		</div><!-- #mid -->
		<footer id="footer">
			<div class="rig clearfix">
				<div class="to-top"></div>
				<h1 class="logo">
					<a href="http://voltage-ent.com/" class="hidetext" target="_blank">VOLTAGE entertainment USA</a>
				</h1>
				<div class="copyright">
					<?php wp_nav_menu( array( 'menu' => 'footer', 'menu_class' => 'footer-menu' ) ); ?>
					<p>Copyright &copy; <?php echo date('Y'); ?> Voltage Entertainment USA, Inc. All Rights Reserved.</p>
				</div>
			</div>
		</footer><!-- #footer -->
	</div><!-- #main -->
	<?php 
		$kc_options = get_option('kc_options');
		$tweet = $kc_options['kc_twitter_text'];
		$tumblr = $kc_options['kc_tumblr_text'];
		$b_name = get_bloginfo('name');
		$b_disc = get_bloginfo('description');
		$b_title = $b_name.' | '.$b_disc;
		$b_title = htmlspecialchars_decode($b_title);
		$url = esc_url( home_url( '/' ) );

		if($tweet){
			$tweet = $tweet;
		} else {
			$tweet = $b_title.' '.$url;
		}

		if($tumblr){
			$tumblr = $tumblr;
		} else {
			$tumblr = $b_title;
		}

		$tweet = rawurlencode($tweet);
		$tumblr = rawurlencode($tumblr);		
		// pre($kc_options);
	?>
	<div class="over">
		<div class="inner">
			<div class="close">close X</div>
			<ul>
				<li>
					<a href="javascript: void(0)" class="facebook hidetext" onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo $url; ?>','sharer','toolbar=0,status=0,width=580,height=325');">Facebook Share</a>
				</li>
				<li>
					<a href="javascript: void(0)" class="twitter hidetext" onclick="window.open('https://twitter.com/intent/tweet?text=<?php echo $tweet; ?>','sharer','toolbar=0,status=0,width=580,height=500');">Twitter Share</a>
				</li>
				<li>
					<a href="javascript: void(0)" class="tumblr hidetext" onclick="window.open('https://www.tumblr.com/widgets/share/tool?shareSource=legacy&amp;canonicalUrl=&amp;url=<?php echo $url; ?>&amp;posttype=link&amp;title=<?php echo $tumblr; ?>','sharer','toolbar=0,status=0,width=580,height=500');">Tumblr Share</a>
				</li>
			</ul>
		</div>
	</div>
	<?php wp_footer(); ?>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/plugins.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/slider/jquery.bxslider.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/scripts.js"></script>
</body>
</html>