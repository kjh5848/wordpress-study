<?php
/*
Plugin Name: kakao-tam
Plugin URI: https://github.com/kakao-tam/wordpress-plugin
Description: 카카오 디벨로퍼스에서 제공하는 카카오 로그인, 카카오톡 공유하기, 카카오톡 채널 친구추가/채팅, 카카오 내비, 카카오 맵 기능을 연동한 플러그인
Version: 1.8.8
Requires at least: 6.5
Requires PHP: 7.0
Author: Kakao TAM
Author URI: https://kakao-tam.tistory.com/140
License: GPL2
*/

/*  Copyright 2022  Kakao TAM  (email : tim.l@kakaocorp.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
include 'constants.php';
include 'tamUtil.php';
include 'validate.php';
include 'validateKakaoDeveloper.php';
include 'validateKakaoLogin.php';
include 'validateKakaoLoginAfterLanding.php';
include 'validateKakaoLoginMapping.php';
include 'validateKakaoLoginSecure.php';
include 'validateShare.php';
include 'validateMe.php';
include 'validateChannel.php';
include 'validateKakaoNavi.php';
include 'validateKakaoMap.php';
include 'oAuthLogin.php';
include 'oAuthLoginKakao.php';

/** Activate */
register_activation_hook(__FILE__, 'kakao_tam_activation_hook');
function kakao_tam_activation_hook()
{
    // option init
    update_option(Constants::KAKAO_LOGIN_ICON, Constants::KAKAO_LOGIN_ICON_ARRAY[0]);
    update_option(Constants::KAKAO_LOGIN_ICON_DISPLAY, Constants::KAKAO_LOGIN_ICON_DISPLAY_ARRAY[0]);

    update_option(Constants::KAKAO_LOGIN_AFTER_LANDING, Constants::KAKAO_LOGIN_AFTER_LANDING_DEFAULT);
    update_option(Constants::KAKAO_LOGIN_AFTER_LANDING_STATE_USE, Constants::KAKAO_LOGIN_AFTER_LANDING_STATE_USE_ARRAY[0]);
    update_option(Constants::KAKAO_LOGIN_AFTER_DISPLAY_STATE_USE, Constants::KAKAO_LOGIN_AFTER_DISPLAY_STATE_USE_ARRAY[0]);

    update_option(Constants::KAKAO_LOGIN_MAPPING_STATE_USE, Constants::KAKAO_LOGIN_MAPPING_STATE_USE_ARRAY[0]);
    update_option(Constants::KAKAO_LOGIN_USER_ROLE_USE, Constants::KAKAO_LOGIN_USER_ROLE_USE_ARRAY[0]);
    update_option(Constants::KAKAO_LOGIN_USER_PROFILE_IMG_USE, Constants::KAKAO_LOGIN_USER_PROFILE_IMG_USE_ARRAY[0]);

    update_option(Constants::KAKAO_LOGIN_SECURE_STATE_USE, Constants::KAKAO_LOGIN_SECURE_STATE_USE_ARRAY[0]);

    update_option(Constants::KAKAOTALK_SHARE_ICON, Constants::KAKAOTALK_SHARE_ICON_ARRAY[0]);
    update_option(Constants::KAKAOTALK_SHARE_ICON_DISPLAY, Constants::KAKAOTALK_SHARE_ICON_DISPLAY_ARRAY[1]);
    update_option(Constants::KAKAOTALK_SHARE_ICON_SUBSET, Constants::KAKAOTALK_SHARE_ICON_SUBSET_ARRAY[0]);

    update_option(Constants::KAKAOTALK_ME_ICON, Constants::KAKAOTALK_ME_ICON_ARRAY[0]);
    update_option(Constants::KAKAOTALK_ME_ICON_DISPLAY, Constants::KAKAOTALK_ME_ICON_DISPLAY_ARRAY[0]);

    update_option(Constants::KAKAOTALK_CHANNEL_ADD_ICON, Constants::KAKAOTALK_CHANNEL_ADD_ICON_ARRAY[1]);
    update_option(Constants::KAKAOTALK_CHANNEL_ADD_ICON_DISPLAY, Constants::KAKAOTALK_CHANNEL_ADD_ICON_DISPLAY_ARRAY[0]);

    update_option(Constants::KAKAOTALK_CHANNEL_CHAT_ICON, Constants::KAKAOTALK_CHANNEL_CHAT_ICON_ARRAY[0]);
    update_option(Constants::KAKAOTALK_CHANNEL_CHAT_ICON_DISPLAY, Constants::KAKAOTALK_CHANNEL_CHAT_ICON_DISPLAY_ARRAY[0]);

    update_option(Constants::KAKAONAVI_ICON, Constants::KAKAONAVI_ICON_ARRAY[0]);
    update_option(Constants::KAKAONAVI_POSITION, Constants::KAKAONAVI_DEFAULT_POSITION);

    update_option(Constants::KAKAOMAP_STYLE, Constants::KAKAOMAP_DEFAULT_STYLE);
    update_option(Constants::KAKAOMAP_POSITION, Constants::KAKAOMAP_DEFAULT_POSITION);
}
/** DeActivate */
register_deactivation_hook(__FILE__, 'kakao_tam_deactivation_hook');
function kakao_tam_deactivation_hook($networkwide)
{
}
/** UnInstall */
register_uninstall_hook(__FILE__, 'kakao_tam_uninstall_hook');
function kakao_tam_uninstall_hook()
{
}
/** add */
add_action('init', 'set_kakao_js_sdk_v2');
add_action('wp_ajax_kakao_api', 'kakao_api_func');
add_action('wp_ajax_nopriv_kakao_api', 'kakao_api_func');
add_action('wp_head', 'set_kakao_js_sdk_init_key' );
add_action('admin_menu', 'kakao_tam_plugin_admin_menu');
add_action('wp_footer', 'kakaotalk_channel_add_action_content');
add_action('wp_footer', 'kakaotalk_me_action_content');

add_filter('the_content', 'kakaotalk_share_filter_content');
add_filter('the_excerpt', 'kakaotalk_share_filter_excerpt');
add_filter('plugin_action_links', 'kakaotalk_share_filter_plugin_action_links', 10, 2);
add_filter('login_message', 'kakao_login_wp_login');

add_shortcode('kakao_login_shortcode', 'kakao_login_shortcode');
add_shortcode('kakaotalk_share_shortcode', 'kakaotalk_share_shortcode');
add_shortcode('kakaotalk_me_shortcode', 'kakaotalk_me_shortcode');
add_shortcode('kakaotalk_channel_add_shortcode', 'kakaotalk_channel_add_shortcode');
add_shortcode('kakaotalk_channel_chat_shortcode', 'kakaotalk_channel_chat_shortcode');
add_shortcode('kakaonavi_shortcode', 'kakaonavi_shortcode');
add_shortcode('kakaonavi_share_shortcode', 'kakaonavi_share_shortcode');
add_shortcode('kakaomap_shortcode', 'kakaomap_shortcode');


/** function
2023.02.26 Dom 객체를 다루는 편집기 플러그인에서 html 밖에 객체 추가 시, 에러 발생하여  include 'script_init.php'; 에는 서버사이드 스크립트만 추가
 */
function set_kakao_js_sdk_v2()
{
    if (is_admin()) {
        return;
    }

    wp_enqueue_script('kakao_tam_script_function', plugins_url('script_function.js', __FILE__), null, '1.0.0', true);
    wp_localize_script('kakao_tam_script_function', 'ajax_object', array('ajax_url' => admin_url( 'admin-ajax.php' ), 'state' => session_id() ) );
    wp_enqueue_style('kakao-tam-style', plugins_url('style.css', __FILE__), null, null);
    include 'script_init.php';
    $oAuthLoginKakao = new oAuthLoginKakao();
    if ($oAuthLoginKakao->isCallBack()) {
        echo '<div id="login_error">	<strong>ERROR</strong>: '.$oAuthLoginKakao->callback().'</div>';
    }
}
function kakao_api_func() {
    session_start();
    if(isAjax() && isset($_POST['action']) == 'kakao_api'){
        if(isKakaotalkMe($_POST['type'])){
            $validateMe = new validateMe();
            echo $validateMe->kakaotalk_me_send($_POST['url'], $_POST['text']);
        }
    }

    wp_die();
}
/** function
 * 2023.02.26 Dom 객체를 다루는 편집기 플러그인에서 html 밖에 객체 추가 시, 에러 발생하여  wp_head 에 스크립틀릿 방식 클라이언트 스크립트 추가
 * 2023.08.27 플러그인과 테마에 따른 로그인 URI 변경 시, 리다이렉트 URI도 변경 되도록 wp_login_url() 함수 사용
 * 2023.09.01 wp_enqueue_script() 함수에 integrity 처리가 되어 있지 않아, 직접 스크립트 추가
 */
function set_kakao_js_sdk_init_key()
{
?>
    <script src="https://t1.kakaocdn.net/kakao_js_sdk/2.4.0/kakao.min.js" integrity="sha384-mXVrIX2T/Kszp6Z0aEWaA8Nm7J6/ZeWXbL8UpGRjKwWe56Srd/iyNmWMBhcItAjH" crossorigin="anonymous"></script>
    <script>
        function kakao_init() {
            Kakao.init("<?php echo esc_html(get_option(Constants::JAVASCRIPT_KEY)); ?>");
        }

        function loginWithKakao() {
            Kakao.Auth.authorize({
                redirectUri: '<?php echo esc_url(wp_login_url()); ?>',
                state: '<?php echo session_id(); ?>'
            })
        }
    </script>
<?php
}
function kakao_tam_plugin_admin_menu()
{
    global $_wp_last_object_menu;
    add_menu_page(__('Developers setting', 'developers_setting'), '카카오 디벨로퍼스 설정', 'manage_options', 'developers_setting_index', 'developers_setting_index', 'dashicons-admin-generic', $_wp_last_object_menu);

    if (is_admin()) {
        wp_enqueue_script('script_function', plugins_url('script_admin_function.js', __FILE__), null, '1.0.0', true);
    }
}
/** function
2023.02.26 Dom 객체를 다루는 편집기 플러그인에서 html 밖에 객체 추가 시, 에러 발생하여  wp_head 에 스크립틀릿 방식 클라이언트 스크립트 추가 -> 이로 인해 wp_head 없는 로그인 페이지에 init 스크립트 별도 추가
 */
function kakao_login_wp_login()
{
    $validateKakaoLogin = new validateKakaoLogin();
    return $validateKakaoLogin->getKakaoLoginContent() . set_kakao_js_sdk_init_key();
}
function developers_setting_index()
{
    include 'admin-developers-setting.php';
}
function kakaotalk_share_filter_plugin_action_links($links, $file)
{
    static $this_plugin;
    if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);

    if ($file == $this_plugin) {
        $settings_link = '<a href="admin.php?page=developers_setting_index">' . __("Settings") . '</a>';
        array_unshift($links, $settings_link);
    }
    return $links;
}

function kakaotalk_share_filter_content($content)
{
    $validateShare = new validateShare();
    $validateMe = new validateMe();
    return $validateShare->getShareContent($content, $validateShare->kakaotalk_share(), $validateMe->kakaotalk_me());
}
function kakaotalk_channel_add_action_content()
{
    $validateChannel = new validateChannel();
    $validateChannel->getWpFooter();
}
function kakaotalk_me_action_content()
{
    $validateMe = new validateMe();
    $validateMe->getWpFooter();
}
function kakaotalk_share_filter_excerpt($content)
{
    return $content;
}
function kakao_login_shortcode($content)
{
    $validateKakaoLogin = new validateKakaoLogin();
    return $validateKakaoLogin->getShortCode($content);
}
function kakaotalk_share_shortcode($content)
{
    $validateShare = new validateShare();
    return $validateShare->getShortCode($content);
}
function kakaotalk_me_shortcode($content)
{
    $validateMe = new validateMe();
    return $validateMe->getShortCode($content);
}
function kakaotalk_channel_add_shortcode($content)
{
    $validateChannel = new validateChannel();
    return $validateChannel->getShortCodeAdd($content);
}
function kakaotalk_channel_chat_shortcode($content)
{
    $validateChannel = new validateChannel();
    return $validateChannel->getShortCodeChat($content);
}
function kakaonavi_shortcode($content)
{
    $validateKakaoNavi = new validateKakaoNavi();
    return $validateKakaoNavi->getShortCode($content);
}
function kakaonavi_share_shortcode($content)
{
    $validateKakaoNavi = new validateKakaoNavi();
    return $validateKakaoNavi->getShareShortCode($content);
}
function kakaomap_shortcode($content)
{
    $validateKakaoMap = new validateKakaoMap();
    return $validateKakaoMap->getShortCode($content);
}
