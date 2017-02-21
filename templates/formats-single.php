<?php
global $sitepress;
$postID         = get_the_ID();
$postName       = get_the_title();

$cleanPostName = \Roots\Sage\Utils\removeHtmlTags($postName, true); // removes html tag like "Title<sup>TM</supt>" => Title
$cleanPostName  = strtolower(\Roots\Sage\Utils\cleanSpecialChars($cleanPostName));

$demoURL        = get_field('demo_url', $postID);
$galleryURL     = get_field('gallery_url', $postID);
$showDemoURL  	= get_field('show_demo_url', $postID);
$showGalleryURL = get_field('show_gallery_url', $postID);

$showDemoURL    = (is_array($showDemoURL)) ? implode($showDemoURL, ",") : "";
$showGalleryURL = (is_array($showGalleryURL)) ? implode($showGalleryURL, ",") : "";

$devices      = array();
$features     = array();
$kpis         = array();

$itemsAdded   = 0;
$currentSet   = array();

$uniqid       = uniqid();

if(get_field('spec_devices', $postID)):
	while(the_repeater_field('spec_devices', $postID)):
		$currentItem = array(
			"image"       => get_sub_field('specdevice_image'),
			"title"       => get_sub_field('specdevice_title')
		);
		array_push($currentSet, $currentItem);
		$itemsAdded++;
		if($itemsAdded == 3){
			array_push($devices, $currentSet);
			$currentSet = array();
			$itemsAdded = 0;
		}
 	endwhile;
 	if($itemsAdded > 0){
 		array_push($devices, $currentSet);
 	}
endif;

$itemsAdded   = 0;
$currentSet   = array();

if(get_field('features', $postID)):
	while(the_repeater_field('features', $postID)):
		$currentItem = array(
			"image"       => get_sub_field('features_image'),
			"title"       => get_sub_field('features_title')
		);
		array_push($currentSet, $currentItem);
		$itemsAdded++;
		if($itemsAdded == 3){
			array_push($features, $currentSet);
			$currentSet = array();
			$itemsAdded = 0;
		}
 	endwhile;
 	if($itemsAdded > 0){
 		array_push($features, $currentSet);
 	}
endif;

$itemsAdded   = 0;
$currentSet   = array();

if(get_field('kpis', $postID)):
	while(the_repeater_field('kpis', $postID)):
		$currentItem = array(
			"image"       => get_sub_field('kpi_image'),
			"title"       => get_sub_field('kpi_title')
		);
		array_push($currentSet, $currentItem);
		$itemsAdded++;
		if($itemsAdded == 3){
			array_push($kpis, $currentSet);
			$currentSet = array();
			$itemsAdded = 0;
		}
 	endwhile;
 	if($itemsAdded > 0){
 		array_push($kpis, $currentSet);
 	}
endif;

$specificationsTitle = 'Format Specifications';
$performanceTitle = 'Performance Benchmarks';

if (ICL_LANGUAGE_CODE == 'de') {
	$specificationsTitle = 'Spezifikationen';
	$performanceTitle = 'Performance-Benchmarks';
}

?>

<div id="format-<?php echo $cleanPostName; ?>" class="format-single row <?php echo $uniqid; ?>">
	<section class="main-section">
		<h1 class="text-main-title"><?php echo the_title(); ?></h1>
		<p class="text-main-paragraph"><?php echo the_content(); ?></p>
	</section>

	<div class="ad-media">
		<div class="ad-media-container">
			<?php render_component("ad-media"); ?>
		</div>
		<div class="container">
			<div class="row">
				<div class="demo-gallery-buttons col-xs-12">
					<?php if( $demoURL !== ""){ ?>
						<a href="<?php echo $demoURL; ?>" target="_blank" class="btn btn-default launch-demo hidden"  data-devices="<?php echo $showDemoURL; ?>">Launch Demo</a>
					<?php } ?>
					<a href="<?php echo $sitepress->language_url(ICL_LANGUAGE_CODE); ?>gallery?form=<?php echo $postID; ?>" target="_blank" class="btn btn-default view-gallery hidden" data-devices="<?php echo $showGalleryURL;?>">View Gallery</a>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="information row">
			<div class="section col-xs-12 col-md-6">
				<h4 class="section-header"><?php echo $specificationsTitle; ?></h4>
				<div class="sub-section">
					<div class="row">
						<div class="col-xs-12">
							<p class="sub-section-header">Device</p>
						</div>
					</div>
					<div class="items">
						<?php foreach($devices as $deviceContainer) { ?>
						<div class="row">
							<?php foreach ($deviceContainer as $device) { ?>
							<div class="item-container col-xs-4">
								<div class="item">
									<img src="<?php echo $device['image']; ?>" class="item-image img-responsive" alt="">
									<p class="item-title"><?php echo $device['title']; ?></p>
								</div>
							</div>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="sub-section">
					<div class="row">
						<div class="col-xs-12">
							<p class="sub-section-header">Features</p>
						</div>
					</div>
					<div class="items">
						<?php foreach($features as $featuresContainer) { ?>
						<div class="row">
							<?php foreach ($featuresContainer as $feature) { ?>
							<div class="item-container col-xs-4">
								<div class="item">
									<img src="<?php echo $feature['image']; ?>" class="item-image img-responsive" alt="">
									<p class="item-title"><?php echo $feature['title']; ?></p>
								</div>
							</div>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="sub-section">
					<div class="row">
						<div class="col-xs-12">
							<p class="sub-section-header">KPI</p>
						</div>
					</div>
					<div class="items">
						<?php foreach($kpis as $kpiContainer) { ?>
						<div class="row">
							<?php foreach ($kpiContainer as $kpi) { ?>
							<div class="item-container col-xs-4">
								<div class="item">
									<img src="<?php echo $kpi['image']; ?>" class="item-image img-responsive" alt="">
									<p class="item-title"><?php echo $kpi['title']; ?></p>
								</div>
							</div>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="section col-xs-12 col-md-6">
				<h4 class="section-header"><?php echo $performanceTitle; ?></h4>
				<?php render_component("format-metrics", array("format" => get_the_ID()));?>
			</div>
		</div>
	</div>
</div>
<script>
  $(document).ready(function () {
    app.templates.formatSingle.init(".<?php echo $uniqid; ?>");
  });
</script>