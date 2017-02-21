<?php
// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_device_taxonomy', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_device_taxonomy() {
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name'              => _x( 'Devices', 'taxonomy general name' ),
    'singular_name'     => _x( 'Device', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Devices' ),
    'all_items'         => __( 'All Devices' ),
    'parent_item'       => __( 'Parent Device' ),
    'parent_item_colon' => __( 'Parent Device:' ),
    'edit_item'         => __( 'Edit Device' ),
    'update_item'       => __( 'Update Device' ),
    'add_new_item'      => __( 'Add New Device' ),
    'new_item_name'     => __( 'New Device Name' ),
    'menu_name'         => __( 'Devices' ),
  );

  $args = array(
    'hierarchical'      => false,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'genre' ),
  );

  register_taxonomy('device', array( 'format' ), $args );
}
