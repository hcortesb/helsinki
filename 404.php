<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package    WordPress
 * @subpackage Helsinki
 */

get_header();
?>
<main id="primary">
	<article>
		<header>
			<h2><?php _e( '404 - Page not found!', 'helsinki' ); ?></h2>
		</header>
		<main>
			<p><?php _e( 'Sorry, the page you are looking for does not exist. If you think, that this is a sirious problem, please contact us. Elsewise you may want to use our search?', 'helsinki' ); ?></p>
		</main>
		<footer>
			<?php get_search_form(); ?>
		</footer>
	</article>
</main>
<?php
get_footer();