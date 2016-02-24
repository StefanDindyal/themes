<?php
add_action( 'init', 'post_hero', 0 );
function post_hero() {
    $labels = array(
		'name' => __( 'Hero', 'midway' ),
		'singular_name' => __( 'Hero', 'midway' ),
		'add_new' => __( 'Add New Hero', 'midway' ),
		'add_new_item' => __( 'Add New Hero', 'midway' ),
		'edit_item' => __( 'Edit Hero', 'midway' ),
		'new_item' => __( 'New Hero Post Item', 'midway' ),
		'view_item' => __( 'View Hero', 'midway' ),
		'search_items' => __( 'Search Heros', 'midway' ),
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
		  'rewrite' => array( 'slug' => 'hero' ), // changes name in permalink structure
		  'menu_icon' => 'dashicons-slides',
		  'menu_position' => 4, // search WordPress Codex for menu_position parameters
		  'supports' => array( 'title', 'editor', 'thumbnail' )
    );
    register_post_type( 'hero', $args ); // adds your $args array from above
    function post_hero_meta($current_screen){
		if ( 'hero' == $current_screen->post_type && 'post' == $current_screen->base ) {
			$prefix = 'hero_';			
			$fields = array(
				array(
				    'label' => 'Hero Link Text',
				    'desc'  => 'Text that will appear in the heros cta.',
				    'id'    => $prefix.'text',			
				    'type'  => 'text'
				),
				array(
				    'label' => 'Hero Link URL',
				    'desc'  => 'The link that the hero will take the user to once clicked. (Link to sections with: #about, #properties, #principals, or #contact) Full URL Example: http://www.google.com',
				    'id'    => $prefix.'url',			
				    'type'  => 'text'
				),
				array(
				    'label' => 'Open Tab',
				    'desc'  => 'Check to have the hero link open in a new browser tab.',
				    'id'    => $prefix.'tab',
				    'type'  => 'checkbox'
				)
			);
			$hero_box = new custom_add_meta_box( 'hero_box', 'Hero Options', $fields, 'hero', true );
		}
	}
	add_action( 'current_screen', 'post_hero_meta' );
}