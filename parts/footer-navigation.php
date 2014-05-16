<?php
/**
 * The secondary site navigation.
 *
 * If no custom menu is assigned, logged in admins
 * see an alert message suggesting to create a menu.
 *
 * @package    WordPress
 * @subpackage Parallactic\Parts
 */
$nav_items_wrap = '<nav role="navigation">';
$nav_items_wrap .= '<ul id="%1$s" class="%2$s">%3$s</ul>';
$nav_items_wrap .= '</nav>';

wp_nav_menu(
	array(
		'theme_location'=> 'parallactic_footer',
		'container'     => FALSE,
		'items_wrap'    => $nav_items_wrap
	)
);
?>