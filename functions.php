<?php
/**
 * Genesis Sample 2.3.0 Developer.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample 2.3.0 Developer
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */
namespace TonyArmadillo\Portfolio;

/**
 * Initialize the theme's constants.
 *
 * @since 2.3.0
 *
 * @return void
 */
function init_constants() {
	$child_theme = wp_get_theme();
	define( 'CHILD_THEME_NAME', $child_theme->get( 'Name' ) );
	define( 'CHILD_THEME_URL', $child_theme->get( 'ThemeURI' ) );
	define( 'CHILD_THEME_VERSION', $child_theme->get( 'Version' ) );
	define( 'CHILD_TEXT_DOMAIN', $child_theme->get( 'TextDomain' ) );
	define( 'CHILD_THEME_DIR', get_stylesheet_directory() );
	define( 'CHILD_CONFIG_DIR', CHILD_THEME_DIR . '/config/' );
}
init_constants();


// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( CHILD_THEME_DIR . '/lib/theme-defaults.php' );

add_action( 'after_setup_theme', __NAMESPACE__ . '\localization_setup' );
/**
 * Set Localization (do not remove).
 *
 * @since 2.3.0
 *
 * @return void
 */
function localization_setup(){
	load_child_theme_textdomain( CHILD_TEXT_DOMAIN, get_stylesheet_directory() . '/languages' );
}

// Includes
include_once( CHILD_THEME_DIR . '/lib/helper-functions.php' );
include_once( CHILD_THEME_DIR . '/lib/masonry.php' );
include_once( CHILD_THEME_DIR . '/lib/hero.php' );
require_once( CHILD_THEME_DIR . '/lib/customize.php' );
include_once( CHILD_THEME_DIR . '/lib/output.php' );
include_once( CHILD_THEME_DIR . '/lib/woocommerce/woocommerce-setup.php' );
include_once( CHILD_THEME_DIR . '/lib/woocommerce/woocommerce-output.php' );
include_once( CHILD_THEME_DIR . '/lib/woocommerce/woocommerce-notice.php' );

/** Remove jQuery and jQuery-ui scripts loading from header */
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\script_remove_header');
/**
 * Remove jquery from head
 *
 * @since 1.0.0
 *
 * @return void
 */
function script_remove_header() {
      wp_deregister_script( 'jquery' );
}

add_action( 'genesis_after_footer', __NAMESPACE__ . '\enqueue_styles_scripts' );
/**
 * Enqueue Scripts.
 *
 * @since 1.0.0
 *
 * @return void
 */
function enqueue_styles_scripts() {
    wp_enqueue_style( CHILD_TEXT_DOMAIN . '-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700|Kaushan+Script|Roboto', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( CHILD_TEXT_DOMAIN . '-fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0' );
	wp_enqueue_style( 'dashicons' );
    
    wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
    wp_enqueue_script( 'jquery' );
    
    wp_enqueue_script( 'magnific', get_stylesheet_directory_uri() . '/js/magnific-popup.min.js', array( 'jquery' ), '1.0.0' );
    wp_enqueue_script( 'wow', get_stylesheet_directory_uri() . "/js/wow.min.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
    wp_enqueue_script( 'global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery' ), '1.0.0' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( CHILD_TEXT_DOMAIN . '-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		CHILD_TEXT_DOMAIN . '-responsive-menu',
		'genesis_responsive_menu',
		genesis_sample_responsive_menu_settings()
	);

}

/**
 * Define our responsive menu settings.
 *
 * @since 1.0.0
 *
 * @return void
 */
function genesis_sample_responsive_menu_settings() {

	$settings = array(
		'mainMenu'          => __( 'Menu', CHILD_TEXT_DOMAIN ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', CHILD_TEXT_DOMAIN ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Enable Logo option in Customizer > Site Identity.
add_theme_support( 'custom-logo', array(
	'height'      => 60,
	'width'       => 200,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( '.site-title', '.site-description' ),
) );

// Display custom logo.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'header-selector'  => '.hero',
	'header_image'     => get_stylesheet_directory_uri() . '/images/hero.jpg',
	'header-text'      => false,
	'width'            => 1920,
	'height'           => 1080,
	'flex-height'      => true,
	'flex-width'       => true,
	'video'            => true,
	'wp-head-callback' => __NAMESPACE__ . '\custom_header',
) );

// Register default custom header image.
register_default_headers( array(
	'child' => array(
		'url'           => '%2$s/images/hero.jpg',
		'thumbnail_url' => '%2$s/images/hero.jpg',
		'description'   => __( 'Hero Image', CHILD_TEXT_DOMAIN ),
	),
) );

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 
    'primary'   => __( 'After Header Menu', CHILD_TEXT_DOMAIN ), 
    'secondary' => __( 'Footer Menu', CHILD_TEXT_DOMAIN ) ) );

// Add Image Sizes.
add_image_size( 'featured-image', 720, 400, true );
add_image_size( 'medium-cropped', 480, 480, true );
add_image_size( 'medium-large', 720, 720, false );

add_filter( 'image_size_names_choose', __NAMESPACE__ . '\new_image_sizes' );
function new_image_sizes( $sizes ) {

    $addsizes = array(
        "medium-cropped" => 'Medium Cropped',
        "medium-large" => 'Medium Large'
    );

    $newsizes = array_merge( $sizes, $addsizes );

    return $newsizes;

}

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

add_filter( 'wp_nav_menu_args', __NAMESPACE__ . '\secondary_menu_args' );
/**
 * Reduce the secondary navigation menu to one level depth.
 *
 * @since 1.0.0
 *
 * @return void
 */
function secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', __NAMESPACE__ . '\author_box_gravatar' );
/**
 * Modify size of the Gravatar in the author box.
 *
 * @since 1.0
 *
 * @return void
 */
function author_box_gravatar( $size ) {
	return 90;
}

add_filter( 'genesis_comment_list_args', __NAMESPACE__ . '\comments_gravatar' );
/**
 * Modify size of the Gravatar in the entry comments.
 *
 * @since 1.0
 *
 * @return void
 */
function comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}

/* Register shortcode_atts_gallery filter callback */
add_filter( 'shortcode_atts_gallery', __NAMESPACE__ . '\gallery_atts', 10, 3 );
 /**
 * Modify size of the Gallery Images.
 *
 * @since 1.0
 *
 * @return void
 */
/* Change attributes of wp gallery to modify image sizes for your needs */
function gallery_atts( $output, $pairs, $atts ) {
 
	/* You can use these sizes:
		- thumbnail
		- medium
		- large
		- full
	or, if your theme/plugin generate additional custom sizes you can use them as well
	*/
        
	if ( $atts['columns'] == 1 ) {
	    //if gallery has one column, use large size
	    $output['size'] = 'medium-large';
	} else if ( $atts['columns'] >= 2 && $atts['columns'] <= 5 ) {
	    //if gallery has between two and four columns, use medium size
	    $output['size'] = 'medium-cropped';
	} else {
	    //if gallery has more than four columns, use thumbnail size
	    $output['size'] = 'thumbnail';
	}
 
	return $output;
 
}

// Remove unused templates and metaboxes.
add_filter( 'theme_page_templates', __NAMESPACE__ . '\remove_templates' );
add_action( 'genesis_admin_before_metaboxes', __NAMESPACE__ . '\remove_metaboxes' );


// Register Front Page Widget Areas.
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Before Grid', CHILD_TEXT_DOMAIN ),
	'description' => __( 'This is the front page 1 section.', CHILD_TEXT_DOMAIN ),
) );

genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'After Grid 1', CHILD_TEXT_DOMAIN ),
	'description' => __( 'This is the front page 2 section.', CHILD_TEXT_DOMAIN ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'After Grid 2', CHILD_TEXT_DOMAIN ),
	'description' => __( 'This is the front page 3 section.', CHILD_TEXT_DOMAIN ),
) );

// Register before footer widget
genesis_register_sidebar( array(
	'id'          => 'before-footer',
	'name'        => __( 'Before Footer', CHILD_TEXT_DOMAIN ),
	'description' => __( 'This is the social media section.', CHILD_TEXT_DOMAIN ),
) );

//* Hook before header widget area before site header
add_action( 'genesis_before_footer', __NAMESPACE__ . '\before_footer_widget_area' );
function before_footer_widget_area() {
	genesis_widget_area( 'before-footer', array(
		'before' => '<div class="before-footer widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );
}

