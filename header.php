<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and
 * everything up till some navigation parts
 *
 * @package    WordPress
 * @subpackage Helsinki
 */
?>
<!Doctype html>
<!--[if IE 7]><html class="no-js ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !IE]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head profile="http://gmpg.org/xfn/11">
	<title><?php wp_title( '|', TRUE, 'right' ); ?></title>
	<meta name="application-name" content="<?php bloginfo( 'blogname' ); ?>">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	<?php if ( is_singular() ) : wp_enqueue_script( 'comment-reply' ); endif; ?>
</head>
<body <?php body_class(); ?>>
	<aside id="headline">
		<div class="wrapper">
			<section class="logo">
				<?php
				/**
				 * Includes the logo template of the website
				 *
				 * The logo contains the blogname by default. It is
				 * possible to change it to a logo image via the
				 * filter `helsinki_get_logo`
				 */
				get_template_part( 'parts/header', 'logo' );
				?>
			</section>
			<section class="navigation">
				<?php
				/**
				 * Includes the header navigation template.
				 *
				 * A header navigation typically contains the main
				 * menu of the website
				 */
				get_template_part( 'parts/header', 'navigation' );
				?>
			</section>
		</div>
	</aside>
	<?php
	/**
	 * Includes the custom header of the theme
	 */
	get_template_part( 'parts/header', 'custom-header' );
	?>