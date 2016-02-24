<?php 
	global $store_name, $keyID, $host, $version, $expires, $instances, $tracks;
	$plist = get_post_meta($post->ID, 'rg_plist', true);
	$albumID = get_post_meta($post->ID, 'rg_select_shop', true);
	$avail = get_post_meta($post->ID, 'rg_item_avail', true);	
	$sold_out = get_post_meta($post->ID, 'rg_item_sold_out', true);	
	$preorder_text = get_post_meta($post->ID, 'rg_preorder_text', true);	
?>
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
											<a href="<?php the_permalink(); ?>"><img src="<?php echo $img; ?>" alt="" border="0"/></a>
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
											<a href="<?php the_permalink(); ?>"><img src="<?php echo $img; ?>" alt="" border="0"/></a>
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
		<div class="contents">
			<div class="in">
			<div class="cell">
			<div class="copy">
				<?php
					if(is_page( 'shop' ) || is_archive()){
						$length = 164;
					} else {
						$length = 326;
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
			<div class="more">
				<a href="<?php the_permalink(); ?>">Learn More</a>
			</div>
			<?php 
				$perm = rawurlencode(get_permalink());
			?>
			<ul class="share clearfix">
				<li><a href="<?php the_permalink(); ?>#comment" class="commenter">c</a></li>
				<li><a class="window" href="http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo $perm; ?>">f</a></li>
				<li><a class="window" href="https://twitter.com/intent/tweet?text=<?php echo $title; ?> <?php echo $perm; ?>">t</a></li>							
				<li><a class="window" href="http://pinterest.com/pin/create/button/?url=<?php echo $perm; ?>&amp;media=<?php echo $vid_thumb; ?>&amp;description=<?php echo $title; ?>">p</a></li>
				<li><a class="window" href="http://www.tumblr.com/share/link?url=<?php echo $perm; ?>&amp;name=<?php echo $title; ?>">u</a></li>
			</ul>
			<div class="tags">				
				<?php echo custom_taxonomies_terms_links(); ?>
			</div>
			</div>
			</div>
		</div>		
		<a href="#" class="view"><span>2</span></a>
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

				    // $results['stock_info'][0]['summary'];
				    
				    ?>

				    	<div class="left">
				    		<?php if(is_single()){ ?>
				    			<div class="title"><?php the_title(); ?></div>
				    		<?php } else { ?>
				    			<div class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
				    		<?php } ?>
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
</article>