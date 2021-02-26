<?php
if ( ! class_exists( 'CI_Widget_Text' ) ) :
class CI_Widget_Text extends WP_Widget {

	protected $defaults = array(
		'title'  => '',
		'text'   => '',
		'filter' => 0,
		'align'  => 'text-left',
	);

	public function __construct() {
		$widget_ops  = array( 'description' => __( 'Deprecated widget. Aligned arbitrary text or HTML.', 'truenorth' ) );
		$control_ops = array();

		parent::__construct( 'ci-text', __( 'Theme (home) - Text (deprecated)', 'truenorth' ), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		/**
		 * Filter the content of the Text widget.
		 *
		 * @since 2.3.0
		 *
		 * @param string    $widget_text The widget content.
		 * @param WP_Widget $instance    WP_Widget instance.
		 */
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );

		$align = $instance['align'];

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		?><div class="ci-text-widget <?php echo esc_attr( $align ); ?>"><?php echo wp_kses_post( ! empty( $instance['filter'] ) ? wpautop( $text ) : $text ); ?></div><?php

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) ); // wp_filter_post_kses() expects slashed
		}

		$instance['filter'] = ! empty( $new_instance['filter'] );

		$instance['align'] = in_array( $new_instance['align'], array( 'text-left', 'text-center', 'text-right', 'text-justify' ), true ) ? $new_instance['align'] : $this->defaults['align'];

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title  = $instance['title'];
		$text   = $instance['text'];
		$filter = $instance['filter'];
		$align  = $instance['align'];

		?>
		<p><em><?php echo wp_kses( __( 'This widget has been deprecated in favor of the native <strong>Text</strong> widget which, since WordPress v4.8, supports a visual editor that allows you to align the text as needed. You are strongly encouraged to use that widget instead.', 'truenorth' ), truenorth_get_allowed_tags( 'guide' ) ); ?></em></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'truenorth' ); ?></label><input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text:', 'truenorth' ); ?></label><textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_textarea( $text ); ?></textarea></p>

		<p><input id="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'filter' ) ); ?>" type="checkbox" <?php checked( 1, $filter ); ?> /> <label for="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>"><?php esc_html_e( 'Automatically add paragraphs', 'truenorth' ); ?></label></p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'align' ) ); ?>"><?php esc_html_e( 'Align text:', 'truenorth' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'align' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'align' ) ); ?>" class="widefat">
				<option value="text-left" <?php selected( $align, 'text-left' ); ?>><?php echo esc_html_x( 'Left', 'text align', 'truenorth' ); ?></option>
				<option value="text-center" <?php selected( $align, 'text-center' ); ?>><?php echo esc_html_x( 'Center', 'text align', 'truenorth' ); ?></option>
				<option value="text-right" <?php selected( $align, 'text-right' ); ?>><?php echo esc_html_x( 'Right', 'text align', 'truenorth' ); ?></option>
				<option value="text-justify" <?php selected( $align, 'text-justify' ); ?>><?php echo esc_html_x( 'Justify', 'text align', 'truenorth' ); ?></option>
			</select>
		</p>
		<?php
	}
}

register_widget( 'CI_Widget_Text' );

endif;
