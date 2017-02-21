<?php

// Register Custom Post Type
if (function_exists("register_post_type")) {

  function register_format_group() {
    $labels = array(
      "name"                => _x( "Format Groups", "Post Type General Name" ),
      "singular_name"       => _x( "Format Group", "Post Type Singular Name"),
      "menu_name"           => __( "Format Groups"),
      "parent_item_colon"   => __( ""),
      "all_items"           => __( "All Format Groups"),
      "view_item"           => __( "View Format Group"),
      "add_new_item"        => __( "Add Format Group"),
      "add_new"             => __( "Add Format Group"),
      "edit_item"           => __( "Edit Format Group"),
      "update_item"         => __( "Update Format Group"),
      "search_items"        => __( "Search Format Group"),
      "not_found"           => __( "Not found"),
      "not_found_in_trash"  => __( "Not found in Trash"),
    );
    $args = array(
      "label"               => __( "Format Group"),
      "description"         => __( "Format Group "),
      "labels"              => $labels,
      "supports"            => array( "title" ),
      "hierarchical"        => false,
      "public"              => true,
      "show_ui"             => true,
      "show_in_menu"        => true,
      "show_in_nav_menus"   => true,
      "show_in_admin_bar"   => true,
      "menu_position"       => 3,
      "can_export"          => true,
      "has_archive"         => false,
      "exclude_from_search" => false,
      "publicly_queryable"  => true,
      "capability_type"     => "page",
    );
    register_post_type( "format_group", $args );

  }

  // Hook into the "init" action
  add_action( "init", "register_format_group");
}
