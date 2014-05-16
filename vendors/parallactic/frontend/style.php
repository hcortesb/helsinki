<?php
/**
 * Feature Name:    Style Functions for Parallactic-Theme
 * Version:         0.9
 * Author:          Inpsyde GmbH for MarketPress.com
 * Author URI:      http://marketpress.com
 */

/**
 * Remove file version query arguments from script/stylesheet URLs.
 *
 * Leaves http://fonts.googleapis.com/css?family=MyFont untouched.
 *
 * @link    http://wordpress.stackexchange.com/a/96325/
 * @link    http://wordpress.stackexchange.com/q/99842/
 *
 * @wp-hook style_loader_src
 *
 * @param   string $url
 * @param   string $handle
 * @return  string
 */
function parallactic_filter_style_loader_src( $url, $handle ){

	$host = parse_url( $url, PHP_URL_HOST );

	if ( $host === 'fonts.googleapis.com' )
		return remove_query_arg( 'ver', $url );

	return $url;
}

/**
 * Enqueue styles and scripts.
 *
 * @wp-hook wp_enqueue_scripts
 *
 * @return  Void
 */
function parallactic_wp_enqueue_styles() {

	$styles = parallactic_get_styles();

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
 * Returning our Parallactic-Styles
 *
 * @return  Array
 */
function parallactic_get_styles(){

	$suffix = parallactic_get_script_suffix();
	$dir    = get_template_directory_uri() . '/assets/css/';

	// $handle => array( 'src' => $src, 'deps' => $deps, 'version' => $version, 'media' => $media )
	$styles = array();

	// adding the main-CSS
	$styles[ 'parallactic' ] = array(
		'src'       => $dir . 'style' . $suffix . '.css',
	    'deps'      => NULL,
	    'version'   => NULL,
	    'media'     => NULL
	);

	// adding the media-CSS
	$styles[ 'parallactic-media' ] = array(
		'src'       => $dir . 'media' . $suffix . '.css',
		'deps'      => NULL,
		'version'   => NULL,
		'media'     => NULL
	);

	// adding our webfonts
	$protocol	= is_ssl() ? 'https' : 'http';
	$open_sans_query_args = array( 'family' => 'Open+Sans:400,300,700' );
	$styles[ 'parallactic-webfont-open-sans' ] = array(
		'src'       => add_query_arg( $open_sans_query_args, "$protocol://fonts.googleapis.com/css" ),
		'deps'      => array(),
		'version'   => NULL,
		'media'     => NULL
	);
	$open_sans_condensed_query_args = array( 'family' => 'Open+Sans+Condensed:300,700' );
	$styles[ 'parallactic-webfont-open-sans-condensed' ] = array(
		'src'       => add_query_arg( $open_sans_condensed_query_args, "$protocol://fonts.googleapis.com/css" ),
		'deps'      => array(),
		'version'   => NULL,
		'media'     => NULL
	);

	return apply_filters( 'parallactic_get_styles', $styles );
}
