<?php
/**
 * Scout-Base functions and definitions
 *
 * @package Scout-Base
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'scout_base_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function scout_base_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Scout-Base, use a find and replace
	 * to change 'scout-base' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'scout-base', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'scout-base' ),
	) );
	
	register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'test-menu' ),
) );





	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'scout_base_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // scout_base_setup
add_action( 'after_setup_theme', 'scout_base_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function scout_base_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'scout-base' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'scout_base_widgets_init' );

// Fixes some styling issues with bootstrap-wordpress integration
remove_filter ('the_content', 'wpautop');


/**
 * Enqueue scripts and styles.
 */
function scout_base_scripts() {
	wp_enqueue_style( 'scout-base-style', get_stylesheet_uri() );

	wp_enqueue_script('jquery');

	wp_enqueue_script( 'scout-base-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'scout-base-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Sets up and implements bootstrap

     wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '3.0.1', true );

     wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css', '3.0.1' );



} // End Function scout_base_scripts()




add_action( 'wp_enqueue_scripts', 'scout_base_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';




// Start the custom post types (and custom taxonomies)
add_action( 'init', 'scout_create_post_type' );
function scout_create_post_type() {


            //------------------------------------------------------------------------
            // 						Create "Ventures" post type
            //------------------------------------------------------------------------

                // Main Post Type

                register_post_type( 'idea_ventures',
                        array(
                                'labels' => array(
                                        'name' => __( 'Ventures' ),
                                        'singular_name' => __( 'Venture' )
                                ),
                        'public' => true,
                        'has_archive' => true,
                        'menu_position' => 20, // 5 - below Posts | 10 - below Media | 20 - below Pages
                        'hierarchical' => false,
                        'rewrite' => array('slug' => 'ventures', 'with_front' => false ),
                        'supports' => array( 'title', 'editor', 'custom-fields', 'thumbnail', 'excerpt' )
                        )
                );

                // Status Category

                register_taxonomy('idea_ventures_status',
      array( 'idea_ventures' ),
      array(
                        'hierarchical' => true,
                        'labels' => array(
                                'name' => _x( 'Venture Status', 'taxonomy general name' ),
                                'menu_name' => __( 'Venture Status' ),
                        ),
                        'show_ui' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'people-role' )
              )
           );        





            //------------------------------------------------------------------------
            // 						Create "Management Members" post type
            //------------------------------------------------------------------------

                // Main Post Type

                register_post_type( 'idea_management',
                        array(
                                'labels' => array(
                                        'name' => __( 'Management Members' ),
                                        'singular_name' => __( 'Management Member' )
                                ),
                        'public' => true,
                        'has_archive' => true,
                        'menu_position' => 20, // 5 - below Posts | 10 - below Media | 20 - below Pages
                        'hierarchical' => false,
                        'rewrite' => array('slug' => 'Management Members', 'with_front' => false ),
                        'supports' => array( 'title', 'editor', 'custom-fields', 'thumbnail', 'excerpt' )
                        )
                );







} // END scout_create_post_type() 


























