<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	// Main body
	$ci_defaults['bg_custom_migrated']  = false;
	$ci_defaults['bg_custom_disabled']  = 'enabled';
	$ci_defaults['bg_color']            = '';
	$ci_defaults['bg_image_disable']    = '';
	$ci_defaults['bg_image']            = '';
	$ci_defaults['bg_image_repeat']     = 'repeat';
	$ci_defaults['bg_image_horizontal'] = 'left';
	$ci_defaults['bg_image_vertical']   = 'top';
	$ci_defaults['bg_image_attachment'] = '';
	$ci_defaults['bg_image_size']       = '';
	$ci_defaults['bg_image_size_value'] = '';

	// Header
	$ci_defaults['bg_h_custom_disabled']  = 'enabled';
	$ci_defaults['bg_h_color']            = '';
	$ci_defaults['bg_h_image_disable']    = '';
	$ci_defaults['bg_h_image']            = '';
	$ci_defaults['bg_h_image_repeat']     = 'repeat';
	$ci_defaults['bg_h_image_horizontal'] = 'left';
	$ci_defaults['bg_h_image_vertical']   = 'top';
	$ci_defaults['bg_h_image_attachment'] = '';
	$ci_defaults['bg_h_image_size']       = '';
	$ci_defaults['bg_h_image_size_value'] = '';

	// Footer
	$ci_defaults['bg_f_custom_disabled']  = 'enabled';
	$ci_defaults['bg_f_color']            = '';
	$ci_defaults['bg_f_image_disable']    = '';
	$ci_defaults['bg_f_image']            = '';
	$ci_defaults['bg_f_image_repeat']     = 'repeat';
	$ci_defaults['bg_f_image_horizontal'] = 'left';
	$ci_defaults['bg_f_image_vertical']   = 'top';
	$ci_defaults['bg_f_image_attachment'] = '';
	$ci_defaults['bg_f_image_size']       = '';
	$ci_defaults['bg_f_image_size_value'] = '';

	add_action( 'admin_init', 'truenorth_maybe_migrate_custom_background_to_customizer' );
	function truenorth_maybe_migrate_custom_background_to_customizer() {
		if ( ! is_admin() || wp_doing_ajax() || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
			return;
		}

		global $ci;

		if ( ! current_theme_supports( 'custom-background' ) || $ci['bg_custom_migrated'] ) {
			return;
		}

		if ( 'enabled' === $ci['bg_custom_disabled'] ) {
			$ci['bg_color'] = '';
			$ci['bg_image'] = '';
		} else {
			$ci['bg_custom_disabled'] = 'enabled';
			set_theme_mod( 'background_color', sanitize_hex_color_no_hash( $ci['bg_color'] ) );
			set_theme_mod( 'background_image', esc_url_raw( $ci['bg_image'] ) );
			set_theme_mod( 'background_preset', 'custom' );
			set_theme_mod( 'background_position_x', $ci['bg_image_horizontal'] );
			set_theme_mod( 'background_position_y', $ci['bg_image_vertical'] );
			set_theme_mod( 'background_repeat', $ci['bg_image_repeat'] );
			set_theme_mod( 'background_attachment', 'fixed' === $ci['bg_image_attachment'] ? 'fixed' : 'scroll' );
			if ( in_array( $ci['bg_image_size'], array( 'contain', 'cover' ), true ) ) {
				set_theme_mod( 'background_size', $ci['bg_image_size'] );
			} else {
				set_theme_mod( 'background_size', 'auto' );
			}
		}

		$ci['bg_custom_migrated'] = true;
		update_option( THEME_OPTIONS, $ci );
	}

	// 100 is the priority. It's important to be a big number, i.e. low priority.
	// Low priority means it will execute AFTER the other hooks, hence this will override other styles previously set.
	add_action( 'wp_head', 'ci_custom_background', 100 );
	if ( ! function_exists( 'ci_custom_background' ) ) :
		function ci_custom_background() {
			if ( ( ! current_theme_supports( 'custom-background' ) && ci_setting( 'bg_custom_disabled' ) !== 'enabled' ) ||
				( ci_setting( 'bg_h_custom_disabled' ) !== 'enabled' && get_truenorth_support( 'custom_header_background' ) ) ||
				( ci_setting( 'bg_f_custom_disabled' ) !== 'enabled' && get_truenorth_support( 'custom_footer_background' ) ) ) :
				?>
				<style type="text/css">
					<?php
						if ( ci_setting( 'bg_h_custom_disabled' ) !== 'enabled' && get_truenorth_support( 'custom_header_background' ) ) {
							do_action( 'ci_custom_header_background', apply_filters( 'ci_custom_header_background_options', ci_panel_get_custom_background_values( 'header' ) ) );
						}

						if ( ! current_theme_supports( 'custom-background' ) && ci_setting( 'bg_custom_disabled' ) !== 'enabled' ) {
							do_action( 'ci_custom_background', apply_filters( 'ci_custom_background_options', ci_panel_get_custom_background_values( 'body' ) ) );
						}

						if ( ci_setting( 'bg_f_custom_disabled' ) !== 'enabled' && get_truenorth_support( 'custom_footer_background' ) ) {
							do_action( 'ci_custom_footer_background', apply_filters( 'ci_custom_footer_background_options', ci_panel_get_custom_background_values( 'footer' ) ) );
						}
					?>
				</style>
			<?php endif;
		}
	endif;

	if ( ! function_exists( 'ci_panel_get_custom_background_values' ) ) :
		function ci_panel_get_custom_background_values( $position ) {

			$position = in_array( $position, array( 'header', 'footer', 'body' ), true ) ? $position : 'body';

			$infix = '';

			switch ( $position ) {
				case 'header':
					$infix = 'h_';
					break;
				case 'footer':
					$infix = 'f_';
					break;
				case 'body':
				default:
					$infix = '';
					break;
			}

			// Filter 'ci_background_color_value' kept for backward compatibility.
			$bg_color = apply_filters( 'ci_background_color_value', ci_setting( "bg_{$infix}color" ) );

			$bg_color = apply_filters( "ci_custom_{$position}_background_color_value", $bg_color );

			$values = array(
				"bg_{$infix}color"            => $bg_color,
				"bg_{$infix}image"            => ci_setting( "bg_{$infix}image" ),
				"bg_{$infix}image_horizontal" => ci_setting( "bg_{$infix}image_horizontal" ),
				"bg_{$infix}image_vertical"   => ci_setting( "bg_{$infix}image_vertical" ),
				"bg_{$infix}image_attachment" => ci_setting( "bg_{$infix}image_attachment" ),
				"bg_{$infix}image_repeat"     => ci_setting( "bg_{$infix}image_repeat" ),
				"bg_{$infix}image_disable"    => ci_setting( "bg_{$infix}image_disable" ),
				"bg_{$infix}image_size"       => ci_setting( "bg_{$infix}image_size" ) !== 'custom' ? ci_setting( "bg_{$infix}image_size" ) : ci_setting( "bg_{$infix}image_size_value" ),
			);

			return apply_filters( 'ci_panel_get_custom_background_values', $values, $position );

		}
	endif;

	add_action( 'ci_custom_header_background', 'ci_custom_header_background_handler' );
	// Default handler for custom header background.
	if ( ! function_exists( 'ci_custom_header_background_handler' ) ) :
	function ci_custom_header_background_handler( $options ) {
		echo apply_filters( 'ci_custom_header_background_applied_element', '#header' );
		echo '{';

		if ( $options['bg_h_color'] ) {
			echo 'background-color: ' . $options['bg_h_color'] . ';';
		}

		if ( $options['bg_h_image'] ) {
			echo 'background-image: url(' . $options['bg_h_image'] . ');';
			echo 'background-position: ' . $options['bg_h_image_horizontal'] . ' ' . $options['bg_h_image_vertical'] . ';';

			if ( 'fixed' === $options['bg_h_image_attachment'] ) {
				echo 'background-attachment: fixed;';
			}
			if ( ! empty( $options['bg_h_image_size'] ) ) {
				echo 'background-size: ' . $options['bg_h_image_size'] . ';';
			}
		}
		if ( $options['bg_h_image_repeat'] ) {
			echo 'background-repeat: ' . $options['bg_h_image_repeat'] . ';';
		}

		if ( 'enabled' === $options['bg_h_image_disable'] ) {
			echo 'background-image: none;';
		}

		echo '} ';
	}
	endif;

	add_action( 'ci_custom_background', 'ci_custom_background_handler' );
	// Default handler for custom background.
	if ( ! function_exists( 'ci_custom_background_handler' ) ) :
		function ci_custom_background_handler( $options ) {
			echo apply_filters( 'ci_custom_background_applied_element', 'body' );
			echo '{';

			if ( $options['bg_color'] ) {
				echo 'background-color: ' . $options['bg_color'] . ';';
			}

			if ( $options['bg_image'] ) {
				echo 'background-image: url(' . $options['bg_image'] . ');';
				echo 'background-position: ' . $options['bg_image_horizontal'] . ' ' . $options['bg_image_vertical'] . ';';

				if ( 'fixed' === $options['bg_image_attachment'] ) {
					echo 'background-attachment: fixed;';
				}

				if ( ! empty( $options['bg_image_size'] ) ) {
					echo 'background-size: ' . $options['bg_image_size'] . ';';
				}
			}

			if ( $options['bg_image_repeat'] ) {
				echo 'background-repeat: ' . $options['bg_image_repeat'] . ';';
			}

			if ( 'enabled' === $options['bg_image_disable'] ) {
				echo 'background-image: none;';
			}

			echo '} ';
		}
	endif;

	add_action( 'ci_custom_footer_background', 'ci_custom_footer_background_handler' );
	// Default handler for custom footer background.
	if ( ! function_exists( 'ci_custom_footer_background_handler' ) ) :
		function ci_custom_footer_background_handler( $options ) {
			echo apply_filters( 'ci_custom_footer_background_applied_element', '#footer' );
			echo '{';

			if ( $options['bg_f_color'] ) {
				echo 'background-color: ' . $options['bg_f_color'] . ';';
			}

			if ( $options['bg_f_image'] ) {
				echo 'background-image: url(' . $options['bg_f_image'] . ');';
				echo 'background-position: ' . $options['bg_f_image_horizontal'] . ' ' . $options['bg_f_image_vertical'] . ';';

				if ( 'fixed' === $options['bg_f_image_attachment'] ) {
					echo 'background-attachment: fixed;';
				}

				if ( ! empty( $options['bg_f_image_size'] ) ) {
					echo 'background-size: ' . $options['bg_f_image_size'] . ';';
				}
			}

			if ( $options['bg_f_image_repeat'] ) {
				echo 'background-repeat: ' . $options['bg_f_image_repeat'] . ';';
			}

			if ( 'enabled' === $options['bg_f_image_disable'] ) {
				echo 'background-image: none;';
			}

			echo '} ';
		}
	endif;

	add_filter( 'ci_background_color_value', 'ci_background_color_value_check_hash' );
	// Make sure 3 and 6 digit values start with a #
	if ( ! function_exists( 'ci_background_color_value_check_hash' ) ) :
		function ci_background_color_value_check_hash( $value ) {
			if ( ( strlen( $value ) === 3 || strlen( $value ) === 6 ) && ( substr_left( $value, 1 ) !== '#' ) ) {
				return '#' . $value;
			} else {
				return $value;
			}
		}
	endif;


	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_custom_background', 10, 2 );
	function truenorth_panel_sanitize_snippet_custom_background( $values, $defaults ) {
		$section_prefixes = array( 'bg', 'bg_h', 'bg_f' );

		$values['bg_custom_migrated'] = (bool) $values['bg_custom_migrated'];

		foreach ( $section_prefixes as $prefix ) {
			$values[ "{$prefix}_custom_disabled" ]  = 'enabled' === $values[ "{$prefix}_custom_disabled" ] ? 'enabled' : '';
			$values[ "{$prefix}_color" ]            = sanitize_hex_color( $values[ "{$prefix}_color" ] );
			$values[ "{$prefix}_image_disable" ]    = 'enabled' === $values[ "{$prefix}_image_disable" ] ? 'enabled' : '';
			$values[ "{$prefix}_image" ]            = esc_url_raw( $values[ "{$prefix}_image" ] );
			$values[ "{$prefix}_image_repeat" ]     = in_array( $values[ "{$prefix}_image_repeat" ], array( 'no-repeat', 'repeat', 'repeat-x', 'repeat-y' ), true ) ? $values[ "{$prefix}_image_repeat" ] : $defaults[ "{$prefix}_image_repeat" ];
			$values[ "{$prefix}_image_horizontal" ] = in_array( $values[ "{$prefix}_image_horizontal" ], array( 'left', 'center', 'right' ), true ) ? $values[ "{$prefix}_image_horizontal" ] : $defaults[ "{$prefix}_image_horizontal" ];
			$values[ "{$prefix}_image_vertical" ]   = in_array( $values[ "{$prefix}_image_vertical" ], array( 'top', 'center', 'bottom' ), true ) ? $values[ "{$prefix}_image_vertical" ] : $defaults[ "{$prefix}_image_vertical" ];
			$values[ "{$prefix}_image_size" ]       = in_array( $values[ "{$prefix}_image_size" ], array( '', 'cover', 'contain', 'custom' ), true ) ? $values[ "{$prefix}_image_size" ] : $defaults[ "{$prefix}_image_size" ];
			$values[ "{$prefix}_image_size_value" ] = sanitize_text_field( $values[ "{$prefix}_image_size_value" ] );
			$values[ "{$prefix}_image_attachment" ] = 'fixed' === $values[ "{$prefix}_image_attachment" ] ? 'fixed' : '';
		}

		return $values;
	}

?>
<?php else : ?>

	<?php if ( get_truenorth_support( 'custom_header_background' ) !== false ) : ?>
		<fieldset id="ci-panel-custom-header-background" class="set">
			<legend><?php esc_html_e( 'Custom Header Background', 'truenorth' ); ?></legend>
			<p class="guide"><?php esc_html_e( "Control whether you want to override the theme's header background, by enabling the custom header background option and tweaking the rest as you please.", 'truenorth' ); ?></p>

			<?php ci_panel_checkbox( 'bg_h_custom_disabled', 'enabled', __( 'Disable custom header background', 'truenorth' ), array( 'input_class' => 'check toggle-button' ) ); ?>

			<div class="toggle-pane">

				<fieldset class="set">
					<p class="guide"><?php esc_html_e( "You can set the header's background color of the page here. This option overrides the header's background color set by the Color Scheme Option (if any), so leave it empty if you want the default. You may select a color using the color picker (pops up when you click on the input box), or enter its hex number in the input box (including a leading #).", 'truenorth' ); ?></p>
					<fieldset>
						<?php ci_panel_input( 'bg_h_color', __( "Header's Background Color", 'truenorth' ), array( 'input_class' => 'colorpckr' ) ); ?>
					</fieldset>
				</fieldset>

				<fieldset class="set">
					<p class="guide"><?php esc_html_e( "When this option is checked, the header's background image is disabled, whether it's set by the default stylesheets or by you, from the option below.", 'truenorth' ); ?></p>
					<fieldset>
						<?php ci_panel_checkbox( 'bg_h_image_disable', 'enabled', __( "Disable header's background image", 'truenorth' ) ); ?>
					</fieldset>
				</fieldset>

				<fieldset class="set">
					<p class="guide"><?php esc_html_e( "You can upload/select an image to use as custom header's background for your site. Make sure to select the appropriate size, once you select your image. You can also choose whether you want the image to repeat.", 'truenorth' ); ?></p>
					<?php ci_panel_upload_image( 'bg_h_image', __( "Upload your header's background image", 'truenorth' ) ); ?>
					<fieldset>
						<?php
							$options = array(
								'no-repeat' => __( 'No Repeat', 'truenorth' ),
								'repeat'    => __( 'Repeat', 'truenorth' ),
								'repeat-x'  => __( 'Repeat X', 'truenorth' ),
								'repeat-y'  => __( 'Repeat Y', 'truenorth' ),
							);
							ci_panel_dropdown( 'bg_h_image_repeat', $options, __( "Repeat header's background image", 'truenorth' ) );
						?>
					</fieldset>
				</fieldset>

				<fieldset class="set">
					<p class="guide"><?php esc_html_e( "You can select the placement of your image in the header's background.", 'truenorth' ); ?></p>
					<fieldset>
						<?php
							$options = array(
								'left'   => __( 'Left', 'truenorth' ),
								'center' => __( 'Center', 'truenorth' ),
								'right'  => __( 'Right', 'truenorth' ),
							);
							ci_panel_dropdown( 'bg_h_image_horizontal', $options, __( "Header's Background Horizontal Placement", 'truenorth' ) );
						?>
					</fieldset>

					<fieldset>
						<?php
							$options = array(
								'top'    => __( 'Top', 'truenorth' ),
								'center' => __( 'Center', 'truenorth' ),
								'bottom' => __( 'Bottom', 'truenorth' ),
							);
							ci_panel_dropdown( 'bg_h_image_vertical', $options, __( "Header's Background Vertical Placement", 'truenorth' ) );
						?>
					</fieldset>
				</fieldset>

				<fieldset class="set">
					<p class="guide">
						<?php
							/* translators: %s is a url. */
							echo wp_kses( sprintf( __( 'You can select the size of your image in the background. For an explanation of the values, please read <a href="%s">this article</a>.', 'truenorth' ), 'http://www.css3.info/preview/background-size/' ), truenorth_get_allowed_tags( 'guide' ) );
						?>
					</p>
					<fieldset>
						<?php
							ci_panel_radio( 'bg_h_image_size', 'bg_h_image_size_none', '', __( 'Default', 'truenorth' ) );
							ci_panel_radio( 'bg_h_image_size', 'bg_h_image_size_cover', 'cover', __( 'Cover', 'truenorth' ) );
							ci_panel_radio( 'bg_h_image_size', 'bg_h_image_size_contain', 'contain', __( 'Contain', 'truenorth' ) );
							ci_panel_radio( 'bg_h_image_size', 'bg_h_image_size_custom', 'custom', __( 'Custom size (e.g. <em>200px 150px</em>)', 'truenorth' ) );

							$fieldname = 'bg_image_size_value';
							?><input type="text" id="<?php echo esc_attr( $fieldname ); ?>" name="<?php echo esc_attr( THEME_OPTIONS . '[' . $fieldname . ']' ); ?>" value="<?php echo esc_attr( $ci[ $fieldname ] ); ?>"><?php
							$js = "
								if( $('input[id^=\"bg_h_image_size\"]:radio:checked').val() == 'custom' )
									$('#" . $fieldname . "').show();
								else
									$('#" . $fieldname . "').hide();
								
								$('body').on('change', 'input[id^=\"bg_h_image_size\"]:radio', function(){
									if( $(this).val() == 'custom' )
										$('#" . $fieldname . "').slideDown();
									else
										$('#" . $fieldname . "').slideUp();
								}); ";
							ci_add_inline_js( $js, $fieldname );
						?>
					</fieldset>
				</fieldset>

				<fieldset class="set">
					<p class="guide"><?php esc_html_e( "When the fixed background option is checked, the header's background image will not scroll along with the rest of the page.", 'truenorth' ); ?></p>
					<fieldset>
						<?php ci_panel_checkbox( 'bg_h_image_attachment', 'fixed', __( "Fixed header's background", 'truenorth' ) ); ?>
					</fieldset>
				</fieldset>

			</div>
		</fieldset>
	<?php endif; ?>


	<fieldset id="ci-panel-custom-background" class="set">
		<legend><?php esc_html_e( 'Custom Background', 'truenorth' ); ?></legend>
		<?php if ( current_theme_supports( 'custom-background' ) ) : ?>
			<p class="guide">
				<?php
					/* translators: %s is a url. */
					echo wp_kses( sprintf( __( 'The Custom Background options were migrated to the Customizer. Please visit <a href="%s" target="_blank">Appearance → Customize</a> to modify your custom background.', 'truenorth' ),
						esc_url( admin_url( '/customize.php' ) )
					), truenorth_get_allowed_tags( 'guide' ) );
				?>
			</p>
			<?php
				// These are needed so that the respective $ci options won't reset. Do not remove.
				$hidden = array( 'input_type' => 'hidden' );
				ci_panel_input( 'bg_custom_migrated', '', $hidden );
				ci_panel_input( 'bg_custom_disabled', '', $hidden );
				ci_panel_input( 'bg_color', '', $hidden );
				ci_panel_input( 'bg_image_disable', '', $hidden );
				ci_panel_input( 'bg_image', '', $hidden );
				ci_panel_input( 'bg_image_repeat', '', $hidden );
				ci_panel_input( 'bg_image_horizontal', '', $hidden );
				ci_panel_input( 'bg_image_vertical', '', $hidden );
				ci_panel_input( 'bg_image_size', '', $hidden );
				ci_panel_input( 'bg_image_size_value', '', $hidden );
				ci_panel_input( 'bg_image_attachment', '', $hidden );
			?>
		<?php else : ?>
			<p class="guide"><?php esc_html_e( "Control whether you want to override the theme's background, by enabling the custom background option and tweaking the rest as you please.", 'truenorth' ); ?></p>

			<?php ci_panel_input( 'bg_custom_migrated', '', array( 'input_type' => 'hidden' ) ); ?>

			<?php ci_panel_checkbox( 'bg_custom_disabled', 'enabled', __( 'Disable custom background', 'truenorth' ), array( 'input_class' => 'check toggle-button' ) ); ?>

			<div class="toggle-pane">

				<fieldset class="set">
					<p class="guide"><?php esc_html_e( 'You can set the background color of the page here. This option overrides the background color set by the Color Scheme Option (if any), so leave it empty if you want the default. You may select a color using the color picker (pops up when you click on the input box), or enter its hex number in the input box (including a leading #).', 'truenorth' ); ?></p>
					<fieldset>
						<?php ci_panel_input( 'bg_color', __( 'Background Color', 'truenorth' ), array( 'input_class' => 'colorpckr' ) ); ?>
					</fieldset>
				</fieldset>

				<fieldset class="set">
					<p class="guide"><?php esc_html_e( "When this option is checked, the body background image is disabled, whether it's set by the default stylesheets or by you, from the option below.", 'truenorth' ); ?></p>
					<fieldset>
						<?php ci_panel_checkbox( 'bg_image_disable', 'enabled', __( 'Disable background image', 'truenorth' ) ); ?>
					</fieldset>
				</fieldset>

				<fieldset class="set">
					<p class="guide"><?php esc_html_e( 'You can upload/select an image to use as custom background for your site. Make sure to select the appropriate size, once you select your image. You can also choose whether you want the image to repeat.', 'truenorth' ); ?></p>
					<?php ci_panel_upload_image( 'bg_image', __( 'Upload your background image', 'truenorth' ) ); ?>
					<fieldset>
						<?php
							$options = array(
								'no-repeat' => __( 'No Repeat', 'truenorth' ),
								'repeat'    => __( 'Repeat', 'truenorth' ),
								'repeat-x'  => __( 'Repeat X', 'truenorth' ),
								'repeat-y'  => __( 'Repeat Y', 'truenorth' ),
							);
							ci_panel_dropdown( 'bg_image_repeat', $options, __( 'Repeat background image', 'truenorth' ) );
						?>
					</fieldset>
				</fieldset>

				<fieldset class="set">
					<p class="guide"><?php esc_html_e( 'You can select the placement of your image in the background.', 'truenorth' ); ?></p>
					<fieldset>
						<?php
							$options = array(
								'left'   => __( 'Left', 'truenorth' ),
								'center' => __( 'Center', 'truenorth' ),
								'right'  => __( 'Right', 'truenorth' ),
							);
							ci_panel_dropdown( 'bg_image_horizontal', $options, __( 'Background Horizontal Placement', 'truenorth' ) );
						?>
					</fieldset>

					<fieldset>
						<?php
							$options = array(
								'top'    => __( 'Top', 'truenorth' ),
								'center' => __( 'Center', 'truenorth' ),
								'bottom' => __( 'Bottom', 'truenorth' ),
							);
							ci_panel_dropdown( 'bg_image_vertical', $options, __( 'Background Vertical Placement', 'truenorth' ) );
						?>
					</fieldset>
				</fieldset>

				<fieldset class="set">
					<p class="guide">
						<?php
							/* translators: %s is a url. */
							echo wp_kses( sprintf( __( 'You can select the size of your image in the background. For an explanation of the values, please read <a href="%s">this article</a>.', 'truenorth' ), 'http://www.css3.info/preview/background-size/' ), truenorth_get_allowed_tags( 'guide' ) );
						?>
					</p>
					<fieldset>
						<?php
							ci_panel_radio( 'bg_image_size', 'bg_image_size_none', '', __( 'Default', 'truenorth' ) );
							ci_panel_radio( 'bg_image_size', 'bg_image_size_cover', 'cover', __( 'Cover', 'truenorth' ) );
							ci_panel_radio( 'bg_image_size', 'bg_image_size_contain', 'contain', __( 'Contain', 'truenorth' ) );
							ci_panel_radio( 'bg_image_size', 'bg_image_size_custom', 'custom', __( 'Custom size (e.g. <em>200px 150px</em>)', 'truenorth' ) );

							$fieldname = 'bg_image_size_value';
							?><input type="text" id="<?php echo esc_attr( $fieldname ); ?>" name="<?php echo esc_attr( THEME_OPTIONS . '[' . $fieldname . ']' ); ?>" value="<?php echo esc_attr( $ci[ $fieldname ] ); ?>"><?php
							$js = "
								if( $('input[id^=\"bg_image_size_\"]:radio:checked').val() == 'custom' )
									$('#" . $fieldname . "').show();
								else
									$('#" . $fieldname . "').hide();
								
								$('body').on('change', 'input[id^=\"bg_image_size_\"]:radio', function(){
									if( $(this).val() == 'custom' )
										$('#" . $fieldname . "').slideDown();
									else
										$('#" . $fieldname . "').slideUp();
								}); ";
							ci_add_inline_js( $js, $fieldname );
						?>
					</fieldset>
				</fieldset>

				<fieldset class="set">
					<p class="guide"><?php esc_html_e( 'When the fixed background option is checked, the background image will not scroll along with the rest of the page.', 'truenorth' ); ?></p>
					<fieldset>
						<?php ci_panel_checkbox( 'bg_image_attachment', 'fixed', __( 'Fixed background', 'truenorth' ) ); ?>
					</fieldset>
				</fieldset>

		</div>
		<?php endif; ?>
	</fieldset>

	<?php if ( get_truenorth_support( 'custom_footer_background' ) !== false ) : ?>
		<fieldset id="ci-panel-custom-footer-background" class="set">
			<legend><?php esc_html_e( 'Custom Footer Background', 'truenorth' ); ?></legend>
			<p class="guide"><?php esc_html_e( "Control whether you want to override the theme's footer background, by enabling the custom footer background option and tweaking the rest as you please.", 'truenorth' ); ?></p>

			<?php ci_panel_checkbox( 'bg_f_custom_disabled', 'enabled', __( 'Disable custom footer background', 'truenorth' ), array( 'input_class' => 'check toggle-button' ) ); ?>

			<div class="toggle-pane">

				<fieldset class="set">
					<p class="guide"><?php esc_html_e( "You can set the footer's background color of the page here. This option overrides the footer's background color set by the Color Scheme Option (if any), so leave it empty if you want the default. You may select a color using the color picker (pops up when you click on the input box), or enter its hex number in the input box (including a leading #).", 'truenorth' ); ?></p>
					<fieldset>
						<?php ci_panel_input( 'bg_f_color', __( "Footer's Background Color", 'truenorth' ), array( 'input_class' => 'colorpckr' ) ); ?>
					</fieldset>
				</fieldset>

				<fieldset class="set">
					<p class="guide"><?php esc_html_e( "When this option is checked, the footer's background image is disabled, whether it's set by the default stylesheets or by you, from the option below.", 'truenorth' ); ?></p>
					<fieldset>
						<?php ci_panel_checkbox( 'bg_f_image_disable', 'enabled', __( "Disable footer's background image", 'truenorth' ) ); ?>
					</fieldset>
				</fieldset>

				<fieldset class="set">
					<p class="guide"><?php esc_html_e( "You can upload/select an image to use as custom footer's background for your site. Make sure to select the appropriate size, once you select your image. You can also choose whether you want the image to repeat.", 'truenorth' ); ?></p>
					<?php ci_panel_upload_image( 'bg_f_image', __( "Upload your footer's background image", 'truenorth' ) ); ?>
					<fieldset>
						<?php
							$options = array(
								'no-repeat' => __( 'No Repeat', 'truenorth' ),
								'repeat'    => __( 'Repeat', 'truenorth' ),
								'repeat-x'  => __( 'Repeat X', 'truenorth' ),
								'repeat-y'  => __( 'Repeat Y', 'truenorth' ),
							);
							ci_panel_dropdown( 'bg_f_image_repeat', $options, __( "Repeat footer's background image", 'truenorth' ) );
						?>
					</fieldset>
				</fieldset>

				<fieldset class="set">
					<p class="guide"><?php esc_html_e( "You can select the placement of your image in the footer's background.", 'truenorth' ); ?></p>
					<fieldset>
						<?php
							$options = array(
								'left'   => __( 'Left', 'truenorth' ),
								'center' => __( 'Center', 'truenorth' ),
								'right'  => __( 'Right', 'truenorth' ),
							);
							ci_panel_dropdown( 'bg_f_image_horizontal', $options, __( "Footer's Background Horizontal Placement", 'truenorth' ) );
						?>
					</fieldset>

					<fieldset>
						<?php
							$options = array(
								'top'    => __( 'Top', 'truenorth' ),
								'center' => __( 'Center', 'truenorth' ),
								'bottom' => __( 'Bottom', 'truenorth' ),
							);
							ci_panel_dropdown( 'bg_f_image_vertical', $options, __( "Footer's Background Vertical Placement", 'truenorth' ) );
						?>
					</fieldset>
				</fieldset>

				<fieldset class="set">
					<p class="guide">
						<?php
							/* translators: %s is a url. */
							echo wp_kses( sprintf( __( 'You can select the size of your image in the footer\'s background. For an explanation of the values, please read <a href="%s">this article</a>.', 'truenorth' ), 'http://www.css3.info/preview/background-size/' ), truenorth_get_allowed_tags( 'guide' ) );
						?>
					</p>
					<fieldset>
						<?php
							ci_panel_radio( 'bg_f_image_size', 'bg_f_image_size_none', '', __( 'Default', 'truenorth' ) );
							ci_panel_radio( 'bg_f_image_size', 'bg_f_image_size_cover', 'cover', __( 'Cover', 'truenorth' ) );
							ci_panel_radio( 'bg_f_image_size', 'bg_f_image_size_contain', 'contain', __( 'Contain', 'truenorth' ) );
							ci_panel_radio( 'bg_f_image_size', 'bg_f_image_size_custom', 'custom', __( 'Custom size (e.g. <em>200px 150px</em>)', 'truenorth' ) );

							$fieldname = 'bg_f_image_size_value';
							?><input type="text" id="<?php echo esc_attr( $fieldname ); ?>" name="<?php echo esc_attr( THEME_OPTIONS . '[' . $fieldname . ']' ); ?>" value="<?php echo esc_attr( $ci[ $fieldname ] ); ?>"><?php
							$js = "
								if( $('input[id^=\"bg_f_image_size_\"]:radio:checked').val() == 'custom' )
									$('#" . $fieldname . "').show();
								else
									$('#" . $fieldname . "').hide();
								
								$('body').on('change', 'input[id^=\"bg_f_image_size_\"]:radio', function(){
									if( $(this).val() == 'custom' )
										$('#" . $fieldname . "').slideDown();
									else
										$('#" . $fieldname . "').slideUp();
								}); ";
							ci_add_inline_js( $js, $fieldname );
						?>
					</fieldset>
				</fieldset>

				<fieldset class="set">
					<p class="guide"><?php esc_html_e( "When the fixed background option is checked, the footer's background image will not scroll along with the rest of the page.", 'truenorth' ); ?></p>
					<fieldset>
						<?php ci_panel_checkbox( 'bg_f_image_attachment', 'fixed', __( "Fixed footer's background", 'truenorth' ) ); ?>
					</fieldset>
				</fieldset>

			</div>
		</fieldset>
	<?php endif; ?>


<?php endif;
