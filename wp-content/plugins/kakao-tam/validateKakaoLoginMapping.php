<?php
class validateKakaoLoginMapping extends validate {

    public function __construct($paramNameType = Constants::KAKAO_LOGIN_MAPPING_SAVE,
                                $paramNameItem = Constants::KAKAO_LOGIN_MAPPING_STATE_USE,
                                $paramNameItemDisplay = Constants::KAKAO_LOGIN_USER_ROLE_USE,
                                $paramNameItemSubSet = Constants::KAKAO_LOGIN_USER_PROFILE_IMG_USE)
    {
        parent::__construct($paramNameType, $paramNameItem, $paramNameItemDisplay, $paramNameItemSubSet);
    }

    public function isPostValidate(){
        if(!parent::isSaveTrue()) return false;
        return true;
    }
    public function getOptionKakaoLoginMappingStateUse(){
        return esc_html(get_option(Constants::KAKAO_LOGIN_MAPPING_STATE_USE));
    }

    public function getOptionKakaoLoginUserRoleUse(){
        return esc_html(get_option(Constants::KAKAO_LOGIN_USER_ROLE_USE));
    }

    public function getOptionKakaoLoginUserProfileImgUse(){
        return esc_html(get_option(Constants::KAKAO_LOGIN_USER_PROFILE_IMG_USE));
    }

    public function updatePostKakaoLoginMappingOption(){
        if($this->isPostValidate()){
            update_option(Constants::KAKAO_LOGIN_MAPPING_STATE_USE, $this->postDataItem);
            update_option(Constants::KAKAO_LOGIN_USER_ROLE_USE, $this->postDataItemDisplay);
            update_option(Constants::KAKAO_LOGIN_USER_PROFILE_IMG_USE, $this->postDataItemSubSet);
            $this->saveCompleteMsg(Constants::KAKAO_LOGIN_MAPPING_TITLE);
        }
    }
}
