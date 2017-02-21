<?php

// Register Custom Post Type
if (function_exists("register_post_type")) {
  
  function register_news_articles() {

    $labels = array(
      "name"                => _x( "News Articles", "Post Type General Name" ),
      "singular_name"       => _x( "News Article", "Post Type Singular Name"),
      "menu_name"           => __( "News Articles"),
      "parent_item_colon"   => __( ""),
      "all_items"           => __( "All News Articles"),
      "view_item"           => __( "View News Article"),
      "add_new_item"        => __( "Add News Articles"),
      "add_new"             => __( "Add News Article"),
      "edit_item"           => __( "Edit News Article"),
      "update_item"         => __( "Update News Article"),
      "search_items"        => __( "Search News Articles"),
      "not_found"           => __( "Not found"),
      "not_found_in_trash"  => __( "Not found in Trash"),
    );
    $args = array(
      "label"               => __( "News Article"),
      "description"         => __( "News"),
      "labels"              => $labels,
      "supports"            => array( "title", "editor", "excerpt", "author", "thumbnail" ),
      "hierarchical"        => false,
      "public"              => true,
      "show_ui"             => true,
      'taxonomies'          => array(),
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
    register_post_type( "news_article_type", $args );
  }

  // Hook into the "init" action
  add_action( "init", "register_news_articles");

}