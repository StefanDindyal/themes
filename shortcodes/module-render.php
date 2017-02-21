<?php
/*
 * Shortcode used to render the modules received by parameter
 * Usage: [module ids="1, 2, 3, 4"]
 * The parameter ids represents the id of each module to be rendered
 */

	function modules_shortcode( $atts, $content = null ) {
		global $postID;
		$ids = trim($atts['ids'], " ");
		$ids = explode(",", $ids);
		ob_start();
		foreach ($ids as &$value) {
			$postID = $value;
			get_template_part('single', 'module');
		}
		return ob_get_clean();
	}
	add_shortcode( 'module', 'modules_shortcode' );
?>