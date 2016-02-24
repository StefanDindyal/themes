<?php
/*/////////////////////////////////////////////////////
	* Creates Admin Panel in dashboard settings page
	* Includes admin-panel.php
/////////////////////////////////////////////////////*/

add_action( 'init', '_m2AdminOptions' );

function _m2AdminOptions(){
    global $settings, $checkbox_options;
    
    require_once( RG_M2_DIR . '/admin-panel.php' );

    $prefix = 'store_';

    $rg_m2_fields = array(
    	array(
    		'id'	=> $prefix.'store_options',
    		'type'	=> 'section',
    		'label' => __( 'M2 Store', RG_M2_LOCALE )
    	),
    	array(
    		'label'=> __( 'Store Name', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( '', RG_M2_LOCALE )),
    		'id'	=> $prefix.'username',
    		'type'	=> 'text',
    		'width' => '30%'
    	),
    	array(
    		'label'=> __( 'Store ID', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( 'This can be found on Clerk.', RG_M2_LOCALE )),
    		'id'	=> $prefix.'store_id',
    		'type'	=> 'text',
    		'width' => '10%'
    	),
    	array(
    		'label'=> __( 'Store API', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( 'Set the API call. (ex: stage, qa, api)<br/>(If left blank default will be stage)', RG_M2_LOCALE )),
    		'id'	=> $prefix.'api',
    		'type'	=> 'text',
    		'width' => '10%'
    	),
    	// TABS SECTION
    	array(
    		'id'	=> $prefix.'tabs_options',
    		'type'	=> 'section',
    		'label' => __( 'Tabs', RG_M2_LOCALE )
    	), 
    	array(
    		'label'	=> 'Tab',
    		'desc'	=> sprintf( __( 'Select the tabs you wish to display for the store. %s(The is for the shortcode, this will not affect the post type selection)%s', RG_M2_LOCALE ), '<strong>', '<strong>' ),
    		'id'	=> $prefix.'tabs',
    		'type'	=> 'checkbox_group',
    		'options' => $checkbox_options
    	),
    	// POST-TYPE SECTION
    	array(
    		'id'	=> $prefix.'post_type_options',
    		'type'	=> 'section',
    		'label' => sprintf( __( 'Post Type', RG_M2_LOCALE ) )
    	),
    	array(
			'label'	=> 'Post Selection',
			'desc'	=> sprintf( __( 'Select the tab you wish to display for the Post and add the name of the post. %s(Post name will have "rg" at the beginning of it)%s', RG_M2_LOCALE ), '<strong>', '<strong>'),
			'id'	=> $prefix.'post_types',
			'type'	=> 'repeatable',
			'sanitizer' => array( 
				'tab' => 'wp_kses_data',
				'postname' => 'sanitize_text_field',
				'icon' => 'wp_kses_data',
			),
			'repeatable_fields' => array (
				'tab' => array(
					'id' => 'tab',
					'type' => 'select',
					'options' => $checkbox_options
				),
				'postname' => array(
					'id' => 'postname',
					'type' => 'text',
					'width' => '15%'
				),
				'icon' => array(
					'id' => 'icon',
					'type' => 'select',
					'options' => array(
						'one' => array(
						  'label' => 'Wordpress Icon',
						  'value' => 'wordpress'
						),
						'two' => array(
						  'label' => 'Audio Icon',
						  'value' => 'format-audio'
						),
						'three' => array(
						  'label' => 'Video Icon',
						  'value' => 'format-video'
						),
						'four' => array(
						  'label' => 'Video Icon Alt',
						  'value' => 'video-alt'
						),
						'five' => array(
						  'label' => 'Video Icon Alt 2',
						  'value' => 'video-alt2'
						),
						'six' => array(
						  'label' => 'Video Icon Alt 3',
						  'value' => 'video-alt3'
						),
						'seven' => array(
						  'label' => 'Image Icon',
						  'value' => 'format-image'
						),
						'eight' => array(
						  'label' => 'Image Icon Alt',
						  'value' => 'images-alt2'
						),
						'nine' => array(
						  'label' => 'Gallery Icon',
						  'value' => 'format-gallery'
						),
						'ten' => array(
						  'label' => 'Calendar Icon',
						  'value' => 'calendar'
						),
						'eleven' => array(
						  'label' => 'Cart Icon',
						  'value' => 'cart'
						),
					)
				),
			)
		),
    	// DISPLAY SECTION
    	array(
    		'id'	=> $prefix.'display_options',
    		'type'	=> 'section',
    		'label' => __( 'Layout Display', RG_M2_LOCALE )
    	),
    	array(
    		'label'	=> 'Product Layout',
    		'desc'	=> sprintf( __( 'Select a list or a dropdown menu view for details product page.', RG_M2_LOCALE )),
    		'id'	=> $prefix.'select',
    		'type'	=> 'select',
    		'options' => array(
    			'one' => array(
				  'label' => 'List',
				  'value' => 'list'
				),
				'two' => array(
				  'label' => 'Dropdown',
				  'value' => 'dropdown'
				),
    		)
    	),
    	array(
    		'label'=> __( 'Pagination', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( 'Set a number for how many products to view at a time.', RG_M2_LOCALE ) ),
    		'id'	=> $prefix.'pagination',
    		'type'	=> 'text',
    		'width' => '5%'
    	),
    	array(
    		'label'=> __( 'Activate Quick View', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( 'Activate Quick View button on main page.', RG_M2_LOCALE ) ),
    		'id'	=> $prefix.'activate_qv',
    		'type'	=> 'checkbox'
    	),
    	array(
    		'label'=> __( 'Activate Mediaelement', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( 'Activate only if your theme does not contain Mediaelement', RG_M2_LOCALE ) ),
    		'id'	=> $prefix.'activate_me',
    		'type'	=> 'checkbox'
    	),
    	array(
    		'label'=> __( 'Activate Fancybox', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( 'Activate only if your theme does not contain Fancybox', RG_M2_LOCALE ) ),
    		'id'	=> $prefix.'activate_fb',
    		'type'	=> 'checkbox'
    	),
    	array(
    		'label'=> __( 'Add To Cart Button Text', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( 'Add your cart button text. %s(If left blank text will be &quot;Add To Cart&quot;)%s', RG_M2_LOCALE ), '<strong>', '<strong>'),
    		'id'	=> $prefix.'bb_text',
    		'type'	=> 'text',
    		'width' => '10%'
    	),
    	array(
    		'label'=> __( 'Buy Button Text Color', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( '', RG_M2_LOCALE )),
    		'id'	=> $prefix.'bb_text_color',
    		'type'	=> 'color',
    		'width' => '10%'
    	),
    	array(
    		'label'=> __( 'Buy Button BG Color', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( '', RG_M2_LOCALE )),
    		'id'	=> $prefix.'bb_color',
    		'type'	=> 'color',
    		'width' => '10%'
    	),
    	array(
    		'label'=> __( 'Buy Button Hover Color', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( '', RG_M2_LOCALE )),
    		'id'	=> $prefix.'bb_hover_color',
    		'type'	=> 'color',
    		'width' => '10%'
    	),
    	array(
    		'id'	=> $prefix.'cart_display_options',
    		'type'	=> 'section',
    		'label' => __( 'Cart Display', RG_M2_LOCALE )
    	),
    	array(
    		'label'=> __( 'Cart Container', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( 'Set the id / class of the cart container (ex: #cart-container)<br/>(If left blank default will be #cart-container).', RG_M2_LOCALE ) ),
    		'id'	=> $prefix.'cart_container',
    		'type'	=> 'text',
    		'width' => '20%'
    	),
    	array(
    		'label'=> __( 'Cart Image Size', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( 'Set the thumbnail size for the cart image, Display Thumbnail setting must be checked.(ex: 100x100)', RG_M2_LOCALE ) ),
    		'id'	=> $prefix.'cart_image',
    		'type'	=> 'text',
    		'width' => '10%'
    	),
    	array(
    		'label'=> __( 'Display Thumbnail', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( 'Check to display thumbnail in the cart.', RG_M2_LOCALE ) ),
    		'id'	=> $prefix.'display_thumb',
    		'type'	=> 'checkbox'
    	),
    	array(
    		'label'=> __( 'Display Price', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( 'Check to display the price in the cart.', RG_M2_LOCALE ) ),
    		'id'	=> $prefix.'display_price',
    		'type'	=> 'checkbox'
    	),
    	array(
    		'label'=> __( 'Spinner', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( '', RG_M2_LOCALE ) ),
    		'id'	=> $prefix.'loader',
    		'type'	=> 'slider',
    		'min' => '0',
			'max' => '100',
    	),
		array(
    		'label'=> __( 'Loading Spinner', RG_M2_LOCALE ),
    		'desc'	=> sprintf( __( '', RG_M2_LOCALE ) ),
    		'id'	=> $prefix.'loading_spinner',
    		'type'	=> 'input_group',
			'sanitizer' => array( 
				'lines' => 'sanitize_text_field',
				'length' => 'sanitize_text_field',
				'width' => 'sanitize_text_field',
				'radius' => 'sanitize_text_field',
				'corners' => 'sanitize_text_field',
				'rotate' => 'sanitize_text_field',
				'trail' => 'sanitize_text_field',
				'speed' => 'sanitize_text_field',
			),
			'group_fields' => array (
				'lines' => array(
					'label' => 'Lines',
					'id' => 'lines',
					'type' => 'slider',
					'min' => '5',
					'max' => '16',
					'step' => '2'
				),
				'length' => array(
					'label' => 'Length',
					'id' => 'length',
					'type' => 'slider',
					'min' => '0',
					'max' => '40',
				),
				'width' => array(
					'label' => 'Width',
					'id' => 'width',
					'type' => 'slider',
					'min' => '2',
					'max' => '30',
				),
				'radius' => array(
					'label' => 'Radius',
					'id' => 'radius',
					'type' => 'slider',
					'min' => '0',
					'max' => '60',
				),
				'corners' => array(
					'label' => 'Corners',
					'id' => 'corners',
					'type' => 'slider',
					'min' => '0',
					'max' => '1',
					'step' => '0.1'
				),
				'rotate' => array(
					'label' => 'Rotate',
					'id' => 'rotate',
					'type' => 'slider',
					'min' => '0',
					'max' => '90',
				),
				'trail' => array(
					'label' => 'Trail',
					'id' => 'trail',
					'type' => 'slider',
					'min' => '10',
					'max' => '100',
				),
				'speed' => array(
					'label' => 'Speed',
					'id' => 'speed',
					'type' => 'slider',
					'min' => '0.5',
					'max' => '2.2',
					'step' => '0.1'
				),
			)
    	),
    	
    );
}

?>