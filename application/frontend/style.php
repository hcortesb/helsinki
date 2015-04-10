<?php
/**
 * Feature Name: Style Functions for Helsinki-Theme
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com
 */

/**
 * Enqueue styles and scripts.
 *
 * @wp-hook wp_enqueue_scripts
 *
 * @return  Void
 */
function helsinki_wp_enqueue_styles() {

	$styles = helsinki_get_styles();

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
 * Returning our Helsinki-Styles
 *
 * @return  Array
 */
function helsinki_get_styles(){

	$suffix  = helsinki_get_script_suffix();
	$dir     = helsinki_get_asset_directory_url( 'css' );
	$theme_data = wp_get_theme();
	$version = $theme_data->Version;

	// $handle => array( 'src' => $src, 'deps' => $deps, 'version' => $version, 'media' => $media )
	$styles = array();

	// adding the main-CSS
	$styles[ 'helsinki' ] = array(
		'src'       => $dir . 'style' . $suffix . '.css',
	    'deps'      => NULL,
	    'version'   => $version,
	    'media'     => NULL
	);

	// adding the media-CSS
	$styles[ 'helsinki-media' ] = array(
		'src'       => $dir . 'media' . $suffix . '.css',
		'deps'      => NULL,
		'version'   => $version,
		'media'     => NULL
	);

	// adding our webfonts
	$protocol	= is_ssl() ? 'https' : 'http';
	$open_sans_query_args = array( 'family' => 'Open+Sans:400,300,700' );
	$styles[ 'helsinki-webfont-open-sans' ] = array(
		'src'       => add_query_arg( $open_sans_query_args, "$protocol://fonts.googleapis.com/css" ),
		'deps'      => array(),
		'version'   => $version,
		'media'     => NULL
	);
	$open_sans_condensed_query_args = array( 'family' => 'Open+Sans+Condensed:300,700' );
	$styles[ 'helsinki-webfont-open-sans-condensed' ] = array(
		'src'       => add_query_arg( $open_sans_condensed_query_args, "$protocol://fonts.googleapis.com/css" ),
		'deps'      => array(),
		'version'   => $version,
		'media'     => NULL
	);

	// adding the font-CSS
	$styles[ 'helsinki-fonts' ] = array(
		'src'     => $dir . 'fonts' . $suffix . '.css',
		'deps'    => NULL,
		'version' => '4.0.3',
		'media'   => NULL
	);

	// adding the magnific css
	$styles[ 'helsinki-magnific' ] = array(
		'src'     => $dir . 'magnific' . $suffix . '.css',
		'deps'    => NULL,
		'version' => '0.9.9',
		'media'   => NULL
	);

	// adding the offcanvas-CSS
	$styles[ 'helsinki-offcanvas' ] = array(
		'src'     => $dir . 'offcanvas' . $suffix . '.css',
		'deps'    => NULL,
		'version' => $version,
		'media'   => NULL
	);

	// check if we have a custom css
	$custom_css = helsinki_get_custom_css_file_url();
    if ( $custom_css !== '' ) {
    	global $pagenow;
        $styles[ 'helsinki-custom-css' ] = array(
            'src'       => $custom_css,
            'deps'      => array(),
            'version'   => time(),
            'media'     => NULL
        );
    }

	return apply_filters( 'helsinki_get_styles', $styles );
}
