<?php global $ci, $ci_defaults, $load_defaults, $content_width; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	$ci_defaults['comments_off_message'] = '';
	$ci_defaults['pages_comments_off']   = '';

	add_filter( 'comments_open', 'ci_disable_pages_comments', 10, 2 );
	if ( ! function_exists( 'ci_disable_pages_comments' ) ) :
	function ci_disable_pages_comments( $comments_open, $post_id ) {
		if ( is_page( $post_id ) ) {
			if ( ci_setting( 'pages_comments_off' ) === 'enabled' ) {
				return false;
			} else {
				return $comments_open;
			}
		} else {
			return $comments_open;
		}
	}
	endif;

	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_comments', 10, 2 );
	function truenorth_panel_sanitize_snippet_comments( $values, $defaults ) {
		$values['comments_off_message'] = 'enabled' === $values['comments_off_message'] ? 'enabled' : '';
		$values['pages_comments_off']   = 'enabled' === $values['pages_comments_off'] ? 'enabled' : '';

		return $values;
	}
?>
<?php else : ?>

	<fieldset id="ci-panel-comments" class="set">
		<legend><?php esc_html_e( 'Comments', 'truenorth' ); ?></legend>
		<p class="guide"><?php echo wp_kses( __( 'You can disable comments specifically for <strong>Pages</strong>. This is usually preferred as pages traditionally hold static, presentational content. When checked, <strong>all</strong> pages will <strong>not</strong> have comments, overriding each page\'s setting. <br />You can also enable or disable the "Comments are closed" message displayed on the bottom of each post/page/etc when the comments are closed. This applies everywhere.', 'truenorth' ), truenorth_get_allowed_tags( 'guide' ) ); ?></p>
		<fieldset>
			<?php ci_panel_checkbox( 'pages_comments_off', 'enabled', __( 'Disable comments for pages.', 'truenorth' ) ); ?>
			<?php ci_panel_checkbox( 'comments_off_message', 'enabled', __( 'Show "Comments are closed" message.', 'truenorth' ) ); ?>
		</fieldset>
	</fieldset>

<?php endif;
