<?php
	get_template_part( 'panel/constants' );

	load_theme_textdomain( 'truenorth', get_template_directory() . '/lang' );

	// This is the main options array. Can be accessed as a global in order to reduce function calls.
	$ci          = get_option( THEME_OPTIONS );
	$ci_defaults = array();

	// The $content_width needs to be before the inclusion of the rest of the files, as it is used inside of some of them.
	if ( ! isset( $content_width ) ) $content_width = 705;

	// Add limit logo size support (to avoid using retinajs).
	add_filter( 'limit_logo_size_support', '__return_true' );

	//
	// Let's bootstrap the theme.
	//
	get_template_part( 'panel/bootstrap' );

	//
	// Let WordPress manage the title.
	//
	add_theme_support( 'title-tag' );

	//
	// Use HTML5 on galleries
	//
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	//
	// Define our various image sizes.
	// Notice: Changing the values below requires running a thumbnail regeneration
	// plugin such as "Regenerate Thumbnails" (http://wordpress.org/plugins/regenerate-thumbnails/)
	// in order for the new dimensions to take effect.
	//
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 945, 680, true );
	add_image_size( 'ci_header', 2000, 500, true );
	add_image_size( 'ci_full_height', 945 );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'truenorth_custom_background_args', array() ) );


	// Enable the automatic video thumbnails.
	add_filter( 'ci_automatic_video_thumbnail_field', 'truenorth_add_auto_thumb_video_field' );
	if ( ! function_exists( 'truenorth_add_auto_thumb_video_field' ) ) :
	function truenorth_add_auto_thumb_video_field( $field ) {
		return 'portfolio_video_url';
	}
	endif;


	function truenorth_get_columns_classes( $columns ) {
		switch ( $columns ) {
			case 1:
				$classes = 'col-md-12 columns-1';
				break;
			case 4:
				$classes = 'col-md-3 columns-4';
				break;
			case 3:
				$classes = 'col-md-4 columns-3';
				break;
			case 2:
			default:
				$classes = 'col-md-6 columns-2';
				break;
		}

		return $classes;
	}


	function ci_add_cpt_header_bg_meta_box( $post ) {
		ci_prepare_metabox( get_post_type( $post ) );

		$image_sizes = ci_get_image_sizes();
		$size        = $image_sizes['ci_header']['width'] . 'x' . $image_sizes['ci_header']['height'];

		?><div class="ci-cf-wrap"><?php
			ci_metabox_open_tab( '' );
				ci_metabox_guide( array(
					__( 'You can replace the default header image if you want, by uploading and / or selecting an already uploaded image. This applies to the current page only.', 'truenorth' ),
					/* translators: %s is image dimensions in pixels, e.g. 800x600 */
					sprintf( __( 'For best results, use a high resolution image, at least %s pixels in size. Make sure you select the desired image size before pressing <em>Use this file</em>.', 'truenorth' ), $size ),
				), array( 'type' => 'ul' ) );

				?>
				<p>
					<?php
						ci_metabox_input( 'header_image', '', array(
							'input_type'  => 'hidden',
							'esc_func'    => 'esc_url',
							'input_class' => 'uploaded',
							'before'      => '',
							'after'       => '',
						) );

						ci_metabox_input( 'header_image_id', '', array(
							'input_type'  => 'hidden',
							'input_class' => 'uploaded-id',
							'before'      => '',
							'after'       => '',
						) );
					?>
					<span class="selected_image" style="display: block;">
						<?php
							$image_url = wp_get_attachment_image_url( get_post_meta( $post->ID, 'header_image_id', true ), 'thumbnail' );
							if ( ! empty( $image_url ) ) {
								echo sprintf( '<img src="%s" /><a href="#" class="close media-modal-icon"></a>', $image_url );
							}
						?>
					</span>
					<a href="#" class="button ci-upload"><?php esc_html_e( 'Upload / Select Image', 'truenorth' ); ?></a>
				</p>
				<?php

			ci_metabox_close_tab();
		?></div><?php
	}


	function truenorth_sanitize_checkbox( &$input ) {
		if ( $input == 1 ) {
			return 1;
		}

		return '';
	}


	/**
	 * Enable lightbox in content and comments, if applicable.
	 */
	add_filter( 'the_content', 'truenorth_lightbox_add_rel', 12 );
	add_filter( 'get_comment_text', 'truenorth_lightbox_add_rel' );
	function truenorth_lightbox_add_rel( $content ) {
		global $post;
		$pattern     = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
		$replacement = '<a$1href=$2$3.$4$5 data-lightbox="gal[' . $post->ID . ']"$6>$7</a>';
		$content     = preg_replace( $pattern, $replacement, $content );

		return $content;
	}

	/**
	 * Enable lightbox captions, if applicable.
	 */
	add_filter( 'wp_get_attachment_link', 'truenorth_wp_get_attachment_link_lightbox_caption', 10, 6 );
	function truenorth_wp_get_attachment_link_lightbox_caption( $html, $id, $size, $permalink, $icon, $text ) {
		$found = preg_match( '#(<a.*?>)<img.*?></a>#', $html, $matches );
		if ( $found ) {
			$found_title = preg_match( '#title=([\'"])(.*?)\1#', $matches[1], $title_matches );

			// Only continue if title attribute doesn't exist.
			if ( 0 === $found_title ) {
				$caption = truenorth_get_image_lightbox_caption( $id );

				if ( $caption ) {
					$new_a = $matches[1];
					$new_a = rtrim( $new_a, '>' );
					$new_a = $new_a . ' title="' . $caption . '">';

					$html = str_replace( $matches[1], $new_a, $html );
				}
			}
		}

		return $html;
	}

	/**
	 * Returns the caption of an image, to be used in a lightbox.
	 *
	 * @uses get_post_thumbnail_id()
	 * @uses wp_prepare_attachment_for_js()
	 *
	 * @param int|false $image_id The image's attachment ID.
	 *
	 * @return string
	 */
	function truenorth_get_image_lightbox_caption( $image_id = false ) {
		if ( false === $image_id ) {
			$image_id = get_post_thumbnail_id();
		}

		$lightbox_caption = '';

		$attachment = wp_prepare_attachment_for_js( $image_id );

		if ( is_array( $attachment ) ) {
			$field = apply_filters( 'truenorth_image_lightbox_caption_field', 'caption', $image_id, $attachment );

			if ( array_key_exists( $field, $attachment ) ) {
				$lightbox_caption = $attachment[ $field ];
			}
		}

		return $lightbox_caption;
	}

	add_action( 'wp_ajax_truenorth_widget_get_selected_image_preview', 'truenorth_widget_get_selected_image_preview' );
	function truenorth_widget_get_selected_image_preview() {
		$image_id   = intval( $_POST['image_id'] );
		$image_size = 'thumbnail';

		if ( ! empty( $image_id ) ) {
			$image_url = wp_get_attachment_image_url( $image_id, $image_size );
			if ( ! empty( $image_url ) ) {
				echo sprintf( '<img src="%s" /><a href="#" class="close media-modal-icon"></a>', $image_url );
			}
		}
		die;
	}

	/**
	 * Theme Elements
	 */
	if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( PHP_VERSION, '5.4', '>=' ) ) {
		require_once 'functions/elements.php';
	}

	function truenorth_post_types() {
		$post_types_available = get_post_types( array( 'public' => true ), 'objects' );
		unset( $post_types_available['attachment'] );
		if ( post_type_exists( 'elementor_library' ) ) {
			unset( $post_types_available['elementor_library'] );
		}

		$truenorth_pt[] = '';

		foreach ( $post_types_available as $key => $pt ) {
			$truenorth_pt[ $key ] = $pt->label;
		}

		return $truenorth_pt;
	}

	add_action( 'wp_ajax_truenorth_get_posts', 'ajax_truenorth_posts' );
	function ajax_truenorth_posts() {

		// Verify nonce
		if ( ! isset( $_POST['truenorth_post_nonce'] ) || ! wp_verify_nonce( $_POST['truenorth_post_nonce'], 'truenorth_post_nonce' ) ) {
			die( 'Permission denied' );
		}

		$post_type = $_POST['post_type'];

		$q = new WP_Query( array(
			'post_type'      => $post_type,
			'posts_per_page' => -1,
		) );
		?>

		<option><?php esc_html_e( 'Select an item', 'truenorth' ); ?></option>

		<?php while ( $q->have_posts() ) : $q->the_post(); ?>
			<option value="<?php echo esc_attr( get_the_ID() ); ?>"><?php the_title(); ?></option>
			<?php
		endwhile;
		wp_reset_postdata();
		wp_die();
	}


	if ( ! defined( 'TRUENORTH_WHITELABEL' ) || false === (bool) TRUENORTH_WHITELABEL ) {
		add_filter( 'pt-ocdi/import_files', 'truenorth_ocdi_import_files' );
		add_action( 'pt-ocdi/after_import', 'truenorth_ocdi_after_import_setup' );
	}

	function truenorth_ocdi_import_files( $files ) {
		if ( ! defined( 'TRUENORTH_NAME' ) ) {
			define( 'TRUENORTH_NAME', 'truenorth' );
		}

		$demo_dir_url = untrailingslashit( apply_filters( 'truenorth_ocdi_demo_dir_url', 'https://www.cssigniter.com/sample_content/' . TRUENORTH_NAME ) );

		// When having more that one predefined imports, set a preview image, preview URL, and categories for isotope-style filtering.
		$new_files = array(
			array(
				'import_file_name'           => esc_html__( 'Demo Import', 'truenorth' ),
				'import_file_url'            => $demo_dir_url . '/content.xml',
				'import_widget_file_url'     => $demo_dir_url . '/widgets.wie',
				'import_customizer_file_url' => $demo_dir_url . '/customizer.dat',
			),
		);

		return array_merge( $files, $new_files );
	}

	function truenorth_ocdi_after_import_setup() {
		// Set up nav menus.
		$main_menu      = get_term_by( 'name', 'Main Menu', 'nav_menu' );
		$secondary_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );

		set_theme_mod( 'nav_menu_locations', array(
			'main_menu'   => $main_menu->term_id,
			'footer_menu' => $secondary_menu->term_id,
		) );

		// Set up home and blog pages.
		$front_page_id = get_page_by_title( 'Home' );
		$blog_page_id  = get_page_by_title( 'Blog' );

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
		update_option( 'page_for_posts', $blog_page_id->ID );
	}

	if ( ! function_exists( 'truenorth_color_luminance' ) ) :
		/**
		 * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.
		 *
		 * @see https://gist.github.com/stephenharris/5532899
		 *
		 * @param string $color Hexadecimal color value. May be 3 or 6 digits, with an optional leading # sign.
		 * @param float $percent Decimal (0.2 = lighten by 20%, -0.4 = darken by 40%)
		 *
		 * @return string Lightened/Darkened colour as hexadecimal (with hash)
		 */
		function truenorth_color_luminance( $color, $percent ) {
			// Remove # if provided
			if ( '#' === $color[0] ) {
				$color = substr( $color, 1 );
			}

			// Validate hex string.
			$hex     = preg_replace( '/[^0-9a-f]/i', '', $color );
			$new_hex = '#';

			$percent = floatval( $percent );

			if ( strlen( $hex ) < 6 ) {
				$hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
			}

			// Convert to decimal and change luminosity.
			for ( $i = 0; $i < 3; $i ++ ) {
				$dec      = hexdec( substr( $hex, $i * 2, 2 ) );
				$dec      = min( max( 0, $dec + $dec * $percent ), 255 );
				$new_hex .= str_pad( dechex( $dec ), 2, 0, STR_PAD_LEFT );
			}

			return $new_hex;
		}
	endif;

	/**
	 * Theme-specific helper functions.
	 */
	require_once get_theme_file_path( '/functions/helpers.php' );

	/**
	 * Template tags.
	 */
	require_once get_theme_file_path( '/functions/template-tags.php' );

	/**
	 *  Common theme features.
	 */
	require_once get_theme_file_path( '/common/common.php' );

	/**
	 * Customizer additions.
	 */
	require_once get_theme_file_path( '/functions/customizer.php' );

	/**
	 * Customizer styles.
	 */
	require_once get_theme_file_path( '/functions/customizer-styles.php' );
