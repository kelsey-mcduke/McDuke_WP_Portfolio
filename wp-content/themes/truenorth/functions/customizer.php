<?php
/**
 * Registers Customizer panels, sections, and controls.
 *
 * @param WP_Customize_Manager $wp_customize Reference to the customizer's manager object.
 */
function truenorth_customize_register( $wp_customize ) {

	$wp_customize->add_panel( 'theme_colors', array(
		'title'    => esc_html_x( 'Theme Colors', 'customizer section title', 'truenorth' ),
		'priority' => 30,
	) );

	$wp_customize->add_section( 'theme_colors_header', array(
		'title'    => esc_html_x( 'Header', 'customizer section title', 'truenorth' ),
		'panel'    => 'theme_colors',
		'priority' => 20,
	) );

	$wp_customize->add_setting( 'header_bg', array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bg', array(
		'section' => 'theme_colors_header',
		'label'   => esc_html__( 'Header Background', 'truenorth' ),
	) ) );

	$wp_customize->add_setting( 'header_menu_color', array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_menu_color', array(
		'section' => 'theme_colors_header',
		'label'   => esc_html__( 'Menu Text Color', 'truenorth' ),
	) ) );

	$wp_customize->add_setting( 'header_menu_color_hover', array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_menu_color_hover', array(
		'section' => 'theme_colors_header',
		'label'   => esc_html__( 'Menu Text Color Hover', 'truenorth' ),
	) ) );

	$wp_customize->add_setting( 'header_menu_background', array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_menu_background', array(
		'section' => 'theme_colors_header',
		'label'   => esc_html__( 'Submenu Background Color', 'truenorth' ),
	) ) );

	$wp_customize->add_section( 'theme_colors_global', array(
		'title'    => esc_html_x( 'Global', 'customizer section title', 'truenorth' ),
		'panel'    => 'theme_colors',
		'priority' => 30,
	) );

	// Rename & Reposition the header image section.
	$wp_customize->get_control( 'background_color' )->section      = 'theme_colors_global';
	$wp_customize->get_control( 'background_image' )->section      = 'theme_colors_global';
	$wp_customize->get_control( 'background_preset' )->section     = 'theme_colors_global';
	$wp_customize->get_control( 'background_position' )->section   = 'theme_colors_global';
	$wp_customize->get_control( 'background_size' )->section       = 'theme_colors_global';
	$wp_customize->get_control( 'background_repeat' )->section     = 'theme_colors_global';
	$wp_customize->get_control( 'background_attachment' )->section = 'theme_colors_global';

	$wp_customize->add_setting( 'site_accent_color', array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_accent_color', array(
		'section' => 'theme_colors_global',
		'label'   => esc_html__( 'Accent color', 'truenorth' ),
	) ) );

	$wp_customize->add_setting( 'site_text_color', array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_text_color', array(
		'section' => 'theme_colors_global',
		'label'   => esc_html__( 'Text color', 'truenorth' ),
	) ) );

	$wp_customize->add_setting( 'site_header_color', array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_header_color', array(
		'section' => 'theme_colors_global',
		'label'   => esc_html__( 'Heading color', 'truenorth' ),
	) ) );

	$wp_customize->add_setting( 'site_form_bg', array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_form_bg', array(
		'section' => 'theme_colors_global',
		'label'   => esc_html__( 'Form fields background color', 'truenorth' ),
	) ) );

	$wp_customize->add_setting( 'site_form_color', array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_form_color', array(
		'section' => 'theme_colors_global',
		'label'   => esc_html__( 'Form fields text color', 'truenorth' ),
	) ) );

	$wp_customize->add_setting( 'site_form_border', array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_form_border', array(
		'section' => 'theme_colors_global',
		'label'   => esc_html__( 'Form fields border color', 'truenorth' ),
	) ) );

	$wp_customize->add_setting( 'site_button_bg', array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_button_bg', array(
		'section' => 'theme_colors_global',
		'label'   => esc_html__( 'Button background color', 'truenorth' ),
	) ) );

	$wp_customize->add_setting( 'site_button_text', array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_button_text', array(
		'section' => 'theme_colors_global',
		'label'   => esc_html__( 'Button text color', 'truenorth' ),
	) ) );

	$wp_customize->add_setting( 'site_button_bg_hover', array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_button_bg_hover', array(
		'section' => 'theme_colors_global',
		'label'   => esc_html__( 'Button background hover color', 'truenorth' ),
	) ) );

	$wp_customize->add_setting( 'site_button_text_hover', array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_button_text_hover', array(
		'section' => 'theme_colors_global',
		'label'   => esc_html__( 'Button text hover color', 'truenorth' ),
	) ) );

	$wp_customize->add_setting( 'site_identity_description_is_visible', array(
		'default'           => 1,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'site_identity_description_is_visible', array(
		'type'    => 'checkbox',
		'section' => 'title_tagline',
		'label'   => esc_html__( 'Show site tagline', 'truenorth' ),
	) );


	$wp_customize->add_panel( 'social', array(
		'title'                    => esc_html_x( 'Social', 'customizer section title', 'truenorth' ),
		'auto_expand_sole_section' => true,
	) );

	$wp_customize->add_section( 'social_content', array(
		'title' => esc_html_x( 'Social Icons', 'customizer section title', 'truenorth' ),
		'panel' => 'social',
	) );

	$networks    = truenorth_get_social_networks();
	$social_mods = array();

	foreach ( $networks as $network ) {
		$social_mod = 'social_content_' . $network['name'];

		$wp_customize->add_setting( $social_mod, array(
			'transport'         => 'postMessage',
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( $social_mod, array(
			'type'    => 'url',
			'section' => 'social_content',
			/* translators: %s is a social network's name, e.g.: Facebook URL */
			'label'   => esc_html( sprintf( _x( '%s URL', 'social network url', 'truenorth' ), $network['label'] ) ),
		) );

		$wp_customize->selective_refresh->get_partial( 'social' )->settings[] = $social_mod;
	}

	$wp_customize->add_setting( 'social_content_rss_feed', array(
		'transport'         => 'postMessage',
		'default'           => get_bloginfo( 'rss2_url' ),
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'social_content_rss_feed', array(
		'type'    => 'url',
		'section' => 'social_content',
		'label'   => esc_html__( 'RSS Feed', 'truenorth' ),
	) );
	$wp_customize->selective_refresh->get_partial( 'social' )->settings[] = 'social_content_rss_feed';

}
add_action( 'customize_register', 'truenorth_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function truenorth_base_customize_preview_js() {
	$theme = wp_get_theme();

	wp_enqueue_script( 'truenorth-customizer-preview', get_template_directory_uri() . '/js/customizer-preview.js', array( 'customize-preview' ), truenorth_asset_version(), true );
}
add_action( 'customize_preview_init', 'truenorth_base_customize_preview_js' );
