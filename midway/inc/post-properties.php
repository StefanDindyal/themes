<?php
add_action( 'init', 'post_properties', 0 );
function post_properties() {
    $labels = array(
		'name' => __( 'Properties', 'midway' ),
		'singular_name' => __( 'Property', 'midway' ),
		'add_new' => __( 'Add New Property', 'midway' ),
		'add_new_item' => __( 'Add New Property', 'midway' ),
		'edit_item' => __( 'Edit Property', 'midway' ),
		'new_item' => __( 'New Property Post Item', 'midway' ),
		'view_item' => __( 'View Property', 'midway' ),
		'search_items' => __( 'Search Properties', 'midway' ),
		'not_found' => __( 'Nothing found', 'midway' ),
		'not_found_in_trash' => __( 'Nothing found in Trash', 'midway' ),
		'parent_item_colon' => ''
	); 	
    $args = array( 
        'labels' => $labels, // adds your $labels array from above
		  'public' => true,
		  'publicly_queryable' => true,
		  'show_ui' => true,
		  'query_var' => true,
		  'capability_type' => 'post',
		  'hierarchical' => true,
		  'rewrite' => array( 'slug' => 'properties' ), // changes name in permalink structure
		  'menu_icon' => 'dashicons-building',
		  'menu_position' => 4, // search WordPress Codex for menu_position parameters
		  'supports' => array( 'title', 'editor', 'thumbnail' )
    );
    register_post_type( 'properties', $args ); // adds your $args array from above

    function post_properties_custom_columns( $columns ) {
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Title",
			"propstate" => "State",
			"propimage" => "Image",			
			"date" => "Date"
		);
		return $columns;
	}
	add_filter( 'manage_edit-properties_columns', 'post_properties_custom_columns' );

    function post_properties_custom_column_content( $column_name ) {
    	global $post;
		$image_src = wp_get_attachment_url( get_post_thumbnail_id( $post_ID ) );
		if( "propimage" == $column_name ){
			if($image_src){
				echo "<img id='work-img' src='$image_src' style='max-width:200px;' />";
			} else {
				echo "No image";
			}
		}
		if( "propstate" == $column_name ){
			/* Get the genres for the post. */
			$terms = get_the_terms( $post_id, 'states' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'states' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'states', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				_e( 'No State Selected' );
			}
		}
	}
	add_action( 'manage_properties_posts_custom_column', 'post_properties_custom_column_content' );

	add_filter( 'manage_edit-properties_sortable_columns', 'my_website_manage_sortable_columns' );
	function my_website_manage_sortable_columns( $sortable_columns ) {		
		$sortable_columns[ 'propstate' ] = 'name';			   
		return $sortable_columns;
	}

    function post_properties_meta($current_screen){
		if ( 'properties' == $current_screen->post_type && 'post' == $current_screen->base ) {
			$prefix = 'prop_';			
			$fields = array(
				array(
				    'label' => 'City',
				    'desc'  => 'Properties location city.',
				    'id'    => $prefix.'city',			
				    'type'  => 'text'
				),
				array(
				    'label' => 'Units',
				    'desc'  => 'The number of units for this property.',
				    'id'    => $prefix.'units',			
				    'type'  => 'text'
				)
			);
			$property_box = new custom_add_meta_box( 'property_box', 'Property Options', $fields, 'properties', true );
		}
	}
	add_action( 'current_screen', 'post_properties_meta' );
}
add_action( 'init', 'create_states', 0 );
function create_states() {
    register_taxonomy(
        'states',
        'properties',
        array(
            'labels' => array(
                'name' => 'Property States',
                'add_new_item' => 'Add New State',
                'new_item_name' => "New State"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );
}