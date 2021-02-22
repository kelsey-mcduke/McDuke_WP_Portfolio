<?php
/*---------------------------First highlight color-------------------*/

	$feminine_shop_first_color = get_theme_mod('feminine_shop_first_color');

	$feminine_shop_custom_css= "";

	if($feminine_shop_first_color != false){
		$feminine_shop_custom_css .='#slider .carousel-control-prev-icon, #slider .carousel-control-next-icon, .more-btn a,#comments input[type="submit"],#comments a.comment-reply-link,input[type="submit"],.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,nav.woocommerce-MyAccount-navigation ul li, .scrollup i, .pagination span, .pagination a, .widget_product_search button, .woocommerce ul.products li.product .price, .toggle-nav i, .wp-block-button__link{';
			$feminine_shop_custom_css .='background-color: '.esc_attr($feminine_shop_first_color).';';
		$feminine_shop_custom_css .='}';
	}

	if($feminine_shop_first_color != false){
		$feminine_shop_custom_css .='a, .top-bar p,.custom-social-icons i:hover,span.cart_no i,.more-btn a:hover,input[type="submit"]:hover,#comments input[type="submit"]:hover,#comments a.comment-reply-link:hover,#slider .carousel-control-prev-icon:hover, #slider .carousel-control-next-icon:hover,#sidebar h3,.copyright p,.pagination .current,.pagination a:hover,#footer .tagcloud a:hover,#sidebar h3 a.rsswidget,#sidebar .tagcloud a:hover,.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,.woocommerce span.onsale,.widget_product_search button:hover, #slider .carousel-control-next-icon:hover,#slider .carousel-control-prev-icon:hover,#about-us strong, #about-us h3, .woocommerce div.product p.price, .woocommerce div.product span.price{';
			$feminine_shop_custom_css .='color: '.esc_attr($feminine_shop_first_color).';';
		$feminine_shop_custom_css .='}';
	}

	if($feminine_shop_first_color != false){
		$feminine_shop_custom_css .='.wp-block-button .wp-block-button__link:hover{';
			$feminine_shop_custom_css .='color: '.esc_attr($feminine_shop_first_color).'!important;';
		$feminine_shop_custom_css .='}';
	}

	if($feminine_shop_first_color != false){
		$feminine_shop_custom_css .='.woocommerce ul.products li.product a img{';
			$feminine_shop_custom_css .='border-color: '.esc_attr($feminine_shop_first_color).';';
		$feminine_shop_custom_css .='}';
	}

	/*---------------- Second highlight color-------------------*/

	$feminine_shop_second_color = get_theme_mod('feminine_shop_second_color');

	if($feminine_shop_second_color != false){
		$feminine_shop_custom_css .='.top-bar,#footer-2,.main-inner-box span.entry-date,.custom-social-icons i:hover,span.cart_no i,.more-btn a:hover,input[type="submit"]:hover,#comments input[type="submit"]:hover,#comments a.comment-reply-link:hover,#slider .carousel-control-prev-icon:hover, #slider .carousel-control-next-icon:hover,#sidebar h3,.pagination .current,.pagination a:hover,#footer .tagcloud a:hover,#sidebar .tagcloud a:hover,.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,.woocommerce span.onsale,.widget_product_search button:hover, .wp-block-button .wp-block-button__link:hover{';
			$feminine_shop_custom_css .='background-color: '.esc_attr($feminine_shop_second_color).';';
		$feminine_shop_custom_css .='}';
	}

	if($feminine_shop_second_color != false){
		$feminine_shop_custom_css .='#footer .textwidget a,#footer li a:hover,.post-main-box:hover h3 a,#sidebar ul li a:hover,.post-navigation a:hover .post-title, .post-navigation a:focus .post-title,.post-navigation a:hover,.post-navigation a:focus{';
			$feminine_shop_custom_css .='color: '.esc_attr($feminine_shop_second_color).';';
		$feminine_shop_custom_css .='}';
	}

	/*---------------------------Width Layout -------------------*/

	$feminine_shop_theme_lay = get_theme_mod( 'feminine_shop_width_option','Full Width');
    if($feminine_shop_theme_lay == 'Boxed'){
		$feminine_shop_custom_css .='body{';
			$feminine_shop_custom_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
		$feminine_shop_custom_css .='}';
		$feminine_shop_custom_css .='#slider .carousel-control-prev-icon{';
			$feminine_shop_custom_css .='border-width: 25px 163px 25px 0; top: 42px;';
		$feminine_shop_custom_css .='}';
		$feminine_shop_custom_css .='#slider .carousel-control-next-icon{';
			$feminine_shop_custom_css .='border-width: 25px 0 25px 170px; top: 42px;';
		$feminine_shop_custom_css .='}';
	}else if($feminine_shop_theme_lay == 'Wide Width'){
		$feminine_shop_custom_css .='body{';
			$feminine_shop_custom_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$feminine_shop_custom_css .='}';
	}else if($feminine_shop_theme_lay == 'Full Width'){
		$feminine_shop_custom_css .='body{';
			$feminine_shop_custom_css .='max-width: 100%;';
		$feminine_shop_custom_css .='}';
	}

	/*--------------------------- Slider Content Layout -------------------*/

	$feminine_shop_slider_image = get_theme_mod('feminine_shop_slider_image');
	if($feminine_shop_slider_image != false){
		$feminine_shop_custom_css .='#slider{';
			$feminine_shop_custom_css .='background: url('.esc_url($feminine_shop_slider_image).');';
		$feminine_shop_custom_css .='}';
	}

	$feminine_shop_theme_lay = get_theme_mod( 'feminine_shop_slider_content_option','Left');
    if($feminine_shop_theme_lay == 'Left'){
		$feminine_shop_custom_css .='#slider .carousel-caption{';
			$feminine_shop_custom_css .='text-align:left; right: 48%;';
		$feminine_shop_custom_css .='}';
	}else if($feminine_shop_theme_lay == 'Center'){
		$feminine_shop_custom_css .='#slider .carousel-caption{';
			$feminine_shop_custom_css .='text-align:center; right: 25%; left: 25%;';
		$feminine_shop_custom_css .='}';
	}else if($feminine_shop_theme_lay == 'Right'){
		$feminine_shop_custom_css .='#slider .carousel-caption{';
			$feminine_shop_custom_css .='text-align:right; right: 10%; left: 48%;';
		$feminine_shop_custom_css .='}';
	}

	/*---------------------------Blog Layout -------------------*/

	$feminine_shop_theme_lay = get_theme_mod( 'feminine_shop_blog_layout_option','Default');
    if($feminine_shop_theme_lay == 'Default'){
		$feminine_shop_custom_css .='.post-main-box{';
			$feminine_shop_custom_css .='';
		$feminine_shop_custom_css .='}';
	}else if($feminine_shop_theme_lay == 'Center'){
		$feminine_shop_custom_css .='.post-main-box, .post-main-box h2, .post-info, .new-text p{';
			$feminine_shop_custom_css .='text-align:center;';
		$feminine_shop_custom_css .='}';
		$feminine_shop_custom_css .='.post-info{';
			$feminine_shop_custom_css .='margin-top:10px;';
		$feminine_shop_custom_css .='}';
	}else if($feminine_shop_theme_lay == 'Left'){
		$feminine_shop_custom_css .='.post-main-box, .post-main-box h2, .post-info, .new-text p, #our-services p{';
			$feminine_shop_custom_css .='text-align:Left;';
		$feminine_shop_custom_css .='}';
		$feminine_shop_custom_css .='.post-main-box h2{';
			$feminine_shop_custom_css .='margin-top:10px;';
		$feminine_shop_custom_css .='}';
	}

	/*----------------Responsive Media -----------------------*/

	$feminine_shop_resp_slider = get_theme_mod( 'feminine_shop_resp_slider_hide_show',true);
    if($feminine_shop_resp_slider == true){
    	$feminine_shop_custom_css .='@media screen and (max-width:575px) {';
		$feminine_shop_custom_css .='#slider{';
			$feminine_shop_custom_css .='display:block;';
		$feminine_shop_custom_css .='} }';
	}else if($feminine_shop_resp_slider == false){
		$feminine_shop_custom_css .='@media screen and (max-width:575px) {';
		$feminine_shop_custom_css .='#slider{';
			$feminine_shop_custom_css .='display:none;';
		$feminine_shop_custom_css .='} }';
	}

	$feminine_shop_resp_metabox = get_theme_mod( 'feminine_shop_metabox_hide_show',true);
    if($feminine_shop_resp_metabox == true){
    	$feminine_shop_custom_css .='@media screen and (max-width:575px) {';
		$feminine_shop_custom_css .='.post-info{';
			$feminine_shop_custom_css .='display:block;';
		$feminine_shop_custom_css .='} }';
	}else if($feminine_shop_resp_metabox == false){
		$feminine_shop_custom_css .='@media screen and (max-width:575px) {';
		$feminine_shop_custom_css .='.post-info{';
			$feminine_shop_custom_css .='display:none;';
		$feminine_shop_custom_css .='} }';
	}

	$feminine_shop_resp_sidebar = get_theme_mod( 'feminine_shop_sidebar_hide_show',true);
    if($feminine_shop_resp_sidebar == true){
    	$feminine_shop_custom_css .='@media screen and (max-width:575px) {';
		$feminine_shop_custom_css .='#sidebar{';
			$feminine_shop_custom_css .='display:block;';
		$feminine_shop_custom_css .='} }';
	}else if($feminine_shop_resp_sidebar == false){
		$feminine_shop_custom_css .='@media screen and (max-width:575px) {';
		$feminine_shop_custom_css .='#sidebar{';
			$feminine_shop_custom_css .='display:none;';
		$feminine_shop_custom_css .='} }';
	}

	$feminine_shop_resp_scroll_top = get_theme_mod( 'feminine_shop_resp_scroll_top_hide_show',false);
    if($feminine_shop_resp_scroll_top == true){
    	$feminine_shop_custom_css .='@media screen and (max-width:575px) {';
		$feminine_shop_custom_css .='.scrollup i{';
			$feminine_shop_custom_css .='display:block;';
		$feminine_shop_custom_css .='} }';
	}else if($feminine_shop_resp_scroll_top == false){
		$feminine_shop_custom_css .='@media screen and (max-width:575px) {';
		$feminine_shop_custom_css .='.scrollup i{';
			$feminine_shop_custom_css .='display:none !important;';
		$feminine_shop_custom_css .='} }';
	}

	/*---------------- Button Settings ------------------*/

	$feminine_shop_button_border_radius = get_theme_mod('feminine_shop_button_border_radius');
	if($feminine_shop_button_border_radius != false){
		$feminine_shop_custom_css .='.post-main-box .more-btn a{';
			$feminine_shop_custom_css .='border-radius: '.esc_attr($feminine_shop_button_border_radius).'px;';
		$feminine_shop_custom_css .='}';
	}

	/*-------------- Copyright Alignment ----------------*/

	$feminine_shop_copyright_alingment = get_theme_mod('feminine_shop_copyright_alingment');
	if($feminine_shop_copyright_alingment != false){
		$feminine_shop_custom_css .='.copyright p{';
			$feminine_shop_custom_css .='text-align: '.esc_attr($feminine_shop_copyright_alingment).';';
		$feminine_shop_custom_css .='}';
	}