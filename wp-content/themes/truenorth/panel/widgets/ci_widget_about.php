<?php
if ( ! class_exists( 'CI_About' ) ) :

class CI_About extends WP_Widget {
	protected $defaults = array(
		'title'    => '',
		'ci_image' => '',
		'ci_about' => '',
		'ci_align' => 'alignleft',
	);

	public function __construct() {
		$widget_ops  = array( 'description' => __( 'About me widget', 'truenorth' ) );
		$control_ops = array();

		parent::__construct( 'ci_about_widget', $name = __( 'Theme - About Me', 'truenorth' ), $widget_ops, $control_ops );

		// These are needed for compatibility with older versions where the title field was named title
		add_filter( 'widget_display_callback', array( $this, '_rename_old_title_field' ), 10, 2 );
		add_filter( 'widget_form_callback', array( $this, '_rename_old_title_field' ), 10, 2 );
	}

	// This is needed for compatibility with older versions where the title field was named title
	public function _rename_old_title_field( $instance, $_this ) {
		$old_field = 'ci_title';
		$class     = get_class( $this );

		if ( get_class( $_this ) === $class && ! isset( $instance['title'] ) && isset( $instance[ $old_field ] ) ) {
			$instance['title'] = $instance[ $old_field ];
			unset( $instance[ $old_field ] );
		}

		return $instance;
	}

	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$title = ci_get_string_translation( 'About Me - Title', $title, 'Widgets' );

		$ci_image = $instance['ci_image'];
		$ci_align = $instance['ci_align'];

		/*
		 * While we've renamed ci_title to title, we can't remove the ci_get_string_translation()
		 * and ci_register_string_translation() calls, so that we won't break any existing installations
		 * with titles translated.
		 * Titles translated with the old method will continue to work. If a new translation exists via
		 * the 'widget_title' filter, then ci_get_string_translation() will not match anything, so the new
		 * translation will be used, as expected.
		 */
		$ci_about = ci_get_string_translation( 'About Me - Text', $instance['ci_about'], 'Widgets' );

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div class="widget_about group">';

			if ( $ci_image ) {
				echo '<img src="' . esc_url( $ci_image ) . '" class="' . esc_attr( $ci_align ) . '" alt="' . esc_attr( $title ) . '" />';
			}

			echo $ci_about;

		echo '</div>';

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']    = sanitize_text_field( $new_instance['title'] );
		$instance['ci_image'] = esc_url_raw( $new_instance['ci_image'] );
		$instance['ci_align'] = in_array( $new_instance['ci_align'], array( 'alignnone', 'alignleft', 'alignright' ), true ) ? $new_instance['ci_align'] : $this->defaults['ci_align'];
		$instance['ci_about'] = wp_kses_post( $new_instance['ci_about'] );

		ci_register_string_translation( 'About Me - Title', $instance['title'], 'Widgets' );
		ci_register_string_translation( 'About Me - Text', $instance['ci_about'], 'Widgets' );

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title    = $instance['title'];
		$ci_image = $instance['ci_image'];
		$ci_align = $instance['ci_align'];
		$ci_about = $instance['ci_about'];

		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'truenorth' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat" /></p>

		<p class="truenorth-upload-input">
			<label for="<?php echo esc_attr( $this->get_field_id( 'ci_image' ) ); ?>">
				<?php esc_html_e( 'Image:', 'truenorth' ); ?>
			</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'ci_image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ci_image' ) ); ?>" type="text" value="<?php echo esc_attr( $ci_image ); ?>" class="uploaded widefat"/>
			<a href="#" class="button ci-upload"><?php esc_html_e( 'Select', 'truenorth' ); ?></a>
		</p>

		<p>
			<label for="<?php echo esc_attr( esc_attr( $this->get_field_id( 'ci_align' ) ) ); ?>"><?php __( 'Image alignment:', 'truenorth' ); ?></label>
			<select name="<?php echo esc_attr( esc_attr( $this->get_field_name( 'ci_align' ) ) ); ?>" class="widefat" id="<?php echo esc_attr( esc_attr( $this->get_field_id( 'ci_align' ) ) ); ?>">
				<option value="alignnone" <?php selected( $ci_align, 'alignnone' ); ?>><?php echo esc_html_x( 'None', 'alignment', 'truenorth' ); ?></option>
				<option value="alignleft" <?php selected( $ci_align, 'alignleft' ); ?>><?php echo esc_html_x( 'Left', 'alignment', 'truenorth' ); ?></option>
				<option value="alignright" <?php selected( $ci_align, 'alignright' ); ?>><?php echo esc_html_x( 'Right', 'alignment', 'truenorth' ); ?></option>
			</select>
		</p>
		<?php

		echo '<p><label for="' . esc_attr( $this->get_field_id( 'ci_about' ) ) . '">' . esc_html__( 'About text:', 'truenorth' ) . '</label><textarea rows="10" id="' . esc_attr( $this->get_field_id( 'ci_about' ) ) . '" name="' . esc_attr( $this->get_field_name( 'ci_about' ) ) . '" class="widefat" >' . esc_textarea( $ci_about ) . '</textarea></p>';
	}

}

register_widget( 'CI_About' );

endif;
