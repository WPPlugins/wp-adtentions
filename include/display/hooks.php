<?php
require_once("adtshowads.php");
function wpadt_Show_Ads(){
	$adtshowads = new wpadt_adtShowAds();
}
add_action('template_redirect', 'wpadt_Show_Ads');
?>