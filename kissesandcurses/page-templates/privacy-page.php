<?php 
	/* Template Name: Privacy Policy */ 
	get_header();
	$privacy_copy = get_post_meta($post->ID, 'kc_privacy_copy', true);
?>
<div id="privacy-page">	
	<div id="story" class="section">		
		<div class="letter">
			<div class="rig">				
				<h2>Privacy Policy</h2>
				<?php echo wpautop($privacy_copy); ?>	
			</div>
		</div>
	</div>	
</div>
<?php
	get_footer();
