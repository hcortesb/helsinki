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

	// include helpers
	include_once( $vendor_dir . 'helsinki/helper.php' );

	// image sizes
	include_once( $vendor_dir . 'helsinki/attachment.php' );
	helsinki_register_image_sizes();
	add_filter( 'img_caption_shortcode', 'helsinki_caption_shortcode', 10, 3 );
	add_filter( 'use_default_gallery_style', '__return_false' );

	// navigation
	include_once( $vendor_dir . '/helsinki/navigation.php' );
	helsinki_register_nav_menus();

	// widgets
	include_once( $vendor_dir . 'helsinki/widget.php' );
	add_action( 'widgets_init', 'helsinki_widgets_init' );
	add_filter( 'dynamic_sidebar_params', 'helsinki_filter_dynamic_sidebar_params' );

	// customizer
	include_once( $vendor_dir . 'helsinki/customizer.php' );
	add_action( 'wp_head', 'helsinki_print_customized_css' );
	add_action( 'customize_register', 'helsinki_register_customizer_sections' );

	// frontend only
	if ( ! is_admin() ) {

		// scripts
		include_once( $vendor_dir . 'helsinki/frontend/script.php' );
		add_action( 'wp_enqueue_scripts', 'helsinki_wp_enqueue_scripts' );

		// style
		include_once( $vendor_dir . 'helsinki/frontend/style.php' );
		add_action( 'wp_enqueue_scripts', 'helsinki_wp_enqueue_styles' );
		add_filter( 'style_loader_src', 'helsinki_filter_style_loader_src', 15, 2 );

		// general template
		include_once( $vendor_dir . 'helsinki/frontend/general.php' );
		add_filter( 'wp_title', 'helsinki_filter_wp_title', 10, 3 );
		add_filter( 'body_class', 'helsinki_filter_body_class', 10, 2 );
		add_action( 'wp_head', 'helsinki_the_favicon' );


		// comments
		include_once( $vendor_dir . 'helsinki/frontend/comment.php' );

		// posts
		include_once( $vendor_dir . 'helsinki/frontend/post.php' );
		add_filter( 'excerpt_more', 'helsinki_filter_excerpt_more' );
	}

	// backend only
	if ( is_admin() ) {
		// style
		include_once( $vendor_dir . 'helsinki/backend/style.php' );
		add_action( 'admin_enqueue_scripts', 'helsinki_admin_enqueue_styles' );
	}

}