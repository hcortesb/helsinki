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

	$application_dir = dirname( __FILE__ ) . '/application/';

	// localization
	load_theme_textdomain( 'helsinki', get_template_directory() . '/languages' );

	// helper
	include_once( $application_dir . 'helper.php' );

	// custom header
	include_once( $application_dir . 'header.php' );
	helsinki_custom_header_setup();

	// theme support
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'  ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );

	// image sizes
	include_once( $application_dir . 'attachment.php' );
	helsinki_register_image_sizes();

	// navigation
	include_once( $application_dir . 'navigation.php' );
	helsinki_register_nav_menus();

	// widgets
	include_once( $application_dir . 'widget.php' );
	add_action( 'widgets_init', 'helsinki_widgets_init' );
	add_filter( 'dynamic_sidebar_params', 'helsinki_filter_dynamic_sidebar_params' );

	// customizer
	include_once( $application_dir . 'customizer.php' );
	add_action( 'helsinki_customized_css_file', 'helsinki_customized_css_file', 10, 4 );
	add_filter( 'helsinki_customizer_default_key_color', 'helsinki_customizer_default_key_color' );
	add_filter( 'helsinki_register_customizer_sections_logo', 'helsinki_register_customizer_sections_logo' );
	add_action( 'customize_register', 'helsinki_register_customizer_sections' );
	add_action( 'customize_preview_init', 'helsinki_save_custom_css_file' );
	add_action( 'customize_save_after', 'helsinki_save_custom_css_file' );

	// Off Canvas
	include_once( $application_dir . 'offcanvas.php' );
	add_filter( 'wp_ajax_helsinki_get_offcanvas_code', 'helsinki_get_offcanvas_code' );
	add_filter( 'wp_ajax_nopriv_helsinki_get_offcanvas_code', 'helsinki_get_offcanvas_code' );

	// frontend only
	if ( ! is_admin() ) {

		// general template
		include_once( $application_dir . 'frontend/general.php' );
		add_filter( 'wp_title', 'helsinki_filter_wp_title', 10, 3 );
		add_filter( 'body_class', 'helsinki_filter_body_class', 10, 2 );
		add_action( 'wp_head', 'helsinki_the_favicon' );

		// Standard Scripts
		include_once( $application_dir . 'frontend/script.php' );
		add_action( 'wp_enqueue_scripts', 'helsinki_wp_enqueue_scripts' );

		// style
		include_once( $application_dir . 'frontend/style.php' );
		add_action( 'wp_enqueue_scripts', 'helsinki_wp_enqueue_styles' );
		add_filter( 'style_loader_src', 'helsinki_filter_style_loader_src', 15, 2 );

		// posts
		include_once( $application_dir . 'frontend/post.php' );
		add_filter( 'excerpt_more', 'helsinki_filter_excerpt_more' );

		// gallery
		include_once( $application_dir . 'frontend/gallery.php' );
		add_filter( 'shortcode_atts_gallery', 'helsinki_shortcode_atts_gallery' );

		// attachment standards
		include_once( $application_dir . 'frontend/attachment.php' );
		add_filter( 'img_caption_shortcode', 'helsinki_caption_shortcode', 10, 3 );
		add_filter( 'use_default_gallery_style', '__return_false' );

		// ping
		include_once( $application_dir . 'frontend/ping.php' );

		// comments
		include_once( $application_dir . 'frontend/comment.php' );
	}

	// backend only
	if ( is_admin() ) {

		// about
		include_once( $application_dir . 'backend/about.php' );
		add_action( 'admin_menu', 'helsinki_add_about_page', 100 );
		add_action( 'admin_init', 'helsinki_maybe_redirect_to_about_page' );

		// style
		include_once( $application_dir . 'backend/style.php' );
		add_action( 'admin_enqueue_scripts', 'helsinki_admin_enqueue_styles' );

		// Admin Scripts
		include_once( $application_dir . 'backend/script.php' );
		add_action( 'admin_enqueue_scripts', 'helsinki_admin_enqueue_scripts' );

	}
}
