<?php
/*
  Plugin Name: RG Videos
  Description: Video Posts.
  Version: 1.0
  Author: Generator
  License: GPLv2
 */
add_action( 'init', 'rg_register_videos' );
function rg_register_videos() {
    $labels = array(
		'name' => __( 'Videos', 'rg-videos' ),
		'singular_name' => __( 'Video', 'rg-videos' ),
		'add_new' => __( 'Add New Video', 'rg-videos' ),
		'add_new_item' => __( 'Add New Video', 'rg-videos' ),
		'edit_item' => __( 'Edit Video', 'rg-videos' ),
		'new_item' => __( 'New Videos Post Item', 'rg-videos' ),
		'view_item' => __( 'View Videos', 'rg-videos' ),
		'search_items' => __( 'Search Videos', 'rg-videos' ),
		'not_found' => __( 'Nothing found', 'rg-videos' ),
		'not_found_in_trash' => __( 'Nothing found in Trash', 'rg-videos' ),
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
		  'rewrite' => array( 'slug' => 'rgvideos' ), // changes name in permalink structure
		  // 'menu_icon' => get_template_directory_uri().'/inc/criton-options/images/menu_icon.png',
		  'menu_position' => 4, // search WordPress Codex for menu_position parameters
		  'supports' => array( 'title', 'thumbnail' ),
    );
    register_post_type( 'videos', $args ); // adds your $args array from above    
	$prefix = 'rg_';
	$video_options = array(
		array(
			'label' => 'Feature',
			'desc' => 'Feature this video on the Videos page.',
			'id' => $prefix . 'vid_feat',
			'std' => '',
			'type' => 'checkbox' // text area
		),
		array(
			'label' => 'Video URL',
			'desc' => 'Supports YouTube video URL\'s.',
			'id' => $prefix . 'vid_src',
			'std' => '',
			'type' => 'text' // text area
		)
	);
	$video_box = new custom_add_meta_box( 'rg-videos', 'Video Options', $video_options, 'videos', true );
}