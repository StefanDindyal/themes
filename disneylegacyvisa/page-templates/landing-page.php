<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link href='//fonts.googleapis.com/css?family=Raleway:400,600,800,700' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.jpg" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->	
	<?php wp_head(); ?>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/jquery.bxslider.css">
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/js/jquery.fancybox.css">
</head>
<body <?php body_class(); ?>>
	<?php 
		// Page Attributes
		// $sub_title = get_post_meta($post->ID, 'rg_sub_title', true);
		// $sub_title = get_post_meta($post->ID, 'rg_sub_title', true);
	?>
	<div id="sky">
		<div id="newsletter" class="clearfix">
			<a href="#nl_form" class="tab">Want more Disney Music Emporium?</a>
		</div>
		<div id="logo">
			<img src="<?php bloginfo('template_directory'); ?>/images/legacy-logo.png" alt="Walt Disney Records | The Legacy Collection" border="0"/>
		</div>
		<div id="sub-title">
			Pre-order the first 3 titles of The Walt Disney Records Legacy Collection now through December 31, 2014 and get <span>10% off</span> (plus shipping and handling).
		</div>
		<div id="form">
			<form name="pinsubmit"><input type="text" name="d24pin" maxlength="50" size="20" value="First 4 numbers of your Disney VISA Card" onfocus="if (this.value == 'First 4 numbers of your Disney VISA Card') {this.value = '';}" onblur="if (this.value == '') {this.value = 'First 4 numbers of your Disney VISA Card';}" /><input type="submit" value="Pre-Order Now"/></form>
		</div>
		<div id="includes">
			<h2></h2>			
			<ul>
				<li>Disney Visa&reg; Cardmembers have the opportunity to order the first 3 titles of The Walt Disney Records Legacy Collection (The Lion King, Mary Poppins and Sleeping Beauty) at a discounted price.</li>
				<li>Offer valid August 1st – December 31st 2014</li>
			</ul>
			<br>
		</div>		
		<ul id="tabs">			
			<li id="tab-2" class="active"><a href="#" class="hidetext">2</a></li>
			<li id="tab-3"><a href="#" class="hidetext">3</a></li>
			<li id="tab-4"><a href="#" class="hidetext">4</a></li>			
		</ul>
		<div id="selector">
			<select>
				<option value="">Select an Album</option>				
				<option value="tab-2">The Lion King</option>
				<option value="tab-3">Mary Poppins</option>
				<option value="tab-4">Sleeping Beauty</option>				
			</select>
		</div>
		<div id="discography">
			<div class="disco">
			<?php 
				$args_disc = array( 'post_type' => 'discography', 'posts_per_page' => 13 );
				$q_disc = new WP_Query( $args_disc );
				if ( $q_disc->have_posts() ) :			
					while ( $q_disc->have_posts() ) : $q_disc->the_post(); 
					$released = get_post_meta($post->ID, 'rg_released', true);
					$tab = get_post_meta($post->ID, 'rg_tab', true);
					$slide1 = get_post_meta($post->ID, 'rg_slide1', true);
					$slide2 = get_post_meta($post->ID, 'rg_slide2', true);
					$slide3 = get_post_meta($post->ID, 'rg_slide3', true);
					$slide3i = get_post_meta($post->ID, 'rg_slide3-img', true);
					$dlist = get_post_meta($post->ID, 'rg_dlist', true);
					$extra = get_post_meta($post->ID, 'rg_extra', true);
				?>			
						<div class="post clearfix" data-id="<?php echo $tab; ?>">
							<?php if($slide1 || $slide2 || $slide3){ ?>
								<div class="entry-thumbnail">
									<div class="target">
										<?php if($slide1){ ?>
											<?php 
												$image = wp_get_attachment_image_src($slide1,'cover-thumb');
												echo '<article><img src='.$image[0].' alt="" border="0"/></article>'; 
											?>
										<?php } ?>
										<?php if($slide2){ ?>
											<?php 
												$image = wp_get_attachment_image_src($slide2,'cover-thumb');
												echo '<article><img src='.$image[0].' alt="" border="0"/></article>'; 
											?>
										<?php } ?>
										<?php if($slide3){ ?>
											<?php
												if($slide3i){
													$image = wp_get_attachment_image_src($slide3i,'cover-thumb');
													echo '<article><a href="'.$slide3.'" class="lb"><img src='.$image[0].' alt="" border="0"/><div class="play"></div></a></article>'; 
												} else {
													if(preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $slide3, $match)) {
					    								$video_id = $match[1];
					    								$image = 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
					    								$dummy = get_template_directory_uri() . '/images/dummy.png';
													}
													echo '<article><a href="'.$slide3.'" class="lb" style="background-image: url('.$image.');"><img src='.$dummy.' alt="" border="0"/><div class="play"></div></a></article>';
												}
											?>
										<?php } ?>
									</div>
								</div>
							<?php } else { ?>
								<div class="entry-thumbnail">
									<?php the_post_thumbnail('cover-thumb'); ?>
								</div>
							<?php } ?>
							<?php if($released){ ?>
								<div class="contents">
									<div class="mid">
										<div class="in">
											<h2><?php the_title(); ?></h2>
											<div class="rtitle">Release Date</div>
											<div class="rdate"><?php echo $released; ?></div>
										</div>
									</div>
								</div>
							<?php } else { ?>
								<div class="contents scroll">								
									<div class="txt"><?php the_content(); ?></div>
									<h2><?php the_title(); ?></h2>
									<?php if(is_array($dlist)){ ?>
										<div class="list">
											<?php $i = 0; foreach($dlist as $item) { ?>
										    	<?php if($item){ ?>
									        		<?php if($item['atitle']&&$item['alist']){ ?>
									        			<h3><?php echo $item['atitle']; ?></h3>
									        			<ol class="options">
									        				<?php
									        					$theList = $item['alist'];
									        					$separator = ',';
											        			$array = explode($separator,$theList);
											        			$output = '';
											        			foreach($array as $track){
											        				$track = trim($track);
											        				$track = str_replace(array('(',')'),array('<span>','</span>'),$track);
											        				$output .= '<li>'.$track.'</li>';
											        			}
											        			echo $output;
									        				?>
									        			</ol>
									        		<?php } ?>
										        <?php } ?>
										    <?php } ?>
										</div>
									<?php } if($extra){ ?>
										<div class="list next">
											<?php echo $extra; ?>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					<?php endwhile;		
				endif; wp_reset_postdata(); 
			?>
			</div>
		</div>
		<div id="claim">
			Order the bundle and get a 10% discount (plus shipping &amp; handling). International orders are available in 63 countries and are subject to additional taxes and S&amp;H fees that will be calculated at checkout. Offer limited to one bundle purchase per customer. Offer not valid with other offers. Must be 13 or older to redeem. Non-transferable or redeemable for other goods or services. Non-refundable. While supplies last. Offer expires on December 31st, 2014. Disney Dream Reward Dollars cannot be redeemed toward this offer. &copy; Disney.
		</div>
		<div id="footer">
			<a href="http://disneymusicemporium.com/" id="emporium-logo" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/emporium-logo.png" alt="Disney Music Emporium" border="0"/></a>
			<div id="legal">
				&copy; <?php echo date('Y'); ?> <a href="http://disney.com/" target="_blank">Disney</a> / Powered by <a href="http://www.rgenerator.com/" target="_blank">rGenerator</a>
			</div>
		</div>
		<div style="display: none;">
			<div id="nl_form">
				<div class="icon"></div>
				<form name="Signup" signupform="true" action="https://fc.myplay.com/apps/sf/signup" method="POST" onsubmit="return validateSignupForm(this)">
					<a href="#" class="custom-close hidetext">Close me</a>
					<div class="real">
						<div class="txt">Sign up and get exclusive<br>
						Disney Music Emporium offers and updates! </div>
						<input type="text" name="first_name" maxlength="50" size="20" value="First Name" onfocus="if (this.value == 'First Name') {this.value = '';}" onblur="if (this.value == '') {this.value = 'First Name';}" />
						
						<input type="hidden" name="demographics_on_form" value="first_name" />
						
						<input type="text" name="last_name" maxlength="50" size="20" value="Last Name" onfocus="if (this.value == 'Last Name') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Last Name';}" />
						
						<input type="hidden" name="demographics_on_form" value="last_name" />
						
						<input type="text" name="email" maxlength="50" size="20" value="Email*" onfocus="if (this.value == 'Email*') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Email*';}" />
						<input type="hidden" name="required_fields" value="email" />
						<input type="hidden" name="demographics_on_form" value="email" />
						<div class="field dob" id="birthDateDiv">										
							<div class="strip">
								<select name="birth_month">
									<option value="Month">MM*</option>
									
										<option value="JAN">Jan</option>
									
										<option value="FEB">Feb</option>
									
										<option value="MAR">Mar</option>
									
										<option value="APR">Apr</option>
									
										<option value="MAY">May</option>
									
										<option value="JUN">Jun</option>
									
										<option value="JUL">Jul</option>
									
										<option value="AUG">Aug</option>
									
										<option value="SEP">Sep</option>
									
										<option value="OCT">Oct</option>
									
										<option value="NOV">Nov</option>
									
										<option value="DEC">Dec</option>
									
								</select>								
							</div>
							<div class="strip">
								<select name="birth_day">
									<option value="Day">DD*</option>
									
										<option value="1">1</option>
									
										<option value="2">2</option>
									
										<option value="3">3</option>
									
										<option value="4">4</option>
									
										<option value="5">5</option>
									
										<option value="6">6</option>
									
										<option value="7">7</option>
									
										<option value="8">8</option>
									
										<option value="9">9</option>
									
										<option value="10">10</option>
									
										<option value="11">11</option>
									
										<option value="12">12</option>
									
										<option value="13">13</option>
									
										<option value="14">14</option>
									
										<option value="15">15</option>
									
										<option value="16">16</option>
									
										<option value="17">17</option>
									
										<option value="18">18</option>
									
										<option value="19">19</option>
									
										<option value="20">20</option>
									
										<option value="21">21</option>
									
										<option value="22">22</option>
									
										<option value="23">23</option>
									
										<option value="24">24</option>
									
										<option value="25">25</option>
									
										<option value="26">26</option>
									
										<option value="27">27</option>
									
										<option value="28">28</option>
									
										<option value="29">29</option>
									
										<option value="30">30</option>
									
										<option value="31">31</option>
									
								</select>								
							</div>
							<div class="strip">
								<select name="birth_year">

										<option value="Year">YYYY*</option>

										<option value="2014">2014</option>
									
										<option value="2013">2013</option>
									
										<option value="2012">2012</option>
									
										<option value="2011">2011</option>
									
										<option value="2010">2010</option>
									
										<option value="2009">2009</option>
									
										<option value="2008">2008</option>
									
										<option value="2007">2007</option>
									
										<option value="2006">2006</option>
									
										<option value="2005">2005</option>
									
										<option value="2004">2004</option>
									
										<option value="2003">2003</option>
									
										<option value="2002">2002</option>
									
										<option value="2001">2001</option>
									
										<option value="2000">2000</option>
									
										<option value="1999">1999</option>
									
										<option value="1998">1998</option>
									
										<option value="1997">1997</option>
									
										<option value="1996">1996</option>
									
										<option value="1995">1995</option>
									
										<option value="1994">1994</option>
									
										<option value="1993">1993</option>
									
										<option value="1992">1992</option>
									
										<option value="1991">1991</option>
									
										<option value="1990">1990</option>
									
										<option value="1989">1989</option>
									
										<option value="1988">1988</option>
									
										<option value="1987">1987</option>
									
										<option value="1986">1986</option>
									
										<option value="1985">1985</option>
									
										<option value="1984">1984</option>
									
										<option value="1983">1983</option>
									
										<option value="1982">1982</option>
									
										<option value="1981">1981</option>
									
										<option value="1980">1980</option>
									
										<option value="1979">1979</option>
									
										<option value="1978">1978</option>
									
										<option value="1977">1977</option>
									
										<option value="1976">1976</option>
									
										<option value="1975">1975</option>
									
										<option value="1974">1974</option>
									
										<option value="1973">1973</option>
									
										<option value="1972">1972</option>
									
										<option value="1971">1971</option>
									
										<option value="1970">1970</option>
									
										<option value="1969">1969</option>
									
										<option value="1968">1968</option>
									
										<option value="1967">1967</option>
									
										<option value="1966">1966</option>
									
										<option value="1965">1965</option>
									
										<option value="1964">1964</option>
									
										<option value="1963">1963</option>
									
										<option value="1962">1962</option>
									
										<option value="1961">1961</option>
									
										<option value="1960">1960</option>
									
										<option value="1959">1959</option>
									
										<option value="1958">1958</option>
									
										<option value="1957">1957</option>
									
										<option value="1956">1956</option>
									
										<option value="1955">1955</option>
									
										<option value="1954">1954</option>
									
										<option value="1953">1953</option>
									
										<option value="1952">1952</option>
									
										<option value="1951">1951</option>
									
										<option value="1950">1950</option>
									
										<option value="1949">1949</option>
									
										<option value="1948">1948</option>
									
										<option value="1947">1947</option>
									
										<option value="1946">1946</option>
									
										<option value="1945">1945</option>
									
										<option value="1944">1944</option>
									
										<option value="1943">1943</option>
									
										<option value="1942">1942</option>
									
										<option value="1941">1941</option>
									
										<option value="1940">1940</option>
									
										<option value="1939">1939</option>
									
										<option value="1938">1938</option>
									
										<option value="1937">1937</option>
									
										<option value="1936">1936</option>
									
										<option value="1935">1935</option>
									
										<option value="1934">1934</option>
									
										<option value="1933">1933</option>
									
										<option value="1932">1932</option>
									
										<option value="1931">1931</option>
									
										<option value="1930">1930</option>
									
										<option value="1929">1929</option>
									
										<option value="1928">1928</option>
									
										<option value="1927">1927</option>
									
										<option value="1926">1926</option>
									
										<option value="1925">1925</option>
									
										<option value="1924">1924</option>
									
										<option value="1923">1923</option>
									
										<option value="1922">1922</option>
									
										<option value="1921">1921</option>
									
										<option value="1920">1920</option>
									
										<option value="1919">1919</option>
									
										<option value="1918">1918</option>
									
										<option value="1917">1917</option>
									
										<option value="1916">1916</option>
									
										<option value="1915">1915</option>
									
										<option value="1914">1914</option>
									
								</select>								
							</div>
						</div>
						<div class="pp"><a href="http://www.myplaydirect.com/privacypolicy" target="_blank">Privacy Policy</a></div>
						<div class="req">Required fields*</div>

						<div class="submit">
							<input type="submit" value="Sign Me Up!"/>
						</div>				
						<!-- Form List ID -->
						<input type="hidden" name="list" value="SVC6669">			  						  			
			  			<input type="hidden" name="fc_form" value="19814"/>			  			
			  			<!-- Form Misc -->
			  			<input type="hidden" name="confirm" value="Y" />
			  			<input type="hidden" name="email_vc" value="NL" />
			  			<input type="hidden" name="mobile_vc" value="MZ" />
			  			<!-- for promo options div display -->
			  			<input type="hidden" id="promo_on_lg" value="false" />
			  			<input type="hidden" id="promo_on_ty" value="false" />
			  			<input type="hidden" id="promo_on_bl" value="false" />
			  			<!-- for enter site div display -->
			  			<input type="hidden" id="entersite_on_lg" value="false" />
			  			<input type="hidden" id="entersite_on_ty" value="false" />
			  			<input type="hidden" id="entersite_on_bl" value="false" />
			  			<!-- FCv2.2 - for service list validation in sFC.js -->  
						<input type="hidden" id="formType" value="newsletter" />
						<input type="hidden" name="demographics_on_form" value="signup_source" />
						<input type="hidden" name="signup_source" id="signup_source" value="EMAIL" />
					</div>
					<div class="thankyou">
						<div class="txt">Thank you for<br>signing up!</div>
					</div>
				</form>				
			</div>
		</div>
	</div>
	<?php wp_footer(); ?>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.mCustomScrollbar.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.fancybox.pack.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.bxslider.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/helpers/jquery.fancybox-media.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/scripts.js"></script>
	<div class="pixel">
	<!-- Google Code for Disney VISA - MyPlay Pre-Order - 540 Days Conversion Page -->
	<!-- Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. For instructions on adding this tag and more information on the above requirements, read the setup guide: google.com/ads/remarketingsetup -->
	<script type="text/javascript">
	/* <![CDATA[ */
	var google_conversion_id = 968640050;
	var google_conversion_label = "Z5CDCKbg8wcQsozxzQM";
	var google_custom_params = window.google_tag_params;
	var google_remarketing_only = true;
	/* ]]> */
	</script>
	<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
	</script>
	<noscript>
	<div style="display:inline;">
	<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/968640050/?value=1.00&label=Z5CDCKbg8wcQsozxzQM&guid=ON&script=0"/>
	</div>
	</noscript>
	<script type="text/javascript">(function(){
	  window._fbds = window._fbds || {};
	  _fbds.pixelId = 768195219876692;
	  var fbds = document.createElement('script');
	  fbds.async = true;
	  fbds.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//connect.facebook.net/en_US/fbds.js';
	  var s = document.getElementsByTagName('script')[0];
	  s.parentNode.insertBefore(fbds, s);
	})();
	window._fbq = window._fbq || [];
	window._fbq.push(["track", "PixelInitialized", {}]);
	</script>
	<noscript><img height="1" width="1" border="0" alt="" style="display:none" src="https://www.facebook.com/tr?id=768195219876692&amp;ev=NoScript" /></noscript>
	</div>
</body>
</html>
<?php /* Template Name: Landing Page Template */ ?>