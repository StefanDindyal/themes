<?php
/*
  Plugin Name: RG Slider Next
  Description: Slider Posts.
  Version: 1.0
  Author: Generator
  License: GPLv2
 */
add_action( 'init', 'rg_register_slider_next' );
function rg_register_slider_next() {
    $labels = array(
		'name' => __( 'Slider Shop', 'rg-slider-next' ),
		'singular_name' => __( 'Slider Shop', 'rg-slider-next' ),
		'add_new' => __( 'Add New Slider Shop', 'rg-slider-next' ),
		'add_new_item' => __( 'Add New Slider Shop', 'rg-slider-next' ),
		'edit_item' => __( 'Edit Slider Shop', 'rg-slider-next' ),
		'new_item' => __( 'New Slider Shop Post Item', 'rg-slider-next' ),
		'view_item' => __( 'View Slider Shop', 'rg-slider-next' ),
		'search_items' => __( 'Search Slider Shop', 'rg-slider-next' ),
		'not_found' => __( 'Nothing found', 'rg-slider-next' ),
		'not_found_in_trash' => __( 'Nothing found in Trash', 'rg-slider-next' ),
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
		  'rewrite' => array( 'slug' => 'slider-next' ), // changes name in permalink structure
		  // 'menu_icon' => get_template_directory_uri().'/inc/criton-options/images/menu_icon.png',
		  'menu_position' => 4, // search WordPress Codex for menu_position parameters
		  'supports' => array( 'title', 'editor', 'thumbnail' ),
    );
    register_post_type( 'slider_next', $args ); // adds your $args array from above    
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
	$slider_box = new custom_add_meta_box( 'rg-slider-next', 'Slider Options', $slider_options, 'slider_next', true );
}