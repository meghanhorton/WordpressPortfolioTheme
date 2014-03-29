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

add_image_size( 'portfolio-small', 300, 200, true );
add_image_size( 'portfolio-large', 600, 400, true );

// add_filter( 'pre_get_posts', 'my_get_posts' );

// function my_get_posts( $query ) {

// 	if ( is_home() && $query->is_main_query() )
// 		$query->set( 'post_type', array( 'post', 'page', 'portfolio' ) );

// 	return $query;
// }

// DEFINE CUSTOM FUNCTIONS
function gallery_portfolio($attr) {
	global $post, $wp_locale;

	$output = "";

	$args = array( 'post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_parent' => $post->ID ); 
	$attachments = get_posts($args);
	if ($attachments) {
		$count = count($attachments) - 1;
		$output = 
		'<div id="gallery">
			<div id="carousel-portfolio" class="carousel slide" data-ride="carousel">';
		// INDICATORS
		$output .= '<ol class="carousel-indicators">';
		for ($i = 0; $i <= $count; $i++) {
			if($i == 0){$active = ' class="active"';} else{unset($active);}
		    $output .= '<li data-target="#carousel-portfolio" data-slide-to="'.$i.'" '.$active.'></li>';
		}
		$output .= '</ol>';
		$output .= '<div class="carousel-inner">';


		$i = 0;
		foreach ( $attachments as $attachment ) {
			if($i == 0){$active = 'active';} else{unset($active);}
			$output .= '<div class="item '.$active.'">';
			$att_title = apply_filters( 'the_title' , $attachment->post_title );
			$output .= wp_get_attachment_image( $attachment->ID , 'full');
			$output .= '<div class="carousel-caption">';
			$output .= '<h3>'.$attachment->post_title.'</h3>';
			$output .= '<h4>'.$attachment->post_content.'</h4>';
			$output .= '</div>';
			$output .= '</div>';
			$i++;
		}
		$output .= '</div>';
		$output .= '
			<a class="left carousel-control" href="#carousel-portfolio" data-slide="prev">
				    <span class="glyphicon glyphicon-chevron-left"></span>
				  </a>
				  <a class="right carousel-control" href="#carousel-portfolio" data-slide="next">
				    <span class="glyphicon glyphicon-chevron-right"></span>
				  </a>
			</div>

		</div>';
	}

	return $output;
}

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

