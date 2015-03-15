<?php
/**
 * Feature Name: Comment Functions for Helsinki-Theme
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com
 */

/**
 * Callback for text comments.
 *
 * @param  object $comment
 * @param  array  $args
 * @param  int    $depth
 * @return void
 */
function helsinki_the_comment( $comment, Array $args = array(), $depth = 0 ) {
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
						        'helsinki'
					        ),
					        get_comment_date(),
					        get_comment_time()
						)
					);
				?>
			</div>
			<?php if ( $comment->comment_approved === '0' ) : ?>
				<p class="comment-awaiting-moderation alert-info"><?php
					_e( 'Your comment is awaiting moderation.', 'helsinki' );
					?></p>
			<?php endif; ?>
			<div class="comment-text">
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
					     'reply_text'=> __( 'Reply to this comment', 'helsinki' ),
					     'depth' 	=> $depth,
					     'max_depth'	=> 999
					)
				)
			);
			?>
		</div>
	<?php
}
