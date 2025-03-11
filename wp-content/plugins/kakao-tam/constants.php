<?php

class Constants
{
    const DEBUG = false;

    const KAUTH_TOKEN_URL = "https://kauth.kakao.com/oauth/token";
    const KAPI_PROFILE_URL = "https://kapi.kakao.com/v2/user/me";
    const REDIRECT_URI_PATH = "/wp-login.php";
    const LOGIN_URI_PATH = "/wp-login.php";

    const DEVELOPERS_TITLE = "카카오 디벨로퍼스 설정";
    const DEVELOPER_SAVE = "developers_save";
    const JAVASCRIPT_KEY = "javascript_key";
    const KAKAOTALK_CHANNEL_ID = "kakaotalk_channel_id";

    const KAKAO_LOGIN_TITLE = "카카오 로그인 설정";
    const KAKAO_LOGIN_SAVE = "kakao_login_save";
    const KAKAO_LOGIN_ICON = "kakao_login_icon";
    const KAKAO_LOGIN_ICON_DISPLAY = "kakao_login_icon_display";
    const KAKAO_LOGIN_ICON_ARRAY = array("kakao_login_medium_wide_kr.png", "kakao_login_medium_wide_en.png");
    const KAKAO_LOGIN_ICON_DISPLAY_ARRAY = array("show", "Do not display");
    const KAKAO_LOGIN_ICON_SUBSET = "kakao_login_icon_subset";
    const KAKAO_LOGIN_ICON_SUBSET_ARRAY = array("left", "center", "right");

    const KAKAO_LOGIN_AFTER_LANDING_TITLE = "카카오 로그인 이후 설정";
    const KAKAO_LOGIN_AFTER_LANDING_SAVE = "kakao_login_after_landing_save";
    const KAKAO_LOGIN_AFTER_LANDING = "kakao_login_after_landing";
    const KAKAO_LOGIN_AFTER_LANDING_DEFAULT = "/";
    const KAKAO_LOGIN_AFTER_LANDING_STATE_USE = "kakao_login_after_landing_state_use";
    const KAKAO_LOGIN_AFTER_LANDING_STATE_USE_ARRAY = array("landing path", "before url");
    const KAKAO_LOGIN_AFTER_DISPLAY_STATE_USE = "kakao_login_after_display_state_use";
    const KAKAO_LOGIN_AFTER_DISPLAY_STATE_USE_ARRAY = array("show", "hide");

    const KAKAO_LOGIN_MAPPING_TITLE = "카카오 로그인 회원 가입 설정";
    const KAKAO_LOGIN_MAPPING_SAVE = "kakao_login_mapping_save";
    const KAKAO_LOGIN_MAPPING_STATE_USE = "kakao_login_mapping_state_use";
    const KAKAO_LOGIN_MAPPING_STATE_USE_ARRAY = array("no mapping", "email authentication mapping");
    const KAKAO_LOGIN_USER_ROLE_USE = "kakao_login_user_role_use";
    const KAKAO_LOGIN_USER_ROLE_USE_ARRAY = array("subscriber", "contributor", "author");
    const KAKAO_LOGIN_USER_PROFILE_IMG_USE = "kakao_login_user_profile_img_use";
    const KAKAO_LOGIN_USER_PROFILE_IMG_USE_ARRAY = array("Y", "N");

    const KAKAO_LOGIN_SECURE_TITLE = "카카오 로그인 보안 설정";
    const KAKAO_LOGIN_SECURE_SAVE = "kakao_login_secure_save";
    const CLIENT_SECRET = "client_secret";
    const KAKAO_LOGIN_SECURE_STATE_USE = "kakao_login_secure_state_use";
    const KAKAO_LOGIN_SECURE_STATE_USE_ARRAY = array("Y", "N");
    const STATE_ERR_MSG = "[State 불일치] 잘못된 접근입니다.";

    const KAKAOTALK_SHARE_TITLE = "카카오톡 공유하기 설정";
    const KAKAOTALK_SHARE_SAVE = "kakaotalk_share_save";
    const KAKAOTALK_SHARE_ICON = "kakaotalk_share_icon";
    const KAKAOTALK_SHARE_ICON_DISPLAY = "kakaotalk_share_icon_display";
    const KAKAOTALK_SHARE_ICON_SUBSET = "kakaotalk_share_icon_subset";
    const KAKAOTALK_SHARE_ICON_ARRAY = array("kakaotalk_sharing_btn_medium.png", "kakaotalk_sharing_btn_small.png");
    const KAKAOTALK_SHARE_ICON_DISPLAY_ARRAY = array("top", "bottom", "Do not display");
    const KAKAOTALK_SHARE_ICON_SUBSET_ARRAY = array("left", "center", "right");

    const KAKAOTALK_ME_TITLE = "카카오톡 나와의 채팅방에 메모하기 설정";
    const KAKAOTALK_ME_SAVE = "kakaotalk_me_save";
    const KAKAOTALK_ME_ICON = "kakaotalk_me_icon";
    const KAKAOTALK_ME_ICON_DISPLAY = "kakaotalk_me_icon_display";
    const KAKAOTALK_ME_ICON_ARRAY = array("kakaotalk_me_btn_medium.png", "kakaotalk_me_btn_small.png");
    const KAKAOTALK_ME_ICON_DISPLAY_ARRAY = array("show", "Do not display");

    const KAKAOTALK_CHANNEL_ADD_TITLE = "카카오톡 채널 추가 설정";
    const KAKAOTALK_CHANNEL_ADD_SAVE = "kakaotalk_channel_add_save";
    const KAKAOTALK_CHANNEL_ADD_ICON = "kakaotalk_channel_add_icon";
    const KAKAOTALK_CHANNEL_ADD_ICON_DISPLAY = "kakaotalk_channel_add_icon_display";
    const KAKAOTALK_CHANNEL_ADD_ICON_ARRAY = array("channel_add_small.png", "channel_add_large.png");
    const KAKAOTALK_CHANNEL_ADD_ICON_DISPLAY_ARRAY = array("Bottom right floating", "Do not display");

    const KAKAOTALK_CHANNEL_CHAT_TITLE = "카카오톡 채널 채팅 설정";
    const KAKAOTALK_CHANNEL_CHAT_SAVE = "kakaotalk_channel_chat_save";
    const KAKAOTALK_CHANNEL_CHAT_ICON = "kakaotalk_channel_chat_icon";
    const KAKAOTALK_CHANNEL_CHAT_ICON_DISPLAY = "kakaotalk_channel_chat_icon_display";
    const KAKAOTALK_CHANNEL_CHAT_ICON_ARRAY = array("consult_small_yellow_pc.png", "consult_small_yellow_mobile.png");
    const KAKAOTALK_CHANNEL_CHAT_ICON_DISPLAY_ARRAY = array("Bottom right floating", "Do not display");

    const KAKAONAVI_TITLE = "카카오 내비 길 안내하기 설정";
    const KAKAONAVI_SAVE = "kakaonavi_save";
    const KAKAONAVI_ICON = "kakaonavi_icon";
    const KAKAONAVI_ICON_ARRAY = array("kakaonavi_btn_medium.png", "kakaonavi_btn_small.png");
    const KAKAONAVI_POSITION = "kakaonavi_position";
    const KAKAONAVI_DEFAULT_POSITION = "{name: '현대백화점 판교점',x: 127.11205203011632,y: 37.39279717586919,coordType: 'wgs84'}";

    const KAKAOMAP_TITLE = "카카오 맵 설정";
    const KAKAOMAP_SAVE = "kakaomap_save";
    const KAKAOMAP_STYLE = "kakaomap_style";
    const KAKAOMAP_DEFAULT_STYLE = "width:500px;height:400px;";
    const KAKAOMAP_POSITION = "kakaomap_position";
    const KAKAOMAP_DEFAULT_POSITION = "33.450701, 126.570667";


}
