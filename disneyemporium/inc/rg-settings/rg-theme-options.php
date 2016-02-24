<?php
/*
Plugin Name: RG Settings Page
Description: Custom Settings for Wordpress Sites.
Version: 1.0.1
Author: rGenerator
Author URI: http://www.rgenerator.com/
License: GPL v2.0
*/

if ( ! function_exists( 'add_action' ) ) {
	_e( "Hi there! I'm just a plugin, not much I can do when called directly." );
	exit;
}

/* The Player
========================================================*/

	
	if ( ! defined( 'RG_MEDIA_LOCALE' ) )
			define( 'RG_MEDIA_LOCALE', '' );
		
	if ( ! defined( 'RG_MEDIA_DIR' ) )
		define( 'RG_MEDIA_DIR', get_template_directory(). '/inc/rg-settings' );

	if ( ! defined( 'RG_MEDIA_URL' ) )
		define( 'RG_MEDIA_URL', get_template_directory_uri(). '/inc/rg-settings' );
		
	add_action( 'init', 'rg_media_admin_options' );            			
	      

	/* ADD ADMIN PANEL
	========================================================*/
	function rg_media_admin_options(){
		global $settings;
		require_once( RG_MEDIA_DIR . '/admin-panel.php' );

		$settings = get_option( 'rg_media_options' );
		$prefix = 'rg_';

		//echo "<pre>"; print_r($format_options); echo "</pre>";
		$rg_media_fields = array(
			// Share					
			array(
				'id'	=> $prefix.'social_network',
				'type'	=> 'section',
				'label' => __( 'Disney Music Emporium Settings', RG_MEDIA_LOCALE )
			),
			array(
				'label'   => __( 'Facebook Page Name', RG_MEDIA_LOCALE ),
				'desc'    => sprintf( __( 'The name of your Facebook page from which to pull posts.', RG_MEDIA_LOCALE )),
				'std'     => '',
				'id'	=> $prefix.'fb_name',
				'type'	=> 'text',
				'width' => '30%'
			),
			array(
				'label'   => __( 'Twitter Username', RG_MEDIA_LOCALE ),
				'desc'    => sprintf( __( 'The username from which to pull tweets.', RG_MEDIA_LOCALE )),
				'std'     => '',
				'id'	=> $prefix.'twtr_name',
				'type'	=> 'text',
				'width' => '30%'
			),
			array(
				'label'   => __( 'Instagram Username', RG_MEDIA_LOCALE ),
				'desc'    => sprintf( __( 'The username from which to pull Instagram pictures.', RG_MEDIA_LOCALE )),
				'std'     => '',
				'id'	=> $prefix.'inst_name',
				'type'	=> 'text',
				'width' => '30%'
			),
			array(
				'label'   => __( 'Feedback Email', RG_MEDIA_LOCALE ),
				'desc'    => sprintf( __( 'The email address to send user feedback to.', RG_MEDIA_LOCALE )),
				'std'     => '',
				'id'	=> $prefix.'mailto',
				'type'	=> 'text',
				'width' => '30%'
			)
		);
		
	}
?>