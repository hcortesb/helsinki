<?php
/**
 * Feature Name:    Style Functions for Helsinki-Backend
 * Version:         0.9
 * Author:          Inpsyde GmbH for MarketPress.com
 * Author URI:      http://marketpress.com
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

	$suffix = marketpress_get_script_suffix();
	$dir    = get_template_directory_uri() . '/assets/css/';

	// $handle => array( 'src' => $src, 'deps' => $deps, 'version' => $version, 'media' => $media )
	$styles = array();

	// adding the main-CSS
	$styles[ 'helsinki-admin' ] = array(
		'src'       => $dir . 'admin' . $suffix . '.css',
	    'deps'      => NULL,
	    'version'   => NULL,
	    'media'     => NULL
	);

	return apply_filters( 'helsinki_get_admin_styles', $styles );
}
