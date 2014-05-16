<?php
/**
 * Feature Name:    Navigation Helper Functions for Parallactic-Theme
 * Version:         0.9
 * Author:          Inpsyde GmbH for MarketPress.com
 * Author URI:      http://marketpress.com
 */

/**
 * Registering the nav_menus to our blog
 *
 * @return void
 */
function parallactic_register_nav_menus() {

	register_nav_menus(
		array(
		     'parallactic_header'  => __( 'Header Site Menu', 'PARALLACTIC_TEXTDOMAIN' ),
		     'parallactic_footer'  => __( 'Footer Site Menu',  'PARALLACTIC_TEXTDOMAIN' ),
		)
	);

}