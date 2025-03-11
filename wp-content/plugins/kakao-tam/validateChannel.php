<?php
class validateChannel extends validate {

    public function __construct($paramNameType = Constants::KAKAOTALK_CHANNEL_ADD_SAVE,
                                $paramNameItem = Constants::KAKAOTALK_CHANNEL_ADD_ICON,
                                $paramNameItemDisplay = Constants::KAKAOTALK_CHANNEL_ADD_ICON_DISPLAY)
    {
        parent::__construct($paramNameType, $paramNameItem, $paramNameItemDisplay);
    }

    public function isPostValidateChannelAdd(){
        if(!parent::isSaveTrue()) return false;
        if(!parent::validateItem(Constants::KAKAOTALK_CHANNEL_ADD_ICON_ARRAY)) return false;
        if(!parent::validateItemDisplay(Constants::KAKAOTALK_CHANNEL_ADD_ICON_DISPLAY_ARRAY)) return false;
        return true;
    }
    public function isPostValidateChannelChat(){
        if(!parent::isSaveTrue()) return false;
        if(!parent::validateItem(Constants::KAKAOTALK_CHANNEL_CHAT_ICON_ARRAY)) return false;
        if(!parent::validateItemDisplay(Constants::KAKAOTALK_CHANNEL_CHAT_ICON_DISPLAY_ARRAY)) return false;
        return true;
    }
    public function getOptionChannelAddIcon(){
        return esc_html(get_option(Constants::KAKAOTALK_CHANNEL_ADD_ICON));
    }
    public function getOptionChannelAddIconDisplay(){
        return esc_html(get_option(Constants::KAKAOTALK_CHANNEL_ADD_ICON_DISPLAY));
    }
    public function getOptionChannelChatIcon(){
        return esc_html(get_option(Constants::KAKAOTALK_CHANNEL_CHAT_ICON));
    }
    public function getOptionChannelChatIconDisplay(){
        return esc_html(get_option(Constants::KAKAOTALK_CHANNEL_CHAT_ICON_DISPLAY));
    }
    public function updatePostChannelAddOption(){
        if($this->isPostValidateChannelAdd()){
            update_option(Constants::KAKAOTALK_CHANNEL_ADD_ICON, $this->postDataItem);
            update_option(Constants::KAKAOTALK_CHANNEL_ADD_ICON_DISPLAY, $this->postDataItemDisplay);
            $this->saveCompleteMsg(Constants::KAKAOTALK_CHANNEL_ADD_TITLE);
        }
    }
    public function updatePostChannelChatOption(){
        if($this->isPostValidateChannelChat()){
            update_option(Constants::KAKAOTALK_CHANNEL_CHAT_ICON, $this->postDataItem);
            update_option(Constants::KAKAOTALK_CHANNEL_CHAT_ICON_DISPLAY, $this->postDataItemDisplay);
            $this->saveCompleteMsg(Constants::KAKAOTALK_CHANNEL_CHAT_TITLE);
        }
    }
    public function getWpFooter(){
        if (!is_admin()) {
                echo '  
            <div class="parent">
                <div class="child">
                    '.((get_option(Constants::KAKAOTALK_CHANNEL_CHAT_ICON_DISPLAY) == "Bottom right floating") ? $this->kakaotalk_channel_chat() : '').'<br/>
                    '.((get_option(Constants::KAKAOTALK_CHANNEL_ADD_ICON_DISPLAY) == "Bottom right floating") ? $this->kakaotalk_channel_add() : '').'
                </div>
            </div>    ';
        }
    }
    public function getShortCodeAdd($content){
        if (!is_admin()) {
            return $this->kakaotalk_channel_add();
        }
        return $content;
    }
    public function getShortCodeChat($content){
        if (!is_admin()) {
            return $this->kakaotalk_channel_chat();
        }
        return $content;
    }
    function kakaotalk_channel_add(){
        return '  
            <a href="http://pf.kakao.com/'.$this->getOptionKakaotalkChannelId().'/friend" target="_blank" rel="noreferrer">
                <img src="' . plugins_url('/icon/' . esc_html(get_option(Constants::KAKAOTALK_CHANNEL_ADD_ICON)), __FILE__) . '" 
                alt="카카오톡 채널 친구추가"/>
            </a>
    ';
    }
    function kakaotalk_channel_chat(){
        return '  
            <a href="http://pf.kakao.com/'.$this->getOptionKakaotalkChannelId().'/chat" target="_blank" rel="noreferrer">
                <img src="' . plugins_url('/icon/' . esc_html(get_option(Constants::KAKAOTALK_CHANNEL_CHAT_ICON)), __FILE__) . '" 
                alt="카카오톡 채널 상담하기"/>
            </a>
    ';
    }
}
