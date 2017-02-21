<?php
/* This module is responsible for rendering the 'Video Grid' components.
 *
 * The values needed comes from Custom Fields defined within the post.
 *
 * The $postID variable comes from the Template Custom which renders the Module content.
 */

global $postID;

$moduleType       = get_field('module_type', $postID);
$mainHero         = get_field('video_grid_hero', $postID);
$grids            = array();
$id               = uniqid();

if(get_field('video_grids', $postID)):
	while(the_repeater_field('video_grids', $postID)):
		$currentGrid = array(
			"title"       => get_sub_field('video_grid_title'),
			"code"        => get_sub_field('video_grid_code'),
			"image"       => get_sub_field('video_grid_image')
		);
		array_push($grids, $currentGrid);
 	endwhile;
endif;

?>

<div class="video-grid row <?php echo $id; ?>">
	<div class="main-section" style="background-image: url('<?php echo $mainHero ?>')">
		<div class='wistia_embed wistia-video'></div>
		<div class="wistia-overlay"></div>
	</div>
	<div class="grid-container">
		<?php foreach($grids as $grid) { ?>
		<div class="grid col-xs-12 col-sm-6 col-md-3 square" style="background-image: url('<?php echo $grid["image"]; ?>')">
			<span class="divider"></span>
			<section class="grid-information">
				<h1 class="main-title"><?php echo $grid["title"]; ?></h1>
				<span class="play-button" data-code="<?php echo $grid["code"]; ?>"></span>
			</section>
		</div>
		<?php } ?>
	</div>
</div>
<script>
	$(document).ready(function() {
		app.modules.videoGrid.init(".<?php echo $id; ?>");
	});
</script>