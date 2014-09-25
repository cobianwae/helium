<?php
/**
* The main template file. Includes the loop.
*
*
* @package Helium
* @since Helium 1.0
*/
	get_header();
	/* Start the Loop */
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;
	get_footer();