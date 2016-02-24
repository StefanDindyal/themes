<?php get_header(); ?>
<div id="news-page">
	<div id="news" class="section">		
		<div class="letter">				
			<h2>What's New?</h2>
			<div class="block clearfix">
				<div class="posts">
					<?php						
						if ( have_posts() ) :
							// Start the Loop.
							while ( have_posts() ) : the_post();

								/*
								 * Include the post format-specific template for the content. If you want to
								 * use this in a child theme, then include a file called called content-___.php
								 * (where ___ is the post format) and that will be used instead.
								 */
								get_template_part( 'content', get_post_format() );

							endwhile;
							// Previous/next post navigation.
							// $q_news->twentyfourteen_paging_nav();

							$big = 999999999; // need an unlikely integer
							echo '<div class="pager">';
								echo paginate_links( array(
									'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
									'format' => '?paged=%#%',
									'current' => max( 1, get_query_var('paged') ),
									'total' => $wp_query->max_num_pages,
									'prev_text' => __('« Prev'),
									'next_text' => __('Next »')
								) );
							echo '</div>';

						else :
							// If no content, include the "No posts found" template.
							get_template_part( 'content', 'none' );

						endif;
					?>
				</div>
				<div class="side">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>	
</div>
<?php
	get_footer();
