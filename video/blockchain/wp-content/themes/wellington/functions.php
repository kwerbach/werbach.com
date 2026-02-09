<?php
/**
 * Wellington functions and definitions
 *
 * @package Wellington
 */

/**
 * Wellington only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}


if ( ! function_exists( 'wellington_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wellington_setup() {

		// Make theme available for translation. Translations can be filed in the /languages/ directory.
		load_theme_textdomain( 'wellington', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Set detfault Post Thumbnail size.
		set_post_thumbnail_size( 880, 660, true );

		// Register Navigation Menu.
		register_nav_menu( 'primary', esc_html__( 'Main Navigation', 'wellington' ) );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'wellington_custom_background_args', array( 'default-color' => 'e5e5e5' ) ) );

		// Set up the WordPress core custom logo feature.
		add_theme_support( 'custom-logo', apply_filters( 'wellington_custom_logo_args', array(
			'height'      => 60,
			'width'       => 300,
			'flex-height' => true,
			'flex-width'  => true,
		) ) );

		// Set up the WordPress core custom header feature.
		add_theme_support( 'custom-header', apply_filters( 'wellington_custom_header_args', array(
			'header-text' => false,
			'width'       => 1280,
			'height'      => 400,
			'flex-height' => true,
		) ) );

		// Add Theme Support for wooCommerce.
		add_theme_support( 'woocommerce' );

		// Add extra theme styling to the visual editor.
		add_editor_style( array( 'assets/css/editor-style.css', get_template_directory_uri() . '/assets/css/custom-fonts.css' ) );

		// Add Theme Support for Selective Refresh in Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add custom color palette for Gutenberg.
		add_theme_support( 'editor-color-palette', array(
			array(
				'name'  => esc_html_x( 'Primary', 'Gutenberg Color Palette', 'wellington' ),
				'slug'  => 'primary',
				'color' => apply_filters( 'wellington_primary_color', '#ee3333' ),
			),
			array(
				'name'  => esc_html_x( 'White', 'Gutenberg Color Palette', 'wellington' ),
				'slug'  => 'white',
				'color' => '#ffffff',
			),
			array(
				'name'  => esc_html_x( 'Light Gray', 'Gutenberg Color Palette', 'wellington' ),
				'slug'  => 'light-gray',
				'color' => '#f0f0f0',
			),
			array(
				'name'  => esc_html_x( 'Dark Gray', 'Gutenberg Color Palette', 'wellington' ),
				'slug'  => 'dark-gray',
				'color' => '#777777',
			),
			array(
				'name'  => esc_html_x( 'Black', 'Gutenberg Color Palette', 'wellington' ),
				'slug'  => 'black',
				'color' => '#303030',
			),
		) );

		// Add support for responsive embed blocks.
		add_theme_support( 'responsive-embeds' );
	}
endif;
add_action( 'after_setup_theme', 'wellington_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wellington_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wellington_content_width', 810 );
}
add_action( 'after_setup_theme', 'wellington_content_width', 0 );


/**
 * Register widget areas and custom widgets.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function wellington_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wellington' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Appears on posts and pages except the full width template.', 'wellington' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="widget-header"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Header', 'wellington' ),
		'id'            => 'header',
		'description'   => esc_html__( 'Appears on header area. You can use a search or ad widget here.', 'wellington' ),
		'before_widget' => '<aside id="%1$s" class="header-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="header-widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Magazine Homepage', 'wellington' ),
		'id'            => 'magazine-homepage',
		'description'   => esc_html__( 'Appears on blog index and Magazine Homepage template. You can use the Magazine widgets here.', 'wellington' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-header"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

}
add_action( 'widgets_init', 'wellington_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function wellington_scripts() {

	// Get Theme Version.
	$theme_version = wp_get_theme()->get( 'Version' );

	// Register and Enqueue Stylesheet.
	wp_enqueue_style( 'wellington-stylesheet', get_stylesheet_uri(), array(), $theme_version );

	// Register Genericons.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/assets/genericons/genericons.css', array(), '3.4.1' );

	// Register and Enqueue HTML5shiv to support HTML5 elements in older IE versions.
	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/assets/js/html5shiv.min.js', array(), '3.7.3' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	// Register and enqueue navigation.js.
	wp_enqueue_script( 'wellington-jquery-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array( 'jquery' ), '20160719' );

	// Passing Parameters to navigation.js.
	wp_localize_script( 'wellington-jquery-navigation', 'wellington_menu_title', esc_html__( 'Navigation', 'wellington' ) );

	// Register Comment Reply Script for Threaded Comments.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wellington_scripts' );


/**
 * Enqueue custom fonts.
 */
function wellington_custom_fonts() {
	wp_enqueue_style( 'wellington-custom-fonts', get_template_directory_uri() . '/assets/css/custom-fonts.css', array(), '20180413' );
}
add_action( 'wp_enqueue_scripts', 'wellington_custom_fonts', 1 );
add_action( 'enqueue_block_editor_assets', 'wellington_custom_fonts', 1 );


/**
 * Enqueue editor styles for the new Gutenberg Editor.
 */
function wellington_block_editor_assets() {
	wp_enqueue_style( 'wellington-editor-styles', get_theme_file_uri( '/assets/css/gutenberg-styles.css' ), array(), '20181102', 'all' );
}
add_action( 'enqueue_block_editor_assets', 'wellington_block_editor_assets' );


/**
 * Add custom sizes for featured images
 */
function wellington_add_image_sizes() {

	// Add Slider Image Size.
	add_image_size( 'wellington-slider-image', 1280, 450, true );

	// Add different thumbnail sizes for Magazine Posts widgets.
	add_image_size( 'wellington-thumbnail-small', 120, 80, true );
	add_image_size( 'wellington-thumbnail-medium', 360, 230, true );
	add_image_size( 'wellington-thumbnail-large', 600, 380, true );

}
add_action( 'after_setup_theme', 'wellington_add_image_sizes' );


/**
 * Make custom image sizes available in Gutenberg.
 */
function wellington_add_image_size_names( $sizes ) {
	return array_merge( $sizes, array(
		'post-thumbnail'             => esc_html__( 'Wellington Single Post', 'wellington' ),
		'wellington-thumbnail-large' => esc_html__( 'Wellington Magazine Post', 'wellington' ),
		'wellington-thumbnail-small' => esc_html__( 'Wellington Thumbnail', 'wellington' ),
	) );
}
add_filter( 'image_size_names_choose', 'wellington_add_image_size_names' );


/**
 * Include Files
 */

// Include Theme Info page.
require get_template_directory() . '/inc/theme-info.php';

// Include Theme Customizer Options.
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/customizer/default-options.php';

// Include Extra Functions.
require get_template_directory() . '/inc/extras.php';

// Include Template Functions.
require get_template_directory() . '/inc/template-tags.php';

// Include support functions for Theme Addons.
require get_template_directory() . '/inc/addons.php';

// Include Post Slider Setup.
require get_template_directory() . '/inc/slider.php';

// Include Magazine Functions.
require get_template_directory() . '/inc/magazine.php';

// Include Widget Files.
require get_template_directory() . '/inc/widgets/widget-magazine-posts-columns.php';
require get_template_directory() . '/inc/widgets/widget-magazine-posts-grid.php';
