<?php
/**
 * Feature Name: About Functions for Helsinki-Backend
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com
 */

/**
 * Determinates if we need to be redirected to the
 * about page.
 *
 * @wp-hook	admin_init
 * 
 * @return	void
 */
function helsinki_maybe_redirect_to_about_page() {

	// only perform the redirect on the admin panel
	if ( ! is_admin() )
		return;

	// getting the theme-data
	$theme_data = wp_get_theme();
	$option = sanitize_title_with_dashes( $theme_data->name ) . '-' . $theme_data->version;
	$about_shown = get_option( '_mp' . $option, FALSE );
	
	// check if we are on the page
	if ( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'helsinki-theme-about' ) {
		update_option( '_mp' . $option, '1' );
		return;
	}

	if ( $about_shown == FALSE ) {
		update_option( '_mp' . $option, '1' );
		wp_safe_redirect( admin_url( 'themes.php?page=helsinki-theme-about' ) );
		exit;
	}
}

/**
 * Adds the about page for this theme and provides
 * several filters for the manipulation
 *
 * @wp-hook	admin_menu
 * 
 * @return	void
 */
function helsinki_add_about_page() {

	add_theme_page( __( 'About', 'helsinki' ), __( 'About', 'helsinki' ), 'switch_themes', 'helsinki-theme-about', 'helsinki_about_page' );
}

/**
 * Displays the about page
 *
 * @return	void
 */
function helsinki_about_page() {
	
	// getting the theme-data
	$theme_data = wp_get_theme();
	?>
	<div class="wrap about-wrap">
		<h1><?php printf( __( 'Welcome to %s', 'helsinki' ), $theme_data->name ); ?></h1>
		<div class="about-text"><?php _e( 'Thank you for downloading our theme. Enjoy your beautiful new choice!', 'helsinki' ); ?></div>
		<div class="mp-badge">Version <?php echo $theme_data->version ?></div>

		<h2 class="nav-tab-wrapper">
			<a href="<?php echo admin_url( 'themes.php?page=helsinki-theme-about' ); ?>" class="nav-tab <?php echo ! isset( $_GET[ 'tab' ] ) ? 'nav-tab-active' : ''; ?>"><?php printf( __( 'About %s', 'helsinki' ), $theme_data->name ); ?></a>
			<a href="<?php echo admin_url( 'themes.php?page=helsinki-theme-about&tab=documentation' ); ?>" class="nav-tab <?php echo isset( $_GET[ 'tab' ] ) && $_GET[ 'tab' ] == 'documentation' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Documentation', 'helsinki' ); ?></a>
			<!--a href="<?php echo admin_url( 'themes.php?page=helsinki-theme-about&tab=faq' ); ?>" class="nav-tab <?php echo isset( $_GET[ 'tab' ] ) && $_GET[ 'tab' ] == 'faq' ? 'nav-tab-active' : ''; ?>"><?php _e( 'F.A.Q.', 'helsinki' ); ?></a-->
			<a href="https://wordpress.org/support/theme/helsinki" target="_blank" class="nav-tab"><?php _e( 'Support Forum', 'helsinki' ); ?></a>
			<a href="<?php echo admin_url( 'themes.php?page=helsinki-theme-about&tab=credits' ); ?>" class="nav-tab <?php echo isset( $_GET[ 'tab' ] ) && $_GET[ 'tab' ] == 'credits' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Credits', 'helsinki' ); ?></a>
		</h2>

		<div class="changelog">
			<?php
			if ( ! isset ( $_GET[ 'tab' ] ) )
				$current_tab = 'overview';
			else
				$current_tab = $_GET[ 'tab' ];

			switch ( $current_tab ) {
				case 'documentation':
					helsinki_about_page_documentation();
					break;
				case 'credits':
					helsinki_about_page_credits();
					break;
				case 'overview':
				default:
					helsinki_about_page_overview();
					break;
			}
			?>
		</div>

	</div>
	<?php
}

/**
 * Displays the overview tab
 *
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

	<hr>
	<div class="return-to-dashboard">
		<a href="<?php echo admin_url( 'customize.php' ); ?>"><?php _e( 'Go to Themes', 'helsinki' ); ?> -> <?php _e( 'Customizer', 'helsinki' ); ?></a>
	</div>
	<?php
}


/**
 * Displays the overview tab
 *
 * @return	void
 */
function helsinki_about_page_credits() {

	?>
	<p class="about-description"><?php _e( 'Helsinki is made by the team of MarketPress. Established from the same community-oriented engagement that brought a platform like WordPress Deutschland into existence.', 'helsinki' ); ?></p>
	<h4 class="wp-people-group"><?php _e( 'The MarketPress Theme Team', 'helsinki' ); ?></h4>
	<ul class="wp-people-group " id="wp-people-group-project-leaders">
		<li class="wp-person">
			<?php echo get_avatar( 'o.schmitz@inpsyde.com', '60', null, 'Olaf Schmitz' ); ?>
			<span class="web">Olaf Schmitz</span>
			<span class="title"><?php _e( 'Founder', 'helsinki' ); ?></span>
		</li>
		<li class="wp-person">
			<?php echo get_avatar( 'n.jantschke@inpsyde.com', '60', null, 'Nick Jantschke' ); ?>
			<span class="web">Nick Jantschke</span>
			<span class="title"><?php _e( 'Designer', 'helsinki' ); ?></span>
		</li>
		<li class="wp-person">
			<?php echo get_avatar( 't.herzog@inpsyde.com', '60', null, 'Thomas Herzog' ); ?>
			<span class="web">Thomas Herzog</span>
			<span class="title"><?php _e( 'Developer', 'helsinki' ); ?></span>
		</li>
		<li class="wp-person">
			<?php echo get_avatar( 'c.huebinger@inpsyde.com', '60', null, 'Caspar H&uuml;binger' ); ?>
			<span class="web">Caspar H&uuml;binger</span>
			<span class="title"><?php _e( 'Support & Editorial', 'helsinki' ); ?></span>
		</li>
		<li class="wp-person">
			<?php echo get_avatar( 'd.kuckei@inpsyde.com', '60', null, 'Denny Kuckei' ); ?>
			<span class="web">Denny Kuckei</span>
			<span class="title"><?php _e( 'Developer & Support', 'helsinki' ); ?></span>
		</li>
		<li class="wp-person">
			<?php echo get_avatar( 't.werner@inpsyde.com', '60', null, 'Tino Werner' ); ?>
			<span class="web">Tino Werner</span>
			<span class="title"><?php _e( 'Support', 'helsinki' ); ?></span>
		</li>
		<li class="wp-person">
			<?php echo get_avatar( 'c.fuchs@inpsyde.com', '60', null, 'Christina Fuchs' ); ?>
			<span class="web">Christina Fuchs</span>
			<span class="title"><?php _e( 'Support', 'helsinki' ); ?></span>
		</li>
	</ul>
	<?php
}

/**
 * Displays the overview tab
 *
 * @return	void
 */
function helsinki_about_page_documentation() {

	?>
	<div class="mp-documentation-nav">
		<ul>
			<li>
				<a href="#helsinki-theme">Helsinki Theme</a>
				<ul>
					<li><a href="#helsinki_requirements">Minimum Requirements</a></li>
					<li><a href="#helsinki_installation">Installation</a></li>
				</ul>
			</li>
			<li>
				<a href="#settings-and-customizations">Settings and Customizations</a>
				<ul>
					<li><a href="#helsinki_navigation">Navigation</a></li>
					<li><a href="#helsinki_formats">Image Formats</a></li>
					<li><a href="#helsinki_customizer">Customizer</a></li>
					<li><a href="#helsinki_widget_areas">Widget Areas</a></li>
				</ul>
			</li>
			<li><a href="#developer-api">Developer-API</a></li>
		</ul>
	</div>

	<div class="mp-documentation">
		<h2 id="helsinki-theme">Helsinki Theme</h2>
		<p>Helsinki is a mondern WordPress theme that offers a complete API where developers can add additional plugins.</p>

		<h3 id="helsinki_requirements">Minimum Requirements</h3>
		<p>The minimum requirements are based on WordPress are as follows:</p>
		<ul>
			<li>PHP 5.2.4</li>
			<li>MySQL 5.0</li>
			<li>WordPress 4.1</li>
		</ul>

		<h3 id="helsinki_installation">Installation</h3>
		<ol>
			<li>Download the ZIP file from wordpress.org.</li>
			<li>Upload the ZIP file in the backend at Design -> Themes -> Upload to your WordPress website, OR unpack the zip file on your hard drive and upload the helsinki folder via (S)FTP to your WordPress website’s theme directory (usually wp-content/themes).</li>
			<li>Activate the theme in the WordPress backend at Design -> Themes.</li>
		</ol>
		
		<h2 id="settings-and-customizations">Settings and Customizations</h2>
		<p>The theme Helsinki refrains on purpose from complex configurations or settings. Almost everything you see within the Theme you can change by API.</p>

		<h3 id="helsinki_navigation">Navigation</h3>
		<p>You can use the WordPress menus in Kiel. After activating the theme you (and only you!) will be greeted with the following request:</p>
		<blockquote>
			<p>Ahoi, [you name]!<br />	Please create your own menu and place it on an available menu location.</p>
		</blockquote>
		<p>Just follow the link within the request and create your menus. Now you have already finished the default configuration. You can settle a main menu (above) or a meta menu (in the footer) like that. You can add menus to following areas:</p>
		<ul>
			<li><code>Header</code> - The navigation on the very top of the website</li>
			<li><code>Footer</code> - The navigation on the bottom of the website usually in the footer</li>
		</ul>

		<h3 id="helsinki_formats">Image Format</h3>
		<p>Helsinki has the ability to use the post thumbnails as parallax image backgrounds on the posts. For that you should upload these images in a high resolution. It's recommended to use 1280x800 pixels.</p>


		<h3 id="helsinki_customizer">Customizer</h3>
		The customizer is a native WordPress feature. You can find it
		<ul>
			<li>in the frontend in the admin bar by the menu item "Adaption" and</li>
			<li>in the backend in the menu bar by the item Design -> Themes -> Adaption next to the avatar of Helsinki.</li>
		</ul>
		<p>Again the theme refrains from as many options as possible. The most important setting you can change is the key color. The key color is responsible for the color scheme of your website. You can choose any color you want and with that change the colors of hyperlinks, highlights and overlays.</p>

		<h3 id="helsinki_widget_areas">Widget Areas</h3>
		<p>Helsinki offers some widget areas in the footer. You can add as many widgets there as you want to. There is also a widget area in the special offcanvas area. You can add there widgets as well.</p>

		<h3 id="developer-api">Developer API</h3>
		<p>On the surface it may seem that Helsinki does not offer a wide range of settings, but it is not like that. There is a huge amount of filters which help developers to build fascinating child themes. The developers of Helsinki tried to build all the functions of Helsinki in the API so that everything is changeable. You might want to have a look in functions.php to see where which filters are requested.</p>
		<p>A detailled developer documentation will come soon.</p>
	</div>
	<?php
}
