<?php
/* Template Name: Home Page */
get_header();
$settings = get_option( 'mid_options' );
$featurea = $settings['mid_feature_a'];
$featureb = $settings['mid_feature_b'];
$featurec = $settings['mid_feature_c'];
$featured = $settings['mid_feature_d'];
$aboutpre = $settings['mid_about_pre'];
$aboutleft = $settings['mid_about_left'];
$aboutright = $settings['mid_about_right'];
$aboutimage = $settings['mid_about_image'];
$prinimagea = $settings['mid_prin_imagea'];
$prinimageb = $settings['mid_prin_imageb'];
$contactheading = $settings['mid_heading'];
$contactlocation = $settings['mid_location'];
$footerprivacy = $settings['mid_privacy'];
$footerrite = $settings['mid_copyrite'];
?>

	<div id="main">

		<section id="feature">
			<div class="contents">
				<?php 					
					$args_props = array( 'post_type' => 'hero', 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => 1 );
					$q_props = new WP_Query( $args_props );
					if ( $q_props->have_posts() ) :
						$properties = array();																		
						while ( $q_props->have_posts() ) : $q_props->the_post(); 
							$id = get_the_ID();
							$text = get_post_meta($id, 'hero_text', true);
							$url = get_post_meta($id, 'hero_url', true);
							$target = get_post_meta($id, 'hero_tab', true);
							$full_img = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full' );
							$full_img = $full_img[0];
					?>
					<div class="hero" style="background-image: url(<?php echo $full_img; ?>);">
						<div class="film"></div>
						<div class="grad"></div>
						<div class="copy">
							<div class="inner">
								<?php the_content(); ?>
								<?php if($url && $text){ ?>
									<div class="cta">										
										<?php if($target === 1 || $target === true || $target == 'on'){ ?>
											<a href="<?php echo $url; ?>" target="_blank"><?php echo $text; ?></a>
										<?php } else { ?>
											<a href="<?php echo $url; ?>"><?php echo $text; ?></a>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						</div>					
					</div>
				<?php
						endwhile; wp_reset_postdata();
						
					else :											
						// get_template_part( 'content', 'none' );
					endif; 
				?>
				<?php if($featurea && $featureb){ ?>			
				<div class="properties">
					<?php if($featurea){
					$id = $featurea[0];
					$city = get_post_meta($id, 'prop_city', true);
					$units = get_post_meta($id, 'prop_units', true);
					$small_img = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'prop-small' );
					$small_img = $small_img[0];
					$full_img = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full' );
					$full_img = $full_img[0];
					$terms = get_the_terms( $id, 'states' );
					$content_post = get_post($id);
					$content = $content_post->post_content;
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					$content = strip_tags($content);				
					if ( !empty( $terms ) ){
						// get the first term
						$term = array_shift( $terms );
					} else {
						$term = '';
					} ?>
						<div class="prop a" style="background-image: url(<?php echo $small_img; ?>);" data-limg="<?php echo $full_img; ?>" data-content="<?php echo $content; ?>" data-city="<?php echo $city; ?>" data-state="<?php echo $term->slug; ?>" data-units="<?php echo $units; ?>" data-title="<?php echo get_the_title($id); ?>">
							<div class="film"></div>
							<div class="grad"></div>
							<div class="copy">
								<h2 class="title"><?php echo get_the_title($id); ?></h2>
								<p><?php echo $content; ?></p>
							</div>
						</div>
					<?php } ?>
					<?php if($featureb){
					$id = $featureb[0];
					$city = get_post_meta($id, 'prop_city', true);
					$units = get_post_meta($id, 'prop_units', true);
					$small_img = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'prop-small' );
					$small_img = $small_img[0];
					$full_img = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full' );
					$full_img = $full_img[0];
					$terms = get_the_terms( $id, 'states' );
					$content_post = get_post($id);
					$content = $content_post->post_content;
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					$content = strip_tags($content);				
					if ( !empty( $terms ) ){
						// get the first term
						$term = array_shift( $terms );
					} else {
						$term = '';
					} ?>
						<div class="prop b" style="background-image: url(<?php echo $small_img; ?>);" data-limg="<?php echo $full_img; ?>" data-content="<?php echo $content; ?>" data-city="<?php echo $city; ?>" data-state="<?php echo $term->slug; ?>" data-units="<?php echo $units; ?>" data-title="<?php echo get_the_title($id); ?>">
							<div class="film"></div>
							<div class="grad"></div>
							<div class="copy">
								<h2 class="title"><?php echo get_the_title($id); ?></h2>
								<p><?php echo $content; ?></p>
							</div>
						</div>
					<?php } ?>
					<?php if($featurec){
					$id = $featurec[0];
					$city = get_post_meta($id, 'prop_city', true);
					$units = get_post_meta($id, 'prop_units', true);
					$small_img = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'prop-small' );
					$small_img = $small_img[0];
					$full_img = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full' );
					$full_img = $full_img[0];
					$terms = get_the_terms( $id, 'states' );
					$content_post = get_post($id);
					$content = $content_post->post_content;
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					$content = strip_tags($content);				
					if ( !empty( $terms ) ){
						// get the first term
						$term = array_shift( $terms );
					} else {
						$term = '';
					} ?>
						<div class="prop c" style="background-image: url(<?php echo $small_img; ?>);" data-limg="<?php echo $full_img; ?>" data-content="<?php echo $content; ?>" data-city="<?php echo $city; ?>" data-state="<?php echo $term->slug; ?>" data-units="<?php echo $units; ?>" data-title="<?php echo get_the_title($id); ?>">
							<div class="film"></div>
							<div class="grad"></div>
							<div class="copy">
								<h2 class="title"><?php echo get_the_title($id); ?></h2>
								<p><?php echo $content; ?></p>
							</div>
						</div>
					<?php } ?>
					<?php if($featured){
					$id = $featured[0];
					$city = get_post_meta($id, 'prop_city', true);
					$units = get_post_meta($id, 'prop_units', true);
					$small_img = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'prop-small' );
					$small_img = $small_img[0];
					$full_img = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full' );
					$full_img = $full_img[0];
					$terms = get_the_terms( $id, 'states' );
					$content_post = get_post($id);
					$content = $content_post->post_content;
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					$content = strip_tags($content);				
					if ( !empty( $terms ) ){
						// get the first term
						$term = array_shift( $terms );
					} else {
						$term = '';
					} ?>
						<div class="prop d" style="background-image: url(<?php echo $small_img; ?>);" data-limg="<?php echo $full_img; ?>" data-content="<?php echo $content; ?>" data-city="<?php echo $city; ?>" data-state="<?php echo $term->slug; ?>" data-units="<?php echo $units; ?>" data-title="<?php echo get_the_title($id); ?>">
							<div class="film"></div>
							<div class="grad"></div>
							<div class="copy">
								<h2 class="title"><?php echo get_the_title($id); ?></h2>
								<p><?php echo $content; ?></p>
							</div>
						</div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
		</section>

		<section id="about">
			<h2 class="title">About Us</h2>
			<div class="contents">
				<?php if($aboutimage){ 
					$aboutimage = wp_get_attachment_image_src( $aboutimage, 'full' );
					$aboutimage = $aboutimage[0]; ?>
					<div class="img" style="background-image: url(<?php echo $aboutimage; ?>);"/></div>
				<?php } ?>				
				<div class="copy">
					<h3 class="upper">
						<?php if($aboutpre){ 
							echo $aboutpre;
						} ?>
					</h3>
					<div class="lower">						
						<div class="block a">
							<?php if($aboutleft){ 
								echo $aboutleft;
							} ?>
						</div>
						<div class="block b">
							<?php if($aboutright){ 
								echo $aboutright;
							} ?>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section id="properties">
			<h2 class="title">Properties</h2>
			<div class="contents clearfix">				
				<div class="selector">
					<div class="fields">
						<div class="drop">
							<span data-state="all">Choose State</span>
							<div class="under">
								<?php 
								//list terms in a given taxonomy using wp_list_categories (also useful as a widget if using a PHP Code plugin)

								$taxonomy     = 'states';
								$orderby      = 'name'; 
								$show_count   = 0;      // 1 for yes, 0 for no
								$pad_counts   = 0;      // 1 for yes, 0 for no
								$hierarchical = 1;      // 1 for yes, 0 for no
								$title        = '';

								$args = array(
								  'taxonomy'     => $taxonomy,
								  'orderby'      => $orderby,
								  'show_count'   => $show_count,
								  'pad_counts'   => $pad_counts,
								  'hierarchical' => $hierarchical,
								  'title_li'     => $title
								);
								?>
								<ul>
									<?php 
										$tags = get_categories($args);
										$mapColor = '{';
										foreach($tags as $tag){
											echo '<li data-id="'.$tag->slug.'">'.$tag->name.'</li>';
											$mapColor .= '\''.strtoupper($tag->slug).'\': {fill: \'white\'},';
										}
										$mapColor .= '}';										
									 ?>
								</ul>
							</div>
						</div>
						<div class="view usa">View</div>
					</div>
				</div>				
				<?php 
					echo '<script type="text/javascript">var mapColor = '.$mapColor.';</script>';
					$args_props = array( 'post_type' => 'properties', 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => -1 );
					$q_props = new WP_Query( $args_props );
					if ( $q_props->have_posts() ) :
						$properties = array();																		
						while ( $q_props->have_posts() ) : $q_props->the_post(); 
							$id = get_the_ID();
							$city = get_post_meta($id, 'prop_city', true);
							$units = get_post_meta($id, 'prop_units', true);
							$small_img = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'prop-small' );
							$small_img = $small_img[0];
							$full_img = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full' );
							$full_img = $full_img[0];
							$terms = get_the_terms( $id, 'states' );
							if ( !empty( $terms ) ){
								// get the first term
								$term = array_shift( $terms );
							} else {
								$term = '';
							}					
							$properties[] = array(
						    	'title' => get_the_title(),
						    	'desc' => get_the_content(),
						    	'city' => $city,
						    	'units' => $units,
						    	'state' => $term->slug,
						    	'simg' => $small_img,
						    	'limg' => $full_img
						  	);
						endwhile; wp_reset_postdata();
						echo '<script type="text/javascript">var properties = '.json_encode( $properties ).';</script>';
					else :											
						// get_template_part( 'content', 'none' );
					endif; 
				?>
				<div id="usMap" style="width: 940px; height: 580px;"></div>
				<div class="list">
					<div id="pager">
						<ul class="target"></ul>
						<div class="page_navigation"></div>	
					</div>
				</div>							
			</div>
		</section>

		<section id="principals">
			<h2 class="title">Principals</h2>
			<div class="contents clearfix">
				<div class="images">
					<?php if($prinimagea){ 
						$prinimagea = wp_get_attachment_image_src( $prinimagea, 'full' );
						$prinimagea = $prinimagea[0]; ?>
						<div class="img" style="background-image: url(<?php echo $prinimagea; ?>);"></div>
					<?php } ?>
					<?php if($prinimageb){ 
						$prinimageb = wp_get_attachment_image_src( $prinimageb, 'full' );
						$prinimageb = $prinimageb[0]; ?>
						<div class="img" style="background-image: url(<?php echo $prinimageb; ?>);"></div>
					<?php } ?>					
				</div>
				<div class="copy">
					<div class="cell">
						<ul class="list">
							<?php 					
							$args_props = array( 'post_type' => 'principals', 'orderby' => 'date', 'order' => 'ASC', 'posts_per_page' => -1 );
							$q_props = new WP_Query( $args_props );
							if ( $q_props->have_posts() ) :
								$properties = array();																		
								while ( $q_props->have_posts() ) : $q_props->the_post(); 									
							?>
							<li><div class="title-strong"><?php the_title(); ?></div><div class="inner"><strong><?php the_title(); ?></strong>, <?php echo get_the_content(); ?></div></li>
						<?php
								endwhile; wp_reset_postdata();
								
							else :											
								// get_template_part( 'content', 'none' );
							endif; 
						?>							
						</ul>
					</div>
				</div>
			</div>
		</section>

		<section id="contact">
			<h2 class="title">Contact Us</h2>
			<div class="contents">
				<div id="map"></div>
				<div class="copy">
					<div class="cell">
						<div class="block">
							<?php if($contactheading){ ?>
							<h2 class="title"><?php echo $contactheading; ?></h2>
							<?php } ?>
							<?php if($contactlocation){ ?>
							<div class="address">
								<?php echo $contactlocation; ?>
							</div>
							<?php } ?>
							<div class="form">
								<?php 
									$nonce = wp_create_nonce("mid_post_submit");
								?>
								<form name="contact" data-nonce="<?php echo $nonce; ?>">
									<div class="resp"></div>
									<div class="inner">
										<input type="text" name="your_full_name" maxlength="50" size="20" placeholder="Your Full Name" value=""/>
										<input type="text" name="your_email_address" maxlength="50" size="20" placeholder="Your Email Address" value=""/>
										<textarea name="message" wrap="physical" placeholder="Enter your message here"></textarea>
										<input type="submit" value="submit"/>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		
	</div><!-- .content-area -->

<?php 
get_footer(); 
?>