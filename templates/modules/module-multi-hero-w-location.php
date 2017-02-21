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
			"description_1"				=> get_sub_field('description_1'),
			"email"						=> get_sub_field('hero_email'),
			"description_2"				=> get_sub_field('description_2'),
			"hero_image"				=> $heroRegular,
			"hero_portrait"				=> $heroPortrait,
			"hero_landscape"			=> $heroLandscape,
			"hero_url"					=> get_sub_field('hero_url'),
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

$mainTextColorClass = $firstTile["hero_content_font_color"];
$mainTextColorClass = ($mainTextColorClass == "") ? "white-text" : $mainTextColorClass;

$firstTile = $tiles[0];
$colsLargeScreen = "col-custom-5";

?>
<div id="multihero-<?php echo $postID; ?>" class="multi-hero">
	<div class="hero row <?php echo $fullHeightClass; ?> hidden-xs hidden-sm hidden-md">
		<?php if($isDesktop){ ?>
			<div class="main-background" style="background-image: url(' <?php echo $firstTile['hero_image']; ?>')"></div>
		<?php } else{ ?>
			<div class="main-background portrait" style="background-image: url('<?php echo $firstTile['hero_portrait']; ?>')"></div>
			<div class="main-background landscape" style="background-image: url('<?php echo $firstTile['hero_landscape']; ?>')"></div>
		<?php } ?>	
		<a class="hero-url" target="blank" href="<?php echo $firstTile['hero_url']; ?>"></a>
		<section class="text-left left-content <?php echo $mainTextColorClass; ?>">
			<h1 class="main-title"><?php echo $firstTile['hero_title']; ?></h1>
			<div class="copy hero-description-1"><?php echo $firstTile['description_1']; ?></div>
			<a href="mailto: <?php echo $firstTile['email']?> " class="copy hero-email"><?php echo $firstTile['email']; ?></a>
			<div class="copy hero-description-2"><?php echo $firstTile['description_2']; ?></div>
		</section>
		<svg class="clock" width="120" height="120" >
			<g><circle cx="60" cy="60" r="55"></circle></g>
			<g class="minilines"></g>
			<line x1="60" y1="70" x2="60" y2="39" class="hour"></line>
			<line x1="60" y1="70" x2="60" y2="25" class="minute"></line>
			<line x1="60" y1="70" x2="60" y2="10" class="second"></line>
		</svg>
	</div>

	<div class="grids row">
		<div class="grid-container" style="<?php echo $inlineStyles; ?>">
			<div class="row-centered">
				<?php foreach($tiles as $tile) { ?>
				<div class="grid col-xs-12 col-sm-12 col-md-12 <?php echo $colsLargeScreen; ?>">
					<div class="tile info-wrapper" style="background-image: url('<?php echo $tile["tile_image"]['url']; ?>');">
						<section class="grid-information">
							<?php if($tile["tile_title"] != '') { ?> <h1 class="main-title hidden-xs hidden-sm hidden-md"><?php echo $tile["tile_title"]; ?></h1> <?php } ?>
							<?php if($tile["tile_description"] != '') { ?> <div class="copy hidden-xs hidden-sm hidden-md"><?php echo $tile["tile_description"] ?></div> <?php } ?>
						</section>
						<section class="in-tile-info visible-xs-block visible-sm-block visible-md-block text-left <?php echo $tile["hero_content_font_color"];?>">
							<h1 class="main-title text-uppercase hero-info-title"> <?php if($tile["hero_title"]) { echo $tile["hero_title"]; }?></h1>
							<?php if($isDesktop){ ?>
								<p class="copy hero-info-desc1"><?php if($tile["description_1"]) { echo ($tile["description_1"]); }?></p>
							<?php } else { ?>
								<p class="copy hero-info-desc1"><?php if($tile["description_1"]) { echo ('<a href="'.$tile["hero_url"].'" target="_blank">'.$tile["description_1"].'</a>'); }?></p>
							<?php } ?>
							<?php if($tile["email"]) { ?><a href="mailto:<?php echo $tile["email"]; ?>" class="copy hero-info-email"><?php echo $tile["email"];?></a> <?php } ?>
							<p class="copy hero-info-desc2"><?php if($tile["description_2"]) { echo ($tile["description_2"]); }?></p>
							<p class="copy hero-info-url hidden"><?php if($tile["hero_url"]) { echo $tile["hero_url"]; }?></p>
							<p class="hero-info-align hidden"><?php echo $tile["hero_content_align"];?></p>
							<p class="hero-info-font-color hidden"><?php echo $tile["hero_content_font_color"];?></p>
							<p class="hero-info-latitude hidden"><?php if($tile["location"]) { echo $tile["location"]["lat"]; }?></p>
							<p class="hero-info-longitude hidden"><?php if($tile["location"]) { echo $tile["location"]["lng"]; }?></p>
							<?php if($isDesktop){ ?>
								<p class="hero-info-img-regular hidden"><?php if($tile["hero_image"]) { echo $tile["hero_image"]; }?></p>
							<?php } else{ ?>
								<p class="hero-info-img-portrait hidden"><?php if($tile["hero_portrait"]) { echo $tile["hero_portrait"]; }?></p>
								<p class="hero-info-img-landscape hidden"><?php if($tile["hero_landscape"]) { echo $tile["hero_landscape"]; }?></p>
							<?php } ?>
						</section>
						<svg class="clock visible-xs-block visible-sm-block visible-md-block" width="120" height="120" >
							<g><circle cx="60" cy="60" r="55"></circle></g>
							<g class="minilines"></g>
							<line x1="60" y1="70" x2="60" y2="39" class="hour"></line>
							<line x1="60" y1="70" x2="60" y2="25" class="minute"></line>
							<line x1="60" y1="70" x2="60" y2="10" class="second"></line>
						</svg>
					</div>
				</div>
				<?php } ?>

				<?php 

				$appearOnTablet = 'hidden-sm';

				for ($x = 1; $x <= $missing; $x++) { 
					$appearOnTablet = ($missingTablet==$x) ? "" : $appearOnTablet = "hidden-sm";
				?>

				<div class="grid col-xs-12 col-sm-12 col-custom-5 hidden-xs hidden-sm hidden-md <?php echo $appearOnTablet; ?>">
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
		app.modules.multiHero.init("<?php echo $postID; ?>", "<?php echo $isDesktop; ?>");
		app.modules.multiHero.setUpMiniLines(HERO);
		app.modules.multiHero.updateTimezone('<?php echo $firstTile['location']['lat']; ?>', '<?php echo $firstTile['location']['lng']; ?>', $(HERO.find('.clock')));
		app.modules.multiHero.setClock(HERO);
	});
</script>