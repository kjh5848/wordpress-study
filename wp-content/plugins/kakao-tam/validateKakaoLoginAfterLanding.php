<?php
class validateKakaoLoginAfterLanding extends validate {

    public function __construct($paramNameType = Constants::KAKAO_LOGIN_AFTER_LANDING_SAVE,
                                $paramNameItem = Constants::KAKAO_LOGIN_AFTER_LANDING,
                                $paramNameItemDisplay = Constants::KAKAO_LOGIN_AFTER_LANDING_STATE_USE,
                                $paramNameItemSubSet = Constants::KAKAO_LOGIN_AFTER_DISPLAY_STATE_USE)
    {
        parent::__construct($paramNameType, $paramNameItem, $paramNameItemDisplay, $paramNameItemSubSet);
    }

    public function isPostValidate(){
        if(!parent::isSaveTrue()) return false;
        return true;
    }
    public function getOptionLoginAfterLanding(){
        return esc_html(get_option(Constants::KAKAO_LOGIN_AFTER_LANDING));
    }
    public function getOptionKakaoLoginAfterLandingStateUse(){
        return esc_html(get_option(Constants::KAKAO_LOGIN_AFTER_LANDING_STATE_USE));
    }
    public function getOptionKakaoLoginAfterDisplayStateUse(){
        return esc_html(get_option(Constants::KAKAO_LOGIN_AFTER_DISPLAY_STATE_USE));
    }
    public function updatePostKakaoLoginAfterLandingOption(){

        if($this->isPostValidate()){
            update_option(Constants::KAKAO_LOGIN_AFTER_LANDING, $this->postDataItem);
            update_option(Constants::KAKAO_LOGIN_AFTER_LANDING_STATE_USE, $this->postDataItemDisplay);
            update_option(Constants::KAKAO_LOGIN_AFTER_DISPLAY_STATE_USE, $this->postDataItemSubSet);
            $this->saveCompleteMsg(Constants::KAKAO_LOGIN_AFTER_LANDING_TITLE);
        }
    }

}
