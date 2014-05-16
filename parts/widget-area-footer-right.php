<?php
/**
 * The right footer widget area
 *
 * @package    WordPress
 * @subpackage Parallactic\Parts
 */
if ( is_active_sidebar( 'footer-right' ) ) : ?>
	<aside class="widget-area widget-column column">
		<?php dynamic_sidebar( 'footer-right' ); ?>
	</aside>
<?php endif; ?>