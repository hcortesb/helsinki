<?php
/**
 * Custom Header Stuff
 *
 * @package    WordPress
 * @subpackage Helsinki\Parts
 */

if ( ! is_front_page() && ! is_home() )
	return;

// load the header, but keep the things clean
$custom_header = get_custom_header();
if ( empty( $custom_header->url ) )
	return;
?>

<header>
	<div class="wrapper">
		<div class="header-text-container">
			<h1><a href="<?php bloginfo( 'url' ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			<div id="description"><?php bloginfo( 'description' ); ?></div>
		</div>
	</div>
</header>