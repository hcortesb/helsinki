<?php
/**
 * The middle footer widget area
 *
 * @package    WordPress
 * @subpackage Helsinki\Parts
 */
if ( is_active_sidebar( 'footer-middle' ) ) : ?>
	<aside class="widget-area widget-column column">
		<?php dynamic_sidebar( 'footer-middle' ); ?>
	</aside>
<?php endif; ?>