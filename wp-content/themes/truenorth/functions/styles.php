<?php
add_action( 'init', 'ci_register_theme_styles' );
if ( ! function_exists( 'ci_register_theme_styles' ) ) :
	function ci_register_theme_styles() {
		//
		// Register all front-end and admin styles here.
		// There is no need to register them conditionally, as the enqueueing can be conditional.
		//
		$font_url = '';
		/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'truenorth' ) ) {
			$font_url = add_query_arg( 'family', urlencode( 'Montserrat:400,700' ), '//fonts.googleapis.com/css' );
		}
		wp_register_style( 'ci-google-font', esc_url( $font_url ) );

		wp_register_style( 'ci-base', get_template_directory_uri() . '/css/base.css', array(), truenorth_asset_version() );
		wp_register_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css', array(), truenorth_asset_version( '2.5.0' ) );
		wp_register_style( 'mmenu', get_template_directory_uri() . '/css/mmenu.css', array(), truenorth_asset_version( '5.2.0' ) );
		wp_register_style( 'magnific', get_template_directory_uri() . '/css/magnific.css', array(), truenorth_asset_version( '1.0.0' ) );
		wp_register_style( 'font-awesome-5', get_theme_file_uri( '/assets/fontawesome/css/all.min.css' ), array(), truenorth_asset_version( '5.7.2' ) );

		wp_register_style( 'ci-repeating-fields', get_theme_file_uri( '/css/admin/repeating-fields.css' ), array(), truenorth_asset_version() );
		wp_register_style( 'ci-post-edit-screens', get_theme_file_uri( '/css/admin/post-edit-screens.css' ), array(
			'ci-repeating-fields',
		), truenorth_asset_version() );

		wp_register_style( 'ci-admin-widgets', get_theme_file_uri( '/css/admin/admin-widgets.css' ), array(
			'ci-repeating-fields',
		), truenorth_asset_version() );

		wp_register_style( 'truenorth-dependencies', false, array(
			'ci-google-font',
			'ci-base',
			'truenorth-common',
			'flexslider',
			'mmenu',
			'font-awesome-5',
			'magnific',
		), truenorth_asset_version() );

		if ( is_child_theme() ) {
			wp_register_style( 'truenorth-style-parent', get_template_directory_uri() . '/style.css', array(
				'truenorth-dependencies',
			), truenorth_asset_version() );
		}

		wp_register_style( 'ci-style', get_stylesheet_uri(), array(
			'truenorth-dependencies',
		), truenorth_asset_version() );
	}
endif;


add_action( 'wp_enqueue_scripts', 'ci_enqueue_theme_styles' );
if ( ! function_exists( 'ci_enqueue_theme_styles' ) ) :
	function ci_enqueue_theme_styles() {
		//
		// Enqueue all (or most) front-end styles here.
		//
		if ( is_child_theme() ) {
			wp_enqueue_style( 'truenorth-style-parent' );
		}

		wp_enqueue_style( 'ci-style' );
		wp_add_inline_style( 'ci-style', truenorth_get_all_customizer_css() );

	}
endif;


if ( ! function_exists( 'ci_enqueue_admin_theme_styles' ) ) :
	add_action( 'admin_enqueue_scripts', 'ci_enqueue_admin_theme_styles' );
	function ci_enqueue_admin_theme_styles() {
		global $pagenow;

		//
		// Enqueue here styles that are to be loaded on all admin pages.
		//
		if ( is_admin() && 'themes.php' === $pagenow && isset( $_GET['page'] ) && 'ci_panel.php' === $_GET['page'] ) {
			//
			// Enqueue here styles that are to be loaded only on CSSIgniter Settings panel.
			//
		}

		if ( in_array( $pagenow, array( 'widgets.php', 'customize.php' ), true ) ) {
			wp_enqueue_style( 'ci-admin-widgets' );
		}
	}
endif;

if ( ! function_exists( 'truenorth_get_all_customizer_css' ) ) :
	function truenorth_get_all_customizer_css() {
		$styles = array(
			'customizer' => truenorth_get_customizer_css(),
		);

		$styles = apply_filters( 'truenorth_all_customizer_css', $styles );

		return implode( PHP_EOL, $styles );
	}
endif;
