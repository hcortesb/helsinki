<?php
/**
 * Pingbacks template
 *
 * @package    WordPress
 * @subpackage Parallactic\Parts
 */

$num = parallactic_get_count_pings();
if ( ! $num )
	return;
?>
<h2 id="pingbacks"><?php
	printf( _nx( 'One pingback', '%d pingbacks', $num, 'Pingbacks title', 'PARALLACTIC_TEXTDOMAIN' ), $num ); ?>
</h2>
<ol class="commentlist pingbacklist">
	<?php
	// Custom callback applied adding pings as URLs with favicon.
	wp_list_comments( array (
		'type'	   => 'pings',
		'style'	   => 'ul',
		'callback' => 'parallactic_the_pings'
	) );
	?>
</ol>