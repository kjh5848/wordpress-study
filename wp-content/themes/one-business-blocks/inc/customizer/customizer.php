<?php
/**
 * One Business Blocks: Customizer
 *
 * @subpackage One Business Blocks
 * @since 1.0
 */

function one_business_blocks_customize_register( $wp_customize ) {

    wp_enqueue_style('customizercustom_css', esc_url( get_template_directory_uri() ). '/inc/customizer/customizer.css');

    // Pro Section
    $wp_customize->add_section('one_business_blocks_pro', array(
        'title'    => __('ONE BUSINESS PREMIUM', 'one-business-blocks'),
        'priority' => 1,
    ));
    $wp_customize->add_setting('one_business_blocks_pro', array(
        'default'           => null,
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new One_Business_Blocks_Pro_Control($wp_customize, 'one_business_blocks_pro', array(
        'label'    => __('ONE BUSINESS PREMIUM', 'one-business-blocks'),
        'section'  => 'one_business_blocks_pro',
        'settings' => 'one_business_blocks_pro',
        'priority' => 1,
    )));
}
add_action( 'customize_register', 'one_business_blocks_customize_register' );


define('ONE_BUSINESS_BLOCKS_PRO_LINK',__('https://www.ovationthemes.com/products/wordpress-business-theme','one-business-blocks'));

define('ONE_BUSINESS_BLOCKS_BUNDLE_BTN',__('https://www.ovationthemes.com/products/wordpress-bundle','one-business-blocks'));

/* Pro control */
if (class_exists('WP_Customize_Control') && !class_exists('One_Business_Blocks_Pro_Control')):
    class One_Business_Blocks_Pro_Control extends WP_Customize_Control{

    public function render_content(){?>
        <label style="overflow: hidden; zoom: 1;">
            <div class="col-md upsell-btn">
                <a href="<?php echo esc_url( ONE_BUSINESS_BLOCKS_PRO_LINK ); ?>" target="blank" class="btn btn-success btn"><?php esc_html_e('UPGRADE ONE BUSINESS PREMIUM','one-business-blocks');?> </a>
            </div>
            <div class="col-md">
                <img class="one_business_blocks_img_responsive " src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png">
            </div>
            <div class="col-md">
                <ul style="padding-top:10px">
                    <li class="upsell-one_business_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Responsive Design', 'one-business-blocks');?> </li>                 
                    <li class="upsell-one_business_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Demo Importer', 'one-business-blocks');?> </li>
                    <li class="upsell-one_business_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Section Reordering', 'one-business-blocks');?> </li>
                    <li class="upsell-one_business_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Contact Page Template', 'one-business-blocks');?> </li>
                    <li class="upsell-one_business_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Multiple Blog Layouts', 'one-business-blocks');?> </li>
                    <li class="upsell-one_business_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Unlimited Color Options', 'one-business-blocks');?> </li>
                    <li class="upsell-one_business_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Cross Browser Support', 'one-business-blocks');?> </li>
                    <li class="upsell-one_business_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Detailed Documentation Included', 'one-business-blocks');?> </li>
                    <li class="upsell-one_business_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('WPML Compatible (Translation Ready)', 'one-business-blocks');?> </li>
                    <li class="upsell-one_business_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Woo-commerce Compatible', 'one-business-blocks');?> </li>
                    <li class="upsell-one_business_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Full Support', 'one-business-blocks');?> </li>
                    <li class="upsell-one_business_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('10+ Sections', 'one-business-blocks');?> </li>
                    <li class="upsell-one_business_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('SEO Friendly', 'one-business-blocks');?> </li>
                    <li class="upsell-one_business_blocks"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Supper Fast', 'one-business-blocks');?> </li>
                </ul>
            </div>
            <div class="col-md upsell-btn upsell-btn-bottom">
                <a href="<?php echo esc_url( ONE_BUSINESS_BLOCKS_BUNDLE_BTN ); ?>" target="blank" class="btn btn-success btn"><?php esc_html_e('Wordpress Theme Bundle (100+ Themes at Just $89)','one-business-blocks');?> </a>
            </div>
        </label>
    <?php } }
endif;