<?php
/**
 * Parallactic functions and definitions
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
 * @subpackage Parallactic
 */

add_action( 'after_setup_theme', 'parallactic_setup', 0 );
/**
 * Callback on theme_init
 *
 * @wp-hook after_setup_theme
 *
 * @return  Void
 */
function parallactic_setup() {

	$vendor_dir = dirname( __FILE__ ) . '/vendors/';

	// localization
	load_theme_textdomain( 'PARALLACTIC_TEXTDOMAIN', get_template_directory() . '/languages' );

	// custom header
	include_once( $vendor_dir . 'parallactic/header.php' );
	parallactic_custom_header_setup();

	// theme support
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'  ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );

	// include helpers
	include_once( $vendor_dir . 'parallactic/helper.php' );

	// image sizes
	include_once( $vendor_dir . 'parallactic/attachment.php' );
	parallactic_register_image_sizes();
	add_filter( 'img_caption_shortcode', 'parallactic_caption_shortcode', 10, 3 );
	add_filter( 'use_default_gallery_style', '__return_false' );

	// navigation
	include_once( $vendor_dir . '/parallactic/navigation.php' );
	parallactic_register_nav_menus();

	// widgets
	include_once( $vendor_dir . 'parallactic/widget.php' );
	add_action( 'widgets_init', 'parallactic_widgets_init' );
	add_filter( 'dynamic_sidebar_params', 'parallactic_filter_dynamic_sidebar_params' );

	// frontend only
	if ( ! is_admin() ) {

		// scripts
		include_once( $vendor_dir . 'parallactic/frontend/script.php' );
		add_action( 'wp_enqueue_scripts', 'parallactic_wp_enqueue_scripts' );

		// style
		include_once( $vendor_dir . 'parallactic/frontend/style.php' );
		add_action( 'wp_enqueue_scripts', 'parallactic_wp_enqueue_styles' );
		add_filter( 'style_loader_src', 'parallactic_filter_style_loader_src', 15, 2 );

		// general template
		include_once( $vendor_dir . 'parallactic/frontend/general.php' );
		add_filter( 'wp_title', 'parallactic_filter_wp_title', 10, 3 );
		add_filter( 'body_class', 'parallactic_filter_body_class', 10, 2 );
		add_action( 'wp_head', 'parallactic_the_favicon' );


		// comments
		include_once( $vendor_dir . 'parallactic/frontend/comment.php' );

		// posts
		include_once( $vendor_dir . 'parallactic/frontend/post.php' );
		add_filter( 'excerpt_more', 'parallactic_filter_excerpt_more' );
	}

	// backend only
	if ( is_admin() ) {
		// style
		include_once( $vendor_dir . 'parallactic/backend/style.php' );
		add_action( 'admin_enqueue_scripts', 'parallactic_admin_enqueue_styles' );
	}
}