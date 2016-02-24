<?php get_header(); 
	$settings = get_option( 'rg_media_options' );	
	$fb = $settings['rg_fb_name'];
	$twtr = $settings['rg_twtr_name'];
	$inst = $settings['rg_inst_name'];
	$mailto = $settings['rg_mailto'];
?>
	<div class="zone sub">
		<div id="homeSlider">
			<?php $args_slider = array( 'post_type' => 'slider', 'posts_per_page' => 4 );
				$q_slider = new WP_Query( $args_slider );
				if ( $q_slider->have_posts() ) :
					while ( $q_slider->have_posts() ) : $q_slider->the_post(); 
						$linkURL = get_post_meta($post->ID, 'rg_link_url', true);
						$linkText = get_post_meta($post->ID, 'rg_link_text', true);
						$target = get_post_meta($post->ID, 'rg_link_target', true);
						$color = get_post_meta($post->ID, 'rg_bg_color', true);
						if($target === on){
							$target = 'target="_blank"';
						} else {
							$target = '';
						}
				?>

						<?php if ( has_post_thumbnail() && ! post_password_required() ) {
								
							$imgSrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slide' );
							$imgSrc = $imgSrc[0];

						} ?>
						<article class="slide" style="background-color: <?php if($color){echo $color;} else {echo '#010101';} ?>; background-image: url('<?php echo $imgSrc; ?>');">							
							<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>								
								<div class="entry-thumbnail">
									<img src="<?php bloginfo('template_directory'); ?>/images/slider-blank.png" alt="" border="0"/>										
								</div>
							<?php endif; ?>
							<div class="hold">
								<div class="row">
									<div class="shell">
										<div class="cell">
											<h1 class="title"><?php the_content(); ?></h1>
											<a href="<?php echo $linkURL; ?>" <?php echo $target; ?>><?php if($linkText){ echo $linkText; } else { echo 'Buy Now'; }?><span>b</span></a>
										</div>
									</div>
								</div>
							</div>
						</article>						
					<?php endwhile;
				endif; 
			wp_reset_postdata(); ?>
		</div>
		<div id="subSlider">			
			<div class="row">
				<?php $args_slider = array( 'post_type' => 'slider', 'posts_per_page' => 4 );
					$index = 0;
					$q_slider = new WP_Query( $args_slider );
					if ( $q_slider->have_posts() ) :
						while ( $q_slider->have_posts() ) : $q_slider->the_post();
							$i = 0;
					?>						
							<article class="slide">
								<a href="#" data-slide-index="<?php echo $index++; ?>">
									<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
										<div class="entry-thumbnail">
											<?php the_post_thumbnail('slide-thumb'); ?>
										</div>
									<?php endif; ?>
									<div class="title"><h1><span>m</span><?php echo ww_limit_title(get_the_title(),16); ?></h1></div>
								</a>
							</article>
						<?php endwhile;
					endif; 
				wp_reset_postdata(); ?>
				<div class="controls">
					<a href="#" class="left">3</a>
					<a href="#" class="right">4</a>				
				</div>
			</div>			
		</div>
	</div>
	<div id="prime" class="clearfix">
		<div class="blur"></div>
		<div class="row">
			<div class="products">
				<?php $args_products = array( 'post_type' => 'rgshop', 'posts_per_page' => 2 );
					$q_products = new WP_Query( $args_products );
					if ( $q_products->have_posts() ) :
						while ( $q_products->have_posts() ) : $q_products->the_post(); 
							get_template_part( 'content', 'products' );
						endwhile;
					endif; 
				wp_reset_postdata(); ?>
			</div>
			<div class="more-prods">
				<a href="/shop" class="weg">view all products</a>
			</div>
			<div class="news clearfix">
				<div class="block">
					<?php $args_news = array( 'category' => 'news', 'posts_per_page' => 1 );
						$q_news = new WP_Query( $args_news );
						if ( $q_news->have_posts() ) :
							while ( $q_news->have_posts() ) : $q_news->the_post(); 
								get_template_part( 'content', get_post_format() );
							endwhile;
						endif; 
					wp_reset_postdata(); ?>
					<a href="/news" class="weg">view all news</a>
				</div>
				<div class="right">
					<div class="social facebook">
						<div class="tab">
							<a href="http://www.facebook.com/<?php echo $fb; ?>" target="_blank"><div class="icon">f</div></a>
						</div>
						<div class="hold clearfix">
							<?php echo do_shortcode('[rg_socialfeed facebook="'.$fb.'" limit="1"]'); ?>
						</div>
					</div>
					<div class="social twitter">
						<div class="tab">
							<a href="http://www.twitter.com/<?php echo $twtr; ?>" target="_blank"><div class="icon">t</div></a>
						</div>
						<div class="hold">
							<?php echo do_shortcode('[rg_socialfeed twitter="'.$twtr.'" limit="1"]'); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="photos">
				<div class="social instagram">
					<div class="tab">
						<a href="http://www.instagram.com/<?php echo $inst; ?>" target="_blank"><div class="icon">i</div></a>
					</div>
					<div class="hold">						
						<?php echo do_shortcode('[rg_socialfeed instagram="'.$inst.'" limit="10"]'); ?>
						<div class="controls">
							<a href="#" class="left">a</a>
							<a href="#" class="right">b</a>
						</div>
					</div>
				</div>
			</div>
			<div class="feedback">
				<h2>Tell us what you think</h2>
				<div class="mailto">
					<a href="mailto:<?php echo $mailto; ?>?subject=Disney Music Emporium Feedback"><span>We’d love to hear from you. Send us your thoughts on the Disney Music Emporium!</span><div class="icon">l</div></a>
				</div>
			</div>			
		</div>
	</div><!-- #primary -->
<?php get_footer(); ?>