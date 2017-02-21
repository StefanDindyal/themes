<?php while (have_posts()) : the_post(); ?>
<?php

$campaignLink = (get_field("campaign_url")) ? get_field("campaign_url") : "#";
$heroImage = (get_field("hero_image")) ? get_field("hero_image") : "https://placehold.it/1440x574";
$backgroundMobilePortrait = '';
$backgroundMobileLandscape = '';
$ad_format = get_field("ad_format");
$ad_format_group = get_field("ad_format_group");
$ad_format_group = $ad_format_group[0];
$ad_format_group = get_permalink($ad_format_group->ID);
$ad_format = new WP_Query(array("post_type" => "format", "post__in" => $ad_format));
$ad_format = $ad_format->posts[0];
$ad_format_name = ($ad_format) ? $ad_format->post_title : "";
$devices = get_field("devices");
$showLaunchInfo = get_field("show_launch_campaign");
$showLaunchInfo = (is_array($showLaunchInfo)) ? implode($showLaunchInfo, ",") : "";
$devicesInfo = "";
if($devices){
  $devicesInfo = $devices;
  foreach ($devicesInfo as $key => $field ) {
    $devicesInfo[$key] = ($field === "phone_landscape") ? "phone" : $field;
  }
  $devicesInfo = array_unique($devicesInfo);
  $devicesInfo = implode($devicesInfo, " + ");
}

$cleanedPostName = (!empty($ad_format_name)) ? \Roots\Sage\Utils\removeHtmlTags($ad_format->post_name, true) : ""; // removes html tag like "Title<sup>TM</supt>" => Title
$cleanedPostName = strtolower (\Roots\Sage\Utils\cleanSpecialChars($cleanedPostName));
$title = (!empty($ad_format_name)) ? '<a href="'.$ad_format_group.'#format-'.$cleanedPostName.'"><strong>'.$ad_format_name.'</strong></a> | '.get_the_title() : get_the_title();

$backgroundMobilePortrait = \Roots\Sage\Utils\get_image_by_device(get_field("bg_image_mobile_portrait"));
$backgroundMobileLandscape = \Roots\Sage\Utils\get_image_by_device(get_field("bg_image_mobile_landscape"));

if($backgroundMobilePortrait == ""){
  $backgroundMobilePortrait = $heroImage;
};

if($backgroundMobileLandscape == ""){
  $backgroundMobileLandscape = $heroImage;
}
?>

<div class="campaign-single-tpl">
  <?php /*render_component("hero", array("bg" => $heroImage, "bgLandscape" => $backgroundMobileLandscape, "bgPortrait" => $backgroundMobilePortrait ));*/ ?>
  <div class="header-image">
    <img src="<?php echo $heroImage; ?>" alt="<?php the_title();?>" border="0"/>
  </div>
  <div class="container">
      <h1 class="title"><?php echo $title; ?></h1>
      <section class="overview">
        <header class="overview-header">Overview</header>
        <div class="overview-content"><?php the_content(); ?></div>
      </section>
  </div>

  <section class="devices-section">
    <?php render_component("ad-media"); ?>
  </section>

  <div class="container">
    <div class="row">
      <?php if($campaignLink != "#") {?>
      <section class="launch-campaign hidden " data-devices="<?php echo $showLaunchInfo; ?>">
        <a class="btn-gray" href="<?php echo $campaignLink; ?>" target="_blank">Launch Live Campaign</a>
      </section>
      <?php } ?>

      <section class="info container">
        <dl class="col-xs-12 col-sm-6">
          <dt>Ad Format</dt>
          <dd><?php echo '<a href="'.$ad_format_group.'#format-'.$cleanedPostName. '">' . $ad_format_name . '</a>' ?></dd>
          <dt>Features</dt>
          <dd><?php the_field("functionality"); ?></dd>
          <dt>Devices</dt>
          <dd class="devices-info"><?php echo $devicesInfo; ?></dd>
        </dl>
        <figure class="col-xs-12 col-sm-6">
          <?php if ($ad_format) : ?>
          <?php render_component("format-metrics", array("format" => $ad_format->ID)); ?>
          <?php endif; ?>
        </figure>
      </section>
    </div>
  </div>
</div>


<script>
  $(document).ready(function () {
    app.templates.campaignSingle.init();
  });
</script>
<?php endwhile; ?>
