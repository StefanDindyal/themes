<?php

namespace Roots\Sage\Utils;

/**
 * Tell WordPress to use searchform.php from the templates/ directory
 */
function get_search_form() {
  $form = '';
  locate_template('/templates/searchform.php', true, false);
  return $form;
}
add_filter('get_search_form', __NAMESPACE__ . '\\get_search_form');


function get_excerpt($post_id, $count = null) {
  $post = get_post($post_id);
  $excerpt = "";
  if ($post) {
    $count = ($count) ? $count : 220;
    $excerpt = (empty($post->post_excerpt)) ? $post->post_content : $post->post_excerpt;
    $excerpt = (empty($excerpt)) ? "-" : $excerpt;
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $count);
  }
  return $excerpt;
}


/*
 * Detects a mobile device
 */
function is_mobile_device(){
  return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function is_desktop(){
  return !is_mobile_device();
}

// ------- IMAGES -------

// -- By Size --
function get_image_normal($image_attrs){
  return $image_attrs["url"];
}

function get_image_thumbnail($image_attrs){
  return $image_attrs["sizes"]["thumbnail"];
}

function get_image_medium($image_attrs){
  return $image_attrs["sizes"]["medium"];
}

function get_image_large($image_attrs){
  return $image_attrs["sizes"]["large"];
}

// -- By Device --
function get_image_by_device($image_attrs){
  $imageSrc = "";
  if(count($image_attrs) > 1){
    if(is_mobile_device()){
        $imageSrc = get_image_large($image_attrs);
    }

    if($imageSrc == ""){
      $imageSrc = get_image_normal($image_attrs);
    }
  }
  return $imageSrc;
}


// -------- LANGUAGE ------------

 function wpml_current_lang( ) {
   
    $languages = icl_get_languages('skip_missing=1');
    $curr_lang = array();
    if( !empty( $languages ) ) {
         
        foreach( $languages as $language ) {
            if( !empty( $language['active'] ) ) {
                $curr_lang = $language; // This will contain current language info.
                break;
            }
        }
    }
    return $curr_lang;
}

 function wpml_lang_by_code($code) {
    $langs = icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str');
    return $langs[$code];
}


// ------------ STRINGS ---------------

// Removes all special characters from a string
function cleanSpecialChars($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

// Removes all hmtl tags from  a string
// $removeContent: if true, removes the tags and the content in the tags.
function removeHtmlTags($string, $removeContent){
  if($removeContent == true){
    return preg_replace("(<([a-z]+)>.*?</\\1>)is","",$string);
  }else{
    return strip_tags($string);
  }
}