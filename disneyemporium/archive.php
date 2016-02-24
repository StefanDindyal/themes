<?php get_header(); ?>
<div class="zone sub">
		<div id="homeSlider">
			<?php $args_slider = array( 'post_type' => 'slider_next', 'posts_per_page' => 4 );
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
				else : ?>
					<div class="fall" style="background-image:url('<?php bloginfo('template_directory'); ?>/images/page-header.jpg');">
						<img src="<?php bloginfo('template_directory'); ?>/images/page-blank.png" alt="" border="0" />
						<div class="row">
							<h1 class="page-title">Shop</h1>			
						</div>
					</div>
				<? endif; 
			wp_reset_postdata(); ?>
		</div>
		<div id="subSlider">			
			<div class="row">
				<?php $args_slider = array( 'post_type' => 'slider_next', 'posts_per_page' => 4 );
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
						<?php endwhile; ?>
					<div class="controls">
						<a href="#" class="left">3</a>
						<a href="#" class="right">4</a>				
					</div>
					<? endif; 
				wp_reset_postdata(); ?>				
			</div>			
		</div>
	</div>	
	<div id="prime" class="shop clearfix">
		<div class="blur"></div>
		<?php 
			$args = array( 'orderby' => 'id', 'order' => 'ASC', 'hide_empty' => true );
			$terms = get_terms('shop_sort', $args);
			if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
			    $count = count($terms);
			    $i=0;
			    if(is_archive()){
			    	$current_tag = single_tag_title("", false);
			    	$term_list = '<div class="sort"><h2>'.$current_tag.' <span class="choose"><span></span></span></h2><ul class="my_term-archive">';
			    } else {
			    	$term_list = '<div class="sort"><h2>Sort By Category <span class="choose"><span></span></span></h2><ul class="my_term-archive">';
			    }
			    foreach ($terms as $term) {
			        $i++;
			    	$term_list .= '<li><a href="' . get_term_link( $term ) . '" title="' . sprintf(__('View all post filed under %s', 'my_localization_domain'), $term->name) . '">' . $term->name . '</a></li>';
			    	if ($count != $i) {
			            $term_list .= '';
			        }
			        else {
			            $term_list .= '</ul></div>';
			        }
			    }
			    echo $term_list;
			}
		?>
		<div class="row">
			<div class="products">
				<?php 
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							get_template_part( 'content', 'products' );
						endwhile;
					endif; 
				?>
			</div>
			<?php number_pagination($q_products->max_num_pages); 
				$settings = get_option( 'rg_media_options' );
				$mailto = $settings['rg_mailto'];
			?>
			<div class="feedback">
				<h2>Tell us what you think</h2>
				<div class="mailto">
					<a href="mailto:<?php echo $mailto; ?>?subject=Disney Music Emporium Feedback"><span>We’d love to hear from you. Send us your thoughts on the Disney Music Emporium!</span><div class="icon">l</div></a>
				</div>
			</div>			
		</div>
	</div>
<?php get_footer(); ?>