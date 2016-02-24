<?php

function _M2customMetaBoxField( $field, $meta = null, $repeatable = null ) {
	if ( ! ( $field || is_array( $field ) ) )
		return;

	$type = isset( $field['type'] ) ? $field['type'] : null;
	$label = isset( $field['label'] ) ? $field['label'] : null;
	$desc = isset( $field['desc'] ) ? '<span class="description">' . $field['desc'] . '</span>' : null;
	$width = isset( $field['width'] ) ? $field['width'] : null;
	$options = isset( $field['options'] ) ? $field['options'] : null;
	
	// the id and name for each field
	$id = $name = isset( $field['id'] ) ? $field['id'] : null;
	if ( $repeatable ) {
		$name = $repeatable[0] . '[' . $repeatable[1] . '][' . $id .']';
		$id = $repeatable[0] . '_' . $repeatable[1] . '_' . $id;
	}
	switch( $type ) {
		// select
		case 'select':
			echo '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '">
					<option value="">Select One</option>'; // Select One
			foreach ( $options as $option )
				echo '<option' . selected( $meta, $option['value'], false ) . ' value="' . $option['value'] . '">' . $option['label'] . '</option>';
			echo '</select><br />' . $desc;
		break;

	} //end switch
		
}

function _m2metaBoxSantitizeBoolean( $string ) {
	if ( ! isset( $string ) || $string != 1 || $string != true )
		return false;
	else
		return true;
}

function _m2metaBoxSanitize( $string, $function = 'sanitize_text_field' ) {
	switch ( $function ) {
		case 'intval':
			return intval( $string );
		case 'absint':
			return absint( $string );
		case 'wp_kses_post':
			return wp_kses_post( $string );
		case 'wp_kses_data':
			return wp_kses_data( $string );
		case 'esc_url_raw':
			return esc_url_raw( $string );
		case 'is_email':
			return is_email( $string );
		case 'sanitize_title':
			return sanitize_title( $string );
		case 'santitize_boolean':
			return santitize_boolean( $string );
		case 'sanitize_text_field':
		default:
			return sanitize_text_field( $string );
	}
}

function _m2metaBoxArrayMap( $func, $meta, $sanitizer ) {
		
	$newMeta = array();
	$meta = array_values( $meta );
	
	foreach( $meta as $key => $array ) {
		if ( $array == '' )
			continue;

		if ( ! is_array( $array ) ) {
			return array_map( $func, $meta, (array)$sanitizer );
			break;
		}
		$keys = array_keys( $array );
		$newSanitizer = $sanitizer;
		if ( is_array( $sanitizer ) ) {
			foreach( $newSanitizer as $sanitizerKey => $value )
				if ( ! in_array( $sanitizerKey, $keys ) )
					unset( $newSanitizer[$sanitizerKey] );
		}
		foreach( $array as $arrayKey => $arrayValue )
			if ( is_array( $arrayValue ) )
				$array[$arrayKey] = _m2metaBoxArrayMap( $func, $arrayValue, $newSanitizer[$arrayKey] );
		
		$array = array_map( $func, $array, $newSanitizer );
		$newMeta[$key] = array_combine( $keys, array_values( $array ) );
	}
	return $newMeta;
}

class _M2customMetaBox {
	
	var $id;
	var $title;
	var $fields;
	var $page;
	
    public function __construct( $id, $title, $fields, $page ) {
		$this->id = $id;
		$this->title = $title;
		$this->fields = $fields;
		$this->page = $page;
		
		if( ! is_array( $this->page ) )
			$this->page = array( $this->page );
		
		add_action( 'admin_enqueue_scripts', array( $this, '_m2metaBoxEnqueueCss' ) );
		add_action( 'add_meta_boxes', array( $this, '_m2metaBoxAddBox' ) );
		add_action( 'save_post',  array( $this, '_m2metaBoxSaveBox' ));
    }
	
	function _m2metaBoxEnqueueCss() {
		global $pagenow;
		if ( in_array( $pagenow, array( 'post-new.php', 'post.php' ) ) && in_array( get_post_type(), $this->page ) ) {
			$deps = array();
			wp_enqueue_style( 'meta_box', get_template_directory_uri(). '/inc/metaboxes/css/meta_box.css', $deps );
		}
	}

	function _m2metaBoxAddBox() {
		foreach ( $this->page as $page ) {
			add_meta_box( $this->id, $this->title, array( $this, '_m2metaBoxCallback' ), $page, 'normal', 'high' );
		}
	}

	function _m2metaBoxCallback() {
		// Use nonce for verification
		wp_nonce_field( 'm2_custom_meta_box_nonce_action', 'm2_custom_meta_box_nonce_field' );
		
		// Begin the field table and loop
		echo '<table class="form-table meta_box">';
		foreach ( $this->fields as $field) {
			if ( $field['type'] == 'section' ) {
				echo '<tr id="'.$field['id'].'">
						<td colspan="2">
							<h2>' . $field['label'] . '</h2>
						</td>
					</tr>';
			} else {
				echo '<tr id="'.$field['id'].'">
						<th style="width:15%"><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
						<td>';
						
						$meta = get_post_meta( get_the_ID(), $field['id'], true);
						echo _M2customMetaBoxField( $field, $meta );
						
				echo '</td>
					</tr>';
			}
		} // end foreach
		echo '</table>'; // end table
	}
	
	function _m2metaBoxSaveBox( $post_id ) {
		$post_type = get_post_type();
		
		// verify nonce
		if ( ! isset( $_POST['m2_custom_meta_box_nonce_field'] ) )
			return $post_id;
		if ( ! ( in_array( $post_type, $this->page ) || wp_verify_nonce( $_POST['m2_custom_meta_box_nonce_field'],  'm2_custom_meta_box_nonce_action' ) ) ) 
			return $post_id;
		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
		// check permissions
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;
		
		// loop through fields and save the data
		foreach ( $this->fields as $field ) {
			if( $field['type'] == 'section' ) {
				$sanitizer = null;
				continue;
			}
			if( in_array( $field['type'], array( 'tax_select', 'tax_checkboxes' ) ) ) {
				// save taxonomies
				if ( isset( $_POST[$field['id']] ) ) {
					$term = $_POST[$field['id']];
					wp_set_object_terms( $post_id, $term, $field['id'] );
				}
			}
			else {
				// save the rest
				$new = false;
				$old = get_post_meta( $post_id, $field['id'], true );
				if ( isset( $_POST[$field['id']] ) )
					$new = $_POST[$field['id']];
				if ( isset( $new ) && '' == $new && $old ) {
					delete_post_meta( $post_id, $field['id'], $old );
				} elseif ( isset( $new ) && $new != $old ) {
					$sanitizer = isset( $field['sanitizer'] ) ? $field['sanitizer'] : 'sanitize_text_field';
					if ( is_array( $new ) )
						$new = _m2metaBoxArrayMap( '_m2metaBoxSanitize', $new, $sanitizer );
					else
						$new = _m2metaBoxSanitize( $new, $sanitizer );
					update_post_meta( $post_id, $field['id'], $new );
				}
			}
		} // end foreach
	}
	
}