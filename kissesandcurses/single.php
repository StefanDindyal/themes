<?php get_header(); ?>
<div id="news-page">
	<div id="news" class="section">		
		<div class="letter">				
			<h2>What's New?</h2>
			<div class="block clearfix">
				<div class="posts">
					<?php
						// Start the Loop.
						while ( have_posts() ) : the_post();

							/*
							 * Include the post format-specific template for the content. If you want to
							 * use this in a child theme, then include a file called called content-___.php
							 * (where ___ is the post format) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );

						endwhile;
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
