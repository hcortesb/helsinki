<?php
/**
 * Feature Name: MarketPress Off-Canvas Stuff
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com/
 */

/**
 * Gets the logo
 *
 * @return	string
 */
function helsinki_get_offcanvas_logo() {

	// register the pre filter to bypass this function
	$pre = apply_filters( 'pre_helsinki_get_offcanvas_logo', FALSE );
	if ( $pre !== FALSE )
		return $pre;

	// set the default logo
	$default = '<h1 class="logo"><a href="' . esc_url( home_url() ) . '">' . get_bloginfo( 'name' ) . '</a></h1>';

	// return string, by adding the default markup to the filter
	return apply_filters( 'helsinki_get_offcanvas_logo', $default );
}

/**
 * Gets the off canvas code
 *
 * @wp-hook	wp_ajax_helsinki_get_offcanvas_code
 * @wp-hook	wp_ajax_nopriv_helsinki_get_offcanvas_code
 * 
 * @return	void
 */
function helsinki_get_offcanvas_code() {

	?>
	<section id="offcanvas">
		<div class="menu">
			<a href="#" class="trigger"><i class="fa fa-bars">&nbsp;</i></a>
			<div class="wrapper">
				<?php echo helsinki_get_offcanvas_logo(); ?>
			</div>
		</div>
		<div class="area">
			<?php if ( is_active_sidebar( 'off-canvas-area' ) ) : ?>
				<?php dynamic_sidebar( 'off-canvas-area' ); ?>
			<?php endif; ?>
		</div>
	</section>
	<?php

	// exit due to AJAX Callback
	exit;
}
