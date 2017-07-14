<?php
ob_start();
class wpadt_createCookie {
	function __construct() {
		add_action('init', array($this, 'wpadt_Setcookiee'));
	}
	
	function wpadt_Setcookiee() {
		global $wpdb;
		$results = $wpdb->get_results( 'SELECT * FROM wp_posts WHERE post_type = "wp_adtentions" AND post_status = "publish"', OBJECT );
			foreach($results as $key => $res){
			$popid = $res -> ID;
				$rules = get_post_meta($popid, "_adt_display_rules", true);
				$cookie = get_post_meta($popid, '_adt_cookie_rule', true);
				
				$cookie = strtotime($cookie . 'day', 0);
				$expiry = get_post_meta($popid, '_adt_cookie_history', true);
				if(is_array($rules)){
				if(in_array('use_cookies', $rules) && $cookie > 0 && !isset($_COOKIE[$popid . "_adt"])){
					setcookie($popid . "_adt", "ShowAds", time()+$cookie);
					update_post_meta($popid, '_adt_cookie_history', time()+$cookie);						
				}
				}
			}
	}
}
new wpadt_createCookie();
?>