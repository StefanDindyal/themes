<?php
/* Most popular posts component.
 *
 * Events:
 *
 * USAGE:
 * render_component("sidebar-widget-most-popular", array("mostPopularPosts" => array));
 *
 */

	$mostPopularPosts = $this->mostPopularPosts;

?>

<?php if ( count($mostPopularPosts)>0 ) { ?>
<section>
	<h3>Most Popular</h3>
	<ol class="archive">
	<?php foreach ($mostPopularPosts as $postItem) { ?>
		<li>
			<a href="<?php echo get_permalink($postItem); ?>"><?php echo get_the_title($postItem); ?></a>
		</li>
	<?php } ?>
	</ol>
</section>
<?php } ?>