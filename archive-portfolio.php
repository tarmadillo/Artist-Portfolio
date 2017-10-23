<?php
/**
 * Portfolio Archive.
 *
 * This template overrides the default archive template
 *
 * @package      
 * @link         
 * @author       
 * @copyright    
 * @license      GPL-2.0+
 */
namespace TonyArmadillo\Portfolio;

/**
 * Add portfolio body class.
 *
 * @param array $classes Default body classes.
 * @return array $classes Default body classes.
 */
function portfolio_body_class( $classes ) {
	$classes[] = 'portfolio';
	$classes[] = 'masonry';
	return $classes;
}
add_filter( 'body_class', __NAMESPACE__ . '\portfolio_body_class', 999 );

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

/**
 * Enqueue masonry script.
 *
 * Uses the masonry script from wp-includes/js/masonry.min.js
 */
function portfolio_masonry_scripts() {

	// Enqueue script.
    wp_enqueue_script( 'infinite-scroll', get_stylesheet_directory_uri() . '/js/infinite-scroll.pkgd.min.js', array( 'jquery' ), '1.0.0' );
    wp_enqueue_script( 'isotope', get_stylesheet_directory_uri() . '/js/isotope.pkgd.min.js', array( 'jquery' ), '1.0.0' );
    wp_enqueue_script( 'infinite-scroll-init', get_stylesheet_directory_uri() . '/js/infinite-scroll-init.js', array( 'jquery' ), '1.0.0' );

	
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\portfolio_masonry_scripts' );

function portfolio_featured_image() {

            // Check display featured image option.
            $genesis_settings = get_option( 'genesis-settings' );

            if ( 1 === $genesis_settings['content_archive_thumbnail'] ) {
                function featured_image_size() {
                    $image = genesis_get_image( array(
                        'size'  => 'medium-cropped',
                    ) );
                    
                    if ( $image ) {
                        printf( '<a href="%s" rel="bookmark">%s</a>', get_permalink(), $image );
                    }
                }
                // Display featured image.
                add_action( 'genesis_entry_header', __NAMESPACE__ . '\featured_image_size', 1 );
            }
        }
add_action( 'genesis_before', __NAMESPACE__ . '\portfolio_featured_image' );
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_post_content', 'genesis_do_post_image' );

// Remove the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

// Remove the post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

// Remove the post meta function
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Remove the entry footer markup
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

// Add our custom loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', __NAMESPACE__ . '\portfolio_masonry_loop' );
/**
 * Custom loop for masonry grid.
 *
 * @since 1.0
 */

function portfolio_masonry_loop() {

	$paged   = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

	// Easter Egg.
	$query_args = wp_parse_args(
		genesis_get_custom_field( 'query_args' ),
		array(
			'post_type'        => 'portfolio',
			'showposts'        => genesis_get_option( 'blog_cat_num' ),
			'paged'            => $paged,
		)
	);
	genesis_custom_loop( $query_args );
}

//* Add Sorting Buttons
add_action( 'genesis_before_content', __NAMESPACE__ . '\sorting_buttons');
function sorting_buttons() {
    ?>
    <div class="button-group js-radio-button-group">
        <a class="sort" href="#" data-filter=".portfolio">All</a>
         <?php 
             $terms = get_tags(); // get all categories, but you can use any taxonomy
             $count = count($terms); //How many are they?
             if ( $count > 0 ){  //If there are more than 0 terms
                 foreach ( $terms as $term ) {  //for each term:
                    echo "<a class='sort' href='#' data-filter='.tag-".$term->slug."'>" . $term->name . "</a>\n";
                    //create a list item with the current term slug for sorting, and name for label
                 }
             } 
         ?>
    </div>
    <?php
}

//* Add View More Button
add_action( 'genesis_after_content', __NAMESPACE__ . '\view_more_button');
function view_more_button() {
    ?>
        <div class="page-load-status">
            <p class="infinite-scroll-last">No more pages to load</p>
            <p class="infinite-scroll-error">Error Loading Pages</p>
        </div>
        <div class="text-center">
            <button class="view-more-button">View more</button>
        </div>
        
    <?php
}



// Run genesis.
genesis();
