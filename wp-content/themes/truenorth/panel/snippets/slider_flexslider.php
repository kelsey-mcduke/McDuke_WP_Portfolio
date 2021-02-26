<?php global $ci, $ci_defaults, $load_defaults, $content_width; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	$ci_defaults['slider_autoslide'] = 'enabled';
	$ci_defaults['slider_effect']    = 'fade';
	$ci_defaults['slider_direction'] = 'horizontal';
	$ci_defaults['slider_speed']     = 3000;
	$ci_defaults['slider_duration']  = 600;

	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_slider_flexslider', 10, 2 );
	function truenorth_panel_sanitize_snippet_slider_flexslider( $values, $defaults ) {
		$values['slider_effect']    = in_array( $values['slider_effect'], array( 'fade', 'slide' ), true ) ? $values['slider_effect'] : $defaults['slider_effect'];
		$values['slider_direction'] = in_array( $values['slider_direction'], array( 'horizontal', 'vertical' ), true ) ? $values['slider_direction'] : $defaults['slider_direction'];
		$values['slider_speed']     = absint( $values['slider_speed'] );
		$values['slider_duration']  = absint( $values['slider_duration'] );

		return $values;
	}
?>
<?php else : ?>

	<fieldset id="ci-panel-slider-flexslider" class="set">
		<legend><?php esc_html_e( 'Main Slider', 'truenorth' ); ?></legend>
		<p class="guide"><?php esc_html_e( 'The following options control the main slider. You may enable or disable auto-sliding by checking the appropriate option and further control its behavior.', 'truenorth' ); ?></p>

		<fieldset id="flexslider-slider-autoslide">
			<?php ci_panel_checkbox( 'slider_autoslide', 'enabled', __( 'Enable auto-slide', 'truenorth' ) ); ?>
		</fieldset>

		<fieldset id="flexslider-slider-effect">
			<?php
				$slider_effects = array(
					'fade'  => _x( 'Fade', 'slider effect', 'truenorth' ),
					'slide' => _x( 'Slide', 'slider effect', 'truenorth' ),
				);
				ci_panel_dropdown( 'slider_effect', $slider_effects, __( 'Slider Effect', 'truenorth' ) );
			?>
		</fieldset>

		<fieldset id="flexslider-slider-direction">
			<?php
				$slider_direction = array(
					'horizontal' => _x( 'Horizontal', 'slider direction', 'truenorth' ),
					'vertical'   => _x( 'Vertical', 'slider direction', 'truenorth' ),
				);
				ci_panel_dropdown( 'slider_direction', $slider_direction, __( 'Slide Direction (only for <b>Slide</b> effect)', 'truenorth' ) );
			?>
		</fieldset>

		<fieldset id="flexslider-slider-speed">
			<?php ci_panel_input( 'slider_speed', __( 'Slideshow speed in milliseconds (smaller number means faster)', 'truenorth' ) ); ?>
		</fieldset>

		<fieldset id="flexslider-slider-duration">
			<?php ci_panel_input( 'slider_duration', __( 'Animation duration in milliseconds (smaller number means faster)', 'truenorth' ) ); ?>
		</fieldset>
	</fieldset>

<?php endif;
