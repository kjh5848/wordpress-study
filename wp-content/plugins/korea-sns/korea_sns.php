<?php
/* 
Plugin Name: Korea SNS 
Plugin URI: http://icansoft.com/product/korea-sns
Description: You can Insert share buttons for korean in contents post or page. - kakaotalk, naver (line, band, blog, cafe), facebook, X, telegram ---> <a href="http://icansoft.com/product/korea-sns">Plugin Page</a> | <a href="http://facebook.com/groups/koreasns">Support</a>
Author: Jongmyoung Kim 
Version: 1.7.0
Author URI: http://icansoft.com/ 
License: GPL2
*/

/* Copyright 2014 Jongmyoung.Kim (email : supprot@icansoft.com)
 This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

add_action('init', 'kon_tergos_init');
add_filter('the_content', 'kon_tergos_content');
add_filter('the_excerpt', 'kon_tergos_excerpt');
add_filter('plugin_action_links', 'kon_tergos_add_settings_link', 10, 2 );
add_action('admin_menu', 'kon_tergos_menu');
add_shortcode( 'korea_sns_button', 'kon_tergos_shortcode');

function kon_tergos_init() {
	if (is_admin()) {
		return;
	}
	
	$option = kon_tergos_get_options_stored();

	wp_enqueue_script('jquery');
	wp_enqueue_script('kakao_sdk', 'https://developers.kakao.com/sdk/js/kakao.min.js', null, null , true);
	wp_enqueue_script('koreasns_js', plugins_url( 'korea_sns.js', __FILE__ ), null, '1.1.0', true );
	wp_enqueue_style( 'koreasns_css', plugins_url('korea_sns.css', __FILE__), null. '1.6.0');
}

function kon_tergos_menu() {
	add_options_page('Korea SNS Options', 'Korea SNS', 'manage_options', 'kon_tergos_options', 'kon_tergos_options');
}

function kon_tergos_add_settings_link($links, $file) {
	static $this_plugin;
	if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
 
	if ($file == $this_plugin){
		$settings_link = '<a href="admin.php?page=kon_tergos_options">'.__("Settings").'</a>';
		array_unshift($links, $settings_link);
	}
	return $links;
}

function kon_tergos_content ($content) {
	return kon_tergos ($content, 'the_content');
}

function kon_tergos_excerpt ($content) {
	return kon_tergos ($content, 'the_excerpt');
}

function kon_tergos ($content, $filter, $link='', $title='') {
	static $last_execution = '';
	
	if ($filter=='the_excerpt' and $last_execution=='the_content') {
		remove_filter('the_content', 'kon_tergos_content');
		$last_execution = 'the_excerpt';
	}
	if ($filter=='the_excerpt' and $last_execution=='the_excerpt') {

		add_filter('the_content', 'kon_tergos_content');
	}

	$custom_field_disable = get_post_custom_values('kon_tergos_disable');	
	if( isset($custom_field_disable[0]) ){
		if( $custom_field_disable[0]=='yes' and $filter!='shortcode' ){
			return $content;
		}
	}
	
	$option = kon_tergos_get_options_stored();

	if ($filter!='shortcode') {
		if (is_single()) {
			if (!$option['show_in']['posts']) { return $content; }
		} else if (is_singular()) {
			if (!$option['show_in']['pages']) {
				return $content;
			}
		} else if (is_home()) {
			if (!$option['show_in']['home_page']) {	return $content; }
		} else if (is_tag()) {
			if (!$option['show_in']['tags']) { return $content; }
		} else if (is_category()) {
			if (!$option['show_in']['categories']) { return $content; }
		} else if (is_date()) {
			if (!$option['show_in']['dates']) { return $content; }
		} else if (is_author()) {
			if (!$option['show_in']['authors']) { return $content; }
		} else if (is_search()) {
			if (!$option['show_in']['search']) { return $content; }
		} else {
			return $content;
		}
	}
	
	if( !isset($option['mobile_only']) ){
		 $option['mobile_only'] = false;
	}
	
	$bMobileClient = 0;
	$arMobileAgent  = array("iphone","lgtelecom","skt","mobile","samsung","nokia","blackberry","android","android","sony","phone");
  for($i=0; $i<sizeof($arMobileAgent); $i++){ 
    if(preg_match("/$arMobileAgent[$i]/", strtolower($_SERVER['HTTP_USER_AGENT']))){
    	$bMobileClient = 1;
    	break;
    } 
  }
	
	if ($link=='' || $title=='') {
		$link = get_permalink();
		$title = get_the_title();
	}
	
	$title = strip_tags($title);
	$title = str_replace("\"", " ", $title);
	$title = str_replace("&#039;", "", $title);	
	
	$siteTitle = get_bloginfo('name');
	$siteTitle = strip_tags($siteTitle);
	$siteTitle = str_replace("\"", " ", $siteTitle);
	$siteTitle = str_replace("&#039;", "", $siteTitle);	
	
	$eLink = urlencode($link);
	$eTitle = urlencode($title." - ".$siteTitle);
	$eSiteTitle = urlencode($siteTitle);
	$bPosBoth = ( $option['position'] == 'both') ? 1 : 0;
	$strSocialButtons = '';
	$locKakaotalk = '';
	$monoIconTag = ( $option['button_style'] == 'basic_mono' || $option['button_style'] == 'round_mono' ) ? 'b_' : '';
	$cssButtonRounded = ( $option['button_style'] == 'round' || $option['button_style'] == 'round_mono' ) ? 'border-radius:50%' : '';
	
	foreach($option['active_buttons'] as $snsKey => $snsOpt ){
		
		if( !$snsOpt ) continue;
		if( $snsKey == 'google1' || $snsKey == 'google' || $snsKey == 'kakaostory' || $snsKey=='kakaotalk' ) continue;	
		if( $option['mobile_only'] && !$bMobileClient && $snsKey=='naverline' ) continue;
		$cssButton = ' style="background-image:url(\''.plugins_url( '/icons/'.$monoIconTag.$snsKey.'.png', __FILE__ ).'\');'.$cssButtonRounded.'"';
		
		switch( $snsKey )
		{			
			case 'naverline':
				if( $bMobileClient )
					$call = 'document.location.href=\'http://line.naver.jp/R/msg/text/?'.$eTitle.'%0D%0A'.$eLink.'\'';
				else
					$call = 'alert(\'Only Mobile\')';
					
				$loc = '<div class="korea-sns-button korea-sns-'.$snsKey.'" OnClick="'.$call.'" '.$cssButton.'></div>';	
				break;
			
					
			default:
				$call = "SendSNS('".$snsKey."', '".$title." - ".$siteTitle."', '".$link."', '', $bMobileClient);";			
				$loc = '<div class="korea-sns-button korea-sns-'.$snsKey.'" OnClick="'.$call.'" '.$cssButton.'></div>';				
				break;
		}
				
		$strSocialButtons .= $loc;
	}
	
	static $nKakaotalkBtCount = 1;
	
	$strSocialButtons .= $locKakaotalk;
	$strSocialButtonsFirst = str_replace('[_POST_ID_]', get_the_ID().'-'.$nKakaotalkBtCount, $strSocialButtons);
	$nKakaotalkBtCount ++;

	$last_execution = $filter;
	if ($filter=='shortcode') return '<div class="korea-sns-shortcode">'.$strSocialButtonsFirst.'</div>';
	
	$classFloat = 'korea-sns-pos-'.$option['position_float'];
	
	$out = '<div class="korea-sns"><div class="korea-sns-post '.$classFloat.'">'.$strSocialButtonsFirst.'</div><div style="clear:both;"></div></div>';
	
	if( is_single() || is_page() ){
		switch( $option['position'] ){
			case 'both':
				$strSocialButtonsSecond = str_replace('[_POST_ID_]', get_the_ID().'-'.$nKakaotalkBtCount, $strSocialButtons);
				$nKakaotalkBtCount ++;
				$out2 = '<div class="korea-sns"><div class="korea-sns-post '.$classFloat.'">'.$strSocialButtonsSecond.'</div><div style="clear:both;"></div></div>';
				return $out.$content.$out2;
			case 'above':
				return $out.$content;
			default:
			case 'bellow':
				return $content.$out;
		}
	}
	else{	
		return $content.$out;
	}
}

function kon_tergos_options () {

	$option_name = 'kon_tergos';
	
	load_plugin_textdomain( 'kiss', false, dirname( plugin_basename( __FILE__ ) ) . '/languages');
	
	if (!current_user_can('manage_options')) {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	$active_buttons = array(
		'facebook'=>'Facebook',
		'twitter'=>'X',
		'telegram'=>'Telegram',
		'kakaotalk'=>'Kakaotalk (Enable in Pro version)',
		'naverline'=>'Naver Line',
		'naverband'=>'Naver Band',
		'naverblog'=>'Naver Blog, Cafe',
		'copyurl'=>'Copy URL'
	);	

	$show_in = array(
		'posts'=>'Posts',
		'pages'=>'Pages',
		'home_page'=>'Home',
		'tags'=>'Tags',
		'categories'=>'Categories',
		'dates'=>'Date',
		'authors'=>'Author',
		'search'=>'Search',
	);
	
	$arButtonStyle = array(
		'basic' => 'Basic',
		'basic_mono' => 'Basic Mono',
		'round' => 'Round',
		'round_mono' => 'Round Mono'
	);
	
	$out = '';
	
	if( isset($_POST['update_kiss']) && 
			wp_verify_nonce( $_POST['kiss_form_nonce'], 'kiss_form_nonce' )	) {
		$option = array();

		foreach (array_keys($active_buttons) as $item) {
			$option['active_buttons'][$item] = (isset($_POST['kon_tergos_active_'.$item]) and $_POST['kon_tergos_active_'.$item]=='on') ? true : false;
		}
		foreach (array_keys($show_in) as $item) {
			$option['show_in'][$item] = (isset($_POST['kon_tergos_show_'.$item]) and $_POST['kon_tergos_show_'.$item]=='on') ? true : false;
		}
		$option['position'] = esc_html($_POST['kon_tergos_position']);
		$option['position_float'] = esc_html($_POST['kon_tergos_position_float']);
		$option['mobile_only'] = esc_html($_POST['kon_tergos_mobile_only']);
		$option['button_style'] =	( isset($_POST['kisspro_button_style']) 	) ? esc_html($_POST['kisspro_button_style']) 			: '';
		$option['kakao_app_key'] = esc_html($_POST['kk_appkey']);
		$option['kakaotalk_title_type'] = esc_html($_POST['kkt_title_type']);
		$option['kakaotalk_title_text'] = esc_html($_POST['kkt_title_text']);
		
		update_option($option_name, $option);
		$out .= '<div class="updated"><p><strong>'.__('Settings saved.' ).'</strong></p></div>';
	}
	
	$option = kon_tergos_get_options_stored();
	
	$sel_above = ($option['position']=='above') ? 'selected="selected"' : '';
	$sel_below = ($option['position']=='below') ? 'selected="selected"' : '';
	$sel_both  = ($option['position']=='both' ) ? 'selected="selected"' : '';
	
	$sel_float_left = ($option['position_float']=='left') ? 'selected="selected"' : '';
	$sel_float_center = ($option['position_float']=='center') ? 'selected="selected"' : '';
	$sel_float_right = ($option['position_float']=='right') ? 'selected="selected"' : '';
	
	$check_mobile_only = ($option['mobile_only']==true) ? 'checked' : '';
	
	$sel_kakaotalk_title_type_sitename = ($option['kakaotalk_title_type']=='1') ? 'selected="selected"' : '';
	$sel_kakaotalk_title_type_text = ($option['kakaotalk_title_type']=='2') ? 'selected="selected"' : '';
	$styleKakaotalkTitleText = ($option['kakaotalk_title_type']=='1') ? 'display:none;' : 'display:inline;';

	?>
	
	<style>
		#kon_tergos_form h3 { cursor: default; }
		#kon_tergos_form td { vertical-align:top; padding:10px; }
	</style>
	
	<div class="wrap">
		<div style="display:table;width:100%;">
			<h1>Korea SNS <?php _e('Settings'); ?></h1>
		</div>
		
		<div id="poststuff" style="padding-top:10px; position:relative;">
			<div>
				<form id="kon_tergos_form" name="form1" method="post" action="">
					<?php wp_nonce_field( 'kiss_form_nonce', 'kiss_form_nonce' ); ?>
					<p>
						<a class="button" href="http://icansoft.com/product/korea-sns-pro" target="_blank"><?php _e('Upgrade Korea SNS Pro', 'kiss'); ?></a>
						
						<span style="float:right;">
							<a href="http://icansoft.com/product/korea-sns" target="_blank"><?php _e('Homepage', 'kiss'); ?></a> <b>|</b>
							<a href="http://facebook.com/groups/koreasns" target="_blank"><?php _e('Support Forum', 'kiss'); ?></a> </b>
						</span>
					</p>
								
					<div class="postbox">
						<div class="inside">
							<table width="100%">
								<tr>
									<td><strong><?php _e('Position'); ?></strong></td>
									<td>
										<select name="kon_tergos_position">
											<option value="above" <?php echo $sel_above; ?>> <?php _e('Top'); ?></option>
											<option value="below" <?php echo $sel_below; ?>> <?php _e('Bottom'); ?></option>
											<option value="both"  <?php echo $sel_both; ?>> <?php _e('All'); ?></option>
										</select>
										
										<select name="kon_tergos_position_float">
											<option value="left" <?php echo $sel_float_left; ?>> <?php _e('Left'); ?></option>
											<option value="center" <?php echo $sel_float_center; ?>> <?php _e('Center'); ?></option>
											<option value="right" <?php echo $sel_float_right; ?>> <?php _e('Right'); ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td><strong><?php _e('Show'); ?></strong></td>
									<td>
										<?php
											foreach ($show_in as $name => $text) {
												$checked = ($option['show_in'][$name]) ? 'checked="checked"' : '';
												?>
													<div style="display: inline-block;">
														<input type="checkbox" name="kon_tergos_show_<?php echo $name; ?>" <?php echo $checked; ?> />
															<?php _e($text); ?>
														&nbsp;&nbsp;
													</div>
												<?php
											}
										?>
										
										<br>
										<br>
										
										<?php 
											foreach ($active_buttons as $name => $text) {
												$checked = ($option['active_buttons'][$name]) ? 'checked="checked"' : '';
												?>
													<div style="display: inline-block;">
														<input type="checkbox" name="kon_tergos_active_<?php echo $name; ?>" <?php echo $checked; ?> />
														<?php _e($text, 'kiss'); ?>
														&nbsp;&nbsp;</div>
												<?php
											}
										?>
										
										<br>
										<br>
										<input type="checkbox" name="kon_tergos_mobile_only" <?php echo $check_mobile_only; ?>/> <?php _e('Hide mobile-click on the desktop', 'kiss'); ?> (<?php _e('Naver Line', 'kiss'); ?>)				
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e('Style'); ?></strong>
									</td>
									<td>
										<select name="kisspro_button_style">
											<?php
												foreach ($arButtonStyle as $key => $text) {
													$selected = ($key == $option['button_style']) ? 'selected="selected"' : '';
													?>
														<option value="<?=$key ?>" <?=$selected ?>> <?php _e($text); ?></option>
													<?php
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td><strong><?php _e('Kakaotalk', 'kiss'); ?></strong></td>
									<td>
										<?php _e('Your Kakao App Key', 'kiss'); ?>
										<input type="text" name="kk_appkey" size="40" value="<?php echo $option['kakao_app_key']; ?>">
										<br/>
										<a href="http://icansoft.com/blog/getting-api-key-for-kakaotalk-web-share" target="_blank">
											[?] <?php _e('Getting apps key from Kakao Developers', 'kiss'); ?></a>
										
										<br>
										<br>
										<?php _e('Kakaotalk Link Button Title', 'kiss'); ?>	
										<select name="kkt_title_type" id="kakaotalk_title_type_select">
										<option value="1" <?php echo $sel_kakaotalk_title_type_sitename; ?>><?php _e('Your Site Name', 'kiss'); ?></option>
										<option value="2" <?php echo $sel_kakaotalk_title_type_text; ?>><?php _e('Direct Input', 'kiss'); ?></option>
										</select>
										<input type="text" id="kakaotalk_title_text" name="kkt_title_text" id="kakaotalk_title_text" size="50"
											value="<?php echo $option['kakaotalk_title_text'] ?>" style="<?php echo $styleKakaotalkTitleText; ?>" />
											<br>
										<a href="http://icansoft.com/blog/korea-sns-change-kakaotalk-icon" target="_blank">
											[?] <?php _e('How to change the app icon image', 'kiss'); ?>
										</a>
									</td>
								</tr>
								
								<tr>
									<td>&nbsp;</td>
									<td>
										<a href="http://icansoft.com/product/korea-sns-pro/" target="_blank">
											<img src="<?php echo plugins_url( '/images/option-banner-koreasnspro.jpg', __FILE__ ); ?>" style="height:150px;border:1px solid #ccc"></a>
										&nbsp;&nbsp;
										<a href="http://icansoft.com/product/korea-map/" target="_blank">
											<img src="<?php echo plugins_url( '/images/option-banner-koreamap.jpg', __FILE__ ); ?>" style="height:150px;border:1px solid #ccc">
										</a>
									</td>
								</tr>	
							</table>
						</div>
					</div>
		
					<input type="submit" name="update_kiss" class="button-primary" value="<?php _e('Save Changes'); ?>" />
				</form>
	
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		jQuery(document).ready(function($) {			
			$("#kakaotalk_title_type_select").change(function(){
				if( $("#kakaotalk_title_type_select option:selected").val() == "1" ){
					$("#kakaotalk_title_text").css("display", "none");
				}
				else{
					$("#kakaotalk_title_text").css("display", "inline");
					
					if( $("#kakaotalk_title_text").val() == "" ){
						$("#kakaotalk_title_text").val("Read more...");
					}
				}
			});
		});
	</script>
	<?php
}

function kon_tergos_shortcode ($atts) {
	return kon_tergos ('', 'shortcode');
}

function kon_tergos_publish ($link='', $title='') {
	return kon_tergos ('', 'shortcode', $link, $title);
}

function kon_tergos_get_options_stored () {

	$option = get_option('kon_tergos');
	 
	if ($option===false)
	{
		$option = kon_tergos_get_options_default();
		add_option('kon_tergos', $option);
	}
	else if ($option=='above' or $option=='below')
	{
		$option = kon_tergos_get_options_default($option);
	}
	else if(!is_array($option))
	{
		$option = json_decode($option, true);
	}
	
	return $option;
}

function kon_tergos_get_options_default ($position='above') {
	$option = array();
	$option['active_buttons'] = array('facebook'=>true, 'twitter'=>true, 'telegram'=>true, 'kakaotalk'=>true, 'naverline'=>true, 'naverband'=>true, 'naverblog'=>true, 'copyurl'=>true);
	$option['position'] = $position;
	$option['position_float'] = 'left';
	$option['mobile_only'] = true;
	$option['show_in'] = array('posts'=>true, 'pages'=>true, 'home_page'=>false, 'tags'=>true, 'categories'=>true, 'dates'=>true, 'authors'=>true, 'search'=>true);
	$option['kakao_app_key'] = '';
	$option['kakaotalk_title_type'] = '1';
	$option['kakaotalk_title_text'] = 'Read Post';
	$option['button_style'] = 'basic';
	
	return $option;
}
