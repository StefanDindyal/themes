<?php 
	/* Template Name: Main */ 
	get_header();	
	$title_cta = get_post_meta($post->ID, 'kc_title_cta', true);
	$download_quote = get_post_meta($post->ID, 'kc_download_quote', true);
	$download_cta = get_post_meta($post->ID, 'kc_download_cta', true);
	$google_url = get_post_meta($post->ID, 'kc_google_url', true);
	$itunes_url = get_post_meta($post->ID, 'kc_itunes_url', true);
	$signup_url = get_post_meta($post->ID, 'kc_signup_url', true);
	$story_copy = get_post_meta($post->ID, 'kc_story_copy', true);
	$story_link = get_post_meta($post->ID, 'kc_story_link', true);
	$youtube_url = get_post_meta($post->ID, 'kc_youtube_url', true);
	$features_quote = get_post_meta($post->ID, 'kc_features_quote', true);
	$characters_quote = get_post_meta($post->ID, 'kc_characters_quote', true);
	$characters_copy = get_post_meta($post->ID, 'kc_characters_copy', true);
	$characters_link = get_post_meta($post->ID, 'kc_characters_link', true);
?>
<div id="main-page">
	<div id="title-head">
		<?php echo wp_get_attachment_image( $title_cta, 'full' ); ?>
	</div>
	<div id="title-art" class="mob">
		<img src="<?php bloginfo('template_directory'); ?>/images/title-art.jpg" alt="" border="0"/>
	</div>
	<div id="title-art-desk" class="anim">
		<div class="hold">
			<img class="base" src="<?php bloginfo('template_directory'); ?>/images/title-img2.jpg" alt="" border="0"/>
			<img class="blue" src="<?php bloginfo('template_directory'); ?>/images/blue-m.png" alt="" border="0"/>
			<img class="red" src="<?php bloginfo('template_directory'); ?>/images/red-m.png" alt="" border="0"/>
			<img class="orange" src="<?php bloginfo('template_directory'); ?>/images/orange-m.png" alt="" border="0"/>
			<img class="pink" src="<?php bloginfo('template_directory'); ?>/images/pink-m.png" alt="" border="0"/>
			<img class="left" src="<?php bloginfo('template_directory'); ?>/images/fog-left.png" alt="" border="0"/>
			<img class="right" src="<?php bloginfo('template_directory'); ?>/images/fog-right.png" alt="" border="0"/>
			<img class="right-b" src="<?php bloginfo('template_directory'); ?>/images/fog-right-b.png" alt="" border="0"/>
			<img class="border" src="<?php bloginfo('template_directory'); ?>/images/border.png" alt="" border="0"/>
		</div>
	</div>
	<div class="device">
		<div class="rig">
			<?php echo wpautop($download_cta); ?>
			<ul>
				<li class="type android hidetext"><a href="<?php echo $google_url; ?>" target="_blank">Google Play</a></li>
				<li class="type iphone hidetext"><a href="<?php echo $itunes_url; ?>" target="_blank">iTunes App Store</a></li>
				<li class="share hidetext"><a href="#" target="_blank">Share!</a></li>
				<li class="newsletter hidetext"><a href="<?php echo $signup_url; ?>" target="_blank">Signup</a></li>
			</ul>
		</div>
	</div>
	<div id="story" class="section">		
		<div class="letter">
			<div class="seal"></div>
			<div class="rig">				
				<h2>The Story</h2>
				<div class="block clearfix">
					<div class="cell copy">
						<?php echo wpautop($story_copy); ?>
						<a href="<?php echo $story_link; ?>" class="more hidetext">Click For More</a>
					</div>
					<div class="cell video">
						<div class="frame top"></div>
						<div class="frame bottom"></div>
						<?php $embed_code = wp_oembed_get($youtube_url.'&amp;wmode=transparent&amp;autoplay=0&amp;theme=dark&amp;controls=1&amp;autohide=0&amp;loop=0&amp;showinfo=0&amp;rel=0'); ?>
						<?php echo $embed_code; ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="features" class="section">
		<div class="banner apothecary">
			<div class="rig">
				<span>&quot;<?php echo $features_quote; ?>&quot;</span>
			</div>
		</div>
		<div class="letter">
			<div class="rig">
				<div class="seal one"></div>
				<div class="seal two"></div>
				<h2>Key Features</h2>
				<ul>
					<?php 
						$args_features = array( 'post_type' => 'feature', 'orderby' => 'date', 'order' => 'ASC', 'posts_per_page' => 3 );
						$q_features = new WP_Query( $args_features );
						if ( $q_features->have_posts() ) :
							
							while ( $q_features->have_posts() ) : $q_features->the_post(); ?>

								<li>
									<?php the_content( __( '<span>Read More</span>', 'twentyfourteen' ) ); ?>
									<div class="pic">
										<?php twentyfourteen_post_thumbnail(); ?>
									</div>
								</li>

							<?php endwhile;							

						else :
							
							get_template_part( 'content', 'none' );

						endif;
					?>					
				</ul>
			</div>
		</div>
	</div>
	<div id="characters" class="section">
		<div class="banner safe">
			<div class="rig">
				<span>&quot;<?php echo $characters_quote; ?>&quot;</span>
			</div>
		</div>
		<div class="letter">
			<div class="rig">
				<div class="seal one"></div>
				<div class="seal two"></div>
				<h2>Choose Your Companions</h2>
				<div class="copy">
					<?php echo wpautop($characters_copy); ?>
				</div>
				<ul>
					<?php 
						$args_character = array( 'post_type' => 'character', 'orderby' => 'date', 'order' => 'ASC', 'posts_per_page' => 5 );
						$q_character = new WP_Query( $args_character );
						if ( $q_character->have_posts() ) :
							
							while ( $q_character->have_posts() ) : $q_character->the_post(); 
								$id = get_the_ID();
						?>

								<li class="post-<?php echo $id; ?>">
									<a href="<?php bloginfo('url'); ?>/characters/?goto=post-<?php echo $id; ?>"><?php twentyfourteen_post_thumbnail(); ?></a>
								</li>

							<?php endwhile;							

						else :
							
							get_template_part( 'content', 'none' );

						endif;
					?>
				</ul>
				<a href="<?php echo $characters_link; ?>" class="more hidetext">Click For More</a>
			</div>
		</div>
	</div>
	<div id="download" class="section">
		<div class="banner salem">
			<div class="rig">
				<span>&quot;<?php echo $download_quote; ?>&quot;</span>
			</div>
		</div>
		<div class="letter">
			<div class="rig">
				<div class="item">
					<div class="device">
						<div class="logo hidetext"><img src="<?php bloginfo('template_directory'); ?>/images/small-logo.png" alt="<?php bloginfo( 'name' ); ?>" border="0"/></div>
						<?php echo wpautop($download_cta); ?>
						<ul>
							<li class="type android hidetext"><a href="<?php echo $google_url; ?>" target="_blank">Google Play</a></li>
							<li class="type iphone hidetext"><a href="<?php echo $itunes_url; ?>" target="_blank">iTunes App Store</a></li>
							<li class="share hidetext"><a href="#" target="_blank">Share!</a></li>
							<li class="newsletter hidetext"><a href="<?php echo $signup_url; ?>" target="_blank">Signup</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	get_footer();
