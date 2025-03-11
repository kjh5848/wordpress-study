<?php

class validate
{
    protected $postDataSave;
    protected $postDataItem;
    protected $postDataItemDisplay;
    protected $postDataItemSubSet;

    public function __construct($paramNameType, $paramNameItem, $paramNameItemDisplay, $postDataItemSubSet = null)
    {
        $this->postDataSave = sanitize_text_field($_POST[$paramNameType]);
        $this->postDataItem = sanitize_text_field($_POST[$paramNameItem]);
        if(!empty($paramNameItemDisplay)){
            $this->postDataItemDisplay = sanitize_text_field($_POST[$paramNameItemDisplay]);
        }
        if(!empty($postDataItemSubSet)){
            $this->postDataItemSubSet = sanitize_text_field($_POST[$postDataItemSubSet]);
        }
    }

    function isSaveTrue()
    {
        if (isset($this->postDataSave) && $this->postDataSave == "true") return true;
        else return false;
    }

    function isMobile()
    {
        $mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

        if (preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) {
            return true;
        } else {
            return false;
        }
    }

    function validateItem($arr)
    {
        return $this->validateArray($arr, $this->postDataItem);
    }

    function validateItemDisplay($arr)
    {
        return $this->validateArray($arr, $this->postDataItemDisplay);
    }

    function validateItemSubSet($arr)
    {
        return $this->validateArray($arr, $this->postDataItemSubSet);
    }

    function validateArray($arr, $data)
    {
        if (!isset($data)) return false;
        for ($i = 0; $i < count($arr); $i++) {
            if ($arr[$i] == $data) return true;
        }
        return false;
    }

    function validateAppKey($value)
    {
        $this->debug('validateAppKey $value', $value);
        if (isset($value) && strlen($value) > 31 && strlen($value) < 100) {
            return true;
        } else {
            $this->validateErrorMsg(Constants::JAVASCRIPT_KEY);
            return false;
        }
    }

    function validateChannelId($value)
    {
        $this->debug('validateChannelId $value', $value);
        if (isset($value) && strlen($value) > 4 && strpos($value, "_") !== false) {
            return true;
        } else {
            $this->validateErrorMsg(Constants::KAKAOTALK_CHANNEL_ID);
            return false;
        }
    }

    function validateString($value)
    {
        if (isset($value) && strlen($value) > 0) return true;
        else return false;
    }

    function validateClientSecret($value)
    {
        if (isset($value) && strlen($value) > 31 && strlen($value) < 100) {
            return true;
        }
        else {
            $this->validateErrorMsg(Constants::CLIENT_SECRET);
            return false;
        }
    }

    public function getOptionKakaotalkChannelId()
    {
        return esc_html(get_option(Constants::KAKAOTALK_CHANNEL_ID));
    }

    public function getShareContent($content, $kakaotalk_share, $kakaotalk_me)
    {
        if (!is_admin()) {
            if (!is_page() && !is_search() && !is_home()) {
                $share = '<div style="text-align:'.esc_html(get_option(Constants::KAKAOTALK_SHARE_ICON_SUBSET)).'">' . $kakaotalk_share .
                    (get_option(Constants::KAKAOTALK_ME_ICON_DISPLAY) == "show" ? $kakaotalk_me : '') .
                    '</div>';

                if (get_option(Constants::KAKAOTALK_SHARE_ICON_DISPLAY) == "top") return $share . $content;
                else if (get_option(Constants::KAKAOTALK_SHARE_ICON_DISPLAY) == "bottom") return $content . $share;
            }
        }
        return $content;
    }

    function debug($type, $value)
    {
        if (Constants::DEBUG) {
            echo esc_html($type) . " : " . esc_html($value) . '<br/>';
        }
    }

    function saveCompleteMsg($msg)
    {
        echo '<div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible"> 
                <p><strong>' . $msg . ' 저장됨.</strong></p>
                <button type="button" class="notice-dismiss" onclick="javascript:closeSaveNotice()"><span class="screen-reader-text">이 알림 무시.</span></button>
              </div>';
    }
    function validateErrorMsg($msg)
    {
        echo '<div id="setting-error-settings_updated" class="notice notice-error settings-error is-dismissible"> 
                <p><strong>' . $msg . ' 처리 불가.</strong></p>
                <button type="button" class="notice-dismiss" onclick="javascript:closeSaveNotice()"><span class="screen-reader-text">이 알림 무시.</span></button>
              </div>';
    }
}
