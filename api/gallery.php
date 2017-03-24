<?php
namespace Api;
class Gallery {
  // Gets the gallery posts filter by the corrresponding parameters.
  public static function get() {
    // Security Check
    Util::verifyNonce();

    // Constants
    $DEFAULT_OVERLAY_COLOR = "#000000";
    $DEFAULT_TEXT_COLOR = "#FFFFFF";
    $DEFAULT_BUTTON_PRIMARY_COLOR = "#FFFFFF";
    $DEFAULT_BUTTON_SECONDARY_COLOR = "#000000";
    $ITEMS_PER_PAGE = 16;

    // Variables.
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
    $format = isset($_GET["format"]) ? $_GET["format"] : null;
    $vertical = isset($_GET["vertical"]) ? $_GET["vertical"] : null;
    $feature = isset($_GET["feature"]) ? $_GET["feature"] : null;
    $device = isset($_GET["device"]) ? $_GET["device"] : null;
    //fav
    $favorite = isset($_GET["favorite"]) ? $_GET["favorite"] : null;
    //fav
    $taxQuery = array("relation" => "AND");
    $metaQuery = array("relation" => "AND");
    $results = array();
    $response = array();

    if (!empty($format)) {
      $formatFilter = array(
        "key" => "ad_format",
        "value"    => serialize(array($format)),
        "compare"    => "="
      );
      array_push($metaQuery, $formatFilter);
    }
    if (!empty($favorite)) {
      $formatFilter = array(
        "key" => "top_campaign",
        "value"    => serialize(array($favorite)),
        "compare"    => "="
      );
      array_push($metaQuery, $formatFilter);
    }
    if (!empty($vertical)) {
      $verticalFilter = array(
        "taxonomy" => "vertical",
        "field"    => "term_id",
        "terms"    => $vertical
      );
      array_push($taxQuery, $verticalFilter);
    }
    if (!empty($feature)) {
      $featuresFilter = array(
        "taxonomy" => "feature",
        "field"    => "term_id",
        "terms"    => $feature
      );
      array_push($taxQuery, $featuresFilter);
    }

    if (!empty($device)) {
      $deviceMeta = array("relation" => "OR");

      foreach (self::getFormats($device) as $format) {
        $devicesFilter = array(
          "key" => "ad_format",
          "value" => '"'.$format->ID.'"',
          "compare" => "LIKE"
        );
        array_push($deviceMeta, $devicesFilter);
      }
      array_push($metaQuery, $deviceMeta);
    }

    $args = array(
      "post_type" => "campaign",
      "tax_query" => $taxQuery,
      "meta_query" => $metaQuery,
      "posts_per_page" => $ITEMS_PER_PAGE,
      "paged" => $page
    );

    $query = new \WP_Query($args);

    while ( $query->have_posts() ) {
      $query->the_post();
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );
      $image = (empty($image)) ? "http://placehold.it/500x500" : $image[0];
      $format = get_field("ad_format");
      $format = ($format) ? new \WP_Query(array("post_type" => "format", "post__in" => array($format[0]))) : null;
      if ($format) {
        $format = ($format->posts) ? $format->posts[0] : null;
      }
      $format = ($format) ? $format->post_title : "";

      $overlayColor = get_field("overlay_color") ? get_field("overlay_color") : $DEFAULT_OVERLAY_COLOR;
      $textColor = get_field("text_color") ? get_field("text_color") : $DEFAULT_TEXT_COLOR;
      $buttonPrimaryColor = get_field("button_primary_color") ? get_field("button_primary_color") : $DEFAULT_BUTTON_PRIMARY_COLOR;
      $buttonSecondaryColor = get_field("button_secondary_color") ? get_field("button_secondary_color") : $DEFAULT_BUTTON_SECONDARY_COLOR;
      $buttonSecondaryColor = get_field("button_secondary_color") ? get_field("button_secondary_color") : $DEFAULT_BUTTON_SECONDARY_COLOR;
      $use_image_tittle =  get_field("use_image_tittle") ?  "visibleTittle": "hidenTittle" ;
      $hide_tittle =  get_field("use_image_tittle") ?  "hidenTittle": "visibleTittle" ;

      $campaignUrl = get_field("campaign_url");
      $demoCode = get_field("demo_code");
      $contentType = get_field("content_type");
      $typeAudio = in_array('audio', $contentType);
      $typePhoto = in_array('photo', $contentType);      
      $typeVideo = in_array('video', $contentType);
      $launchBtn = get_field("show_launch_campaign");

      $entry["id"] = get_the_ID();
      $entry["title"] = get_the_title();
      $entry["format"] = $format;
      $entry["permalink"] = get_the_permalink();
      $entry["image"] = $image;
      $entry["overlayColor"] = $overlayColor;
      $entry["titleImage"] = get_field("tittle_image");
      $entry["showTittleImg"] = $use_image_tittle;
      $entry["hideTittle"] = $hide_tittle;
      $entry["textColor"] = $textColor;
      $entry["buttonPrimaryColor"] = $buttonPrimaryColor;
      $entry["buttonSecondaryColor"] = $buttonSecondaryColor;
      $entry["typeAudio"] = $typeAudio;
      $entry["typePhoto"] = $typePhoto;
      $entry["typeVideo"] = $typeVideo;
      $entry["campaignUrl"] = $campaignUrl;
      $entry["demoCode"] = $demoCode;
      $entry["launchBtn"] = $launchBtn;
      array_push($results, $entry);
    }
    $filters = self::getFilters($format, $device, $args);
    $response["results"] = $results;
    $response["filters"] = $filters;
    wp_send_json($response);
    exit;
  }

  private static function getFilters($formatId, $deviceId, $queryArgs) {
    $filters = array();
    $filters["formats"] = array();
    $filters["verticals"] = array();
    $filters["features"] = array();
    $filters["devices"] = array();
    $queryArgs["posts_per_page"] = -1;
    $query = new \WP_Query($queryArgs);

    // If a format filter is sent, then the device filter should be limited to the devices
    // for this format.
    if ($formatId) {
      $devicesIds = get_field("supported_devices", $formatId);
      $devices = get_terms("device", array("hide_empty" => false, "include" => $devicesIds));
    }

    if ($query->found_posts > 0) {
    // From the result set get the verticals and features.
    // This is very slow but the client insisted to keep those taxonomies at the campaign level.
      while ($query->have_posts()) {
        $query->the_post();
        $verticals = wp_get_post_terms(get_the_ID(), "vertical");
        $features = wp_get_post_terms(get_the_ID(), "feature");
        foreach($verticals as $vertical) {
          array_push($filters["verticals"], array("id" => $vertical->term_id, "name" => $vertical->name));
        }
        foreach($features as $feature) {
          array_push($filters["features"], array("id" => $feature->term_id, "name" => $feature->name));
        }
        $formatId = get_field("ad_format");
        $formatId = ($formatId[0]) ? $formatId[0] : null;
        if ($formatId) {
          $format = get_post($formatId);
          if ($format) {
            array_push($filters["formats"], array("id" => $format->ID, "name" => $format->post_title));
            $devices = wp_get_post_terms($formatId, "device");
            foreach($devices as $device) {
              array_push($filters["devices"], array("id" => $device->term_id, "name" => $device->name));
            }
          }
        }
      }
      $filters["verticals"] = array_map("unserialize", array_unique(array_map("serialize", $filters["verticals"])));
      $filters["features"] = array_map("unserialize", array_unique(array_map("serialize", $filters["features"])));
      $filters["formats"] = array_map("unserialize", array_unique(array_map("serialize", $filters["formats"])));
      $filters["devices"] = array_map("unserialize", array_unique(array_map("serialize", $filters["devices"])));
    } else {
      $formats = self::getFormats($deviceId);
      $verticals = get_terms("vertical", array("hide_empty" => false));
      $features = get_terms("feature", array("hide_empty" => false));
      $devices = get_terms("device", array("hide_empty" => false));
      foreach($formats as $format) {
        array_push($filters["formats"], array("id" => $format->ID, "name" => $format->post_title));
      }
      foreach($verticals as $vertical) {
        array_push($filters["verticals"], array("id" => $vertical->term_id, "name" => $vertical->name));
      }
      foreach($features as $feature) {
        array_push($filters["features"], array("id" => $feature->term_id, "name" => $feature->name));
      }
      foreach($devices as $device) {
        array_push($filters["devices"], array("id" => $device->term_id, "name" => $device->name));
      }
    }
    return $filters;
  }

  private static function getFormats($deviceId = null) {
    $posts = array();
    $taxQuery = array (
      array(
        "taxonomy" => "device",
        "field"    => "term_id",
        "terms"    => $deviceId
      )
    );
    $args = array(
      "post_type" => "format",
      "status" => "publish",
      "paged" => 1,
      "posts_per_page" => -1
    );
    if ($deviceId) {
      $args["tax_query"] = $taxQuery;
    }

    $query = new \WP_Query($args);

    while ( $query->have_posts() ) {
      $query->the_post();
      global $post;
      array_push($posts, $post);
    }
    return $posts;
  }
}
