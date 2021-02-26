<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ( true === $load_defaults ) : ?>
<?php
	add_filter( 'ci_panel_tabs', 'ci_add_tab_color_options', 20 );
	if ( ! function_exists( 'ci_add_tab_color_options' ) ) :
		function ci_add_tab_color_options( $tabs ) {
			$tabs[ sanitize_key( basename( __FILE__, '.php' ) ) ] = __( 'Appearance Options', 'truenorth' );

			return $tabs;
		}
	endif;

	// Default values for options go here.
	// $ci_defaults['option_name'] = 'default_value';
	// or
	// load_panel_snippet( 'snippet_name' );

	load_panel_snippet( 'custom_background' );

	$ci_defaults['blog_layout'] = 'sidebar';

	$ci_defaults['default_header_bg']    = ''; // Holds the URL of the image file to use as header background
	$ci_defaults['default_header_color'] = '#CCCCCC'; // Holds the color to use as header background

	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_tab_color_options', 10, 2 );
	function truenorth_panel_sanitize_tab_color_options( $values, $defaults ) {
		$values['blog_layout']          = in_array( $values['blog_layout'], array( 'sidebar', 'fullwidth' ), true ) ? $values['blog_layout'] : $defaults['blog_layout'];
		$values['default_header_bg']    = esc_url_raw( $values['default_header_bg'] );
		$values['default_header_color'] = sanitize_hex_color( $values['default_header_color'] );

		return $values;
	}
?>
<?php else : ?>

	<fieldset class="set">
		<legend><?php esc_html_e( 'Blog Layout', 'truenorth' ); ?></legend>

		<p class="guide"><?php esc_html_e( 'Select the default layout of your blog and blog-related pages (e.g. single posts).', 'truenorth' ); ?></p>
		<?php
			$options = array(
				'sidebar'   => __( 'With Sidebar', 'truenorth' ),
				'fullwidth' => __( 'Full width - No Sidebar', 'truenorth' ),
			);
			ci_panel_dropdown( 'blog_layout', $options, __( 'Blog Layout:', 'truenorth' ) );
		?>
	</fieldset>

	<fieldset class="set">
		<legend><?php esc_html_e( 'Header Display', 'truenorth' ); ?></legend>

		<p class="guide">
			<?php
				$image_sizes = ci_get_image_sizes();
				$size        = $image_sizes['ci_header']['width'] . 'x' . $image_sizes['ci_header']['height'];
				esc_html_e( 'Upload or select an image to be used as the default header background on your header. This will be displayed across your website.', 'truenorth' );
				/* translators: %s is image dimensions in pixels, e.g. 800x600 */
				echo esc_html( sprintf( __( 'For best results, use a high resolution image, at least %s pixels in size.', 'truenorth' ), $size ) );
				esc_html_e( 'You may additionally set a background color (useful for having solid backgrounds or transparent images).', 'truenorth' );
			?>
		</p>
		<?php
			ci_panel_upload_image( 'default_header_bg', __( 'Upload an image:', 'truenorth' ) );
			ci_panel_input( 'default_header_color', __( 'Color:', 'truenorth' ), array( 'input_class' => 'colorpckr' ) );
		?>
	</fieldset>

	<?php load_panel_snippet( 'custom_background' ); ?>

<?php endif;
