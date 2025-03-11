<?php
class validateKakaoLoginSecure extends validate {

    public function __construct($paramNameType = Constants::KAKAO_LOGIN_SECURE_SAVE,
                                $paramNameItem = Constants::CLIENT_SECRET,
                                $paramNameItemDisplay = Constants::KAKAO_LOGIN_SECURE_STATE_USE)
    {
        parent::__construct($paramNameType, $paramNameItem, $paramNameItemDisplay);
    }

    public function isPostValidate(){
        if(!parent::isSaveTrue()) return false;
        $this->debug('isSaveTrue()', parent::isSaveTrue());
        if(!parent::validateClientSecret($this->postDataItem)) return false;
        return true;
    }
    public function getOptionClientSecret(){
        return esc_html(get_option(Constants::CLIENT_SECRET));
    }
    public function getOptionKakaoLoginSecureStateUse(){
        return esc_html(get_option(Constants::KAKAO_LOGIN_SECURE_STATE_USE));
    }
    public function updatePostKakaoLoginSecureOption(){
        if($this->isPostValidate()){
            update_option(Constants::CLIENT_SECRET, $this->postDataItem);
            update_option(Constants::KAKAO_LOGIN_SECURE_STATE_USE, $this->postDataItemDisplay);
            $this->saveCompleteMsg(Constants::KAKAO_LOGIN_SECURE_TITLE);
        }
    }
}
