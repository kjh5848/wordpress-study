<?php
	if ( ! defined( 'ABSPATH' ) ) {
		die( 'uninstall error' );
	}
	
	if ( defined( 'WP_UNINSTALL_PLUGIN' ) ) {
		global $wpdb, $wp_filesystem;
	
		delete_option('kon_tergos');
	}
