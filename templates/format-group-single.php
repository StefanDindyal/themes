<?php
$posts_ids = get_field("formats");
$posts_ids = (!empty($posts_ids)) ? $posts_ids : array();
$query = new WP_Query(array("post_type" => "format", "post__in" => $posts_ids, "orderby" => "post__in"));
$heroImage = (get_field("hero_image")) ? get_field("hero_image") : null;
$backgroundMobilePortrait = \Roots\Sage\Utils\get_image_by_device(get_field("bg_image_mobile_portrait"));
$backgroundMobileLandscape = \Roots\Sage\Utils\get_image_by_device(get_field("bg_image_mobile_landscape"));

if($backgroundMobilePortrait == ""){
$backgroundMobilePortrait = $heroImage;
};

if($backgroundMobileLandscape == ""){
$backgroundMobileLandscape = $heroImage;
}
render_component("hero", array("bg" => $heroImage, "bgLandscape" => $backgroundMobileLandscape, "bgPortrait" => $backgroundMobilePortrait ));
echo "<div class='format-group'>";
while ($query->have_posts()) : $query->the_post(); 
  get_template_part("single", "format");
  wp_reset_postdata();
endwhile;
echo "</div>";
?>
