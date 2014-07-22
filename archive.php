<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Fourteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
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