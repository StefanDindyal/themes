<?php /* Template Name: Videos Page Template */ get_header(); ?>	
	<div class="zone" style="background-image:url('<?php bloginfo('template_directory'); ?>/images/page-header.jpg');">
		<img src="<?php bloginfo('template_directory'); ?>/images/page-blank.png" alt="" border="0" />
		<div class="row">
			<h1 class="page-title"><?php the_title(); ?></h1>			
		</div>
	</div>
	<div id="prime" class="videos clearfix">
		<div class="row">
			<div class="feature">
			<?php 
			$args_videos = array( 'post_type' => 'videos', 'posts_per_page' => 1, 'meta_query' => array( array( 'key' => 'rg_vid_feat', 'value' => on ) ));
			$q_videos = new WP_Query( $args_videos );
			if ( $q_videos->have_posts() ) :			
				while ( $q_videos->have_posts() ) : $q_videos->the_post(); 
					$vurl = get_post_meta($post->ID, 'rg_vid_src', true);			
					if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $vurl, $match)) {
		    			$video_id = $match[1];
		    			$vid_thumb = 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
					}
			?>			
					<article class="post">
						<div class="rits">
							<?php if ( has_post_thumbnail() && ! post_password_required() ) { ?>				
							<div class="entry-thumbnail">
								<?php the_post_thumbnail('video-thumb'); ?>
							</div>				
							<?php } else if($video_id) { ?>				
							<div class="entry-thumbnail loop" style="background-image:url(<?php echo $vid_thumb; ?>);">
								<img src="<?php bloginfo('template_directory'); ?>/images/video-blank.png" width="980" height="550" alt="" border="0"/>
							</div>
							<?php } ?>
							<?php if($vurl){ ?>
								<a href="#" class="play" title="<?php the_title(); ?>" data-video="<?php echo $video_id; ?>"><span>d</span></a>
							<?php } ?>
							<div class="title">
								<?php
									$length = 50;
									$msg = get_the_title();					
									if (strlen($msg) > $length) {

										// truncate string
										$msgCut = substr($msg, 0, $length);

										// make sure it ends in a word so assassinate doesn't become ass...
										$msg = substr($msgCut, 0, strrpos($msgCut, ' ')).' ... '; 
									}
									echo $msg;
								?>
							</div>
						</div>						
						<ul class="share clearfix">
							<div class="bg-roll">
							<?php 
								$title = rawurlencode(get_the_title());
								$title = str_replace("%26%238217%3B", "&rsquo;", $title);
								$perm = rawurlencode(get_permalink());
								$vid_thumb = rawurlencode($vid_thumb);								
							?>					
							<li><a class="window" href="http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo $perm; ?>">f</a></li>
							<li><a class="window" href="https://twitter.com/intent/tweet?text=<?php echo $title; ?> <?php echo $perm; ?>">t</a></li>							
							<li><a class="window" href="http://pinterest.com/pin/create/button/?url=<?php echo $perm; ?>&amp;media=<?php echo $vid_thumb; ?>&amp;description=<?php echo $title; ?>">p</a></li>
							<li><a class="window" href="http://www.tumblr.com/share/link?url=<?php echo $perm; ?>&amp;name=<?php echo $title; ?>">u</a></li>
							</div>
						</ul>			
					</article>
				<?php endwhile;
			else :
				echo '<div class="post"></div>';
			endif; wp_reset_postdata();
			?>	
			</div>
			<ul class="list">
			<?php
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args_videos = array( 'post_type' => 'videos', 'posts_per_page' => 6, 'paged' => $paged );
			$q_videos = new WP_Query( $args_videos );
			if ( $q_videos->have_posts() ) :			
				while ( $q_videos->have_posts() ) : $q_videos->the_post(); 
					$vfeat = get_post_meta($post->ID, 'rg_vid_feat', true);			
					$vurl = get_post_meta($post->ID, 'rg_vid_src', true);			
					if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $vurl, $match)) {
		    			$video_id = $match[1];
		    			$vid_thumb = 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
					} else if(preg_match('/https?:\/\/(?:www\.)?vimeo\.com\/\d{8}/', $vurl, $match)) {
						$vurl = $vurl;
						$video_id = substr(parse_url($vurl, PHP_URL_PATH), 1);
						$hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/'.$video_id.'.php'));
						$vid_thumb = $hash[0]['thumbnail_large'];
					}
					// if($vfeat != 1){
					echo $vfeat;
			?>			
					<li class="post">
						<div class="rits">
						<?php if ( has_post_thumbnail() && ! post_password_required() ) { ?>				
						<div class="entry-thumbnail">
							<?php the_post_thumbnail('video-thumb'); ?>
						</div>				
						<?php } else if($video_id) { ?>				
						<div class="entry-thumbnail loop" style="background-image:url(<?php echo $vid_thumb; ?>);">
							<img src="<?php bloginfo('template_directory'); ?>/images/video-blank.png" width="980" height="550" alt="" border="0"/>
						</div>
						<?php } ?>
						<?php if($vurl){ ?>
							<a href="#" class="play" title="<?php the_title(); ?>" data-video="<?php echo $video_id; ?>"><span>d</span></a>
						<?php } ?>
						<div class="title">
							<?php
								$length = 44;
								$msg = get_the_title();					
								if (strlen($msg) > $length) {

									// truncate string
									$msgCut = substr($msg, 0, $length);

									// make sure it ends in a word so assassinate doesn't become ass...
									$msg = substr($msgCut, 0, strrpos($msgCut, ' ')).' ... '; 
								}
								echo $msg;
							?>
						</div>
						</div>						
						<ul class="share clearfix">
							<div class="bg-roll">
							<?php
								$title = rawurlencode(get_the_title());
								$title = str_replace("%26%238217%3B", "&rsquo;", $title);
								$perm = rawurlencode(get_permalink());
								$vid_thumb = rawurlencode($vid_thumb);
							?>					
							<li><a class="window" href="http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo $perm; ?>">f</a></li>
							<li><a class="window" href="https://twitter.com/intent/tweet?text=<?php echo $title; ?> <?php echo $perm; ?>">t</a></li>							
							<li><a class="window" href="http://pinterest.com/pin/create/button/?url=<?php echo $perm; ?>&amp;media=<?php echo $vid_thumb; ?>&amp;description=<?php echo $title; ?>">p</a></li>
							<li><a class="window" href="http://www.tumblr.com/share/link?url=<?php echo $perm; ?>&amp;name=<?php echo $title; ?>">u</a></li>
							</div>
						</ul>
					</li>
				<?php 
				// } 
				endwhile;		
			endif; wp_reset_postdata(); 
			?>
			</ul>			
			<?php number_pagination($q_videos->max_num_pages); ?>			
		</div>
	</div>	
<?php get_footer(); ?>