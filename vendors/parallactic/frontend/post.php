<?php
/**
 * Feature Name:    Post Functions for Parallactic-Theme
 * Version:         0.9
 * Author:          Inpsyde GmbH for MarketPress.com
 * Author URI:      http://marketpress.com
 */

/**
 * Paginated posts navigation. Used instead of
 * next_posts()/previous_posts().
 * Displays an unordered list.
 *
 * @param       array $args
 *
 * @return      string
 */
function parallactic_get_posts_pagination( Array $args = array() ) {
	global $wp_query;

	$paginated = $wp_query->max_num_pages;

	if ( $paginated < 2 )
		return '';

	$current = 1;
	$format = '&page=%#%';
	$is_permalink_structure = get_option( 'permalink_structure' );
	if ( isset( $wp_query->query_vars[ 'page' ] ) )
		$current = $wp_query->query_vars[ 'page' ];

	if ( $is_permalink_structure ){
		$current = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		$format = 'page/%#%/';
	}

	$default_args   = array(
		'base' 		=> get_pagenum_link( 1 ) . '%_%',
		'current' 	=> $current,
		'format' 	=> $format,
		'mid_size' 	=> 2,
		'end_size'	=> 2,
		'total' 	=> $paginated,
		'type' 		=> 'list',
		'prev_text'	=> sprintf(
			'<span title="%s">‹</span>',
			__( 'Previous', 'PARALLACTIC_TEXTDOMAIN' )
		),
		'next_text'	=> sprintf(
			'<span title="%s">›</span>',
			__( 'Next', 'PARALLACTIC_TEXTDOMAIN' )
		),
	);

	$rtn = apply_filters( 'pre_parallactic_get_posts_pagination', FALSE, $args, $default_args );
	if ( $rtn !== FALSE )
		return $rtn;

	$args = wp_parse_args( $args, $default_args );
	$args = apply_filters( 'parallactic_get_posts_pagination_args', $args );

	$output = paginate_links( $args );

	return apply_filters( 'parallactic_get_posts_pagination', $output, $args );
}


/**
 * Callback for the excerpt_more
 *
 * @wp-hook excerpt_more
 *
 * @param   integer $length
 * @return  string
 */
function parallactic_filter_excerpt_more( $length ) {

	global $post;

	$markup = '<p><a href="%s" title="%s" class="more-link">%s</a></p>';
	$link = get_permalink();
	$title_attr = esc_attr( $post->title );
	$title = _x( 'Continue&#160;reading&#160;&#8230;', 'More link text', 'PARALLACTIC_TEXTDOMAIN' ); // hard space + […]
	$output = '&#160;[&#8230;] ';
	$output .= sprintf(
		$markup,
		$link,
		$title_attr,
		$title
	);

	return $output;
}