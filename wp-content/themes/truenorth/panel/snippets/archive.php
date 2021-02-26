<?php global $ci, $ci_defaults, $load_defaults, $content_width; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	$ci_defaults['archive_no']    = 5;
	$ci_defaults['archive_week']  = 'enabled';
	$ci_defaults['archive_month'] = 'enabled';
	$ci_defaults['archive_year']  = 'enabled';

	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_archive', 10, 2 );
	function truenorth_panel_sanitize_snippet_archive( $values, $defaults ) {
		$values['archive_no']    = absint( $values['archive_no'] );
		$values['archive_week']  = 'enabled' === $values['archive_week'] ? 'enabled' : '';
		$values['archive_month'] = 'enabled' === $values['archive_month'] ? 'enabled' : '';
		$values['archive_year']  = 'enabled' === $values['archive_year'] ? 'enabled' : '';

		return $values;
	}
?>
<?php else : ?>

	<fieldset id="ci-panel-archive">
		<legend><?php esc_html_e( 'Archive', 'truenorth' ); ?></legend>
		<fieldset class="set">
			<p class="guide"><?php esc_html_e( 'The number of the latest posts displayed in the archive page.', 'truenorth' ); ?></p>
			<?php ci_panel_input( 'archive_no', __( 'Number of latest posts', 'truenorth' ) ); ?>
		</fieldset>
		<fieldset>
			<p class="guide"><?php esc_html_e( 'Use the following options to display various types of archives.', 'truenorth' ); ?></p>
			<?php ci_panel_checkbox( 'archive_week', 'enabled', __( 'Display weekly archive', 'truenorth' ) ); ?>
			<?php ci_panel_checkbox( 'archive_month', 'enabled', __( 'Display monthly archive', 'truenorth' ) ); ?>
			<?php ci_panel_checkbox( 'archive_year', 'enabled', __( 'Display yearly archive', 'truenorth' ) ); ?>
		</fieldset>
	</fieldset>

<?php endif;
