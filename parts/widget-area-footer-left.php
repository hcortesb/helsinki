<?php
/**
 * The left footer widget area
 *
 * @package    WordPress
 * @subpackage Helsinki\Parts
 */
if ( is_active_sidebar( 'footer-left' ) ) : ?>
	<aside class="widget-area widget-column column">
		<?php dynamic_sidebar( 'footer-left' ); ?>
	</aside>
<?php endif; ?>