<?php
/* This module is responsible for rendering the 'Slider' components.
 *
 * The values needed comes from Custom Fields defined within the post.
 *
 * The $postID variable comes from the Template Custom which renders the Module content.
 */

global $postID;

$sliderID         = rand(1,100);
$moduleType       = get_field('module_type', $postID);
$mainTitle        = get_field('main_title', $postID);
$mainSubtitle     = get_field('main_subtitle', $postID);
$mainDescription  = get_field('main_description', $postID);
$buttonText       = get_field('main_button_text', $postID);
$buttonURL        = get_field('main_button_url', $postID);

$slides = array();

if(get_field('image_slider_collection', $postID)):
	while(the_repeater_field('image_slider_collection', $postID)):

		$currentSlide = array(
			"image"       => get_sub_field('slide_image'),
			"caption"       => get_sub_field('slide_title')
		);
		array_push($slides, $currentSlide);

 	endwhile;
endif;

?>
<div class="slider <?php if($moduleType == 'slider-centered') echo 'slider-centered'; ?> row">
	<div id="carousel-example-generic-<?php echo $sliderID; ?>" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner" role="listbox">
		<?php
		foreach ($slides as $key => $slide) {
		?>
			<div class="item <?php if($key==0) echo 'active'; ?>">
				<img class="img-responsive" src="<?php echo $slide["image"]; ?>" alt="Test 1">
		<?php if($moduleType != 'slider-centered') { ?>
				<div class="image-caption"><?php echo $slide["caption"]; ?></div>
		<?php } ?>
			</div>
		<?php
		}
		?>
		</div>
		<a class="left carousel-control" href="#carousel-example-generic-<?php echo $sliderID; ?>" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#carousel-example-generic-<?php echo $sliderID; ?>" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
	<section>
		<?php if($mainSubtitle != '') { ?> <h3 class="main-subtitle"><?php echo $mainSubtitle; ?></h3> <?php } ?>
		<h3 class="main-title"><?php echo $mainTitle; ?></h3>
		<div class="copy"><?php echo $mainDescription; ?></div>
		<a class="btn btn-default" target="_blank" href="<?php echo $buttonURL; ?>"><?php echo $buttonText; ?></a>
	</section>
</div>
