<?php
/**
 * Feature Name: Attachment Helper Functions for Helsinki-Theme
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com
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
