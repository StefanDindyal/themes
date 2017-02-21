<?php
/* Language Overlay Module.
 *
 * EVENTS:
 * Open Overlay   ->   app.instances.LanguageSelectorComponents["uniqId"].open();
 * Open Overlay   ->   app.instances.LanguageSelectorComponents["uniqId"].close();
 * Toggle Overlay ->   app.instances.LanguageSelectorComponents["uniqId"].toggle();
 *
 * USAGE:
 * render_component("language-selector",array("smallVersion" => true, "id"=> "uniqId"));
 */

	$id = ($this->id);
	$smallVersion = ($this->smallVersion == true) ? true : false;
  	$smallClass = ($smallVersion == true) ? "small" : ""; 
?>

<div id="<?php echo $id; ?>" class="language-selector <?php echo $smallClass; ?>">
    <button class="close-btn" onclick="app.instances.LanguageSelectorComponents['<?php echo $id; ?>'].close()"></button> 
	<div class="languages-container">
		<p class="secondary-title">Change your location</p>
	<!-- 	<ul class="visible-xs-block">
			
		</ul> -->
		<?php
		if( function_exists('icl_get_languages') ):
	    $languages = icl_get_languages('skip_missing=1&orderby=custom');
	  
	    $link = '<ul class="languages"><li class="back-button-container"><a data-previous-item-id="'.$id.'">Locations</a></li>';
	    foreach($languages as $language) {
	    	$lang = \Roots\Sage\Utils\wpml_lang_by_code($language['language_code']);
	    	if($language['language_code'] == 'en'){
	    		$link .= '<li class="language"><a class="lang lang-'.$language['language_code'].'" href="' . $language['url'] . '"><button class="lang-badge">US/CAN</button>US &amp; Canada</a></li>';
	    	} else {
	    		$link .= '<li class="language"><a class="lang lang-'.$language['language_code'].'" href="' . $language['url'] . '"><button class="lang-badge">'.$lang["tag"].'</button>' . $language['native_name'] . '</a></li>';	
	    	}	        
	    }
	    $link .= '</ul>';
	  
	    echo $link;
	    endif;
		?>
	</div>

</div>

<script>
  $(document).ready(function() {
    var newLanguageSelector = new app.components.languageSelector("<?php echo $id; ?>","<?php echo $smallVersion; ?>");
    app.instances.LanguageSelectorComponents["<?php echo $id; ?>"] = newLanguageSelector;
  });
</script>