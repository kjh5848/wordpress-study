<?php
class validateShare extends validate {

    public function __construct($paramNameType = Constants::KAKAOTALK_SHARE_SAVE,
                                $paramNameItem = Constants::KAKAOTALK_SHARE_ICON,
                                $paramNameItemDisplay = Constants::KAKAOTALK_SHARE_ICON_DISPLAY,
                                $paramNameItemSubSet = Constants::KAKAOTALK_SHARE_ICON_SUBSET)
    {
        parent::__construct($paramNameType, $paramNameItem, $paramNameItemDisplay, $paramNameItemSubSet);
    }

    public function isPostValidate(){
        if(!parent::isSaveTrue()) return false;
        if(!parent::validateItem(Constants::KAKAOTALK_SHARE_ICON_ARRAY)) return false;
        if(!parent::validateItemDisplay(Constants::KAKAOTALK_SHARE_ICON_DISPLAY_ARRAY)) return false;
        if(!parent::validateItemSubSet(Constants::KAKAOTALK_SHARE_ICON_SUBSET_ARRAY)) return false;
        return true;
    }
    public function getOptionShareIcon(){
        return esc_html(get_option(Constants::KAKAOTALK_SHARE_ICON));
    }
    public function getOptionShareIconDisplay(){
        return esc_html(get_option(Constants::KAKAOTALK_SHARE_ICON_DISPLAY));
    }
    public function getOptionShareIconSubSet(){
        return esc_html(get_option(Constants::KAKAOTALK_SHARE_ICON_SUBSET));
    }
    public function updatePostShareOption(){
        if($this->isPostValidate()){
            update_option(Constants::KAKAOTALK_SHARE_ICON, $this->postDataItem);
            update_option(Constants::KAKAOTALK_SHARE_ICON_DISPLAY, $this->postDataItemDisplay);
            update_option(Constants::KAKAOTALK_SHARE_ICON_SUBSET, $this->postDataItemSubSet);
            $this->saveCompleteMsg(Constants::KAKAOTALK_SHARE_TITLE);
        }
    }
    public function getShortCode($content){
        if (!is_admin()) {
            return $this->kakaotalk_share();
        }
        return $content;
    }

    function kakaotalk_share()
    {
        $url = "'".get_permalink()."'";
        return '
        <div class="share">        
            <a href="javascript:shareMessage(' . $url . ')">
            <img src="' . plugins_url('/icon/' . esc_html(get_option(Constants::KAKAOTALK_SHARE_ICON)), __FILE__) . '"
            alt="카카오톡 공유 버튼" />
            </a>    
        </div>            
    ';
    }
}
