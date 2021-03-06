<?php global $ci, $ci_defaults, $load_defaults, $content_width; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	$ci_defaults['slider_autoslide'] = 'enabled';
	$ci_defaults['slider_timeout']   = 3000;
	$ci_defaults['slider_speed']     = 500;
	$ci_defaults['slider_effect']    = 'scrollRight';
	$ci_defaults['slider_sync']      = 'enabled';

	function truenorth_panel_snippet_slider_cycle_effects() {
		return array(
			'none'        => _x( 'None', 'slider effect', 'truenorth' ),
			'cover'       => _x( 'Cover', 'slider effect', 'truenorth' ),
			'uncover'     => _x( 'Uncover', 'slider effect', 'truenorth' ),
			'fade'        => _x( 'Fade', 'slider effect', 'truenorth' ),
			'fadeZoom'    => _x( 'Fade Zoom', 'slider effect', 'truenorth' ),
			'shuffle'     => _x( 'Shuffle', 'slider effect', 'truenorth' ),
			'toss'        => _x( 'Toss', 'slider effect', 'truenorth' ),
			'wipe'        => _x( 'Wipe', 'slider effect', 'truenorth' ),
			'zoom'        => _x( 'Zoom', 'slider effect', 'truenorth' ),
			'scrollVert'  => _x( 'Scroll Vertically', 'slider effect', 'truenorth' ),
			'scrollHorz'  => _x( 'Scroll Horizontally', 'slider effect', 'truenorth' ),
			'scrollLeft'  => _x( 'Scroll Left', 'slider effect', 'truenorth' ),
			'scrollRight' => _x( 'Scroll Right', 'slider effect', 'truenorth' ),
			'scrollUp'    => _x( 'Scroll Up', 'slider effect', 'truenorth' ),
			'scrollDown'  => _x( 'Scroll Down', 'slider effect', 'truenorth' ),
			'blindX'      => _x( 'Blind X', 'slider effect', 'truenorth' ),
			'blindY'      => _x( 'Blind Y', 'slider effect', 'truenorth' ),
			'blindZ'      => _x( 'Blind Z', 'slider effect', 'truenorth' ),
			'curtainX'    => _x( 'Curtain X', 'slider effect', 'truenorth' ),
			'curtainY'    => _x( 'Curtain Y', 'slider effect', 'truenorth' ),
			'growX'       => _x( 'Grow X', 'slider effect', 'truenorth' ),
			'growY'       => _x( 'Grow Y', 'slider effect', 'truenorth' ),
			'slideX'      => _x( 'Slide X', 'slider effect', 'truenorth' ),
			'slideY'      => _x( 'Slide Y', 'slider effect', 'truenorth' ),
			'turnUp'      => _x( 'Turn Up', 'slider effect', 'truenorth' ),
			'turnDown'    => _x( 'Turn Down', 'slider effect', 'truenorth' ),
			'turnLeft'    => _x( 'Turn Left', 'slider effect', 'truenorth' ),
			'turnRight'   => _x( 'Turn Right', 'slider effect', 'truenorth' ),
		);
	}


	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_slider_cycle', 10, 2 );
	function truenorth_panel_sanitize_snippet_slider_cycle( $values, $defaults ) {
		$values['slider_autoslide'] = 'enabled' === $values['slider_autoslide'] ? 'enabled' : '';
		$values['slider_timeout']   = absint( $values['slider_timeout'] );
		$values['slider_effect']    = array_key_exists( $values['slider_effect'], truenorth_panel_snippet_slider_cycle_effects() ) ? $values['slider_effect'] : $defaults['slider_effect'];
		$values['slider_speed']     = absint( $values['slider_speed'] );
		$values['slider_sync']      = 'enabled' === $values['slider_sync'] ? 'enabled' : '';

		return $values;
	}
?>
<?php else : ?>

	<fieldset id="ci-panel-slider-cycle" class="set">
		<legend><?php esc_html_e( 'Main Slider', 'truenorth' ); ?></legend>
		<p class="guide">
			<?php
				/* translators: %s is a url. */
				echo wp_kses( sprintf( __( 'The following options control the main slider. You may enable auto-sliding by checking the appropriate option, or by setting the auto-slide timeout to a value grater than 0. A demo of the transition effects can be seen <a href="%s">here</a>.', 'truenorth' ), 'http://jquery.malsup.com/cycle/browser.html' ), truenorth_get_allowed_tags( 'guide' ) );
			?>
		</p>

		<fieldset>
			<?php ci_panel_checkbox( 'slider_autoslide', 'enabled', __( 'Enable auto-slide', 'truenorth' ) ); ?>
		</fieldset>

		<fieldset>
			<?php ci_panel_input( 'slider_timeout', __( 'Auto-slide timeout (milliseconds)', 'truenorth' ) ); ?>
		</fieldset>

		<fieldset>
			<?php ci_panel_dropdown( 'slider_effect', truenorth_panel_snippet_slider_cycle_effects(), __( 'Slider Effect', 'truenorth' ) ); ?>
		</fieldset>

		<fieldset>
			<?php ci_panel_input( 'slider_speed', __( 'Slideshow speed in milliseconds (smaller number means faster)', 'truenorth' ) ); ?>
		</fieldset>

		<fieldset>
			<?php ci_panel_checkbox( 'slider_sync', 'enabled', __( 'Enable synchronized sliding', 'truenorth' ) ); ?>
		</fieldset>
	</fieldset>

<?php endif;
