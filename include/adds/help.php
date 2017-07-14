<?php
class wpadt_adthelp {

	function __construct() {
		// additional sub menu page
		add_action('admin_menu', array($this, 'wpadt_adt_help_menu_page'));
	}
	
	function wpadt_adt_help_menu_page() { 
		add_submenu_page('edit.php?post_type=wp_adtentions', 'ADT Help', 'Helps', 'manage_options', 'adt-help_page', array($this, 'wpadt_adt_help_page'));
	}
	
	function wpadt_adt_help_page() {
	?>	
		<h1>Help and Supports</h1>
		<h3>Documentation</h3>
		A full documentation of this plugin is available <a href="http://adtentions.soursoptree.com/documentation" target="_blank">here</a>.
		<hr>
		<h3>Tutorial</h3>
		There is a detailed tutorial about how to create an animated horizontal opt-in bar <a href="http://adtentions.soursoptree.com/tutorials" target="_blank">here</a>.
		<hr>
		<h3>Supports</h3>
		If you bought WP Adtentions premium version, then you can ask for premium support <a href="http://adtentions.soursoptree.com/supports" target="_blank">here</a>.
		<p>
		A free support is available through wordpress support forum.
		</p>
		<hr>
		<h3>Suggest Improvements</h3>
		You can suggest for any improvement if you feel unsatisfied with the current version of WP Adtentions <a href="http://adtentions.soursoptree.com/suggest-features" target="_blank">here</a>.
		<hr>
		<h3>Earn Money</h3>		
		Earn 50% of every sale of WP Adtentions you promote. Click <a href="http://adtentions.soursoptree.com/affiliates" target="_blank">here</a> for more details.
	<?php
	}
}
	new wpadt_adthelp();
?>