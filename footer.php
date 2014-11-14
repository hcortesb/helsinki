<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the latest elements
 *
 * @package    WordPress
 * @subpackage Helsinki
 */
?>
	<footer>
		<div class="totop"><a href="#">^</a></div>
		<div class="wrapper">
			<?php
			// Include left footer
			get_template_part( 'parts/widget-area', 'footer-left' );
			// Include middle footer
			get_template_part( 'parts/widget-area', 'footer-middle' );
			// Include right footer
			get_template_part( 'parts/widget-area', 'footer-right' );
			?>
		</div>
	</footer>
	<section class="copyline">
		<div class="wrapper">
			<?php
			// Include right copyline
			echo helsinki_get_footer_theme_info();
			// Include left copyline
			get_template_part( 'parts/footer', 'navigation' );
			?>
		</div>
	</section>
	<?php wp_footer(); ?>
</body>
</html>