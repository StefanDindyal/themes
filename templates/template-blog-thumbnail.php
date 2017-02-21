<?php 

/*
 * Template to render a blog post thumbnail.
 * Used inside the blog index page.
 */

$excerpt = strip_tags(get_the_content());
$excerpt = substr($excerpt, 0, 140);

$thumbnailLink = get_the_permalink();
$thumbnailTarget = '_parent';
$thumbnailWidth = 'col-xs-12 col-sm-9';

if(get_post_type() == 'press_release_type') {
	$thumbnailWidth = 'col-xs-12';
}

if(get_post_type() == 'news_article_type') {
	$thumbnailLink = get_field('news_article_url');
	$thumbnailTarget = '_blank';
}

?>

<div class="thumbnail <?php echo get_post_type(); ?>">
	<div class="row">
		<?php if(get_post_type() !== 'press_release_type') { ?>
		<div class="col-xs-12 col-sm-3">
			<?php 
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()), 'full' );
				$url = $thumb['0'];
			?>
			<div class="thumbnail-image">
				<a href="<?php echo $thumbnailLink; ?>" target="<?php echo $thumbnailTarget; ?>" title="<?php the_title_attribute(); ?>" <?php if($url && $url!='') { ?> style="background-image: url('<?php echo $url; ?>')" <?php } ?> ></a>
			</div>
		</div>
		<?php } ?>
		<div class="<?php echo $thumbnailWidth; ?>">
			<div class="caption">

				<?php if(get_post_type() !== 'press_release_type') { ?>
				<h5><?php the_category(' + '); ?></h5>
				<?php } ?>

				<h3><a href="<?php echo $thumbnailLink; ?>" target="<?php echo $thumbnailTarget; ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

				<?php if(get_post_type() === 'press_release_type' || get_post_type() === 'news_article_type') { ?>
				<p class="date-and-tags">
					<time class="updated" datetime="<?= get_the_time('c'); ?>"><?= get_the_date(); ?></time>
				</p>

				<?php } ?>
				
				<div class="post-content">
					<p><?php echo $excerpt; ?><a href="<?php echo $thumbnailLink; ?>" target="<?php echo $thumbnailTarget; ?>">...</a></p>
				</div>
				
				<?php if(get_post_type() !== 'press_release_type' && get_post_type() !== 'news_article_type' && get_post_type() !== 'research_post') { ?>
				<p><small class="text-muted">by <?php the_author_posts_link(); ?></small></p>
				<?php } ?>
			</div>
		</div>
	</div>
</div>