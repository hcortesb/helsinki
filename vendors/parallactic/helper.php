<?php
/**
 * Feature Name:    General Template Functions for Parallactic
 * Version:         0.9
 * Author:          Inpsyde GmbH for MarketPress.com
 * Author URI:      http://marketpress.com
 */

/**
 * getting the Script and Style suffix for Parallactic-Theme
 * Adds a conditional ".min" suffix to the file name when WP_DEBUG is NOT set to TRUE.
 *
 * @return string
 */
function parallactic_get_script_suffix() {

	$script_debug   = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
	$suffix         = $script_debug ? '' : '.min';

	return $suffix;
}