<?php
/*/////////////////////////////////////////////////////
	* Creates Admin Panel in dashboard settings page
	* Includes admin-panel.php
/////////////////////////////////////////////////////*/
add_action( 'init', '_kcAdminOptions' );

function _kcAdminOptions(){
    global $post_settings, $post_types_options, $plugins_options, $post_video_options, $kc_fields;
    
	if ( ! ( current_user_can( 'administrator' ) || current_user_can( 'developer' )) )
	    	return;
				
    require_once( KC_DIR . '/admin-panel.php' );
    	
    $prefix = 'kc_';

    $kc_fields = array(
		array(
		 	'id'	=> $prefix.'options',
		 	'type'	=> 'section',
		 	'label' => __( 'Share Options', KC_LOCALE )
		),
		array(
			'desc'  => 'Short Tweet text. (Required: The sites url or shortlink if desired)',
		 	'id'	=> $prefix.'twitter_text',
		 	'type'	=> 'text',
		 	'label' => __( 'Twitter Share Text', KC_LOCALE )
		),
		array(
			'desc'  => 'Tumblr share text.',
		 	'id'	=> $prefix.'tumblr_text',
		 	'type'	=> 'text',
		 	'label' => __( 'Tumblr Share Text', KC_LOCALE )
		),
		array(
		 	'id'	=> $prefix.'contact_options',
		 	'type'	=> 'section',
		 	'label' => __( 'Contact Us Options', KC_LOCALE )
		),
		array(
			'desc'  => 'Email to send contact form information to.',
		 	'id'	=> $prefix.'email_url',
		 	'type'	=> 'text',
		 	'label' => __( 'Contact Us Email', KC_LOCALE )
		),
		array(
		 	'id'	=> $prefix.'ga_options',
		 	'type'	=> 'section',
		 	'label' => __( 'Google Analytics Options', KC_LOCALE )
		),
		array(
			'desc'  => 'Paste Google Analytics script here.',
		 	'id'	=> $prefix.'ga_tag',
		 	'type'	=> 'textarea',
		 	'placeholder' => '<script>GA CODE</script>',
		 	'label' => __( 'Google Analytics Script', KC_LOCALE )
		)
	);
}
?>