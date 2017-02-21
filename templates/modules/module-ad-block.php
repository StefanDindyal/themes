<?php
/* This module is responsible for rendering the 'Hero' components.
 *
 * The values needed comes from Custom Fields defined within the post.
 *
 * The $postID variable comes from the Template Custom which renders the Module content.
 */

global $postID;

$isDesktop = Roots\Sage\Utils\is_desktop();
$adContent  = get_field('ad_content', $postID);
$adType  = get_field('ad_type', $postID);

?>
<div class="ad-block">

  <div class="ad <?php if($adType){ echo $adType; } ?>">
    <?php if($adType === 'seeThrough'){ ?>
      <div id="targetElement"></div>
    <?php } ?>
    <?php if($adContent){
      echo $adContent;
    } ?>
	</div>
  
</div>