<?php

function curDomain() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"];
    }
    return $pageURL;
}

function curPageURL() {
    return curDomain().$_SERVER["REQUEST_URI"];
}

function curPagePath() {
    return $_SERVER["REQUEST_URI"];
}

function getReferer() {
    return $_SERVER['HTTP_REFERER'];
}

function isPagePath($pagePath){
    $pos = strpos(curPagePath(), $pagePath);
    if ($pos === false) {
        return false;
    } else {
        return true;
    }
}

function isLogin(){
    if (function_exists("is_login")){
        return is_login();
    }
    else{
        return false !== stripos( wp_login_url(), $_SERVER['SCRIPT_NAME'] );
    }
}

function isAjax(){
    if (function_exists("is_ajax")){
        return is_ajax();
    }
    else{
        return false !== stripos( $_SERVER['REQUEST_URI'], 'wp-admin/admin-ajax.php' );
    }
}

function isValidSessionID($state){
    return session_id() == $state;
}

function isKakaotalkMe($type){
    return $type == "kakaotalkMe";
}

function isMobile(){
    $mobile_agent = "/(iphone|ipod|ipad|android|blackberry|windows ce|nokia|webos|opera mini|sonyericsson|opera mobi|iemobile|mobile)/i";
    if (preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    } else {
        return false;
    }
}

function isMobileApp(){
    $mobile_agent = "/(iphone|ipod|ipad|android|blackberry|windows ce|nokia|webos|opera mini|sonyericsson|opera mobi|iemobile|mobile)/i";
    if (preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    } else {
        return false;
    }
}

function isMobileAppIOS(){
    $mobile_agent = "/(iphone|ipod|ipad)/i";
    if (preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    } else {
        return false;
    }
}

function isMobileAppAndroid(){
    $mobile_agent = "/(android)/i";
    if (preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    } else {
        return false;
    }
}

function isMobileAppKakaoTalk(){
    $mobile_agent = "/(kakaotalk)/i";
    if (preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    } else {
        return false;
    }
}

function isMobileAppKakaoStory(){
    $mobile_agent = "/(kakaostory)/i";
    if (preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    } else {
        return false;
    }
}

function isMobileAppFacebook(){
    $mobile_agent = "/(fb)/i";
    if (preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    } else {
        return false;
    }
}

function isMobileAppLine(){
    $mobile_agent = "/(line)/i";
    if (preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    } else {
        return false;
    }
}

function isMobileAppWhatsApp(){
    $mobile_agent = "/(whatsapp)/i";
    if (preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    } else {
        return false;
    }
}

function isMobileAppWeChat(){
    $mobile_agent = "/(wechat)/i";
    if (preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    } else {
        return false;
    }
}


