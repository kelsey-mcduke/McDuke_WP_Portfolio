<?php global $ci, $ci_defaults, $load_defaults, $content_width; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	$ci_defaults['internal_slider_autoslide'] = 'enabled';
	$ci_defaults['internal_slider_effect']    = 'fade';
	$ci_defaults['internal_slider_direction'] = 'horizontal';
	$ci_defaults['internal_slider_speed']     = 3000;
	$ci_defaults['internal_slider_duration']  = 600;

	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_slider_flexslider_internal', 10, 2 );
	function truenorth_panel_sanitize_snippet_slider_flexslider_internal( $values, $defaults ) {
		$values['internal_slider_effect']    = in_array( $values['internal_slider_effect'], array( 'fade', 'slide' ), true ) ? $values['internal_slider_effect'] : $defaults['internal_slider_effect'];
		$values['internal_slider_direction'] = in_array( $values['internal_slider_direction'], array( 'horizontal', 'vertical' ), true ) ? $values['internal_slider_direction'] : $defaults['internal_slider_direction'];
		$values['internal_slider_speed']     = absint( $values['internal_slider_speed'] );
		$values['internal_slider_duration']  = absint( $values['internal_slider_duration'] );

		return $values;
	}
?>
<?php else : ?>

	<fieldset id="ci-panel-slider-flexslider-internal" class="set">
		<legend><?php esc_html_e( 'Internal Slider', 'truenorth' ); ?></legend>
		<p class="guide"><?php esc_html_e( 'The following options control the internal slider. You may enable or disable auto-sliding by checking the appropriate option and further control its behavior.', 'truenorth' ); ?></p>
		<fieldset id="internal-flexslider-slider-autoslide">
			<?php ci_panel_checkbox( 'internal_slider_autoslide', 'enabled', __( 'Enable auto-slide', 'truenorth' ) ); ?>
		</fieldset>
		<fieldset id="internal-flexslider-slider-effect">
			<?php
				$slider_effects = array(
					'fade'  => _x( 'Fade', 'slider effect', 'truenorth' ),
					'slide' => _x( 'Slide', 'slider effect', 'truenorth' ),
				);
				ci_panel_dropdown( 'internal_slider_effect', $slider_effects, __( 'Slider Effect', 'truenorth' ) );
			?>
		</fieldset>
		<fieldset id="internal-flexslider-slider-direction">
			<?php
				$slider_direction = array(
					'horizontal' => _x( 'Horizontal', 'slider direction', 'truenorth' ),
					'vertical'   => _x( 'Vertical', 'slider direction', 'truenorth' ),
				);
				ci_panel_dropdown( 'internal_slider_direction', $slider_direction, __( 'Slide Direction (only for <b>Slide</b> effect)', 'truenorth' ) );
			?>
		</fieldset>
		<fieldset id="internal-flexslider-slider-speed">
			<?php ci_panel_input( 'internal_slider_speed', __( 'Slideshow speed in milliseconds (smaller number means faster)', 'truenorth' ) ); ?>
		</fieldset>
		<fieldset id="internal-flexslider-slider-duration">
			<?php ci_panel_input( 'internal_slider_duration', __( 'Animation duration in milliseconds (smaller number means faster)', 'truenorth' ) ); ?>
		</fieldset>
	</fieldset>

<?php endif;
