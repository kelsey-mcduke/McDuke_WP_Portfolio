<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	$ci_defaults['ci_footer_credits']           = apply_filters( 'ci_footer_credits', '' );
	$ci_defaults['ci_footer_credits_secondary'] = apply_filters( 'ci_footer_credits_secondary', '' );


	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_footer_text', 10, 2 );
	function truenorth_panel_sanitize_snippet_footer_text( $values, $defaults ) {
		$values['ci_footer_credits']           = wp_kses_post( $values['ci_footer_credits'] );
		$values['ci_footer_credits_secondary'] = wp_kses_post( $values['ci_footer_credits_secondary'] );

		return $values;
	}
?>
<?php else : ?>

	<?php if ( has_filter( 'ci_footer_credits' ) ) : ?>

		<fieldset id="ci-panel-footer-text" class="set">
			<legend><?php esc_html_e( 'Footer Text', 'truenorth' ); ?></legend>
			<?php
				$allowed_tags = apply_filters( 'ci_footer_allowed_tags', array(
					'<a>',
					'<b>',
					'<strong>',
					'<i>',
					'<em>',
					'<span>',
				) );
			?>
			<p class="guide">
				<?php
					/* translators: %s is space-separated list of HTML tags, e.g. <a> <b> <strong> */
					echo wp_kses( apply_filters( 'ci_panel_footer_credits_description', sprintf( __( 'You can change the footer text by entering your custom text here. You may use <strong>:year:</strong> to display the current year. The following HTML tags are allowed: %s', 'truenorth' ), htmlspecialchars( implode( ' ', $allowed_tags ) ) ) ), truenorth_get_allowed_tags( 'guide' ) );
				?>
			</p>

			<?php if ( has_filter( 'ci_footer_credits' ) ) : ?>
				<?php ci_panel_textarea( 'ci_footer_credits', __( 'Footer text', 'truenorth' ) ); ?>
			<?php endif; ?>

			<?php if ( has_filter( 'ci_footer_credits_secondary' ) ) : ?>
				<?php ci_panel_textarea( 'ci_footer_credits_secondary', __( 'Secondary footer text', 'truenorth' ) ); ?>
			<?php endif; ?>
		</fieldset>

	<?php endif; ?>

<?php endif;
