<?php
add_action( 'init', 'kc_story', 0 );
function kc_story() {
    $labels = array(
		'name' => __( 'Story', 'kc-story' ),
		'singular_name' => __( 'Story', 'kc-story' ),
		'add_new' => __( 'Add New Story', 'kc-story' ),
		'add_new_item' => __( 'Add New Story', 'kc-story' ),
		'edit_item' => __( 'Edit Story', 'kc-story' ),
		'new_item' => __( 'New Story Post Item', 'kc-story' ),
		'view_item' => __( 'View Story', 'kc-story' ),
		'search_items' => __( 'Search Story', 'kc-story' ),
		'not_found' => __( 'Nothing found', 'kc-story' ),
		'not_found_in_trash' => __( 'Nothing found in Trash', 'kc-story' ),
		'parent_item_colon' => ''
	); 	
    $args = array( 
        'labels' => $labels, // adds your $labels array from above
		  'public' => true,
		  'publicly_queryable' => true,
		  'show_ui' => true,
		  'query_var' => true,
		  'capability_type' => 'post',
		  'hierarchical' => false,
		  'rewrite' => array( 'slug' => 'story' ), // changes name in permalink structure
		  // 'menu_icon' => get_template_directory_uri().'/inc/criton-options/images/menu_icon.png',
		  'menu_position' => 4, // search WordPress Codex for menu_position parameters
		  'supports' => array( 'title', 'editor', 'thumbnail' ),
    );
    register_post_type( 'story', $args ); // adds your $args array from above
    function kc_story_custom_columns( $columns ) {
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Title",
			"image" => "Image",
			"date" => "Date"
		);
		return $columns;
	}
	add_filter( 'manage_edit-story_columns', 'kc_story_custom_columns' );
    function kc_story_custom_column_content( $column ) {
		global $post;
		$image_src = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );		
		if ( "ID" == $column ){
			echo $post->ID;
		} elseif ( "image" == $column ) {
			if($image_src){
				echo "<img id='work-img' src='$image_src' style='max-width:100px;' />";
			}
		}
	}
	add_action( 'manage_posts_custom_column', 'kc_story_custom_column_content' );
}