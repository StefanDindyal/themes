<?php
add_action( 'init', 'kc_character', 0 );
function kc_character() {
    $labels = array(
		'name' => __( 'Characters', 'kc-character' ),
		'singular_name' => __( 'Character', 'kc-character' ),
		'add_new' => __( 'Add New Character', 'kc-character' ),
		'add_new_item' => __( 'Add New Character', 'kc-character' ),
		'edit_item' => __( 'Edit Character', 'kc-character' ),
		'new_item' => __( 'New Character Post Item', 'kc-character' ),
		'view_item' => __( 'View Character', 'kc-character' ),
		'search_items' => __( 'Search Character', 'kc-character' ),
		'not_found' => __( 'Nothing found', 'kc-character' ),
		'not_found_in_trash' => __( 'Nothing found in Trash', 'kc-character' ),
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
		  'rewrite' => array( 'slug' => 'character' ), // changes name in permalink structure
		  // 'menu_icon' => get_template_directory_uri().'/inc/criton-options/images/menu_icon.png',
		  'menu_position' => 4, // search WordPress Codex for menu_position parameters
		  'supports' => array( 'title', 'editor', 'thumbnail' ),
    );
    register_post_type( 'character', $args ); // adds your $args array from above
    function kc_characters_custom_columns( $columns ) {
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Title",
			"characterimage" => "Character",
			"date" => "Date"
		);
		return $columns;
	}
	add_filter( 'manage_edit-character_columns', 'kc_characters_custom_columns' );
    function kc_characters_custom_column_content( $column ) {
		global $post;
		$image_src = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );		
		if ( "ID" == $column ){
			echo $post->ID;
		} elseif ( "characterimage" == $column ) {
			if($image_src){
				echo "<img id='work-img' src='$image_src' style='max-width:100px;' />";
			}
		}
	}
	add_action( 'manage_posts_custom_column', 'kc_characters_custom_column_content' );
    function kc_characters_meta($current_screen){
		if ( 'character' == $current_screen->post_type && 'post' == $current_screen->base ) {
			$prefix = 'kc_';			
			$fields = array(
				array(
				    'label' => 'Character Full',
				    'desc'  => '',
				    'id'    => $prefix.'character_full',			
				    'type'  => 'image'
				)				
			);
			$character_box = new custom_add_meta_box( 'character_box', 'Character Options', $fields, 'character', true );
		}
	}
	add_action( 'current_screen', 'kc_characters_meta' );
}