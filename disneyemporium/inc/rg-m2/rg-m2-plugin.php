<?php
/*
Plugin Name: RG M2 Store
Description: A plugin to pull artist m2 store products.
Version: 3.5.0
Author: GENERATOR
Author URI: http://www.rgenerator.com/
License: GPL v2.0
Copyright 2014 SonyDADC

License:
 
 Copyright 2014 SonyDADC / GENERATOR
 
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.
 
  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
 
  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

if ( ! defined( 'RG_M2_LOCALE' ) )
    define( 'RG_M2_LOCALE', '' );
    
if ( ! defined( 'RG_M2_DIR' ) )
    define( 'RG_M2_DIR', get_template_directory() . '/inc/rg-m2' );

if ( ! defined( 'RG_M2_URL' ) )
    define( 'RG_M2_URL', get_template_directory_uri() . '/inc/rg-m2' );

/* GLOBALS
========================================================*/
global $settings, $store_name, $storeID, $keyID, $host, $version, $expires, $tabs, $checkbox_options, $defaulttab, $item_id, $country, $checkout_host, $tab_options;

add_action( 'init', '_m2getStoreTabs', 0 );
add_action( 'init', '_m2postTypeCreate', 0 );
add_action( 'wp_enqueue_scripts', '_m2EnqueueScripts' );
add_action( 'wp_head', '_m2CartScript' );
add_action( 'wp_head', '_m2DefaultCss' );
add_shortcode( 'M2Store', '_m2Shortcode' );

$tabs = array();
$checkbox_options = array();
$defaulttab = array();

$settings = get_option( 'rg_store_options' );
$store_name = preg_replace("/[\s_]/", "-", $settings['store_username']);
$storeID = $settings['store_store_id'];
$keyID = '109177db7055de2e42958238572b4454'; // Default API Key
$api = ($settings['store_api'] != '' ? $settings['store_api'] : 'stage');
$host = $api.'.myplaydirect.com';
$checkout_host = $api.'.myplaydirect.com';
$version = 'api/v1';
$expires = HOUR_IN_SECONDS;
$country = _m2countries();
$cartContainer = ($settings['store_cart_container'] != '' ? $settings['store_cart_container'] : '#cart-container');
$cartImageSize = ($settings['store_cart_image'] != '' ? $settings['store_cart_image'] : '100x100');
$cartThumb = $settings['store_display_thumb'];
$cartPrice = $settings['store_display_price'];

/*/////////////////////////////////////////////////////
	* Time Constants for set_transient():
	  MINUTE_IN_SECONDS  = 60 (seconds)
	  HOUR_IN_SECONDS    = 60 * MINUTE_IN_SECONDS
	  DAY_IN_SECONDS     = 24 * HOUR_IN_SECONDS
	  WEEK_IN_SECONDS    = 7 * DAY_IN_SECONDS
	  YEAR_IN_SECONDS    = 365 * DAY_IN_SECONDS
/////////////////////////////////////////////////////*/

require_once( RG_M2_DIR . '/admin-options.php' );

function m2pre($arr){ 
    echo "<pre>"; print_r($arr); echo "</pre>";
}

/*/////////////////////////////////////////////////////
	* Shortcode
/////////////////////////////////////////////////////*/
function _m2Shortcode($atts){	
    global $store_name;
	$atts = shortcode_atts(array(
		'storename' => $store_name
	), $atts);

	return _m2StoreBuild();
}

/*/////////////////////////////////////////////////////
	* Options function
/////////////////////////////////////////////////////*/
function _m2options($option_name) {
    $options = get_option( 'rg_store_options' );
    return $options[$option_name];
}

/*/////////////////////////////////////////////////////
	* Currencies Symbols '' => '',
/////////////////////////////////////////////////////*/ 
$currencies = array( 'ANG' => '&fnof;', 'ARS' => '&#36;', 'AUD' => '&#36;', 'BGN' => '&#1083;&#1074;', 'BRL' => 'R&#36;', 'CAD' => '&#36;', 'CHF' => 'CHF', 'CLP' => '&#36;', 'CNY' => '&yen;', 'COP' => '&#36;', 'CZK' => '&nbsp;&#75;&#269;', 'DKK' => 'DKK&nbsp;', 'DOP' => 'RD&#36;', 'EGP' => '&pound;','EEK' => 'kr', 'EUR' => '&euro;', 'GBP' => '&pound;', 'HKD' => '&#36;', 'HUF' => '&#70;&#116;', 'IDR' => 'Rp', 'ILS' => '&#8362;', 'ISK' => 'kr', 'JPY' => '&yen;','LTL' => 'Lt', 'LVL' => 'Ls', 'MXN' => '&#36;', 'MYR' => 'RM', 'NOK' => 'kr', 'NZD' => '&#36;', 'PHP' => '&#8369;', 'PLN' => 'z&#322;', 'RON' => 'lei','RSD' => '&#1044;&#1080;&#1085;.', 'SEK' => 'kr', 'SGD' => '&#36;', 'THB' => '&#3647;', 'TRL' => '&#8356;', 'TWD' => 'NT&#36;', 'UAH' => '&#8372;', 'USD' => '&#36;', 'UYU' => '&#36;U', 'VEF' => 'Bs', 'VND' => '&#8363;', 'ZAR' => 'R'
);


/*/////////////////////////////////////////////////////
	* Error handling
/////////////////////////////////////////////////////*/
function _m2jsonValidate($jsonObj, $assoc_array = FALSE){
    // decode the JSON data
    $result = json_decode($jsonObj, $assoc_array);

    // switch and check possible JSON errors
    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            $error = ''; // JSON is valid
            break;
        case JSON_ERROR_DEPTH:
            $error = 'Maximum stack depth exceeded.';
            break;
        case JSON_ERROR_STATE_MISMATCH:
            $error = 'Underflow or the modes mismatch.';
            break;
        case JSON_ERROR_CTRL_CHAR:
            $error = 'Unexpected control character found.';
            break;
        case JSON_ERROR_SYNTAX:
            $error = 'Syntax error, malformed JSON.';
            break;
        // only PHP 5.3+
        case JSON_ERROR_UTF8:
            $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
            break;
        default:
            $error = 'Unknown JSON error occured.';
            break;
    }

    if($error !== '') {
        return FALSE;
    } else {
    	return TRUE;
    }
}

function _m2loadAPI($apiCall) {

	$ch = curl_init( $apiCall );

	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt( $ch, CURLOPT_HEADER, 0);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT ,0); 
	curl_setopt( $ch, CURLOPT_TIMEOUT, 2); //timeout in seconds

	$json = curl_exec( $ch );
	$http_resp = curl_getinfo($ch,CURLINFO_HTTP_CODE);
	$good_resp = array('200', '304');
	if(curl_errno($ch) || !in_array($http_resp, $good_resp))
	{
		if(curl_errno($ch)) { 
			$err = "CURL error number ". curl_errno($ch) ." on ". $apiCall;
		} else {
			$err = "HTTP error " .$http_resp ." on ". $apiCall;
		}
		error_log($err);
	    return FALSE;

	} else {

		return $json;
	}

}

function _m2getData( $call, $tName ){
    if ( false === ( $json = get_transient( $tName ) ) ) {
	
		  if($call = _m2loadAPI($call)) { 
	    	if(_m2jsonValidate($call)) { 
	    		 $json = $call;
	       		 set_transient( $tName, $call, $expires );
	       		 set_transient( $tName.'_backup', $call, 0 );
	       	} else {
		    	$json = get_transient( $tName.'_backup');
		    	$err = "Invalid JSON retured from ". $call;
		    	error_log($err);
	       	}
	    } else {
	   		$json = get_transient( $tName.'_backup');
	    	// $lastSuccess = date('l jS \of F Y h:i:s A',strtotime( $json['meta'][0]['generated']));
	    	$err = "Error calling ". $call;
	    	error_log($err);
	    }
	}
	return $json;			
}

/*/////////////////////////////////////////////////////
* Sets store country from stores API
/////////////////////////////////////////////////////*/
function _m2countries(){
  global $settings, $store_name, $keyID, $host, $version, $expires, $country, $storeID;

  $storeAPI = 'http://'.$host.'/'.$version.'/stores/'.$storeID.'?key='.$keyID;
  $tName = 'store_countries_'.$store_name;
    $store = json_decode(_m2getData($storeAPI, $tName), true);
    if( empty($store) ){
      return;
    } else {
      $s_country = $_SERVER['HTTP_CLOUDFRONT_VIEWER_COUNTRY'];
      if( in_array($s_country, $store['results'][0]['countries']) ){
        return $s_country;
      } else {
        return 'US';
      }
    }
}

/*/////////////////////////////////////////////////////
	* Gets store tabs from tabs API
	* Creates settings of all tabs
/////////////////////////////////////////////////////*/
function _m2getStoreTabs(){
   global $settings, $store_name, $keyID, $host, $version, $expires, $tabs, $checkbox_options, $defaulttab, $country;
   
   if( $settings['store_username'] != ''):
   	  	$tabsAPI = 'http://'.$host.'/'.$store_name.'/'.$version.'/tabs.json?key='.$keyID.'&amp;current_country='.$country;
   	  
      	$tName = 'store_tabs_'.$store_name.'_'.$country;
      	$tab = json_decode(_m2getData($tabsAPI, $tName), true);      
      		
   		if( empty($tab) ){
   		 	return;
   		} else {
   		   for($i = 0; $i < count($tab['results']); $i++){
   				$results = $tab['results'][$i];
   				$id = $results['id'];
   				$tab_type = $results['tab_type'];
   				$name = $results['name'];
   				$title = $results['title'];
   				$default_tab = $results['default_tab'];
   				
   				if($results):								
   					array_push( $tabs, array(
   					   'id' => $id,
   					   'tab_type' => $tab_type,
   					   'name' => $name,
   					   'title' => $title,
   					   'default_tab' => $default_tab
   					));
   					
   					$defaulttab[$id] = array( 'default_tab' => $default_tab );
   									
   					$checkbox_options[$id] = array(
   					   'label' => $title,  
   					   'value' => $id,
   					);
   				endif;
   		   }//for
   		}//else
   endif;
}


/*/////////////////////////////////////////////////////
	* Post Type Creation
/////////////////////////////////////////////////////*/
function _m2postTypeCreate(){
	global $settings, $postname, $typeID;
	
 	if($settings['store_post_types'][0][0] != ''):
 		_m2createPostType();
		_m2createPage();
		_m2postTypeOpts();
	endif;
}
/*/////////////////////////////////////////////////////
	* Creates a post type for each selected tab
/////////////////////////////////////////////////////*/
function _m2createPostType(){
    global $settings, $postname, $typeID;
    
    if($settings['store_post_types'][0][0] != ''):
    	foreach($settings['store_post_types'] as $type):
			$typeID = $type[0];
			$postname = $type[1];
			$icon = $type[2];
			// m2pre($settings);
    		$labels = array(
    		   'name' => __( $postname, 'rg-m2' ),
    		   'singular_name' => __( $postname.' Post', 'rg-m2' ),
    		   'add_new' => __( 'Add '.$postname.' Post', 'rg-m2' ),
    		   'add_new_item' => __( 'Add '.$postname.' Post', 'rg-m2' ),
    		   'edit_item' => __( 'Edit '.$postname.' Post', 'rg-m2' ),
    		   'new_item' => __( 'New '.$postname.' Post Item', 'rg-m2' ),
    		   'view_item' => __( 'View '.$postname.' Post', 'rg-m2' ),
    		   'search_items' => __( 'Search '.$postname.' Post', 'rg-m2' ),
    		   'not_found' => __( 'Nothing found', 'rg-m2' ),
    		   'not_found_in_trash' => __( 'Nothing found in Trash', 'rg-m2' ),
    		   'parent_item_colon' => ''
    		);
    		$args = array(
    		   'labels' => $labels,
    		   'public' => true,
    		   'exclude_from_search' => false,
    		   'show_ui' => true,
    		   'show_in_nav_menus' => false,
    		   'capability_type' => 'post',
    		   'hierarchical' => false,
    		   'has_archive' => false,
    		   //'rewrite' => array('slug' => strtolower($postname)),
    		   'query_var' => true,
    		   'menu_icon' => 'dashicons-'.($icon ? $icon : 'wordpress'),
    		   'supports' => array( 'title', 'editor', 'thumbnail' ),
    		);
    		register_post_type( 'rg'.strtolower($postname), $args );
    		flush_rewrite_rules();
    	endforeach;
    endif;
}
/*/////////////////////////////////////////////////////
	* Creates a page for each post type
/////////////////////////////////////////////////////*/
function _m2createPage(){
    global $settings, $postname, $typeID;
    
    if($settings['store_post_types'][0][0] != ''):
	   foreach($settings['store_post_types'] as $type):
		  $typeID = $type[0];
		  $postname = $type[1];
	   	  
		  $page_title = $postname;
		  $page_name = strtolower($postname);
		  $page_content = 'This is the '.$postname.' Page Template';
		  $page_template = 'page-template/'.strtolower($postname).'-page.php';
		  $page_check = get_page_by_title( $page_title );
		  
		  $new_post = array(
		    'post_title' => $page_title,
		    'post_content' => $page_content,
		    'post_status' => 'publish',
		    'comment_status' => 'closed',
		    'ping_status' => 'closed',
		    'post_type' => 'page'
		  );
		     
		  if (!isset($page_check->ID)):
		     $page_ids[ $postname ] = wp_insert_post( $new_post );
		     update_post_meta( $page_ids[ $postname ], '_wp_page_template', $page_template );
		  endif;
	   endforeach;
	endif;
}
/*/////////////////////////////////////////////////////
	* Creates a select field for each post type
	  based on the selected tab
/////////////////////////////////////////////////////*/
function _m2postTypeOpts(){
	global $settings, $store_name, $keyID, $host, $version, $expires, $country, $tab_options, $postname, $typeID;
	
	if($settings['store_post_types'][0][0] != ''):
		require_once( 'm2_meta_box.php' );
		foreach($settings['store_post_types'] as $type):
		   $typeID = $type[0];
		   $postname = $type[1];

		   $PostTab = 'http://'.$host.'/'.$store_name.'/'.$version.'/tabs/'.$typeID.'.json?key='.$keyID.'&amp;current_country='.$country;
		   $tName = 'store_'.strtolower($postname).'_tab_'.$typeID.'_'.$country;
		   $tab = json_decode(_m2getData($PostTab, $tName), true);
		   		   
		    if( empty($tab) ){
		        return;
		    } else {
		       $tab_options = array();
		    	  
		       for($i = 0; $i < count($tab['results']); $i++){
		     	$results = $tab['results'][$i];
		     	$id = $results['id'];
		     	$name = $results['name'];
		     	$title = $results['title'];
		     	   			
		     	$tab_options[$id] = array(
		     	   'label' => $title,
		     	   'value' => $id,
		     	);
		       }
		    }
		    
		    $prefix = 'rg_';
		    $m2fields = array(
		        array(
		            'label'	=> $postname,
		            'desc'	=> 'Select the '.strtolower($postname).' here.',
		            'id'	=> $prefix.'select_'.strtolower($postname),
		            'type'	=> 'select',
		            'options' => $tab_options
		        )
		    );
		    $metaBox = new _M2customMetaBox( strtolower($postname).'_post_box', $postname.' Select Options', $m2fields, 'rg'.strtolower($postname), true );
   		   
		endforeach;
	endif;
}

/*/////////////////////////////////////////////////////
	* Main build function
/////////////////////////////////////////////////////*/	
function _m2StoreBuild(){
    global $settings, $store_name, $keyID, $host, $version, $expires, $currencies, $products, $checkbox_options, $defaulttabs, $item_id, $country, $value, $data;
    
    $output = '<div id="store-block" class="clearfix">' . "\n";
    if($settings['store_username'] != ''){

    	if(count($settings['store_tabs']) > 1):
    	$output .= '<div class="tab-container">';
    	  $output .= '<ul class="filter-subnav">';
    		   foreach($settings['store_tabs'] as $key => $value):
    		     if($value):
    		     	  $output .= '<li class="tab '.( $defaulttab[$value]['default_tab'] == 'true' ? "default-tab" : "" ).'">';
    		     	  	  $output .= '<a href="javascript:;" tab-id="'.$value.'">'.$checkbox_options[$value]['label'].'</a>';
    		     	  $output .= '</li>';
    		     endif;
    		   endforeach;
    		$output .= '</ul>';
    	$output .= '</div>';
    	endif;
    	
    	$output .= '<div class="tabs-list-container">';
    		if($settings['store_tabs'] != ''):
    	   		foreach($settings['store_tabs'] as $key => $value):
    				$tabAPI = 'http://'.$host.'/'.$store_name.'/'.$version.'/tabs/'.$value.'.json?key='.$keyID.'&amp;expand=instances,preview&amp;current_country='.$country;
    				if($value):
    					foreach((array)$key as $tab):
    						$tName = 'store_tab_'.$value.'_'.$country;
							  $data = json_decode(_m2getData($tabAPI, $tName), true);
    						
							if( empty($data) ){
							   return;
							} else {
							 $output .= '<div class="tab-list" tab-id="'.$value.'">';
							 $output .= '<ul id="products-list-'.$key.'" class="products-list '.$checkbox_options[$value]['label'].'">';
							 	for($i = 0; $i < count($data['results']); $i++){
							 	   	$results = $data['results'][$i]; 
							 	   	$title = $results['title']; 
							 	   	$item_id = $results['id'];
							 	   	$tracks = $results['tracks'];
							 	   	$instance = $results['instances'];
							 	   	$instancePrice = str_replace(',', '.', $results['instances'][0]['pricing']['source_display']);
							 	   	$currency = $results['pricing']['currency'];
							 	   	$amount = str_replace(',', '.', $results['pricing']['amount']);
							 	   	$price = $results['pricing'][0]['source_display'];
							 	   	$bundles = $results['bundles'];
							 	   	$type = $results['type']; 
							 	   	$album_id = $results['album']; 
							 	   	$graphic = $results['graphic']; 
							 	   	$all_images = $results['all_images']; 
							 	   	$available = $results['stock_info'][0]['available'];
							 	   	$purchaseable = $results['stock_info'][0]['purchaseable'];
							 	   	$summary = $results['stock_info'][0]['summary']; 
							 	   	$detail = $results['stock_info'][0]['detail'];
							 	   	$track_preview = $results['preview']['media']['s3']['master'];
							 	   	$duration = $results['duration'];
							 	   	$year = $results['year'];
							 	   	$tags = $results['tags'][0]['name'];
							 	   	/// subscription_type && pin_code_type
							 	   	$name = $results['name']; 
							 	   	$redemption_instructions = $results['redemption_instructions']; 
							 	   	$url_base = $results['url_base']; 
							 	   	$kind = $results['kind'];
							 	   	/// generic_physical_product type
							 	   	$short_description_html = $results['short_description_html']['en'];
							 	   	$long_description_html = $results['long_description_html']['en'];
							 	   
							 	   	
							 	   $output .= '<li class="product '.$type.' '.($i % 2 ? 'even' : 'odd').'">';
							 	       if($type == 'track'){
							 	       		$output .= '<ul class="'.$type.'">';
							 		 	  	 	if($graphic):
							 		 	  	 	$output .= '<li><img class="track-img-frame" alt="'.$title.'" src="'.$graphic.'" style="max-width:50px;"></li>';
							 		 	  	 	endif;
							 		 	  	 	if($track_preview):
							 						$output .= '<li class="track-url">';
							 						    $output .= '<audio src="'.$track_preview.'" preload="auto" type="audio/mp3"></audio>';
							 						$output .= '</li>';
							 				    endif;
							 				    $output .= '<li><h3 class="product_name">'.$title.'</h3></li>';
							 				    if($purchaseable == true):
							 				    	if($amount){ $output .= '<li class="product_price">'.$price.'</li>'; }
							 					    $output .= '<li>';
							 					       $output .= '<div class="product_add btn" item-id="'.$item_id.'">';
							 					       	if($settings['store_bb_text'] != ''){ 
							 					       		$output .= $settings['store_bb_text']; 
							 					       	} else { 
							 					       		$output .= '<span>+</span>'; 
							 					       	}
							 					       	$output .= '<span class="icon">&nbsp;</span>';
							 					       $output .= '</div>';
							 					   $output .= '</li>';
							 					endif;
							 		 	  	$output .= '</ul>';
							 	     	} else {
							 	     	  	$output .= '<div class="img-frame">';
							 	     	  		if($settings['store_activate_qv'] != ''):
							 	     	  			$output .= '<span class="quick-view" data-url="/store/product/'.$item_id.'">Quick View</span>';
							 	     	  		endif;
							 	     	  		$output .= '<a href="/store/product/'.$item_id.'">';
							 	     	  	 		$output .= '<img alt="'.$title.'" src="'.$graphic.'" class="product_img">';
							 		 	  	 	$output .= '</a>';
							 		 	  	 $output .= '</div>';
							 	     	  	 $output .= '<div class="details">';
							 	     	  	 	$output .= '<div class="view_product btn">';
							 	       				$output .= '<a href="/store/product/'.$item_id.'" title="View">';
							 	       				    $output .= '<span>View</span>';
							 	       				$output .= '</a>';
							 		   			$output .= '</div>';
							 	     	  	    $output .= '<a href="/store/product/'.$item_id.'" title="'.$title.'" class="product_title">'.$title.'</a>';
							 	     	  	    if($instance){
							 	     	  	       $output .= '<p class="product_price">'.$instancePrice.'</p>';
							 	     	  	    } else {
							 	     	  	       $output .= '<p class="product_price">'.$price.'</p>';
							 	     	  	    }
							 	     	  	 $output .= '</div>';
							 	     	}
							 	   $output .= '</li>';
							 		
							 	 }//for
							 									 
							 $output .= '</ul>';
							 $output .= '<script type="text/javascript">
							 			    jQuery(function($) {
							 			 	 	$("#products-list-'.$key.'").paginate({ 
							 			 	 		count: '.count($data['results']).', 
							 			 	 		itemsPerPage: '.($settings['store_pagination'] ? $settings['store_pagination'] : 9).'
							 			 	 	});
							 			    });
							 			</script>';
							 $output .= '<div id="products-list-'.$key.'-pagination" class="m2-pagination">';
							     $output .= '<div id="products-list-'.$key.'-previous" class="btn disabled"><a href="#">&laquo; Previous</a></div>';
							     $output .= '<div id="products-list-'.$key.'-numbers"></div>';
							     $output .= '<div id="products-list-'.$key.'-next" class="btn"><a href="#">Next &raquo;</a></div>';
							 $output .= '</div>';
							 
							 $output .= '</div>';
							 }//else
    					endforeach;// (array)$key
    				endif;// $value
    			endforeach;//$settings['store_tabs']
    		else:
    			$output .= '<h1 class="message">Please select at least one tab from the settings menu. <a href="'.get_bloginfo('wpurl').'/wp-admin/options-general.php?page=rg-m2-settings">Settings</a></h1>';
    	   	endif;
    	$output .= '</div>';
    	
    }//if
    
    $output .= "</div>\n";
    
    return $output;

}

/*/////////////////////////////////////////////////////
	* Enqueue Scripts
/////////////////////////////////////////////////////*/
function _m2EnqueueScripts() {
    global $settings, $store_name, $keyID, $host, $version, $country, $checkout_host, $cartContainer, $cartImageSize, $api, $cartThumb, $cartPrice;
    if ( !is_admin() ) {
    	wp_enqueue_script('jquery');
    	wp_enqueue_script( 'm2-jsonp', RG_M2_URL . '/js/jquery.jsonp.2.4.0.js', array('jquery'), '2.4.0', true);
    	wp_enqueue_script( 'm2-cart', RG_M2_URL . '/js/m2store.js', array( 'jquery' ), true );
    	wp_localize_script( 'm2-cart', 'm2store', array( 
    		'storename' => $store_name, 
    		'api' => $api, 
    		'host' => $host,
    		'checkout_host' => $checkout_host,
    		'keyID' => $keyID,
    		'version' => $version,
    		'country' => $country,
    		'cartContainer' => $cartContainer,
    		'cartImageSize' => $cartImageSize,
    		'cartThumb' => $cartThumb,
    		'cartPrice' => $cartPrice,
    		'directory' => get_bloginfo( 'template_directory' )
    	) );
    	if($settings['store_activate_me'] != '' && is_page_template('page-template/product-page.php')):
    		wp_enqueue_script( 'wp-mediaelement' );
			wp_enqueue_style( 'm2-genericons', RG_M2_URL . '/css/fonts/genericons.css', array(), '3.0.2' );
		endif;
		if($settings['store_select'] == 'dropdown'):
			wp_enqueue_script('m2-chosen', RG_M2_URL . '/js/chosen.jquery.min.js' );
			wp_enqueue_style('m2-chosen-style', RG_M2_URL. '/css/chosen.css' );
		endif;
    }
}

/*/////////////////////////////////////////////////////
	* JS / Function to build cart
/////////////////////////////////////////////////////*/		
function _m2CartScript(){
    global $settings, $store_name, $keyID, $host, $version, $country, $checkout_host, $cartContainer, $cartImageSize;
	   
    if ( !is_admin() ) {
    	
    	?>
    	<script type="text/javascript">
			jQuery(function($){
    	
			///////////////////////////////////////////////////////// OTHER SCRIPTS //////////////////////////////////////////////////    	
				$('.tab-list:first-child').css({ opacity: 0 }).stop().show().animate({ opacity: 1 }, { duration: 1000 });
		
			<?php if($settings['store_activate_qv'] != ''): ?>
				$('.img-frame').hover(function(){
				    $('.quick-view', this).stop().animate({ top:'199px' },{ queue:false, duration:160 });
				}, function() {
				    $('.quick-view', this).stop().animate({ top:'235px' },{ queue:false, duration:160 });
				});
				
				$('.quick-view').on('click', function(e){				
				    var box = $(this);											
				    var url = box.attr('data-url');

				    $.fancybox.showLoading();
				    
				    $.get(url, function(data){
				    	var productContent = $('#store-product-detail',data);
				    	$.fancybox.hideLoading();
				    	$.fancybox.open({
				    		href : url,
				    		type : 'html',
				    		padding : 10,
				    		scrolling : false,
				    		autoSize : true,
				    		autoWidth : true,
				    		autoHeight : true,
				        	content : productContent
				    	});
				    	$.fancybox.update();
				    	
				    	$('.img-frame-details .product_thumb li a').live('click', function(e){
				    		e.preventDefault();
				    		var imgSrc = $(this).attr('href');
				    		var gallery = $('.main_product_img:first');
				    		
				    		gallery.each(function(){ 
				    		    if ( $(this).length ) {
				    		       $(this).animate({ opacity:0 },function(){
				    		       	  var imageObj = new Image();
				    		    	      imageObj.src = imgSrc;
				    		    	      imageObj.addEventListener('load', function() { 
				    		    	  		gallery.attr('src', imgSrc).animate({ opacity:1 }); 
				    		    	  	 }, false);
				    		       });
				    		       return false;
				    		    }
				    		    return true;
				    		});
				    	});
				    	
				    	<?php if($settings['store_activate_me'] != ''): ?>
				    	    var controls = ["playpause"];			
				    	    $(".track-url audio").mediaelementplayer({ features: controls, pauseOtherPlayers: true });
				    	<?php endif; ?>
				    	
				    },'html');
				    e.preventDefault();        
				    //history.pushState(null, null, url);
				});
			<?php endif; ?>
    		
    		<?php if(is_page_template('page-template/store-page.php')): ?>
    		
				$('.filter-subnav li a').each(function(current){
				 var current = $(this);
				 current.attr('tab-id');
				
				 current.live('click', function(e) {
				 	 //window.location.hash = current.attr('data-hash');
				     tabSwitch(current);
				     e.preventDefault();
				 });
				 
				});
				
				function tabSwitch(current){			    
				   $('.filter-subnav li a').parent().removeClass('active');
				   current.parent().addClass('active');
				   
				   var id = current.attr('tab-id');
				   var tabs = $('.tab-list');
				   var tabsAttr = $('.tab-list[tab-id="'+id+'"]');
				   
				   tabs.hide();
				   tabsAttr.fadeIn(1000);
				}
    		<?php endif; ?>
    		
    		<?php if($settings['store_activate_fb'] != '' && is_page_template('page-template/product-page.php')): ?>
    		$('.product_thumb li a').fancybox({
    			padding: 0,
    		    helpers	: {
    		    	title	: {
    		    		type: 'outside'
    		    	},
    		    	thumbs	: {
    		    		width	: 50,
    		    		height	: 50
    		    	}
    		    }
    		});
    		<?php endif; ?>
    		
    		<?php if($settings['store_activate_me'] != '' && is_page_template('page-template/product-page.php')): ?>
    			var controls = ["playpause"];			
				$(".track-url audio").mediaelementplayer({ features: controls, pauseOtherPlayers: true });
			<?php endif; ?>
			
			<?php if($settings['store_select'] == 'dropdown' && is_page_template('page-template/product-page.php')): ?>
				$('.instance_select').chosen({ 
				    width: "100%",
				    disable_search_threshold: 10
				});
			<?php endif; ?>
    	});
    	</script>
    	<?php
    }
}

/*/////////////////////////////////////////////////////
	* Default CSS
/////////////////////////////////////////////////////*/
function _m2DefaultCss(){
    global $settings;
    if ( !is_admin() && is_page_template('page-template/store-page.php') || is_page_template('page-template/product-page.php') ) {
    	?>
    	<style type="text/css">
    	   .product_loading { background: rgba(0,0,0,.6); display: block; width: 100%; height: 100%; position: absolute; top: 0; left: 0; z-index: 50; }
		   .product_loading .product_loading_inner { position: absolute; left: 50%; top: 50%; margin-left: -30px; margin-top: -7.5px; }
		   .product_loading .box { background-color:#2187e7; background-image: -moz-linear-gradient(45deg, #2187e7 25%, #a0eaff); background-image: -webkit-linear-gradient(45deg, #2187e7 25%, #a0eaff); border-left:1px solid #111; border-top:1px solid #111; border-right:1px solid #333; border-bottom:1px solid #333; width: 15px; height: 15px; display: inline-block; margin-left:5px; opacity:0.1; transform:scale(0.7); -moz-transform:scale(0.7); -webkit-transform:scale(0.7); -moz-animation:move 1s infinite linear; -webkit-animation:move 1s infinite linear; }
		   .product_loading #box_1 { -moz-animation-delay: .2s; -webkit-animation-delay: .2s; animation-delay: .2s; }
		   .product_loading #box_2 { -moz-animation-delay: .3s; -webkit-animation-delay: .3s; animation-delay: .3s; }
		   .product_loading #box_3{ -moz-animation-delay: .4s; -webkit-animation-delay: .4s; animation-delay: .4s; }
		   @-moz-keyframes move{
		       0%{ -moz-transform: scale(1.2); opacity:1; }
		       100%{ -moz-transform: scale(0.7); opacity:0.1; }
		   }
		   @-webkit-keyframes move{
		       0%{ -webkit-transform: scale(1.2); opacity:1; }
		       100%{ -webkit-transform: scale(0.7); opacity:0.1; }
		   }
		   .sale-price .product_loading { display: none; }
		   .empty { color: #fff; }
		   .m2-pagination { margin: 20px 0; }
		   .m2-pagination div { display: inline-block; }
		   .product_add { position: relative; }
		   .b-squeeze { padding: 15px 22px; }
    	   .empty { color: #000; }
    	   .filter-subnav li { display: inline-block; padding: 0 10px; }
    	   .products-list img { width: 100%; }
    	   .product { width: 235px; margin-bottom: 20px; display: inline-block; vertical-align: top; margin: 5px; z-index: 0; position: relative; }
    	   .product.track { display: block; width: 100%; }
    	   .tab-list { display: none; }
    	   .products-list h3, .products-list .product h3 {font-size: 1.2em;line-height: 1.205;font-weight: bold;}
    	   .products-list .product h3 a { color: #000000; text-decoration: none; }
    	   .products-list .img-frame { position: relative; overflow: hidden; }
    	   .quick-view { position: absolute; top: 235px; width: 100%; background: rgba(0,0,0,.8); padding: 10px 0; text-align: center; color: #fff; cursor: pointer; z-index: 10; }
    	   .products-list div.details div.formats { margin: 5px 0;font-size: 90%;}
    	   .products-list .details-text { overflow: hidden; }
    	   .products-list ul.track li { display: inline-block; } 
    	   .view_product { float: right; }
    	   .view_product a {}
    	   .view_product a span {}
    	   .product_title { float: left; max-width: 215px; }
    	   .product_price { clear: both; }
    	   .btn { 
    	   		padding: 2px 10px;
    	   		display: inline-block;
    	   		-moz-border-radius: 0;
    	   		-webkit-border-radius: 0;
    	   		border-radius: 0;
    	   		-moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
    	   		-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.5);
    	   		box-shadow: 0 1px 3px rgba(0,0,0,0.5);
    	   		background: url(<?php echo RG_M2_URL; ?>/images/button-overlay.png) repeat-x scroll 0 0 <?php echo $settings['store_bb_color']; ?>;
    	   		border-bottom: 1px solid rgba(0, 0, 0, 0.25);
    	   		cursor: pointer;
    	   		position: relative;
    	   }
    	   .btn a, .btn span, .btn .txt {
    	      font: bold 13px/28px 'Arial', sans-serif;
    	   	  text-transform: uppercase;
    	   	  text-align: center;
    	   	  font-style: normal;
    	   	  color: <?php echo $settings['store_bb_text_color']; ?>;
    	   	  text-decoration: none;
    	   	  text-shadow: 0 -1px 1px rgba(0, 0, 0, 0.25);
    	   	  padding: 0 8px; 
    	   }
    	   .btn:hover {
    	   	  background: url(<?php echo RG_M2_URL; ?>/images/button-overlay.png) repeat-x scroll 0 0 <?php echo $settings['store_bb_hover_color']; ?>;
    		  outline: none;
    		}
    	   .product-select { margin: 15px 0; }
    	   .product-detail {}
    	   .product-detail .img-frame-details { float: left; max-width: 390px; margin: 0 20px 0 0; }
    	   .product-detail .img-frame-details img {}
    	   .product_thumb { padding: 20px 0 0; }
    	   .product_thumb li { display: inline-block; max-width: 75px; padding: 0 3px 5px}
    	   .product-description { float: left; }
    	   .product-description .product_title { float: none; max-width: 100%; font-size: 25px; padding: 0 0 20px; }
    	   .product-description .product_title p { font-size: 12px; }
    	   .product-description .m2Cart-product { padding: 0 0 20px; }
    	   .product-description .m2Cart-product li { display: inline-table; padding: 0 10px 0; }
    	   .product-description .m2Cart-product .type-name {}
    	   .type-name h3 {}
    	   .type-name .availability { font-size: 12px; }
    	   .price-container {}
    	   .price-container .product_price {}
    	   .action .add_to_cart { height: 27px; }
    	   
    	   .instance div.txt { display: inline-block; }
    	   .instance span.icon { display: inline-block;zoom: 1;margin-left: 5px;text-indent: -9999px;width: 20px;background: url(//images.myplaydirect.com/autoimage/display/sprite/b=000000/w=ffffff/media.myplaydirect.com/m2/images/m2_sprite_r28.png/m2_sprite_r28) no-repeat scroll;background-position: -416px -42px; }
    	   .added { display: none; }
    	   .instance.in_cart .added { display: block; }
    	   .instance.in_cart .num { display: none; }
    	   
    	   .track-list {}
    	   .track-list .track {}
    	   .track-list .track li { display: inline-block; }
    	   
    	   .cart-btn-container .m2-row { display: none; }
    	   .cart-btn-container .m2-row.active { display: inline-block; }
    	   .cart-btn-container .m2-row .product_name, .cart-btn-container .m2-row .product_price, .cart-btn-container .m2-row .availability, .cart-btn-container .m2-row .product_image, .single-item span.product_image, .M2_product-container .product_image { display: none !important; }
    	   
    	   .mejs-container, .mejs-controls { width: 30px !important; height: 30px; }
		   .mejs-button.mejs-playpause-button button { display: none; visibility: hidden; }
		   .mejs-button.mejs-playpause-button { display: inline-block; -webkit-font-smoothing: antialiased; font: normal 22px/1 'Genericons'; color: #117399; text-decoration: none; vertical-align: middle; width: 30px; height: 30px; border: 4px solid #fff; cursor: pointer; margin: 0; padding: 0; -moz-border-radius: 30px;
		   -webkit-border-radius: 30px; border-radius: 30px; background: #000000; -webkit-transition: all 0.2s ease-in; -moz-transition: all 0.2s ease-in; -o-transition: all 0.2s ease-in; -ms-transition: all 0.2s ease-in; box-shadow: 2px 2px 6px 0px rgba(0,0,0,0.5); -webkit-box-shadow: 2px 2px 6px 0px rgba(0,0,0,0.5); -moz-box-shadow: 2px 2px 6px 0px rgba(0,0,0,0.5); }
		   .mejs-button.mejs-playpause-button.mejs-play:before { content: '\f452'; }
		   .mejs-button.mejs-playpause-button.mejs-pause:before { content: '\f448'; }
		   .mejs-button.mejs-playpause-button:hover, .mejs-button.mejs-playpause-button.mejs-pause { border-color: #000; background-color: #117399; color: #fff; }
		   
		   .pagination li { display: inline-block; padding: 0 5px; }
		   .pagination li a.active { color: #a30000; }
		   
		   .loading_time { position: fixed; background: rgba(0,0,0,.85); width: 100%; height: 100%; z-index: 99999; }
		   .loading_time_inner { position: absolute; left: 50%; top: 50%; width: 100px; height: 100px; margin-left: -50px; margin-top: -50px; }
		   .loading_time_inner span { font: 700 18px/18px 'Arial', sans-serif; color: #fff; text-align: center; display: block; padding: 10px 0 0; }
		   
    		</style>
    	<?php
    }
}

/*/////////////////////////////////////////////////////
	* Create the submenu links in plugins page
/////////////////////////////////////////////////////*/	
function _m2PluginActionLink($links, $file) {
    static $this_plugin;
    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }
    // check to make sure we are on the correct plugin
    if ($file == $this_plugin) {
    	// link to what ever you want
        $plugin_links[] = '<a href="'.get_bloginfo('wpurl').'/wp-admin/options-general.php?page=rg-m2-settings">'.__('Options', RG_M2_LOCALE).'</a>';
         // add the links to the list of links already there
    	foreach($plugin_links as $link) {
    		array_unshift($links, $link);
    	}
    }
    return $links;
}
//add_filter('plugin_action_links', '_m2PluginActionLink', 10, 2);

// Cron Update Transients

function synchronize_trans(){
  global $wpdb;
  $time_now = time();//OR option_value+0 < $time_now
  $transients = $wpdb->get_col( "SELECT option_name FROM $wpdb->options where option_name LIKE '_transient_%'" );
  if( empty( $transients ) ) {
    return false;
  }
  foreach( $transients as $transient ) {
    $string = array('_transient_', '_transient_timeout_');
    $name = str_replace( $string, '', $transient );     
    delete_transient( $name );
  }  
  _m2getStoreTabs();
  _m2postTypeCreate();
}

add_action('synchronize_trans_cron_job', 'synchronize_trans');

function add_synchronize_trans_cron_job() {
    if (!wp_get_schedule('synchronize_trans_cron_job')) {
        wp_schedule_event(time(), 'minutes', 'synchronize_trans_cron_job');
    }
}

add_action('init', 'add_synchronize_trans_cron_job');

function remove_synchronize_trans_cron_job() {
    wp_clear_scheduled_hook('synchronize_trans_cron_job');
}

add_action('switch_theme', 'remove_synchronize_trans_cron_job');

?>