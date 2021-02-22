<?php
/**
 * Feminine Shop Child functions and definitions
 *
 * @package Feminine Shop
 */

 // Enqueue scripts and styles
function feminine_child_scripts(){
	wp_enqueue_style( 'feminine-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'feminine-style' ));
}
add_action( 'wp_enqueue_scripts', 'feminine_child_scripts' );


//Create body class
function feminine_child_body_classes( $classes ) {
  if ( is_page( 'Homepage' ) ) {
    $classes[] = 'homepage';
  }
  return $classes;
}
add_filter( 'body_class','feminine_child_body_classes' );