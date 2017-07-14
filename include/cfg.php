<?php
require_once("controls/request.php");
$poid = isset($_GET['post']) ? $_GET['post'] : "";
$settingpage = admin_url('edit.php?post_type=wp_adtentions&page=adt-setting_controller_page');
$reqapi = new wpadt_wpadrequestApi();
$keysaved = $reqapi->wpadt_checkOptionKey();
?>