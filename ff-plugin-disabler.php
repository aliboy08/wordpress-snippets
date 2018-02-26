<?php
/*
Plugin Name: Plugin Disabler
Description: Disable Plugins on selected pages
Version: 1.0
Author: Alistair Ponce
License: GPLv2
*/
$request_uri = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );

$is_admin = strpos( $request_uri, '/wp-admin/' );

// add filter in front pages only
if( false === $is_admin ){
	add_filter( 'option_active_plugins', 'ff_option_active_plugins' );
}

function ff_option_active_plugins( $plugins ){
	
	global $request_uri;
	
	$unnecessary_plugins = array();

	// Deactivate unnecessary plugins on homepage
	if( $request_uri == '/' ){
		$unnecessary_plugins[] = 'ajax-thumbnail-rebuild/ajax-thumbnail-rebuild.php';
		$unnecessary_plugins[] = 'duplicate-post/duplicate-post.php';
		$unnecessary_plugins[] = 'really-simple-captcha/really-simple-captcha.php';
		$unnecessary_plugins[] = 'wp-smushit/wp-smush.php';
		$unnecessary_plugins[] = 'wp-pagenavi/wp-pagenavi.php';
		$unnecessary_plugins[] = 'gravityforms/gravityforms.php';
	}

	foreach ( $unnecessary_plugins as $plugin ) {
		$k = array_search( $plugin, $plugins );
		if( false !== $k ){
			unset( $plugins[$k] );
		}
	}
	
	return $plugins;
}