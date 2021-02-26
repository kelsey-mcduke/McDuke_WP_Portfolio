<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	$ci_defaults['google_maps_api_enable'] = '';
	$ci_defaults['google_maps_api_key']    = '';

	add_action( 'init', 'ci_register_google_maps_api' );
	function ci_register_google_maps_api() {
		$args = array(
			'v' => '3',
		);

		$key = trim( ci_setting( 'google_maps_api_key' ) );

		if ( $key ) {
			$args['key'] = $key;
		}

		$google_url = add_query_arg( $args, '//maps.googleapis.com/maps/api/js' );

		wp_register_script( 'google-maps', esc_url_raw( $google_url ), array(), null, false );
	}


	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_google_maps_api', 10, 2 );
	function truenorth_panel_sanitize_snippet_google_maps_api( $values, $defaults ) {
		$values['google_maps_api_key'] = sanitize_text_field( $values['google_maps_api_key'] );

		return $values;
	}

?>
<?php else : ?>

	<fieldset id="ci-panel-google-maps-api" class="set">
		<p class="guide"><?php esc_html_e( 'The Google Maps API must be loaded only once in each page. Since many plugins may try to load it as well, you might want to disable it from the theme to avoid potential errors.', 'truenorth' ); ?></p>
		<?php ci_panel_checkbox( 'google_maps_api_enable', 'on', __( 'Load Google Maps API.', 'truenorth' ) ); ?>

		<p class="guide">
			<?php
				/* translators: Both %1$s and %2$s are urls. */
				echo wp_kses( sprintf( __( 'Paste here your Google Maps API Key. Maps will <strong>not</strong> be displayed without an API key. You need to issue a key from <a href="%1$s" target="_blank">Google Accounts</a>, and make sure the <strong>Google Maps JavaScript API</strong> is enabled. For instructions on issuing an API key, <a href="%2$s" target="_blank">read this article</a>.', 'truenorth' ),
					'https://code.google.com/apis/console/',
					'http://www.cssigniter.com/docs/article/generate-a-google-maps-api-key/'
				), truenorth_get_allowed_tags( 'guide' ) );
			?>
		</p>
		<?php ci_panel_input( 'google_maps_api_key', __( 'Google Maps API Key', 'truenorth' ) ); ?>
	</fieldset>

<?php endif;
