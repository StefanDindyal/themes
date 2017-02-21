<?php
/* This module is responsible for rendering the 'Hero' components.
 *
 * The values needed comes from Custom Fields defined within the post.
 *
 * The $postID variable comes from the Template Custom which renders the Module content.
 */

global $postID;

$isDesktop = Roots\Sage\Utils\is_desktop();

$mainTitle        = get_field('main_title', $postID);
$mainTitleNotBold = get_field('main_title_not_bold', $postID);
$mainSubtitle     = get_field('main_subtitle', $postID);
$mainDescription  = get_field('main_description', $postID);
$mobileDescription  = get_field('mobile_description', $postID);
$contentAlign     = get_field('content_align', $postID);
$backgroundType   = get_field('is_color_image_or_video', $postID);

$isFullHeight     = get_field('full_window_height', $postID);
$fullHeightClass  = ($isFullHeight == 1) ? "full-height" : "";

$buttonText       = get_field('main_button_text', $postID);
$buttonURL        = get_field('main_button_url', $postID);
$isButtonOk = false;

if($buttonText != "" && $buttonURL != ""){
  $isButtonOk = true;
}

$clearNavigationCheck = get_field('clear_navigation_menu', $postID);
$navigation = ($clearNavigationCheck == 1) ? "clear" : "green";

$background       = '';
$backgroundMobilePortrait = '';
$backgroundMobileLandscape = '';
$imageSrc		  = '';
$heroId			  = "hero-".uniqid();

if($backgroundType=='background') {
	$imageSrc = \Roots\Sage\Utils\get_image_by_device(get_field('bg_image_1', $postID));
	$background = 'style="background-image: url('.$imageSrc.');"';
} else if($backgroundType=='color') {
	$background = 'style="background-color: '.get_field('background_color_1', $postID).';"';
} else if($backgroundType=='video'){
	//
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

$mainTextColorClass = get_field("main_text_font_color_set", $postID);
$mainTextColorClass = ($mainTextColorClass == "")? "white-text" : $mainTextColorClass;

$sectionId = uniqid();

?>
<div id="<?php echo $heroId; ?>"class="hero row <?php echo $fullHeightClass; ?>" data-nav="<?php echo $navigation?>">
	<?php if($backgroundType=='video'){
		render_component("wistia-video", array(
			"id"=> get_field('bg_video_1', $postID), 
			"extraClasses"=>$mainTextColorClass, 
			"playButtonContainerSelector"=>"#".$sectionId)
		);
	?>
	<?php } else if($isDesktop){ ?>
		<div <?php echo $background; ?> class="background">
			<?php if($isButtonOk) { ?>
				<a href="<?php echo $buttonURL; ?>"><img src="<?php echo $imageSrc; ?>" alt="&nbsp;" border="0"/></a>
			<?php } else { ?>
				<img src="<?php echo $imageSrc; ?>" alt="&nbsp;" border="0"/>
			<?php } ?>
		</div>
	<?php } ?>
	<?php if($backgroundType != 'color' && $isDesktop == false){?>
		<?php if($isButtonOk) { ?>
			<div class="background-mobile portrait" style="background-image: url('<?php echo $backgroundMobilePortrait; ?>')">
				<a href="<?php echo $buttonURL; ?>">
					<img src="<?php echo $imageSrc; ?>" alt="&nbsp;" border="0"/>
					<img src="<?php echo $backgroundMobilePortrait; ?>" alt="&nbsp;" border="0" class="mobileOne"/>
				</a>
			</div>
			<div class="background-mobile landscape" style="background-image: url('<?php echo $backgroundMobileLandscape; ?>')">
				<a href="<?php echo $buttonURL; ?>">
					<img src="<?php echo $imageSrc; ?>" alt="&nbsp;" border="0"/>
					<img src="<?php echo $backgroundMobilePortrait; ?>" alt="&nbsp;" border="0" class="mobileOne"/>
				</a>
			</div>
		<?php } else { ?>
			<div class="background-mobile portrait" style="background-image: url('<?php echo $backgroundMobilePortrait; ?>')">
				<img src="<?php echo $imageSrc; ?>" alt="&nbsp;" border="0"/>
				<img src="<?php echo $backgroundMobilePortrait; ?>" alt="&nbsp;" border="0" class="mobileOne"/>
			</div>
			<div class="background-mobile landscape" style="background-image: url('<?php echo $backgroundMobileLandscape; ?>')">
				<img src="<?php echo $imageSrc; ?>" alt="&nbsp;" border="0"/>
				<img src="<?php echo $backgroundMobilePortrait; ?>" alt="&nbsp;" border="0" class="mobileOne"/>
			</div>
		<?php } ?>
	<?php } ?>
	
	<section id="<?php echo $sectionId; ?>" class="text-<?php echo $contentAlign; ?> <?php echo $mainTextColorClass; ?> <?php echo $contentAlign; ?>-content">
		<?php if($mainSubtitle != '') { ?><h3 class="main-subtitle"><?php echo $mainSubtitle; ?></h3> <?php } ?>
		<h1 class="main-title"><?php echo $mainTitle; ?><span class="main-title-not-bold"><?php echo $mainTitleNotBold; ?></span></h1>
		<div class="copy"><?php echo $mainDescription; ?></div>
		<?php if($mobileDescription){ ?>
			<div class="copy mobile"><?php echo $mobileDescription; ?></div>			
		<?php } ?>
		<?php if($isButtonOk) { ?><a href="<?php echo $buttonURL; ?>" class="btn btn-default"><?php echo $buttonText; ?></a> <?php } ?>
	</section>
</div>

<script>
	$(function (){
		app.modules.hero.init('<?php echo $imageSrc; ?>', '<?php echo $heroId; ?>');
	});
</script>

