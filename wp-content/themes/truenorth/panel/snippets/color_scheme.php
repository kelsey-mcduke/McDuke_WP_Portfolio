<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	$ci_defaults['stylesheet'] = apply_filters( 'truenorth_panel_default_stylesheet', 'default.css' );

	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_color_scheme', 10, 2 );
	function truenorth_panel_sanitize_snippet_color_scheme( $values, $defaults ) {
		$values['stylesheet'] = sanitize_text_field( $values['stylesheet'] );

		return $values;
	}
?>
<?php else : ?>

	<?php
		$schemes = array();

		$schemes_path = '';
		if ( is_child_theme() && file_exists( get_stylesheet_directory() . '/colors' ) ) {
			$schemes_path = get_stylesheet_directory() . '/colors';
		} elseif ( file_exists( get_template_directory() . '/colors' ) ) {
			$schemes_path = get_template_directory() . '/colors';
		}

		$schemes_path = apply_filters( 'ci_color_schemes_directory', $schemes_path );

		if ( ! empty( $schemes_path ) && is_readable( $schemes_path ) ) {
			$handle = opendir( $schemes_path );
			if ( $handle ) {
				while ( false !== ( $file = readdir( $handle ) ) ) {
					if ( '.' !== $file && '..' !== $file ) {
						$file_info = pathinfo( $schemes_path . '/' . $file );
						if ( ! empty( $file_info['extension'] ) && 'css' === $file_info['extension'] ) {
							$ignore_suffix = '.min';
							$suffix_length = strlen( $ignore_suffix );
							if ( substr( $file_info['filename'], - $suffix_length, $suffix_length ) === $ignore_suffix ) {
								continue;
							}

							$schemes[ $file ] = $file;
						}
					}
				}
				closedir( $handle );
			}
		}
	?>

	<fieldset id="ci-panel-color-scheme" class="set">
		<legend><?php esc_html_e( 'Color Scheme', 'truenorth' ); ?></legend>
		<p class="guide"><?php esc_html_e( 'Select your color scheme. This affects the overall look and feel of your website.', 'truenorth' ); ?></p>
		<?php
			// Try to retain old settings where the stylesheet didn't include the extension .css
			if ( ! empty( $ci['stylesheet'] ) ) {
				$color = $ci['stylesheet'];
				if ( substr_right( $ci['stylesheet'], 4 ) !== '.css' ) {
					$ci['stylesheet'] = $ci['stylesheet'] . '.css';
				}
			}

			ci_panel_dropdown( 'stylesheet', $schemes, __( 'Color scheme', 'truenorth' ) );
		?>
	</fieldset>

<?php endif;
