<?php

// Creating the widget 
class featured_post_widget extends WP_Widget {
function __construct() {
$textDomain = 'the_featured';
parent::__construct(
// Base ID of your widget
'kc_the_featured', 

// Widget name will appear in UI
__('Featured Posts', $textDomain), 

// Widget description
array( 'description' => __( 'Displays the featured posts.', $textDomain ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
$number = apply_filters( 'widget_title', $instance['p_number'] );
if($number){
	$number = $number;
} else {
	$number = 1;
}
// before and after widget arguments are defined by themes
// echo $args['before_widget'];
if ( ! empty( $title ) )
// echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
?>
<div class="widget featured">
	<div class="widget-title"><?php echo $title; ?></div>
	<?php
		if ( twentyfourteen_has_featured_posts() ) {		
			/* Get all sticky posts */
			$sticky = get_option( 'sticky_posts' );

			/* Sort the stickies with the newest ones at the top */
			rsort( $sticky );

			/* Get the 5 newest stickies (change 5 for a different number) */
			$sticky = array_slice( $sticky, 0, $number );

			/* Query sticky posts */
			$q_featured = new WP_Query( array( 'post__in' => $sticky, 'ignore_sticky_posts' => 1 ) );

			if ( $q_featured->have_posts() ) :
				// Start the Loop.
				while ( $q_featured->have_posts() ) : $q_featured->the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', 'side' );

				endwhile;			
			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );

			endif;
		}
	?>
</div>
<?php
// echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Featured Posts', $textDomain );
}
if ( isset( $instance[ 'p_number' ] ) ) {
$number = $instance[ 'p_number' ];
}
else {
$number = __( '1', $textDomain );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id( 'p_number' ); ?>"><?php _e( 'Number of posts:' ); ?></label></br>
<input class="widefat" id="<?php echo $this->get_field_id( 'p_number' ); ?>" name="<?php echo $this->get_field_name( 'p_number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" style="width: 10%;" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['p_number'] = ( ! empty( $new_instance['p_number'] ) ) ? strip_tags( $new_instance['p_number'] ) : '';
return $instance;
}
} // Class playlists_widget ends here

// Register and load the widget
function featured_post_load_widget() {
	register_widget( 'featured_post_widget' );
}
add_action( 'widgets_init', 'featured_post_load_widget' );
