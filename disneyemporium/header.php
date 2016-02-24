<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<script src="//cdn.optimizely.com/js/1886101513.js"></script>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link href='//fonts.googleapis.com/css?family=Raleway:500,600,700,800,400' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/js/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/js/fancy/jquery.fancybox.css">
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/js/bx/jquery.bxslider.css">	
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon_disney.png" type="image/x-icon" />
	<?php if(is_home()){ ?>
	<meta name="description" content="Welcome to the Disney Music Emporium, the destination for Disney music fans featuring collectible Disney music products not available anywhere else." />	
	<meta property="og:description" content="Welcome to the Disney Music Emporium, the destination for Disney music fans featuring collectible Disney music products not available anywhere else." />
	<meta property="og:image" content="<?php echo bloginfo( 'template_directory' ).'/images/fb_share.jpg'; ?>" />		
	<?php } else { ?>
	<meta property="og:image" content="<?php echo postThumb('full'); ?>" />
	<?php } ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>	
</head>
<body <?php body_class(); ?>>
	<div id="fb-root"></div>
	<div id="grid">		
		<div id="header">
			<div class="row">
				<div class="mobile">
					<a class="home-link hidetext" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">Disney Music Emporium</a>
					<div id="burger" class="icon"><span>7</span></div>
					<div id="nav">						
						<ul class="list">
							<li class="products">
								<a href="/products">Products</a>
								<ul class="sub">
									<?php $args_products = array( 'post_type' => 'rgshop', 'posts_per_page' => 5 );
										$q_products = new WP_Query( $args_products );
										if ( $q_products->have_posts() ) :
											while ( $q_products->have_posts() ) : $q_products->the_post(); ?>
												<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
											<?php endwhile;
										endif; 
									wp_reset_postdata(); ?>								
									<li><a href="/shop" class="all">View All</a></li>
								</ul>
							</li>
							<li><a href="/the-legacy-collection">The Legacy Collection</a></li>
							<li><a href="/news">News</a></li>
							<li><a href="/videos">Videos</a></li>
							<li><a href="/shop">Shop</a></li>
						</ul>
					</div>
					<div id="side">
						<ul class="list">
							<li><a href="#" class="newsletter"><span>n</span></a></li>
							<li class="carthold">								
							</li>
						</ul>					
					</div>
				</div>
				<div class="desk">
					<div id="nav">
						<a class="home-link hidetext" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">Disney Music Emporium</a>
						<ul class="list">
							<li class="products">
								<a href="/products">Products</a>
								<ul class="sub">
									<?php $args_products = array( 'post_type' => 'rgshop', 'posts_per_page' => 5 );
										$q_products = new WP_Query( $args_products );
										if ( $q_products->have_posts() ) :
											while ( $q_products->have_posts() ) : $q_products->the_post(); ?>
												<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
											<?php endwhile;
										endif; 
									wp_reset_postdata(); ?>								
									<li><a href="/shop" class="all">View All</a></li>
								</ul>
							</li>
							<li><a href="/the-legacy-collection">The Legacy Collection</a></li>
							<li><a href="/news">News</a></li>
							<li><a href="/videos">Videos</a></li>
							<li><a href="/shop">Shop</a></li>
						</ul>
					</div>
					<div id="side">
						<ul class="list">
							<li><a href="#" class="newsletter">n</a></li>
							<li class="carthold">
								<!-- <a href="#" class="cart">1</a> -->
								<div id="cart-container"></div>
							</li>
						</ul>					
					</div>				
				</div>
			</div>
			<div id="newsletter">
				<div class="row">
					<div id="form">
						<h2>Sign up and get exclusive Disney Music Emporium offers and updates!</h2>
						<div id="campaigns">			
							<!-- Start of Form -->
							<div id="panel">
							    <div id="signup-box">
									<div id="fcf">			
										<form name="Signup" signupform="true" action="https://fc.myplay.com/apps/sf/signup" method="POST" onsubmit="return validateSignupForm(this)">
											<div id="landing">											
												<!-- <div id="errorDiv" style="border: 1px solid; background-repeat: no-repeat; background-position: 10px center; color: #D8000C; background-color: #FFBABA; font-weight:normal; font-size:12px; visibility:hidden;"></div> -->
												<div class="section signup" id="mainForm">				
													<div class="field single" id="firstNameDiv">
														<input type="text" name="first_name" maxlength="50" size="20" value="First Name" onfocus="if (this.value == 'First Name') {this.value = '';}" onblur="if (this.value == '') {this.value = 'First Name';}"/>
													</div>
													<input type="hidden" name="demographics_on_form" value="first_name" />
													<div class="field single" id="lastNameDiv">
														<input type="text" name="last_name" maxlength="50" size="20" value="Last Name" onfocus="if (this.value == 'Last Name') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Last Name';}"/>
													</div>
													<input type="hidden" name="demographics_on_form" value="last_name" />
													<div class="field single" id="emailDiv">
														<input type="text" name="email" maxlength="50" size="20" value="Email*" onfocus="if (this.value == 'Email*') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Email*';}"/>
													</div>
													<input type="hidden" name="required_fields" value="email" /> <input
														type="hidden" name="demographics_on_form" value="email" />
													<div class="field dob" id="birthDateDiv">
													<label>Date of Birth</label>
													<select name="birth_month">
													<option value="Month">MONTH*</option>
													<option value="JAN">January</option>
													<option value="FEB">February</option>
													<option value="MAR">March</option>
													<option value="APR">April</option>
													<option value="MAY">May</option>
													<option value="JUN">June</option>
													<option value="JUL">July</option>
													<option value="AUG">August</option>
													<option value="SEP">September</option>
													<option value="OCT">October</option>
													<option value="NOV">November</option>
													<option value="DEC">December</option>
													</select>
													
													<select name="birth_day">
													<option value="Day">DAY*</option>
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
													
													<select name="birth_year">
													<option value="Year">YEAR*</option>
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
													<input type="hidden" name="list" value="SVC6669">
													<div id="primaryNotification" style="display:none;"> 
													</div>	
													<div id="privacy">
														<div class="section privacy">
															<a href="http://www.myplaydirect.com/privacypolicy" target="_blank">Privacy Policy</a><br><span id="req_fields_lbl">Required fields*</span>
														</div>
													</div>									
													<div class="field submit">
														<input type="submit"  value="Sign Me Up!"/>
														<div class="or">or</div>
														<a href="#" title="Connect with Facebook" onclick="getFBData();" class="social-btn-wrap connect"><span>Connect with Facebook</span></a>
													</div>														
													<div style="display: none;" id="infoDiv"></div>
													<div id="secondaryNotification" style="display:none;">
													</div>
												</div>												
											</div>																	
											<!-- Form List ID -->
								  			<input type="hidden" name="fc_form" value="19841"/>
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
										</form>
									</div>
									<!-- End of Form -->
								</div>
							</div>																					
						</div><!-- End of Campaign -->						
					</div>					
				</div>
				<a href="#" class="view">8</a>
			</div>			
		</div>