<?php

class wpadt_adtsaveAnimationWA {

	function __construct() {
		add_action( 'save_post', array( $this, 'wpadt_save' ) );
	}

	function wpadt_save( $post_id ){
	global $post;
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['adt_custom_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['adt_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'adt_custom_box' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'wp_adtentions' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */	
		
		if(isset($_POST["wa"]) && !empty($_POST["wa"])) {
		$wa = $_POST["wa"];	
		$waarray = array();
			foreach($wa as $key => $value) {
				if(is_array($value)) {
					foreach($value as $k => $v) {
						$waarray[sanitize_text_field($key)][sanitize_text_field($k)] = sanitize_text_field($v);
					}
				} else {
					$waarray[sanitize_text_field($key)] = sanitize_text_field($value);
				}
			}
			update_post_meta($post_id, "adt_show_wholeadanimation", $waarray);		
		} else {
			delete_post_meta($post_id, "adt_show_wholeadanimation");
		}
	
	}

}
new wpadt_adtsaveAnimationWA();
?>