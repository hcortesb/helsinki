<?php
/**
 * The article
 *
 * @package    WordPress
 * @subpackage Helsinki\Parts
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
			<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php
			/**
			 * Include the article meta
			 */
			get_template_part( 'parts/article', 'meta' );
			?>
			<?php do_action( 'helsinki_single_post_header' ); ?>
		</header>
		<main>
			<?php do_action( 'helsinki_single_post_before_content' ); ?>
			<?php the_content(); ?>
			<?php
			/**
			 * This is where post content can optionally be sliced
			 * into pages with the <!--nextpage--> tag.
			 */
			wp_link_pages(
				array(
					'before' => '<nav class="site-page-link">' . _x( '<span>Pages:</span>', 'Prefix for content pagination', 'helsinki' ),
					'after'  => '</nav>'
				)
			);
			?>
			<?php do_action( 'helsinki_single_post_after_content' ); ?>
		</main>
		<footer>
			<?php previous_post_link( '<span class="alignleft">&laquo; %link</span>' ); ?>
			<?php next_post_link( '<span class="alignright">%link &raquo;</span>' ); ?>
			<?php do_action( 'helsinki_single_post_footer' ); ?>
		</footer>
	</div>
</article>
