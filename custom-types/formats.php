<?php

// Register Custom Post Type
if (function_exists("register_post_type")) {

  function register_format() {

    $labels = array(
      "name"                => _x( "Formats", "Post Type General Name" ),
      "singular_name"       => _x( "Format", "Post Type Singular Name"),
      "menu_name"           => __( "Formats"),
      "parent_item_colon"   => __( ""),
      "all_items"           => __( "All Formats"),
      "view_item"           => __( "View Format"),
      "add_new_item"        => __( "Add Format"),
      "add_new"             => __( "Add Format"),
      "edit_item"           => __( "Edit Format"),
      "update_item"         => __( "Update Format"),
      "search_items"        => __( "Search Formats"),
      "not_found"           => __( "Not found"),
      "not_found_in_trash"  => __( "Not found in Trash"),
    );
    $args = array(
      "label"               => __( "Format"),
      "description"         => __( "Formats"),
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
    register_post_type( "format", $args );
  }

  // Hook into the "init" action
  add_action( "init", "register_format");
  add_action( 'admin_menu' , function () {
    remove_meta_box( 'tagsdiv-device', 'format', 'side' );
  });
}
