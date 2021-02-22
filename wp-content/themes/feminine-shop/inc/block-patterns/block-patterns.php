<?php
/**
 * Feminine Shop: Block Patterns
 *
 * @package Feminine Shop
 * @since   1.0.0
 */

/**
 * Register Block Pattern Category.
 */
if ( function_exists( 'register_block_pattern_category' ) ) {
	register_block_pattern_category( 'feminine-shop',
		array( 'label' => __( 'Feminine Shop', 'feminine-shop' ) )
	);
}

/**
 * Register Block Patterns.
 */
if ( function_exists( 'register_block_pattern' ) ) {
	register_block_pattern(
		'feminine-shop/banner-section',
		array(
			'title'      => __( 'Banner Section', 'feminine-shop' ),
			'categories' => array( 'feminine-shop' ),
			'content'    => "<!-- wp:cover {\"url\":\"" . esc_url(get_template_directory_uri()) . "/inc/block-patterns/images/slider.png\",\"id\":3001,\"dimRatio\":30,\"focalPoint\":{\"x\":\"0.42\",\"y\":\"0.49\"},\"align\":\"full\",\"className\":\"Banner-section\"} -->\n<div class=\"wp-block-cover alignfull has-background-dim-30 has-background-dim Banner-section\" style=\"background-image:url(" . esc_url(get_template_directory_uri()) . "/inc/block-patterns/images/slider.png);background-position:42% 49%\"><div class=\"wp-block-cover__inner-container\"><!-- wp:columns {\"align\":\"full\",\"className\":\"mx-lg-5 px-lg-5 mx-md-3 px-md-3 mx-1 px-1\"} -->\n<div class=\"wp-block-columns alignfull mx-lg-5 px-lg-5 mx-md-3 px-md-3 mx-1 px-1\"><!-- wp:column {\"width\":\"50.33%\",\"className\":\"banner-inner-box text-lg-left text-md-left text-center\"} -->\n<div class=\"wp-block-column banner-inner-box text-lg-left text-md-left text-center\" style=\"flex-basis:50.33%\"><!-- wp:heading {\"level\":6,\"style\":{\"typography\":{\"fontSize\":14}}} -->\n<h6 style=\"font-size:14px\">LOREM IPSUM HAS BEEN THE INDUSTRY</h6>\n<!-- /wp:heading -->\n\n<!-- wp:heading -->\n<h2>Lorem Ipsum has been the industrys standard</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Lorem Ipsum has been the industrys standard dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons {\"className\":\"m-0\"} -->\n<div class=\"wp-block-buttons m-0\"><!-- wp:button {\"borderRadius\":5,\"style\":{\"color\":{\"background\":\"#19203f\"}},\"textColor\":\"white\"} -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link has-white-color has-text-color has-background\" style=\"border-radius:5px;background-color:#19203f\">EXPLORE NOW &gt;&gt;</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:column -->\n\n<!-- wp:column {\"width\":\"66.66%\"} -->\n<div class=\"wp-block-column\" style=\"flex-basis:66.66%\"><!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns --></div></div>\n<!-- /wp:cover -->",
		)
	);

	register_block_pattern(
		'feminine-shop/article-section',
		array(
			'title'      => __( 'Product Section', 'feminine-shop' ),
			'categories' => array( 'feminine-shop' ),
			'content'    => "<!-- wp:group {\"align\":\"full\",\"className\":\"product-section py-5\"} -->\n<div class=\"wp-block-group alignfull product-section py-5\"><div class=\"wp-block-group__inner-container\"><!-- wp:columns {\"align\":\"full\",\"className\":\"mx-lg-5 px-lg-5 mx-md-3 px-md-3 mx-1 px-1\"} -->\n<div class=\"wp-block-columns alignfull mx-lg-5 px-lg-5 mx-md-3 px-md-3 mx-1 px-1\"><!-- wp:column {\"width\":\"43%\",\"className\":\"text-lg-left text-md-center text-center mb-lg-0 mb-md-3 mb-3\"} -->\n<div class=\"wp-block-column text-lg-left text-md-center text-center mb-lg-0 mb-md-3 mb-3\" style=\"flex-basis:43%\"><!-- wp:heading {\"level\":6,\"className\":\"product-sec-text\",\"style\":{\"typography\":{\"fontSize\":14}}} -->\n<h6 class=\"product-sec-text\" style=\"font-size:14px\">Our Features &amp; Quality Details!</h6>\n<!-- /wp:heading -->\n\n<!-- wp:heading {\"level\":3} -->\n<h3>Lorem Ipsum has been the industrys standard dummy</h3>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"style\":{\"color\":{\"text\":\"#71788c\"},\"typography\":{\"fontSize\":14}}} -->\n<p class=\"has-text-color\" style=\"color:#71788c;font-size:14px\">Lorem Ipsum has been the industrys standard dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons {\"className\":\"m-0\"} -->\n<div class=\"wp-block-buttons m-0\"><!-- wp:button {\"borderRadius\":8,\"style\":{\"color\":{\"background\":\"#19203f\"}},\"textColor\":\"white\",\"className\":\"is-style-fill\"} -->\n<div class=\"wp-block-button is-style-fill\"><a class=\"wp-block-button__link has-white-color has-text-color has-background\" style=\"border-radius:8px;background-color:#19203f\">KNOW MORE &gt;&gt;</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:column -->\n\n<!-- wp:column {\"width\":\"66.66%\"} -->\n<div class=\"wp-block-column\" style=\"flex-basis:66.66%\"><!-- wp:woocommerce/product-category {\"columns\":4,\"rows\":1,\"categories\":[209],\"contentVisibility\":{\"title\":true,\"price\":true,\"rating\":true,\"button\":true}} /--></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph --></div></div>\n<!-- /wp:group -->",
		)
	);
}