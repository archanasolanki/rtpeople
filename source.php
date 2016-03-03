<?php
/*
Plugin Name: rtPeople
Plugin URI: 
Author: rtCamp
Author URI: https://rtcamp.com/
Version: 1.0
Description: 
*/

/*
 * Initial Actions
*/

register_activation_hook( __FILE__, 'rtpeople_install' );
register_deactivation_hook( __FILE__, 'rtpeople_deactivation' );

/*
 * Register Custom Post type
 */
function rtpeople_setup_post_type() {
 
    // Register our "person" custom post type
    
    // Setting up labels
    $labels = array(
		'name'               => _x( 'People', 'post type general name', 'rtpeople' ),
		'singular_name'      => _x( 'Person', 'post type singular name', 'rtpeople' ),
		'menu_name'          => _x( 'People', 'admin menu', 'rtpeople' ),
		'name_admin_bar'     => _x( 'Person', 'add new on admin bar', 'rtpeople' ),
		'add_new'            => _x( 'Add New', 'Person', 'rtpeople' ),
		'add_new_item'       => __( 'Add New Person', 'rtpeople' ),
		'new_item'           => __( 'New Person', 'rtpeople' ),
		'edit_item'          => __( 'Edit Person', 'rtpeople' ),
		'view_item'          => __( 'View Person', 'rtpeople' ),
		'all_items'          => __( 'All People', 'rtpeople' ),
		'search_items'       => __( 'Search People', 'rtpeople' ),
		'not_found'          => __( 'No books found.', 'rtpeople' ),
		'not_found_in_trash' => __( 'No books found in Trash.', 'rtpeople' )
	);

    // Taxonomies array
    $taxonomy_array = array( 'category', 'post_tag' );
    
    // default arguments
    $args = array(
		'labels'             => $labels,
                'description'        => __( 'Description.', 'rtpeople' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'person' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'supports'           => array( 'title', 'editor', 'trackbacks', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
                'taxonomies'         => $taxonomy_array
	);

    register_post_type( 'person', $args );
 
}
add_action( 'init', 'rtpeople_setup_post_type' );
 
function rtpeople_install() {
 
    // Trigger our function that registers the custom post type
    rtpeople_setup_post_type();
 
    // Clear the permalinks after the post type has been registered
    flush_rewrite_rules();
 
}

/*
 * Deactivation function
 */

function rtpeople_deactivation() {
    
     // Clear the permalinks to remove our post type's rules
    flush_rewrite_rules();
}
?>
