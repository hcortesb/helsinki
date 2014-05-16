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
			<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php do_action( 'parallactic_single_page_header' ); ?>
		</header>
		<main>
			<?php do_action( 'parallactic_single_page_before_content' ); ?>
			<?php the_content(); ?>
			<?php do_action( 'parallactic_single_page_after_content' ); ?>
		</main>
	</div>
</article>