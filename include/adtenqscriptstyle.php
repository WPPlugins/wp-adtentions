<?php
class wpadt_adtEnqScriptStyle {
	function __construct() {
		$this->wpadt_enqueuescripts();
	}
	
	function wpadt_enqueuescripts() {
		add_action('admin_enqueue_scripts', array($this, 'wpadt_eps_admin_script_style'), 99999);
	}

	function wpadt_eps_admin_script_style() {
		global $pagenow, $typenow;
		
		if (($pagenow == 'edit.php' || $pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow ==='wp_adtentions' && !isset($_GET['page'])) {
		
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script( 'jquery-ui-slider');
			wp_enqueue_script( 'jquery-ui-effect');
			wp_enqueue_script( 'jquery-ui-datepicker');
			wp_enqueue_script( 'iris' ); 
			//jQuery
			wp_enqueue_script( 'adtmain_js', plugin_dir_url(__FILE__). '/../../js/admin/main.js', array(), '1.0.0', true );
			wp_enqueue_script( 'accordion_js', plugin_dir_url(__FILE__). '/../../js/admin/jquery.accordion.js', array('jquery'), '1.0.0', true );
			wp_enqueue_script( 'adt_slider_js', plugin_dir_url(__FILE__). '/../../js/admin/adtslider.js', array('jquery', 'jquery-ui-slider'), '1.0.0', true );
			wp_enqueue_script( 'adt_hierachy_js', plugin_dir_url(__FILE__). '/../../js/admin/hierachy.js', array(), '1.0.0', true );
			wp_enqueue_script( 'tabshashchange_js', plugin_dir_url(__FILE__). '/../../js/admin/jquery.hashchange.min.js', array('jquery'), '1.0.0', true );
			wp_enqueue_script( 'easytabs', plugin_dir_url(__FILE__). '/../../js/admin/jquery.easytabs.min.js', array('jquery', 'tabshashchange_js'), '1.0.0', true );
			wp_enqueue_script( 'adtpreview', plugin_dir_url(__FILE__). '/../../js/admin/preview.js', array('jquery'), '1.0.0', true );
			wp_enqueue_script( 'adtjquery_nicescroll_js', plugin_dir_url(__FILE__). '/../../js/admin/jquery.nicescroll.min.js', array('jquery'), '1.0.0', true );
			//CSS			
			wp_enqueue_style( 'adt_jqui_css', plugins_url('../css/admin/jquery-ui.css',  __FILE__) );
			wp_enqueue_style('adt_css_tabbable');
			wp_enqueue_style( 'adt_maincss', plugins_url('../css/admin/main.css',  __FILE__) );
			wp_enqueue_style( 'adt_designcss', plugins_url('../css/admin/design.css',  __FILE__) );
			wp_register_style( 'adt_accordioncss', plugins_url('../css/admin/jquery.accordion.css',  __FILE__) );
			wp_enqueue_style('adt_accordioncss');
			wp_register_style( 'adt_preview', plugins_url('../css/admin/preview.css',  __FILE__) );
			wp_enqueue_style('adt_preview');
			wp_register_style( 'adt_animateonepreview', plugins_url('../css/front/animate/animate.min.css',  __FILE__) );
			wp_enqueue_style('adt_animateonepreview');
		}

	}
}

new wpadt_adtEnqScriptStyle();
?>