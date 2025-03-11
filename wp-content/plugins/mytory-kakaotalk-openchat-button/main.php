<?php

/**
 * Plugin Name: Mytory KakaoTalk OpenChat Floating Button(non-official)
 * Description: Display a floating KakaoTalk OpenChat button on your website.
 * Version: 1.0.1
 * Author: mytory
 * License: GPLv2 or later
 */

if (!defined('ABSPATH')) {
    // Exit if accessed directly
    exit;
}

// Hook for adding admin menus
add_action('admin_menu', 'kakaotalk_openchat_menu');

// Action function for the above hook
function kakaotalk_openchat_menu(): void
{
    add_options_page(
        'KakaoTalk OpenChat Settings',
        '카카오 오픈챗',
        'manage_options',
        'kakaotalk-openchat',
        'kakaotalk_openchat_settings_page'
    );
}

// KakaoTalk OpenChat settings page
function kakaotalk_openchat_settings_page(): void
{
    include 'setting.php';
}

// Register and define the settings
add_action('admin_init', 'kakaotalk_openchat_admin_init');
function kakaotalk_openchat_admin_init(): void
{
    register_setting('kakaotalk-openchat-settings-group', 'kakaotalk_openchat_url');
}

// Add the action hook
add_action('wp_footer', 'kakaotalk_openchat_footer_hook');
function kakaotalk_openchat_footer_hook(): void
{
    $kakaotalk_url = get_option('kakaotalk_openchat_url');
    if ($kakaotalk_url || current_user_can('edit_others_posts')) {
        include 'button.php';
    }
}

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('kakaotalk-openchat-style', plugins_url('style.css', __FILE__));
});

add_filter(
    'plugin_action_links_' . plugin_basename(__FILE__),
    function ($links) {
        $settings_link = '<a href="' . admin_url('options-general.php?page=kakaotalk-openchat') . '">' . __('Settings') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
);
