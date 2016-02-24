<?php 
	/* Template Name: FAQ */ 
	get_header();
	$faq_title_copy = get_post_meta($post->ID, 'kc_faq_title_copy', true);
	$faq_qa = get_post_meta($post->ID, 'kc_faq_qa', true);
	$faq_about = get_post_meta($post->ID, 'kc_faq_about', true);	
?>
<div id="faq-page">	
	<div id="disc" class="section">		
		<div class="letter">
			<div class="rig">				
				<h2>About Kisses &amp; Curses</h2>
				<div class="block">
					<div class="pic">
						<?php twentyfourteen_post_thumbnail(); ?>
					</div>
					<?php echo wpautop($faq_title_copy); ?>					
				</div>
			</div>
		</div>
	</div>
	<div id="faq" class="section">
		<div class="letter">
			<div class="rig">
				<div class="item">
					<h2>F.A.Q</h2>
					<?php echo wpautop($faq_qa); ?>										
				</div>
			</div>
		</div>
	</div>	
	<div id="volt" class="section">		
		<div class="letter">
			<div class="rig">
				<div class="item">
					<div class="volt"></div>
					<h2>About Voltage Entertainment USA, Inc.</h2>								
					<?php echo wpautop($faq_about); ?>
				</div>
			</div>
		</div>
	</div>	
</div>
<?php
	get_footer();
