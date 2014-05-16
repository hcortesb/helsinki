<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package    WordPress
 * @subpackage Parallactic
 */

if ( ! have_comments() && ! comments_open() )
	return;
?>

<div class="comment-list">
	<div class="wrapper">
		<?php if ( post_password_required() ) : ?>
			<p class="nopassword">
				<?php _e( 'This post is password protected. Enter the password to view any comments.', 'PARALLACTIC_TEXTDOMAIN' ); ?>
			</p>
		<?php
			return;
		endif; // post_password_required

		if ( have_comments() ) {
			echo '<h2 id="commentheadline">';
				printf(
					_nx( '1 Comment', '%1$s Comments', get_comments_number(), 'Comments title', 'PARALLACTIC_TEXTDOMAIN' ),
					number_format_i18n( get_comments_number() )
				);
			echo '</h2>';
		}

		// comments template
		get_template_part( 'parts/comment', 'commentlist' );

		// Paginated comments. Again.
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) )
			get_template_part( 'parts/comment', 'pagination' );

		// Pings with favicons.
		get_template_part( 'parts/comment', 'pingbacklist' );
		?>

		<?php
		// comment form.
		if ( comments_open() )
			comment_form();
		?>
	</div>
</div>