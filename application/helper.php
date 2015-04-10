<?php
/**
 * Feature Name: MarketPress Helper Files
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com/
 */

/**
 * Gets the specific asset directory url
 *
 * @param	string $path the relative path to the wanted subdirectory. If
 *				no path is selected, the root asset directory will be returned
 * @return	string the url of the marketpress asset directory
 */
function helsinki_get_asset_directory_url( $path = '' ) {

	// set base url
	$helsinki_assets_url = get_template_directory_uri() . '/assets/';
	if ( $path != '' )
		$helsinki_assets_url .= $path . '/';
	return $helsinki_assets_url;
}

/**
 * Gets the specific asset directory path
 *
 * @param	string $path the relative path to the wanted subdirectory. If
 *				no path is selected, the root asset directory will be returned
 * @return	string the url of the marketpress asset directory
 */
function helsinki_get_asset_directory( $path = '' ) {

	// set base url
	$helsinki_assets = get_template_directory() . '/assets/';
	if ( $path != '' )
		$helsinki_assets .= $path . '/';
	return $helsinki_assets;
}

/**
 * Simple counter for repeating elements.
 *
 * @param	string $name
 * @return	int
 */
function helsinki_get_counter( $name ) {

	static $counters = array ();

	if ( ! isset ( $counters[ $name ] ) )
		$counters[ $name ] = 0;

	$counters[ $name ] += 1;

	return $counters[ $name ];
}

/**
 * getting the Script and Style suffix for Kiel-Theme
 * Adds a conditional ".min" suffix to the file name when WP_DEBUG is NOT set to TRUE.
 *
 * @return	string
 */
function helsinki_get_script_suffix() {

	$script_debug = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
	$suffix = $script_debug ? '' : '.min';

	return $suffix;
}

/**
 * Functions which returns all supported Social-icons for the Customizer
 *
 * @return	array
 */
function helsinki_get_social_medias() {

	$settings = array();

	$settings[ 'twitter' ] = array(
		'label'      => __( 'Twitter', 'helsinki' ),
		'icon'       => helsinki_get_icon( 'twitter' ),
		'share_link' => '//twitter.com/share?url=%s'
	);

	$settings[ 'facebook' ] = array(
		'label'      => __( 'Facebook', 'helsinki' ),
		'icon'       => helsinki_get_icon( 'facebook' ),
		'share_link' => '//www.facebook.com/sharer.php?u=%s'
	);

	$settings[ 'google' ] = array(
		'label'      => __( 'Google+', 'helsinki' ),
		'icon'       => helsinki_get_icon( 'google-plus' ),
		'share_link' => '//plusone.google.com/_/+1/confirm?hl=de&url=%s'
	);

	$settings[ 'pinterest' ] = array(
		'label'      => __( 'Pinterest', 'helsinki' ),
		'icon'       => helsinki_get_icon( 'pinterest' ),
		'share_link' => '//pinterest.com/pin/create/button/?url=%s'
	);

	$settings[ 'instagram' ] = array(
		'label' => __( 'Instagram', 'helsinki' ),
		'icon'  => helsinki_get_icon( 'instagram' ),
	);

	$settings[ 'xing' ] = array(
		'label' => __( 'Xing', 'helsinki' ),
		'icon'  => helsinki_get_icon( 'xing' ),
	);

	$settings[ 'github' ] = array(
		'label' => __( 'GitHub', 'helsinki' ),
		'icon'  => helsinki_get_icon( 'github' ),
	);

	$settings[ 'youtube' ] = array(
		'label' => __( 'Youtube', 'helsinki' ),
		'icon'  => helsinki_get_icon( 'youtube' ),
	);

	$settings[ 'stackoverflow' ] = array(
		'label' => __( 'Stack-Overflow', 'helsinki' ),
		'icon'  => helsinki_get_icon( 'stack-overflow' ),
	);


	$settings[ 'wordpress' ] = array(
		'label' => __( 'WordPress.org', 'helsinki' ),
		'icon'  => helsinki_get_icon( 'wordpress' ),
	);

	return apply_filters( 'helsinki_get_social_medias', $settings );
}

/**
 * Helper function to display the Social Icons from customizer
 *
 * @param	array $args
 * @return	string
 */
function helsinki_get_social_channel_icons( array $args = array() ) {

	$default_args = array(
		'before'      => '<aside class="social-share" id="site-social-icons">',
		'after'       => '</aside>',
		'link'        => '<a href="%1$s" title="%2$s" class="social-share-link social-share-link-%3$s">%4$s</a>',
		'link_before' => '',
		'link_after'  => '',
	);

	$rtn = apply_filters( 'pre_helsinki_customizer_get_social_channel_icons', FALSE, $args, $default_args );
	if ( $rtn !== FALSE )
		return $rtn;

	$args = wp_parse_args( $args, $default_args );
	$args = apply_filters( 'helsinki_customizer_get_social_channel_icons_args', $args );

	$markup = '';
	$links = array();

	$social_icons = helsinki_get_social_medias();
	foreach ( $social_icons as $theme_mod => $icon ) {

		$link = get_theme_mod( $theme_mod, '' );

		if ( $link !== '' ) {

			$markup .=  $args[ 'link_before' ];
			$markup .= sprintf(
				$args[ 'link' ],
				esc_url( $link ),
				esc_attr( $icon[ 'label' ] ),
				$theme_mod,
				$icon[ 'icon' ]
			);
			$markup .= $args[ 'link_after' ];

			$links[ $theme_mod ] = $link;
		}
	}

	if ( $markup !== '' )
		$markup = $args[ 'before' ] . $markup . $args[ 'after' ];

	return apply_filters( 'helsinki_customizer_get_social_channel_icons', $markup, $social_icons, $links );
}


/**
 * Helper Function to print the Font-Awesome-Icons in Theme-Templates
 *
 * @param	string $icon
 * @param	array $classes
 * @return	string
 */
function helsinki_get_icon( $icon, Array $classes = array() ) {
	$markup = '<i class="fa fa-%1$s %2$s" aria-hidden="true"></i>';
	$classes_string = implode( ' ', $classes );
	$output = sprintf(
		$markup,
		$icon,
		$classes_string
	);
	return apply_filters( 'helsinki_get_icon', $output, $icon, $classes, $markup );
}

/**
 * converts a hex-color-code to rgb values
 *
 * @param	string $hex
 * @return	array
 */
function helsinki_hex_to_rgb( $hex ) {

	// remove #
	$hex = str_replace("#", "", $hex);

	// do we have short hex?
	if ( strlen( $hex ) == 3 ) {
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
		$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
		$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	} else {
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	}

	$rgb = array( $r, $g, $b );
	return $rgb;
}
