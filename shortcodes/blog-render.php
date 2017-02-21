<?php 
/*
 * Shortcode used to render a specific blog (Post or Research)
 * Usage: [postList type="post" numberOfPosts="4"]
 * The parameter type represents the type of post to list
 * The parameter numberOfPosts allows the user to limit the amount of post to show
 */

	function postLists_shortcode( $atts, $content = null ) {
		$postType = $atts['type'] ?: 'post';
		$postQuant = $atts['limit'] ?: '10';

		$args = array( 'post_type' => $postType, 'posts_per_page' => $postQuant );
		$loop = new WP_Query( $args );

		ob_start();
		echo '<div class="col-md-8">';
		while ( $loop->have_posts() ) : $loop->the_post();
		
			get_template_part('templates/template-blog', 'thumbnail');

		endwhile;
		echo '</div>';
		return ob_get_clean();
	}
	add_shortcode( 'postList', 'postLists_shortcode' );

 ?>