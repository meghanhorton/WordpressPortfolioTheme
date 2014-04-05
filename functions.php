<?php
/*
Author: Meghan Horton
URL: htp://meghanhorton.com
*/

// ADD CUSTOM POST TYPE
add_action( 'init', 'create_post_type' );
add_action( 'init', 'add_custom_taxonomies', 0 );


// CREATE PORTFOLIO
function create_post_type() {
	register_post_type( 'portfolio',
		array(
			'labels' => array(
				'name' => __( 'Portfolio' ),
				'singular_name' => __( 'Portfolio Item' )
			),
		'taxonomies' => array('portfolio_categories'), 
		'public' => true,
		'has_archive' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-format-gallery',
		'supports' => array('title','editor','thumbnail','excerpt','post-formats'),
		)
	);
}

// CREATE PORTFOLIO TAXONOMIES
function add_custom_taxonomies() {
	// Add new "Locations" taxonomy to Posts
	register_taxonomy('portfolio_categories', 'portfolio', array(
		// Hierarchical taxonomy (like categories)
		'hierarchical' => true,
		// This array of options controls the labels displayed in the WordPress Admin UI
		'labels' => array(
			'name' => _x( 'Portfolio Categories', 'taxonomy general name' ),
			'singular_name' => _x( 'Portfolio Category', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Portfolio Categories' ),
			'all_items' => __( 'All Categories' ),
			'parent_item' => __( 'Parent Category' ),
			'parent_item_colon' => __( 'Parent Category:' ),
			'edit_item' => __( 'Edit Portfolio Category' ),
			'update_item' => __( 'Update Portfolio Category' ),
			'add_new_item' => __( 'Add New Portfolio Category' ),
			'new_item_name' => __( 'New Portfolio Category' ),
			'menu_name' => __( 'Categories' ),
		),
		// Control the slugs used for this taxonomy
		'rewrite' => array(
			'slug' => 'portfolio/category', // This controls the base slug that will display before each term
			'with_front' => true, // Don't display the category base before "/locations/"
			'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
		),
	));

	// Add new "Locations" taxonomy to Posts
	register_taxonomy('portfolio_skills', 'portfolio', array(
		'hierarchical' => false,
		// This array of options controls the labels displayed in the WordPress Admin UI
		'labels' => array(
			'name' => _x( 'Portfolio Skills', 'taxonomy general name' ),
			'singular_name' => _x( 'Portfolio Skills', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Portfolio Skills' ),
			'all_items' => __( 'All Skills' ),
			'parent_item' => __( 'Parent Skills' ),
			'parent_item_colon' => __( 'Parent Skills:' ),
			'edit_item' => __( 'Edit Portfolio Skills' ),
			'update_item' => __( 'Update Portfolio Tag' ),
			'add_new_item' => __( 'Add New Portfolio Tag' ),
			'new_item_name' => __( 'New Portfolio Tag' ),
			'menu_name' => __( 'Skills' ),
		),
		// Control the slugs used for this taxonomy
		'rewrite' => array(
			'slug' => 'portfolio/skills', // This controls the base slug that will display before each term
			'with_front' => true, // Don't display the category base before "/locations/"
			'hierarchical' => false // This will allow URL's like "/locations/boston/cambridge/"
		),
	));
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
	if( is_home() ) {
		wp_enqueue_style( 'front-css',get_stylesheet_directory_uri() . '/css/home-style.css');
	}
}



// CHANGE LOCATION OF CUSTOM BG
function change_custom_background_cb() {
    $background = get_background_image();
    $color = get_background_color();
 
    if ( ! $background && ! $color )
        return;
 
    $style = $color ? "background-color: #$color;" : '';
 
    if ( $background ) {
        $image = " background-image: url('$background'); background-size: cover; background-position: middle;";
 
        $repeat = get_theme_mod( 'background_repeat', 'repeat' );
 
        if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
            $repeat = 'repeat';
 
        $repeat = " background-repeat: $repeat;";
 
        $position = get_theme_mod( 'background_position_x', 'left' );
 
        if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
            $position = 'left';
 
        $position = " background-position: top $position;";
 
        $attachment = get_theme_mod( 'background_attachment', 'scroll' );
 
        if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
            $attachment = 'scroll';
 
        $attachment = " background-attachment: $attachment;";
 
        $style .= $image . $repeat . $position . $attachment;
    }
    ?>
    <style type="text/css">
	.jumbotron { <?php echo trim( $style ); ?> }
	</style>
    <?php
}


// LAUNCH CUSTOM FUNCTIONS
function add_after_parent(){
	remove_shortcode('gallery', 'gallery_shortcode_tbs');
	add_shortcode('gallery', 'gallery_portfolio');
	add_action( 'wp_enqueue_scripts', 'add_scripts' );
	remove_theme_support('custom-background');
	add_theme_support( 'custom-background', array( 'wp-head-callback'=>'change_custom_background_cb' ) );

}

add_action('after_setup_theme','add_after_parent',11); 

?>