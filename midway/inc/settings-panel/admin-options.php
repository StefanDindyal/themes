<?php
/*/////////////////////////////////////////////////////
	* Creates Admin Panel in dashboard settings page
	* Includes admin-panel.php
/////////////////////////////////////////////////////*/
add_action( 'init', '_midAdminOptions' );

function _midAdminOptions(){
    global $post_settings, $post_types_options, $plugins_options, $post_video_options, $mid_fields;
    
	if ( ! ( current_user_can( 'administrator' ) || current_user_can( 'developer' )) )
	    	return;
				
    require_once( MID_DIR . '/admin-panel.php' );
    	
    $prefix = 'mid_';

    $mid_fields = array(
		array(
		 	'id'	=> $prefix.'options',
		 	'type'	=> 'section',
		 	'label' => __( 'Feature Options', MF_LOCALE )
		),
		array(
			'desc'  => ' Select a post to feature.',
		 	'id'	=> $prefix.'feature_a',
		 	'type'	=> 'post_select',
		 	'post_type' => 'properties',
		 	'label' => __( 'Feature Box One', MF_LOCALE )
		),
		array(
			'desc'  => ' Select a post to feature.',
		 	'id'	=> $prefix.'feature_b',
		 	'type'	=> 'post_select',
		 	'post_type' => 'properties',
		 	'label' => __( 'Feature Box Two', MF_LOCALE )
		),
		array(
			'desc'  => ' Select a post to feature.',
		 	'id'	=> $prefix.'feature_c',
		 	'type'	=> 'post_select',
		 	'post_type' => 'properties',
		 	'label' => __( 'Feature Box Three', MF_LOCALE )
		),
		array(
			'desc'  => ' Select a post to feature.',
		 	'id'	=> $prefix.'feature_d',
		 	'type'	=> 'post_select',
		 	'post_type' => 'properties',
		 	'label' => __( 'Feature Box Four', MF_LOCALE )
		),
		array(
		 	'id'	=> $prefix.'options2',
		 	'type'	=> 'section',
		 	'label' => __( 'About Us Options', MF_LOCALE )
		),
		array(
			'desc'  => 'Text appearing before copy. Use &lt;strong&gt;&lt;/strong&gt; tag for bold copy.',
		 	'id'	=> $prefix.'about_pre',
		 	'type'	=> 'textarea',
		 	'label' => __( 'Pre-Text', MF_LOCALE )
		),
		array(
			'desc'  => 'Text appearing in left column of copy. Use &lt;p&gt;&lt;/p&gt; tag for paragraphs.',
		 	'id'	=> $prefix.'about_left',
		 	'type'	=> 'textarea',
		 	'label' => __( 'Left Column Copy', MF_LOCALE )
		),
		array(
			'desc'  => 'Text appearing in right column of copy. Use &lt;p&gt;&lt;/p&gt; tag for paragraphs.',
		 	'id'	=> $prefix.'about_right',
		 	'type'	=> 'textarea',
		 	'label' => __( 'Right Column Copy', MF_LOCALE )
		),
		array(
			'desc'  => '',
		 	'id'	=> $prefix.'about_image',
		 	'type'	=> 'image',
		 	'label' => __( 'Image', MF_LOCALE )
		),
		array(
		 	'id'	=> $prefix.'options3',
		 	'type'	=> 'section',
		 	'label' => __( 'Principals Options', MF_LOCALE )
		),
		array(
			'desc'  => '',
		 	'id'	=> $prefix.'prin_imagea',
		 	'type'	=> 'image',
		 	'label' => __( 'Principal Image A', MF_LOCALE )
		),
		array(
			'desc'  => '',
		 	'id'	=> $prefix.'prin_imageb',
		 	'type'	=> 'image',
		 	'label' => __( 'Principal Image B', MF_LOCALE )
		),
		array(
		 	'id'	=> $prefix.'options4',
		 	'type'	=> 'section',
		 	'label' => __( 'Contact Us Options', MF_LOCALE )
		),		
		array(
			'desc'  => 'Text appearing before address.',
		 	'id'	=> $prefix.'heading',
		 	'type'	=> 'textarea',
		 	'label' => __( 'Heading', MF_LOCALE )
		),
		array(
			'desc'  => 'Address of business. Use &lt;p&gt;&lt;/p&gt; tags for new lines.',
		 	'id'	=> $prefix.'location',
		 	'type'	=> 'textarea',
		 	'label' => __( 'Location', MF_LOCALE )
		),
		array(
			'desc'  => 'Where the contact form emails will be sent. Ex: example@example.com',
		 	'id'	=> $prefix.'email',
		 	'type'	=> 'text',
		 	'label' => __( 'Forwarding Email', MF_LOCALE )
		),		
		array(
		 	'id'	=> $prefix.'options5',
		 	'type'	=> 'section',
		 	'label' => __( 'Footer Options', MF_LOCALE )
		),
		array(
			'desc'  => 'A url linking to your privacy policy. Ex: http://www.google.com',
		 	'id'	=> $prefix.'privacy',
		 	'type'	=> 'text',
		 	'label' => __( 'Privacy Policy Link', MF_LOCALE )
		),
		array(
			'desc'  => 'Line of copyrite text. Use &amp;copy; in place of &copy;.',
		 	'id'	=> $prefix.'copyrite',
		 	'type'	=> 'text',
		 	'label' => __( 'Copyright Text', MF_LOCALE )
		)	
	);
}
?>