<?php
/**
 * Feature Name: Widget Functions for Helsinki-Theme
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com
 */

/**
 * Callback to register the widget areas
 *
 * @wp-hook widgets_init
 *
 * @return  array
 */
function helsinki_widgets_init() {

	// Define widget areas
	$sidebars = array(
		'footer-left' => array(
			'class' => 'widget-area widget-column column',
			'name'  => _x( 'Footer Left', 'Widget area name in wp-admin/widgets.php', 'helsinki' ),
			'desc'  => _x( 'Widget area at the left footer', 'Widget area description in wp-admin/widgets.php', 'helsinki' )
		),
		'footer-middle' => array(
			'class' => 'widget-area widget-column column',
			'name'  => _x( 'Footer Middle', 'Widget area name in wp-admin/widgets.php', 'helsinki' ),
			'desc'  => _x( 'Widget area at the middle footer', 'Widget area description in wp-admin/widgets.php', 'helsinki' )
		),
		'footer-right' => array(
			'class' => 'widget-area widget-column column',
			'name'  => _x( 'Footer Right', 'Widget area name in wp-admin/widgets.php', 'helsinki' ),
			'desc'  => _x( 'Widget area at the right footer', 'Widget area description in wp-admin/widgets.php', 'helsinki' )
		),
		'off-canvas-area' => array(
			'class' => 'widget-area widget-offcanvas offcanvas',
			'name' => _x( 'Off-Canvas-Area', 'Widget area name in wp-admin/widgets.php', 'helsinki' ),
			'desc' => _x( 'The widget area in the off canvas area', 'Widget area name in wp-admin/widgets.php', 'helsinki' ),
		),
	);

	// Create widget areas
	foreach ( $sidebars as $id => $args ) {
		register_sidebar( array(
				'name'			=> $args[ 'name' ],
				'id'			=> $id,
				'description'	=> $args[ 'desc' ],
				'class'			=> $args[ 'class' ],
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	// Return a value for unit tests
	return $GLOBALS[ 'wp_registered_sidebars' ];
}

/**
 * Add classes for widgets with counters or dropdowns.
 *
 * @wp-hook dynamic_sidebar_params
 *
 * @param   array $params
 * @return  array
 */
function helsinki_filter_dynamic_sidebar_params( Array $params ) {
	global $wp_registered_widgets;

	$classes     = array();
	$instance_id = $params[ 1 ][ 'number' ];
	$widget_id   = $params[ 0 ][ 'widget_id' ];

	// The class handling the widget.
	$settings    = $wp_registered_widgets[ $widget_id ][ 'callback' ][ 0 ]->get_settings();

	if ( empty ( $settings[ $instance_id ] ) )
		return $params;

	if ( ! empty ( $settings[ $instance_id ][ 'dropdown' ] ) )
		$classes[] = 'widget-with-dropdown';

	if ( ! empty ( $settings[ $instance_id ][ 'count' ] ) )
		$classes[] = 'widget-with-counters';

	if ( empty ( $classes ) )
		return $params;

	$params[ 0 ][ 'before_widget' ] = str_replace(
		'class="',
		'class="' . join( ' ', $classes ) . ' ',
		$params[ 0 ][ 'before_widget' ]
	);

	return $params;
}
