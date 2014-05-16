<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @package    WordPress
 * @subpackage Parallactic
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
		get_template_part( 'parts/single', 'content' );
		comments_template();
		?>
	<?php endwhile; endif; ?>
</main>
<?php
get_footer();