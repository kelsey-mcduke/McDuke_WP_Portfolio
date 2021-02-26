<?php global $ci, $ci_defaults, $load_defaults, $content_width; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	if ( ! function_exists( 'ci_the_post_thumbnail_full' ) ) :
	function ci_the_post_thumbnail_full( $args = array() ) {
		$args = wp_parse_args( (array) $args, array(
			'class'   => '',
			'noalign' => false,
		) );

		$attr = array();

		if ( ci_setting( 'featured_full_use_full' ) === 'full' ) {
			$attr['class'] = $args['class'];

			if ( empty( $attr['class'] ) ) {
				unset( $attr['class'] );
			}

			the_post_thumbnail( 'ci_featured_full', $attr );
		} elseif ( ci_setting( 'featured_full_use_full' ) === 'single' ) {
			$attr['class'] = $args['class'];

			if ( false === $args['noalign'] ) {
				$attr['class'] .= ' ' . ci_setting( 'featured_single_align' ) . ' ';
			}

			if ( empty( $attr['class'] ) ) {
				unset( $attr['class'] );
			}

			the_post_thumbnail( 'ci_featured_single', $attr );
		}
	}
	endif;


	$fullwidth_width = intval( apply_filters( 'ci_full_template_width', 960 ) );

	$ci_defaults['featured_full_height']   = intval( $fullwidth_width / 3 );
	$ci_defaults['featured_full_use_full'] = 'full';

	if ( ci_setting( 'featured_full_use_full' ) === 'full' ) {
		add_image_size( 'ci_featured_full', $fullwidth_width, intval( ci_setting( 'featured_full_height' ) ), true );
	}


	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_featured_image_fullwidth', 10, 2 );
	function truenorth_panel_sanitize_snippet_featured_image_fullwidth( $values, $defaults ) {
		$values['featured_full_use_full'] = in_array( $values['preview_content'], array( 'full', 'single', 'disabled' ), true ) ? $values['featured_full_use_full'] : $defaults['featured_full_use_full'];
		$values['featured_full_height']   = absint( $values['featured_full_height'] );

		return $values;
	}
?>
<?php else : ?>

	<fieldset id="ci-panel-featured-image-fullwidth" class="set">
		<legend><?php esc_html_e( 'Featured Image - Full Width', 'truenorth' ); ?></legend>
		<p class="guide"><?php esc_html_e( 'You can select whether the full width page template (if applicable) will use it\'s own image size, or the same configuration as normal posts and pages. If you select its own size, you can only configure the height of the image, as the width will match the width of the page by default. Please note that if you choose the full width and/or change its height, you will need to regenerate your thumbnails.', 'truenorth' ); ?></p>
		<?php
			$fullwidth_options = array(
				'full'     => __( 'Full width image', 'truenorth' ),
				'single'   => __( 'The same as posts/pages', 'truenorth' ),
				'disabled' => _x( 'Disabled', 'featured image is disabled', 'truenorth' ),
			);
			ci_panel_dropdown( 'featured_full_use_full', $fullwidth_options, __( 'Featured image for Full Width template is', 'truenorth' ) );
		?>

		<fieldset class="mt10">
			<?php ci_panel_input( 'featured_full_height', __( 'Full Width featured image height', 'truenorth' ) ); ?>
		</fieldset>
	</fieldset>

<?php endif;
