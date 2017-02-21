<?php
/* This module is responsible for rendering the 'Grid Container' module which
 * renders from 3 to 5 grids in line.
 *
 * The values needed comes from Custom Fields defined within the post.
 *
 * The $postID variable comes from the Template Custom which renders the Module content.
 */

global $postID;


$gridContainer 	     =  "gridContainer-".uniqid(); 
$moduleType          = get_field('module_type', $postID);
$backgroundType      = get_field('is_color_or_background_1', $postID);

$whenShowInfo		 = get_field('show_info_on_hover', $postID);

$mainTextColorClass = get_field("main_text_font_color_set", $postID);
$mainTextColorClass = ($mainTextColorClass == "")? "dark-text" : $mainTextColorClass;
$inlineStyles        = "";
$colsLargeScreen     = "";

if($backgroundType == 'background') {
	$imageSrc = \Roots\Sage\Utils\get_image_by_device(get_field('bg_image_1', $postID));
	$inlineStyles  = $inlineStyles."background-image: url(".$imageSrc.");";
} else {
	$inlineStyles  = $inlineStyles."background-color: ".get_field('background_color_1', $postID).";";
}


$grids = array();
$numberGrids = 0;

if(get_field('grids', $postID)):
	while(the_repeater_field('grids', $postID)):
		$numberGrids++;
		$currentGrid = array(
			"image"       => get_sub_field('grid_image'),
			"title"       => get_sub_field('grid_title'),
			"description" => get_sub_field('grid_description'),
			"buttonText"  => get_sub_field('grid_button_text'),
			"buttonUrl"   => get_sub_field('grid_button_url')
		);
		array_push($grids, $currentGrid);

 	endwhile;
endif;
$even = $numberGrids % 2 == 0 ? true : false;

if($numberGrids == 3){
	$colsLargeScreen = "col-md-4";
} else if($numberGrids == 4){
	$colsLargeScreen = "col-md-3";
} else {
	$colsLargeScreen = "col-custom-5";
}

?>

<div class="grids row" id="<?php echo $gridContainer; ?>">
	<div class="grid-container <?php echo $whenShowInfo; ?> <?php echo $mainTextColorClass; ?>" style="<?php echo $inlineStyles; ?>"  data-refresh="true">
		<div class="activate-flex row-centered">
			<?php foreach($grids as $grid) { ?>
			<div class="grid col-centered col-xs-12 col-sm-6 <?php echo $colsLargeScreen; ?>">
				<span class="divider"></span>
				<div class="grid-wrapper">
					<section class="grid-information">
						<?php if($grid["image"] != '') { ?> <div class="image-container"><img src="<?php echo $grid["image"]; ?>" class="img-responsive" alt=""></div> <?php } ?>
						<div class="content-wrapper">
							<?php if($grid["title"] != '') { ?> <h1 class="main-title"><?php echo $grid["title"]; ?></h1> <?php } ?>
							<?php if($grid["description"] != '') { ?> <div class="copy"><?php echo $grid["description"] ?></div> <?php } ?>
							<?php if($grid["buttonText"] != "" && $grid["buttonUrl"] != "") { ?> <a href="<?php echo $grid["buttonUrl"]; ?>" class="btn btn-default"><?php echo $grid["buttonText"]; ?></a> <?php } ?>
						</div>
					</section>
				</div>
			</div>
			<?php } ?>
			<?php if(!$even) { ?>
				<div class="grid extra-grid col-centered col-sm-6 visible-sm-inline-block" style="background-image: url('http://usmentor.qbcontent.com/wp-content/uploads/2014/07/instagram-logo-300x300.png')">
					<span class="divider"></span>
					<section class="grid-information">
						<h1 class="main-title">Instagram</h1>
						<p class="copy">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed!</p>
						<a href="https://www.google.com" class="btn btn-default">Grid Button</a>
					</section>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		app.lib.util.refreshGifs("#<?php echo $gridContainer; ?> .grid-wrapper", "#<?php echo $gridContainer; ?> .grid-container");
		new app.modules.GridContainer("#<?php echo $gridContainer; ?>", "<?php echo $whenShowInfo; ?>");
	});
</script>


