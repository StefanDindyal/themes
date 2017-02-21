<?php
// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_vertical_taxonomy', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_vertical_taxonomy() {
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name'              => _x( 'Verticals', 'taxonomy general name' ),
    'singular_name'     => _x( 'Vertical', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Verticals' ),
    'all_items'         => __( 'All Verticals' ),
    'parent_item'       => __( 'Parent Vertical' ),
    'parent_item_colon' => __( 'Parent Vertical:' ),
    'edit_item'         => __( 'Edit Vertical' ),
    'update_item'       => __( 'Update Vertical' ),
    'add_new_item'      => __( 'Add New Vertical' ),
    'new_item_name'     => __( 'New Vertical Name' ),
    'menu_name'         => __( 'Verticals' ),
  );

  $args = array(
    'hierarchical'      => false,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'genre' ),
  );

  register_taxonomy('vertical', array( 'campaign' ), $args );
}
