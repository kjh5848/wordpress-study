<?php

/**
 * @var string $kakaotalk_url
 */

if (!defined('ABSPATH')) {
   // Exit if accessed directly
   exit;
}
?>
<a href="<?php echo esc_attr($kakaotalk_url ?: admin_url('options-general.php?page=kakaotalk-openchat')) ?>" class="mytory-kakaotalk-openchat-button"></a>