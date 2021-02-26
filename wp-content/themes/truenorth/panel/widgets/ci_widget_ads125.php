<?php
if ( ! class_exists( 'CI_Ads125' ) ) :
class CI_Ads125 extends WP_Widget {

	protected $defaults = array(
		'title'      => '',
		'ci_random'  => '',
		'ci_new_win' => '',
		'ci_b1url'   => '', 'ci_b1lin' => '', 'ci_b1tit' => '',
		'ci_b2url'   => '', 'ci_b2lin' => '', 'ci_b2tit' => '',
		'ci_b3url'   => '', 'ci_b3lin' => '', 'ci_b3tit' => '',
		'ci_b4url'   => '', 'ci_b4lin' => '', 'ci_b4tit' => '',
		'ci_b5url'   => '', 'ci_b5lin' => '', 'ci_b5tit' => '',
		'ci_b6url'   => '', 'ci_b6lin' => '', 'ci_b6tit' => '',
		'ci_b7url'   => '', 'ci_b7lin' => '', 'ci_b7tit' => '',
		'ci_b8url'   => '', 'ci_b8lin' => '', 'ci_b8tit' => '',
	);

	public function __construct() {
		$widget_ops  = array( 'description' => __( 'Display 125x125 Banners', 'truenorth' ) );
		$control_ops = array();

		parent::__construct( 'ci_ads125_widget', $name = __( 'Theme - 125x125 Ads', 'truenorth' ), $widget_ops, $control_ops );

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

		/*
		 * While we've renamed ci_title to title, we can't remove the ci_get_string_translation()
		 * and ci_register_string_translation() calls, so that we won't break any existing installations
		 * with titles translated.
		 * Titles translated with the old method will continue to work. If a new translation exists via
		 * the 'widget_title' filter, then ci_get_string_translation() will not match anything, so the new
		 * translation will be used, as expected.
		 */
		$title = ci_get_string_translation( 'Ads125 - Title', $title, 'Widgets' );

		$ci_random  = $instance['ci_random'];
		$ci_new_win = isset( $instance['ci_new_win'] ) ? $instance['ci_new_win'] : '';

		$b = array();
		for ( $i = 1; $i <= 8; $i ++ ) {
			$b[ $i ]['url'] = $instance[ 'ci_b' . $i . 'url' ];
			$b[ $i ]['lin'] = $instance[ 'ci_b' . $i . 'lin' ];
			$b[ $i ]['tit'] = ci_get_string_translation( 'Ads125 - Banner Title', $instance[ 'ci_b' . $i . 'tit' ], 'Widgets' );
		}

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<ul id="ads125" class="ads125 group">';

		if ( 'random' === $ci_random ) {
			shuffle( $b );
		}

		$target = '';
		if ( 'enabled' === $ci_new_win ) {
			$target = ' target="_blank" ';
		}

		$i = 1;
		foreach ( $b as $key => $value ) {
			if ( ! empty( $value['url'] ) ) {
				if ( 0 === $i % 2 ) {
					echo wp_kses_post( '<li class="last"><a href="' . esc_url( $value['lin'] ) . '" ' . $target . ' ><img src="' . esc_url( $value['url'] ) . '" alt="' . esc_attr( $value['tit'] ) . '" /></a></li>' );
				} else {
					echo wp_kses_post( '<li><a href="' . esc_url( $value['lin'] ) . '" ' . $target . ' ><img src="' . esc_url( $value['url'] ) . '" alt="' . esc_attr( $value['tit'] ) . '" /></a></li>' );
				}
			}
			$i ++;
		}

		echo '</ul>';

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']      = sanitize_text_field( $new_instance['title'] );
		$instance['ci_random']  = ci_sanitize_checkbox( $new_instance['ci_random'], 'random' );
		$instance['ci_new_win'] = ci_sanitize_checkbox( $new_instance['ci_new_win'], 'enabled' );

		ci_register_string_translation( 'Ads125 - Title', $instance['title'], 'Widgets' );

		for ( $i = 1; $i <= 8; $i ++ ) {
			$instance[ 'ci_b' . $i . 'url' ] = esc_url_raw( $new_instance[ 'ci_b' . $i . 'url' ] );
			$instance[ 'ci_b' . $i . 'lin' ] = esc_url_raw( $new_instance[ 'ci_b' . $i . 'lin' ] );
			$instance[ 'ci_b' . $i . 'tit' ] = sanitize_title( $new_instance[ 'ci_b' . $i . 'tit' ] );

			ci_register_string_translation( 'Ads125 - Banner Title', $instance[ 'ci_b' . $i . 'tit' ], 'Widgets' );
		}

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo '<p><label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title:', 'truenorth' ) . '</label><input id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $instance['title'] ) . '" class="widefat" /></p>';
		echo '<p><input id="' . esc_attr( $this->get_field_id( 'ci_random' ) ) . '" name="' . esc_attr( $this->get_field_name( 'ci_random' ) ) . '" type="checkbox"' . checked( $instance['ci_random'], 'random', false ) . ' value="random" /> <label for="' . esc_attr( $this->get_field_id( 'ci_random' ) ) . '">' . esc_html__( 'Display ads in random order.', 'truenorth' ) . '</label></p>';
		echo '<p><input id="' . esc_attr( $this->get_field_id( 'ci_new_win' ) ) . '" name="' . esc_attr( $this->get_field_name( 'ci_new_win' ) ) . '" type="checkbox"' . checked( $instance['ci_new_win'], 'enabled', false ) . ' value="enabled" /> <label for="' . esc_attr( $this->get_field_id( 'ci_new_win' ) ) . '">' . esc_html__( 'Open ads in new window.', 'truenorth' ) . '</label></p>';

		for ( $i = 1; $i <= 8; $i ++ ) {
			?><p><?php
			$url = $instance[ 'ci_b' . $i . 'url' ];
			$lin = $instance[ 'ci_b' . $i . 'lin' ];
			$tit = $instance[ 'ci_b' . $i . 'tit' ];
			echo '<label for="' . esc_attr( $this->get_field_id( 'ci_b' . $i . 'url' ) ) . '">' . sprintf( esc_html__( 'Banner #%d URL', 'truenorth' ), intval( $i ) ) . '</label><input id="' . esc_attr( $this->get_field_id( 'ci_b' . $i . 'url' ) ) . '" name="' . esc_attr( $this->get_field_name( 'ci_b' . $i . 'url' ) ) . '" type="text" value="' . esc_attr( $url ) . '" class="widefat" />';
			echo '<label for="' . esc_attr( $this->get_field_id( 'ci_b' . $i . 'lin' ) ) . '">' . sprintf( esc_html__( 'Banner #%d Link', 'truenorth' ), intval( $i ) ) . '</label><input id="' . esc_attr( $this->get_field_id( 'ci_b' . $i . 'lin' ) ) . '" name="' . esc_attr( $this->get_field_name( 'ci_b' . $i . 'lin' ) ) . '" type="text" value="' . esc_attr( $lin ) . '" class="widefat" />';
			echo '<label for="' . esc_attr( $this->get_field_id( 'ci_b' . $i . 'tit' ) ) . '">' . sprintf( esc_html__( 'Banner #%d Title', 'truenorth' ), intval( $i ) ) . '</label><input id="' . esc_attr( $this->get_field_id( 'ci_b' . $i . 'tit' ) ) . '" name="' . esc_attr( $this->get_field_name( 'ci_b' . $i . 'tit' ) ) . '" type="text" value="' . esc_attr( $tit ) . '" class="widefat" />';
			?></p><?php
		}


	}

}

register_widget( 'CI_Ads125' );

endif;
