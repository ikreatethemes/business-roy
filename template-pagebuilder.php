<?php
/**
 * Template Name: Business Roy - Full Width
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Business Roy
 */
get_header();  ?>

<div class="businessroy_wrap">
	<?php

		while ( have_posts() ) : the_post();

		    the_content();

		endwhile; // End of the loop.
	?>
</div>

<?php get_footer();