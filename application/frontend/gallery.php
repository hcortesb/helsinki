<?php
/**
 * Feature Name: MarketPress Gallery Theme Functions
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com/
 */

/**
 * This function forces every gallery to link
 * to the file instead of the attachment page.
 * This is due to some problems with the magnific
 * popup.
 *
 * @wp-hook	shortcode_atts_gallery
 *
 * @param	array $out the attributes given by the gallery
 * 
 * @return	array
 */
function helsinki_shortcode_atts_gallery( $out ) {

	$out[ 'link' ] = 'file';

	return $out;
}
