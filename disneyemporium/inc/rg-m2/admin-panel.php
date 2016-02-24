<?php

/* -----------------------------------------
	Plugin Global Settings
----------------------------------------- */

global $rg_m2_fields;

class RG_Admin_Options {

public function __construct() {
    add_action( 'admin_menu', array( $this, '_m2settingsMenu' ) );
    add_action( 'admin_init', array( $this, '_m2registerSettings' ) );
    add_action( 'admin_init', array( $this, '_processFormActions' ) );
    
    if (isset($_GET['page']) && ( $_GET['page'] == 'rg-m2-settings') ){
		add_action( 'admin_enqueue_scripts', array( $this, '_m2AdminScripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, '_m2AdminStyles' ) );
		add_action( 'admin_head', array( $this, '_m2addCustomScripts' ) );
	}

}

public function pre($arr){ 
    echo "<pre>"; print_r($arr); echo "</pre>";
}
	
function _m2displaySettings( $field, $meta = null, $repeatable = null ) {
	if ( ! ( $field || is_array( $field ) ) )
  		 	return;
  		 	
  	$value = isset( $field['value'] ) ? $field['value'] : null;
	$title = isset( $field['title'] ) ? $field['title'] : null;
	$type = isset( $field['type'] ) ? $field['type'] : null;
   	$options = isset( $field['options'] ) ? $field['options'] : null;
   	$width = isset( $field['width'] ) ? $field['width'] : '50%';
   	$label = isset( $field['label'] ) ? '<label for="'.$field['id'].'">'.$field['label'].'</label>' : null;
	$desc = isset( $field['desc'] ) ? '<span class="description">' . $field['desc'] . '</span>' : null;
	$rows = isset( $field['rows'] ) ? $field['rows'] : null;
	$cols = isset( $field['cols'] ) ? $field['cols'] : null;
	$post_type = isset( $field['post_type'] ) ? $field['post_type'] : null;
	$place = isset( $field['place'] ) ? $field['place'] : null;
	$size = isset( $field['size'] ) ? $field['size'] : null;
  	$repeatable_fields = isset( $field['repeatable_fields'] ) ? $field['repeatable_fields'] : null;
  	$group_fields = isset( $field['group_fields'] ) ? $field['group_fields'] : null;
  	
  	$id = $name = isset( $field['id'] ) ? 'rg_store_options['.$field['id'].']' : null;

  	if ( $repeatable ) {		
		$name = $repeatable[0].'['.$repeatable[1].']['.$repeatable[2].']';
		$id = $repeatable[0] . '_' . $repeatable[1] . '_' . $field['id'];
  	}
  	/*
if( isset( $rg_store_options[$field['id']] ) ) {
	   $meta = $rg_store_options[$field['id']];
	} else {
	   $meta = '';
	}
*/

   switch($type) {
      // text
      case 'text':
      	echo '<input type="'.$type.'" name="'.$name.'" id="'.$id.'" value="'.$meta.'" class="regular-text" style="width:'.$width.';" size="30" />';
      	if($desc){ echo '<br/>'.$desc; }
      break;
      // editor
	  case 'editor':
	      echo wp_editor( $meta, $id, $settings ) . '<br />' . $desc;
	  break;
      // text
      case 'password':
         echo '<input type="password" name="'.$name.'" id="'.$id.'" value="'.$meta.'" size="30" class="regular-text" />'.$desc;
      break;
      // textarea
      case 'textarea':
         echo '<textarea name="'.$name.'" id="'.$id.'" cols="60" rows="4">'.$meta.'</textarea>
         	<br />'.$desc;
      break;
      // checkbox
      case 'checkbox':
         echo '<input type="checkbox" value="'.($meta != '' ? 'true' : 'false').'" name="'.$name.'" id="'.$id.'" ',$meta != '' ? ' checked="checked"' : '',' />
         	<label for="rg_store_options['.$field['id'].']"><span class="description">'.$field['desc'].'</span></label>';
      break;
      // select, chosen
	  case 'select':
	  case 'chosen':
	      echo '<select name="'.$name.'" id="'.$id.'"' , $type == 'chosen' ? ' class="chosen"' : '' , isset( $multiple ) && $multiple == true ? ' multiple="multiple"' : '' , '>
	      		<option value="">Select One</option>'; // Select One
	      foreach ( $options as $option )
	      	echo '<option' . selected( $meta, $option['value'], false ) . ' value="'.$option['value'].'">' . $option['label'] . '</option>';
	      echo '</select>';
	      if($desc){ echo '<br />' . $desc; }
	  break;
      // radio
      case 'radio':
         foreach ( $field['options'] as $option ) {
         	echo '<input type="radio" name="'.$name.'" id="rg_store_options['.$option['value'].']" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
         			<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
         }
         echo $desc;
      break;
      // checkbox_group
      case 'checkbox_group':
         foreach ($field['options'] as $option) {
         	echo '<input type="checkbox" value="'.$option['value'].'" name="rg_store_options['.$field['id'].'][]" id="rg_store_options['.$option['value'].']"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' />
         			<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
         }
         echo $desc;
      break;
      // tax_select
      case 'tax_select':
         echo '<select name="rg_store_options['.$field['id'].']" id="'.$id.'">
         		<option value="">-- '.__('Select', RG_M2_LOCALE).' --</option>'; // Select One
         $terms = get_terms($field['id'], 'get=all');
         $selected = wp_get_object_terms('', 'rg_store_options['.$field['id'].']');
         foreach ($terms as $term) {
         	if ($selected && $term->slug == $meta )
         		echo '<option value="'.$term->slug.'" selected="selected">'.$term->name.'</option>';
         	else
         		echo '<option value="'.$term->slug.'">'.$term->name.'</option>';
         }
         $taxonomy = get_taxonomy($field['id']);
         echo '</select><br /><span class="description"><a href="'.get_bloginfo('home').'/wp-admin/edit-tags.php?taxonomy='.$field['id'].'">'.__('Manage', 'rg').' '.$taxonomy->label.'</a></span>';
      break; 
      // post_select, post_chosen
	  case 'post_select':
	  case 'post_list':
	  case 'post_chosen':
	      echo '<select data-placeholder="Select One" name="rg_store_options['.$field['id'].']" id="'.$id.'"' , $type == 'post_chosen' ? ' class="chosen"' : '' , isset( $multiple ) && $multiple == true ? ' multiple="multiple"' : '' , '>
	      		<option value=""></option>'; // Select One
	      $posts = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => 'name', 'order' => 'ASC' ) );
	      foreach ( $posts as $item )
	      	echo '<option value="' . $item->ID . '"' . selected( is_array( $meta ) && in_array( $item->ID, $meta ), true, false ) . '>' . $item->post_title . '</option>';
	      $post_type_object = get_post_type_object( $post_type );
	      echo '</select> &nbsp;<span class="description"><a href="' . admin_url( 'edit.php?post_type=' . $post_type . '">Manage ' . $post_type_object->label ) . '</a></span><br />' . $field['desc'];
	  break;    
      // date
      case 'date':
         echo '<input type="text" class="date-'.$field['id'].'" name="'.$name.'" id="'.$id.'" value="'.$meta.'" size="30" />
         		<span class="description">'.$field['desc'].'</span>';
      break;
      //date format
      case 'format_date':
			echo '<input type="text" class="datepicker" name="'.$name.'" id="'.$id.'" value="' . $meta . '" style="width:'.esc_attr( $width ).';" size="30" />
			<p>Format options:<br>
			  <select id="format">
			    <option value="mm/dd/yy">Default - mm/dd/yy</option>
			    <option value="yy-mm-dd">ISO 8601 - yy-mm-dd</option>
			    <option value="d M, y">Short - d M, y</option>
			    <option value="d MM, y">Medium - d MM, y</option>
			    <option value="DD, d MM, yy">Full - DD, d MM, yy</option>
			    <option value="&apos;day&apos; d &apos;of&apos; MM &apos;in the year&apos; yy">With text - "day" d "of" MM "in the year" yy</option>
			  </select>
			</p>
					<br />' . $field['desc'];
		break;
		//timepicker
		case 'timepicker':
			echo '<input type="text" name="'.$name.'" id="'.$id.'-'.$repeatable[0].'" value="'.esc_attr( $meta ).'" class="rg-timepicker" style="width:'.esc_attr( $width ).';" size="30" />';
		break;
      // image
	  case 'image':
	      $image = RG_M2_URL . '/images/image.png';	
	      echo '<div class="rg-m2_image"><span class="rg-m2_default_image" style="display:none">' . $image . '</span>';
	      if ( $meta ) {
	      	$image = wp_get_attachment_image_src( intval( $meta ), 'medium' );
	      	$image = $image[0];
	      }				
	      echo	'<input name="'.$name.'" type="hidden" class="rg-m2_upload_image" value="' . intval( $meta ) . '" style="width:'.$width.';" />
	      			<img src="' . esc_attr( $image ) . '" class="rg-m2_preview_image" alt="" />
	      				<a href="#" class="rg-m2_upload_image_button button" rel="' . get_the_ID() . '">Choose Image</a>
	      				<small>&nbsp;<a href="#" class="rg-m2_clear_image_button">Remove Image</a></small></div>
	      				<br clear="all" />' . $field['desc'];
	  break;
      // repeatable
      case 'repeatable':
		    echo '<a class="repeatable-add add-new-h2" href="#">Add Field</a>
		            <ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
		    $i = 0;
		    if ( $meta == '' || $meta == array() ) {
			    $keys = wp_list_pluck( $repeatable_fields, 'id' );
			    $meta = array ( array_fill_keys( $keys, null ) );
			}
			$meta = array_values( $meta );
		    foreach( $meta as $value ):
		    	echo '<li class="r-row">';
		    		echo '<span class="sort hndle">|||</span>';
		    		$p = 0;
					foreach($repeatable_fields as $repeatable_field){
						//m2pre($meta[$i][$p++]);
					    echo $this->_m2displaySettings( $repeatable_field, $meta[$i][$p++], array( $id, $i ) );
					}
			    	echo '<a class="repeatable-remove add-new-h2" href="#">-</a>';
			    echo '</li>';
			    $i++;
		    endforeach;
		    echo '</ul><br/>';
		    echo $desc;
		break;
		
      // colorpicker - farbtastic
      case 'color':
	     $meta = $meta ? $meta : '#';
	     echo '<input type="text" name="' .$name. '" id="'.$field['id'].'" value="' . $meta . '" size="10" style="width:'.$width.';" />
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
	  // slider
      case 'slider':
      $value = $meta != '' ? $meta : '0';
         echo '<div id="'.$field['id'].'-slider"></div>
         		<input type="text" name="'.$name.'" id="rg_slider_'.$field['id'].'" value="'.$value.'" size="5" />
         		<br /><span class="description">'.$field['desc'].'</span>';
	   	echo '<script type="text/javascript">
	     	jQuery(function(jQuery) {
	   			jQuery("#'.$field['id'].'-slider").slider({
	   				value: ' . $value . ',
	   				min: ' . $field['min'] . ',
	   				max: ' . $field['max'] . ',';
	   				if($field['step']){ echo 'step: ' . $field['step'] . ','; }
	   				echo 'slide: function( event, ui ) {
	   					jQuery( "#rg_slider_'.$field['id'].'" ).val( ui.value );
	   				}
	   			});
	   		});
	   		</script>';
      break;
	  
	  // group of fields
	  case 'input_group':
	      echo '<ul id="'.$id.'-repeatable" class="admin_group">';
	      $i = 0;
		  if ( $meta == '' || $meta == array() ) {
		      $keys = wp_list_pluck( $group_fields, 'id' );
		      $meta = array ( array_fill_keys( $keys, null ) );
		  }
		  $meta = array_values( $meta );
		  foreach( (array)$meta as $key => $value ):
		  	 foreach($group_fields as $group_field):
		  	     echo '<li class="r-row">';
		  	     	echo '<label>'.$group_field['label'].'</label>';
		  	     	echo $this->_m2displaySettings( $group_field, $value[$i], array( $id, $i ) );
		  	     echo '</li>';
		  	 endforeach;
		  	 $i++;
		  endforeach;
	      echo '</ul><br/>';
		  echo $desc;
	  break;
      
   }//end switch

}

function _m2findFieldType( $needle, $haystack ) {
	foreach ( $haystack as $h )
		if ( isset( $h['type'] ) && $h['type'] == 'repeatable' )
			return $this->_m2findFieldType( $needle, $h['repeatable_fields'] );
		elseif ( ( isset( $h['type'] ) && $h['type'] == $needle ) || ( isset( $h['repeatable_type'] ) && $h['repeatable_type'] == $needle ) )
			return true;
	return false;
}

function _m2findRepeatableType( $needle = 'repeatable', $haystack ) {
	foreach ( $haystack as $h )
		if ( isset( $h['type'] ) && $h['type'] == $needle )
			return true;
	return false;
}

function _m2validateThis($input) {
    $valid = array();
    // checks each input that has been added
    foreach($input as $key => $value){
    	// does a basic check to make sure that the database value is there
    	if(get_option($key === FALSE)){
    		// adds the field if its not there
    		add_option($key, $value);
    	} else {
    		// updates the field if its already there
    		update_option($key, $value);
    	}

    	// you have to return the value or WordPress will cry
    	$valid[$key] = $value;
    }

    // return it and prevent WordPress depression
    return $valid;
}

/* ----------------------------------------
* create the settings page layout
----------------------------------------- */

function _m2displayPage() {
   global $rg_m2_fields;
   echo '<div class="wrap" id="rg-m2">';
      	echo '<div class="icon"></div>';
      	echo '<h2>' . __( 'RG M2 Options', RG_M2_LOCALE ) . '</h2>';
      	
      	if ( ! isset( $_REQUEST['settings-updated'] ) )
   			$_REQUEST['settings-updated'] = false;
   			
   		if( $_GET['page'] == 'rg-m2-settings' && isset($_GET['all-transients-deleted']) ):
		    echo '<div class="updated fade"><p>All Transients Deleted</p></div>';
		elseif( $_GET['page'] == 'rg-m2-settings' && isset($_GET['transient-deleted']) ):
			echo '<div class="updated fade"><p>'.$_REQUEST['transient'].' Transient Deleted</p></div>';
		endif;
   
      echo '<div class="has-right-sidebar">';
      	echo '<style>';
      		echo '#poststuff { width: 25% !important; overflow: hidden !important; float: right !important; min-width: 25% !important; }';
      	echo '</style>';
      	echo '<div id="poststuff">';
      		echo $this->_m2sidebarMenu();
      	echo '</div>';
      
      	echo '<div style="float: left; width: 75%;" >';
      		echo '<form method="post" action="options.php" class="rg_options_form">';
      			settings_fields('rg_store_options');
      			wp_nonce_field( basename(__FILE__), 'RG_Admin_Page_Class_nonce' );
      			
      			echo '<div id="section_container">';
      			echo '<table class="form-table rg-m2">';
						foreach ( $rg_m2_fields as $field ) {
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
						   			
						   			$meta = get_option( 'rg_store_options' );
						   			echo $this->_m2displaySettings( $field, $meta[$field['id']] );
						   			
						   	echo     '<td>
						   		</tr>';
						   }
						} // end foreach
						echo '</table>'; // end table
					echo '</div>';      			
      			echo '<p class="submit"><input name="Submit" type="submit" class="button-primary" value="'. __( 'Save Options', RG_M2_LOCALE ). '" /></p>';
      		echo '</form>';
      	echo '</div>';
      	echo $this->_m2transientMenu();
      echo '</div>';
   echo '</div>';
   
}

public function _m2settingsMenu() {
   add_menu_page( 'RG M2 Options', 'RG M2 Options', 'manage_options', 'rg-m2-settings', array( $this, '_m2displayPage' ), RG_M2_URL.'/images/wp_m2_icon.png', 100 );
}

/* ----------------------------------------
* register the plugin settings
----------------------------------------- */

public function _m2registerSettings() {
	register_setting( 'rg_store_options', 'rg_store_options', array( $this, '_m2validateThis' ) );
}


/* ----------------------------------------
* register scripts & styles
----------------------------------------- */
public function _m2AdminScripts() {
	if( is_admin() && $_GET['page'] == 'rg-m2-settings' ) {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_media();
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('farbtastic');
		wp_enqueue_script('chosen', RG_M2_URL . '/js/chosen.js' );
    	wp_enqueue_script( 'spinner', RG_M2_URL . '/js/spin.js', array('jquery'), true);
		wp_enqueue_script('admin-js', RG_M2_URL . '/js/custom-admin.js');
	}
}

public function _m2AdminStyles() {
	if( is_admin() && $_GET['page'] == 'rg-m2-settings' ) {
		wp_enqueue_style('thickbox');
		wp_enqueue_style('farbtastic');
		wp_enqueue_style('chosen', RG_M2_URL. '/css/chosen.css' );
		wp_enqueue_style('admin-css', RG_M2_URL . '/css/admin-panel.css');
		wp_enqueue_style('jquery-ui-custom', RG_M2_URL.'/css/jquery-ui-custom.css');
	}
}
   	

public function _m2addCustomScripts() {
   global $rg_m2_fields;
   
   $meta = get_option( 'rg_store_options' );
   
   $output = '<script type="text/javascript">
   			jQuery(function($){';
   			
   foreach ( $rg_m2_fields as $field ) {
	   switch( $field['type'] ) {
	   	case 'format_date' :
		    echo '$( "#' . $field['id'] . '" ).datepicker();
    	    	  $( "#format" ).change(function() {
    	    	    $( "#' . $field['id'] . '" ).datepicker( "option", "dateFormat", $( this ).val() );
    	    	  });';
		break;
		case 'date' :
		    echo '$("#' . $field['id'] . '").datepicker({
		     		dateFormat: mm/dd/yy
		     	});';
		break;
	   	// timepicker
		case 'timepicker' :
		    echo '$("input#'.$field['id'].'").timepicker({
		    			timeFormat: "hh:mm tt"
		    	  })';
		break;
	   }
	}		
   $output .= '});
   	</script>';

   echo $output;
}

/*/////////////////////////////////////////////////////
	* Transients
/////////////////////////////////////////////////////*/
	
	public function _getTransients( $args = array() ) {
	    global $wpdb;
	
	    $defaults = array(
	    	'offset' => 0,
	    	'number' => 30,
	    	'search' => ''
	    );
	    $args       = wp_parse_args( $args, $defaults );
	    $cache_key  = md5( serialize( $args ) );
	    $transients = wp_cache_get( $cache_key );
	
	    if( false === $transients ) {
	    	//$sql = "SELECT * FROM $wpdb->options WHERE option_name LIKE '\_transient\_%'";
	    	$sql = "SELECT * FROM $wpdb->options WHERE option_name LIKE '\_transient\_%' OR '\_transient\_timeout%'";
	    	if( ! empty( $args['search'] ) ) {
	    		$search  = esc_sql( $args['search'] );
	    		$sql    .= " AND option_name LIKE '%{$search}%'";
	    	}
	    	$offset = absint( $args['offset'] );
	    	$number = absint( $args['number'] );
	    	$sql .= " ORDER BY option_id DESC LIMIT $offset,$number;";
	
	    	$transients = $wpdb->get_results( $sql );
	
	    	wp_cache_set( $cache_key, $transients, '', 3600 );
	    }
	
	    return $transients;
	}
	
	private function _getTransientName( $transient ) {
	    return substr( $transient->option_name, 11, strlen( $transient->option_name ) );
	}
	
	private function _getTransientExpirationTime( $transient ) {
	    return get_option( '_transient_timeout_' . $this->_getTransientName( $transient ) );
	}
	
	private function _getTransientExpiration( $transient ) {
	    $time_now   = time();
	    $expiration = $this->_getTransientExpirationTime( $transient );
	
	    if( empty( $expiration ) ) {
	    	return __( 'Does not expire', RG_M2_LOCALE );
	    }
	    if( $time_now > $expiration ) {
	    	return __( 'Expired', RG_M2_LOCALE );
	    }
	    return human_time_diff( $time_now, $expiration );
	}
	
	private function delete_transient( $transient = '' ) {
	    if( empty( $transient ) ) {
	    	return false;
	    }
	    return delete_transient( $transient );
	}
	
	private function _deleteAllTransients() {
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
		return true;
	}

	private function _getTotalTransients() {
	    global $wpdb;
	
	    $count = wp_cache_get( 'rg_transients_count' );
	
	    if( false === $count ) {
	        $count = $wpdb->get_var( "SELECT count(option_id) FROM $wpdb->options where option_name LIKE '\_transient\_%'" );
	        wp_cache_set( 'rg_transients_count', $count, '', 3600 );
	    }
	    return $count;
	}
	
	public function _processFormActions() {
	    if( empty( $_REQUEST['action'] ) ) {
	    	return;
	    }
	    if( empty( $_REQUEST['transient'] ) ) {
	    	return;
	    }
	    if( ! current_user_can( 'manage_options' ) ) {
	    	return;
	    }
	    if( ! wp_verify_nonce( $_REQUEST['_wpnonce'] , 'transient_management' ) ) {
	    	return;
	    }
	    switch( $_REQUEST['action'] ) {
	    	case 'delete_transients' :
	    		$this->delete_transient( $_REQUEST['transient'] );
	    		wp_safe_redirect( admin_url( 'admin.php?page=rg-m2-settings&transient-deleted' ) ); exit;
	    	break;
	
	    	case 'delete_all_transients' :
	    		$this->_deleteAllTransients();
	    		wp_safe_redirect( admin_url( 'admin.php?page=rg-m2-settings&all-transients-deleted' ) ); exit;
	    	break;
	    }
	
	}
	
	public function _m2transientMenu(){
		$transients = $this->_getTransients();
		//$this->pre($transients);
		echo '<div id="side-info-column" style="width: 75%; clear: both;">';
			echo '<div class="postbox">';
				echo '<h2>'.__( 'Transients', RG_M2_LOCALE ).'</h2>';
				echo '<div class="postbox" style="height: 300px; overflow: auto;">';
					echo '<table class="wp-list-table widefat fixed posts">';
					    echo '<tr>
					    	      <th style="width:70px;">'.__( 'ID', RG_M2_LOCALE ).'</th>
					    	      <th style="width: 325px;">'.__( 'Name', RG_M2_LOCALE ).'</th>
					    	      <th style="width: 180px;">'.__( 'Expires In', RG_M2_LOCALE ).'</th>
					    	  </tr>';
					    if( $transients ):
					    	foreach( $transients as $transient ):
					    	//$this->pre($transient);
$delete_url = wp_nonce_url( add_query_arg( array( 'action' => 'delete_transients', 'transient' => $this->_getTransientName( $transient ) ) ), 'transient_management' );
					    		echo '<tr>';
					    			echo '<td>'.$transient->option_id.'</td>';
					    			echo '<td>'.$this->_getTransientName( $transient ).'</td>';
					    			echo '<td>'.$this->_getTransientExpiration( $transient ).'</td>';
					    			echo '<td><a href="'.esc_url( $delete_url ).'" class="delete" style="color:#a00;">'.__( 'Delete', RG_M2_LOCALE ).'</a></td>';
					    		echo '</tr>';
					    	endforeach;
					    else :
					    	echo '<tr><td colspan="5">'.__( 'No transients found', RG_M2_LOCALE ).'</td>';
					    endif;
					echo '</table>';
				echo '</div>';
				echo '<form method="post" style="padding:0 0 20px 0;">
						<input type="hidden" name="action" value="delete_all_transients" />
						<input type="hidden" name="transient" value="all" />';
						wp_nonce_field( 'transient_management' );
				   echo '<input type="submit" class="button-primary" value="'. __( 'Delete Transients', RG_M2_LOCALE ).'" />';
				echo '</form>';
			echo '</div>';
		echo '</div>';
	}


   public function _m2sidebarMenu() {
      echo '<div id="side-info-column">';
      /* Instructions
      ========================================================*/
      echo '<div class="postbox">
      		<h3 class="hndle">' . __( 'How to Use', RG_M2_LOCALE ) . '</h3>';   
   		echo '<div class="inside">
   			<h4>' . __( 'How to add the cart', RG_M2_LOCALE ) . '</h4>
   			
   		 	To render the cart add this ID to any element:
   		 	<pre><code> #cart-container </code></pre>
   		 	';
   		
   		echo '</div>';
   echo '<div class="inside">
       <h4>' . __( 'URL Rewrite', RG_M2_LOCALE ) . '</h4>
       Add these functons to your themes function.php file:
    	<pre><code>
   add_filter( "query_vars", "add_query_vars_filter" );
   function add_query_vars_filter( $qvars ){
     $qvars[] = "productID";
     return $qvars;
   }
   
   function add_rewrite_rules($aRules) {
       $aNewRules = array("store/product/([0-9]+)/?$" => "index.php?pagename=store/product&productID=$matches[1]");
       $aRules = $aNewRules + $aRules;
       return $aRules;
   }
   add_filter("rewrite_rules_array", "add_rewrite_rules");
    	</code></pre>';
   
   echo '</div>';
      echo	'</div>';
      
      /* Credits
      ========================================================*/
      echo '<div class="postbox credits">
      		<h3 class="hndle">' . __( 'Credits', RG_M2_LOCALE ) . '</h3>
      		<div class="inside">';
      
      echo '<ul>
      	<li>' . __( 'Author:', RG_M2_LOCALE ) . ' <a href="http://www.rgenerator.com/" target="_blank">RGenerator</a></li>
      </ul>';
      echo '</div>
      	</div>';
      echo '</div>';
      
   }

}

new RG_Admin_Options;

?>