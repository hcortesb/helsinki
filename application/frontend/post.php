<?php
/**
 * Feature Name: MarketPress Post Stuff
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com/
 */

/**
 * Paginated posts navigation. Used instead of
 * next_posts()/previous_posts().
 * Displays an unordered list.
 *
 * @param	array $args
 *
 * @return	string
 */
function helsinki_get_posts_pagination( Array $args = array() ) {
	global $wp_query;

	$paginated = $wp_query->max_num_pages;
	if ( $paginated < 2 )
		return '';

	$default_args   = array(
		'base' 		=> str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
		'current' 	=> max( 1, get_query_var( 'paged' ) ),
		'format' 	=> '',
		'mid_size' 	=> 2,
		'total' 	=> $wp_query->max_num_pages,
		'type' 		=> 'list',
		'prev_text'	=> sprintf(
			'<span title="%s">‹</span>',
			__( 'Previous', 'helsinki' )
		),
		'next_text'	=> sprintf(
			'<span title="%s">›</span>',
			__( 'Next', 'helsinki' )
		),
	);

	$rtn = apply_filters( 'pre_helsinki_get_posts_pagination', FALSE, $args, $default_args );
	if ( $rtn !== FALSE )
		return $rtn;

	$args = wp_parse_args( $args, $default_args );
	$args = apply_filters( 'helsinki_get_posts_pagination_args', $args );

	$output = paginate_links( $args );

	return apply_filters( 'helsinki_get_posts_pagination', $output, $args );
}


/**
 * Callback for the excerpt_more
 *
 * @wp-hook	excerpt_more
 *
 * @param	integer $length
 * @return	string
 */
function helsinki_filter_excerpt_more( $length ) {

	global $post;

	// hard space + […]
	$output  = '&#160;[&#8230;] ';
	$output .= sprintf(
		'<p><a href="%s" title="%s" class="more-link">%s</a></p>',
		get_permalink(),
		esc_attr( $post->title ),
		_x( 'Continue&#160;reading&#160;&#8230;', 'More link text', 'helsinki' )
	);

	return $output;
}
