<?php
/* This module is responsible for rendering the 'Diptych' and
 * the 'Diptych With Main Title' components.
 *
 * The values needed comes from Custom Fields defined within the post.
 *
 * The $postID variable comes from the Template Custom which renders the Module content.
 */

global $postID;

$moduleType       = get_field('module_type', $postID);

$isDesktop        = Roots\Sage\Utils\is_desktop();

$mainTitle        = get_field('main_title', $postID);
$mainSubtitle     = get_field('main_subtitle', $postID);
$mainDescription  = get_field('main_description', $postID);

$leftTitle        = get_field('left_title_diptych', $postID);
$leftDescription  = get_field('left_description_diptych', $postID);
$leftButtonText   = get_field('left_button_text_diptych', $postID);
$leftButtonURL    = get_field('left_button_url_diptych', $postID);

$rightTitle       = get_field('right_title_diptych', $postID);
$rightDescription = get_field('right_description_diptych', $postID);
$rightButtonText  = get_field('right_button_text_diptych', $postID);
$rightButtonURL   = get_field('right_button_url_diptych', $postID);

$backgroundType1  = get_field('is_color_or_background_1', $postID);
$backgroundType2  = get_field('is_color_or_background_2', $postID);

$backgroundMobilePortrait1 = \Roots\Sage\Utils\get_image_by_device(get_field("bg_image_1_diptych_portrait", $postID));;
$backgroundMobileLandscape1 = \Roots\Sage\Utils\get_image_by_device(get_field("bg_image_1_diptych_landscape", $postID));;
$backgroundMobilePortrait2 = \Roots\Sage\Utils\get_image_by_device(get_field("bg_image_2_diptych_portrait", $postID));;
$backgroundMobileLandscape2 = \Roots\Sage\Utils\get_image_by_device(get_field("bg_image_2_diptych_landscape", $postID));;

$isFullHeight     = get_field('full_window_height', $postID);
$fullHeightClass  = ($isFullHeight == 1) ? "full-height" : "";

if($backgroundType1 == 'background') {
	$imageSrc = \Roots\Sage\Utils\get_image_by_device(get_field('bg_image_1', $postID));
	$background1 = 'style="background-image: url('.$imageSrc.')";';
	if($backgroundMobilePortrait1 == ""){
		$backgroundMobilePortrait1 = $imageSrc;
	};

	if($backgroundMobileLandscape1 == ""){
		$backgroundMobileLandscape1 = $imageSrc;
	}
} else {
	$background1 = 'style="background-color: '.get_field('background_color_1', $postID).'";';
}

if($backgroundType2 == 'background') {
	$imageSrc2 = \Roots\Sage\Utils\get_image_by_device(get_field('bg_image_2', $postID));
	$background2 = 'style="background-image: url('.$imageSrc2.')";';
	if($backgroundMobilePortrait2 == ""){
		$backgroundMobilePortrait2 = $imageSrc2;
	};

	if($backgroundMobileLandscape2 == ""){
		$backgroundMobileLandscape2 = $imageSrc2;
	}
} else {
	$background2 = 'style="background-color: '.get_field('background_color_2', $postID).'";';
}
?>

<div class="diptych row">
	<?php if ($moduleType == 'diptych-main-title'){ ?>
	<section class="section-content top-aligned">
		<?php if($mainSubtitle != '') { ?> <h3 class="main-subtitle"><?php echo $mainSubtitle; ?></h3> <?php } ?>
		<h1 class="main-title"><?php echo $mainTitle; ?></h1>
		<div class="copy"><?php echo $mainDescription; ?></div>
	</section>
	<?php } ?>
	<div class="col-xs-12 col-sm-6 bg-cols <?php echo $fullHeightClass; ?>">
		<?php if($backgroundType1 == 'background' && !$isDesktop){ ?>
			<div class="background-mobile portrait" style="background-image: url('<?php echo $backgroundMobilePortrait1; ?>')"></div>
			<div class="background-mobile landscape" style="background-image: url('<?php echo $backgroundMobileLandscape1; ?>')"></div>
		<?php } else{ ?>
			<div <?php echo $background1; ?> class="background">&nbsp;</div>
		<?php } ?>
		<section class="section-content bottom-aligned">
			<h1 class="main-title"><?php echo $leftTitle; ?></h1>
			<div class="copy"><?php echo $leftDescription; ?></div>
			<?php if(($leftButtonText != '')&& ($leftButtonURL != '')){ ?>
				<a class="btn btn-default" href="<?php echo $leftButtonURL; ?>"><?php echo $leftButtonText; ?></a>
			<?php } ?>
		</section>
	</div>
	<div class="col-xs-12 col-sm-6 bg-cols <?php echo $fullHeightClass; ?>">
		<?php if($backgroundType2 == 'background' && !$isDesktop){ ?>
			<div class="background-mobile portrait" style="background-image: url('<?php echo $backgroundMobilePortrait2; ?>')"></div>
			<div class="background-mobile landscape" style="background-image: url('<?php echo $backgroundMobileLandscape2; ?>')"></div>
		<?php } else{ ?>
				<div <?php echo $background2; ?> class="background">&nbsp;</div>
		<?php } ?>
		<section class="section-content bottom-aligned">
			<h1 class="main-title"><?php echo $rightTitle; ?></h1>
			<div class="copy"><?php echo $rightDescription; ?></div>
			<?php if(($rightButtonText != '')&& ($rightButtonURL != '')){ ?>
				<a class="btn btn-default" href="<?php echo $rightButtonURL; ?>"><?php echo $rightButtonText; ?></a>
			<?php } ?>
		</section>
	</div>
</div>
