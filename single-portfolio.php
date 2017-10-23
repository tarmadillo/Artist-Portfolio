<?php
/**
 * Adds Portfolio Archive template.
 *
 * This template overrides the default archive template to clean
 * up the output.
 *
 * @package      
 * @link         
 * @author       
 * @copyright    
 * @license      GPL-2.0+
 */
namespace TonyArmadillo\Portfolio;

add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Remove the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );


genesis();