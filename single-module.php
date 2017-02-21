<?php
  global $postID;
  global $insideFullPageModule;

  $moduleType = get_field('module_type', $postID);
  $clearNavigationCheck = get_field('clear_navigation_menu', $postID);

  // If the modules are being rendered inside a full page module then the navigation bar color version should not
  // change with the waypoints, instead, they change when the section changes.
  if($insideFullPageModule){
    $navigation = ($clearNavigationCheck == 1) ? "clearNavOnRequest" : "";
  }
  else{
    $navigation = ($clearNavigationCheck == 1) ? "clearNav" : "";
  }

  echo "<div id=".$postID." class='module ".$navigation."'>";

	switch ($moduleType) {
	    case 'hero':
	        get_template_part('templates/modules/module', 'hero');
	        break;
	    case 'slider-centered':
	        get_template_part('templates/modules/module', 'slider');
	        break;
	    case 'slider-left':
	        get_template_part('templates/modules/module', 'slider');
	        break;
    	case 'diptych-main-title':
	        get_template_part('templates/modules/module', 'diptych');
	        break;
    	case 'diptych-regular':
	        get_template_part('templates/modules/module', 'diptych');
	        break;
    	case 'triptych-white':
	        get_template_part('templates/modules/module', 'triptych');
	        break;
    	case 'triptych-transparent':
	        get_template_part('templates/modules/module', 'triptych');
	        break;
    	case 'circles':
	        get_template_part('templates/modules/module', 'circles');
	        break;
    	case 'image-grid-centered':
	        get_template_part('templates/modules/module', 'imagegrid');
	        break;
    	case 'image-grid-left':
	        get_template_part('templates/modules/module', 'imagegrid');
	        break;
    	case 'articles-full':
	        get_template_part('templates/modules/module', 'articles');
	        break;
      case 'articles-caption':
	        get_template_part('templates/modules/module', 'articles');
	        break;
      case 'copy':
          get_template_part('templates/modules/module', 'copy');
          break;
      case 'copy-transition':
          get_template_part('templates/modules/module', 'copy-transition');
          break;
    	case 'full-page-slider':
        	get_template_part('templates/modules/module', 'full-page-slider');
        	break;
      case 'grid-container':
        	get_template_part('templates/modules/module', 'grids');
        	break;
      case 'publisher-form':
        	get_template_part('templates/modules/module', 'publisher-form');
        	break;
      case 'multi-hero-grid-selector':
          get_template_part('templates/modules/module', 'multi-hero');
          break;
      case 'multi-hero-grid-selector-w-location':
          get_template_part('templates/modules/module', 'multi-hero-w-location');
          break;
      case 'job-listing':
          get_template_part('templates/modules/module', 'job-listing');
          break;
      case 'video-grid-container':
          get_template_part('templates/modules/module', 'video-grid');
          break;
      case 'ad-block':
          get_template_part('templates/modules/module', 'ad-block');
          break;
	}
  echo "</div>";
?>
