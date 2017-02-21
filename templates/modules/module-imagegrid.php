<?php
/* This module is responsible for rendering the 'Image Grid' module which includes:
 * Image Grid Centered and image-grid-left.
 *
 * The values needed comes from Custom Fields defined within the post.
 *
 * The $postID variable comes from the Template Custom which renders the Module content.
 */

global $postID;
$DEFAULT_OVERLAY_COLOR = "#000000";
$DEFAULT_TEXT_COLOR = "#FFFFFF";
$DEFAULT_BUTTON_PRIMARY_COLOR = "#FFFFFF";
$DEFAULT_BUTTON_SECONDARY_COLOR = "#000000";	

$moduleType          = get_field('module_type', $postID);

$mainTitle           = get_field('main_title', $postID);
$mainSubtitle        = get_field('main_subtitle', $postID);
$mainDescription     = get_field('main_description', $postID);
$backgroundType      = get_field('is_color_or_background_1', $postID);
$imageGrid           = get_field('image_grid');
$mainButtonText      = get_field('main_button_text', $postID);
$mainButtonURL       = get_field('main_button_url', $postID);
$isButtonOk = false;
$mainTextColorClass = get_field("main_text_font_color_set", $postID);
$mainTextColorClass = ($mainTextColorClass == "")? "dark-text" : $mainTextColorClass;

if($mainButtonText != "" && $mainButtonURL != ""){
  $isButtonOk = true;
}

$inlineStyles        = "";

if($backgroundType == 'background') {
	$imageSrc = \Roots\Sage\Utils\get_image_by_device(get_field('bg_image_1', $postID));
	$inlineStyles  = $inlineStyles."background-image: url(".$imageSrc.");";
} else {
	$inlineStyles  = $inlineStyles."background-color: ".get_field('background_color_1', $postID).";";
}


$grids = array();

if(get_field('image_grid', $postID)):
	$count =0;
	while(the_repeater_field('image_grid', $postID)):
		$currentGrid = array(
			"id"          	 => $count,
			"image"          => get_sub_field('grid_image'),
			"title"          => get_sub_field('grid_title'),
			"titleImage"     => get_sub_field('grid_tittle_image'),
			"useImageTittle" => get_sub_field('grid_use_image_tittle'),
			"description"    => get_sub_field('grid_description'),
			"buttonText"     => get_sub_field('grid_button_text'),
			"buttonUrl"      => get_sub_field('grid_button_url'),
			"overlayColor"   => get_sub_field("overlay_color") ? get_sub_field("overlay_color") : $DEFAULT_OVERLAY_COLOR,
			"textColor"      => get_sub_field("text_color") ? get_sub_field("text_color") : $DEFAULT_TEXT_COLOR,
			"buttonPrimaryColor"   => get_sub_field("button_primary_color") ? get_sub_field("button_primary_color") : $DEFAULT_BUTTON_PRIMARY_COLOR,
			"buttonSecondaryColor" => get_sub_field("button_secondary_color") ? get_sub_field("button_secondary_color") : $DEFAULT_BUTTON_SECONDARY_COLOR
		);
		array_push($grids, $currentGrid);
		$count++;
 	endwhile;
endif;

$rowMultiple     =  3;
$numberElements  =  count($grids);
$evenElements    =  $numberElements % 2 == 0 ? true : false;
$twoRowMultiple  =  $numberElements % ($rowMultiple * 2) == 0 ? true : false;
$orphanElements  =  $numberElements % $rowMultiple;
$completeOrphan1 =  $orphanElements == 1 || $orphanElements == 2 || ($orphanElements == 0 && !$twoRowMultiple) ? true : false;
$completeOrphan2 =  $orphanElements == 1 ? true : false;
$imageGridId 	 =  "imageGrid-".uniqid(); 
?>

<div id="<?php echo $imageGridId; ?>" class="image-grid row">
	<div class="hero-grid <?php echo $mainTextColorClass; ?>" style="<?php echo $inlineStyles; ?>">
		<section class="top-section <?php if($moduleType == 'image-grid-left') echo 'left-align'; ?>">
			<?php if($mainSubtitle != '') { ?> <h3 class="main-subtitle"><?php echo $mainSubtitle; ?></h3> <?php } ?>
			<?php if($mainTitle != '') { ?> <h1 class="main-title"><?php echo $mainTitle; ?></h1> <?php } ?>
			<?php if($mainDescription != '') { ?> <div class="copy"><?php echo $mainDescription; ?></div> <?php } ?>
			<?php if($isButtonOk) { ?> <a href="<?php echo $mainButtonURL; ?>" class="btn btn-default"><?php echo $mainButtonText; ?></a> <?php } ?>
		</section>
	</div>
	<div class="grid-container">
		<?php foreach($grids as $grid) { ?>
		<style>
			#grid-tile-<?php echo $grid["id"]; ?> .grid-information .btn-custom {
				background: -webkit-linear-gradient(20deg, <?php echo $grid["buttonPrimaryColor"]; ?> 50%, transparent 50%);
		        background: -webkit-linear-gradient(70deg, <?php echo $grid["buttonPrimaryColor"]; ?> 50%);
		        background: linear-gradient(20deg, <?php echo $grid["buttonPrimaryColor"]; ?> 50%, transparent 50%);
		        background-position: right bottom;
		        background-size: 400% 200%;
		        color: <?php echo $grid["buttonPrimaryColor"]; ?>;
		        border-color: <?php echo $grid["buttonPrimaryColor"]; ?>;
			}
			#grid-tile-<?php echo $grid["id"]; ?> .grid-information .btn-default:hover {
				color: <?php echo $grid["buttonSecondaryColor"]; ?>;
	        	background-position: left bottom;
	      	}

	      	#grid-tile-<?php echo $grid["id"]; ?> .grid-information {
				color: <?php echo $grid["textColor"]; ?>;
				border-color:<?php echo $grid["buttonPrimaryColor"]; ?>;
			}	


  			#overlay-<?php echo $grid['id']?> {
				background: <?php echo $grid["overlayColor"]; ?> 50%;
  			}

		</style>
		<div id="grid-tile-<?php echo $grid['id']?>" class="grid square col-xs-12 col-sm-6 col-md-4 " style="background-image: url('<?php echo $grid["image"]; ?>')">
			<div id="overlay-<?php echo $grid['id']?>" class="overlay"></div>
			<div class="grid-wrapper">
				<section class="grid-information">
					
					<?php if($grid["useImageTittle"]) { ?>
						<div class="image-tittle" style="background-image: url('<?php echo $grid["titleImage"]; ?>')"></div>
					<?php }else{ ?>
						<h1 class="main-title"><?php echo $grid["title"]; ?></h1>
					<?php }?>
					<div class="copy"><?php echo $grid["description"]; ?></div>
					<a href="<?php echo $grid["buttonUrl"]; ?>" class="btn btn-default btn-custom"><?php echo $grid["buttonText"]; ?></a>
				</section>
			</div>
		</div>
		<?php } ?>
		<?php if($completeOrphan1) { ?>
			<div class="grid square extra-grid col-xs-12 col-sm-6 col-md-4 hidden-xs <?php if($evenElements) echo 'hidden-sm'; ?> <?php if($orphanElements == 0) echo 'hidden-md hidden-lg'; ?>" style="background-image: url('http://usmentor.qbcontent.com/wp-content/uploads/2014/07/instagram-logo-300x300.png')">
				<section class="grid-information">
					<h1 class="main-title">Instagram</h1>
					<p class="copy">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed!</p>
					<a href="https://www.google.com" class="btn btn-default">Grid Button</a>
				</section>
			</div>
		<?php } ?>
		<?php if($completeOrphan2) { ?>
			<div class="grid square extra-grid col-xs-12 col-sm-6 col-md-4 hidden-xs hidden-sm" style="background-image: url('https://bchospitalityfoundation.com/wp-content/uploads/2011/12/FB-Logo-White-512-Blue-BG-300x300.png')">
				<section class="grid-information">
					<h1 class="main-title">Facebook</h1>
					<p class="copy">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed!</p>
					<a href="https://www.google.com" class="btn btn-default">Grid Button</a>
				</section>
			</div>
		<?php } ?>
	</div>
</div>
