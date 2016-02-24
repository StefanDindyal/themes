<?php

$settings = get_option( 'rg_media_options' );	
$fb = $settings['rg_fb_name'];
$twtr = $settings['rg_twtr_name'];
$inst = $settings['rg_inst_name'];
$mailto = $settings['rg_mailto'];

global $store_name, $keyID, $host, $version, $expires, $instances, $tracks;

get_header(); ?>

<?php if('rgshop' == get_post_type()){ ?>
	<?php $color = get_post_meta($post->ID, 'rg_bg_color', true); ?>
	<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="zone" style="background-color: <?php if($color){echo $color;} else {echo '#010101';} ?>;">		
			<?php 
				$imgSrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slide' );
				$imgSrc = $imgSrc[0];
			?>
			<div class="entry-thumbnail" style="background-image: url('<?php echo $imgSrc; ?>');">
				<img src="<?php bloginfo('template_directory'); ?>/images/single-blank.png" alt="" border="0"/>
			</div>		
		</div>
	<?php else : ?>
		<div class="zone" style="background-image:url('<?php bloginfo('template_directory'); ?>/images/page-header.jpg');">
			<img src="<?php bloginfo('template_directory'); ?>/images/page-blank.png" alt="" border="0" />
			<div class="row">
				<h1 class="page-title">Shop</h1>	
			</div>
		</div>
	<?php endif; ?>
	<div id="prime" class="clearfix">
		<div class="blur"></div>
		<div class="row">
			<?php while ( have_posts() ) : the_post(); ?>
					<?php 
						global $store_name, $keyID, $host, $version, $expires, $instances, $tracks;
						$plist = get_post_meta($post->ID, 'rg_plist', true);
						$inst = get_post_meta($post->ID, 'rg_inst_tag', true);
						$instcopy = get_post_meta($post->ID, 'rg_inst_copy', true);
						$vurl = get_post_meta($post->ID, 'rg_yt_url', true);
						$sc = get_post_meta($post->ID, 'rg_sc_url', true);	
						$albumID = get_post_meta($post->ID, 'rg_select_shop', true);
						$avail = get_post_meta($post->ID, 'rg_item_avail', true);
						$sold_out = get_post_meta($post->ID, 'rg_item_sold_out', true);	
						$preorder_text = get_post_meta($post->ID, 'rg_preorder_text', true);	
						$no_comments = get_post_meta($post->ID, 'rg_no_comments', true);	
					?>
			<div class="products">
					<article class="product">
						<div class="hold">
							<div class="slider">
								<?php									
									if(is_array($plist)){ ?>									
										<ul class="target">
											<?php $i = 0; foreach($plist as $item) { ?>
												<?php if($item){ ?>
													<li class="slide">
														<?php if($item['popt'] == true){ 
																$img = wp_get_attachment_image_src( $item['pimg'], 'square' );
																$img = $img[0];
															?>
															<?php if($item['pvid']){  
																if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $item['pvid'], $match)) {
									    								$video_id = $match[1];
									    								$vid_thumb = 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
																}
															?>
																<?php if($img){ ?>
																	<img src="<?php echo $img; ?>" alt="" border="0"/>
																	<a href="<?php echo $item['pvid']; ?>" class="play"><span>d</span></a>
																<?php } else { ?>
																	<div class="vid-thumb" style="background-image:url('<?php echo $vid_thumb; ?>');"><img src="<?php bloginfo('template_directory'); ?>/images/480-blank.png" alt="" border="0"/></div>
																	<a href="<?php echo $item['pvid']; ?>" class="play"><span>d</span></a>
																<?php } ?>
															<?php } elseif($item['pimg']){ 
																	$img = wp_get_attachment_image_src( $item['pimg'], 'square' );
																	$img = $img[0];
																?>
																<img src="<?php echo $img; ?>" alt="" border="0"/>
															<?php } ?>
														<?php } else { ?>
															<?php if($item['pvid']){  
																if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $item['pvid'], $match)) {
									    								$video_id = $match[1];
									    								$vid_thumb = 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
																}
															?>
																<div class="vid-thumb" style="background-image:url('<?php echo $vid_thumb; ?>');"><img src="<?php bloginfo('template_directory'); ?>/images/480-blank.png" alt="" border="0"/></div>
																<a href="<?php echo $item['pvid']; ?>" class="play"><span>d</span></a>
															<?php } elseif($item['pimg']){ 
																	$img = wp_get_attachment_image_src( $item['pimg'], 'square' );
																	$img = $img[0];
																?>
																<img src="<?php echo $img; ?>" alt="" border="0"/>
															<?php } ?>
														<?php } ?>
													</li>
												<?php } ?>
											<?php } ?>
										</ul>				
								<?php } else { ?>
									<img src="<?php bloginfo('template_directory'); ?>/images/480-blank.png" alt="" border="0"/>
								<?php } ?>
							</div>							
						</div>
						<div class="con-block">
							<div class="contents">								
								<div class="scroll">
									<div class="hold">
										<?php the_content(); ?>
									</div>
								</div>								
							</div>
							<div class="buy-block">
								<?php 			
									if($albumID){
										$productAPI = 'http://'.$host.'/'.$store_name.'/'.$version.'/products/'.$albumID.'.json?key='.$keyID.'&amp;graphic_size=590x590';				
				
										$tName = 'rg_album_'.$albumID;
      									$tab = json_decode(_m2getData($productAPI, $tName), true);
										
										if( empty($tab) ){
										   // return;
										} else {
											$results = $tab['results'][0]; 
										    $instances = $results['instances'];
										    $tracks = $results['tracks']; 				    	
										    $purchaseable = $results['stock_info'][0]['purchaseable'];
										    ?>

										    	<div class="left">
										    		<div class="title"><?php the_title(); ?></div>
										    		<div class="avail">
										    			<?php
										    				if($preorder_text){
										    					echo '<span>'.$preorder_text.'</span>';	
										    				} else {
										    					echo '<span>Available Now</span>';
										    				}					    			
										    			?>
										    		</div>
										    	</div>
										    	<?php if($preorder_text){ ?>
										    		<div class="buy"><div class="icon">1</div><div class="txt">Pre-Order</div></div>
										    	<?php } else { ?>
										    		<div class="buy"><div class="icon">1</div><div class="txt">Buy Now</div></div>
										    	<?php } ?>
										    	<?php if($instances){ ?>
										    	<?php  echo instanceLoop(); ?>
											    <?php } else {
											    	if($purchaseable == true || $purchaseable == 1){
											    		echo '<div class="instances"><div class="inner"><div class="instance" item-id="'.$results['id'].'">';

											    			echo '<div class="left"><div class="top"><span class="'.$results['type'].'-type type">'.$results['title'].'</span></div>';
														
															echo '<div class="bottom"><span class="'.$results['type'].'-price price">'.str_replace(',', '.', $results['pricing']['display']).'</span> <span class="summary">'.$results['stock_info'][0]['summary'].'</span></div></div>';
															echo '<div class="add product_add" item-id="'.$results['id'].'"><div class="icon">1</div><div class="txt">Add To Cart</div><div class="txt added">In Cart</div></div>';
														echo '</div></div></div>';
											    	} else {
											    		echo '<div class="instances"><div class="inner"><div class="instance soldout" item-id="'.$results['id'].'">';

											    			echo '<div class="left"><div class="top"><span class="'.$results['type'].'-type type">'.$results['title'].'</span></div>';
														
															echo '<div class="bottom"><span class="'.$results['type'].'-price price">'.str_replace(',', '.', $results['pricing']['display']).'</span> <span class="summary">Sold Out</span></div></div>';
															echo '<div class="add product_add soldout" item-id="'.$results['id'].'"><div class="icon">1</div><div class="txt">Sold Out</div><div class="txt added">In Cart</div></div>';
														echo '</div></div></div>';
											    	}
											    } ?>
										<?php }//else
									} else { ?>
												<div class="left">
										    		<div class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
										    		<div class="avail">
										    			<span>&nbsp;</span>
										    		</div>
										    	</div>				    	
									<?php }
								?>
							</div>
						</div>						
					</article>					
			</div>
			<?php 
				$perm = rawurlencode(get_permalink());
			?>
			<ul class="share clearfix">
				<div class="bg-roll">
				<li><a href="<?php the_permalink(); ?>#comment" class="commenter">c</a></li>
				<li><a class="window" href="http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo $perm; ?>">f</a></li>
				<li><a class="window" href="https://twitter.com/intent/tweet?text=<?php echo $title; ?> <?php echo $perm; ?>">t</a></li>							
				<li><a class="window" href="http://pinterest.com/pin/create/button/?url=<?php echo $perm; ?>&amp;media=<?php echo $vid_thumb; ?>&amp;description=<?php echo $title; ?>">p</a></li>
				<li><a class="window" href="http://www.tumblr.com/share/link?url=<?php echo $perm; ?>&amp;name=<?php echo $title; ?>">u</a></li>
				</div>
			</ul>
			<?php if($sc || $vurl){ ?>
			<div class="videos clearfix">
				<?php if($sc){ ?>				
				<div class="sound <?php if($vurl){echo 'yes-vid';}else{echo 'no-vid';} ?>">
					<div class="social music">
						<div class="tab">
							<div class="icon">9</div>
						</div>
						<div class="hold" data-url="<?php echo $sc; ?>">						
							<ul class="tracks"></ul>
							<div class="controls">
								<a href="#" class="left"></a>
								<a href="#" class="start"><span class="in"><span>g</span></span></a>
								<a href="#" class="right"></a>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<?php if($vurl){ ?>
				<ul class="list <?php if($sc){echo 'yes-sc';}else{echo 'no-sc';} ?>">
				<?php 												
					if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $vurl, $match)) {
		    			$video_id = $match[1];
		    			$vid_thumb = 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
					} else if(preg_match('/https?:\/\/(?:www\.)?vimeo\.com\/\d{8}/', $vurl, $match)) {
						$vurl = $vurl;
						$video_id = substr(parse_url($vurl, PHP_URL_PATH), 1);
						$hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/'.$video_id.'.php'));
						$vid_thumb = $hash[0]['thumbnail_large'];
					}					
				?>			
					<li class="post">
						<div class="rits">
						<?php if($video_id) { ?>				
						<div class="entry-thumbnail loop" style="background-image:url(<?php echo $vid_thumb; ?>);">
							<img src="<?php bloginfo('template_directory'); ?>/images/video-blank.png" width="980" height="550" alt="" border="0"/>
						</div>
						<?php } ?>
						<?php if($vurl){ ?>
							<a href="<?php echo $vurl; ?>" class="play"><span>d</span></a>
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
					</li>				
				</ul>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if($instcopy || $inst){ ?>
			<div class="clearfix">
				<div class="inst-copy">
					<?php 
					if($instcopy){ echo $instcopy; } 
					if($inst){ echo ' <span>#'.$inst.'</span>'; }
					?>
				</div>
			</div>
			<?php } ?>
			<?php if($inst){ ?>
			<script type="text/javascript">				
				function imgError(image) {
				    image.onerror = "";
				    image.parentNode.parentNode.className += ' hidden';
				    return true;
				}				
			</script>
			<div class="photos">
				<div class="social instagram">
					<div class="tab">
						<div class="icon">i</div>
					</div>
					<div class="hold">						
						<?php echo do_shortcode('[rg_socialfeed instagramtag="'.$inst.'" limit="10"]'); ?>
						<div class="controls">
							<a href="#" class="left">a</a>
							<a href="#" class="right">b</a>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>			
			<?php endwhile; ?>	
			<div class="feedback">
				<h2>Tell us what you think</h2>
				<div class="mailto">
					<a href="mailto:<?php echo $mailto; ?>?subject=Disney Music Emporium Feedback"><span>We’d love to hear from you. Send us your thoughts on the Disney Music Emporium!</span><div class="icon">l</div></a>
				</div>
			</div>			
			<div id="comment" class="comments">				
				<?php if($no_comments === 0 || $no_comments === false || $no_comments === ''){ ?>
					<h2><span>What fans are saying</span></h2>
					<div class="hold">
						<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="770" data-numposts="4" data-colorscheme="light"></div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>	
<?php } else if(in_category('news')){ ?>
	<div class="zone" style="background-image:url('<?php bloginfo('template_directory'); ?>/images/page-header.jpg');">
		<img src="<?php bloginfo('template_directory'); ?>/images/page-blank.png" alt="" border="0" />
		<div class="row">
			<h1 class="page-title">News</h1>
		</div>
	</div>
	<div id="prime" class="clearfix">
		<div class="row">		
			<div class="news clearfix">
				<div class="block">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', get_post_format() ); ?>						

					<?php endwhile; 
						$perm = rawurlencode(get_permalink());
					?>
				</div>
				<ul class="share clearfix">
					<div class="bg-roll">
					<li><a href="<?php the_permalink(); ?>#comment" class="commenter">c</a></li>
					<li><a class="window" href="http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo $perm; ?>">f</a></li>
					<li><a class="window" href="https://twitter.com/intent/tweet?text=<?php echo $title; ?> <?php echo $perm; ?>">t</a></li>							
					<li><a class="window" href="http://pinterest.com/pin/create/button/?url=<?php echo $perm; ?>&amp;media=<?php echo $vid_thumb; ?>&amp;description=<?php echo $title; ?>">p</a></li>
					<li><a class="window" href="http://www.tumblr.com/share/link?url=<?php echo $perm; ?>&amp;name=<?php echo $title; ?>">u</a></li>
					</div>
				</ul>			
			</div>			

			<div id="comment" class="comments">
				<?php if($no_comments === 0 || $no_comments === false){ ?>
					<h2><span>What fans are saying</span></h2>
					<div class="hold">
						<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="770" data-numposts="4" data-colorscheme="light"></div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } else if('videos' == get_post_type()){ ?>	
	<div class="zone" style="background-image:url('<?php bloginfo('template_directory'); ?>/images/page-header.jpg');">
		<img src="<?php bloginfo('template_directory'); ?>/images/page-blank.png" alt="" border="0" />
		<div class="row">
			<h1 class="page-title">Videos</h1>
		</div>
	</div>
	<div id="prime" class="videos clearfix">
		<div class="row">
			<div class="feature">
			<?php 			
				while ( have_posts() ) : the_post(); 
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
								$title = str_replace('%26%238211%3B', '-', $title);
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
				<?php endwhile;	?>	
			</div>
		</div>
	</div>		
<?php } else {


} ?>
<?php get_footer(); ?>