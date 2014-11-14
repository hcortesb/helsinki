<?php
/**
 * The template for displaying Author archive pages
 *
 * @package    WordPress
 * @subpackage Helsinki
 */

get_header();
?>
<main id="primary">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php
		/**
		  * Include a template part specific to the Post Format.
		  *
		  * @link http://codex.wordpress.org/Post_Formats
		  */
		get_template_part( 'parts/archive', 'content' );
		?>
	<?php endwhile; endif; ?>

	<?php
	/**
	 * Include query pagination.
	 */
	get_template_part( 'parts/archive', 'pagination' );
	?>
</main>
<?php
get_footer();