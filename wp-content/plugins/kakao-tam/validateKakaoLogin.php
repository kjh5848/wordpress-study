<?php
class validateKakaoLogin extends validate {

    public function __construct($paramNameType = Constants::KAKAO_LOGIN_SAVE,
                                $paramNameItem = Constants::KAKAO_LOGIN_ICON,
                                $paramNameItemDisplay = Constants::KAKAO_LOGIN_ICON_DISPLAY,
                                $paramNameItemSubSet = Constants::KAKAO_LOGIN_ICON_SUBSET)
    {
        parent::__construct($paramNameType, $paramNameItem, $paramNameItemDisplay, $paramNameItemSubSet);
    }

    public function isPostValidate(){
        if(!parent::isSaveTrue()) return false;
        if(!parent::validateItem(Constants::KAKAO_LOGIN_ICON_ARRAY)) return false;
        if(!parent::validateItemDisplay(Constants::KAKAO_LOGIN_ICON_DISPLAY_ARRAY)) return false;
        return true;
    }
    public function getOptionKakaoLoginIcon(){
        return esc_html(get_option(Constants::KAKAO_LOGIN_ICON));
    }
    public function getOptionKakaoLoginIconDisplay(){
        return esc_html(get_option(Constants::KAKAO_LOGIN_ICON_DISPLAY));
    }
    public function getOptionKakaoLoginIconSubset(){
        return esc_html(get_option(Constants::KAKAO_LOGIN_ICON_SUBSET));
    }

    public function updatePostKakaoLoginOption(){
        if($this->isPostValidate()){
            update_option(Constants::KAKAO_LOGIN_ICON, $this->postDataItem);
            update_option(Constants::KAKAO_LOGIN_ICON_DISPLAY, $this->postDataItemDisplay);
            update_option(Constants::KAKAO_LOGIN_ICON_SUBSET, $this->postDataItemSubSet);
            $this->saveCompleteMsg(Constants::KAKAO_LOGIN_TITLE);
        }
    }
    public function getShortCode($content){
        if (!is_admin()) {
            return $this->kakao_login();
        }
        return $content;
    }
    public function getKakaoLoginContent(){
        return (get_option(Constants::KAKAO_LOGIN_ICON_DISPLAY) == "show" ? $this->kakao_login() : '');
    }
    public function getLanding(){
        $landingState = get_option(Constants::KAKAO_LOGIN_AFTER_LANDING_STATE_USE);
        $landingPath = get_option(Constants::KAKAO_LOGIN_AFTER_LANDING);

        if($landingState == "before url"){
            if (isPagePath(Constants::LOGIN_URI_PATH)) {
                $landing = getReferer();
                if($landing == ""){
                    $landing = home_url();
                }
            }
            else{
                $landing = curPageURL();
            }
        }
        else{
            $landing = home_url($landingPath);
        }
        return $landing;
    }

    function kakao_login()
    {
        $_SESSION["kakaoLoginLanding"] = $this->getLanding();
        if(is_user_logged_in() && get_option(Constants::KAKAO_LOGIN_AFTER_DISPLAY_STATE_USE) == "hide"){
            return '';
        }
        else{
            return '
                <div class="kakaoLogin" style="text-align:'.esc_html(get_option(Constants::KAKAO_LOGIN_ICON_SUBSET)).'">        
                    <a href="javascript:loginWithKakao()">
                    <img src="' . plugins_url('/icon/' . esc_html(get_option(Constants::KAKAO_LOGIN_ICON)), __FILE__) . '"
                    alt="카카오 로그인" />
                    </a>    
                </div>            
            ';
        }
    }
}
