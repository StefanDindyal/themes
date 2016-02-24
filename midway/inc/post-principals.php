<?php
add_action( 'init', 'post_principals', 0 );
function post_principals() {
    $labels = array(
		'name' => __( 'Principals', 'midway' ),
		'singular_name' => __( 'Principal', 'midway' ),
		'add_new' => __( 'Add New Principal', 'midway' ),
		'add_new_item' => __( 'Add New Principal', 'midway' ),
		'edit_item' => __( 'Edit Principal', 'midway' ),
		'new_item' => __( 'New Principal Post Item', 'midway' ),
		'view_item' => __( 'View Principal', 'midway' ),
		'search_items' => __( 'Search Principals', 'midway' ),
		'not_found' => __( 'Nothing found', 'midway' ),
		'not_found_in_trash' => __( 'Nothing found in Trash', 'midway' ),
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
		  'rewrite' => array( 'slug' => 'principals' ), // changes name in permalink structure
		  'menu_icon' => 'dashicons-groups',
		  'menu_position' => 4, // search WordPress Codex for menu_position parameters
		  'supports' => array( 'title', 'editor' )
    );
    register_post_type( 'principals', $args ); // adds your $args array from above
}