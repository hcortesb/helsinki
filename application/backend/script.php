<?php
/**
 * Feature Name: MarketPress Admin Script Setup
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com/
 */

/**
 * Enqueue styles and scripts.
 *
 * @wp-hook	admin_enqueue_scripts
 *
 * @return	void
 */
function helsinki_admin_enqueue_scripts() {

	$scripts = helsinki_get_admin_scripts();

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
function helsinki_get_admin_scripts(){

	$scripts = array();
	$suffix = helsinki_get_script_suffix();

	// getting the theme-data
	$theme_data = wp_get_theme();
	$version    = $theme_data->Version;

	// adding the offcanvas js
	$scripts[ 'jquery-admin' ] = array(
		'src'       => helsinki_get_asset_directory_url( 'js' ) . 'admin' . $suffix . '.js',
		'deps'      => array( 'jquery' ),
		'version'   => $version,
		'in_footer' => TRUE,
	);

	return apply_filters( 'helsinki_get_admin_scripts', $scripts );
}
