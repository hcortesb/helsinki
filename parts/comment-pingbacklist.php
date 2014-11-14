<?php
/**
 * Pingbacks template
 *
 * @package    WordPress
 * @subpackage Helsinki\Parts
 */

$num = helsinki_get_count_pings();
if ( ! $num )
	return;
?>
<h2 id="pingbacks"><?php
	printf( _nx( 'One pingback', '%d pingbacks', $num, 'Pingbacks title', 'helsinki' ), $num ); ?>
</h2>
<ol class="commentlist pingbacklist">
	<?php
	// Custom callback applied adding pings as URLs with favicon.
	wp_list_comments( array (
		'type'	   => 'pings',
		'style'	   => 'ul',
		'callback' => 'helsinki_the_pings'
	) );
	?>
</ol>