<?php 
	/* Template Name: Story */ 
	get_header(); 
?>
<div id="story-page">	
	<div id="story" class="section">		
		<div class="letter">
			<div class="rig">				
				<h2>The Story</h2>
				<ul class="block clearfix">
					<?php 
						$args_story = array( 'post_type' => 'story', 'orderby' => 'date', 'order' => 'ASC', 'posts_per_page' => -1 );
						$q_story = new WP_Query( $args_story );
						if ( $q_story->have_posts() ) :
							
							while ( $q_story->have_posts() ) : $q_story->the_post(); 
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
	<div id="disc" class="section">		
		<div class="letter">
			<div class="rig">
				<div class="item">				
					<ul>
						<?php 
							$args_story = array( 'post_type' => 'story', 'orderby' => 'date', 'order' => 'ASC', 'posts_per_page' => -1 );
							$q_story = new WP_Query( $args_story );
							if ( $q_story->have_posts() ) :
								
								while ( $q_story->have_posts() ) : $q_story->the_post(); 
									$id = get_the_ID();
							?>

									<li data-id="post-<?php echo $id; ?>">
										<?php the_content(); ?>
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
</div>
<?php
	get_footer();
