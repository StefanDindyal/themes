<?php /* Template Name: Legacy Page Template */ get_header(); 
	$color = get_post_meta($post->ID, 'rg_bg_color', true);
	$term = get_post_meta($post->ID, 'rg_term', true);
?>
	<div class="zone sub">
		<div id="homeSlider">
			<?php if ( has_post_thumbnail() && ! post_password_required() ) {
								
				$imgSrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slide' );
				$imgSrc = $imgSrc[0];

			} ?>
			<article class="slide" style="background-color: <?php if($color){echo $color;} else {echo '#010101';} ?>; background-image: url('<?php echo $imgSrc; ?>');">							
				<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>								
					<div class="entry-thumbnail">
						<img src="<?php bloginfo('template_directory'); ?>/images/thin-header.png" alt="" border="0"/>										
					</div>
				<?php endif; ?>
			</article>
		</div>		
	</div>	
	<div id="legacy-copy">
		<div class="row">
			<div class="int">
				<div class="title"><?php the_title(); ?></div>
				<div class="contents"><?php the_content(); ?></div>
			</div>
		</div>
	</div>
	<div id="prime" class="shop clearfix">
		<div class="blur"></div>		
		<div class="row">
			<div class="products">
				<?php					
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;		
					$args_products = array( 'post_type' => 'rgshop', 'tax_query' => array(
						array(
							'taxonomy' => 'shop_sort',
							'field'    => 'slug',
							'terms'    => $term,
						),
					), 'posts_per_page' => 12, 'paged' => $paged );
					$q_products = new WP_Query( $args_products );
					if ( $q_products->have_posts() ) :
						while ( $q_products->have_posts() ) : $q_products->the_post(); 
							get_template_part( 'content', 'products' );							
						endwhile;
					endif; 
				wp_reset_postdata(); ?>
			</div>
			<?php //number_pagination($q_products->max_num_pages); 
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