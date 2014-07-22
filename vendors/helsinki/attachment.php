<?php
/**
 * Feature Name:    Attachment Helper Functions for Helsinki-Theme
 * Version:         0.9
 * Author:          Inpsyde GmbH for MarketPress.com
 * Author URI:      http://marketpress.com
 */

/**
 * Register the image sizes
 *
 * @return  void
 */
function helsinki_register_image_sizes() {

	$default_sizes = array(
		'post-thumbnail'    => array( 'width' => 1280, 'height' => 800, 'crop' => TRUE ),
	);
	$default_sizes = apply_filters( 'helsinki_image_sizes', $default_sizes );

	foreach ( $default_sizes as $id => $args )
		add_image_size( $id, $args[ 'width' ], $args[ 'height' ], $args[ 'crop' ] );
}

/**
 * Manipulates the caption shortcode of WordPress
 * to set the caption above the image
 *
 * @param   String $output
 * @param   Array $attr
 * @param   String $content
 * @return  String
 */
function helsinki_caption_shortcode( $output, $attr, $content ) {

	$output = '<figure class="wp-caption ' . $attr[ 'align' ] . '">';
	$output .= $content;
	$output .= '<figcaption class="wp-caption-text">' . $attr[ 'caption' ] . '</figcaption>';
	$output .= '</figure>';

	return $output;
}