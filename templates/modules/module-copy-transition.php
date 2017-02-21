<?php
/* This module is responsible for rendering the 'Hero' components.
 *
 * The values needed comes from Custom Fields defined within the post.
 *
 * The $postID variable comes from the Template Custom which renders the Module content.
 */

global $postID;

$isDesktop = Roots\Sage\Utils\is_desktop();
$contentAlign     = get_field('content_align', $postID);
$moduleType       = get_field('module_type', $postID);
$mainTitle        = get_field('main_title', $postID);
$mainSubtitle     = get_field('main_subtitle', $postID);
$mainDescription  = get_field('main_description', $postID);
$number           = get_field('number', $postID);
$unit             = get_field('unit', $postID);
$numberIcon       = get_field('number_icon', $postID);
$numberNext       = get_field('number_next', $postID);
$unitNext         = get_field('unit_next', $postID);
$numberIconNext   = get_field('number_icon_next', $postID);
$numberCopy       = get_field('number_copy', $postID);

$backgroundType       = get_field('is_color_image_or_video', $postID);
$background = '';
$backgroundMobilePortrait = '';
$backgroundMobileLandscape = '';

$buttonText       = get_field('main_button_text', $postID);
$buttonURL        = get_field('main_button_url', $postID);
$border           = get_field('copy_separator', $postID);

$imageStyle             = '';
$videoId                = '';
$copyBackground         = '';
$sectionInlineStyles    = '';
$borderClass            = '';
$isButtonOk             = false;
$heightStyle            = get_field('height_style', $postID); // options: standardHeight, autoHeight, full-height
$copyClasses            = '';
$imageClasses           = '';
$carousel               = false;
$carouselItems          = array();
$firstItem              = true;
$carouselID             = uniqid();
$carouselSize           = 0;

if($contentAlign == 'center'){
  $carousel = get_field('carousel', $postID);
  if($carousel){
    if(get_field('carrousel_frames', $postID)):
      while(the_repeater_field('carrousel_frames', $postID)):
        $currentFrame = array(
          "image"       => get_sub_field('carousel_image')
        );
        array_push($carouselItems, $currentFrame);
      endwhile;
    endif;
  }
}

if($border){
  if( in_array( "top", $border  ) ){
      $borderClass = 'border-top ';
  }
  if( in_array( "bottom", $border  ) ){
      $borderClass = $borderClass.'border-bottom ';
  }
}

if($buttonText != "" && $buttonURL != ""){
  $isButtonOk = true;
}

$mainTextColorClass = get_field("main_text_font_color_set", $postID);
$mainTextColorClass = ($mainTextColorClass == "")? "dark-text" : $mainTextColorClass;

if($backgroundType =='video') { // case: $backgroundType == video
  $videoId = get_field('bg_video_1', $postID);
}
else if($backgroundType =='background') { // case: $backgroundType == background (Image)
  
  // image style options
  // background-image : Background Image
  // content-image : Content Image
  
  $imageStyle = get_field('background_or_content_image', $postID);
  $imageSrc = \Roots\Sage\Utils\get_image_by_device(get_field('bg_image_1', $postID));
  //if($isDesktop){
    $background = 'style="background-image: url('.$imageSrc.');"';
  //}

}
else if($backgroundType =='color') { // case: $background == color
	$background = 'style="background-color: '.get_field('background_color_1', $postID).';"';
}

if($backgroundType != "color"){
  $backgroundMobilePortrait = \Roots\Sage\Utils\get_image_by_device(get_field("bg_image_mobile_portrait", $postID));
  $backgroundMobileLandscape = \Roots\Sage\Utils\get_image_by_device(get_field("bg_image_mobile_landscape", $postID));

  if($backgroundType != "video"){
    if($backgroundMobilePortrait == ""){
      $backgroundMobilePortrait = $imageSrc;
    };

    if($backgroundMobileLandscape == ""){
      $backgroundMobileLandscape = $imageSrc;
    }
  }
}

if($contentAlign == 'right') {
  $copyClasses = 'col-xs-12 col-md-6';
  $imageClasses = 'col-xs-12 col-md-6';
  $splitClass = 'left';
} else if($contentAlign == 'left'){ // if $contentAlign == 'center'
  $copyClasses = 'col-xs-12 col-md-6 col-md-pull-6';
  $imageClasses = 'col-xs-12 col-md-6 col-md-push-6';
} else{
  $copyClasses = 'col-sm-12 centered-copy image-wrapper copy-inline';
  $imageClasses = 'hidden';
  $copyBackground = $background;
}

$isCopyFirst = true;
if ($contentAlign == 'right') {
  $isCopyFirst = false;
} 

if($heightStyle != "full-height"){
  $copyClasses = $copyClasses." ".$heightStyle;
}
$imageClasses = $imageClasses." ".$heightStyle." ".$imageStyle;
$sectionId = uniqid();

?>
<div id="ct<?php echo $sectionId; ?>" class="copy-text row transition <?php echo $borderClass; echo ($heightStyle != "full-height")? $heightStyle : ""; ?>">

  <div class="split <?php echo $splitClass; ?>" <?php echo $background; ?>></div>  
	<div class="<?php echo $copyClasses; ?> copy-wrapper jqFlexMinHeight <?php echo ($heightStyle == "full-height")? $heightStyle : ""; ?>" data-color="<?php echo get_field('background_color_1', $postID); ?>">
    <?php 
      if($contentAlign == 'center' && $backgroundType =='video') {
        render_component("wistia-video", array(
          "id"=> $videoId, 
          "extraClasses"=>$mainTextColorClass,
          "playButtonContainerSelector"=>"#".$sectionId)
        );
      }
    ?>
    <?php if($contentAlign == 'center' && $backgroundType != 'color' && $isDesktop == false){?>
      <div class="backgroun-mobile portrait" style="background-image: url('<?php echo $backgroundMobilePortrait; ?>')"></div>
      <div class="backgroun-mobile landscape" style="background-image: url('<?php echo $backgroundMobileLandscape; ?>')"></div>
    <?php } ?>
    <div class="row jqFlexMinHeight-body">
  		<section id="<?php echo $sectionId; ?>"class="<?php echo $mainTextColorClass; ?>">
  			<?php if($mainSubtitle != '') { ?> <h3 class="main-subtitle"><?php echo $mainSubtitle; ?></h3> <?php } ?>
  			<h1 class="main-title"><?php echo $mainTitle; ?></h1>
  			<?php if($mainDescription != ""){ ?>
          <div class="copy"><?php echo $mainDescription; ?></div>
        <?php } ?>
        <?php if($isButtonOk) : ?>
          <a href="<?php echo $buttonURL;?>" class="btn btn-default" ><?php echo $buttonText;?></a>
        <?php endif; ?>
  		</section>
      <?php if($carousel){ ?>
      <div class="text-center">
        <div class="slider-wrapper">
          <div class="slider slider-<?php echo $carouselID; ?>" data-moving="false">
            <ul>
            <?php foreach($carouselItems as $item) { ?>
              <li class="item" style="width: 170px; height: 170px;">
                <div class="item-container">
                  <div class="img-container">
                    <img src="<?php echo $item['image'] ?>" class="img-responsive">
                  </div>
                </div>
              </li>
            <?php } ?>
            </ul>
          </div>
          <a class="control left-control slider-prev-<?php echo $carouselID; ?>"></a>
          <a class="control right-control slider-next-<?php echo $carouselID; ?>"></a>
        </div>
      </div>      
      <?php } ?>
    </div>
	</div>
  <div class="<?php echo $imageClasses; ?> image-wrapper">
    <?php if($number && !$numberNext || !$number && $numberNext){
      $collaps = 'collaps';
    } else {
      $collaps = '';
    } ?>
    <div class="num-hold <?php echo $collaps; ?>">
      <?php if($numberIcon || $numberIconNext){ ?>
        <div class="icons">
          <?php if($numberIcon){ ?>
            <div class="icon"><img src="<?php echo $numberIcon; ?>" alt="" border="0"/></div>
          <?php } ?>
          <div class="divider">&nbsp;</div>
          <?php if($numberIconNext){ ?>
            <div class="icon"><img src="<?php echo $numberIconNext; ?>" alt="" border="0"/></div>
          <?php } ?>
        </div>
      <?php } ?>
      
      <?php if($number){ ?>
        <div class="digit">
          <span class="number" data-number="<?php echo $number; ?>"></span><span class="unit"><?php echo $unit; ?></span>
        </div>
      <?php } ?>              
      <div class="divider">&nbsp;</div>      
      <?php if($numberNext){ ?>
        <div class="digit">
          <span class="number next" data-number="<?php echo $numberNext; ?>"></span><span class="unit next"><?php echo $unitNext; ?></span>
        </div>
      <?php } ?>        

      <?php if($numberCopy){ ?>
        <div class="number-copy">
          <?php echo $numberCopy; ?>
        </div>
      <?php } ?>
    </div>
    <img src="<?php bloginfo('template_directory'); ?>/patch/images/700x.png" alt="" border="0"/>
  </div>
  
</div>