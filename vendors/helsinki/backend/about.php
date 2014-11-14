<?php
/**
 * Feature Name:    About Functions for Helsinki-Backend
 * Version:         0.9
 * Author:          Inpsyde GmbH for MarketPress.com
 * Author URI:      http://marketpress.com
 */


/**
 * Displays the about page
 * 
 * @wp-hook	marketpress_about_page_overview
 * @return	void
 */
function helsinki_about_page_overview() {
	?>
	<div class="feature-section col two-col">
		<div class="col-1">
			<h3><?php _e( 'Big images', 'helsinki' ); ?></h3>
			<p><?php _e( 'The theme Helsinki offers not only a custom header it also comes with the ability for basic parallactic behaviour. So the thumbnails for your articles are no thumbnails any more. Instead they fill the whole background.', 'helsinki' ); ?></p>
		</div>
		<div class="col-2 last-feature">
			<img src="<?php echo get_template_directory_uri() . '/assets/img/about-01.png'; ?>">
		</div>
	</div>
	<hr>
	<div class="feature-section col two-col">
		<div class="col-1">
			<img src="<?php echo get_template_directory_uri() . '/assets/img/about-02.png'; ?>">
		</div>
		<div class="col-2 last-feature">
			<h3><?php _e( 'Off-Canvas Widget-Area', 'helsinki' ); ?></h3>
			<p><?php _e( 'Off-Canvas is a technology to hide Elements from the website outside of the viewport. It is visible for mobile devices only. Helsinki offers a flexible widgetarea where you are able to place any widget you want.', 'helsinki' ); ?></p>
		</div>
	</div>
	<hr>
	<div class="feature-section col two-col">
		<div class="col-1">
			<h3><?php _e( 'Flexible Footer', 'helsinki' ); ?></h3>
			<p><?php _e( 'The footer of Helsinki comes with several widget areas, navigations and pagination elements.', 'helsinki' ); ?></p>
		</div>
		<div class="col-2 last-feature">
			<img src="<?php echo get_template_directory_uri() . '/assets/img/about-03.png'; ?>">
		</div>
	</div>
	<hr>
	<div class="feature-section col two-col">
		<div class="col-1">
			<img src="<?php echo get_template_directory_uri() . '/assets/img/about-04.gif'; ?>">
		</div>
		<div class="col-2 last-feature">
			<h3><?php _e( 'Ready for the customizer', 'helsinki' ); ?></h3>
			<p><?php _e( 'With the customizer comes the magic. With Helsinki you can change the key color, set a logo and you are able to add your social network channels.', 'helsinki' ); ?></p>
		</div>
	</div>
	<?php
}