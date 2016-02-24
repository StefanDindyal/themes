<?php
/*
  Plugin Name: RG Products
  Description: Product Posts.
  Version: 1.0
  Author: Generator
  License: GPLv2
 */
add_action( 'init', 'rg_register_products' );
function rg_register_products() {
    $labels = array(
		'name' => __( 'Products', 'rg-products' ),
		'singular_name' => __( 'Product', 'rg-products' ),
		'add_new' => __( 'Add New Product', 'rg-products' ),
		'add_new_item' => __( 'Add New Product', 'rg-products' ),
		'edit_item' => __( 'Edit Product', 'rg-products' ),
		'new_item' => __( 'New Products Post Item', 'rg-products' ),
		'view_item' => __( 'View Products', 'rg-products' ),
		'search_items' => __( 'Search Products', 'rg-products' ),
		'not_found' => __( 'Nothing found', 'rg-products' ),
		'not_found_in_trash' => __( 'Nothing found in Trash', 'rg-products' ),
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
		  'rewrite' => array( 'slug' => 'products' ), // changes name in permalink structure
		  // 'menu_icon' => get_template_directory_uri().'/inc/criton-options/images/menu_icon.png',
		  'menu_position' => 4, // search WordPress Codex for menu_position parameters
		  'supports' => array( 'title', 'editor', 'thumbnail' ),
    );
    // register_post_type( 'products', $args ); // adds your $args array from above    
}
function _albumAdminOpts(){
	global $albums_options;
	$prefix = 'rg_';
	$product_options = array(
		// array(
		// 	'label' => 'Available',
		// 	'desc' => 'Check this if the product is available.',
		// 	'id' => $prefix . 'item_avail',
		// 	'std' => '',
		// 	'type' => 'checkbox' // text area
		// ),		
		// array(
		// 	'label' => 'Sold Out',
		// 	'desc' => 'Check this if the product is sold out.',
		// 	'id' => $prefix . 'item_sold_out',
		// 	'std' => '',
		// 	'type' => 'checkbox' // text area
		// ),		
		array(
			'label' => 'Disable Comments',
			'desc' => 'Removes comments from this product post',
			'id' => $prefix . 'no_comments',
			'std' => '',
			'type' => 'checkbox' // text area
		),		
		array(
			'label' => 'Pre-Order copy',
			'desc' => 'Enter text here for pre-order date.',
			'id' => $prefix . 'preorder_text',
			'std' => '',
			'type' => 'text' // text area
		),		
		array(
			'label' => 'Soundcloud URL',
			'desc' => 'URL to the Soundcloud playlist or track.',
			'id' => $prefix . 'sc_url',
			'std' => '',
			'type' => 'text' // text area
		),
		array(
			'label' => 'Video URL',
			'desc' => 'Supports YouTube video URL\'s.',
			'id' => $prefix . 'yt_url',
			'std' => '',
			'type' => 'text' // text area
		),
		array(
			'label' => 'Instagram Copy',
			'desc' => 'Text which appears above the instagram feed. This is in addition to the tag name.',
			'id' => $prefix . 'inst_copy',
			'std' => '',
			'type' => 'text' // text area
		),
		array(
			'label' => 'Instagram Tag',
			'desc' => 'Tag for which to pull Instagram posts. Exclude "#".',
			'id' => $prefix . 'inst_tag',
			'std' => '',
			'type' => 'text' // text area
		),
		array(
			'label' => 'Header Background Color',
			'desc' => 'Sets a background color to this specific slide. Shows up behind the images on the ends.',
			'id' => $prefix . 'bg_color',
			'std' => '',
			'type' => 'color' // text area
		)
	);
	$slider_options_list = array(		
		array( // Repeatable & Sortable Text inputs
		'label'	=> 'Slide Listing', // <label>
		'desc'	=> 'Slides to be featured with product. Entering and image posts the image as the slide. If you enter a video URL, this will post the video as the slide. YouTube videos supported. The image for the video will be pulled from YouTube. If you wish to use the uploaded image as the video image then you can check the Video Image Opt.', // description
		'id'	=> $prefix.'plist', // field id and name
		'type'	=> 'repeatable', // type of field
		'sanitizer' => array( // array of sanitizers with matching kets to next array
			'pimg' => 'sanitize_text_field'
		),
			'repeatable_fields' => array( // array of fields to be repeated
				'popt' => array(
					'label' => 'Video Image Opt',
					'id' => 'popt',
					'width' => '',
					'type' => 'checkbox'
				),
				'pimg' => array(
					'label' => 'Slide Image',
					'id' => 'pimg',
					'width' => 'width:80%;',
					'type' => 'image'
				),
				'pvid' => array(
					'label' => 'Video URL',
					'id' => 'pvid',
					'width' => 'width:80%;',
					'type' => 'text'
				)				
			)
		)
	);	
	$products_box = new custom_add_meta_box( 'rg-products', 'Product Options', $product_options, 'rgshop', true );
	$p_slider_box = new custom_add_meta_box( 'rg-p-slide', 'Slider Options', $slider_options_list, 'rgshop', true );	
}
add_action( 'admin_init', '_albumAdminOpts' );