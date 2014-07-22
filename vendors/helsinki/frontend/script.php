<?php
/**
 * Feature Name:    Script Functions for Helsinki-Theme
 * Version:         0.9
 * Author:          Inpsyde GmbH for MarketPress.com
 * Author URI:      http://marketpress.com
 */

/**
 * Enqueue styles and scripts.
 *
 * @wp-hook wp_enqueue_scripts
 *
 * @return  void
 */
function helsinki_wp_enqueue_scripts() {

	$scripts = helsinki_get_scripts();

	foreach ( $scripts as $handle => $script ) {

		wp_enqueue_script(
			$handle,
			$script[ 'src' ],
			$script[ 'deps' ],
			$script[ 'version' ],
			$script[ 'in_footer' ]
		);
	}
}

/**
 * Returning our Helsinki-Scripts
 *
 * @return  array
 */
function helsinki_get_scripts(){

	$scripts = array();
	$suffix = helsinki_get_script_suffix();
	$dir = get_template_directory_uri() . '/assets/js/';

	// adding the main-js
	$scripts[ 'helsinki-js' ] = array(
		'src'       => $dir . 'frontend' . $suffix . '.js',
		'deps'      => array( 'jquery' ),
		'version'   => NULL,
		'in_footer' => TRUE
	);

	/*
	 * Custom modernizr build, adds classes to <html>
	 * displaying browser support for CSS3 and HTML5 features.
	 */
	$scripts[ 'modernizr' ] = array(
		'src'       => $dir . 'modernizr' . $suffix . '.js',
		'deps'      => array(),
		'version'   => NULL,
		'in_footer' => FALSE
	);

	return apply_filters( 'helsinki_get_scripts', $scripts );
}
