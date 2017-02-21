<?php
/* Wistia Video
 *
 * USAGE:
 * render_component("wistia-video", array("id"=> "wistiaVideoID", "extraClasses"=>"some extra classes", "playButtonContainerSelector"));
 * playButtonContainerSelector: is the selector (ID) in case the button should be in a different container: the button will be moved with javascript.
 *
 */
  global $postID;
  
  $isDesktop = Roots\Sage\Utils\is_desktop();
  $desktopClass = ($isDesktop == true) ? "desktop" : "";
  $extraClasses = isset($this->extraClasses) ? $this->extraClasses : "";
  $playButtonText = get_field('video_play_button_text', $postID);
  $overlayImageSrc = get_field('image_before_video_start', $postID); 
  $wistiaID = ($this->id);
  $showPlayButton = get_field('show_play_button_in_video', $postID);
  $showPlayButton = ($showPlayButton == null || $showPlayButton == false ) ? 0 : 1;

  $playButtonContainerSelector = isset($this->playButtonContainerSelector) ? $this->playButtonContainerSelector : "";

?>


<?php if ($isDesktop || $showPlayButton == 1) { ?>
<div class="wistia-wrapper <?php echo $extraClasses; echo " ".$desktopClass; ?>">
	<div id="wistia_<?php echo $wistiaID;?>" class='wistia_embed wistia-video'></div>
	<div class="videoOverlay" style="background-image: url('<?php echo $overlayImageSrc; ?>');">
		<button class="btn btn-default playButton hidden"><?php echo $playButtonText; ?></button>
	</div>
</div>
<script>	
	$(document).ready(function() {    
		app.components.wistia.init("<?php echo $wistiaID; ?>", "<?php echo $showPlayButton; ?>", "<?php echo $playButtonContainerSelector; ?>")
	});
</script>
<?php } ?>