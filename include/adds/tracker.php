<?php
class wpadt_adtFrontTracker{
	function __construct(){
		if(is_admin()) {
			add_action( 'wp_ajax_trackadperformance', array($this, 'wpadt_adtajax_adperformance_tracker'));
		}
		add_action( 'wp_ajax_nopriv_trackadperformance', array($this, 'wpadt_adtajax_adperformance_tracker'));
	}

	function wpadt_adtajax_adperformance_tracker($post) {
	global $wpdb, $post;	
	check_ajax_referer('adt-secure-submit', 'security');	
		if(isset($_POST['array']) && $_POST['array'] != "") {
			parse_str($_POST['array'], $output);

			if(isset($_POST['view']) && $_POST['view'] == true){
			$view = get_post_meta($output['id'], '_ad_viewtracking_performance', true);			
			$trackrest = array();
				foreach($output as $key => $val) {
					if($key == 'count') {
						$trackrest[wp_strip_all_tags($key)] = wp_strip_all_tags(intval($val)) + intval($view['count']);
					} else {
						$trackrest[wp_strip_all_tags($key)] = wp_strip_all_tags($val);
					}
				}			
				update_post_meta($trackrest['id'], '_ad_viewtracking_performance', $trackrest);
			}
			if(isset($_POST['click']) && $_POST['click'] == true){
			$click = get_post_meta($output['id'], '_ad_clicktracking_performance', true);			
				$trackrest = array();
				foreach($output as $key => $val) {
					if($key == 'count') {
						$trackrest[wp_strip_all_tags($key)] = wp_strip_all_tags(intval($val)) + intval($click['count']);
					} else {
						$trackrest[wp_strip_all_tags($key)] = wp_strip_all_tags($val);
					}
				}
				update_post_meta($trackrest['id'], '_ad_clicktracking_performance', $trackrest);
			}			
		}
	die();
	}
}

new wpadt_adtFrontTracker();
?>