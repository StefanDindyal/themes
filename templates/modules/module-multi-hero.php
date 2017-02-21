<?php
/* This module is responsible for rendering the 'Multi Hero' components.
 *
 * The values needed comes from Custom Fields defined within the post.
 *
 * The $postID variable comes from the Template Custom which renders the Module content.
 */

global $postID;


$tiles = array();
$maxTilesNumber = 5;
$numberTiles = 0;

$isFullHeight     = get_field('full_window_height', $postID);
$fullHeightClass  = ($isFullHeight == 1) ? "full-height" : "";

$isDesktop = Roots\Sage\Utils\is_desktop();

if(get_field('hero_list', $postID)):
	while(the_repeater_field('hero_list', $postID)):
		$numberTiles++;
		$heroRegular   = \Roots\Sage\Utils\get_image_by_device(get_sub_field('hero_image', $postID));
		$heroPortrait  = \Roots\Sage\Utils\get_image_by_device(get_sub_field("hero_image_portrait", $postID));
		$heroLandscape = \Roots\Sage\Utils\get_image_by_device(get_sub_field("hero_image_landscape", $postID));
		if($heroPortrait == ""){
			$heroPortrait = $heroRegular;
		}
		if($heroLandscape == ""){
			$heroLandscape = $heroRegular;
		}

		$tileElt = array(
			"hero_title"				=> get_sub_field('hero_title'),
			"hero_pre_title"			=> get_sub_field('hero_pre_title'),
			"hero_sub_title"			=> get_sub_field('hero_sub_title'),
			"description_1"				=> get_sub_field('description_1'),
			"description_2"				=> get_sub_field('description_2'),
			"hero_image"				=> $heroRegular,
			"hero_portrait"				=> $heroPortrait,
			"hero_landscape"			=> $heroLandscape,
			"hero_content_align"		=> get_sub_field('hero_content_align'),
			"hero_content_font_color"	=> get_sub_field('hero_content_font_color'),
			"tile_title"				=> get_sub_field('tile_title'),
			"tile_description"			=> get_sub_field('tile_description'),
			"tile_image"				=> get_sub_field('tile_image'),
			"location"					=> get_sub_field('location')
		);
		array_push($tiles, $tileElt);

 	endwhile;
endif;

$missing = $maxTilesNumber - ($numberTiles % $maxTilesNumber);
$missing = ($missing == 5) ? 0 : $missing;
$missingTablet = ($numberTiles % 2);

$firstTile = $tiles[0];

$mainTextColorClass = $firstTile["hero_content_font_color"];
$mainTextColorClass = ($mainTextColorClass == "") ? "white-text" : $mainTextColorClass;

$colsLargeScreen = "col-custom-5";

?>
<div id="multihero-<?php echo $postID; ?>" class="multi-hero <?php echo get_field('module_type', $postID); ?>">
	<div class="hero row <?php echo $fullHeightClass; ?> hidden-xs hidden-sm hidden-md">
		<?php if($isDesktop){ ?>
			<div class="main-background" style="background-image: url(' <?php echo $firstTile['hero_image']; ?>')"></div>
		<?php } else{ ?>
			<div class="main-background portrait" style="background-image: url('<?php echo $firstTile['hero_portrait']; ?>')"></div>
			<div class="main-background landscape" style="background-image: url('<?php echo $firstTile['hero_landscape']; ?>')"></div>
		<?php } ?>		
		<section class="text-left left-content <?php echo $mainTextColorClass; ?>">
			<h3 class="main-pre-title text-uppercase hero-info-pre-title"> <?php if($tile["hero_pre_title"]) { echo $tile["hero_pre_title"]; }?></h3>
			<h1 class="main-title"><?php echo $firstTile['hero_title']; ?></h1>
			<h2 class="text-uppercase main-sub-title"> <?php if($tile["hero_sub_title"]) { echo $tile["hero_sub_title"]; }?></h2>
			<div class="copy hero-description-1"><?php echo $firstTile['description_1']; ?></div>
			<div class="copy hero-description-2"><?php echo $firstTile['description_2']; ?></div>
		</section>
	</div>

	<div class="grids row">
		<div class="grid-container" style="<?php echo $inlineStyles; ?>">
			<div class="row-centered">
				<?php foreach($tiles as $tile) { ?>
				<div class="grid col-xs-12 col-sm-12 col-md-12 <?php echo $colsLargeScreen; ?>">
					<div class="tile info-wrapper" style="background-image: url('<?php echo $tile["tile_image"]['url']; ?>');">
						<section class="grid-information">
							<?php if($tile["tile_title"] != '') { ?> <h1 class="main-title"><?php echo $tile["tile_title"]; ?></h1> <?php } ?>
							<?php if($tile["tile_description"] != '') { ?> <div class="copy"><?php echo $tile["tile_description"] ?></div> <?php } ?>
						</section>
						<div class="in-tile-info hidden text-left">
							<h3 class="main-pre-title text-uppercase hero-info-pre-title"> <?php if($tile["hero_pre_title"]) { echo $tile["hero_pre_title"]; }?></h3>
							<h1 class="main-title text-uppercase hero-info-title"> <?php if($tile["hero_title"]) { echo $tile["hero_title"]; }?></h1>
							<h2 class="text-uppercase hero-info-sub-title"> <?php if($tile["hero_sub_title"]) { echo $tile["hero_sub_title"]; }?></h2>
							<div class="hidden copy hero-info-desc1"><?php if($tile["description_1"]) { echo $tile["description_1"]; }?></div>
							<div class="hidden copy hero-info-desc2"><?php if($tile["description_2"]) { echo $tile["description_2"]; }?></div>
							<p class="hero-info-align hidden"><?php echo $tile["hero_content_align"];?></p>
							<p class="hero-info-font-color hidden"><?php echo $tile["hero_content_font_color"];?></p>
							<?php if($isDesktop){ ?>
								<p class="hero-info-img-regular hidden"><?php if($tile["hero_image"]) { echo $tile["hero_image"]; }?></p>
							<?php } else{ ?>
								<p class="hero-info-img-portrait hidden"><?php if($tile["hero_portrait"]) { echo $tile["hero_portrait"]; }?></p>
								<p class="hero-info-img-landscape hidden"><?php if($tile["hero_landscape"]) { echo $tile["hero_landscape"]; }?></p>
							<?php } ?>
						</div>
					</div>
					<div class="mobile-tile-info dark-text visible-xs visible-sm visible-md">
						<div class="copy"><?php if($tile["description_1"]) { echo $tile["description_1"]; }?></div>
						<div class="copy"><?php if($tile["description_2"]) { echo $tile["description_2"]; }?></div>
					</div>
				</div>
				<?php } ?>

				<?php 

				$appearOnTablet = 'hidden-sm';

				for ($x = 1; $x <= $missing; $x++) { 
					$appearOnTablet = ($missingTablet==$x) ? "" : $appearOnTablet = "hidden-sm";
				?>

				<div class="grid col-xs-12 col-sm-12 col-custom-5 hidden-xs hidden-sm hidden-md">
					<div class="info-wrapper" style="background-image: url('http://undertone.qa.kg-stage.com/wp-content/uploads/2015/07/img-team-extra.png')">
						<section class="grid-information">
						</section>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		var HERO = $('.hero');
		var TILE_MOVE_DELAY = 600;
		app.modules.multiHero.init("<?php echo $postID; ?>", "<?php echo $isDesktop; ?>");
	});
</script>