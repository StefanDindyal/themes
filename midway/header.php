<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<link href='https://fonts.googleapis.com/css?family=Raleway:400,200,600,300,100,700,500' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/js/perfect-scrollbar.css">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<div id="hamburger"></div>
	<div id="nav">
		<ul>
			<li><a href="#about">About</a></li>
			<li><a href="#properties">Properties</a></li>
			<li class="logo"><a href="#home"><h1 class="hidetext">Midway Investors</h1></a></li>
			<li><a href="#principals">Principals</a></li>
			<li><a href="#contact">Contact</a></li>
		</ul>
	</div>
	<div id="nav" class="mobile">
		<ul>
			<li><a href="#about">About</a></li>
			<li><a href="#properties">Properties</a></li>			
			<li><a href="#principals">Principals</a></li>
			<li><a href="#contact">Contact</a></li>
		</ul>
	</div>