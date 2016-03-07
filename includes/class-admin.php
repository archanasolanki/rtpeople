<?php
/*
 * Admin class
 * Creates metaboxes and save data
 * 
 * @author Archana Solanki <archana.solanki@rtcamp.com>
 */

namespace rtCamp\WP\rtPeople;

if ( !class_exists( 'Admin' ) ) {

	class Admin {
		/*
		 * Intializes action hooks
		 */

		public function init() {
			//add meta boxes for address, contact and timing info
			add_action( 'add_meta_boxes', array( $this, 'add_metaboxes' ) );

			// save data of metaboxes
			add_action( 'save_post', array( $this, 'save_metabox_data' ) );
		}

		/*
		 * add metabox for inserting and editing meta data
		 */

		function add_metaboxes() {
			add_meta_box( 'rtpeople-meta-box-id', 'Other Information', array( $this, 'cd_meta_box_cb' ), 'people', 'normal', 'high' );
		}

		/*
		 * function to add text field in the metabox
		 */

		function cd_meta_box_cb() {
			// $post is already set, and contains an object: the WordPress post
			global $post;
			$values = get_post_custom( $post->ID );
			$location = isset( $values['location'] ) ? $values['location'] : '';
			$website = isset( $values['website'] ) ? $values['website'] : '';
			$availability = isset( $values['availability'] ) ? esc_attr( $values['availability'] ) : '';

			// We'll use this nonce field later on when saving.
			wp_nonce_field( 'rtpeople_meta_box_nonce', 'meta_box_nonce' );
			?>
			<p>
				<label for="location">Location</label>
				<input type="text" name="location" id="location" value="<?php echo get_post_meta( $post->ID, 'location', true ); ?>" />
			</p>
			<p>
				<label for="website">Website</label>
				<input type="text" name="website" id="website" value="<?php echo get_post_meta( $post->ID, 'website', true ); ?>" />
			</P>

			<p>
			        <input type="checkbox" id="availability" name="availability" <?php checked( $check, 'yes' ); ?> />
			        <label for="availability">Yes</label>
			</p>

			<?php
		}

		/*
		 * save meta data for people
		 */

		function save_metabox_data() {
			global $post;
			$post_id = $post->ID;

			$slug = "people";
			if ( $slug != $post->post_type )
				return $post_id;

			$location = "";
			$website = "";
			$availability = "";

			if ( isset( $_POST["location"] ) ) {
				$location = $_POST["location"];
			}
			update_post_meta( $post_id, "location", $location );

			if ( isset( $_POST["availability"] ) ) {
				$availability = $_POST["availability"];
			}
			update_option( 'availability', $availability );

			if ( isset( $_POST["website"] ) ) {
				$website = $_POST["website"];
			}
			update_post_meta( $post_id, "website", $website );
		}

	}

}

