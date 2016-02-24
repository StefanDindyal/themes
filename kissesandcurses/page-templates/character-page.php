<?php 
	/* Template Name: Characters */ 
	get_header(); 
?>
<div id="character-page">
	<div id="char-list" class="section">		
		<div class="letter">				
			<h2>Characters</h2>
			<div class="block clearfix">
				<div class="rig">
					<ul>
						<?php 
							$args_character = array( 'post_type' => 'character', 'orderby' => 'date', 'order' => 'ASC', 'posts_per_page' => -1 );
							$q_character = new WP_Query( $args_character );
							if ( $q_character->have_posts() ) :
								
								while ( $q_character->have_posts() ) : $q_character->the_post(); 
									$id = get_the_ID();
							?>

									<li data-id="post-<?php echo $id; ?>">
										<?php twentyfourteen_post_thumbnail(); ?>
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
	</div>
	<div id="char" class="section">		
		<div class="letter">
			<div class="rig">				
				<ul>
					<?php 
						$args_character = array( 'post_type' => 'character', 'orderby' => 'date', 'order' => 'ASC', 'posts_per_page' => -1 );
						$q_character = new WP_Query( $args_character );
						if ( $q_character->have_posts() ) :
							
							while ( $q_character->have_posts() ) : $q_character->the_post(); 
								$id = get_the_ID();
								$character_full = get_post_meta($post->ID, 'kc_character_full', true);
						?>

								<li data-id="post-<?php echo $id; ?>">
									<div class="tab">
										<div class="pol"><?php twentyfourteen_post_thumbnail(); ?></div>
										<div class="inner clearfix">
											<div class="full">
												<?php echo wp_get_attachment_image( $character_full, 'full' ); ?>
											</div>
											<div class="copy">
												<?php the_content(); ?>
											</div>
										</div>
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
</div>
<?php
	get_footer();
