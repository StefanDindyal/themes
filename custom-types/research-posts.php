<?php

// Register Custom Post Type
if (function_exists("register_post_type")) {
  
  function register_research_post() {

    $labels = array(
      "name"                => _x( "Research Articles", "Post Type General Name" ),
      "singular_name"       => _x( "Research Article", "Post Type Singular Name"),
      "menu_name"           => __( "Research Articles"),
      "parent_item_colon"   => __( ""),
      "all_items"           => __( "All Research Articles"),
      "view_item"           => __( "View Research Article"),
      "add_new_item"        => __( "Add Research Articles"),
      "add_new"             => __( "Add Research Article"),
      "edit_item"           => __( "Edit Research Article"),
      "update_item"         => __( "Update Research Article"),
      "search_items"        => __( "Search Research Articles"),
      "not_found"           => __( "Not found"),
      "not_found_in_trash"  => __( "Not found in Trash"),
    );
    $args = array(
      "label"               => __( "Research Article"),
      "description"         => __( "Research Articles "),
      "labels"              => $labels,
      "supports"            => array( "title", "editor", "excerpt", "author", "thumbnail", "comments" ),
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
    register_post_type( "research_post", $args );

  }

  // Hook into the "init" action
  add_action( "init", "register_research_post");

}