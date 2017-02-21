<?php
/**
 * Template Name: Blog Post List
 */

$index = ICL_LANGUAGE_CODE == 'en' ? 1 : 2;

// Check if the repeater field has rows of data
$mostPopularPosts = array();
if( have_rows('most_popular_posts') ){
	while ( have_rows('most_popular_posts') ) : the_row();
		$mostPopularPosts[] = get_sub_field('post_item');
	endwhile;
}

$postType = get_field('blog_type') ?: 'post';

// Identify if we are in a year specific year page, and author page or a regular blog page.
$path       = $_SERVER['REQUEST_URI'];
$path       = explode('/', $path);
$type       = isset($path[$index]) ? $path[$index] : "";

$maxPosts = get_field('max_posts') ?: '5';
switch($type){
	case "author":
		$author   = isset($path[$index+1]) ? $path[$index+1] : "";
		$args     = array( 'post_type' => array('post', 'research_post'), 'posts_per_page' => $maxPosts, 'author_name' => $author, 'orderby' => 'date', 'order' => 'DESC');
		$loadMore = '<a href="#" data-page="1" data-elements="'.$maxPosts.'" data-type="" data-cat="" data-author="'.$author.'" data-year="-1" class="load-more btn btn-default">Load More Articles <span class="down-arrow"></span></a>';
		break;
	case "date":
		$year     = isset($path[$index+1]) ? $path[$index+1] : "";
		$args     = array( 'post_type' => array('post', 'research_post'), 'posts_per_page' => $maxPosts, 'date_query' => array(array('year' => $year)));
		$loadMore = '<a href="#" data-page="1" data-elements="'.$maxPosts.'" data-type="" data-cat="" data-author="" data-year="'.$year.'" class="load-more btn btn-default">Load More Articles <span class="down-arrow"></span></a>';
		break;
	case "category":
		$category = isset($path[$index+1]) ? $path[$index+1] : "";
		$args     = array( 'post_type' => array('post', 'research_post'), 'posts_per_page' => $maxPosts, 'category_name' => $category, 'orderby' => 'date', 'order' => 'DESC');
		$loadMore = '<a href="#" data-page="1" data-elements="'.$maxPosts.'" data-type="" data-cat="'.$category.'" data-author="" data-year="-1" class="load-more btn btn-default">Load More Articles <span class="down-arrow"></span></a>';
		break;
	default:
		$args     = array( 'post_type' => $postType, 'posts_per_page' => $maxPosts );
		$loadMore = '<a href="#" data-page="1" data-elements="'.$maxPosts.'" data-type="'.$postType.'" data-cat="" data-author="" data-year="-1" class="load-more btn btn-default">Load More Articles <span class="down-arrow"></span></a>';	
}

$loop = new WP_Query( $args );
?>

<div class="post-listing-template">
	<div class="container blogs-content">
		<div class="row">
			<div class="col-md-8 posts-container">
				<div class="posts">
				<?php 				
					while ( $loop->have_posts() ) : $loop->the_post();
						get_template_part('templates/template-blog', 'thumbnail');
					endwhile;
					wp_reset_postdata();
				?>
				</div>
				<?php render_component("loader"); ?>
				<?php echo $loadMore; ?>				
			</div>
			<div class="col-md-4">
				<div class="sidebar">
					<?php 
						
						/* SIDE BAR*/
						switch ($postType) {
						    case 'research_post':
						    	render_component("sidebar-widget-most-popular", array('mostPopularPosts' => $mostPopularPosts));
						        dynamic_sidebar('sidebar-research');
						        break;
					      	case 'press_release_type':
						        dynamic_sidebar('sidebar-press-release');
						        break;
					        case 'news_article_type':
						        dynamic_sidebar('sidebar-news');
						        break;
						    case 'post':
						    	render_component("sidebar-widget-most-popular", array('mostPopularPosts' => $mostPopularPosts));
						        dynamic_sidebar('sidebar-blog');
						        break;
						}
					?>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function () {
			app.templates.postIndex.init();
		});
	</script>
</div>