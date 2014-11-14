<?php
/**
 * Pagination for archive pages.
 *
 * Wrapping this into a template tag might seem ridiculous
 * until you need to add markup around it for whatever reason.
 *
 * @package    WordPress
 * @subpackage Helsinki\Parts
 */
?>

<nav class="pagination" role="navigation">
	<?php echo marketpress_get_posts_pagination(); ?>
</nav>