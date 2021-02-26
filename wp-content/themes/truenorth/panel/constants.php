<?php

//
//
// The following constants are generated and should not be touched.
// Edit file /functions/constants.php instead.
//
//

get_template_part( 'functions/constants' );

if ( ! defined( 'WP_THEME_URL' ) )      define( 'WP_THEME_URL', get_stylesheet_directory_uri() );
if ( ! defined( 'CI_DOMAIN' ) )         define( 'CI_DOMAIN', 'ci_'.TRUENORTH_NAME );
if ( ! defined( 'CI_SAMPLE_CONTENT' ) ) define( 'CI_SAMPLE_CONTENT', CI_DOMAIN.'_sample_content' );
if ( ! defined( 'THEME_OPTIONS' ) )     define( 'THEME_OPTIONS', CI_DOMAIN.'_theme_options' );

// Get the version from the parent stylesheet.
$theme_data = wp_get_theme( basename( get_template_directory() ) );
$version    = $theme_data->get( 'Version' );

if ( ! defined( 'TRUENORTH_VERSION' ) ) define( 'TRUENORTH_VERSION', $version );
