<?php

add_action( 'widgets_init', 'rg_socialfeed_widget' );

function rg_socialfeed_widget() {
	register_widget( 'RG_Social_Feed_Widget' );
}

class RG_Social_Feed_Widget extends WP_Widget {
	
	function RG_Social_Feed_Widget() {		
		$widget_ops = array( 'classname' => 'rg-widget', 'description' => __( 'Combined social media feeds', RG_LOCALE ) );
		$control_ops = array( 'id_base' => 'rg-widget' );
		$this->WP_Widget( 'rg-widget', __( 'RG Social Widget', RG_LOCALE ), $widget_ops, $control_ops );
		
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title = $instance['title'];
		$username = $instance['username'];
		$limit = $instance['limit'];
		$feed = $instance['feed'];
		$imagesize = $instance['imagesize'];
		
		echo '<div id="sidebar-feed">';
		
		if ( $title )
			echo $before_title . $title . $after_title;
		
		if(!empty($instance)){
		   $new_options = $instance;
		} else {
		   $new_options = get_option( 'rg_options' );
		}
		
		//echo rg_socialfeed($options);
		
		if( $feed == "all" ){
			echo rg_socialfeed($options);
		}elseif( $feed == "facebook" ){
			echo do_shortcode('[rg_socialfeed facebook="'.$new_options['username'].'" limit="'.$new_options['limit'].'" imagesize="'.$new_options['imagesize'].'"]');
		} elseif( $feed == "twitter" ){
			echo do_shortcode('[rg_socialfeed twitter="'.$new_options['username'].'" limit="'.$new_options['limit'].'"]');
		} elseif( $feed == "instagram" ){
			echo do_shortcode('[rg_socialfeed instagram="'.$new_options['username'].'" limit="'.$new_options['limit'].'" imagesize="'.$new_options['imagesize'].'"]');
		} elseif( $feed == "instagramtag" ){
			echo do_shortcode('[rg_socialfeed instagramtag="'.$new_options['username'].'" limit="'.$new_options['limit'].'" imagesize="'.$new_options['imagesize'].'"]');
		} else {
			echo '';
		}
				
		echo '</div>';
		
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['limit'] = strip_tags( $new_instance['limit'] );
		$instance['feed'] = strip_tags( $new_instance['feed'] );
		$instance['imagesize'] = strip_tags( $new_instance['imagesize'] );

		return $instance;
	}
	
	function form( $instance ) {
		
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
			$username = esc_attr( $instance[ 'username' ] );
			$limit = esc_attr( $instance[ 'limit' ] );
			$feed = esc_attr( $instance[ 'feed' ] );
			$imagesize = esc_attr( $instance[ 'imagesize' ] );
		} else {
			$title = __( 'Social Feed', 'text_domain' );
			$username = __( '', 'short_desc' );
			$limit = __( '10', 'limit' );
			$feed = __( 'default', 'feed' );
			$imagesize = __( 'Thumbnail', 'imagesize' );
		}
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', RG_LOCALE ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('feed'); ?>"><?php _e('Select Feed:', RG_LOCALE); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('feed'); ?>" name="<?php echo $this->get_field_name('feed'); ?>">
			<option value="default" <?php selected( $feed, "default" ); ?>></option>
			<option value="all" <?php selected( $feed, "all" ); ?>>All Feeds</option>
			<option value="facebook" <?php selected( $feed, "facebook" ); ?>>Facebook</option>
		 	<option value="twitter" <?php selected( $feed, "twitter" ); ?>>Twitter</option>
		 	<option value="instagram" <?php selected( $feed, "instagram" ); ?>>Instagram</option>
		 	<option value="instagramtag" <?php selected( $feed, "instagramtag" ); ?>>Instagram Tag</option>
		</select>
		<small><?php printf( __( "If All Feeds selected usernames will be pulled from the main options.", RG_LOCALE )); ?></small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Username:', RG_LOCALE ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Number of items to show:', RG_LOCALE ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo $instance['limit']; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('imagesize'); ?>"><?php _e('Select Image Size:', RG_LOCALE); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('imagesize'); ?>" name="<?php echo $this->get_field_name('imagesize'); ?>">
			<option value="thumbnail" <?php selected( $imagesize, "thumbnail" ); ?>>Thumbnail</option>
			<option value="standard" <?php selected( $imagesize, "standard" ); ?>>Standard</option>
		</select>
		</p> 
		
		<p><?php printf( __( "The rest of this widget's options are set on the %s plugin settings page%s.", RG_LOCALE ), '<a href="options-general.php?page=rg-options">', '</a>' ); ?></p>
		
	<?php }
	
}

?>