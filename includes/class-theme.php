<?php

/*
 * Class theme
 * Loads necessary templates 
 * and scripts
 */
namespace rtCamp\WP\rtPeople;
if ( !class_exists( 'Theme' ) ) {

	class Theme {
		/*
		 * Initiates action hooks
		 */

		public function init() {
			//Template directory uri
			$template_uri = RTPEOPLE_URL;
			
			//filter to include custom templates
			add_filter( 'template_include', array( $this, 'load_template' ) );
			add_filter( 'template_include', array( $this, 'load_archive_template' ) );
			
			//loads necessary css files for restaurants and slick slider
			add_action( 'wp_enqueue_style', 'rtpeople_style', 1 );
			wp_enqueue_style( 'rtpeople_style', $template_uri . 'assets/css/style.css' );

			//loads custom content template
			add_action( 'get_template_part_templates/content', array( $this, 'load_content' ) );
		}

		/**
		 * Chooses template to load 
		 * 
		 * @param string $template
		 * @return string
		 */
		function choose_template( $template ) {
			//stores $template as array of strings separated by '/'
			$path_array = explode( '/', $template );
			//reverses the array
			$path_array = array_reverse( $path_array );

			//path to the plugin directory
			$path_to_template = \rtCamp\WP\rtPeople\RTPEOPLE_PATH;

			if ( !empty( $path_array ) ) {

				switch ( $path_array[0] ) {
					//if the template requested is archive.php
					case 'archive.php':
						//path to the cutom archive template
						$path_to_template .= 'templates/archive-people.php';
						$template = $path_to_template;
						break;
					//if the template requested is single.php
					case 'single.php':
						//path to the custom single template
						$path_to_template .= 'templates/single-people.php';
						$template = $path_to_template;
						break;

					default:
						break;
				}
			}
			//before finalising the template
			do_action( 'rt_before_template_chosen', $template );

			return $template;
		}

		/**
		 * Loads custome single-people template if no custom template used
		 * 
		 * @param string $template Path to the chosen template
		 */
		public function load_template( $template ) {

			if ( is_singular( 'people' ) ) {
				return $this->choose_template( $template );
			}
			return $template;
		}

		/**
		 * Loads custome content-people template if no custom template used
		 * 
		 */
		public function load_content() {
			$template = \rtCamp\WP\rtPeople\RTPEOPLE_PATH . 'templates/content-people.php';

			//filters template to load for content
			$template = apply_filters( 'rt_load_content_template', $template );
			$location = locate_template( 'template-parts/content-people.php', true );
			if ( '' === $location ) {
				load_template( $template );
			}
		}

		/**
		 * Loads custome archive-people template if no custom template used
		 * 
		 * @param string $template Path to the chosen template
		 */
		public function load_archive_template( $template ) {

			if ( is_post_type_archive( 'people' ) ) {
				return $this->choose_template( $template );
			}
			return $template;
		}

	}

}

