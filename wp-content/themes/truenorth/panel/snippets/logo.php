<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	$ci_defaults['logo']   = '';
	$ci_defaults['logox2'] = '';

	if ( apply_filters( 'limit_logo_size_support', false ) ) {
		$ci_defaults['logo_id']         = 0;
		$ci_defaults['limit_logo_size'] = 0;
		$ci_defaults['logo_width']      = 0; // Needed for compatibility with migrated logos.
		$ci_defaults['logox2_migrated'] = false;
	}

	if ( apply_filters( 'ci_panel_option_show_site_slogan', true ) ) {
		$ci_defaults['show_site_slogan'] = '';
	}

	add_action( 'init', 'truenorth_migrate_retina_logo_to_limit_logo_size' );
	function truenorth_migrate_retina_logo_to_limit_logo_size() {
		if ( ! is_admin() || wp_doing_ajax() || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
			return;
		}

		global $ci;

		if ( ! apply_filters( 'limit_logo_size_support', false ) || ! apply_filters( 'ci_retina_logo', true ) || $ci['logox2_migrated'] ) {
			return;
		}

		$logo  = ci_setting( 'logo' );
		$logo2 = ci_setting( 'logox2' );

		if ( $logo2 ) {
			$ci['logo']            = $logo2;
			$ci['logox2']          = '';
			$ci['limit_logo_size'] = 1;
		}

		if ( $ci['logo'] ) {
			$post_id = attachment_url_to_postid( $ci['logo'] );
			if ( $post_id ) {
				$ci['logo_id'] = $post_id;
			}

			// Try to get the image's width, in case we don't have a post id.
			$response = wp_remote_head( $ci['logo'] );
			if ( 200 === wp_remote_retrieve_response_code( $response ) ) {
				$image_info = getimagesize( $ci['logo'] );
				if ( ! empty( $image_info ) && ! empty( $image_info[0] ) ) {
					$ci['logo_width'] = $image_info[0];
				}
			}
		}

		$ci['logox2_migrated'] = true;
		update_option( THEME_OPTIONS, $ci );
	}

	add_action( 'init', 'truenorth_limit_logo_styles' );
	function truenorth_limit_logo_styles() {
		if ( ! apply_filters( 'limit_logo_size_support', false ) || ! ci_setting( 'limit_logo_size' ) ) {
			return;
		}

		$logo_id    = ci_setting( 'logo_id' );
		$logo_width = ci_setting( 'logo_width' );

		$max_width = false;

		if ( ! empty( $logo_id ) ) {
			$image_metadata = wp_get_attachment_metadata( $logo_id );
			$max_width      = floor( $image_metadata['width'] / 2 );
		} elseif ( ! empty( $logo_width ) && $logo_width > 0 ) {
			$max_width = floor( intval( $logo_width ) / 2 );
		}

		if ( $max_width ) {
			$selector = apply_filters( 'truenorth_limit_logo_styles_selector', '.imglogo img' );
			$rules    = apply_filters( 'truenorth_limit_logo_styles_rules', 'width: %spx; max-width: 100%;' );

			$css = sprintf( '%1$s { %2$s }', $selector, $rules );
			$css = str_replace( '%s', $max_width, $css );

			wp_add_inline_style( 'ci-style', $css );
		}
	}

	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_logo', 10, 2 );
	function truenorth_panel_sanitize_snippet_logo( $values, $defaults ) {
		$values['logo']            = esc_url_raw( $values['logo'] );
		$values['logo_id']         = absint( $values['logo_id'] );
		$values['logo_width']      = absint( $values['logo_width'] );
		$values['limit_logo_size'] = absint( $values['limit_logo_size'] );
		$values['logox2']          = esc_url_raw( $values['logox2'] );

		if ( isset( $values['show_site_slogan'] ) ) {
			$values['show_site_slogan'] = 'off' === $values['show_site_slogan'] ? 'off' : '';
		}

		return $values;
	}
?>
<?php else : ?>

	<fieldset id="ci-panel-logo" class="set">
		<legend><?php esc_html_e( 'Logo', 'truenorth' ); ?></legend>

		<div>
			<p class="guide"><?php esc_html_e( 'Upload your logo here. It will replace the textual logo (site name) on the header.', 'truenorth' ); ?></p>
			<?php
				$args = array(
					'input_type'  => 'text',
					'select_size' => true,
				);

				if ( apply_filters( 'limit_logo_size_support', false ) ) {
					$args = array(
						'input_type'  => 'hidden',
						'select_size' => false,
					);
				}
			?>
			<?php ci_panel_upload_image( 'logo', __( 'Upload your logo', 'truenorth' ), $args ); ?>

			<?php if ( apply_filters( 'limit_logo_size_support', false ) ) : ?>
				<input type="hidden" name="<?php echo esc_attr( THEME_OPTIONS . '[logo_id]' ); ?>" class="uploaded-id" value="<?php echo esc_attr( $ci['logo_id'] ); ?>">

				<?php // Needed for compatibility with migrated logos that don't have a respective post id. ?>
				<input type="hidden" name="<?php echo esc_attr( THEME_OPTIONS . '[logo_width]' ); ?>" value="<?php echo esc_attr( $ci['logo_width'] ); ?>">
			<?php endif; ?>
		</div>

		<?php if ( apply_filters( 'limit_logo_size_support', false ) ) : ?>
			<p class="guide"><?php esc_html_e( 'This option will limit the image size to half its width. You will need to upload your image in 2x the dimension you want to display it in.', 'truenorth' ); ?></p>
			<?php ci_panel_checkbox( 'limit_logo_size', 1, __( 'Limit logo size (for Retina display).', 'truenorth' ) ); ?>
		<?php endif; ?>


		<?php if ( apply_filters( 'ci_panel_option_show_site_slogan', true ) ) : ?>
			<p class="guide"><?php esc_html_e( "By default, the site tagline appears near the logo (either image or textual). You can choose to show or hide it. This doesn't affect any other usages of the tagline.", 'truenorth' ); ?></p>
			<?php
				$options = array(
					''    => __( 'Show tagline', 'truenorth' ),
					'off' => __( 'Hide tagline', 'truenorth' ),
				);
				ci_panel_dropdown( 'show_site_slogan', $options, __( 'Tagline near the logo:', 'truenorth' ) );
			?>
		<?php endif; ?>
	</fieldset>

	<?php if ( apply_filters( 'ci_retina_logo', true ) && ! apply_filters( 'limit_logo_size_support', false ) ) : ?>
		<fieldset id="ci-panel-logo-hires" class="set">
			<legend><?php esc_html_e( 'Hi-Res Logo', 'truenorth' ); ?></legend>
			<p class="guide"><?php echo wp_kses( __( 'You can upload a higher resolution logo image, that will automatically be served to devices with retina (high resolution) displays. The image needs to be exactly twice the width and height of the image above, and have the same filename with a <strong>@2x</strong> appended at the end. For example, if the image above is named <strong>logo.png</strong> then you need to upload a file named <strong>logo@2x.png</strong><br />Please note that the two images need to be in the same folder. Because of that you should upload both images at the same time in order for the retina version to automatically be recognized.', 'truenorth' ), truenorth_get_allowed_tags( 'guide' ) ); ?></p>
			<?php ci_panel_upload_image( 'logox2', __( 'Upload your hi-res logo', 'truenorth' ) ); ?>
		</fieldset>
	<?php endif; ?>

<?php endif;
