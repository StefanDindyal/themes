<?php

class RG_Options {

	private $sections;
	private $checkboxes;
	private $settings;
	
	public function __construct() {
		$this->checkboxes = array();
		$this->settings = array();
		$this->get_settings();
		
		$this->sections['tour'] = __( 'Tour Settings', RG_LOCALE );
		$this->sections['newsletter'] = __( 'Newsletter Settings', RG_LOCALE );
		$this->sections['feeds'] = __( 'Included Feeds', RG_LOCALE );
		$this->sections['display'] = __( 'Display Settings', RG_LOCALE );
		$this->sections['facebook'] = __( 'Facebook Settings', RG_LOCALE );
		$this->sections['twitter'] = __( 'Twitter Settings', RG_LOCALE );
		$this->sections['instagram'] = __( 'Instagram Settings', RG_LOCALE );
		
		add_action( 'admin_menu', array( &$this, 'add_pages' ) );
		add_action( 'admin_init', array( &$this, 'register_settings' ) );
		
		if ( ! get_option( 'rg_options' ) )
			$this->initialize_settings();
		
	}

	public function add_pages() {
		$admin_page = add_options_page( 'RG Social Options', 'RG Social Options', 'manage_options', 'rg-options', array( &$this, 'display_page' ) );
		add_action( 'admin_print_styles-' . $admin_page, array( &$this, 'admin_styles' ) );		
	}
	public function admin_styles() {
		wp_enqueue_style( 'admin-css', RG_SOCIAL_URL . '/css/admin-panel.css');
	}

	
	public function create_setting( $args = array() ) {
		$defaults = array(
			'id'      => 'default_field',
			'title'   => '',
			'desc'    => '',
			'std'     => '',
			'type'    => 'text',
			'section' => 'general',
			'choices' => array(),
			'class'   => '',
			'width'   => '30%'
		);
		extract( wp_parse_args( $args, $defaults ) );
		
		$field_args = array(
			'type'      => $type,
			'id'        => $id,
			'desc'      => $desc,
			'std'       => $std,
			'choices'   => $choices,
			'label_for' => $id,
			'class'     => $class,
			'width'     => $width
		);
		
		if ( $type == 'checkbox' )
			$this->checkboxes[] = $id;

		add_settings_field( $id, $title, array( $this, 'display_setting' ), 'rg-options', $section, $field_args );
	}
	
	public function display_page() {
		//<div class="icon32" id="icon-options-general"></div>
		echo '<div class="wrap" id="rg-social"><div class="icon"></div>
				<h2>' . __( 'RG Social Options', RG_LOCALE ) . '</h2>';
	
		echo '<div class="has-right-sidebar"><div id="poststuff">';
			$this->sidebar();
		echo '</div>';
		
		echo '<div style="float: left; width: 70%;" >
			<form action="options.php" method="post">';
	
			settings_fields( 'rg_options' );
			do_settings_sections( 'rg-options' );
		echo '<p class="submit"><input name="Submit" type="submit" class="button-primary" value="' . __( 'Save Changes', RG_LOCALE ) . '" /></p>
		</div>
		</form>
		</div>
</div>';
		
	}
	
	public function display_setting( $args = array() ) {
		extract( $args );
		
		$options = get_option( 'rg_options' );
		
		if ( ! isset( $options[$id] ) && $type != 'checkbox' )
			$options[$id] = $std;
		elseif ( ! isset( $options[$id] ) )
			$options[$id] = 0;
		
		$field_class = '';
		if ( $class != '' )
			$field_class = ' ' . $class;
		
		switch ( $type ) {
			case 'checkbox':
				echo '<input class="checkbox'.$field_class.'" type="checkbox" id="'.$id.'" name="rg_options['.$id.']" value="1" '.checked( $options[$id], 1, false ) . ' />';
				if ( $desc != '' )
		 			echo ' <span class="description">' . $desc . '</span>';
				break;
			
			case 'select':
				echo '<select class="select'.$field_class.'" name="rg_options['.$id.']">';
				foreach ( $choices as $value => $label )
					echo '<option value="'.esc_attr( $value ).'"'.selected( $options[$id], $value, false ) .'>'.$label.'</option>';
				echo '</select>';
				if ( $desc != '' )
					echo ' <span class="description">' . $desc . '</span>';
				break;
			
			case 'radio':
				$i = 0;
				foreach ( $choices as $value => $label ) {
					echo '<input class="radio' . $field_class . '" type="radio" name="rg_options[' . $id . ']" id="' . $id . $i . '" value="' . esc_attr( $value ) . '" ' . checked( $options[$id], $value, false ) . '> <label for="' . $id . $i . '">' . $label . '</label>';
					if ( $i < count( $options ) - 1 )
						echo '<br />';
					$i++;
				}
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				break;
			
			case 'textarea':
				echo '<textarea class="' . $field_class . '" id="' . $id . '" name="rg_options[' . $id . ']" placeholder="' . $std . '" rows="5" cols="30">' . wp_htmledit_pre( $options[$id] ) . '</textarea>';
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				break;
			
			case 'password':
				echo '<input class="regular-text' . $field_class . '" type="password" id="' . $id . '" name="rg_options[' . $id . ']" value="' . esc_attr( $options[$id] ) . '" style="width:'.$width.';"/>';
				if ( $desc != '' )
					echo ' <span class="description">' . $desc . '</span>';
				break;
			
			case 'html':
		 		echo $desc;
		 		break;
			
			case 'text':
			default:
		 		echo '<input class="regular-text'.$field_class.'" type="text" id="'.$id.'" name="rg_options['.$id.']" placeholder="'.$std.'" value="' . esc_attr( $options[$id] ) . '" style="width:'.$width.';" />';
		 		if ( $desc != '' )
		 			echo ' <span class="description">' . $desc . '</span>';
		 		
		 		break;
		}
	}

	/* Feeds
		===========================================*/
	public function get_settings() {
		
		$this->settings['tour_id'] = array(
			'title'   => __( 'Bandsintown User Name', RG_LOCALE ),
			'desc'    => sprintf( __( 'The artists username on Bandsintown', RG_LOCALE )),
			'std'     => '',
			'type'    => 'text',
			'section' => 'tour'
		);

		$this->settings['list_id'] = array(
			'title'   => __( 'Newsletter List', RG_LOCALE ),
			'desc'    => sprintf( __( 'The Neolayne List ID', RG_LOCALE )),
			'std'     => '',
			'type'    => 'text',
			'section' => 'newsletter'
		);

		$this->settings['facebook'] = array(
			'title'   => __( 'Facebook username', RG_LOCALE ),
			'desc'    => sprintf( __( '', RG_LOCALE )),
			'std'     => '',
			'type'    => 'text',
			'section' => 'feeds'
		);
		
		$this->settings['twitter'] = array(
			'title'   => __( 'Twitter username', RG_LOCALE ),
			'desc'    => sprintf( __( '', RG_LOCALE )),
			'std'     => '',
			'type'    => 'text',
			'section' => 'feeds'
		);
		
		$this->settings['instagram'] = array(
			'title'   => __( 'Instagram username', RG_LOCALE ),
			'desc'    => sprintf( __( '', RG_LOCALE )),
			'std'     => '',
			'type'    => 'text',
			'section' => 'feeds'
		);
		
		$this->settings['instagramtag'] = array(
			'title'   => __( 'Instagram tag name', RG_LOCALE ),
			'desc'    => sprintf( __( '', RG_LOCALE )),
			'std'     => '',
			'type'    => 'text',
			'section' => 'feeds'
		);
		
		////////// DISPLAY SETTINGS
		
		$this->settings['limit'] = array(
			'title'   => __( 'Limit', RG_LOCALE ),
			'desc'    => sprintf( __( 'Number of items to display.', RG_LOCALE )),
			'std'     => '',
			'type'    => 'text',
			'width'   => '5%',
			'section' => 'display'
		);
		
		$this->settings['fancybox'] = array(
			'title'   => __( 'Enable Fancybox', RG_LOCALE ),
			'desc'    => sprintf( __( 'Check to enable Fancybox Lightbox for all images and videos on Instagram and Facebook images.', RG_LOCALE )),
			'std'     => '',
			'type'    => 'checkbox',
			'section' => 'display'
		);
		
		$this->settings['date'] = array(
			'title'   => __( 'Date Format', RG_LOCALE ),
			'desc'    => sprintf( __( 'Input the date format for Facebook & Twitter %sExample: F j, Y <br/><br/>(If left blank default is time ago ie: 4 minutes ago)%s <br/>%sDocumentation on date and time formatting.%s', RG_LOCALE ), '<strong>', '</strong>', '<a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">', '</a>'),
			'std'     => '',
			'type'    => 'text',
			'section' => 'display',
			'width'   => '7%'
		);
		
		////////// FACEBOOK SETTINGS
		
		$this->settings['media'] = array(
			'title'   => __( 'Media', RG_LOCALE ),
			'desc'    => sprintf( __( 'Check to disable images and videos on each post.', RG_LOCALE )),
			'std'     => '',
			'type'    => 'checkbox',
			'section' => 'facebook'
		);
		
		$this->settings['mediasize'] = array(
			'title'   => __( 'Mediasize', RG_LOCALE ),
			'desc'    => sprintf( __( 'Select the media size for Facebook images %s(thumbnail is the default)%s', RG_LOCALE ), '<strong>', '</strong>'),
			'std'     => '',
			'type'    => 'select',
			'section' => 'facebook',
			'choices' => array(
				'thumbnail' => 'Thumbnail',
				'large' => 'Large'
			)
		);
		
		////////// TWITTER SETTINGS
		
		$this->settings['avatar'] = array(
			'title'   => __( 'User Avatar', RG_LOCALE ),
			'desc'    => sprintf( __( 'Check to disable the avatar image.', RG_LOCALE )),
			'std'     => '',
			'type'    => 'checkbox',
			'section' => 'twitter'
		);
		
		$this->settings['intent'] = array(
			'title'   => __( 'Reply, Retweet & Favorite', RG_LOCALE ),
			'desc'    => sprintf( __( 'Check to disable the Reply, Retweet & Favorite options.', RG_LOCALE )),
			'std'     => '',
			'type'    => 'checkbox',
			'section' => 'twitter'
		);
		
		////////// INSTAGRAM SETTINGS
		
		$this->settings['mediatype'] = array(
			'title'   => __( 'Mediatype', RG_LOCALE ),
			'desc'    => sprintf( __( 'Select the media type for Instagram.', RG_LOCALE )),
			'std'     => '',
			'type'    => 'select',
			'section' => 'instagram',
			'choices' => array(
				'all' => 'All items',
				'photos' => 'Photos only',
				'videos' => 'Videos only'
			)
		);
		
		$this->settings['imagesize'] = array(
			'title'   => __( 'Imagesize', RG_LOCALE ),
			'desc'    => sprintf( __( 'Select the media size for Instagram %s(standard is the default if left blank)%s', RG_LOCALE ), '<strong>', '</strong>'),
			'std'     => '',
			'type'    => 'select',
			'section' => 'instagram',
			'choices' => array(
				'' => '',
				'thumbnail' => 'Thumbnail - 150x150',
				'standard' => 'Standard - 306x306',
				'large' => 'Large - 612x612'
			)
		);
		
		$this->settings['caption'] = array(
			'title'   => __( 'Caption', RG_LOCALE ),
			'desc'    => sprintf( __( 'Check to disable captions from images.', RG_LOCALE )),
			'std'     => '',
			'type'    => 'checkbox',
			'section' => 'instagram'
		);
		
	}

	public function display_section() {
		// code
	}
	
	public function initialize_settings() {
		$default_settings = array();
		foreach ( $this->settings as $id => $setting )
			$default_settings[$id] = $setting['std'];
		
		update_option( 'rg_options', $default_settings );
	}
	
	public function register_settings() {
		register_setting( 'rg_options', 'rg_options', array ( &$this, 'validate_settings' ) );
		
		foreach ( $this->sections as $slug => $title )
			add_settings_section( $slug, $title, array( &$this, 'display_section' ), 'rg-options' );
		
		$this->get_settings();
		
		foreach ( $this->settings as $id => $setting ) {
			$setting['id'] = $id;
			$this->create_setting( $setting );
		}
	}
	
	
	public function sidebar() {
		
		echo '<div id="side-info-column" class="inner-sidebar" style="width: 25%;">';
		
		/* Instructions
		========================================================*/
		echo '<div class="postbox">
				<h3 class="hndle">' . __( 'How to Use', RG_LOCALE ) . '</h3>
				<div class="inside">';
		
		echo '<h4>' . __( 'Shortcode', RG_LOCALE ) . '</h4>
		<p>' . __( 'To insert a mashup into any post or page, use this shortcode in the content area:', RG_LOCALE ) . '</p>
		<pre class="smm-pre">echo do_shortcode("[rg_socialfeed feedname="feeduser"]")</pre>
		<p>' . sprintf( __( 'Change "feedname" and "feeduser" to call individual feeds.', RG_LOCALE )) . '</p>
		<p>' . sprintf( __( 'These options can be called with the shortcode as well: <br/> limit, mediatype, imagesize, mediasize ', RG_LOCALE )) . '</p>
		<h4>' . __( 'Template Tag', RG_LOCALE ) . '</h4>
		<p>' . __( 'Insert this code into your theme to display a mashup:', RG_LOCALE ) . '</p>' . 
		"<pre class='smm-pre'>if (function_exists('rg_socialfeed'))rg_socialfeed();</pre>" . 
		'<p>' . sprintf( __( 'This will call all feeds at once. And sort them by time created.', RG_LOCALE )) . '</p>';
		
		echo '</div>
			</div>';
		
		/* Credits
		========================================================*/
		echo '<div class="postbox credits">
				<h3 class="hndle">' . __( 'Credits', RG_LOCALE ) . '</h3>
				<div class="inside">';
		
		echo '<ul>
			<li>' . __( 'Author:', RG_LOCALE ) . ' <a href="http://www.rgenerator.com/" target="_blank">RGenerator</a></li>
		</ul>';
		echo '</div>
			</div>';
		echo '</div>';
		
	}
	
	public function validate_settings( $input ) {
		$options = get_option( 'rg_options' );
		
		foreach ( $this->checkboxes as $id ) {
			if ( isset( $options[$id] ) && ! isset( $input[$id] ) )
				unset( $options[$id] );
		}
		
		return $input;
	}
	
}//END

$RG_Options = new RG_Options();

?>