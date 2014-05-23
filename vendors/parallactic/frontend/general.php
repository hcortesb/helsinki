<?php
/**
 * Feature Name:    General template stuff for Parallactic-Theme
 * Version:         0.9
 * Author:          Inpsyde GmbH for MarketPress.com
 * Author URI:      http://marketpress.com
 */

/**
 * Gets the logo
 *
 * @return  string
 */
function parallactic_get_logo() {

	// register the pre filter to bypass this function
	$pre = apply_filters( 'pre_parallactic_get_logo', FALSE );
	if ( $pre !== FALSE )
		return $pre;

	// set the default logo
	$default = '<h1 class="logo"><a href="' . get_bloginfo( 'url' ) . '">' . get_bloginfo( 'name' ) . '</a></h1>';

	// return string, by adding the default markup to the filter
	return apply_filters( 'parallactic_get_logo', $default );
}

/**
 * Adds the current blogname to the title
 *
 * @wp-hook wp_title
 *
 * @param   string $title
 * @param   string $sep
 * @param   string $seplocation
 * @return  string
 */
function parallactic_filter_wp_title( $title, $sep, $seplocation ) {

	// return just the blogname if there is
	// no title to display
	if ( empty( $title ) )
		return get_bloginfo( 'name' );

	// check the seperator location to build
	// the new title
	if ( $seplocation == 'right' )
		return $title . get_bloginfo( 'name' );
	else
		return get_bloginfo( 'name' ) . $title;
}

/**
 * Adds a standard bodyclass to the css-class
 * declaration in the tag <body>
 *
 * @wp-hook body_class
 *
 * @param   array $classes
 * @param   string $class
 * @return  array
 */
function parallactic_filter_body_class( $classes, $class ) {

	if ( ! in_array( 'parallactic-body', $classes ) )
		$classes[] = 'parallactic-body';

	return $classes;
}

/**
 * Displays the favicon
 *
 * @wp-hook wp_head
 *
 * @return  void
 */
function parallactic_the_favicon() {
	echo parallactic_get_favicon();
}

/**
 * gets the favicon markup
 *
 * @return  string
 */
function parallactic_get_favicon() {

	// the favicon name
	$favicon_name = 'favicon.ico';

	// setting the possible directories
	$asset_dir          = '/assets/img/';
	$child_theme_dir    = get_stylesheet_directory() . $asset_dir;
	$parent_theme_dir   = get_template_directory() . $asset_dir;

	// getting the favicon_uri
	$favicon_uri = '';
	if ( file_exists( $child_theme_dir . $favicon_name ) )
		$favicon_uri = get_stylesheet_directory_uri();
	else if ( file_exists( ( $parent_theme_dir . $asset_dir ) ) )
		$favicon_uri = get_template_directory_uri();

	$markup = '';
	if ( $favicon_uri !== '' )
		$markup = '<link rel="shortcut icon" href="' . $favicon_uri . $asset_dir . $favicon_name . '">';

	return apply_filters( 'parallactic_get_favicon', $markup, $favicon_uri, $asset_dir, $favicon_name );
}

/**
 * Theme info.
 *
 * @return string
 */
function parallactic_get_footer_theme_info() {

	$theme_data = wp_get_theme( get_template() );

	$author_uri = $theme_data->get( 'AuthorURI' );
	$author     = $theme_data->get( 'Author' );

	$link =  sprintf(
		_x( 'A %1$s Beta-Theme', 'Theme author link', 'PARALLACTIC_TEXTDOMAIN' ),
		'<a href="' . $author_uri . '" rel="designer">' . $author . '</a>'
	);

	$markup = sprintf(
		'<p class="mp-site-info">&#169; %1$s %2$s',
		date( 'Y' ),
		$link
	);

	return apply_filters( 'parallactic_get_footer_theme_info', $markup, $author_uri, $author );
}