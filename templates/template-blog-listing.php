<?php
/**
 * Template Name: Blog Listing Template
 */

// check if the repeater field has rows of data

	if( have_rows('modules_list') ):

	  // loop through the rows of data
	    while ( have_rows('modules_list') ) : the_row();
	       $postID = get_sub_field('module');
	       get_template_part('single', 'module');
	    endwhile;
	else :
	    // no rows found
	endif;

	get_template_part('templates/template-blog-post', 'list');
	
?>
