<?php
/* This module is responsible for rendering the 'Circle' module which includes:
 * Circle Module with 2, 3 and 4 sections of content.
 *
 * The values needed comes from Custom Fields defined within the post.
 *
 * The $postID variable comes from the Template Custom which renders the Module content.
 */

global $postID;

$circlesId = "circles-".uniqid();
$moduleType          = get_field('module_type', $postID);

$mainTitle           = get_field('main_title', $postID);
$mainSubtitle        = get_field('main_subtitle', $postID);
$mainDescription     = get_field('main_description', $postID);
$circles = array();

$mainTextColorClass = get_field("main_text_font_color_set", $postID);
$mainTextColorClass = ($mainTextColorClass == "")? "dark-text" : $mainTextColorClass;
$secondaryTextColorClass = get_field("secondary_text_font_color_set", $postID);
$secondaryTextColorClass = ($secondaryTextColorClass == "")? "dark-text" : $secondaryTextColorClass;
$numberOfItemsPerRow = get_field("number_of_items_per_row", $postID);

$showTopSection = false;
if($mainTitle || $mainSubtitle || $mainDescription){
  $showTopSection = true;
}

$itemsAdded   = 0;
$currentSet   = array();

if(get_field('circles_content', $postID)):
	while(the_repeater_field('circles_content', $postID)):
		$currentCircle = array(
			"image"       => get_sub_field('circle_image'),
			"title"       => get_sub_field('circle_title'),
			"description" => get_sub_field('circle_description'),
			"buttonText"  => get_sub_field('circle_button_text'),
			"buttonUrl"   => get_sub_field('circle_button_url')
		);
		array_push($currentSet, $currentCircle);
		$itemsAdded++; 
		if($itemsAdded == $numberOfItemsPerRow){
			array_push($circles, $currentSet);
			$currentSet = array();
			$itemsAdded = 0;
		}
 	endwhile;
 	if($itemsAdded > 0){
 		array_push($circles, $currentSet);
 	}
endif;

$backgroundType      = get_field('is_color_or_background_1', $postID);

if($backgroundType == 'background') {
	$imageSrc = \Roots\Sage\Utils\get_image_by_device(get_field('bg_image_1', $postID));
	$backgroundType = 'background-image: url('.$imageSrc.');';
} else {
	$backgroundType = 'background-color: '.get_field('background_color_1', $postID).';';
}

?>

<div id="<?php echo $circlesId; ?>" class="circles row" style="<?php echo $backgroundType; ?>">
  <?php if($showTopSection == true): ?>
  	<section class="top-section <?php echo $mainTextColorClass ?>">
  		<?php if($mainSubtitle != '') { ?> <h3 class="main-subtitle"><?php echo $mainSubtitle; ?></h3> <?php } ?>
  		<h1 class="main-title"><?php echo $mainTitle; ?></h1>
  		<div class="copy"><?php echo $mainDescription; ?></div>
  	</section>
  <?php endif; ?>
	<div class="col-xs-12 circles-container" data-refresh="true">
		<div class="row row-centered <?php echo $secondaryTextColorClass; ?>">
			<?php foreach($circles as $circlesContainer) { ?>
				<?php foreach ($circlesContainer as $circle) { ?>
					<div class="col-xs-12 col-sm-6 col-md-3 col-centered">
						<section class="circle-section" >
							<div class="circle">
								<img src="<?php echo $circle["image"]; ?>" class="img-responsive" alt="">
							</div>
							<h3 class="small-title"><?php echo $circle["title"]; ?></h3>
							<div class="copy"><?php echo $circle["description"]; ?></div>
							<?php if($circle["buttonUrl"] != '') { ?><a href="<?php echo $circle["buttonUrl"]; ?>" class="btn btn-default"><?php echo $circle["buttonText"]; ?></a> <?php } ?>
						</section>
					</div>
				<?php } ?>
				<br class="hidden-xs hidden-sm">
			<?php } ?>
		</div>	
	</div>
</div>

<script>
	$(document).ready(function() {
		new app.modules.Circle("#<?php echo $circlesId; ?>");
	});
</script>


