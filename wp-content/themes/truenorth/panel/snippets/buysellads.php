<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	$ci_defaults['buysellads_code'] = '';

	add_action( 'wp_body_open', 'ci_register_bsa_script' );
	if ( ! function_exists( 'ci_register_bsa_script' ) ) :
		function ci_register_bsa_script() {
			// Load Buy Sell Ads code, if available.
			if ( ci_setting( 'buysellads_code' ) ) {
				echo html_entity_decode( ci_setting( 'buysellads_code' ) );
			}

		}
	endif;

	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_buysellads', 10, 2 );
	function truenorth_panel_sanitize_snippet_buysellads( $values, $defaults ) {
		$values['buysellads_code'] = strip_tags( $values['buysellads_code'], '<script>' );

		return $values;
	}
?>
<?php else : ?>

	<fieldset id="ci-panel-buysellads" class="set">
		<legend><?php esc_html_e( 'BuySellAds', 'truenorth' ); ?></legend>
		<p class="guide">
			<?php
				/* translators: %s is a url. */
				echo wp_kses( sprintf( __( 'Paste here your BuySellAds.com <strong>Main Code</strong>, as given by the <a href="%s">BSA website</a>, and it will be automatically included on every page. Then use our BSA Widget for your sidebar code.', 'truenorth' ), 'https://support.buysellads.com/support/publishers/ad-management-placement/installing-your-ad-code/#how-to-install-your-ad-code' ), truenorth_get_allowed_tags( 'guide' ) );
			?>
		</p>
		<?php ci_panel_textarea( 'buysellads_code', __( 'BuySellAds.com Main Code', 'truenorth' ) ); ?>
	</fieldset>

<?php endif;
