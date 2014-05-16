<?php
/**
 * The article
 *
 * @package    WordPress
 * @subpackage Parallactic\Parts
 */

?>

<article <?php post_class(); ?>>
	<?php
	/**
	 * Include the article thumbnail
	 */
	get_template_part( 'parts/article', 'thumbnail' );
	?>
	<div class="wrapper">
		<header>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php
			/**
			 * Include the article meta
			 */
			get_template_part( 'parts/article', 'meta' );
			?>
			<?php do_action( 'parallactic_archive_post_header' ); ?>
		</header>
		<main>
			<?php do_action( 'parallactic_archive_post_before_content' ); ?>
			<?php the_excerpt(); ?>
			<?php do_action( 'parallactic_archive_post_after_content' ); ?>
		</main>
		<footer>
			<?php
			/**
			 * Include the article comment count
			 */
			get_template_part( 'parts/article', 'comment-count' );
			?>
			<?php do_action( 'parallactic_archive_post_footer' ); ?>
		</footer>
	</div>
</article>