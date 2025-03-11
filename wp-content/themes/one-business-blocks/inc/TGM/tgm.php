<?php
	
load_template( get_template_directory() . '/inc/TGM/class-tgm-plugin-activation.php' );

/**
 * Recommended plugins.
 */
function one_business_blocks_register_recommended_plugins() {
	$plugins = array(
		array(
			'name'             => __( 'Ovation Elements', 'one-business-blocks' ),
			'slug'             => 'ovation-elements',
			'required'         => false,
			'force_activation' => false,
		)
	);
	$config = array();
	one_business_blocks_tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'one_business_blocks_register_recommended_plugins' );