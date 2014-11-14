<?php
/**
 * Helsinki functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package    WordPress
 * @subpackage Helsinki
 */

add_action( 'after_setup_theme', 'helsinki_setup', 0 );
/**
 * Callback on theme_init
 *
 * @wp-hook after_setup_theme
 *
 * @return  Void
 */
function helsinki_setup() {

	$vendor_dir = dirname( __FILE__ ) . '/vendors/';

	// localization
	load_theme_textdomain( 'helsinki', get_template_directory() . '/languages' );

	// custom header
	include_once( $vendor_dir . 'helsinki/header.php' );
	helsinki_custom_header_setup();

	// theme support
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'  ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );

	// image sizes
	include_once( $vendor_dir . 'helsinki/attachment.php' );
	helsinki_register_image_sizes();

	// navigation
	include_once( $vendor_dir . '/helsinki/navigation.php' );
	helsinki_register_nav_menus();

	// widgets
	include_once( $vendor_dir . 'helsinki/widget.php' );
	add_action( 'widgets_init', 'helsinki_widgets_init' );
	add_filter( 'dynamic_sidebar_params', 'helsinki_filter_dynamic_sidebar_params' );

	// customizer
	include_once( $vendor_dir . 'helsinki/customizer.php' );
	add_action( 'marketpress_customized_css_file', 'helsinki_customized_css_file', 10, 3 );
	add_filter( 'marketpress_customizer_default_key_color', 'helsinki_customizer_default_key_color' );
	add_filter( 'marketpress_register_customizer_sections_logo', 'helsinki_register_customizer_sections_logo' );

	// frontend only
	if ( ! is_admin() ) {

		// style
		include_once( $vendor_dir . 'helsinki/frontend/style.php' );
		add_action( 'wp_enqueue_scripts', 'helsinki_wp_enqueue_styles' );
		add_filter( 'style_loader_src', 'helsinki_filter_style_loader_src', 15, 2 );

		// general template
		include_once( $vendor_dir . 'helsinki/frontend/general.php' );

		// comments
		include_once( $vendor_dir . 'helsinki/frontend/comment.php' );
	}

	// backend only
	if ( is_admin() ) {
		// about
		include_once( $vendor_dir . 'helsinki/backend/about.php' );
		add_action( 'marketpress_about_page_overview', 'helsinki_about_page_overview' );

		// style
		include_once( $vendor_dir . 'helsinki/backend/style.php' );
		add_action( 'admin_enqueue_scripts', 'helsinki_admin_enqueue_styles' );
	}

	include_once( $vendor_dir . 'marketpress/setup.php' );
	marketpress_setup();
}