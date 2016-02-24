<?php 
	$vurl = get_post_meta($post->ID, 'rg_news_vid', true);			
	if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $vurl, $match)) {
		$video_id = $match[1];
		$vid_thumb = 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
	}
	$title = get_the_title();
?>
	<?php 
	$perm = rawurlencode(get_permalink());
	if ( is_single() ) { ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="thumb">
				<?php if ( $vurl ) { ?>			
					<div class="entry-thumbnail" style="background-image:url('<?php echo $vid_thumb; ?>');">
						<img src="<?php bloginfo('template_directory'); ?>/images/news-single-blank.png" alt="" border="0"/>
						<a href="<?php echo $vurl; ?>" class="play"><span>d</span></a>
					</div>
				<?php } else if ( has_post_thumbnail() ) { ?>
					<div class="entry-thumbnail">
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('rec'); ?></a>
					</div>
				<?php } ?>
			</div>
			<div class="content">
				<div class="date"><h2><?php the_time('M d') ?></h2></div>
				<div class="title"><h1><?php the_title(); ?></h1></div>
				<div class="hold">
					<?php the_content(); ?>
				</div>			
			</div>			
		</article><!-- #post -->		
	<?php } else { ?>
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
				<div class="title"><a href="<?php the_permalink(); ?>"><h1>
					<?php 
						if(has_post_thumbnail() || $vid_thumb){
							$length = 26;
						} else {
							$length = 999;
						}
						$msg = get_the_title();					
						if (strlen($msg) > $length) {

							// truncate string
							$msgCut = substr($msg, 0, $length);

							// make sure it ends in a word so assassinate doesn't become ass...
							$msg = substr($msgCut, 0, strrpos($msgCut, ' ')).' ... '; 
						}
						echo $msg;
					?>				
				</h1></a></div>
				<div class="hold">
					<?php
						if(has_post_thumbnail() || $vid_thumb){
							$length = 70;
						} else {
							$length = 220;
						}
						$msg = get_the_excerpt();					
						if (strlen($msg) > $length) {

							// truncate string
							$msgCut = substr($msg, 0, $length);

							// make sure it ends in a word so assassinate doesn't become ass...
							$msg = substr($msgCut, 0, strrpos($msgCut, ' ')).' ... <a href="'.get_permalink().'" class="read-more">b</a>'; 
						}
						echo $msg;
					?>
				</div>
				<ul class="share clearfix">
					<li><a href="<?php the_permalink(); ?>#comment" class="commenter">c</a></li>
					<li><a class="window" href="http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo $perm; ?>">f</a></li>
					<li><a class="window" href="https://twitter.com/intent/tweet?text=<?php echo $title; ?> <?php echo $perm; ?>">t</a></li>							
					<li><a class="window" href="http://pinterest.com/pin/create/button/?url=<?php echo $perm; ?>&amp;media=<?php echo $vid_thumb; ?>&amp;description=<?php echo $title; ?>">p</a></li>
					<li><a class="window" href="http://www.tumblr.com/share/link?url=<?php echo $perm; ?>&amp;name=<?php echo $title; ?>">u</a></li>
				</ul>
			</div>
		</article><!-- #post -->
	<?php } // is_single() ?>	