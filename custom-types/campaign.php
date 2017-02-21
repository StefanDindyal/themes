<?php

// Register Custom Post Type
if (function_exists("register_post_type")) {

  function register_campaign() {

    $labels = array(
      "name"                => _x( "Campaigns", "Post Type General Name" ),
      "singular_name"       => _x( "Campaign", "Post Type Singular Name"),
      "menu_name"           => __( "Campaigns"),
      "parent_item_colon"   => __( ""),
      "all_items"           => __( "All Campaigns"),
      "view_item"           => __( "View Campaign"),
      "add_new_item"        => __( "Add Campaign"),
      "add_new"             => __( "Add Campaign"),
      "edit_item"           => __( "Edit Campaign"),
      "update_item"         => __( "Update Campaign"),
      "search_items"        => __( "Search Campaigns"),
      "not_found"           => __( "Not found"),
      "not_found_in_trash"  => __( "Not found in Trash"),
    );
    $args = array(
      "label"               => __( "Campaign"),
      "description"         => __( "Campaign "),
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
      "has_archive"         => false,
      "exclude_from_search" => false,
      "publicly_queryable"  => true,
      "capability_type"     => "page",
    );
    register_post_type( "campaign", $args );

  }

  // Hook into the "init" action
  add_action( "init", "register_campaign");
}


// Remove format metabox (custom field is used instead)
add_action( 'admin_menu' , function () {
  remove_meta_box( 'tagsdiv-vertical', 'campaign', 'side' );
  remove_meta_box( 'tagsdiv-feature', 'campaign', 'side' );
});
