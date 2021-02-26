<?php global $ci, $ci_defaults, $load_defaults, $content_width; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	$ci_defaults['pagination_method'] = 'paginate_links';


	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_pagination', 10, 2 );
	function truenorth_panel_sanitize_snippet_pagination( $values, $defaults ) {
		$values['pagination_method'] = in_array( $values['pagination_method'], array( 'paginate_links', 'prevnext', 'wp_pagenavi' ), true ) ? $values['pagination_method'] : $defaults['pagination_method'];

		return $values;
	}
?>
<?php else : ?>

	<fieldset id="ci-panel-excerpt" class="set">
		<legend><?php esc_html_e( 'Pagination', 'truenorth' ); ?></legend>
		<p class="guide"><?php esc_html_e( 'Select how you want pagination links to be displayed. You can display the traditional "Previous" and "Next" links, or the recommended, numbered links.', 'truenorth' ); ?></p>
		<label><?php esc_html_e( 'Select the pagination method to use:', 'truenorth' ); ?></label>
		<?php ci_panel_radio( 'pagination_method', 'paginate_links', 'paginate_links', __( 'Numbered pagination.', 'truenorth' ) ); ?>
		<?php ci_panel_radio( 'pagination_method', 'prevnext', 'prevnext', __( '"Previous - Next" links.', 'truenorth' ) ); ?>

		<?php if ( function_exists( 'wp_pagenavi' ) ) : ?>

			<?php if ( get_truenorth_support( 'wp_pagenavi' ) === false ) : ?>
				<p class="guide mt10"><?php echo wp_kses( __( "The theme has detected that you have installed the <strong>WP-PageNavi</strong> plugin. Although the theme doesn't provide appropriate styles for it, you can still use it without editing any files, by selecting the option below. However, you might need to configure and/or style it on your own.", 'truenorth' ), truenorth_get_allowed_tags( 'guide' ) ); ?></p>
			<?php endif; ?>

			<?php ci_panel_radio( 'pagination_method', 'wp_pagenavi', 'wp_pagenavi', __( 'WP-PageNavi plugin.', 'truenorth' ) ); ?>
		<?php endif; ?>
	</fieldset>

<?php endif;
