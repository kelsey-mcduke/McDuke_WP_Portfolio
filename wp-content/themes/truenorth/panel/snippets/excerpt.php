<?php global $ci, $ci_defaults, $load_defaults, $content_width; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	$ci_defaults['preview_content']     = 'disabled'; //enabled means content, disabled means excerpt
	$ci_defaults['excerpt_length']      = 50;
	$ci_defaults['excerpt_text']        = '[...]';
	$ci_defaults['read_more_text']      = __( 'Read More &raquo;', 'truenorth' );
	$ci_defaults['excerpt_link_cutoff'] = '';

	if ( ! function_exists( 'ci_read_more' ) ) :
	function ci_read_more( $post_id = false, $return = false ) {
		global $post;

		if ( false === $post_id ) {
			$post_id = $post->ID;
		}

		$link = sprintf( '<a class="ci-more-link" href="%s"><span>%s</span></a>',
			esc_url( get_permalink( $post_id ) ),
			ci_setting( 'read_more_text' )
		);

		$link = apply_filters( 'ci-read-more-link', $link, ci_setting( 'read_more_text' ), get_permalink( $post_id ) );

		if ( true === $return ) {
			return $link;
		} else {
			// We shouldn't escape $link as it contains the whole <a> element.
			echo wp_kses_post( $link );
		}
	}
	endif;

	// Handle the excerpt.
	add_filter( 'excerpt_length', 'ci_excerpt_length' );
	if ( ! function_exists( 'ci_excerpt_length' ) ) :
	function ci_excerpt_length( $length ) {
		return ci_setting( 'excerpt_length' );
	}
	endif;

	add_filter( 'excerpt_more', 'ci_excerpt_more' );
	if ( ! function_exists( 'ci_excerpt_more' ) ) :
	function ci_excerpt_more( $more ) {
		return ci_setting( 'excerpt_text' );
	}
	endif;

	add_filter( 'excerpt_more', 'ci_link_excerpt_more', 99 );
	if ( ! function_exists( 'ci_link_excerpt_more' ) ) :
	function ci_link_excerpt_more( $more ) {
		$link = ci_setting( 'excerpt_link_cutoff' );
		if ( ! empty( $link ) ) {
			return '<a href="' . esc_url( get_permalink() ) . '">' . $more . '</a>';
		} else {
			return $more;
		}
	}
	endif;

	add_filter( 'the_content_more_link', 'ci_change_read_more', 10, 2 );
	if ( ! function_exists( 'ci_change_read_more' ) ) :
	function ci_change_read_more( $more_link, $more_link_text ) {
		return str_replace( $more_link_text, ci_setting( 'read_more_text' ), $more_link );
	}
	endif;


	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_excerpt', 10, 2 );
	function truenorth_panel_sanitize_snippet_excerpt( $values, $defaults ) {
		$values['preview_content']     = in_array( $values['preview_content'], array( 'enabled', 'disabled' ), true ) ? $values['preview_content'] : $defaults['preview_content'];
		$values['read_more_text']      = wp_kses_post( $values['read_more_text'] );
		$values['excerpt_length']      = absint( $values['excerpt_length'] );
		$values['excerpt_text']        = wp_kses_post( $values['excerpt_text'] );
		$values['excerpt_link_cutoff'] = 'on' === $values['excerpt_link_cutoff'] ? 'on' : '';

		return $values;
	}
?>
<?php else : ?>

	<fieldset id="ci-panel-excerpt" class="set">
		<legend><?php esc_html_e( 'Content Preview', 'truenorth' ); ?></legend>

		<fieldset id="ci-panel-excerpt-preview-content">
			<p class="guide"><?php esc_html_e( 'You can select whether you want the Content or the Excerpt to be displayed on listing pages.', 'truenorth' ); ?></p>
			<label><?php esc_html_e( 'Use the following on listing pages', 'truenorth' ); ?></label>
			<?php
				ci_panel_radio( 'preview_content', 'use_content', 'enabled', __( 'Use the Content', 'truenorth' ) );
				ci_panel_radio( 'preview_content', 'use_excerpt', 'disabled', __( 'Use the Excerpt', 'truenorth' ) );
			?>
		</fieldset>

		<fieldset id="ci-panel-excerpt-read-more">
			<p class="guide mt10"><?php esc_html_e( 'You can set what the Read More text will be. This applies to both the Content and the Excerpt.', 'truenorth' ); ?></p>
			<?php ci_panel_input( 'read_more_text', __( 'Read More text', 'truenorth' ) ); ?>
		</fieldset>

		<fieldset id="ci-panel-excerpt-excerpt-options">
			<p class="guide mt10"><?php esc_html_e( 'You can define how long the Excerpt will be (in words). You can also set the text that appears when the excerpt is auto-generated and is automatically cut-off. These options only apply to the Excerpt.', 'truenorth' ); ?></p>
			<?php
				ci_panel_input( 'excerpt_length', __( 'Excerpt length (in words)', 'truenorth' ) );
				ci_panel_input( 'excerpt_text', __( 'Excerpt auto cut-off text', 'truenorth' ) );
				ci_panel_checkbox( 'excerpt_link_cutoff', 'on', __( 'Link cut-off text to permalink', 'truenorth' ) );
			?>
		</fieldset>
	</fieldset>

<?php endif;
