<?php get_header(); ?>
	<div class="page">
	<div class="zone" style="background-image:url('<?php bloginfo('template_directory'); ?>/images/page-header.jpg');">
		<img src="<?php bloginfo('template_directory'); ?>/images/page-blank.png" alt="" border="0" />
		<div class="row">
			<h1 class="page-title">404</h1>	
		</div>
	</div>
	<div id="prime" class="clearfix">
		<div class="row">			
			<div id="content" class="site-content" role="main">
				<center>
				<header class="page-header">
					<h1 class=""><?php _e( 'Not found', 'twentythirteen' ); ?></h1>
				</header>

				<div class="page-wrapper">
					<div class="page-content">
						<h2><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'twentythirteen' ); ?></h2>
						<p><?php _e( 'It looks like nothing was found at this location.', 'twentythirteen' ); ?></p>
					</div><!-- .page-content -->
				</div><!-- .page-wrapper -->
				</center>
			</div><!-- #content -->	
		</div>
	</div>
	</div>
<?php get_footer(); ?>