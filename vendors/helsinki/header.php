<?php
/**
 * Feature Name:    Custom Header Stuff
 * Version:         0.9
 * Author:          Inpsyde GmbH for MarketPress.com
 * Author URI:      http://marketpress.com
 */

/**
 * Set up the WordPress core custom header settings.
 *
 * @uses helsinki_header_style()
 * @uses helsinki_admin_header_style()
 * @uses helsinki_admin_header_image()
 *
 * @return void
 */
function helsinki_custom_header_setup() {
	/**
	 * Filter Helsinki custom-header support arguments.
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type bool   $header_text            Whether to display custom header text. Default false.
	 *     @type int    $width                  Width in pixels of the custom header image. Default 1280.
	 *     @type int    $height                 Height in pixels of the custom header image. Default 800.
	 *     @type bool   $flex_height            Whether to allow flexible-height header images. Default true.
	 *     @type string $admin_head_callback    Callback function used to style the image displayed in
	 *                                          the Appearance > Header screen.
	 *     @type string $admin_preview_callback Callback function used to create the custom header markup in
	 *                                          the Appearance > Header screen.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'helsinki_custom_header_args', array(
		'width'                  => 1280,
		'height'                 => 800,
		'default-text-color'     => 'fff',
		'wp-head-callback'       => 'helsinki_header_style',
		'admin-head-callback'    => 'helsinki_admin_header_style',
		'admin-preview-callback' => 'helsinki_admin_header_image',
	) ) );
}

/**
 * Styles the header image and text displayed on the blog
 *
 * @see helsinki_custom_header_setup().
 *
 * @return void
 */
function helsinki_header_style() {

	// load the header, but keep the things clean
	$custom_header = get_custom_header();
	if ( empty( $custom_header->url ) )
		return;
	?>
	<style type="text/css" id="helsinki-header-css">
		body > header {
			color: #<?php echo get_header_textcolor(); ?>;
			height: <?php echo $custom_header->height; ?>px;
			max-height: <?php echo $custom_header->height; ?>px;
			background: url(<?php echo $custom_header->url; ?>) 50% 0 no-repeat fixed;
			background-size: cover !important;
		}

		body > header a {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	</style>
	<?php
}

/**
 * Style the header image displayed on the Appearance > Header screen.
 *
 * @see helsinki_custom_header_setup().
 *
 * @return void
 */
function helsinki_admin_header_style() {
	?>
	<style type="text/css" id="helsinki-header-css">
		#headimg {
			text-align: center;
			font-family: 'Open Sans Condensed', sans-serif;
		}

		#headimg .header-text-container {
			padding-top: 25%;
		}

		#headimg a {
			text-decoration: none;
		}

		#headimg h1 {
			margin: 10px 0;
			font-size: 50px;
			font-weight: 300;
			text-shadow: 2px 1px 2px rgba(150, 150, 150, 0.75);
		}

		#headimg #desc {
			font-size: 25px;
			text-shadow: 2px 1px 2px rgba(150, 150, 150, 0.75);
		}
	</style>
	<?php
}

/**
 * Create the custom header image markup displayed on the Appearance > Header screen.
 *
 * @see helsinki_custom_header_setup().
 *
 * @return void
 */
function helsinki_admin_header_image() {

	// load the custom header stlye
	$custom_header = get_custom_header();
	$header_image_style = 'background-image:url(' . esc_url( get_header_image() ) . ');';
	if ( $custom_header->width )
		$header_image_style .= 'max-width:' . $custom_header->width . 'px;';
	if ( $custom_header->height )
		$header_image_style .= 'height:' . $custom_header->height . 'px;';

	?>
	<div id="headimg" style="<?php echo $header_image_style; ?>">
		<div class="header-text-container displaying-header-text">
			<?php
			if ( display_header_text() )
				$style = ' style="color:#' . get_header_textcolor() . ';"';
			else
				$style = ' style="display:none;"';
			?>
			<h1><a id="name" class="displaying-header-text" <?php echo $style; ?> onclick="return false;" href="<?php bloginfo( 'url' ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			<div id="desc" class="displaying-header-text" <?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		</div>
	</div>
	<?php
}