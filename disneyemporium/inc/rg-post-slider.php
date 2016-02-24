<?php
/*
  Plugin Name: RG Slider
  Description: Slider Posts.
  Version: 1.0
  Author: Generator
  License: GPLv2
 */
add_action( 'init', 'rg_register_slider' );
function rg_register_slider() {
    $labels = array(
		'name' => __( 'Slider', 'rg-slider' ),
		'singular_name' => __( 'Slider', 'rg-slider' ),
		'add_new' => __( 'Add New Slider', 'rg-slider' ),
		'add_new_item' => __( 'Add New Slider', 'rg-slider' ),
		'edit_item' => __( 'Edit Slider', 'rg-slider' ),
		'new_item' => __( 'New Slider Post Item', 'rg-slider' ),
		'view_item' => __( 'View Slider', 'rg-slider' ),
		'search_items' => __( 'Search Slider', 'rg-slider' ),
		'not_found' => __( 'Nothing found', 'rg-slider' ),
		'not_found_in_trash' => __( 'Nothing found in Trash', 'rg-slider' ),
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
		  'rewrite' => array( 'slug' => 'slider' ), // changes name in permalink structure
		  // 'menu_icon' => get_template_directory_uri().'/inc/criton-options/images/menu_icon.png',
		  'menu_position' => 4, // search WordPress Codex for menu_position parameters
		  'supports' => array( 'title', 'editor', 'thumbnail' ),
    );
    register_post_type( 'slider', $args ); // adds your $args array from above    
	$prefix = 'rg_';
	$slider_options = array(		
		array(
			'label' => 'Link URL',
			'desc' => 'The destination of the slider CTA.',
			'id' => $prefix . 'link_url',
			'std' => '',
			'type' => 'text' // text area
		),
		array(
			'label' => 'Link Text',
			'desc' => 'The text that appears in the sliders CTA. Deafults to Buy Now.',
			'id' => $prefix . 'link_text',
			'std' => '',
			'type' => 'text' // text area
		),
		array(
			'label' => 'Open in a New Window',
			'desc' => 'Opens the slider link in a new window or tab.',
			'id' => $prefix . 'link_target',
			'std' => '',
			'type' => 'checkbox' // text area
		),
		array(
			'label' => 'Slide Background Color',
			'desc' => 'Sets a background color to this specific slide. Shows up behind the images on the ends.',
			'id' => $prefix . 'bg_color',
			'std' => '',
			'type' => 'color' // text area
		)
	);	
	$slider_box = new custom_add_meta_box( 'rg-slider', 'Slider Options', $slider_options, 'slider', true );
}