<?php
/** MUSIC POST TYPE **/

add_action( 'init', 'gb_register_music' );

function gb_register_music() {
    $labels = array(
		'name' => __( 'Music', 'gb-music' ),
		'singular_name' => __( 'Music', 'gb-music' ),
		'add_new' => __( 'Add New Music', 'gb-music' ),
		'add_new_item' => __( 'Add New Music', 'gb-music' ),
		'edit_item' => __( 'Edit Music', 'gb-music' ),
		'new_item' => __( 'Add New Music', 'gb-music' ),
		'view_item' => __( 'View Music', 'gb-music' ),
		'search_items' => __( 'Search Music', 'gb-music' ),
		'not_found' => __( 'Nothing Found', 'gb-music' ),
		'not_found_in_trash' => __( ' Nothing Found', 'gb-music' ),
		'parent_item_colon' => ''
	); 	
    $args = array( 
        'labels' => $labels, // adds your $music array from above
		  'public' => true,
		  'publicly_queryable' => true,
		  'show_ui' => true,
		  'query_var' => true,
		  'capability_type' => 'post',
		  'hierarchical' => false,
		  'rewrite' => array( 'slug' => 'music' ), // changes name in permalink structure
		  'menu_icon' => get_template_directory_uri().'/inc/images/content_icon.png',
		  'menu_position' => 5, // search WordPress Codex for menu_position parameters
		  'supports' => array( 'title', 'editor', 'thumbnail' ),
    ); 
    register_post_type( 'demusic', $args ); // adds your $args array from above
	flush_rewrite_rules();
}


/**
 * Output custom columns for music Post Type
 */
function gb_music_custom_columns( $columns ) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Album Title"
	);
	return $columns;
}
add_filter( 'manage_edit-music_columns', 'gb_music_custom_columns' );

/**
 * Custom column content for music Post Type
 */
function gb_music_custom_column_content( $column ) {
	global $post;

	$image_src = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	$custom = get_post_custom();

	if ( "ID" == $column ){
		echo $post->ID;
	} elseif ( "artistbg" == $column ) {
		//echo "<img id='music_logo' src='$image_src' style='max-width:100px;' />";
	}
}
add_action( 'manage_posts_custom_column', 'gb_music_custom_column_content' );

$albums_options = array();

function _getAlbumTab(){
   global $settings, $store_name, $keyID, $host, $version, $expires, $albums_options;
   
   $albumTabID = '5492810';
   
   if($settings['m2_username'] != ''):
   	$albumTab = 'http://'.$host.'/'.$store_name.'/api/'.$version.'/tabs/'.$albumTabID.'.json?key='.$keyID;
    //rgpree($albumTab);
   	if ( false === ( $json = get_transient( 'rg_album_tab_'.$albumTabID ) ) ) {
  	   $json = file_get_contents($albumTab); 
  	   set_transient( 'rg_album_tab_'.$albumTabID, $json, HOUR_IN_SECONDS );
  	}
  	// delete_transient( 'rg_album_tab_'.$albumTabID );
  	$tab = json_decode($json, true);
   	if( empty($tab) ){
     		return;
   	} else {
   	   for($i = 0; $i < count($tab['results']); $i++){
   			$results = $tab['results'][$i];
   			$id = $results['id'];
   			$name = $results['name'];
   			$title = $results['title'];
   			   			
   			$albums_options[$id] = array(
   			   'label' => $title,  
   			   'value' => $id,
   			);
   	   }//for
   	}//else
   endif;
}
add_action( 'init', '_getAlbumTab', 0 );


function _albumAdminOpts(){
	global $albums_options;
	$prefix = 'rg_';

	$fields = array(
		array(
			'label'	=> 'Album',
			'desc'	=> 'Select the album here.',
			'id'	=> $prefix.'select_album',
			'type'	=> 'chosen',
	    	'options' => $albums_options
		),
		array(
			'label'	=> 'Release Date',
			'desc'	=> 'Paste the album Release Date here.',
			'id'	=> $prefix.'album_release',
			'type'	=> 'releasedate',
			'width' => '10%'
		),
		array(
			'label'	=> 'Video URL',
			'desc'	=> 'Paste the video URL here.',
			'id'	=> $prefix.'album_video_url',
			'type'	=> 'text'
		),
		array(
			'label'	=> 'Video Title',
			'desc'	=> 'Paste the video title here.',
			'id'	=> $prefix.'album_video_title',
			'type'	=> 'text'
		),
		array(
			'label' => 'Video Image',
		    'desc'	=> 'Add a video image, if none use default will be the video default thumbnail.',
		    'id'	=> $prefix.'album_video_img',
		    'type'	=> 'image'
		),
		array(
			'label'	=> 'Add Bundle',
			'desc'	=> 'Check to add bundle product to detail page.',
			'id'	=> $prefix.'album_bundle',
			'type'	=> 'checkbox'
		),
		array(
			'label'	=> 'Bundle Image',
			'desc'	=> 'Add bundle image to detail page. (Will be displayed on when the bundle is checked)',
			'id'	=> $prefix.'album_bundle_img',
			'type'	=> 'image'
		),
	);
	$music_box = new custom_add_meta_box( 'music_box', 'Music Options', $fields, 'gbmusic', true );
}
add_action( 'init', '_albumAdminOpts', 0 );

?>