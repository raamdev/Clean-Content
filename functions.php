<?php
/**
 * simple content functions and definitions
 *
 * @package simple content
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 
 */
	//  I DON'T WANT TO. MAYBE LATER.
		// if ( ! isset( $content_width ) ) {
		// 	$content_width = 678; /* pixels */
		// }



if ( ! function_exists( 'simple_content_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function simple_content_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on simple content, use a find and replace
	 * to change 'simple-content' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'simple-content', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */

	add_theme_support( 'post-thumbnails' );

	// Increase default size for large images

	update_option('large_size_w', 1200);
	update_option('large_size_h', 1200);

	// decrease jpeq quality for retina images
	add_filter( 'jpeg_quality', create_function( '', 'return 51;' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'simple-content' ),
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
	add_theme_support( 'custom-background', apply_filters( 'simple_content_custom_background_args', array(
		'default-color' => 'f7f7f7',
		'default-image' => '',
	) ) );
}
endif; // simple_content_setup
add_action( 'after_setup_theme', 'simple_content_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function simple_content_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'simple-content' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'simple_content_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function simple_content_scripts() {
	wp_enqueue_style( 'simple-content-style', get_stylesheet_uri() );

	wp_enqueue_script( 'simple-content-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'simple-content-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'simple_content_scripts' );

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

/**
 * Returns the theme's footer credits
 *
 * @return string
 *
 */
function simple_content_get_footer_credits() {
	return sprintf(
		'%1$s',
		sprintf( __( 'Themed by %1$s, empowered by %2$s.', 'simple_content' ), '<a href="' . esc_url( 'http://alidark.com/clean-content' ) . '" rel="designer" title="Clean Content, a simple reader focused theme">Clean Content</a>', '<a href="http://wordpress.org/" rel="generator" title="WordPress: A free open-source publishing platform">WordPress</a>' )
	);
}

/**
 * Add shortcode for wide images
 *
 */

function wide($atts, $content = null) {
    return '<div class="wide">'.do_shortcode($content).'</div>';
}
add_shortcode('wide', 'wide');

/**
 * Add editor stylesheet. Not doing much with it, just to prevent huge images.
 *
 */


function my_theme_add_editor_styles() {
    add_editor_style( 'editor-style.css' );
}
add_action( 'init', 'my_theme_add_editor_styles' );
