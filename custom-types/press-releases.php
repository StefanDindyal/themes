<?php

// Register Custom Post Type
if (function_exists("register_post_type")) {

  function register_press_releases() {

    $labels = array(
      "name"                => _x( "Press Releases", "Post Type General Name" ),
      "singular_name"       => _x( "Press Release", "Post Type Singular Name"),
      "menu_name"           => __( "Press Releases"),
      "parent_item_colon"   => __( ""),
      "all_items"           => __( "All Press Releases"),
      "view_item"           => __( "View Press Release"),
      "add_new_item"        => __( "Add Press Releases"),
      "add_new"             => __( "Add Press Release"),
      "edit_item"           => __( "Edit Press Release"),
      "update_item"         => __( "Update Press Release"),
      "search_items"        => __( "Search Press Releases"),
      "not_found"           => __( "Not found"),
      "not_found_in_trash"  => __( "Not found in Trash"),
    );
    $args = array(
      "label"               => __( "Press Release"),
      "description"         => __( "Press Releases "),
      "labels"              => $labels,
      "supports"            => array( "title", "editor", "excerpt", "author", "thumbnail" ),
      "hierarchical"        => false,
      "public"              => true,
      "show_ui"             => true,
      'taxonomies'          => array('category'),
      "show_in_menu"        => true,
      "show_in_nav_menus"   => true,
      "show_in_admin_bar"   => true,
      "menu_position"       => 3,
      "can_export"          => true,
      "has_archive"         => true,
      "exclude_from_search" => true,
      "publicly_queryable"  => true,
      "capability_type"     => "page",
    );
    register_post_type( "press_release_type", $args );
  }

  // Hook into the "init" action
  add_action( "init", "register_press_releases");

}