<?php
/*
Author: Meghan Horton
URL: htp://meghanhorton.com
*/

// ADD CUSTOM POST TYPE
add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'portfolio',
		array(
			'labels' => array(
				'name' => __( 'Portfolio' ),
				'singular_name' => __( 'Portfolio Item' )
			),
		'taxonomies' => array('category','post_tag'), 
		'public' => true,
		'has_archive' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-format-gallery',
		'supports' => array('title','editor','thumbnail','excerpt','post-formats'),
		)
	);
}

// ALLOW CUSTOM POST TYPES ON ARCHIVE PAGES
function namespace_add_custom_types( $query ) {
  if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
    $query->set( 'post_type', array(
     'post', 'portfolio'
		));
	  return $query;
	}
}
add_filter( 'pre_get_posts', 'namespace_add_custom_types' );


// SET THUMBNAIL SIZES
add_image_size( 'portfolio-small', 300, 200, true );
add_image_size( 'portfolio-large', 600, 400, true );


// ADD CUSTOM JAVASCRIPT
function add_scripts() {
	// ADD CAROUSEL FUNCTIONALITY
	wp_enqueue_script(
		'custom',
		get_stylesheet_directory_uri() . '/js/custom.js',
		array( 'jquery' )
	);
	wp_enqueue_style( 'custom-css', get_stylesheet_directory_uri() . '/css/custom.css' );
}

// LAUNCH CUSTOM FUNCTIONS
function add_after_parent(){
	remove_shortcode('gallery', 'gallery_shortcode_tbs');
	add_shortcode('gallery', 'gallery_portfolio');
	add_action( 'wp_enqueue_scripts', 'add_scripts' );
}

add_action('after_setup_theme','add_after_parent');

