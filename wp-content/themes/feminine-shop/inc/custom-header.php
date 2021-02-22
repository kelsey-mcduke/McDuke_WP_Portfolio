<?php
/**
 * @package Feminine Shop
 * Setup the WordPress core custom header feature.
 *
 * @uses feminine_shop_header_style()
*/
function feminine_shop_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'feminine_shop_custom_header_args', array(
		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1400,
		'height'                 => 202,
		'flex-width'    		 => true,
		'flex-height'    		 => true,
		'wp-head-callback'       => 'feminine_shop_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'feminine_shop_custom_header_setup' );

if ( ! function_exists( 'feminine_shop_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see feminine_shop_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'feminine_shop_header_style' );

function feminine_shop_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$custom_css = "
        .middle-bar{
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
		}";
	   	wp_add_inline_style( 'feminine-shop-basic-style', $custom_css );
	endif;
}
endif;