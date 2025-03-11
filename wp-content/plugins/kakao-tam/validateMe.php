<?php
class validateMe extends validate {

    public function __construct($paramNameType = Constants::KAKAOTALK_ME_SAVE,
                                $paramNameItem = Constants::KAKAOTALK_ME_ICON,
                                $paramNameItemDisplay = Constants::KAKAOTALK_ME_ICON_DISPLAY)
    {
        parent::__construct($paramNameType, $paramNameItem, $paramNameItemDisplay);
    }

    public function isPostValidate(){
        if(!parent::isSaveTrue()) return false;
        if(!parent::validateItem(Constants::KAKAOTALK_ME_ICON_ARRAY)) return false;
        if(!parent::validateItemDisplay(Constants::KAKAOTALK_ME_ICON_DISPLAY_ARRAY)) return false;
        return true;
    }
    public function getOptionShareIcon(){
        return esc_html(get_option(Constants::KAKAOTALK_ME_ICON));
    }
    public function getOptionShareIconDisplay(){
        return esc_html(get_option(Constants::KAKAOTALK_ME_ICON_DISPLAY));
    }
    public function updatePostShareOption(){
        if($this->isPostValidate()){
            update_option(Constants::KAKAOTALK_ME_ICON, $this->postDataItem);
            update_option(Constants::KAKAOTALK_ME_ICON_DISPLAY, $this->postDataItemDisplay);
            $this->saveCompleteMsg(Constants::KAKAOTALK_ME_TITLE);
        }
    }

    public function getShortCode($content){
        if (!is_admin()) {
            return $this->kakaotalk_me();
        }
        return $content;
    }

    function kakaotalk_me()
    {
        $url = "'".get_permalink()."'";
        return '
        <div class="share kakaotalk-me">
            <a href="javascript:kakaotalkMeMessage()">
            <img src="' . plugins_url('/icon/' . esc_html(get_option(Constants::KAKAOTALK_ME_ICON)), __FILE__) . '"
            alt="카카오톡 나와의 채팅방에 메모하기 버튼" />
            </a>    
        </div>
    ';
    }
    public function getWpFooter(){
        $url = "'".get_permalink()."'";
        if (!is_admin()) {
            echo '        
            <div id="kakaotalkMeLayerBg" >
                <div id="kakaotalkMeLayer" class="pop-layer">
                    <div class="pop-container">
                        <div class="pop-conts">
                            <p class="ctxt mb20">
                            <textarea id="kakaotalk-me-txt" class="kakaotalk-me-txt"></textarea>
                            </p>
                
                            <div class="btn-r">
                                <a href="javascript:kakaotalkMeSend(' . $url . ')" class="btn-layerSend">Send</a>
                                <a href="javascript:kakaotalkMeLayerClose()" class="btn-layerClose">Close</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }


    function kakaotalk_me_send($url, $text){
        if(!isset($_SESSION["accessToken"]) || $_SESSION["accessToken"] == ""){ return "카카오 로그인 후 사용 가능합니다."; }
        // 토큰이 만료되었다면 { return "카카오 로그인 후 사용 가능합니다."; }
        $response = wp_remote_get(
            esc_url_raw('https://kapi.kakao.com/v1/user/access_token_info'),
            array(
                'headers' => array(
                    'Authorization' => 'Bearer '.$_SESSION["accessToken"]
                )
            )
        );
        if (!is_array($response) && is_wp_error($response)){ return "카카오 로그인 후 사용 가능합니다."; }
        if ($response['response']['code'] != 200){ return "카카오 로그인 후 사용 가능합니다.\n\n".$response['body']; }
        // 메시지 발송 API 호출
        $response = wp_remote_post( esc_url_raw('https://kapi.kakao.com/v2/api/talk/memo/default/send'), array(
            'body'    => array(
                'template_object'      => '{
                                                "object_type": "text",
                                                "text": "'.$text.'",
                                                "link": {
                                                    "web_url": "'.$url.'",
                                                    "mobile_web_url": "'.$url.'"
                                                },
                                                "button_title": "바로 확인"
                                            }'
            ),
            'headers' => array(
                'Authorization' => 'Bearer '.$_SESSION["accessToken"],
                'Content-Type' => 'application/x-www-form-urlencoded'
            ),
        ) );
        if (!is_array($response) && is_wp_error($response)){ return "메시지 발송 에러\n\n".$response['body']; }
        if ($response['response']['code'] != 200){ return "메시지 발송 에러\n\n".$response['body']; }
        return "메시지 발송 성공";
    }
}
