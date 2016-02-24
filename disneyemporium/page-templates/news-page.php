<?php /* Template Name: News Page Template */ get_header(); ?>	
	<div class="zone" style="background-image:url('<?php bloginfo('template_directory'); ?>/images/page-header.jpg');">
		<img src="<?php bloginfo('template_directory'); ?>/images/page-blank.png" alt="" border="0" />
		<div class="row">
			<h1 class="page-title"><?php the_title(); ?></h1>	
		</div>
	</div>
	<div id="prime" class="clearfix">
		<div class="row">			
			<div class="feature">
				<?php $args_news = array( 'category' => 'news', 'posts_per_page' => 1, 'meta_query' => array( array( 'key' => 'rg_news_feat', 'value' => on ) ) );
					$q_news = new WP_Query( $args_news );
					if ( $q_news->have_posts() ) :
						while ( $q_news->have_posts() ) : $q_news->the_post(); 
							$vurl = get_post_meta($post->ID, 'rg_news_vid', true);			
							if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $vurl, $match)) {
								$video_id = $match[1];
								$vid_thumb = 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
							}
							$perm = rawurlencode(get_permalink());
					?>						
								<div class="news clearfix">
									<div class="block">
										<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
											<div class="thumb">
												<?php if ( $vurl ) { ?>			
													<div class="entry-thumbnail" style="background-image:url('<?php echo $vid_thumb; ?>');">
														<img src="<?php bloginfo('template_directory'); ?>/images/480-blank.png" alt="" border="0"/>
														<a href="<?php echo $vurl; ?>" class="play"><span>d</span></a>
													</div>
												<?php } else if ( has_post_thumbnail() ) { ?>
													<div class="entry-thumbnail">
														<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('square'); ?></a>
													</div>
												<?php } ?>
											</div>
											<div class="content">
												<div class="date"><h2><?php the_time('M d') ?></h2></div>
												<div class="scroll">
													<div class="title"><h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1></div>
													<div class="hold">
														<?php the_content(); ?>
													</div>			
												</div>
											</div>			
										</article><!-- #post -->
										<ul class="share clearfix">
											<div class="bg-roll">
												<li><a href="<?php the_permalink(); ?>#comment" class="commenter">c</a></li>
											<li><a href="javascript: void(0)" onClick="window.open('http://www.facebook.com/sharer.php?s=100&p[title]=<?php bloginfo('title'); ?>&p[summary]=<?php the_title(); ?>&p[url]=<?php the_permalink(); ?>&p[images][0]=<?php echo postThumb('square'); ?>','sharer','toolbar=0,status=0,width=580,height=325');">f</a></li>
											<li><a href="javascript: void(0)" onClick="window.open('https://twitter.com/intent/tweet?text=<?php the_title(); ?>&nbsp;<?php the_permalink(); ?>','sharer','toolbar=0,status=0,width=580,height=500');">t</a></li>
											<li><a href="javascript: void(0)" onClick="window.open('http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo postThumb('square'); ?>&amp;description=<?php the_title(); ?>','sharer','toolbar=0,status=0,width=580,height=500');">p</a></li>
											<li><a href="javascript: void(0)" onClick="window.open('http://www.tumblr.com/share/link?url=<?php echo $perm; ?>&amp;name=<?php the_title(); ?>','sharer','toolbar=0,status=0,width=580,height=500');">u</a></li>
											</div>
										</ul>
									</div>
								</div>							
						<?php endwhile;
					endif; 
				wp_reset_postdata(); ?>					
			</div>
			<div class="news clearfix">
				<div class="block">
					<?php 
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;		
						$args_news = array( 'category' => 'news', 'posts_per_page' => 6, 'paged' => $paged );
						$q_news = new WP_Query( $args_news );
						if ( $q_news->have_posts() ) :
							while ( $q_news->have_posts() ) : $q_news->the_post(); 
								get_template_part( 'content', get_post_format() );
							endwhile;
						endif; 
					wp_reset_postdata(); ?>
				</div>
				<?php number_pagination($q_news->max_num_pages); ?>
			</div>			
		</div>
	</div>	
<?php get_footer(); ?>