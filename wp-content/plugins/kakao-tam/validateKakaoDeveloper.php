<?php
class validateKakaoDeveloper extends validate {

    public function __construct($paramNameType = Constants::DEVELOPER_SAVE,
                                $paramNameItem = Constants::JAVASCRIPT_KEY,
                                $paramNameItemDisplay = Constants::KAKAOTALK_CHANNEL_ID)
    {
        parent::__construct($paramNameType, $paramNameItem, $paramNameItemDisplay);
    }

    public function isPostValidate(){
        if(!parent::isSaveTrue()) return false;
        $this->debug('isSaveTrue()', parent::isSaveTrue());
        $this->debug('$this->postDataItem', $this->postDataItem);
        $this->debug('$this->postDataItemDisplay', $this->postDataItemDisplay);
        if(!parent::validateAppKey($this->postDataItem)) return false;
        if(!parent::validateChannelId($this->postDataItemDisplay)) return false;
        $this->debug('isPostValidate()', 'true');
        return true;
    }
    public function getOptionJavaScriptKey(){
        return esc_html(get_option(Constants::JAVASCRIPT_KEY));
    }
    public function hasOptionJavaScriptKey(){
        return strlen(get_option(Constants::JAVASCRIPT_KEY)) > 31;
    }

    public function updatePostShareOption(){
        if($this->isPostValidate()){
            update_option(Constants::JAVASCRIPT_KEY, $this->postDataItem);
            update_option(Constants::KAKAOTALK_CHANNEL_ID, $this->postDataItemDisplay);
            $this->saveCompleteMsg(Constants::DEVELOPERS_TITLE);
        }
    }
}
