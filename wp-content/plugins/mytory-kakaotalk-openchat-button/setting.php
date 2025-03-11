<?php
if (!defined('ABSPATH')) {
    // Exit if accessed directly
    exit;
}
?>
<div class="wrap">
    <h2>KakaoTalk OpenChat Settings</h2>
    <!--suppress HtmlUnknownTarget -->
    <form method="post" action="options.php">
        <?php settings_fields('kakaotalk-openchat-settings-group'); ?>
        <?php do_settings_sections('kakaotalk-openchat-settings-group'); ?>
        <table class="form-table">
            <tr style="vertical-align: top;">
                <th scope="row"><label for="kakaotalk_openchat_url">URL</label></th>
                <td><input style="width: 100%;" type="text" id="kakaotalk_openchat_url" name="kakaotalk_openchat_url" value="<?php echo esc_attr(get_option('kakaotalk_openchat_url')); ?>" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>