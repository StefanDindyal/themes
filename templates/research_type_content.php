<?php 
  /*
   *  Template to render the content section of the research posts
   */

  $infoGraphic      = get_field('infographic_visual_file');
  $infoGraphicIntro = get_field('infographic_intro');
  $bullets          = get_field('bullets_section');
  $cover            = get_field('cover_photo');
?>

<div class="row research-content">
  <div class="col-xs-12 visible-xs overview">
    <?php the_content(); ?>
  </div>
  <div class="col-xs-12 col-sm-4 cover-photo">
    <img src="<?php echo $cover; ?>" class="img-responsive">
  </div>
  <div class="col-xs-12 col-sm-8 overview">
    <div class="hidden-xs">
      <?php the_content(); ?>
    </div>
    <div class="bullets">
      <?php echo $bullets; ?>
    </div>
    <?php if($hubspotCode !== ''){ ?>
    <div class="download-report">
      <p class="text-center"><a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#reportForm">Download Full Report</a></p>
    </div>
    <?php } ?>
  </div>
  <?php if($infoGraphic != '') { ?>
  <div class="col-xs-12 infographic">
    <?php if($infoGraphicIntro != '') { ?>
    <div class="overview">
      <?php echo $infoGraphicIntro ?>
    </div>
    <?php } ?>
    <img class="img-responsive" src="<?php echo $infoGraphic; ?>" alt="<?php the_title(); ?>">
    <a href="#" id="infographicVisualLink" class="btn-form-submit text-center">Embed This Visual</a>
    <textarea id="infographicVisualCode"><p><strong>Please include attribution to http://www.undertone.com with this graphic.</strong><br /><br /><a href="<?php the_permalink(); ?>"><img src="<?php echo $infographicVisual; ?>" alt="<?php the_title(); ?>"/></a></p></textarea>
  </div>
  <?php } ?>
</div>



