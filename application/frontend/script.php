<?php
/**
 * Feature Name: MarketPress Script Setup
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com/
 */

/**
 * Enqueue styles and scripts.
 *
 * @wp-hook	wp_enqueue_scripts
 *
 * @return	void
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

		// checking for localize script args
		if ( array_key_exists( 'localize', $script ) && ! empty( $script[ 'localize' ] ) )
			foreach ( $script[ 'localize' ] as $name => $args )
				wp_localize_script(
					$handle,
					$name,
					$args
				);
	}
}

/**
 * Returning our scripts
 *
 * @return	array
 */
function helsinki_get_scripts(){

	$scripts = array();
	$suffix = helsinki_get_script_suffix();

	// getting the theme-data
	$theme_data = wp_get_theme();
	$version    = $theme_data->Version;

	// adding the html5shiv
	$scripts[ 'html5shiv' ] = array(
		'src'       => helsinki_get_asset_directory_url( 'js' ) . 'html5shiv' . $suffix . '.js',
		'deps'      => array(),
		'version'   => '2.6.2',
		'in_footer' => FALSE
	);

	// adding the magnific-js
	$scripts[ 'jquery-magnific' ] = array(
		'src'       => helsinki_get_asset_directory_url( 'js' ) . 'jquery.magnific' . $suffix . '.js',
		'deps'      => array( 'jquery' ),
		'version'   => '0.9.9',
		'in_footer' => TRUE
	);

	// adding the gallery js
	$scripts[ 'jquery-gallery' ] = array(
		'src'       => helsinki_get_asset_directory_url( 'js' ) . 'gallery' . $suffix . '.js',
		'deps'      => array( 'jquery' ),
		'version'   => $version,
		'in_footer' => TRUE
	);

	// adding the offcanvas js
	$scripts[ 'jquery-offcanvas' ] = array(
		'src'       => helsinki_get_asset_directory_url( 'js' ) . 'offcanvas' . $suffix . '.js',
		'deps'      => array( 'jquery' ),
		'version'   => $version,
		'in_footer' => TRUE,
		'localize'  => array(
			'helsinki_offcanvas_args' =>  helsinki_get_offcanvas_args()
		)
	);

	return apply_filters( 'helsinki_get_scripts', $scripts );
}

/**
 * Helper-Function to get some off canvas vars
 *
 * @return	array
 */
function helsinki_get_offcanvas_args() {

	// the default values
	$args = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	);
	return apply_filters( 'helsinki_get_offcanvas_args', $args );
}
