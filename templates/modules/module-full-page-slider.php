<?php
/* This module is responsible for rendering the 'Full Page Slider' component.
 *
 * The values needed comes from Custom Fields defined within the post.
 *
 */

global $postID;
global $insideFullPageModule;

$modulesRepeater = get_field('full_page_slider', $postID);
$carouselId      = "carousel-".uniqid();
$showScrollDown  = get_field('show_scroll_down', $postID);
$showScrollDown  = $showScrollDown ? "display" : "hidden";
$indicatorColor  = get_field('indicators_color', $postID);
?>


<?php if($modulesRepeater): ?>
  <div class="row"> 
    <div id="<?php echo $carouselId; ?>" class="carousel slide" data-ride="" data-interval="6000" data-pause="" >      
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
          <?php foreach($modulesRepeater as $index=>$module) :?>
            <div class="item col-xs-12 <?php if($index==0) {echo "active";} ?>">
              <?php
                $postID = $module["module_id"];
                $insideFullPageModule = true;
                get_template_part('single', 'module');
              ?>
            </div>
          <?php endforeach; ?>
          <?php $insideFullPageModule = false; ?>
      </div>

      <!-- Indicators -->
      <ol class="carousel-indicators">
        <?php foreach($modulesRepeater as $index=>$module) :?>
          <li style="background-color:<?php echo $indicatorColor; ?>" data-target="#<?php echo $carouselId; ?>" data-slide-to="<?php echo $index; ?>" class="<?php if($index==0) {echo "active";} ?>"></li>
        <?php endforeach;?>
      </ol>
      
      <div class="scrollDownContainer <?php echo $showScrollDown; ?>">
        <div class="scrollDown">
          <span class="text">Scroll Down</span>
          <span class="down-arrow "></span>
        </div>
      </div>
      <div class="loader-container show">
        <?php render_component("loader", array("size" => "big")); ?>
      </div>      
    </div>
  </div>
<?php endif; ?>

<script>  
    $(document).ready(function() {
        new app.modules.FullPageSlider("#<?php echo $carouselId; ?>", "<?php echo $showScrollDown; ?>");  
    });
</script>