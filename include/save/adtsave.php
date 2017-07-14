<?php

class wpadt_adtSave {

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
	
		if(isset($_POST['adtusehtmlads']) && trim($_POST['adtusehtmlads']) != "") {
			if(is_admin()) {
				update_post_meta( $post_id, '_adt_htmlads_key', sanitize_text_field(htmlentities(stripslashes($_POST['adtusehtmlads']), ENT_QUOTES)));
			} else {
				return;
			}
		} else {
			if(is_admin()) {
				delete_post_meta($post_id, '_adt_htmlads_key');
			} else {
				return;
			}
		}
	
/* SAVE SETTINGS */
		if(isset($_POST['onoffswitch'])) {
			$switch = sanitize_text_field($_POST['onoffswitch']);
			update_post_meta( $post_id, '_on_off_switch', $switch);
		} else {
			delete_post_meta( $post_id, '_on_off_switch', 'switch_on');
		}		
		
		$location = array();
		
		if(isset($_POST['all_location'])) {
		
			$location[] = sanitize_text_field($_POST['all_location']);
			
		} else {
		
			if(isset($_POST['exclude_home'])) {
				$location[] = sanitize_text_field($_POST['exclude_home']);
			} elseif(isset($_POST['home_only'])) {
				$location[] = sanitize_text_field($_POST['home_only']);
			} 
			
			if(isset($_POST['exclude_archive'])) {
				$location[] = sanitize_text_field($_POST['exclude_archive']);
			} elseif(isset($_POST['archive_only'])) {
				$location[] = sanitize_text_field($_POST['archive_only']);
			}
			
			if(isset($_POST['deeps']) && $_POST['deeps'] != "") {
					$deeps = sanitize_text_field($_POST['deeps']);
					
			}					
		}

		if(isset($_POST['404_page'])) {
			$location[] = sanitize_text_field($_POST['404_page']);
		} elseif(isset($_POST['no_404_page'])) {
			$location[] = sanitize_text_field($_POST['no_404_page']);
		}
		
		if(isset($_POST['by_date'])) {
		$date = $_POST['by_date'];
				$datearray = array();
				foreach($date as $key => $value) {
					if(is_array($value)) {
						foreach($value as $k => $v) {
							$datearray[sanitize_text_field($key)][sanitize_text_field($k)] = sanitize_text_field($v);
						}
					} else {
						$datearray[sanitize_text_field($key)] = sanitize_text_field($value);
					}
				}
		update_post_meta( $post_id, '_adt_date_key', $datearray);
		}
	
		if(!empty($deeps)){
			$locations = array_merge($location, $deeps);
		} else {
			$locations = $location;
		}
		
		$locationarray = array();
		foreach($locations as $key => $value) {
			if(is_array($value)) {
				foreach($value as $k => $v) {
					$locationarray[sanitize_text_field($key)][sanitize_text_field($k)] = sanitize_text_field($v);
				}
			} else {
				$locationarray[sanitize_text_field($key)] = sanitize_text_field($value);
			}
		}		
		update_post_meta( $post_id, '_adt_locations_key', $locationarray);
		
		$adtRules = array();
		if(isset($_POST['adt_rules'])) {
			$adtRule[] = sanitize_text_field($_POST['adt_rules']);
		}
		
		// COOKIE
		if(isset($_POST['use_cookies']) && $_POST['cookies_expr'] != "") {
			$adtRule[] = sanitize_text_field($_POST['use_cookies']);
			$cookie_val = sanitize_text_field($_POST['cookies_expr']);
			update_post_meta( $post_id, '_adt_cookie_rule', $cookie_val);
		}
		
		$adtRules = array();
		foreach($adtRule as $rule){
			if(is_array($rule)){
			foreach($rule as $re)
			$adtRules[] = $re;			
			} else {
			$adtRules[] = $rule;
			}
		}
		$rulearray = array();
		foreach($adtRules as $key => $value) {
			if(is_array($value)) {
				foreach($value as $k => $v) {
					$rulearray[sanitize_text_field($key)][sanitize_text_field($k)] = sanitize_text_field($v);
				}
			} else {
				$rulearray[sanitize_text_field($key)] = sanitize_text_field($value);
			}
		}
		update_post_meta( $post_id, '_adt_display_rules', $rulearray);
// endof SAVE SETTINGS
	
// START WP_FILESYSTEM
	$access_type = get_filesystem_method();
	if($access_type === 'direct') {
		
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$creds = request_filesystem_credentials($url, '', false, false, array());
			/* initialize the API */
			if ( ! WP_Filesystem($creds) ) {
				return false;
			}
			global $wp_filesystem;
			$cssEditor = new wpadt_CssEditor();
	// adtdap[wcenterize]
	
			if(isset($_POST['adtdes'])) {
				$adtdes = $_POST['adtdes'];				
				$adtdessn = array();
				foreach($adtdes as $key => $value) {
					if(is_array($value)) {
						foreach($value as $k => $v) {
							$adtdessn[sanitize_text_field($key)][sanitize_text_field($k)] = sanitize_text_field($v);
						}
					} else {
						$adtdessn[sanitize_text_field($key)] = sanitize_text_field($value);
					}
				}
				update_post_meta($post_id, "_adtdes_array_values", $adtdessn);
				
				$adt_selector = array("#adt_front_wrapper", "#adt_front_wrappersecond");
				$adt_cssf = array_filter($adtdes);
					if(is_array($adt_cssf)) {
					$adt_file = plugin_dir_path(__FILE__) . '/../../css/front/default/wrapper.css';

					if(!$wp_filesystem->is_dir(plugin_dir_path(__FILE__) . '/../../css/front/custom/')) 
					{
						$wp_filesystem->mkdir(plugin_dir_path(__FILE__) . '/../../css/front/custom/');
					}
											
					$adt_path = plugin_dir_path(__FILE__) . '/../../css/front/custom/wrapper' . $post_id . '.css';
					
					$adt_content = $wp_filesystem->get_contents($adt_file);
					
					/*THE CSS PROPERTIES*/
					//"#adt_front_wrapper"
					$adt_css = $adt_selector[0] . "{\n";
					
					if(isset($adtdes['wwidth']) && $adtdes['wwidth'] != "" && $adtdes['wwidth'] != 0 && !isset($adtdes['wauto'])) { 
					$adt_css .= "width:" . sanitize_text_field($adtdes['wwidth']) . sanitize_text_field($adtdes['wwidthm']) . " !important; ";
					} else {
					$adt_css .= "width: initial; ";	
					}
					
					if(isset($adtdes['wheight']) && $adtdes['wheight'] != "" && $adtdes['wheight'] != 0  && !isset($adtdes['hauto'])) { 
					$adt_css .= "height:" . sanitize_text_field($adtdes['wheight']) . sanitize_text_field($adtdes['wheightm']) . " !important; ";
					} else {
					$adt_css .= "height: initial; ";	
					}
					
					if(isset($adtdes['woverflow']) && $adtdes['woverflow'] == "on" ) { 
					$adt_css .= "overflow: hidden !important; ";
					}
					
					if(isset($adtdes['centerinner']) && $adtdes['centerinner'] == "on" ) { 
					$adt_css .= "text-align: center !important; ";
					}
					
					$adt_css .= "}\n";
					
					
					//"#adt_front_wrappersecond"
					$adt_css .= $adt_selector[1] . "{\n";					
					if(isset($adtdes['wbgclr']) && $adtdes['wbgclr'] != "" && !isset($adtdes['wbgnone'])) { 
					$adt_css .= "background: " . sanitize_text_field($adtdes['wbgclr']) . " !important; ";
					}
					
					$padding = "initial";
					if(!isset($adtdes['wpaddingnone'])) {
						$padding = "";
						if(isset($adtdes['wpaddingtop']) && $adtdes['wpaddingtop'] != "") { 
							$padding .= sanitize_text_field($adtdes['wpaddingtop']) . "px ";
						}
						
						if(isset($adtdes['wpaddingright']) && $adtdes['wpaddingright'] != "") { 
							$padding .= sanitize_text_field($adtdes['wpaddingright']) . "px ";
						}
						
						if(isset($adtdes['wpaddingbottom']) && $adtdes['wpaddingbottom'] != "") { 
							$padding .= sanitize_text_field($adtdes['wpaddingbottom']) . "px ";
						}
						
						if(isset($adtdes['wpaddingleft']) && $adtdes['wpaddingleft'] != "") { 
							$padding .= sanitize_text_field($adtdes['wpaddingleft']) . "px";
						}
					}
						$padding .= ";";
						$adt_css .= "padding:" . $padding;
					
					 
					if(isset($adtdes['wshdwhr']) && $adtdes['wshdwhr'] != "" && isset($adtdes['wshdwvr']) && $adtdes['wshdwvr'] != "" && isset($adtdes['wshdwspr']) && $adtdes['wshdwspr'] != "" && isset($adtdes['wshdwblr']) && $adtdes['wshdwblr'] != "" && isset($adtdes['wshdwclr']) && $adtdes['wshdwclr'] != "" && !isset($adtdes['wshadow'])) { 
					
					$adt_css .= "-webkit-box-shadow: " . sanitize_text_field($adtdes['wshdwhr']) . "px " . sanitize_text_field($adtdes['wshdwvr']) . "px " . sanitize_text_field($adtdes['wshdwblr']) .  "px " . sanitize_text_field($adtdes['wshdwspr']) . "px " . sanitize_text_field($adtdes['wshdwclr']) . " !important; ";
					
					$adt_css .= "-moz-box-shadow: " . sanitize_text_field($adtdes['wshdwhr']) . "px " . sanitize_text_field($adtdes['wshdwvr']) . "px " . sanitize_text_field($adtdes['wshdwblr']) .  "px " . sanitize_text_field($adtdes['wshdwspr']) . "px " . sanitize_text_field($adtdes['wshdwclr']) . " !important; ";
					
					$adt_css .= "box-shadow: " . sanitize_text_field($adtdes['wshdwhr']) . "px " . sanitize_text_field($adtdes['wshdwvr']) . "px " . sanitize_text_field($adtdes['wshdwblr']) .  "px " . sanitize_text_field($adtdes['wshdwspr']) . "px " . sanitize_text_field($adtdes['wshdwclr']) . " !important; ";
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
new wpadt_adtSave();
?>