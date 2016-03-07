<?php

/* 
 * Admin class
 * Creates metaboxes and save data
 * 
 * @author Archana Solanki <archana.solanki@rtcamp.com>
 */
namespace rtCamp\WP\rtPeople;
if( !class_exists( 'Admin' )) {
	class Admin {
		/*
		 * Intializes action hooks
		 */
		
		public function init() {
			//add meta boxes for address, contact and timing info
			add_action( 'add_meta_boxes', array( $this, 'add_metaboxes' ) );
			
			// save data of metaboxes
			add_action( 'save_post', '' );
		}
	}
}

