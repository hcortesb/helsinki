<?php
/**
 * The article thumbnail
 *
 * @package    WordPress
 * @subpackage Helsinki\Parts
 */
?>
<?php if ( has_post_thumbnail() ) :
	$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
	$image = wp_get_attachment_image_src( $post_thumbnail_id, 'post-thumbnail', FALSE );
	?>
	<div class="post-thumbnail" style="background: url(<?php echo $image[ 0 ]; ?>) 50% 0 no-repeat fixed;background-size: cover !important;">&nbsp;</div>
<?php endif; ?>