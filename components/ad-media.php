<?php
/* This component requires the current post to have the "Devices" Custom field group.
   USAGE: <?php render_component("devices"); ?>
*/

// Get the media type
$componentName = "ad-component";
$componentId = $componentName . "-" . uniqid();
$mediaType  = get_field("type_of_media");
$wisitaCode = 0;

if($mediaType == "devices"){

  $devices = get_field("devices");
  $devices = (is_array($devices)) ? $devices : array();
  $devicesClass = $devices;
  array_walk($devicesClass, function (&$value, $key) {
    $value = "show-$value";
    $value = str_replace("_", "-", $value);
  });
  $devicesClass = implode($devicesClass, " ");

}else if($mediaType == "slider"){

  $indicatorColor         = get_field('indicators_color');
  $firstItem              = true;
  $sliderID               = uniqid();
  $images = array();
  if(get_field('images')):
    while(the_repeater_field('images')):
      array_push($images, get_sub_field('image'));
    endwhile;
  endif;

} else if($mediaType == "wistia"){
  $wisitaCode =  get_field('wistia_code');
}

?>
<div id="<?php echo $componentId; ?>" class="<?php echo $componentName; ?>">
<?php if($mediaType ==  "devices"){ ?>
    <div class="container device-subcomp <?php echo $devicesClass; ?>">
      <div class="row">
          <?php if (in_array("desktop", $devices)) : ?>
          <figure class="device desktop">
            <img class="img-responsive" src="<?php bloginfo('template_url'); ?>/dist/img/img-macbook.png">
            <div class="video-wrapper">
              <?php if (get_field("desktop_video")) : ?>
              <video muted loop>
                <source src="<?php the_field("desktop_video"); ?>" type="video/mp4">
              </video>
              <?php endif; ?>
            </div>
          </figure>
          <?php endif; ?>

          <?php if (in_array("tablet", $devices)) : ?>
          <figure class="device tablet">
            <img class="img-responsive" src="<?php bloginfo('template_url'); ?>/dist/img/img-ipad.png">
            <div class="video-wrapper">
              <?php if (get_field("tablet_video")) : ?>
              <video muted loop>
                <source src="<?php the_field("tablet_video"); ?>" type="video/mp4">
              </video>
              <?php endif; ?>
            </div>
          </figure>
          <?php endif; ?>

          <?php if (in_array("phone", $devices)) : ?>
          <figure class="device phone">
            <img class="img-responsive img-portrait" src="<?php bloginfo('template_url'); ?>/dist/img/img-iphone.png">
            <img class="img-responsive img-landscape" src="<?php bloginfo('template_url'); ?>/dist/img/img-iphone-landscape.png">
            <div class="video-wrapper">
              <?php if (get_field("phone_video")) : ?>
              <video muted loop>
                <source src="<?php the_field("phone_video"); ?>" type="video/mp4">
              </video>
              <?php endif; ?>
            </div>
          </figure>
          <?php endif; ?>

          <?php if (in_array("phone_landscape", $devices)) : ?>
          <figure class="device phone landscape">
            <img class="img-responsive img-portrait" src="<?php bloginfo('template_url'); ?>/dist/img/img-iphone.png">
            <img class="img-responsive img-landscape" src="<?php bloginfo('template_url'); ?>/dist/img/img-iphone-landscape.png">
            <div class="video-wrapper">
              <?php if (get_field("phone_video")) : ?>
              <video muted loop>
                <source src="<?php the_field("phone_landscape_video"); ?>" type="video/mp4">
              </video>
              <?php endif; ?>
            </div>
          </figure>
          <?php endif; ?>

      </div>
    </div>
<?php } ?>

<?php if($mediaType ==  "slider"){ ?>
    <div class="container slider-subcomp">
      <div class="row">
          <div id="carousel-<?php echo $sliderID; ?>" class="carousel slide" data-ride="carousel">
            
            <ol class="carousel-indicators">
              <?php foreach($images as $index=>$image) :?>
                <li style="background-color:<?php echo $indicatorColor; ?>" data-target="#carousel-<?php echo $sliderID; ?>" data-slide-to="<?php echo $index; ?>" class="<?php if($index==0) {echo "active";} ?>"></li>
              <?php endforeach;?>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
              <?php foreach($images as $image) { ?>
              <div class="item <?php if($firstItem){ $firstItem = false; echo 'active'; } ?>" style="background-image: url('<?php echo $image; ?>')"></div>
              <?php } ?>
            </div>

            <!-- Controls -->
            <!--<a class="left carousel-control" href="#carousel-<?php echo $sliderID; ?>" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            </a>
            <a class="right carousel-control" href="#carousel-<?php echo $sliderID; ?>" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </a>-->

          </div>
          <script>
            $(document).ready(function () {
              $("#carousel-<?php echo $sliderID; ?>").swiperight(function() {
                $(this).carousel('prev');
              });
              $("#carousel-<?php echo $sliderID; ?>").swipeleft(function() {
                $(this).carousel('next');
              });
            });
          </script>
      </div>
    </div>
<?php } ?>

<?php if($mediaType ==  "wistia"){ ?>
    <div class="container-fluid video-subcomp">
      <div class="row">
          <div id="wistia_<?php echo $wisitaCode ?>" class="wistia_embed wistia-background">&nbsp;</div>
      </div>
    </div>
<?php } ?>
</div>
<script>
  $(document).ready(function () {
    new app.components.adMedia("#<?php echo $componentId; ?>", "<?php echo $mediaType; ?>", "<?php echo $wisitaCode; ?>");
  });
</script>
