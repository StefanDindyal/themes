<?php
/*
  Plugin Name: RG Discography
  Description: Discography Posts.
  Version: 1.0
  Author: Generator
  License: GPLv2
 */
add_action( 'init', 'rg_register_discography', 0 );
function rg_register_discography() {
    $labels = array(
		'name' => __( 'Discography', 'rg-slider' ),
		'singular_name' => __( 'Discography', 'rg-slider' ),
		'add_new' => __( 'Add New Discography', 'rg-slider' ),
		'add_new_item' => __( 'Add New Discography', 'rg-slider' ),
		'edit_item' => __( 'Edit Discography', 'rg-slider' ),
		'new_item' => __( 'New Discography Post Item', 'rg-slider' ),
		'view_item' => __( 'View Discography', 'rg-slider' ),
		'search_items' => __( 'Search Discography', 'rg-slider' ),
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
		  'rewrite' => array( 'slug' => 'discography' ), // changes name in permalink structure
		  // 'menu_icon' => get_template_directory_uri().'/inc/criton-options/images/menu_icon.png',
		  'menu_position' => 4, // search WordPress Codex for menu_position parameters
		  'supports' => array( 'title', 'editor', 'thumbnail' ),
    );
    register_post_type( 'discography', $args ); // adds your $args array from above    
	$prefix = 'rg_';
	$disc_options = array(
		array(
			'label' => 'Release Date',
			'desc' => 'When the product will be released. Inputing to this field formats the post to the "Release Date" style.',
			'id' => $prefix . 'released',
			'std' => '',
			'type' => 'text' // text area
		),
		array(
			'label' => 'Tab Listing',
			'desc' => 'The tab that this post corresponds to. MUST BE SELECTED',
			'id' => $prefix . 'tab',
			'std' => '',
			'type' => 'select', // text area
			'options' => array(
				'Option 1' => array(
					'label' => 'Portfolio',
					'value' => 'tab-1'
				), 
				'Option 2' => array(
					'label' => 'The Lion King',
					'value' => 'tab-2'
				), 
				'Option 3' => array(
					'label' => 'Marry Poppins',
					'value' => 'tab-3'
				), 
				'Option 4' => array(
					'label' => 'Sleeping Beauty',
					'value' => 'tab-4'
				), 
				'Option 5' => array(
					'label' => 'The Little Mermaid',
					'value' => 'tab-5'
				), 
				'Option 6' => array(
					'label' => 'Fantasia',
					'value' => 'tab-6'
				), 
				'Option 7' => array(
					'label' => 'Pinnochio',
					'value' => 'tab-7'
				), 
				'Option 8' => array(
					'label' => 'Toy Story',
					'value' => 'tab-8'
				), 
				'Option 9' => array(
					'label' => 'Disneyland',
					'value' => 'tab-9'
				), 
				'Option 10' => array(
					'label' => 'Lady and the Tramp',
					'value' => 'tab-10'
				), 
				'Option 11' => array(
					'label' => 'Pocahontas',
					'value' => 'tab-11'
				),
				'Option 12' => array(
					'label' => 'Aristocats',
					'value' => 'tab-12'
				),
				'Option 13' => array(
					'label' => 'Cinderella',
					'value' => 'tab-13'
				)
			)
		)
	);
	$slider_options = array(		
		array(
			'label' => 'Slide 1(Image)',
			'desc' => 'First Slider Image.',
			'id' => $prefix . 'slide1',
			'std' => '',
			'type' => 'image' // text area
		),
		array(
			'label' => 'Slide 2(Image)',
			'desc' => 'Secound Slider Image.',
			'id' => $prefix . 'slide2',
			'std' => '',
			'type' => 'image' // text area
		),
		array(
			'label' => 'Slide 3(Video)',
			'desc' => 'Last Slide is a Video. This accepts only a YouTube URL. ex: http://www.youtube.com/watch?v=ibAxkCJfvC4',
			'id' => $prefix . 'slide3',
			'std' => '',
			'type' => 'text' // text area
		),
		array(
			'label' => 'Slide 3(Video Image Replace)',
			'desc' => 'Uploading and Image here will replace the image pulled from YouTube.',
			'id' => $prefix . 'slide3-img',
			'std' => '',
			'type' => 'image' // text area
		)
	);
	$track_options_list = array(		
		array( // Repeatable & Sortable Text inputs
		'label'	=> 'Track Listing', // <label>
		'desc'	=> 'Tracks or list items must be separated by a ",". For sub titles enter within parentheses. ex: Track 1(Score), Track 2(Performed by Jane Doe, etc.)', // description
		'id'	=> $prefix.'dlist', // field id and name
		'type'	=> 'repeatable', // type of field
		'sanitizer' => array( // array of sanitizers with matching kets to next array
			'atitle' => 'sanitize_text_field'
		),
			'repeatable_fields' => array( // array of fields to be repeated
				'atitle' => array(
					'label' => 'Item Heading ex: Disc 1 or Artist: Jane Doe',
					'id' => 'atitle',
					'width' => 'width:80%;',
					'type' => 'text'
				),
				'alist' => array(
					'label' => 'List of Items/Tracks',
					'id' => 'alist',
					'width' => 'width:80%;',
					'type' => 'textarea'
				)
			)
		),
		array(
			'label' => 'Extra Copy',
			'desc' => 'Extra Copy Field. This copy can be used rather than the track listing. Ideal for the Portfolio Tab.',
			'id' => $prefix . 'extra',
			'std' => '',
			'type' => 'textarea' // text area
		)
	);	
	$discography_music_box = new custom_add_meta_box( 'rg-discography', 'Discography Options', $disc_options, 'discography', true );
	$discography_slider_box = new custom_add_meta_box( 'rg-discography-slider', 'Slider Options', $slider_options, 'discography', true );
	$discography_list_box = new custom_add_meta_box( 'rg-discography-list', 'Item/Track Listing', $track_options_list, 'discography', true );		
}