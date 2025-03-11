<?php 

function one_business_blocks_add_admin_menu() {
    add_menu_page(
        'Theme Settings', // Page title
        'Theme Settings', // Menu title
        'manage_options', // Capability
        'one-business-blocks-theme-settings', // Menu slug
        'one_business_blocks_settings_page' // Function to display the page
    );
}
add_action( 'admin_menu', 'one_business_blocks_add_admin_menu' );

function one_business_blocks_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Theme Settings', 'one-business-blocks' ); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'one_business_blocks_settings_group' );
            do_settings_sections( 'one-business-blocks-theme-settings' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function one_business_blocks_register_settings() {
    register_setting( 'one_business_blocks_settings_group', 'one_business_blocks_enable_animations' );

    add_settings_section(
        'one_business_blocks_settings_section',
        __( 'Animation Settings', 'one-business-blocks' ),
        null,
        'one-business-blocks-theme-settings'
    );

    add_settings_field(
        'one_business_blocks_enable_animations',
        __( 'Enable Animations', 'one-business-blocks' ),
        'one_business_blocks_enable_animations_callback',
        'one-business-blocks-theme-settings',
        'one_business_blocks_settings_section'
    );
}
add_action( 'admin_init', 'one_business_blocks_register_settings' );

function one_business_blocks_enable_animations_callback() {
    $checked = get_option( 'one_business_blocks_enable_animations', true );
    ?>
    <input type="checkbox" name="one_business_blocks_enable_animations" value="1" <?php checked( 1, $checked ); ?> />
    <?php
}

