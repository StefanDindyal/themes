<?php

/* -----------------------------------------
	Plugin Global Settings
----------------------------------------- */

/**********************************************************************************
	Change all instances of 'media' when using with a new plugin. (case sensative)
***********************************************************************************/

global $rg_media_fields;

$rg_media_options = get_option( 'rg_theme_options' );
	
function rg_media_display_setting( $field, $rg_media_options = null, $repeatable = null ) {
	if ( ! ( $field || is_array( $field ) ) )
  		 	return;
  		 	
   $type = isset( $field['type'] ) ? $field['type'] : null;
   $options = isset( $field['options'] ) ? $field['options'] : null;
   $width = isset( $field['width'] ) ? $field['width'] : '50%';
  	$repeatable_fields = isset( $field['repeatable_fields'] ) ? $field['repeatable_fields'] : null;
  	$id = $name = isset( $field['id'] ) ? $field['id'] : null;

  	if ( $repeatable ) {
  	 	$name = 'rg_media_options['.$repeatable[0].']['.$repeatable[1].']['.$field['id'].']';
		$id = 'rg_media_options_' .$repeatable[0]. '_' .$repeatable[1]. '_' .$field['id'];
  	}
  	
  	if( isset( $rg_media_options[$field['id']] ) ) {
	   $meta = $rg_media_options[$field['id']];
	} else {
	   $meta = '';
	}
		      
   switch($type) {
      // text
      case 'text':
      	echo '<input type="'.$type.'" name="'.( $repeatable ? $name : 'rg_media_options['.$field['id'].']' ).'" id="'.( $repeatable ? $id : $field['id'] ).'" value="'.$meta.'" class="regular-text" style="width:'.$width.';" size="30" /></br><span class="description">'.$field['desc'].'</span>';
      break;
      // text
      case 'password':
         echo '<input type="password" name="'.( $repeatable ? $name : 'rg_media_options['.$field['id'].']' ).'" id="rg_media_options['.$field['id'].']" value="'.$meta.'" size="30" class="regular-text" />
         	<span class="description">'.$field['desc'].'</span>';
      break;
      // textarea
      case 'textarea':
         echo '<textarea name="'.( $repeatable ? $name : 'rg_media_options['.$field['id'].']' ).'" id="rg_media_options['.$field['id'].']" cols="60" rows="4">'.$meta.'</textarea>
         	<br /><span class="description">'.$field['desc'].'</span>';
      break;
      // checkbox
      case 'checkbox':
         echo '<input type="checkbox" name="'.( $repeatable ? $name : 'rg_media_options['.$field['id'].']' ).'" id="rg_media_options['.$field['id'].']" ',$meta != '' ? ' checked="checked"' : '',' />
         	<label for="rg_media_options['.$field['id'].']"><span class="description">'.$field['desc'].'</span></label>';
      break;
      // select
      case 'select':
      	echo '<select name="'.( $repeatable ? $name : 'rg_media_options['.$field['id'].']' ).'" id="rg_media_options['.$field['id'].']">';
			foreach ( $options as $option ){
				echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
			}
			echo '</select><br /><span class="description">'.$field['desc'].'</span>';
      break;
      // radio
      case 'radio':
         foreach ( $field['options'] as $option ) {
         	echo '<input type="radio" name="'.( $repeatable ? $name : 'rg_media_options['.$field['id'].']' ).'" id="rg_media_options['.$option['value'].']" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
         			<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
         }
         echo '<span class="description">'.$field['desc'].'</span>';
      break;
      // checkbox_group
      case 'checkbox_group':
         foreach ($field['options'] as $option) {
         	echo '<input type="checkbox" value="'.$option['value'].'" name="rg_media_options['.$field['id'].'][]" id="rg_media_options['.$option['value'].']"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' />
         			<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
         }
         echo '<span class="description">'.$field['desc'].'</span>';
      break;
      // tax_select
      case 'tax_select':
         echo '<select name="rg_media_options['.$field['id'].']" id="rg_media_options['.$field['id'].']">
         		<option value="">-- '.__('Select', RG_LOCALE).' --</option>'; // Select One
         $terms = get_terms($field['id'], 'get=all');
         $selected = wp_get_object_terms('', 'rg_media_options['.$field['id'].']');
         foreach ($terms as $term) {
         	if ($selected && $term->slug == $rg_media_options[$field['id']] )
         		echo '<option value="'.$term->slug.'" selected="selected">'.$term->name.'</option>';
         	else
         		echo '<option value="'.$term->slug.'">'.$term->name.'</option>';
         }
         $taxonomy = get_taxonomy($field['id']);
         echo '</select><br /><span class="description"><a href="'.get_bloginfo('home').'/wp-admin/edit-tags.php?taxonomy='.$field['id'].'">'.__('Manage', 'rg').' '.$taxonomy->label.'</a></span>';
      break; 
      // post_list
      case 'post_list':
         $items = get_posts( array (
         	'post_type'	=> $field['post_type'],
         	'posts_per_page' => -1
         ));
         echo '<select name="rg_media_options['.$field['id'].']" id="rg_media_options['.$field['id'].']">
         		<option value="">-- '.__('Select', RG_LOCALE).' --</option>'; // Select One
         	foreach($items as $item) {
         		if( $item->post_type == 'page' OR $item->post_type == 'post') {
         			$post_type = str_replace('page', __('page', RG_LOCALE), $item->post_type);
         			$post_type = str_replace('post', __('post', RG_LOCALE), $item->post_type);
         		} else { $post_type = $item->post_type; }
         		echo '<option value="'.$item->ID.'"',$rg_media_options[$field['id']] == $item->ID ? ' selected="selected"' : '','>'.$post_type.': '.$item->post_title.'</option>';
         	} // end foreach
         echo '</select>&nbsp;<span class="description">'.$field['desc'].'</span>';
      break;     
      // date
      case 'date':
         echo '<input type="text" class="date-'.$field['id'].'" name="'.( $repeatable ? $name : 'rg_media_options['.$field['id'].']' ).'" id="rg_media_options['.$field['id'].']" value="'.$rg_media_options[$field['id']].'" size="30" />
         		<span class="description">'.$field['desc'].'</span>';
      break;
      // image
      case 'image':
		   $image = RG_MEDIA_URL.'/images/post-img.png';	
		   echo '<span class="default_image" style="display:none">'.$image.'</span>';
		   if ($meta) { $imageID = rg_media_get_attachment_id_from_url( $meta ); $image = wp_get_attachment_image_src($imageID, 'thumbnail'); }
		   
		   if (!$meta){ 
		   	echo '<img src="'.$image.'" class="preview_image" alt="" style="max-width:150px;" />';
		   } else { 
		   	echo '<img src="'.$image[0].'" class="preview_image" alt="" style="max-width:150px;" />'; 
		   }
		   echo	'<br />
		   		<input type="text" name="'.( $repeatable ? $name : 'rg_media_options['.$field['id'].']' ).'" id="rg_media_options['.$field['id'].']" class="upload_field" value="'.$meta.'" size="30" style="width:'.$field['width'].'" />
		   		<input id="upload_image_button" class="button" type="button" value="Upload">
		   		<button class="clear_image_button button">Remove Image</button>
		   		<br clear="all" /><span class="description">'.$field['desc'].'</span>';
		   			
		break;
      // slider
      case 'slider':
      $field_id = $field['id'];
      $value = $rg_media_options["$field_id"] != '' ? $rg_media_options["$field_id"] : '0';
         echo '<div id="'.$field['id'].'-slider"></div>
         		<input type="text" name="'.( $repeatable ? $name : 'rg_media_options['.$field['id'].']' ).'" id="rg_val_slider_'.$field['id'].'" value="'.$value.'" size="5" />
         		<br /><span class="description">'.$field['desc'].'</span>';
      break;
      
      //repeatable
      case 'repeatable':
      	echo '<table id="rg_media_options['.$field['id'].']-repeatable" class="rg-media_repeatable" cellspacing="0">
				<thead>
					<tr>
						<th><span class="sort_label"></span></th>
						<th><a class="rg-media_repeatable_add" href="#"></a></th>
					</tr>
				</thead>
				<tbody>';
  		   	$i = 0;
		   	if ( $meta == '' || $meta == array() ) {
					$keys = wp_list_pluck( $repeatable_fields, 'id' );
					$meta = array ( array_fill_keys( $keys, null ) );
				}
				$meta = array_values( $meta );
				foreach( $meta as $row ) {
		   		echo '<tr><td colspan="3">';
					echo '<div class="btns"><span class="sort hndle"></span><a class="rg-media_repeatable_remove" href="#"></a></div>';
		   		foreach($repeatable_fields as $key => $value){
		   			if ( ! array_key_exists( $value['id'], $meta[$i] ) )
							 $meta[$i][$value['id']] = null;
						echo '<div class="r-row" id="'.$value['id'].'">';
				   		echo '<label>'.$value['label'].'</label>';
							echo rg_media_display_setting( $value, $rg_media_options[$field['id']][$i], array($id, $i, $value['id']) );
						echo '</div>';
		   		} // end each field
		   		echo '</td></tr>';
		   		$i++;
		   	} // end each row
		   	echo '</tbody>';
		   	echo '
				<tfoot>
					<tr>
						<th><span class="sort_label"></span></th>
						<th><a class="rg-media_repeatable_add" href="#"></a></th>
					</tr>
				</tfoot>';
			echo '</table>';
	   	echo '<br /><span class="description">'.$field['desc'].'</span>';
		   
		break;
      
      // colorpicker
      case 'colorpicker':
         echo '<input type="text" class="color" name="'.( $repeatable ? $name : 'rg_media_options['.$field['id'].']' ).'" id="rg_media_options['.$field['id'].']" value="'.$rg_media_options[$field['id']].'" size="30" />
         		<br /><span class="description">'.$field['desc'].'</span>';
         break;
         // Color
         case 'color':
			$meta = $meta ? $meta : '#';
			echo '<input type="text" name="'.( $repeatable ? $name : 'rg_media_options['.$field['id'].']' ).'" id="' . $field['id'] . '" value="' . $meta . '" size="10" style="width:'.$width.';" />
				<br />' . $desc;
			echo '<div id="colorpicker-' . $field['id'] . '"></div>
				<script type="text/javascript">
				jQuery(function(jQuery) {
					jQuery("#colorpicker-' . $field['id'] . '").hide();
					jQuery("#colorpicker-' . $field['id'] . '").farbtastic("#' . $field['id'] . '");
					jQuery("#' . $field['id'] . '").bind("blur", function() { jQuery("#colorpicker-' . $field['id'] . '").slideToggle(); } );
					jQuery("#' . $field['id'] . '").bind("focus", function() { jQuery("#colorpicker-' . $field['id'] . '").slideToggle(); } );
				});
				</script>';
		break;
      
   }//end switch

}

function rg_media_find_field_type( $needle, $haystack ) {
	foreach ( $haystack as $h )
		if ( isset( $h['type'] ) && $h['type'] == 'repeatable' )
			return rg_media_find_field_type( $needle, $h['repeatable_fields'] );
		elseif ( ( isset( $h['type'] ) && $h['type'] == $needle ) || ( isset( $h['repeatable_type'] ) && $h['repeatable_type'] == $needle ) )
			return true;
	return false;
}

function rg_media_find_repeatable( $needle = 'repeatable', $haystack ) {
	foreach ( $haystack as $h )
		if ( isset( $h['type'] ) && $h['type'] == $needle )
			return true;
	return false;
}

/* ----------------------------------------
* create the settings page layout
----------------------------------------- */

function rg_media_display_page() {
   global $rg_media_options, $rg_media_fields;
   echo '<div class="wrap" id="rg-media">';
      	echo '<div class="icon"></div>';
      	echo '<h2>' . __( 'RG Theme Options', RG_LOCALE ) . '</h2>';
      	
      	if ( ! isset( $_REQUEST['settings-updated'] ) )
   			$_REQUEST['settings-updated'] = false;
   
      echo '<div class="has-right-sidebar">';
      	echo '<div id="poststuff">';
      		echo rg_media_sidebar();
      	echo '</div>';
      
      	echo '<div style="float: left; width: 70%;" >';
      		echo '<form method="post" action="options.php" class="rg_options_form">';
      			echo settings_fields('rg_media_options');
      			wp_nonce_field( basename(__FILE__), 'RG_Admin_Page_Class_nonce' );
      			
      			echo '<div id="section_container">';
      			echo '<table class="form-table rg-media">';
						foreach ( $rg_media_fields as $field ) {
						   if ( $field['type'] == 'section' ) {
						   	echo '<tr class="' . $field['id'] . '">
						   			<td colspan="2">
						   				<h2 class="section-title">' . $field['label'] . '</h2>
						   			</td>
						   		</tr>';
						   } else {
						   	echo '<tr class="' . $field['id'] . '">
						   			<th style="width:15%"><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
						   			<td>';
						   			
						   			$rg_media_options = get_option( 'rg_media_options' );
						   			echo rg_media_display_setting( $field, $rg_media_options );
						   			
						   	echo     '<td>
						   		</tr>';
						   }
						} // end foreach
						echo '</table>'; // end table					
					echo '</div>';      			
      			echo '<p class="submit"><input name="Submit" type="submit" class="button-primary" value="'. __( 'Save Options', RG_LOCALE ). '" /></p>';   			
      		echo '</form>';
      	echo '</div>';
      	
      echo '</div>';      
      
   echo '</div>';
   
}

function rg_media_settings_menu() {
   add_options_page( 'RG Theme Options', 'RG Theme Options', 'edit_posts', 'rg-media-settings', 'rg_media_display_page' );
}
add_action('admin_menu', 'rg_media_settings_menu', 100);

/* ----------------------------------------
* register the plugin settings
----------------------------------------- */

function rg_media_register_settings() {
	register_setting( 'rg_media_options', 'rg_media_options' );
}
//call register settings function
add_action( 'admin_init', 'rg_media_register_settings', 100 );


/* ----------------------------------------
* register scripts & styles
----------------------------------------- */
function rg_media_admin_scripts() {
	global $rg_media_fields;
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('colorpicker');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('media-uploader', RG_MEDIA_URL . '/js/media-uploader.js');
	wp_enqueue_script('jscolor', RG_MEDIA_URL . '/js/jscolor.js');
	wp_enqueue_script('farbtastic');
	wp_enqueue_script('admin-script', RG_MEDIA_URL . '/js/custom-admin.js');
}

function rg_media_admin_styles() {
	if( is_admin() ) {
		wp_enqueue_style('thickbox');
		wp_enqueue_style('farbtastic');
		wp_enqueue_style('admin-css', RG_MEDIA_URL . '/css/admin-panel.css');
		wp_enqueue_style('jquery-ui-custom', RG_MEDIA_URL.'/css/jquery-ui-custom.css');
	}
}
   	

function rg_media_add_custom_scripts() {
   global $rg_media_fields, $rg_media_options;
   $output = '<script type="text/javascript">
   			jQuery(function($){';
   			
   foreach ( $rg_media_fields as $field ) {
	   switch( $field['type'] ) {
	   	// date
	   	case 'date' :
	   		$output .= '$(".date-'.$field['id'].'").datepicker({
	   				dateFormat: \'yy-mm-dd\'
	   			});';
	   	break;
	   	// slider
	   	case 'slider' :
	   	$field_id = $field['id'];
   		$value = $rg_media_options["$field_id"] != '' ? $rg_media_options["$field_id"] : '0';
	   	if ( $value == '' )
	   		$value = $field['min'];
	   	$output .= '
	   			$("#rg_media_options['.$field['id'].']-slider").slider({
	   				value: ' . $value . ',
	   				min: ' . $field['min'] . ',
	   				max: ' . $field['max'] . ',
	   				step: ' . $field['step'] . ',
	   				slide: function( event, ui ) {
	   					$( "#rg_media_options['.$field['id'].']" ).val( ui.value );
	   				}
	   			});';
	   	break;
	   }
	}		
   $output .= '});
   	</script>';

   echo $output;
}

if (isset($_GET['page']) && ( $_GET['page'] == 'rg-media-settings') ){
	add_action('admin_enqueue_scripts', 'rg_media_admin_scripts');
	add_action('admin_enqueue_scripts', 'rg_media_admin_styles');
	add_action('admin_head','rg_media_add_custom_scripts');
}


/* ------------------------------------------------------------------*/
/* GET AN IMAGE FROM GLOBAL STRING */
/* ------------------------------------------------------------------*/

function rg_media_image($field_id,  $width = '', $height = ''){
	global $rg_media_options;
	if( isset($field_id) ) {
		// Get attachment data
		$image_data = wp_get_attachment_image_src( $rg_media_options["$field_id"], '' );		
		// get URL
		$url = $image_data[0];
		
		// Height and width
		if( $height != '' && $width != '' ) {
			$height = $height;
			$width 	= $width;
		} else {
			$width = $image_data[1];
			$height = $image_data[2];
		}
		echo '<img src="'.$url.'" width="'.$width.'" height="'.$height.'"/>'; 
		
	}
}

/* ------------------------------------------------------------------*/
/* RETURN AN IMAGE URL FROM GLOBAL STRING */
/* ------------------------------------------------------------------*/

function rg_media_get_image($field_id) {
	global $rg_media_options;
	
	if( isset($field_id) ) {
		// Get attachment data
		$image_data = wp_get_attachment_image_src( $rg_media_options["$field_id"], '' );
		// get URL
		$url = $image_data[0];	
		return $url;
	}
}

/* ------------------------------------------------------------------*/
/* RETURN AN IMAGE ID */
/* ------------------------------------------------------------------*/
function rg_media_get_attachment_id_from_url( $attachment_url = '' ) {
	global $wpdb;
	$attachment_id = false;
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
	}
	return $attachment_id;
}
	
function rg_media_sidebar() {
   echo '<div id="side-info-column" class="inner-sidebar" style="width: 25%;">';
   /* Instructions
   ========================================================*/
   echo '<div class="postbox">
   		<h3 class="hndle">' . __( 'How to Use', RG_LOCALE ) . '</h3>
   		<div class="inside">';
   
   echo '<h4>' . __( 'Template Tag', RG_LOCALE ) . '</h4>';
   
   echo 
   	'<h4>' . __( 'How to create custom fields', RG_LOCALE ) . '</h4>
   	<h4>Add a Text input field</h4>
		<pre><code>array(
	"label"=> "Text Input",
	"desc"	=> "A description for the field.",
	"id"	=> $prefix."textinput",
	"type"	=> "text"
		),</code></pre>';
   
   echo '</div>
   	</div>';
   
   /* Credits
   ========================================================*/
   echo '<div class="postbox credits">
   		<h3 class="hndle">' . __( 'Credits', RG_LOCALE ) . '</h3>
   		<div class="inside">';
   
   echo '<ul>
   	<li>' . __( 'Author:', RG_LOCALE ) . ' <a href="http://www.rgenerator.com/" target="_blank">RGenerator</a></li>
   </ul>';
   echo '</div>
   	</div>';
   echo '</div>';
   
}

?>