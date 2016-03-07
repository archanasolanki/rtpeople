<?php

/*
 * Load class
 * creates initial post type and texonomies
 * instaltiates
 * @author Archana Solanki <archana.solanki@rtcamp.com>
 */

namespace rtCamp\WP\rtPeople;

if ( !class_exists( 'Load' ) ) {

	class Load {

		/**
		 * instantiates admin, theme classes and action hooks
		 *
		 */
		public function init() {

			//instantiates class array
			$this->instantiate();

			//registers post type on init hook
			add_action( 'init', array( $this, 'register_post_type' ) );
			//register taxonomy on init hook
			add_action( 'init', array( $this, 'register_taxonomy' ) );

			//activate plugin hook
			register_activation_hook( RTPEOPLE_PATH . 'rt-people.php', array( $this, 'rt_people_flush_rewrites' ) );
		}

		/**
		 * instantiates classes
		 */
		function instantiate() {

			$class_names = array( 'theme', 'admin' );

			foreach ( $class_names as $class ) {

				//Capitalizes first letter of the class name
				$class_uc = ucfirst( $class );

				$class_name = '\\rtCamp\WP\rtPeople\\' . $class_uc;
				//similar to $class = new $Class();
				${$class} = new $class_name();

				//calls init() method of class $class
				${$class}->init();
			}
		}

		/*
		 * Creates custom post type, default post type 'people'
		 *
		 * Creates custom post type with necessary custom fields to represent an entity
		 * labels to show in UI, associated taxonomies and more.
		 *
		 * @param function register_post_type( $post_type, array() ) function call to register post type
		 */

		public function register_post_type() {

			//Labels for the elements of UI
			$label = array(
			    'name' => _x( 'People', 'post type general name', 'rtpeople' ),
			    'singular_name' => _x( 'Person', 'post type singular name', 'rtpeople' ),
			    'menu_name' => _x( 'People', 'admin menu', 'rtpeople' ),
			    'name_admin_bar' => _x( 'Person', 'add new on admin bar', 'rtpeople' ),
			    'add_new' => _x( 'Add New', 'Person', 'rtpeople' ),
			    'add_new_item' => __( 'Add New Person', 'rtpeople' ),
			    'new_item' => __( 'New Person', 'rtpeople' ),
			    'edit_item' => __( 'Edit Person', 'rtpeople' ),
			    'view_item' => __( 'View Person', 'rtpeople' ),
			    'all_items' => __( 'All People', 'rtpeople' ),
			    'search_items' => __( 'Search People', 'rtpeople' ),
			    'not_found' => __( 'No developer found.', 'rtpeople' ),
			    'not_found_in_trash' => __( 'No developer found in Trash.', 'rtpeople' )
			);

			//A String or array of strings of post types to create
			$post_type = 'people';

			// Taxonomies array
			$taxonomy_array = array( 'developer_category', 'skill_set' );

			//Array of arguments for custom post type
			$custom_post_type_arg = array(
			    $post_type => array(
				'public' => true,
				'taxonomies' => $taxonomy_array,
				'label' => 'Restaurants',
				'labels' => $label,
				'hierarchical' => false,
				'public' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'show_in_nav_menus' => true,
				'show_in_admin_bar' => true,
				'menu_position' => 5,
				'can_export' => true,
				'has_archive' => true,
				'exclude_from_search' => false,
				'publicly_queryable' => true,
				'capability_type' => 'page',
				'supports' => array( 'title', 'editor', 'trackbacks', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
			    )
			);
			/**
			 * Filter rt_create_post_type settings.
			 *
			 * @param string|array  $post_type  Array or String of post type.
			 * @param string $custom_post_type_arg Array for the argument related to custom post type.
			 */
			$custom_post_type_arg = apply_filters( 'rt_create_custom_post_type_args', $custom_post_type_arg );

			foreach ( $custom_post_type_arg as $key => $value ) {
				register_post_type( $key, $value );
			}
		}

		/**
		 * registers custom taxonomies
		 *
		 * Taxonomies with necessary parameters associated with
		 * custom post type
		 *
		 * @see register_taxonomy()
		 *
		 */
		function register_taxonomy() {

			//Array of taxonomy terms
			$taxonomies = array(
			    'developer_category' => array(
				'post_type' => 'people',
				array(
				    'show_ui' => true,
				    'show_admin_column' => true,
				    'label' => 'Developer Category',
				)
			    ),
			    'skill_set' => array(
				'post_type' => 'people',
				array(
				    'show_ui' => true,
				    'show_admin_column' => true,
				    'label' => 'Skills',
				)
			    ),
			    'taxonomies' => 'category'
			);

			/**
			 * Filter the register_taxonomy settings
			 *
			 * @see register_taxonomy()
			 *
			 * @param string $taxonomies Array of arguments to register
			 */
			$taxonomies = apply_filters( 'rt_custom_taxonomy_post_type_args', $taxonomies );

			foreach ( $taxonomies as $taxonomy => $label ) {

				register_taxonomy( $taxonomy, $label['post_type'], $label[0] );
			}
		}

		/**
		 * To flush the rewrite rules.
		 */
		function rt_people_flush_rewrites() {

			flush_rewrite_rules();
		}

	}

}