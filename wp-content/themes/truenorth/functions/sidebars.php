<?php
add_action( 'widgets_init', 'ci_widgets_init' );
if ( ! function_exists( 'ci_widgets_init' ) ) :
function ci_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html_x( 'Blog', 'widget area', 'truenorth' ),
		'id'            => 'blog',
		'description'   => __( 'This is the main sidebar.', 'truenorth' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Pages', 'widget area', 'truenorth' ),
		'id'            => 'page',
		'description'   => __( 'Widgets placed in this sidebar will appear in the static pages. If empty, blog widgets will be shown instead.', 'truenorth' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Homepage', 'widget area', 'truenorth' ),
		'id'            => 'home',
		'description'   => __( 'Widget area of the homepage.', 'truenorth' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="section-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Footer', 'widget area', 'truenorth' ),
		'id'            => 'footer',
		'description'   => __( 'Widget area on the footer.', 'truenorth' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

}
endif;

function truenorth_get_allowed_sidebar_wrappers() {
	$attributes = array(
		'id'    => true,
		'class' => true,
	);

	$allowed = array(
		'a'       => array(
			'id'     => true,
			'class'  => true,
			'href'   => true,
			'title'  => true,
			'target' => true,
		),
		'div'     => $attributes,
		'span'    => $attributes,
		'strong'  => $attributes,
		'i'       => $attributes,
		'section' => $attributes,
		'aside'   => $attributes,
		'h1'      => $attributes,
		'h2'      => $attributes,
		'h3'      => $attributes,
		'h4'      => $attributes,
		'h5'      => $attributes,
		'h6'      => $attributes,
	);

	return apply_filters( 'truenorth_get_allowed_sidebar_wrappers', $allowed );
}
