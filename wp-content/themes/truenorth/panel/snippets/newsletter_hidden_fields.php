<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	if ( ! function_exists( 'ci_newsletter_hidden_fields' ) ) :
		function ci_newsletter_hidden_fields() {
			$fields = ci_setting( 'newsletter_hidden_fields' );
			$count  = count( $fields );
			$out    = '';

			if ( is_array( $fields ) && $count > 0 ) {
				for ( $i = 0; $i < $count; $i += 2 ) {
					if ( empty( $fields[ $i ] ) ) {
						continue;
					}

					$out .= '<input type="hidden" name="' . esc_attr( $fields[ $i ] ) . '" value="' . esc_attr( $fields[ $i + 1 ] ) . '" />';
				}
			}

			return $out;
		}
	endif;


	$ci_defaults['newsletter_hidden_fields'] = apply_filters( 'ci_newsletter_hidden_fields_defaults', array(
		'hidden1',
		'value1',
		'hidden2',
		'value2',
	) );


	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_newsletter_hidden_fields', 10, 2 );
	function truenorth_panel_sanitize_snippet_newsletter_hidden_fields( $values, $defaults ) {
		if ( ! isset( $values['newsletter_hidden_fields'] ) || ! is_array( $values['newsletter_hidden_fields'] ) ) {
			$values['newsletter_hidden_fields'] = array();
		} else {
			$fields = $values['newsletter_hidden_fields'];
			$count  = count( $fields );

			if ( ! empty( $fields ) ) {
				for ( $i = 0; $i < $count; $i += 2 ) {
					$values['newsletter_hidden_fields'][ $i ]     = sanitize_key( $fields[ $i ] );
					$values['newsletter_hidden_fields'][ $i + 1 ] = sanitize_text_field( $fields[ $i + 1 ] );
				}
			}
		}

		return $values;
	}
?>
<?php else : ?>

	<fieldset class="set">
		<legend><?php esc_html_e( 'Hidden Fields', 'truenorth' ); ?></legend>
		<p class="guide"><?php esc_html_e( 'You can pass additional data to your newsletter system, by means of hidden fields (e.g. Mailchimp requires them).', 'truenorth' ); ?></p>
		<fieldset id="newsletter_hidden_fields">
			<a href="#" id="newsletter-add-field"><?php esc_html_e( 'Add hidden field', 'truenorth' ); ?></a>
			<div class="inside">
				<?php
					$fields = $ci['newsletter_hidden_fields'];
					$count  = count( $fields );
					if ( ! empty( $fields ) ) {
						for ( $i = 0; $i < $count; $i += 2 ) {
							echo '<p class="newsletter-field"><label>' . esc_html__( 'Hidden field name', 'truenorth' ) . '<input type="text" name="' . esc_attr( THEME_OPTIONS ) . '[newsletter_hidden_fields][]" value="' . esc_attr( $fields[ $i ] ) . '" /></label><label>' . esc_html__( 'Hidden field value', 'truenorth' ) . '<input type="text" name="' . esc_attr( THEME_OPTIONS ) . '[newsletter_hidden_fields][]" value="' . esc_attr( $fields[ $i + 1 ] ) . '" /></label> <a href="#" class="newsletter-remove">' . esc_html__( 'Remove me', 'truenorth' ) . '</a></p>';
						}
					}
				?>
			</div>
		</fieldset>
		<?php
			$name_field  = '<label>' . esc_html__( 'Hidden field name', 'truenorth' ) . '<input type="text" name="' . esc_attr( THEME_OPTIONS ) . '[newsletter_hidden_fields][]" /></label>';
			$value_field = '<label>' . esc_html__( 'Hidden field value', 'truenorth' ) . '<input type="text" name="' . esc_attr( THEME_OPTIONS ) . '[newsletter_hidden_fields][]" /></label>';
			$append      = '<p class="newsletter-field">' . $name_field . $value_field . ' <a href="#" class="newsletter-remove">' . esc_html__( 'Remove me', 'truenorth' ) . '</a></p>';
			$script      = "
				$('#newsletter-add-field').click( function() {
					$('#newsletter_hidden_fields .inside').append('" . $append . "');
					return false;
				});

				$('#newsletter_hidden_fields').on('click', '.newsletter-remove', function() {
					$(this).parent('p').remove();
					return false;
				});
			";

			ci_add_inline_js( $script, 'newsletter_hidden_fields_script' );
		?>
	</fieldset>

<?php endif;
