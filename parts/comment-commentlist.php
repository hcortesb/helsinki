<?php
/**
 * Comments template
 *
 * @package    WordPress
 * @subpackage Parallactic\Parts
 */

// We have comments, but the comment form has been closed.
if ( ! comments_open() && (int) get_comments_number() !== 0 && post_type_supports( get_post_type(), 'comments' ) ) { ?>
	<p class="nocomments"><?php _e( 'Comments are closed.', 'PARALLACTIC_TEXTDOMAIN' ); ?></p>
<?php } ?>

<?php if ( have_comments() ) : ?>
<ol class="commentlist">
	<?php
	wp_list_comments( array(
		'type'	   => 'comment',
		'style'	   => 'ul',
		'callback' => 'parallactic_the_comment'
	) );
	?>
</ol>
<?php endif; ?>