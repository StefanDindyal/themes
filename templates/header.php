<?php

	// OPEN sky
	echo '<div id="sky">';
	// Desktop navigation bar
	if(\Roots\Sage\Utils\is_mobile_device() == false){
		render_component("navigation"); 
	}
	// Mobile navigation bar
	render_component("navigation-small");
?>

