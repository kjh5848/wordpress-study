<?php

class oAuthLoginKakao extends oAuthLogin
{

    protected $code;
    protected $state;
    protected $mapping_code;

    public function __construct()
    {
        $this->code = sanitize_text_field($_GET['code']);
        $this->state = sanitize_text_field($_GET['state']);
        $this->mapping_code = sanitize_text_field($_GET['mapping_code']);
    }

    public function isCallBack()
    {
        //메일 매핑 여부 확인
        if (isset($_GET['mapping_code'])) {

            //메일 매핑 유저 로그인 처리
            $user_meta_query_by_mapping_code = new WP_User_Query( array( 'meta_key' => 'tmp_kakao_app_user_hash', 'meta_value' => $this->mapping_code ) );
            $users_by_mapping_code = $user_meta_query_by_mapping_code->get_results();
            if (!empty($users_by_mapping_code) && $this->isValidUser($users_by_mapping_code[0])) {
                $wp_already_user_id = $users_by_mapping_code[0]->id;
                $wp_already_user_kakao_app_user_id = get_user_meta($wp_already_user_id, 'tmp_kakao_app_user_id', true);
                add_user_meta( $wp_already_user_id, 'kakao_app_user_id', $wp_already_user_kakao_app_user_id);
                delete_user_meta( $wp_already_user_id, 'tmp_kakao_app_user_id');
                delete_user_meta( $wp_already_user_id, 'tmp_kakao_app_user_hash');
                return $this->setLogin($wp_already_user_id);
            }
        }

        if (function_exists("is_login")){
            if (is_login() && isset($_GET['code'])) return true;
        }
        else{
            if (isset($_GET['code'])) return true;
        }
        return false;
    }

    public function isValidState()
    {
        if (get_option(Constants::KAKAO_LOGIN_SECURE_STATE_USE) == 'N') return true;
        else if (isset($_GET['state']) && $this->state == session_id()) return true;
        else return false;
    }

    function isValidToken($response)
    {
        if (isset(json_decode($response)->access_token)) return true;
        else return false;
    }

    function isValidProfile($response)
    {
        if (isset(json_decode($response)->id)) return true;
        else return false;
    }

    function isValidUser($response)
    {
        if (isset($response->id)) return true;
        else return false;
    }

    function getAlreadyExistUser($profile)
    {
        $decode_profile_kakao_account = json_decode($profile)->kakao_account;
        $email_user = get_user_by( 'email', $decode_profile_kakao_account->email);
        if (isset($email_user->id)) return $email_user->id;
        else return 0;
    }

    function getKakaoUserEmail($profile)
    {
        $decode_profile_kakao_account = json_decode($profile)->kakao_account;
        return $decode_profile_kakao_account->email;
    }

    /** function
     * 2023.08.27 플러그인과 테마에 따른 로그인 URI 변경 시, 리다이렉트 URI도 변경 되도록 wp_login_url() 함수 사용
     *
     */
    public function callback()
    {
        if (!$this->isValidState()) {
            return Constants::STATE_ERR_MSG;
        }
        $token = $this->getToken();
        if (!$this->isValidToken($token)) {
            return $token;
        }

        $profile = $this->getProfile();
        if (!$this->isValidProfile($profile)) {
            return $profile;
        }
        $this->debug('find kakao user id by oAuth', json_decode($profile)->id);

        $user = get_user_by( 'login', json_decode($profile)->id.'@k');
        $this->debug('find user id by kakao_app_user_id', $user->id);

        if (!$this->isValidUser($user)) { //signup

            // 유저 메타 앱유저ID 로그인
            $user_meta_query_by_kakao_app_user_id = new WP_User_Query( array( 'meta_key' => 'kakao_app_user_id', 'meta_value' => json_decode($profile)->id ) );
            $users_by_kakao_app_user_id = $user_meta_query_by_kakao_app_user_id->get_results();
            if (!empty($users_by_kakao_app_user_id) && $this->isValidUser($users_by_kakao_app_user_id[0])) {
                return $this->setLogin($users_by_kakao_app_user_id[0]->id);
            }

            // 기존회원과 매핑 설정 사용하는 경우만
            if(get_option(Constants::KAKAO_LOGIN_MAPPING_STATE_USE) == "email authentication mapping"){
                // 이메일로 회원정보 조회된다면
                $wp_already_user_id = $this->getAlreadyExistUser($profile);
                if($wp_already_user_id != 0){ // 이메일 체크 추가

                    $wp_already_user_kakao_app_user_id = get_user_meta($wp_already_user_id, 'kakao_app_user_id', true);
                    if(isset($wp_already_user_kakao_app_user_id) && $wp_already_user_kakao_app_user_id !=''){ //매핑된 앱유저ID 있으면,
                        //해당 이메일은 이미 다른 카카오 계정과 매핑 되어 있습니다.
                        return "해당 이메일은 이미 다른 카카오 계정과 매핑 되어 있습니다. ".$wp_already_user_kakao_app_user_id;
                    }
                    else { //매핑된 앱유저ID 없으면,

                        //난수 생성해 유저 메타에 추가하고, 임시 앱유저 ID 유저 메타 추가
                        add_user_meta( $wp_already_user_id, 'tmp_kakao_app_user_hash', $this->code);
                        add_user_meta( $wp_already_user_id, 'tmp_kakao_app_user_id', json_decode($profile)->id);
                        //메일 발송 후, 에러 리턴
                        wp_mail($this->getKakaoUserEmail($profile),
                            curDomain().') 동일한 이메일의 기존 계정과 카카오 로그인 연동 확인',
                            curDomain().'사이트에서 '.$this->getKakaoUserEmail($profile)
                            .' 기존 계정과 동일한 이메일의 카카오 계정을 연동하시려면 기재된 URL 로 이동해주세요. '
                            .add_query_arg('mapping_code', $this->code, esc_url(wp_login_url())),
                            array('Content-Type:text/html; charset=UTF-8')) ;
                        //메일에서 난수 링크 선택 시, isCallBack 함수에서 난수로 유저 찾아 임시 앱유저 ID 유저 메타를 실제 유저 메타로 등록
                        return "동일한 이메일의 기존 계정이 있습니다. 기존 계정과 카카오 로그인 매핑 위해 이메일("
                            .$this->getKakaoUserEmail($profile).") 발송하였습니다. 메일 내용의 링크 진입 시, 기존 계정으로 카카오 로그인 가능합니다.";
                    }
                }
                else { // 기존 이메일 없으면 그냥 가입
                    return $this->setSignUp($profile);
                }
            }
            else{
                return $this->setSignUp($profile);
            }
        } else { //login
            return $this->setLogin($user->id);
        }
    }

    /** function
     * 2023.08.27 플러그인과 테마에 따른 로그인 URI 변경 시, 리다이렉트 URI도 변경 되도록 wp_login_url() 함수 사용
     */
    function getToken()
    {
        $callUrl = Constants::KAUTH_TOKEN_URL
            . "?grant_type=authorization_code&client_id=" . get_option(Constants::JAVASCRIPT_KEY)
            . "&client_secret=" . get_option(Constants::CLIENT_SECRET)
            . "&redirect_uri=" . esc_url(wp_login_url())
            . "&code=" . $this->code;
        return $this->excuteCurl($callUrl, "POST", array(), array(), "accessToken");
    }

    function getProfile()
    {
        $callUrl = Constants::KAPI_PROFILE_URL;
        $headers[] = "Authorization: Bearer " . $_SESSION["accessToken"];
        return $this->excuteCurl($callUrl, "POST", $headers, array(), "profile");;
    }

    /** function
     * 2023.08.27 user_login 에 앱유저ID 대신 이메일 사용, 기존 @k 로직으로 유저 조회 실패 시, 메타에서 조회하는 로직이 있음.
     */
    function setSignUp($profile)
    {
        $decode_profile = json_decode($profile);
        $decode_profile_kakao_account = $decode_profile->kakao_account;
        $decode_profile_kakao_account_profile = $decode_profile_kakao_account->profile;
        $kakao_login_user_role_use = get_option(Constants::KAKAO_LOGIN_USER_ROLE_USE);
        $kakao_user_login_value = "";
        if (isset($decode_profile_kakao_account->email)) {
            $kakao_user_login_value = $decode_profile_kakao_account->email;
        }
        else {
            $kakao_user_login_value = $decode_profile->id . '@k';
        }
        $userdata = array(
            'user_login' => $kakao_user_login_value,
            'user_pass' => uniqid(),
            'user_nicename' => $decode_profile_kakao_account->name,
            'user_url' => $decode_profile_kakao_account_profile->profile_image_url,
            'user_email' => $decode_profile_kakao_account->email,
            'display_name' => $decode_profile_kakao_account_profile->nickname,
            'nickname' => $decode_profile_kakao_account_profile->nickname,
            'first_name' => '',
            'last_name' => $decode_profile_kakao_account->name,
            'description' => '',
            'role' => (($kakao_login_user_role_use == "") ? 'subscriber' : $kakao_login_user_role_use),
            'meta_input' => array(
                'kakao_app_user_id' => $decode_profile->id,
                'name' => $decode_profile_kakao_account->name,
                'phone_number' => $decode_profile_kakao_account->phone_number,
                'age_range' => $decode_profile_kakao_account->age_range,
                'birthyear' => $decode_profile_kakao_account->birthyear,
                'birthday' => $decode_profile_kakao_account->birthday,
                'gender' => $decode_profile_kakao_account->gender,
                'ci' => $decode_profile_kakao_account->ci
            )
        );
        $userId = wp_insert_user($userdata);
        if (is_wp_error($userId)) {
            return $userId->get_error_message();
        }
        $this->debug('signup user id', $userId);
        return $this->setLogin($userId);
    }

    function setLogin($userId)
    {
        wp_set_auth_cookie($userId);
        wp_signon();
        $this->debug('login success', home_url());
        header('Location: ' . $_SESSION["kakaoLoginLanding"]);
    }

    protected function excuteCurl($callUrl, $method, $headers = array(), $data = array(), $session_type = "")
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $callUrl);
        if ($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, true);
        } else {
            curl_setopt($ch, CURLOPT_POST, false);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($session_type == "accessToken") {
            if (isset(json_decode($response)->access_token)) {
                $_SESSION["accessToken"] = json_decode($response)->access_token;
            }
        }
        if ($session_type == "profile") {
            if (isset(json_decode($response)->id)) {
                $_SESSION["loginProfile"] = json_decode($response);
            }
        }

        $this->debug($session_type, $response);
        return $response;
    }

}
