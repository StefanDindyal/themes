<?php 
	/* 
	 * USAGE:
	 * render_component("hero", array("bg" => "imageURL", "bgLandscape" => "imageURL", "bgPortrait" => "imageURL" ));
	 */

	$isDesktop = Roots\Sage\Utils\is_desktop();

	$bg = isset($this->bg) ? $this->bg : "";
	$bgLandscape = isset($this->bgLandscape) ? $this->bgLandscape : $bg;
	$bgPortrait = isset($this->bgPortrait) ? $this->bgPortrait : $bg;

?>

<div class="hero-comp row">
  <?php if (isset($this->bg)) : ?>

  <?php if($isDesktop){?>
  		<div class="hero" style="background-image: url(<?php echo $bg; ?>);"></div>
    <?php } else { ?>
        <div class="backgroun-mobile portrait" style="background-image: url('<?php echo $bgPortrait; ?>')"></div>
        <div class="backgroun-mobile landscape" style="background-image: url('<?php echo $bgLandscape; ?>')"></div>
    <?php } ?>
  <?php else : ?>
  <div class="no-hero"></div>
  <?php endif; ?>
</div>
