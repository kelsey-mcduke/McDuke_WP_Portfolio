<?php global $ci, $ci_defaults, $load_defaults, $content_width; ?>
<?php if ( true === $load_defaults ) : ?>
<?php
add_filter( 'ci_show_generator_tag', '__return_false' );
	$ci_defaults['ci_show_generator_tag'] = 'on';

	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_site_other', 10, 2 );
	function truenorth_panel_sanitize_snippet_site_other( $values, $defaults ) {
		$values['ci_show_generator_tag'] = 'on' === $values['ci_show_generator_tag'] ? 'on' : '';

		return $values;
	}
?>
<?php else : ?>

	<?php if ( ! CI_WHITELABEL && apply_filters( 'ci_show_generator_tag', true ) ) : ?>
		<fieldset id="ci-panel-site-other" class="set">
			<legend><?php esc_html_e( 'Other options', 'truenorth' ); ?></legend>
			<p class="guide"><?php esc_html_e( "The Meta Generator tag is a piece of information added in the head of the generated HTML code that states the theme name and the developer of the theme. While it is not visible to your site's visitors, it does help us gather usage statistics.", 'truenorth' ); ?></p>
			<?php ci_panel_checkbox( 'ci_show_generator_tag', 'on', __( 'Echo a Meta Generator tag (invisible in the website).', 'truenorth' ) ); ?>
		</fieldset>
	<?php endif; ?>

<?php endif;
