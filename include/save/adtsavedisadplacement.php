<?php

class wpadt_adtSaveDisAPMainArea {

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
		
		if(isset($_POST["adtdap"]) && !empty($_POST["adtdap"])) {			
		$adtdap = $_POST["adtdap"];	
		$adtdaparray = array();
			foreach($adtdap as $key => $value) {
				if(is_array($value)) {
					foreach($value as $k => $v) {
						$adtdaparray[sanitize_text_field($key)][sanitize_text_field($k)] = sanitize_text_field($v);
					}
				} else {
					$adtdaparray[sanitize_text_field($key)] = sanitize_text_field($value);
				}
			}
			update_post_meta($post_id, "adt_display_adplacement", $adtdaparray);		
		} else {
			delete_post_meta($post_id, "adt_display_adplacement");
		}
		
// START WP_FILESYSTEM
	$access_type = get_filesystem_method();
	if($access_type === 'direct') {
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		$creds = request_filesystem_credentials($url, '', false, false, array());
			
			/* initialize the API */
			if ( ! WP_Filesystem($creds) ) {
				/* any problems and we exit */
				return false;
			} 
			global $wp_filesystem;
			$cssEditor = new wpadt_CssEditor();

			if(isset($_POST['adtdap'])) {
				$adtdap = sanitize_text_field($_POST['adtdap']);
				$adt_selector = array(".adtplacement");
				$adt_cssf = array_filter($adtdap);
					if(is_array($adt_cssf)) {
					$adt_file = plugin_dir_path(__FILE__) . '/../../css/front/default/placement.css';

					if(!$wp_filesystem->is_dir(plugin_dir_path(__FILE__) . '/../../css/front/custom/')) 
					{
						$wp_filesystem->mkdir(plugin_dir_path(__FILE__) . '/../../css/front/custom/');
					}
					
					$adt_path = plugin_dir_path(__FILE__) . '/../../css/front/custom/placement' . $post_id . '.css';
					
					$adt_content = $wp_filesystem->get_contents($adt_file);
					
					/*THE CSS PROPERTIES*/
					$adt_css = $adt_selector[0] . "{\n";
						if($adtdap['adtwpostype'] == "adtwpostypepred"){
							if(isset($adtdap['adtwpospred']) && $adtdap['adtwpospred'] != "" ) { 
								if($adtdap['adtwpospred'] == "top_left") {
	if(isset($adtdap['wmargintop']) && ($adtdap['wmargintop'] != 0) ) { 
		$margin = sanitize_text_field($adtdap['wmargintop']) . "px ";
		$adt_css .= "top: " . $margin . " !important;";
	} else {
		$adt_css .= "top: 0 !important;";
	}
	
	/* if(isset($adtdap['wmarginright']) && ($adtdap['wmarginright'] != 0)) { 
		$margin = $adtdap['wmarginright'] . "px ";
		$adt_css .= "right: " . $margin . " !important;";
	}
	
	if(isset($adtdap['wmarginbottom']) && ($adtdap['wmarginbottom'] != 0)) { 
		$margin = $adtdap['wmarginbottom'] . "px ";
		$adt_css .= "bottom: " . $margin . " !important;";
	} */
	
	if(isset($adtdap['wmarginleft']) && ($adtdap['wmarginleft'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginleft']) . "px";
		$adt_css .= "left: " . $margin . " !important;";
	} else {
		$adt_css .= "left: 0 !important;";
	}								
								$adt_css .= "position:fixed !important; z-index: 2147483642;";
								} elseif ($adtdap['adtwpospred'] == "top_middle") {									
	if(isset($adtdap['wmargintop']) && ($adtdap['wmargintop'] != 0) ) { 
		$margin = sanitize_text_field($adtdap['wmargintop']) . "px ";
		$adt_css .= "top: " . $margin . " !important;";
	} else {
		$adt_css .= "top: 0 !important;";
	}
	
	if(isset($adtdap['wmarginright']) && ($adtdap['wmarginright'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginright']) . "px ";
		$adt_css .= "right: " . $margin . " !important;";
	} else {
		$adt_css .= "right: 0 !important;";
	}
	
	if(isset($adtdap['wmarginbottom']) && ($adtdap['wmarginbottom'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginbottom']) . "px ";
		$adt_css .= "bottom: " . $margin . " !important;";
	} else {
		$adt_css .= "bottom: 0 !important;";
	}
	
	if(isset($adtdap['wmarginleft']) && ($adtdap['wmarginleft'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginleft']) . "px";
		$adt_css .= "left: " . $margin . " !important;";
	} else {
		$adt_css .= "left: 0 !important;";
	}
								$adt_css .= "position:fixed !important; margin: 0 auto !important; z-index: 2147483642;";
								} elseif ($adtdap['adtwpospred'] == "top_right") {									
	if(isset($adtdap['wmargintop']) && ($adtdap['wmargintop'] != 0) ) { 
		$margin = sanitize_text_field($adtdap['wmargintop']) . "px ";
		$adt_css .= "top: " . $margin . " !important;";
	} else {
		$adt_css .= "top: 0 !important;";
	}
	
	if(isset($adtdap['wmarginright']) && ($adtdap['wmarginright'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginright']) . "px ";
		$adt_css .= "right: " . $margin . " !important;";
	} else {
		$adt_css .= "right: 0 !important;";
	}
	
/* 	if(isset($adtdap['wmarginbottom']) && ($adtdap['wmarginbottom'] != 0)) { 
		$margin = $adtdap['wmarginbottom'] . "px ";
		$adt_css .= "bottom: " . $margin . " !important;";
	} 
	
	if(isset($adtdap['wmarginleft']) && ($adtdap['wmarginleft'] != 0)) { 
		$margin = $adtdap['wmarginleft'] . "px";
		$adt_css .= "left: " . $margin . " !important;";
	} */
								$adt_css .= "position:fixed !important; z-index: 2147483642;";
								} elseif ($adtdap['adtwpospred'] == "center_left") {									
	if(isset($adtdap['wmargintop']) && ($adtdap['wmargintop'] != 0) ) { 
		$margin = sanitize_text_field($adtdap['wmargintop']) . "px ";
		$adt_css .= "top: " . $margin . " !important;";
	} else {
		$adt_css .= "top: 0 !important;";
	}
	
	if(isset($adtdap['wmarginright']) && ($adtdap['wmarginright'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginright']) . "px ";
		$adt_css .= "right: " . $margin . " !important;";
	} else {
		$adt_css .= "right: 0 !important;";
	}
	
	if(isset($adtdap['wmarginbottom']) && ($adtdap['wmarginbottom'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginbottom']) . "px ";
		$adt_css .= "bottom: " . $margin . " !important;";
	} else {
		$adt_css .= "bottom: 0 !important;";
	}
	
	if(isset($adtdap['wmarginleft']) && ($adtdap['wmarginleft'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginleft']) . "px";
		$adt_css .= "left: " . $margin . " !important;";
	} else {
		$adt_css .= "left: 0 !important;";
	}
								$adt_css .= "display:block !important; position:fixed !important; margin: auto 0 !important; z-index: 2147483642;";								
								} elseif ($adtdap['adtwpospred'] == "center") {									
	if(isset($adtdap['wmargintop']) && ($adtdap['wmargintop'] != 0) ) { 
		$margin = sanitize_text_field($adtdap['wmargintop']) . "px ";
		$adt_css .= "top: " . $margin . " !important;";
	} else {
		$adt_css .= "top: 0 !important;";
	}
	
	if(isset($adtdap['wmarginright']) && ($adtdap['wmarginright'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginright']) . "px ";
		$adt_css .= "right: " . $margin . " !important;";
	} else {
		$adt_css .= "right: 0 !important;";
	}
	
	if(isset($adtdap['wmarginbottom']) && ($adtdap['wmarginbottom'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginbottom']) . "px ";
		$adt_css .= "bottom: " . $margin . " !important;";
	} else {
		$adt_css .= "bottom: 0 !important;";
	}
	
	if(isset($adtdap['wmarginleft']) && ($adtdap['wmarginleft'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginleft']) . "px";
		$adt_css .= "left: " . $margin . " !important;";
	} else {
		$adt_css .= "left: 0 !important;";
	}
								$adt_css .= "display:block !important; position:fixed !important; margin: auto !important; z-index:2147483642;";	
								} elseif ($adtdap['adtwpospred'] == "center_right") {									
	if(isset($adtdap['wmargintop']) && ($adtdap['wmargintop'] != 0) ) { 
		$margin = sanitize_text_field($adtdap['wmargintop']) . "px ";
		$adt_css .= "top: " . $margin . " !important;";
	} else {
		$adt_css .= "top: 0 !important;";
	}
	
	if(isset($adtdap['wmarginright']) && ($adtdap['wmarginright'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginright']) . "px ";
		$adt_css .= "right: " . $margin . " !important;";
	} else {
		$adt_css .= "right: 0 !important;";
	}
	
	if(isset($adtdap['wmarginbottom']) && ($adtdap['wmarginbottom'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginbottom']) . "px ";
		$adt_css .= "bottom: " . $margin . " !important;";
	} else {
		$adt_css .= "bottom: 0 !important;";
	}
	
/* 	if(isset($adtdap['wmarginleft']) && ($adtdap['wmarginleft'] != 0)) { 
		$margin = $adtdap['wmarginleft'] . "px";
		$adt_css .= "left: " . $margin . " !important;";
	}  */
								$adt_css .= "display:block !important; position:fixed !important; margin: auto 0 !important; z-index:2147483642;";
								} elseif ($adtdap['adtwpospred'] == "bottom_left") {									
/* 	if(isset($adtdap['wmargintop']) && ($adtdap['wmargintop'] != 0) ) { 
		$margin = $adtdap['wmargintop'] . "px ";
		$adt_css .= "top: " . $margin . " !important;";
	} 
	
	if(isset($adtdap['wmarginright']) && ($adtdap['wmarginright'] != 0)) { 
		$margin = $adtdap['wmarginright'] . "px ";
		$adt_css .= "right: " . $margin . " !important;";
	} */
	
	if(isset($adtdap['wmarginbottom']) && ($adtdap['wmarginbottom'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginbottom']) . "px ";
		$adt_css .= "bottom: " . $margin . " !important;";
	} else {
		$adt_css .= "bottom: 0 !important;";
	}
	
	if(isset($adtdap['wmarginleft']) && ($adtdap['wmarginleft'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginleft']) . "px";
		$adt_css .= "left: " . $margin . " !important;";
	} else {
		$adt_css .= "left: 0 !important;";
	}
								$adt_css .= "position:fixed !important; z-index: 2147483642;";								
								} elseif ($adtdap['adtwpospred'] == "bottom_middle") {									
/* 	if(isset($adtdap['wmargintop']) && ($adtdap['wmargintop'] != 0) ) { 
		$margin = $adtdap['wmargintop'] . "px ";
		$adt_css .= "top: " . $margin . " !important;";
	} */
	
	if(isset($adtdap['wmarginright']) && ($adtdap['wmarginright'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginright']) . "px ";
		$adt_css .= "right: " . $margin . " !important;";
	} else {
		$adt_css .= "right: 0 !important;";
	}
	
	if(isset($adtdap['wmarginbottom']) && ($adtdap['wmarginbottom'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginbottom']) . "px ";
		$adt_css .= "bottom: " . $margin . " !important;";
	} else {
		$adt_css .= "bottom: 0 !important;";
	}
	
	if(isset($adtdap['wmarginleft']) && ($adtdap['wmarginleft'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginleft']) . "px";
		$adt_css .= "left: " . $margin . " !important;";
	} else {
		$adt_css .= "left: 0 !important;";
	}
								$adt_css .= "position:fixed !important; margin: 0 auto !important; z-index: 2147483642;";								
								} elseif ($adtdap['adtwpospred'] == "bottom_right") {									
/* 	if(isset($adtdap['wmargintop']) && ($adtdap['wmargintop'] != 0) ) { 
		$margin = $adtdap['wmargintop'] . "px ";
		$adt_css .= "top: " . $margin . " !important;";
	} */
	
	if(isset($adtdap['wmarginright']) && ($adtdap['wmarginright'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginright']) . "px ";
		$adt_css .= "right: " . $margin . " !important;";
	} else {
		$adt_css .= "right: 0 !important;";
	}
	
	if(isset($adtdap['wmarginbottom']) && ($adtdap['wmarginbottom'] != 0)) { 
		$margin = sanitize_text_field($adtdap['wmarginbottom']) . "px ";
		$adt_css .= "bottom: " . $margin . " !important;";
	} else {
		$adt_css .= "bottom: 0 !important;";
	}
	
/* 	if(isset($adtdap['wmarginleft']) && ($adtdap['wmarginleft'] != 0)) { 
		$margin = $adtdap['wmarginleft'] . "px";
		$adt_css .= "left: " . $margin . " !important;";
	} */
								$adt_css .= "position:fixed !important; z-index: 2147483642;";
								}
							}	
								
						} elseif($adtdap['adtwpostype'] == "adtwpostypecust") {
							$adt_css .= "position:fixed !important; z-index:2147483642;";
							if(isset($adtdap['wtop']) && $adtdap['wtop'] != "" ) { 
							$adt_css .= "top:" . sanitize_text_field($adtdap['wtop']) . sanitize_text_field($adtdap['wtopm']) . " !important; ";
							}
							if(isset($adtdap['wleft']) && $adtdap['wleft'] != "" ) { 
							$adt_css .= "left:" . sanitize_text_field($adtdap['wleft']) . sanitize_text_field($adtdap['wleftm']) . " !important; ";
							}
						}elseif($adtdap['adtwpostype'] == "adtwposshortcode") {
							$adt_css .= "position:relative !important;";
						} else {
						$adt_css .= "";
						}
					
					$adt_css .= '}';
					 
					/*end THE CSS PROPERTIES*/
					$finalADTStyle = $cssEditor->wpadt_editCss($adt_content, $adt_css, $adt_selector, $post_id);	
					$wp_filesystem->put_contents($adt_path, sanitize_text_field($finalADTStyle), FS_CHMOD_FILE);
					}
				}
	}
	
	}

}
new wpadt_adtSaveDisAPMainArea();
?>