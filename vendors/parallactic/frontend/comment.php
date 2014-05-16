<?php
/**
 * Feature Name:    Comment Functions for Parallactic-Theme
 * Version:         0.9
 * Author:          Inpsyde GmbH for MarketPress.com
 * Author URI:      http://marketpress.com
 */

/**
 * Callback for text comments.
 *
 * @param  object $comment
 * @param  array  $args
 * @param  int    $depth
 * @return void
 */
function parallactic_the_comment( $comment, Array $args = array(), $depth = 0 ) {
	?>
	<li itemprop="reviews" itemscope="" itemtype="http://schema.org/Review" <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<div class="comment_container">
			<div class="comment-author">
				<?php
					echo get_avatar( $comment );
					printf( '<p class="meta fn"><strong itemprop="author">%s</strong></p>', get_comment_author_link() );
					printf( '<a href="%1$s"><time itemprop="datePublished" datetime="%2$s">%3$s</time></a>',
				        esc_url( get_comment_link( $comment->comment_ID ) ),
				        get_comment_time( 'c' ),
				        sprintf(
					        _x(
						        '%1$s @ %2$s',
						        '1: date, 2: time for comment meta',
						        'PARALLACTIC_TEXTDOMAIN'
					        ),
					        get_comment_date(),
					        get_comment_time()
						)
					);
				?>
			</div>
			<?php if ( $comment->comment_approved === '0' ) : ?>
				<p class="comment-awaiting-moderation alert-info"><?php
					_e( 'Your comment is awaiting moderation.', 'PARALLACTIC_TEXTDOMAIN' );
					?></p>
			<?php endif; ?>
			<div class="comment-text">

				<?php if ( get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) {
					$rating = get_comment_meta( $comment->comment_ID, 'rating', TRUE );
					$rating = esc_attr( $rating );
					if ( $rating ) { ?>
					<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( __( 'Rated %d out of 5', 'woocommerce' ), $rating ); ?>">
						<span style="width:<?php echo ( intval( get_comment_meta( $GLOBALS[ 'comment' ]->comment_ID, 'rating', TRUE ) ) / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo intval( get_comment_meta( $GLOBALS[ 'comment' ]->comment_ID, 'rating', TRUE ) ); ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?></span>
					</div>
					<?php } ?>
				<?php } ?>

				<?php comment_text(); ?>
			</div>
			<br class="clearfix">
			<?php
			/**
			 * Omnipresent reply link.
			 *
			 * Adjust to a defined maximal depth by setting
			 * 'max_depth' => $args['max_depth'].
			 */
			comment_reply_link(
				array_merge(
					$args,
					array(
					     'reply_text'=> __( 'Reply to this comment', 'PARALLACTIC_TEXTDOMAIN' ),
					     'depth' 	=> $depth,
					     'max_depth'	=> 999
					)
				)
			);
			?>
		</div>
	<?php
}

/**
 * Count amount of pingbacks + trackbacks for a post.
 *
 * @link    http://wordpress.stackexchange.com/a/96596/23011
 *
 * @param   int $post_id Post ID for comment query. Default is current post.
 * @return  int
 */
function parallactic_get_count_pings( $post_id = NULL ) {
	global $wp_query;

	$pings	  = 0;
	$comments = FALSE;

	if ( $post_id !== NULL ) {
		$comments = get_comments( array (
			'post_id' => $post_id, # Note: post_ID will not work!
			'status'  => 'approve'
		) );
	} else if ( ! empty ( $wp_query->comments ) ) {
		$comments = $wp_query->comments;
	}

	if ( ! $comments )
		return 0;

	foreach ( $comments as $comment )
		if ( in_array ( $comment->comment_type, array ( 'pingback', 'trackback' ) ) )
			$pings += 1;

	return $pings;
}

/**
 * Callback for wp_list_comments( array ( 'type' => 'pings' ) ); pings is pingback and trackback together
 *
 * @link    http://wordpress.stackexchange.com/a/96596/23011
 * @link    http://codex.wordpress.org/Function_Reference/wp_list_comments#Parameters
 *
 * @param   object $comment
 * @return  void
 */
function parallactic_the_pings( $comment ) {

	$url	    = esc_url( $comment->comment_author_url );
	$icon_args  = array( 'url' => $url );
	$icon	    = parallactic_get_external_favicon( $icon_args );
	$name	    = esc_html( $comment->comment_author );

	printf(
		'<li><a href="%s">%s %s</a>',
		$url,
		$icon,
		$name
	);
}

/**
 * Get an img element for a favicon from Google.
 *
 * @link    http://wordpress.stackexchange.com/a/96596/23011
 *
 * @param   array $args array( 'url' => string, 'class' => string, 'size' => integer, 'alt' => string )
 * @return  string
 */
function parallactic_get_external_favicon( Array $args = array()  ) {

	$default_args = array(
		'url'   => '',
		'class' => 'icon',
		'size'  =>  '16',
		'alt'   => ''
	);

	$rtn = apply_filters( 'pre_parallactic_get_external_favicon', FALSE, $args, $default_args );
	if ( $rtn !== FALSE )
		return $rtn;

	$args = wp_parse_args( $args, $default_args );
	$args = apply_filters( 'parallactic_get_external_favicon_args', $args );

	$output = '';

	if ( $args[ 'url' ] !== '' ) {
		$host	        = parse_url( $args[ 'url' ],  PHP_URL_HOST );
		$icon_url       = 'https://plus.google.com/_/favicon?domain=' . $host;

		$output   = sprintf(
			'<img class="%s" width="%d" height="%d" alt="%s" src="%s" />',
			$args[ 'class' ],
			esc_attr( $args[ 'size' ] ),
			esc_attr( $args[ 'size' ] ),
			esc_attr( $args[ 'alt' ] ),
			$icon_url
		);
	}

	return apply_filters( 'parallactic_get_external_favicon', $output, $args );
}