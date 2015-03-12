<?php
/**
 * Feature Name: Navigation Helper Functions for Helsinki-Theme
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com
 */

/**
 * Registering the nav_menus to our blog
 *
 * @return void
 */
function helsinki_register_nav_menus() {

	register_nav_menus(
		array(
		     'helsinki_header'  => __( 'Header Site Menu', 'helsinki' )
		)
	);

}
