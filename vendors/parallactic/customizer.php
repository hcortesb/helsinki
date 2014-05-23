<?php
/**
 * Feature Name:    Customizer Stuff for Parallactic
 * Version:		    0.1
 * Author:		    Inpsyde GmbH for MarketPress.com
 * Author URI:	    http://inpsyde.com/
 */

/**
 * Register the parallactic specific customizer options. In our
 * case it is a simple color picker to set a specific
 * key color.
 *
 * @param object $wp_customize
 *
 * @return void
 */
function parallactic_register_customizer_sections( $wp_customize ) {

	$wp_customize->add_section( 'parallactic_colors' , array(
		'title' => __( 'Colors', 'theme_parallactic' )
	) );

	$wp_customize->add_setting( 'link_color', array(
		'default' => '#0084cc',
		'transport' => 'refresh',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'label' => __( 'Key Color', 'theme_parallactic' ),
		'section' => 'parallactic_colors',
		'settings' => 'link_color',
	) ) );
}

/**
 * Prints the customized CSS if there is setted
 * a color in the customizer
 *
 * @return void
 */
function parallactic_print_customized_css() {

	$color = get_theme_mod( 'link_color' );
	if ( ! $color )
		return;
	?>
	<style type="text/css">
		a,
		body > main article .comments a:hover,
		body > main article .comments a:focus,
		body > main article .comments a:hover {
			color: <?php echo $color; ?>;
		}

		#headline nav ul li a:hover,
		#headline nav ul li a:focus,
		#headline nav ul li a.active,
		#headline nav ul li.current-menu-item a,
		body > main article .comments a .count,
		.pagination ul li .current,
		.pagination ul li a:hover,
		.pagination ul li a:focus,
		.pagination ul li a.active,
		.toggle-mobile-menu:hover,
		.toggle-mobile-menu:focus,
		.toggle-mobile-menu.active {
			background: <?php echo $color; ?>;
		}
	</style>
    <?php
}