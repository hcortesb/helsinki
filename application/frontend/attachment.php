<?php
/**
 * Feature Name: MarketPress Attachment Setup
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com/
 */

/**
 * Manipulates the caption shortcode of WordPress
 * to set the caption above the image
 * 
 * @param	string $output
 * @param	array $attr
 * @param	string $content
 * @return	string
 */
function helsinki_caption_shortcode( $output, $attr, $content ) {
	
	$output = '<figure class="wp-caption ' . $attr[ 'align' ] . '">';
	$output .= $content;
	$output .= '<figcaption class="wp-caption-text">' . $attr[ 'caption' ] . '</figcaption>';
	$output .= '</figure>';

	return $output;
}
