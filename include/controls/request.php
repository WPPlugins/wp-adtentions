<?php
class wpadt_wpadrequestApi {
	
	function wpadt_checkUpdate($endpoint, $type, $email, $key, $domain, $recheck = "") {
		return "true";
	}
	
	function wpadt_checkOptionKey($optkey = "wpad_activation_key_val") {
		return 1;
	}
	
	function wpadt_actiForm($domain) {
	}
}
?>