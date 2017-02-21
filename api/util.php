<?php

namespace Api;
class Util {
  public static function search() {

    self::verifyNonce();
    $PER_PAGE = $_GET["resultsPerPage"];
    $searchString = $_GET["searchString"];
    $page = (isset($_GET["page"])) ? $_GET["page"] : 1;
    $query = new \WP_Query(array("s" => $searchString, 
                                "posts_per_page" => $PER_PAGE, 
                                "paged" => $page,
                                "post_type" => array("post", "page", "format", "campaign", "news_article_type",
                                               "press_release_type", "register_research_post")));
    $response = array();
    $results = array();


    while ( $query->have_posts() ) {
      $query->the_post();
      $postTypeName = get_post_type( get_the_ID() );
      $postTypeObject = get_post_type_object($postTypeName);
      $entry = array();
      $entry["title"] = get_the_title();
      $entry["type"] = $postTypeObject->labels->singular_name;
      $entry["excerpt"] = \Roots\Sage\Utils\get_excerpt(get_the_ID(), 120);
      $entry["permalink"] = get_the_permalink();
      array_push($results, $entry);
    }

    $response["total"] = (int) $query->found_posts;
    $response["totalPage"] = ceil((int)$query->found_posts / $PER_PAGE);
    $response["perPage"] = $PER_PAGE;
    $response["page"] = (int)$page;
    $response["results"] = $results;

    wp_send_json($response);
    exit;
  }

  public static function searchSuggestions() {
    self::verifyNonce();
    $searchString = $_GET["searchString"];
    $MAX_SUGGESTIONS = 4;
    add_filter( "posts_where", "\\title_filter", 10, 2 );
    $query = new \WP_Query(array("search_title" => $searchString, "posts_per_page" => $MAX_SUGGESTIONS,
            "paged" => 0, "orderby" => "title",
            "post_type" => array("post", "page", "format", "campaign", "news_article_type",
                                               "press_release_type", "register_research_post")));

    remove_filter( "posts_where", "\\title_filter", 10, 2 );
    error_log(json_encode(get_post_types()));
    $postCount = 0;
    $response = array();

    while ( $query-> have_posts() ) {
      $query->the_post();
      $postCount++;
      $suggestion["title"] = strtolower(get_the_title());
      $suggestion["permalink"] = get_the_permalink();
      array_push($response, $suggestion);
    }
    wp_send_json($response);
    exit;
  }

  public static function getJobs() {
    self::verifyNonce();
    $JOBS_API_URL = "http://app.jobvite.com/CompanyJobs/Xml.aspx?c=qtC9VfwT";
    $xml = file_get_contents($JOBS_API_URL);
    $xml = preg_replace('~\s*(<([^-->]*)>[^<]*<!--\2-->|<[^>]*>)\s*~','$1',$xml);
    $xml = simplexml_load_string($xml,'SimpleXMLElement', LIBXML_NOCDATA);
    echo json_encode($xml);
  }

  public static function morePosts() {
    self::verifyNonce();
    $page     = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
    $elements = isset($_GET["elements"]) ? intval($_GET["elements"]) : 5;
    $type     = isset($_GET["type"]) ? $_GET["type"] : "post";
    $year     = isset($_GET["year"]) ? intval($_GET["year"]) : -1;
    $author   = isset($_GET["author"]) ? $_GET["author"] : "";
    $cat      = isset($_GET["cat"]) ? $_GET["cat"] : "";
    $offset   = $page * $elements;
    
    if($year !== -1){
      /* Date Blog Page */
      $args = array( 'post_type' => array('post', 'research_post'), 'posts_per_page' => $elements, 'offset' => $offset, 'date_query' => array(array('year' => $year)));
    } else if($author !== ""){
      /* Author Blog Page */
      $args = array( 'post_type' => array('post', 'research_post'), 'posts_per_page' => $elements, 'offset' => $offset, 'author_name' => $author, 'orderby' => 'date', 'order' => 'DESC');
    } else if($cat !== ""){
      /* Category Blog Page */
      $args = array( 'post_type' => array('post', 'research_post'), 'posts_per_page' => $elements, 'offset' => $offset, 'category_name' => $cat, 'orderby' => 'date', 'order' => 'DESC');
    } else {
      /* Regular Specific Post Type Page */
      $args = array( 'post_type' => $type, 'posts_per_page' => $elements, 'offset' => $offset);
    }

    $loop = new \WP_Query( $args );

    ob_start();
    while ( $loop->have_posts() ) : $loop->the_post();
      get_template_part('templates/template-blog', 'thumbnail');
    endwhile;
    echo ob_get_clean();
  }

  public static function verifyNonce() {
    $nonce = $_GET["nonce"];
    if (!wp_verify_nonce( $nonce, "myajax-post-comment-nonce")) {
      die("Security check");
    }
  }
}
