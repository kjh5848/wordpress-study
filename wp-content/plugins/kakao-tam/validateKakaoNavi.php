<?php
class validateKakaoNavi extends validate {

    public function __construct($paramNameType = Constants::KAKAONAVI_SAVE,
                                $paramNameItem = Constants::KAKAONAVI_ICON,
                                $paramNameItemDisplay = Constants::KAKAONAVI_POSITION)
    {
        parent::__construct($paramNameType, $paramNameItem, $paramNameItemDisplay);
    }

    public function isPostValidate(){
        if(!parent::isSaveTrue()) return false;
        if(!parent::validateItem(Constants::KAKAONAVI_ICON_ARRAY)) return false;
        if(!parent::validateString(Constants::KAKAONAVI_POSITION)) return false;
        return true;
    }
    public function getOptionKakaoNaviIcon(){
        return esc_html(get_option(Constants::KAKAONAVI_ICON));
    }
    public function getOptionKakaoNaviPosition(){
        return str_replace(array("\'"), "'" ,html_entity_decode(get_option(Constants::KAKAONAVI_POSITION), ENT_QUOTES));
    }
    public function updatePostKakaoNaviOption(){
        if($this->isPostValidate()){
            update_option(Constants::KAKAONAVI_ICON, $this->postDataItem);
            update_option(Constants::KAKAONAVI_POSITION, $this->postDataItemDisplay);
            $this->saveCompleteMsg(Constants::KAKAONAVI_TITLE);
        }
    }
    public function getShortCode($content){
        if (!is_admin()) {
            return $this->kakaonavi();
        }
        return $content;
    }
    public function getShareShortCode($content){
        if (!is_admin()) {
            return $this->kakaonavi_share();
        }
        return $content;
    }

    function kakaonavi()
    {
        if(!$this->isMobile()) {
            return '';
        }
        $position = $this->getOptionKakaoNaviPosition();
        return '
        <div class="kakanavi">        
            <a href="javascript:startNavigation('.$position.')">
            <img src="' . plugins_url('/icon/' . esc_html(get_option(Constants::KAKAONAVI_ICON)), __FILE__) . '"
            alt="카카오 내비" />
            </a>    
        </div>            
    ';
    }

    function kakaonavi_share()
    {
        if(!$this->isMobile()) {
            return '';
        }
        $position = $this->getOptionKakaoNaviPosition();
        return '
        <div class="kakanavi">        
            <a href="javascript:shareLocation('.$position.')">
            <img src="' . plugins_url('/icon/' . esc_html(get_option(Constants::KAKAONAVI_ICON)), __FILE__) . '"
            alt="카카오 내비" />
            </a>    
        </div>            
    ';
    }
}

