<?php
/**
 * Feature Name:    Customizer Stuff for Helsinki
 * Version:		    0.1
 * Author:		    Inpsyde GmbH for MarketPress.com
 * Author URI:	    http://inpsyde.com/
 */

/**
 * Prints the customized CSS if there is setted
 * a color in the customizer
 * 
 * @wp-hook	marketpress_customized_css_file
 * @return	string the css
 */
function helsinki_customized_css_file( $output, $color, $color_rgb ) {

	ob_start();
	?>
	a,
	body main#primary article .comments a:hover,
	body main#primary article .comments a:focus,
	body main#primary article .comments a:hover {
		color: <?php echo $color; ?>;
	}

	#headline nav ul li a:hover,
	#headline nav ul li a:focus,
	#headline nav ul li a.active,
	#headline nav ul li.current-menu-item a,
	body main#primary article .comments a .count,
	.pagination ul li .current,
	.pagination ul li a:hover,
	.pagination ul li a:focus,
	.pagination ul li a.active,
	.toggle-mobile-menu:hover,
	.toggle-mobile-menu:focus,
	.toggle-mobile-menu.active {
		background: <?php echo $color; ?>;
	}
    <?php
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}

/**
 * Gets the default color for helsinki
 * 
 * @wp-hook	marketpress_customizer_default_key_color
 * @return	string the default color
 */
function helsinki_customizer_default_key_color() {
	return '#0084cc';
}

/**
 * Disable the customizer logo
 * 
 * @wp-hook	marketpress_register_customizer_sections_logo
 * @return	boolean
 */
function helsinki_register_customizer_sections_logo() {
	return FALSE;
}

