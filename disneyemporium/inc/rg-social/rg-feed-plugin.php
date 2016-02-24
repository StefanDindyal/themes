<?php
/*
Plugin Name: RG Social Feed
Description: A plugin for custom social feeds via shortcode, includes Facebook, Twitter & Instagram.
Version: 2.0.1
Author: rGenerator
Author URI: http://www.rgenerator.com/
License: GPL v2.0

*** Includes FancyBox and MediaElement.js Library for Instagram videos.
  
	define each as 
	echo do_shortcode('[rg_socialfeed twitter="ARTIST NAME" count="1"]');
*/

if ( ! function_exists( 'add_action' ) ) {
	_e( "Hi there! I'm just a plugin, not much I can do when called directly." );
	exit;
}

/* CONSTANTS
========================================================*/
if ( ! defined( 'RG_LOCALE' ) )
	define( 'RG_LOCALE', '' );
	
if ( ! defined( 'RG_SOCIAL_DIR' ) )
	define( 'RG_SOCIAL_DIR', get_template_directory() . '/inc/rg-social' );

if ( ! defined( 'RG_SOCIAL_URL' ) )
	define( 'RG_SOCIAL_URL', get_template_directory_uri() . '/inc/rg-social' );
	

/* Get the options from the admin panel
========================================================*/

function rg_option( $option ) {
	$options = get_option( 'rg_options' );
	if ( isset( $options[$option] ) )
		return $options[$option];
	else
		return false;
}

/* Register the shortcode
========================================================*/

function rg_options_init($options){
	$options = shortcode_atts( array(
		'facebook' => '',
		'twitter' => '',
		'instagram' => '',
		'instagramtag' => '',
		'limit' => 20,
		'date' => '',
		'mediatype' => 'all',
		'imagesize' => 'standard',
		'mediasize' => 'thumbnail'
	), $options );
	
	$current_feed = rg_socialfeed($options);
    if( $current_feed ) {
        return $current_feed;
    }
}
add_shortcode( 'rg_socialfeed', 'rg_options_init' );

//Enable Shortcodes in Sidebar Text Widgets
add_filter('widget_text', 'do_shortcode', 11);


/* THE MAGIC
========================================================*/

function rg_socialfeed($options = array()) {
	$output = '<div class="social-block clearfix">' . "\n";
	
	$new_options = array();
	
	if(!empty($options)){
		$new_options = $options;
	} else {
		$new_options = get_option( 'rg_options' );
	}
	
	$limit = $new_options['limit'];
			
	if ( ! $limit )
		$limit = 20;
			
	$flashPath = RG_SOCIAL_URL . '/js/flashmediaelement.swf'; // Flash fallback for the html5 video
	$access_token = '270065846467161%7Cb198YwI5BqA9Gf4x-fTLkPsFDJA';
	
	$int = 0;
	$expires = HOUR_IN_SECONDS;
	$jsonp = array();
	$feedurl = array();
	$feed_keys = array( 'facebook', 'twitter', 'instagram', 'instagramtag' );
		
	foreach ( $feed_keys as $key ):	
		if ( $new_options[ $key ] != '' ){
			$feedurl = rg_social_feed_url( $key, $new_options );			

			if($key == 'facebook'){
				if ( false === ( $json = get_transient( 'rg_facebook_'.$new_options['facebook'] ) ) ) {
					$json = file_get_contents($feedurl); 
					set_transient( 'rg_facebook_'.$new_options['facebook'], $json, $expires );
				}
				// delete_transient( 'rg_facebook_'.$new_options['facebook'] );
				$data = json_decode($json, true);
			} elseif($key == 'twitter'){
				if ( false === ( $json = get_transient( 'rg_twitter_'.$new_options['twitter'] ) ) ) {
					$json = file_get_contents($feedurl); 
					set_transient( 'rg_twitter'.$new_options['twitter'], $json, $expires );
				}
				// delete_transient( 'rg_twitter'.$new_options['twitter'] );
				$data = json_decode($json, true);
			} elseif($key == 'instagram'){
				if ( false === ( $json = get_transient( 'rg_instagram_'.$new_options['instagram'] ) ) ) {
					$json = file_get_contents($feedurl); 
					set_transient( 'rg_instagram_'.$new_options['instagram'], $json, $expires );
				}
				// delete_transient( 'rg_instagram_'.$new_options['instagram'] );
				$data = json_decode($json, true);
			} elseif($key == 'instagramtag'){
				if ( false === ( $json = get_transient( 'rg_instagramtag_'.$new_options['instagramtag'] ) ) ) {
					$json = file_get_contents($feedurl); 
					set_transient( 'rg_instagramtag_'.$new_options['instagramtag'], $json, $expires );
				}
				// delete_transient( 'rg_instagramtag_'.$new_options['instagramtag'] );
				$data = json_decode($json, true);
			}
			
			if( empty($data) )
				return;
						
			if($limit > count($data['data']))
				$limit = count($data['data']);
			
			for($i = 0; $i < $limit; $i++) {
            	$thedata = $data['data'][$i];
            	$type = $thedata['type'];
			   	$id = $thedata['id'];
				
				//INSTAGRAM
				if(isset($new_options['instagram']) || isset($new_options['instagramtag'])){
			    	 $created = $thedata['created_time'];
			    	 $inst_date = date('M j, Y', $created);			    	 
			    	 $full_date = date('U', strtotime($inst_date));
			    	 $dated = theRelativeTime($full_date);
			    	 $username = $thedata['user']['username'];
			    	 $instalikes = $thedata['likes']['count'];
			    	 $link = $thedata['link'];
			    	 $caption = (!empty($thedata['caption']['text'])) ? $thedata['caption']['text'] : '...';
			    	 
			    	 if(in_array($data['attribution'], $thedata) && $thedata['images']){ 
			    	 	$lowresimage = $thedata['images']['low_resolution']['url'];
			    	 	$standardimage = $thedata['images']['standard_resolution']['url'];
			    	 	$thumbnailimage = $thedata['images']['thumbnail']['url'];
			    	 	$w = $thedata['images']['low_resolution']['width'];
			    	 	$h = $thedata['images']['low_resolution']['height'];
			    	 }
			    		 
			    	 if( $thedata['videos'] ){ $videoURL = $thedata['videos']['standard_resolution']['url']; }
			    	 if( $link == null ){ $link = 'http://instagram.com/'.$username; }
			    	 
			    	 if (in_array($data['attribution'], $thedata) && $new_options['imagesize'] == 'thumbnail') {
			    	     $lowresimage = $thedata['images']['thumbnail']['url'];
			    	     $w = $thedata['images']['thumbnail']['width'];
			    	  	  $h = $thedata['images']['thumbnail']['height'];
			    	 } elseif (in_array($data['attribution'], $thedata) && $new_options['imagesize'] == 'standard') {
			    	     $lowresimage = $thedata['images']['low_resolution']['url'];
			    	     $w = $thedata['images']['low_resolution']['width'];
			    	  	  $h = $thedata['images']['low_resolution']['height'];
			    	 } elseif (in_array($data['attribution'], $thedata) && $new_options['imagesize'] == 'large') {
			    	     $lowresimage = $thedata['images']['standard_resolution']['url'];
			    	     $w = $thedata['images']['standard_resolution']['width'];
			    	  	  $h = $thedata['images']['standard_resolution']['height'];
			    	 }
			   }
				
				//TWITTER
				if($new_options['twitter'] != ''){
					$created_at = date('U', strtotime($thedata['created_at']));
			   	$txt = $thedata['text'];
			   	$screen_name = $thedata['user']['screen_name'];
			   	$tweetid = $thedata['id_str'];
			   	$followers_count = $thedata['user']['followers_count'];
			   	$profileImg = $thedata['user']['profile_image_url'];
			   	$tweetusername = $thedata['user']['name'];
			   }
			   
			   //FB
			   if($new_options['facebook'] != ''){
			   	$fbuserID = $thedata['user_id'];
			   	$updated_time = $thedata['updated_time'];
			   	$fblikes = $thedata['likes']['count'];
			   	$fbshare = $thedata['shares']['count'];
			   	$fbuser_id = $thedata['user_id'];
			   	$status_type = $thedata['status_type'];
			   	$medianame = $thedata['name']; // title for the link & video post
			   	$mediacaption = $thedata['caption']; //caption under $medianame for link & video post
			   	$mediadescription = $thedata['description']; //description for link & video post
			   	$linkproperties = $thedata['properties'][0]['text']; //shows "75,752 like this"
			   	$fbvideosource = $thedata['source'];
			   	$fbicon = $thedata['icon']; // small post type icon from FB
			   	$fbcommentslink = $thedata['actions'][0]['link'];
			   	
			   	$large_image = $thedata['images'];
			   	$fbimage = $thedata['picture'];
			   	$created_time = date('U', strtotime($thedata['created_time']));
			   	
			   	if($new_options['mediasize'] == 'thumbnail'){ 
			   		$fbimage = $thedata['picture']; 
			   	} elseif($new_options['mediasize'] == 'large'){
				   	$fbimage = $thedata['images'];
			   	}
			   	
			   	if($thedata['message']){
			   	   $message = $thedata['message'];
			   	} elseif($thedata['story']){
			   	   $message = $thedata['story'];
			   	}
			   }
			   
			   $UTC = $created + $created_at + $created_time;
			   
			   $variables[$UTC] = array(
			   	'key' => $key,
			   	'created_time' => $created_time,
			   	'type' => $type,
			   	'id' => $id,
			   	'inst_time' => $created,
			   	
			   	'username' => $username,
			   	'instalikes' => $instalikes,
			   	'lowresimage' => $lowresimage,
			   	'standardimage' => $standardimage,
			   	'thumbnailimage' => $thumbnailimage,
			   	'link' => $link,
			   	'caption' => $caption,
			   	'w' => $w,
			   	'h' => $h,
			   	'videoURL' => $videoURL,
			   	
			   	'txt' => $txt,
			   	'screen_name' => $screen_name,
			   	'tweetid' => $tweetid,
			   	'followers_count' => $followers_count,
			   	'profileImg' => $profileImg,
			   	'tweetusername' => $tweetusername,
			   	'created_at' => $created_at,
			   	
			   	'fbuserID' => $fbuserID,
			   	'updated_time' => $updated_time,
			   	'fblikes' => $fblikes,
			   	'fbshare' => $fbshare,
			   	'fbuser_id' => $fbuser_id,
			   	'fbimage' => $fbimage,
			   	'status_type' => $status_type,
			   	'medianame' => $medianame,
			   	'mediacaption' => $mediacaption,
			   	'mediadescription' => $mediadescription,
			   	'linkproperties' => $linkproperties,
			   	'fbvideosource' => $fbvideosource,
			   	'fbicon' => $fbicon,
			   	'fbcommentslink' => $fbcommentslink,
			   	'message' => $message,
			   	'large_image' => $large_image
			   );

			}//for
	}
	endforeach;
	
	ksort($variables);
	$string = array_reverse($variables);
	
	foreach($string as $item):
		
		if($new_options['date']){
			$tw_time = date($new_options['date'], $item['created_at']);
		   $fb_time = date($new_options['date'], $item['created_time']);
		   $inst_date = date($new_options['date'], $item['inst_time']);
		} else {
			$tw_time = theRelativeTime($item['created_at']);
		   $fb_time = theRelativeTime($item['created_time']);
		   $inst_date = theRelativeTime($item['inst_time']);
		}
	
		if($item['key'] == 'instagram' || $item['key'] == 'instagramtag') {
	      if($new_options['mediatype'] == 'all'){
	      	if($item['type'] == 'video'){
	      		if(rg_option( 'fancybox' )){
							$output .= '<div class="instagram-info '.$item['type'].'">';
							   $output .= '<a href="#video_'.$int.'" class="video_trigger" rel="instagram-media" title="'.$item['caption'].'" style="width:'.$item['w'].'px;height:'.$item['h'].'px;"><span></span><img src="'.$item['lowresimage'].'"/></a>';
							   	$output .= '<div id="video_'.$int.'" class="video_container" style="display:none;width:'.$item['w'].'px;height:'.$item['h'].'px;">';
							   	$output .= '<video poster="'.$item['lowresimage'].'" preload="none">';
							   	$output .= '<source type="video/mp4" src="'.$item['videoURL'].'"></source>';
							   	$output .= '<object width="'.$item['w'].'" height="'.$item['h'].'" type="application/x-shockwave-flash" data="'.$flashPath.'">';
							   	  $output .= '<param name="movie" value="'.$flashPath.'" />';
							   	  $output .= '<param name="flashvars" value="controls=true&width='.$item['w'].'&height='.$item['h'].'&file='.$item['videoURL'].'" />';
									  $output .= '<img src="'.$item['lowresimage'].'" title="'.$item['caption'].'" />';
									$output .= '</object>';
							   	$output .= '</video>';
							   	$output .= '</div>';
							$output .= '</div>';
						} else {
							$output .= '<div class="instagram-info '.$item['type'].'">';
							   $output .= '<div id="video_'.$int.'" class="video_container" style="width:'.$item['w'].'px;height:'.$item['h'].'px;">';
							   	$output .= '<video poster="'.$item['lowresimage'].'" preload="none" style="width:'.$item['w'].'px;height:'.$item['h'].'px;">';
							   	$output .= '<source type="video/mp4" src="'.$item['videoURL'].'"></source>';
							   	$output .= '<object width="'.$item['w'].'" height="'.$item['h'].'" type="application/x-shockwave-flash" data="'.$flashPath.'">';
							   	  $output .= '<param name="movie" value="'.$flashPath.'" />';
							   	  $output .= '<param name="flashvars" value="controls=true&width='.$item['w'].'&height='.$item['h'].'&file='.$item['videoURL'].'" />';
							   	  $output .= '<img src="'.$item['lowresimage'].'" title="'.$item['caption'].'" />';
							   	$output .= '</object>';
							   	$output .= '</video>';
							   $output .= '</div>';
							$output .= '</div>';
						}
	      	} else {
	      		if(rg_option( 'fancybox' )){
						$output .= '<div class="instagram-info '.$item['type'].'">';
						   $output .= '<a href="'.$item['standardimage'].'" data-likes="'.$item['instalikes'].'" title="'.$item['caption'].'" rel="instagram">';
						   	$output .= '<img src="'.$item['standardimage'].'" alt="'.$item['caption'].'">';
						   $output .= '</a>';
						   if(!rg_option('caption')){ $output .= '<div class="caption" rel="instagram">'.parseFeedURl($item['caption']).'</div>'; }
						$output .= '</div>';
					} else {
						$output .= '<div class="instagram-info '.$item['type'].'">';
						   $output .= '<a href="'.$item['link'].'" data-likes="'.$item['instalikes'].'" title="'.$item['caption'].'" rel="instagram" target="_blank">';
						   	$output .= '<img src="'.$item['standardimage'].'" alt="'.$item['caption'].'" onerror="imgError(this);">';
						   $output .= '</a>';						   
						   $output .= '<div class="peak"><div class="user"><div class="link"><a href="http://instagram.com/'.$username.'" target="_blank">@'.$username.'</a></div></div>';
						  	if(!rg_option('caption')){ $output .= '<div class="caption" rel="instagram">'.parseFeedURl($item['caption']).'</div></div>'; }
						   // $output .= '<div class="date">'.$inst_date.'</div>';
						$output .= '</div>';
					}
	      	}
	      } elseif($new_options['mediatype'] == 'photos' && $item['type'] == 'image'){
	      		if(rg_option( 'fancybox' )){
						$output .= '<div class="instagram-info '.$item['type'].'">';
						   $output .= '<a href="'.$item['link'].'" data-likes="'.$item['instalikes'].'" title="'.$item['caption'].'" rel="instagram" target="_blank">';
						   	$output .= '<img src="'.$item['standardimage'].'" alt="'.$item['caption'].'">';
						   $output .= '</a>';
						   if(!rg_option('caption')){ $output .= '<div class="caption" rel="instagram">'.parseFeedURl($item['caption']).'</div>'; }
						   $output .= '<div class="user"><div class="link"><span>i</span><a href="http://instagram.com/'.$username.'" target="_blank">@'.$username.'</a></div></div>';
						   $output .= '<div class="date">'.$inst_date.'</div>';				
						$output .= '</div>';
					} else {
						$output .= '<div class="instagram-info '.$item['type'].'">';
						   $output .= '<a href="'.$item['standardimage'].'" data-likes="'.$item['instalikes'].'" title="'.$item['caption'].'" rel="instagram">';
						   	$output .= '<img src="'.$item['standardimage'].'" alt="'.$item['caption'].'">';
						   $output .= '</a>';						   
						   $output .= '<div class="user"><div class="link"><a href="http://instagram.com/'.$username.'" target="_blank">@'.$username.'</a></div></div>';
						   if(!rg_option('caption')){ $output .= '<div class="caption" rel="instagram">'.parseFeedURl($item['caption']).'</div>'; }
						   // $output .= '<div class="date">'.$inst_date.'</div>';
						$output .= '</div>';
					}
	      } elseif($new_options['mediatype'] == 'videos' && $item['type'] == 'video'){
				if(rg_option( 'fancybox' )){
				   	$output .= '<div class="instagram-info '.$item['type'].'">';
				   	   $output .= '<a href="#video_'.$int.'" class="video_trigger" rel="instagram-media" title="'.$item['caption'].'" style="width:'.$item['w'].'px;height:'.$item['h'].'px;"><span></span><img src="'.$item['lowresimage'].'"/></a>';
				   	   	$output .= '<div id="video_'.$int.'" class="video_container" style="display:none;width:'.$item['w'].'px;height:'.$item['h'].'px;">';
				   	   	$output .= '<video poster="'.$item['lowresimage'].'" preload="none">';
				   	   	$output .= '<source type="video/mp4" src="'.$item['videoURL'].'"></source>';
				   	   	$output .= '<object width="'.$item['w'].'" height="'.$item['h'].'" type="application/x-shockwave-flash" data="'.$flashPath.'">';
				   	   	  $output .= '<param name="movie" value="'.$flashPath.'" />';
				   	   	  $output .= '<param name="flashvars" value="controls=true&width='.$item['w'].'&height='.$item['h'].'&file='.$item['videoURL'].'" />';
				   	   	  $output .= '<img src="'.$item['lowresimage'].'" title="'.$item['caption'].'" />';
				   	   	$output .= '</object>';
				   	   	$output .= '</video>';
				   	   	$output .= '</div>';
				   	$output .= '</div>';
				   } else {
				   	$output .= '<div class="instagram-info '.$item['type'].'">';
				   	   $output .= '<div id="video_'.$int.'" class="video_container" style="width:'.$item['w'].'px;height:'.$item['h'].'px;">';
				   	   	$output .= '<video poster="'.$item['lowresimage'].'" preload="none" style="width:'.$item['w'].'px;height:'.$item['h'].'px;">';
				   	   	$output .= '<source type="video/mp4" src="'.$item['videoURL'].'"></source>';
				   	   	$output .= '<object width="'.$item['w'].'" height="'.$item['h'].'" type="application/x-shockwave-flash" data="'.$flashPath.'">';
				   	   	  $output .= '<param name="movie" value="'.$flashPath.'" />';
				   	   	  $output .= '<param name="flashvars" value="controls=true&width='.$item['w'].'&height='.$item['h'].'&file='.$item['videoURL'].'" />';
				   	   	  $output .= '<img src="'.$item['lowresimage'].'" title="'.$item['caption'].'" />';
				   	   	$output .= '</object>';
				   	   	$output .= '</video>';
				   	   $output .= '</div>';
				   	$output .= '</div>';
				   }
				}
	   }
		
		if($item['key'] == 'twitter'){
 	 	   $output .= '<div class="tweet-info">';
 	 	   	$output .= '<ul class="user">';
 	 	 	  		$output .= '<li class="link"><a href="http://twitter.com/intent/user?screen_name='.$item['screen_name'].'" target="_blank">@'.$item['screen_name'].'</a></li>'; 	 	 	  		
 	 	 	  	$output .= '</ul>'; 	 	 	  	
 	 	 	  $output .= '<div class="tweet-info">';
 	 	 	  	$output .= '<div class="txt">'.parseTweetUrl($item['txt']).'</div>'; 	 	 	  	
 	 	 	  $output .= '</div>'; 	 	 	  
 	 	 	$output .= '</div>';
 	 	 }
 	 	 //date('M d', 
 	 	 if($item['key'] == 'facebook') {
 	 	 	$msg = utf8_encode($item['message']);
 	 	 	$msg = preg_replace('/[[:^print:]]/', '', $msg); 	 	 	
 	 	 	$msg = str_replace('<a', '<a target="_blank"', $msg);
 	 	 	$msg = preg_replace('/(?<!http:\/\/|https:\/\/|\"|=|\'|\'>|\">)(www\..*?)(\s|\Z|\.\Z|\.\s|\<|\>|,)/i',"<a href=\"http://$1\" target=\"_blank\">$1</a>$2",$msg);
			$msg = preg_replace('/(?<!\"|=|\'|\'>|\">|site:)(https?:\/\/(www){0,1}.*?)(\s|\Z|\.\Z|\.\s|\<|\>|,)/i',"<a href=\"$1\" target=\"_blank\">$1</a>$3",$msg); 	 	 	
 	 	 	// $msg = makeClickableLinks($msg);
 	 	 	// var_dump($msg);
 	 // 	 	if (strlen($msg) > 160) {

			//     // truncate string
			//     $msgCut = substr($msg, 0, 160);

			//     // make sure it ends in a word so assassinate doesn't become ass...
			//     $msg = substr($msgCut, 0, strrpos($msgCut, ' ')).' ... '; 
			// }			
		   $output .= '<div class="fb-info '.$item['type'].'">';
		   	if($item['type'] == 'photo'){		   				   		
		   		if(!rg_option('media')){
						if(rg_option('fancybox')){	
						   $output .= '<div class="fb-img"><a href="'.$item['large_image'].'" title="'.$item['message'].'"><img src="'.$item['fbimage'].'" /></a></div>';
						} else {
						   $output .= '<div class="fb-img"><img src="'.$item['fbimage'].'" /></div>';
						}
					}
					$output .= '<p>'.$msg.'</p>';
		   	} elseif($item['type'] == 'video'){
		   		// $output .= '<div class="header">'.$item['medianame'].'<span class="time">'.$fb_time.'</span></div>';
		   		$output .= '<div class="fb-img" style="background-image:url('.$item['fbimage'].');"><img src="'.get_template_directory_uri().'/images/130-blank.png" alt="" border="0"/></div>';
		   		$output .= '<p>'.$msg.'</p>';
		   		// if(!rg_option('media')){ 
		   		// 	$output .= '<div class="fb-vid">'.apply_filters('the_content', '[embed]'.$item['videosource'].'[/embed]').'</div>'; 
		   		// }
		   	} elseif($item['type'] == 'link'){
		   		if (strlen($item['link']) > 40) {

			    	// truncate string
			    	$msgCut = substr($item['link'], 0, 40);

			    	// make sure it ends in a word so assassinate doesn't become ass...
			    	$linktxt = $msgCut.' ... '; 
				}
		   		// $output .= '<div class="header">'.$item['medianame'].'<span class="time">'.$fb_time.'</span></div>';
		   		$output .= '<p>'.$msg.'<br><span class="a-link"><a href="'.$item['link'].'" title="'.$item['mediadescription'].'">'.$linktxt.'</a></span></p>';
		   		// $output .= '<p></p>';
		   		// $output .= '<div class="prop">'.$item['linkproperties'].'</div>';
		   	}
		   $output .= '</div>';
		}
		
	endforeach;
	
	$output .= "</div>\n";
	
	$dimensions = array();
	array_push($dimensions, $w, $h, $int);
	if($new_options['instagram'] || $new_options['instagramtag']) { rg_enableScripts($dimensions); }

	return $output;
		
}//END


function rg_social_feed_url( $feed_key, $settings ) {
	$time = date('U');
	switch ( $feed_key ) {
		case 'facebook':
			$feed_url = 'http://feed.rgnrtr.com/facebook/'.$settings[ 'facebook' ].'/json?cache_killer='.$time;
			break;
		case 'twitter':
			$feed_url = 'http://feed.rgnrtr.com/twitter/'.$settings[ 'twitter' ].'/json?cache_killer='.$time;
			break;
		case 'instagram':
			$feed_url = 'http://feed.rgnrtr.com/instagram/'.$settings[ 'instagram' ].'/json?type=image&cache_killer='.$time;
			break;
		case 'instagramtag':
			$feed_url = 'https://feed.rgnrtr.com/instagram/tag/'.$settings[ 'instagramtag' ].'/json?type=image&cache_killer='.$time;
			break;
	}
	return $feed_url;
}



/* MAKES LINKS <A TAGS, USERNAME & HASH TAGS FOR TWITTER
========================================================*/
function parseTweetUrl($str) {
	$str = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $str);
	$str = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $str);
	$str = preg_replace("/@(\w+)/", "<a href=\"https://twitter.com/intent/user?screen_name=\\1\" target=\"_blank\">@\\1</a>", $str); // Usernames
	$str = preg_replace("/#(\w+)/", "<a href=\"https://twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $str); // Hash Tags
   return $str;
}

/* MAKES LINKS <A TAGS
========================================================*/
function parseFeedURl($url) {
	$url = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $url);
	$url = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $url);
	$url = preg_replace("/@(\w+)/", "<a href=\"http://instagram.com/\\1\" target=\"_blank\">@\\1</a>", $url);
return $url;
}

function makeClickableLinks($s) {
  return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
}

/* ADDS TIME AS TIME AGO
========================================================*/
function theRelativeTime($ts){
    if(!ctype_digit($ts))
        $ts = strtotime($ts);
    $diff = time() - $ts;
    if($diff == 0)
        return 'now';
    elseif($diff > 0){
        $day_diff = floor($diff / 86400);
        if($day_diff == 0){
            if($diff < 60) return 'just now';
            if($diff < 120) return '1 minute ago';
            if($diff < 3600) return floor($diff / 60) . ' minutes ago';
            if($diff < 7200) return '1 hour ago';
            if($diff < 86400) return floor($diff / 3600) . ' hours ago';
        }
        if($day_diff == 1) return 'Yesterday';
        if($day_diff < 7) return $day_diff . ' days ago';
        if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
        if($day_diff < 60) return 'last month';
        return date('F Y', $ts);
    } else {
        $diff = abs($diff);
        $day_diff = floor($diff / 86400);
        if($day_diff == 0) {
            if($diff < 120) return 'in a minute';
            if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
            if($diff < 7200) return 'in an hour';
            if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
        }
        if($day_diff == 1) return 'Tomorrow';
        if($day_diff < 4) return date('l', $ts);
        if($day_diff < 7 . (7 - date('w'))) return 'next week';
        if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
        if(date('n', $ts) == date('n') . 1) return 'next month';
        return date('F Y', $ts);
    }
}

 
function warning_method(){
   echo '<div>Fancybox already exists in you theme, RG Social plugin will not activate it.</div>';
}

/* ADD SCRIPTS & STYLES
========================================================*/ //file_exists
// $fancybox = preg_match('/<script.+?src=\"(.*?\/fancybox)\".+?script>/s', $content);

function rg_enqueue_scripts() {
	if ( !is_admin() ) {
		if ( rg_option( 'fancybox' ) ) {
			wp_enqueue_script( 'custom-fancybox', RG_SOCIAL_URL . '/js/fancybox.js');
			// wp_enqueue_script( 'custom-media', RG_SOCIAL_URL . '/js/mediaelement.js');
			// wp_enqueue_script( 'custom-script', RG_SOCIAL_URL . '/js/custom-scripts.js');
		}
		// wp_enqueue_script( 'custom-media', RG_SOCIAL_URL . '/js/mediaelement.js');
		// wp_enqueue_script( 'custom-script', RG_SOCIAL_URL . '/js/custom-scripts.js');
		wp_enqueue_style( 'custom-css', RG_SOCIAL_URL . '/css/custom-style.css');
	}
}

add_action( 'wp_enqueue_scripts', 'rg_enqueue_scripts' );


function rg_enableScripts($dimensions){
	if ( ! is_admin() ) {
		?>
		<style type="text/css">
		   .mejs-shim { width: <?php echo $dimensions[0]; ?>px !important; height: <?php echo $dimensions[1]; ?>px !important; }
		</style>
		<?php
	}
}

function rg_enableFancyBox(){
	if ( ! is_admin() ) {
		if ( rg_option( 'fancybox' ) ) {
			?>
				<script type="text/javascript">
					jQuery( document ).ready(function( $ ) {
					   $('.social-block .instagram-info a, .fb-img a').fancybox({ padding: 5 });
					   $('.social-block .instagram-info .video_trigger').fancybox({ padding: 5 , afterLoad : function() { this.content.html(); } });
					});
				</script>
				<style type="text/css">
					.video_container, .mejs-container, .mejs-video, .mejs-mediaelement video, .mejs-layer { width: 612px !important; height: 612px !important; display: block; line-height: 0; }
				</style>
			<?php
		}
	}
}
add_action( 'wp_head', 'rg_enableFancyBox' );


/* create the submenu links in plugins page
========================================================*/

function rg_social_action_link($links, $file) {
    static $this_plugin;
    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }
    // check to make sure we are on the correct plugin
    if ($file == $this_plugin) {
		// link to what ever you want
        $plugin_links[] = '<a href="'.get_bloginfo('wpurl').'/wp-admin/options-general.php?page=rg-options">'.__('Options', RG_LOCALE).'</a>';
         // add the links to the list of links already there
		foreach($plugin_links as $link) {
			array_unshift($links, $link);
		}
    }
    return $links;
}
add_filter('plugin_action_links', 'rg_social_action_link', 10, 2);


/* WIDGET
========================================================*/
require_once( RG_SOCIAL_DIR . '/rg-feed-widget.php' );


/* ADD ADMIN PANEL
========================================================*/
// require_once( RG_SOCIAL_DIR . '/admin-panel.php' );


?>
