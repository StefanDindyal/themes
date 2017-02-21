<?php
// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_feature_taxonomy', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_feature_taxonomy() {
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name'              => _x( 'Features', 'taxonomy general name' ),
    'singular_name'     => _x( 'Feature', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Features' ),
    'all_items'         => __( 'All Features' ),
    'parent_item'       => __( 'Parent Feature' ),
    'parent_item_colon' => __( 'Parent Feature:' ),
    'edit_item'         => __( 'Edit Feature' ),
    'update_item'       => __( 'Update Feature' ),
    'add_new_item'      => __( 'Add New Feature' ),
    'new_item_name'     => __( 'New Feature Name' ),
    'menu_name'         => __( 'Features' ),
  );

  $args = array(
    'hierarchical'      => false,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'genre' ),
  );

  register_taxonomy('feature', array( 'campaign' ), $args );
}
