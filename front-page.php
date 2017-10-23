<?php
/**
 * Developer's Lite.
 *
 * This file adds the front page to the Developers Theme.
 *
 * @package Developers
 * @author  Tony Armaidllo
 * @license GPL-2.0+
 * @link    
 */
namespace TonyArmadillo\Portfolio;

// Remove Header Image
remove_action( 'genesis_after_header', __NAMESPACE__ . '\hero', 99 );

// Remove Masonry Loop
remove_action('genesis_meta', __NAMESPACE__ . '\masonry_layout');

// Remove title
remove_action( 'genesis_after_header', 'genesis_do_post_title' );

add_action( 'genesis_meta', __NAMESPACE__ . '\front_page_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 * @since 1.0.0
 */
function front_page_genesis_meta() {

    // Add front-page body class.
    add_filter( 'body_class', __NAMESPACE__ . '\body_class' );

    // Force full width content layout.
    add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

    // Remove breadcrumbs.
    remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
        
    // Remove the default Genesis loop.
    remove_action( 'genesis_loop', 'genesis_do_loop' );
        
    add_action( 'genesis_loop', __NAMESPACE__ . '\be_custom_loop');
    
    if ( is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) || is_active_sidebar( 'front-page-5' ) || is_active_sidebar( 'front-page-6' ) || is_active_sidebar( 'front-page-7' ) ) {
        // Add homepage widgets after grid.
        add_action( 'genesis_after_loop', __NAMESPACE__ . '\widgets_after_loop' );
    }
    
}

// Define front-page body class.
function body_class( $classes ) {

	$classes[] = 'front-page';

	return $classes;

}

function be_custom_loop() {
	global $post;
	// arguments, adjust as needed
	$args = array(
		'post_type'      => 'portfolio',
		'posts_per_page' => 12,
		'post_status'    => 'publish',
        'category_name'  => 'front-page',
		'paged'          => get_query_var( 'paged' )
	);
	
	global $wp_query;
	$wp_query = new \WP_Query( $args );
	if ( have_posts() ) : ?>

        <div class="wow grid">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="entry-page-image">
                        <a class="item-overlay" rel="lightbox" href="<?php the_post_thumbnail_url(); ?>"></a>
                        <?php the_post_thumbnail( 'medium-large' ); ?>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
    
        </div> <!-- #content -->
    <?php endif; ?>
    <?php
}

function widgets_after_loop () {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', CHILD_TEXT_DOMAIN ) . '</h2>';

	genesis_widget_area( 'front-page-2', array(
		'before' => '<div id="front-page-2" class="front-page-2 wow" tabindex="-1"><div class="widget-area"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );
    
    genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3 wow" tabindex="-1"><div class="widget-area"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );
}


// Run the Genesis loop.
genesis();