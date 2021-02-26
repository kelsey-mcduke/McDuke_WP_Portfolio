<?php
if ( ! class_exists( 'CI_BSA' ) ) :
class CI_BSA extends WP_Widget {

	protected $defaults = array(
		'code' => '',
	);

	public function __construct() {
		$widget_ops  = array( 'description' => __( 'BuySellAds.com Integration', 'truenorth' ) );
		$control_ops = array();

		parent::__construct( 'ci_buysellads_widget', $name = __( 'Theme - BuySellAds.com', 'truenorth' ), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$code = $instance['code'];
		echo $args['before_widget'];
		echo '<div class="group">' . $code . '</div>';
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance         = $old_instance;
		$instance['code'] = stripslashes( $new_instance['code'] );

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$code = $instance['code'];

		echo '<p><label for="' . esc_attr( $this->get_field_id( 'code' ) ) . '">' . esc_html__( 'Zone Code:', 'truenorth' ) . '</label><textarea rows="10" id="' . esc_attr( $this->get_field_id( 'code' ) ) . '" name="' . esc_attr( $this->get_field_name( 'code' ) ) . '" class="widefat" >' . esc_textarea( $code ) . '</textarea></p>';
		echo '<p>' . wp_kses( sprintf( __( 'Paste your <strong>Zone Code</strong> here, as described in this <a href="%s">BuySellAds tutorial</a>.', 'truenorth' ), esc_url( 'http://support.buysellads.com/knowledge_base/topics/how-to-install-your-ad-code' ) ), truenorth_get_allowed_tags( 'guide' ) ) . '</p>';
	}

}

register_widget( 'CI_BSA' );

endif;
