<?php global $ci, $ci_defaults, $load_defaults, $content_width; ?>
<?php if ( true === $load_defaults ) : ?>
<?php

	if ( ! function_exists( 'ci_cpt_with_featured_image' ) ) :
		function ci_cpt_with_featured_image() {
			return apply_filters( 'ci_featured_image_post_types', array( 'post', 'page' ) );
		}
	endif;

	if ( ! function_exists( 'ci_the_post_thumbnail' ) ) :
		function ci_the_post_thumbnail( $args = array() ) {
			$args = wp_parse_args( (array) $args, array(
				'class'   => '',
				'noalign' => false,
			) );

			$attr = array();

			$post_type = get_post_type();
			if ( ci_setting( 'featured_single_' . $post_type . '_show' ) === 'enabled' ) {
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

	//
	// Checks if the featured image of current post should be displayed.
	// Usable only within the loop.
	//
	if ( ! function_exists( 'ci_is_featured_enabled' ) ) :
		function ci_is_featured_enabled() {
			$post_type = get_post_type();
			if ( ci_setting( 'featured_single_' . $post_type . '_show' ) === 'enabled' ) {
				return true;
			}

			return false;
		}
	endif;

	//
	// Checks if the current post has a featured image assigned, and if it should be displayed.
	// Usable only within the loop.
	//
	if ( ! function_exists( 'ci_has_image_to_show' ) ) :
		function ci_has_image_to_show() {
			return apply_filters( 'ci_has_image_to_show',
				ci_is_featured_enabled() && has_post_thumbnail(),
				ci_is_featured_enabled(),
				has_post_thumbnail()
			);
		}
	endif;


	$img_cpt = ci_cpt_with_featured_image();
	foreach ( $img_cpt as $post_type_name ) {
		$ci_defaults[ 'featured_single_' . $post_type_name . '_show' ] = 'enabled';
	}

	$ci_defaults['featured_single_width']  = apply_filters( 'ci_featured_single_width', intval( $content_width ) );
	$ci_defaults['featured_single_height'] = apply_filters( 'ci_featured_single_height', intval( $content_width / 2 ) );
	$ci_defaults['featured_single_align']  = 'alignnone';

	add_image_size( 'ci_featured_single', intval( ci_setting( 'featured_single_width' ) ), intval( ci_setting( 'featured_single_height' ) ), true );


	add_filter( 'truenorth_sanitize_panel_options', 'truenorth_panel_sanitize_snippet_featured_image_single', 10, 2 );
	function truenorth_panel_sanitize_snippet_featured_image_single( $values, $defaults ) {
		$thumb_types = ci_cpt_with_featured_image();
		foreach ( $thumb_types as $post_type_name ) {
			$values[ "featured_single_{$post_type_name}_show" ] = 'enabled' === $values[ "featured_single_{$post_type_name}_show" ] ? 'enabled' : '';
		}

		$values['featured_single_width']  = absint( $values['featured_single_width'] );
		$values['featured_single_height'] = absint( $values['featured_single_height'] );
		$values['featured_single_align']  = in_array( $values['featured_single_align'], array( 'alignnone', 'alignleft', 'aligncenter', 'alignright' ), true ) ? $values['featured_single_align'] : $defaults['featured_single_align'];

		return $values;
	}
?>
<?php else : ?>

	<fieldset id="ci-panel-featured-image-single" class="set">
		<legend><?php esc_html_e( 'Featured Image', 'truenorth' ); ?></legend>
		<p class="guide">
			<?php
				/* translators: %d is an integer number (of pixels). */
				echo wp_kses( sprintf( __( 'Control whether you want the featured image of each post to be displayed when viewing that post\'s page. The featured image can be shown/hidden on each individual post type, with common dimensions. You can define its width and height <em>(defaults to the content width, currently: %d pixels)</em>, and whether you want it aligned on the left, right or middle of the page.', 'truenorth' ), $content_width ), truenorth_get_allowed_tags( 'guide' ) );
				echo ' ';
				echo wp_kses( __( 'Note that if you change the width and/or the height of the featured images, you will need to regenerate all your thumbnails using an appropriate plugin, such as the <a href="https://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a> plugin, otherwise your images may appear distorted.', 'truenorth' ), truenorth_get_allowed_tags( 'guide' ) );
			?>
		</p>
		<?php
			$thumb_types = ci_cpt_with_featured_image();
			foreach ( $thumb_types as $post_type_name ) {
				$obj = get_post_type_object( $post_type_name );
				/* translators: %s is a post type's name. */
				ci_panel_checkbox( 'featured_single_' . $post_type_name . '_show', 'enabled', wp_kses( sprintf( __( 'Show featured images on <em>%s</em>', 'truenorth' ), $obj->labels->name ), truenorth_get_allowed_tags( 'guide' ) ) );
			}
		?>
		<fieldset class="mt10">
			<?php ci_panel_input( 'featured_single_width', __( 'Featured image Width', 'truenorth' ) ); ?>
			<?php ci_panel_input( 'featured_single_height', __( 'Featured image Height', 'truenorth' ) ); ?>
			<?php
				$align_options = array(
					'alignnone'   => __( 'None', 'truenorth' ),
					'alignleft'   => __( 'Left', 'truenorth' ),
					'aligncenter' => __( 'Center', 'truenorth' ),
					'alignright'  => __( 'Right', 'truenorth' ),
				);
				ci_panel_dropdown( 'featured_single_align', $align_options, __( 'Featured image alignment', 'truenorth' ) );
			?>
		</fieldset>
	</fieldset>

<?php endif;
