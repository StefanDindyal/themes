<?php

// Register Custom Post Type
if (function_exists("register_post_type")) {

  function register_module() {

    $labels = array(
      "name"                => _x( "Modules", "Post Type General Name" ),
      "singular_name"       => _x( "Module", "Post Type Singular Name"),
      "menu_name"           => __( "Modules"),
      "parent_item_colon"   => __( ""),
      "all_items"           => __( "All Modules"),
      "view_item"           => __( "View Module"),
      "add_new_item"        => __( "Add Modules"),
      "add_new"             => __( "Add Module"),
      "edit_item"           => __( "Edit Module"),
      "update_item"         => __( "Update Module"),
      "search_items"        => __( "Search Modules"),
      "not_found"           => __( "Not found"),
      "not_found_in_trash"  => __( "Not found in Trash"),
    );
    $args = array(
      "label"               => __( "Module"),
      "description"         => __( "Modules "),
      "labels"              => $labels,
      "supports"            => array( "title", "editor", "excerpt", "author", "thumbnail" ),
      "hierarchical"        => false,
      "public"              => true,
      "show_ui"             => true,
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
    register_post_type( "module", $args );
  }

  // Hook into the "init" action
  add_action( "init", "register_module");

}