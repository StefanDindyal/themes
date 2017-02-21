<?php
/* API ROUTES FILE */

add_action('wp_ajax_nopriv_search', '\Api\Util::search');
add_action('wp_ajax_search', '\Api\Util::search');

add_action('wp_ajax_nopriv_search_suggestions', '\Api\Util::searchSuggestions');
add_action('wp_ajax_search_suggestions', '\Api\Util::searchSuggestions');

add_action('wp_ajax_nopriv_gallery_get', '\Api\Gallery::get');
add_action('wp_ajax_gallery_get', '\Api\Gallery::get');

add_action('wp_ajax_nopriv_job_get', '\Api\Util::getJobs');
add_action('wp_ajax_job_get', '\Api\Util::getJobs');

add_action('wp_ajax_nopriv_more_posts', '\Api\Util::morePosts');
add_action('wp_ajax_more_posts', '\Api\Util::morePosts');
