<?php
/* This module is responsible for rendering the 'Articles' components.
 *
 * The values needed comes from Custom Fields defined within the post.
 *
 * The $postID variable comes from the Template Custom which renders the Module content.
 */

global $postID;

$isDesktop = Roots\Sage\Utils\is_desktop();
$moduleType       = get_field('module_type', $postID);

$mainTitle        = get_field('main_title', $postID);
$mainSubtitle     = get_field('main_subtitle', $postID);
$mainDescription  = get_field('main_description', $postID);
$buttonText       = get_field('main_button_text', $postID);
$buttonURL        = get_field('main_button_url', $postID);
$contentAlign     = get_field('content_align', $postID);
$backgroundType   = get_field('is_color_image_or_video', $postID);
$background       = '';
$backgroundMobilePortrait = '';
$backgroundMobileLandscape = '';
$videoId		  = '';

if($backgroundType=='background') {
	$imageSrc = \Roots\Sage\Utils\get_image_by_device(get_field('bg_image_1', $postID));
	$background = 'style="background-image: url('.$imageSrc.');"';
} else if($backgroundType=='color') {
	$background = 'style="background-color: '.get_field('background_color_1', $postID).';"';
} else if($backgroundType=='video'){
	$videoId = get_field('bg_video_1', $postID);
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

$articleGrid = $moduleType == 'articles-full' ? 'article_grid_full' : 'article_grid_caption';
$grids = array();

if(get_field($articleGrid, $postID)):
	while(the_repeater_field($articleGrid, $postID)):
		if($articleGrid == 'article_grid_full'){
			//article_grid_full
			$currentGrid = array(
				"image"       => get_sub_field('article_image'),
				"title"       => get_sub_field('article_title'),
				"description" => get_sub_field('article_description'),
				"buttonText"  => get_sub_field('article_button_text'),
				"buttonUrl"   => get_sub_field('article_button_url')
			);
			array_push($grids, $currentGrid);
		}else{
			//article_grid_caption
			$currentGrid = array(
				"image"       => get_sub_field('article_caption_image'),
				"title"       => get_sub_field('article_caption_title')
			);
			array_push($grids, $currentGrid);
		}
 	endwhile;
endif;

?>
<div class="article row">
	<div class="hero-article">
		<div <?php echo $background; ?> class="background">
		 	<?php 
		        if($backgroundType =='video') {
		          render_component("wistia-video", array("id"=> $videoId));
		        }
		    ?>
		    <?php if($backgroundType != 'color' && $isDesktop == false){?>
				<div class="backgroun-mobile portrait" style="background-image: url('<?php echo $backgroundMobilePortrait; ?>')"></div>
				<div class="backgroun-mobile landscape" style="background-image: url('<?php echo $backgroundMobileLandscape; ?>')"></div>
			<?php } ?>
		</div>
		<section class="text-<?php echo $contentAlign; ?> <?php echo $contentAlign; ?>-content">
			<?php if($mainSubtitle != '') { ?> <h3 class="main-subtitle"><?php echo $mainSubtitle; ?></h3> <?php } ?>
			<h1 class="main-title"><?php echo $mainTitle; ?></h1>
			<div class="copy"><?php echo $mainDescription; ?></div>
			<a class="btn btn-default" href="<?php echo $buttonURL; ?>"><?php echo $buttonText; ?></a>
		</section>
	</div>
	<div class="grid-container">
		<?php foreach($grids as $grid) { ?>
		<div class="grid col-xs-12 col-sm-6 col-md-3 " style="background-image: url('<?php echo $grid["image"]; ?>')">
			<span class="divider"></span>
			<div class="grid-wrapper">
				<div class="grid-overlay"></div>
				<?php if($articleGrid == 'article_grid_full'){ ?>
				<section class="grid-information">
					<h1 class="main-title"><?php echo $grid["title"]; ?></h1>
					<div class="copy"><?php echo $grid["description"]; ?></div>
					<?php if($grid["buttonUrl"]!='') { ?><a href="<?php echo $grid["buttonUrl"]; ?>" class="btn btn-default"><?php echo $grid["buttonText"]; ?></a><?php } ?>
				</section>
				<?php }else{ ?>
				<section class="grid-information to-bottom">
					<div class="small-title"><?php echo $grid["title"]; ?></div>
				</section>
				<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
</div>