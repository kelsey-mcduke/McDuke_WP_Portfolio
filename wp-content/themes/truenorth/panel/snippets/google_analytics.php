<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	$ci_defaults['google_analytics_code'] = '';

	add_action( 'wp_head', 'ci_output_google_analytics_code' );
	if ( ! function_exists( 'ci_output_google_analytics_code' ) ) :
		function ci_output_google_analytics_code() {
			// Load Google Analytics code, if available.
			if ( ci_setting( 'google_analytics_code' ) ) {
				echo html_entity_decode( ci_setting( 'google_analytics_code' ) );
			}
		}
	endif;

	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_google_analytics', 10, 2 );
	function truenorth_panel_sanitize_snippet_google_analytics( $values, $defaults ) {
		$values['google_analytics_code'] = strip_tags( $values['google_analytics_code'], '<script>' );

		return $values;
	}
?>
<?php else : ?>

	<fieldset id="ci-panel-google-analytics" class="set">
		<legend><?php esc_html_e( 'Google Analytics', 'truenorth' ); ?></legend>
		<p class="guide"><?php echo wp_kses( __( 'Paste here your Google Analytics Code, as given by the Analytics website (including the <strong>&lt;script&gt;</strong> and <strong>&lt;/script&gt;</strong> tags), and it will be automatically included on every page.', 'truenorth' ), truenorth_get_allowed_tags( 'guide' ) ); ?></p>
		<?php ci_panel_textarea( 'google_analytics_code', __( 'Google Analytics Code', 'truenorth' ) ); ?>
	</fieldset>

<?php endif;
