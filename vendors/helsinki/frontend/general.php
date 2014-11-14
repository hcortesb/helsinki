<?php
/**
 * Feature Name:    General template stuff for Helsinki-Theme
 * Version:         0.9
 * Author:          Inpsyde GmbH for MarketPress.com
 * Author URI:      http://marketpress.com
 */

/**
 * Gets the logo
 *
 * @return  string
 */
function helsinki_get_logo() {

	// register the pre filter to bypass this function
	$pre = apply_filters( 'pre_helsinki_get_logo', FALSE );
	if ( $pre !== FALSE )
		return $pre;

	// set the default logo
	$default = '<h1 class="logo"><a href="' . get_bloginfo( 'url' ) . '">' . get_bloginfo( 'name' ) . '</a></h1>';

	// return string, by adding the default markup to the filter
	return apply_filters( 'helsinki_get_logo', $default );
}