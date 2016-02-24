<?php
add_action( 'init', 'kc_feature', 0 );
function kc_feature() {
    $labels = array(
		'name' => __( 'Features', 'kc-feature' ),
		'singular_name' => __( 'Feature', 'kc-feature' ),
		'add_new' => __( 'Add New Feature', 'kc-feature' ),
		'add_new_item' => __( 'Add New Feature', 'kc-feature' ),
		'edit_item' => __( 'Edit Feature', 'kc-feature' ),
		'new_item' => __( 'New Feature Post Item', 'kc-feature' ),
		'view_item' => __( 'View Feature', 'kc-feature' ),
		'search_items' => __( 'Search Feature', 'kc-feature' ),
		'not_found' => __( 'Nothing found', 'kc-feature' ),
		'not_found_in_trash' => __( 'Nothing found in Trash', 'kc-feature' ),
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
		  'rewrite' => array( 'slug' => 'feature' ), // changes name in permalink structure
		  // 'menu_icon' => get_template_directory_uri().'/inc/criton-options/images/menu_icon.png',
		  'menu_position' => 4, // search WordPress Codex for menu_position parameters
		  'supports' => array( 'title', 'editor', 'thumbnail' ),
    );
    register_post_type( 'feature', $args ); // adds your $args array from above    
}