<?php
/**
 * Pagination for comments
 *
 * @package    Duesseldorf\Parts
 */
?>

<nav class="site-pagination" id="site-pagination-comments" role="navigation">
	<span class="alignleft">
		<?php previous_comments_link( __( '&laquo; Older Comments', 'helsinki' ) ); ?>
	</span>
	<span class="alignright">
		<?php next_comments_link( __( 'Newer Comments &raquo;', 'helsinki' ) ); ?>
	</span>
	<br class="clearfix">
</nav>
