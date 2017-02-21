<?php
/* This module is responsible for rendering the 'Triptych Transparent Background' and
 * the 'Triptych White Background' components.
 *
 * The values needed comes from Custom Fields defined within the post.
 *
 * The $postID variable comes from the Template Custom which renders the Module content.
 */

global $postID;

$moduleType             = get_field('module_type', $postID);
$title_1_triptych       = get_field('title_1_triptych', $postID);
$description_1_triptych = get_field('description_1_triptych', $postID);
$button_text_1_triptych = get_field('button_text_1_triptych', $postID);
$button_url_1_triptych  = get_field('button_url_1_triptych', $postID);

$title_2_triptych       = get_field('title_2_triptych', $postID);
$description_2_triptych = get_field('description_2_triptych', $postID);
$button_text_2_triptych = get_field('button_text_2_triptych', $postID);
$button_url_2_triptych  = get_field('button_url_2_triptych', $postID);

$title_3_triptych       = get_field('title_3_triptych', $postID);
$description_3_triptych = get_field('description_3_triptych', $postID);
$button_text_3_triptych = get_field('button_text_3_triptych', $postID);
$button_url_3_triptych  = get_field('button_url_3_triptych', $postID);

$backgroundType1  = get_field('is_color_or_background_1', $postID);
$backgroundType2  = get_field('is_color_or_background_2', $postID);
$backgroundType3  = get_field('is_color_or_background_3', $postID);

if($backgroundType1=='background') {
  $imageSrc = \Roots\Sage\Utils\get_image_by_device(get_field('bg_image_1', $postID));
	$backgroundType1 = 'style="background-image: url('.$imageSrc.')";';
} else {
	$backgroundType1 = 'style="background-color: '.get_field('background_color_1', $postID).'";';
}

if($backgroundType2=='background') {
  $imageSrc2 = \Roots\Sage\Utils\get_image_by_device(get_field('bg_image_2', $postID));
	$backgroundType2 = 'style="background-image: url('.$imageSrc2.')";';
} else {
	$backgroundType2 = 'style="background-color: '.get_field('background_color_2', $postID).'";';
}

if($backgroundType3=='background') {
  $imageSrc3 = \Roots\Sage\Utils\get_image_by_device(get_field('bg_image_3', $postID));
	$backgroundType3 = 'style="background-image: url('.$imageSrc3.')";';
} else {
	$backgroundType3 = 'style="background-color: '.get_field('background_color_3', $postID).'";';
}

$imageIcon1  = get_field('image_icon_1', $postID);
$imageIcon2  = get_field('image_icon_2', $postID);
$imageIcon3  = get_field('image_icon_3', $postID);

$isFullHeight     = get_field('full_window_height', $postID);
$fullHeightClass  = ($isFullHeight == 1) ? "full-height" : "";

$triptychId = "triptych-".uniqid();
?>

<div id="<?php echo $triptychId; ?>" class="triptych <?php if($moduleType == 'triptych-white') echo 'triptych-white-bg dark-text'; ?> row">
	<div class="bg-cols <?php echo $fullHeightClass; ?> col-sm-12 col-md-4" >
    <div class="row">
      <span class="background" <?php echo $backgroundType1; ?>> </span>
  		<section>
        <?php if($imageIcon1) : ?>
          <img src="<?php echo $imageIcon1; ?>">
        <?php endif; ?>
  			<h3 class="small-title"><?php echo $title_1_triptych; ?></h3>
  			<div class="copy"><?php echo $description_1_triptych; ?></div>
  			<?php if($button_url_1_triptych != '') { ?><a class="btn btn-default" href="<?php echo $button_url_1_triptych; ?>"><?php echo $button_text_1_triptych; ?></a><?php } ?>
  		</section>
    </div>
	</div>
	<div class="bg-cols <?php echo $fullHeightClass; ?> col-sm-12 col-md-4">
		<div class="row">
      <span class="background" <?php echo $backgroundType2; ?>></span>
      <section>
        <?php if($imageIcon2) : ?>
          <img src="<?php echo $imageIcon2; ?>">
        <?php endif; ?>
  			<h3 class="small-title"><?php echo $title_2_triptych; ?></h3>
  			<div class="copy"><?php echo $description_2_triptych; ?></div>
  			<?php if($button_url_2_triptych != '') { ?><a class="btn btn-default" href="<?php echo $button_url_2_triptych; ?>"><?php echo $button_text_2_triptych; ?></a><?php } ?>
  		</section>
    </div>
	</div>
	<div class="bg-cols <?php echo $fullHeightClass; ?> col-sm-12 col-md-4">
		<div class="row">
      <span class="background" <?php echo $backgroundType3; ?>></span>
      <section>
        <?php if($imageIcon3) : ?>
          <img src="<?php echo $imageIcon3; ?>">
        <?php endif; ?>
  			<h3 class="small-title"><?php echo $title_3_triptych; ?></h3>
  			<div class="copy"><?php echo $description_3_triptych; ?></div>
  			<?php if($button_url_3_triptych != '') { ?><a class="btn btn-default" href="<?php echo $button_url_3_triptych; ?>"><?php echo $button_text_3_triptych; ?></a><?php } ?>
  		</section>
    </div>
	</div>
</div>

<script>  
  $(document).ready(function() {
    new app.modules.Triptych("#<?php echo $triptychId; ?>");
  });
</script>
