<?php
/**
 * Feature Name: Style Functions for Helsinki-Backend
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com
 */

/**
 * Enqueue styles and scripts.
 *
 * @wp-hook admin_enqueue_scripts
 *
 * @return  Void
 */
function helsinki_admin_enqueue_styles() {

	$styles = helsinki_get_admin_styles();

	foreach( $styles as $key => $style ){
		wp_enqueue_style(
			$key,
			$style[ 'src' ],
			$style[ 'deps' ],
			$style[ 'version' ],
			$style[ 'media' ]
		);
	}
}

/**
 * Returning our Admin-Styles
 *
 * @return  Array
 */
function helsinki_get_admin_styles(){

	$suffix = helsinki_get_script_suffix();
	$theme_data = wp_get_theme();
	$version = $theme_data->Version;
	$dir    = helsinki_get_asset_directory_url( 'css' );

	// $handle => array( 'src' => $src, 'deps' => $deps, 'version' => $version, 'media' => $media )
	$styles = array();

	// adding the admin-CSS
	$styles[ 'helsinki-admin' ] = array(
		'src'     => $dir . 'admin' . $suffix . '.css',
		'deps'    => NULL,
		'version' => $version,
		'media'   => NULL
	);

	return apply_filters( 'helsinki_get_admin_styles', $styles );
}
