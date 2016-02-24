<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<meta name="description" content="<?php bloginfo( 'description' ); ?>" />	
	<meta property="og:title" content="<?php bloginfo( 'name' ); ?>" />
	<meta property="og:image" content="<?php bloginfo('template_directory'); ?>/images/title-art.jpg" />
	<meta property="og:description" content="<?php bloginfo('description'); ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/js/slider/jquery.bxslider.css">
	<link rel="shortcut icon" href="<?php bloginfo( 'template_directory' ); ?>/images/favicon.png" type="image/x-icon" />
	<?php wp_head(); ?>
	<?php
	$kc_options = get_option('kc_options');
	$ga_tag = $kc_options['kc_ga_tag'];
	if($ga_tag){ ?>
	<!-- Google Analytics -->
	<?php echo $ga_tag; 
	} 
	?>				
</head>
<body <?php body_class(); ?>>
<div id="prime">	
	<header id="header">
		<div class="plate"></div>
		<div class="rig clearfix">
			<h1 class="logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hidetext"><img src="<?php bloginfo('template_directory'); ?>/images/small-logo.png" alt="<?php bloginfo( 'name' ); ?>" border="0"/></a>
				<span>Graphic Novel Romance Apps</span>
			</h1>
			<div id="burger">
				<ul>
					<li></li>
					<li></li>
					<li></li>
				</ul>
			</div>
			<div class="to-top"></div>
			<div id="menus">
				<?php wp_nav_menu( array( 'menu' => 'social', 'menu_class' => 'social-menu' ) ); ?>
				<?php wp_nav_menu( array( 'menu' => 'main', 'menu_class' => 'main-menu' ) ); ?>
			</div>						
		</div>
		<div id="mobile">				
			<?php wp_nav_menu( array( 'menu' => 'social', 'menu_class' => 'social-menu' ) ); ?>
			<?php wp_nav_menu( array( 'menu' => 'main', 'menu_class' => 'main-menu' ) ); ?>	
			<div class="to-top"><span>Top</span></div>			
		</div>
	</header>
	<div id="mid">