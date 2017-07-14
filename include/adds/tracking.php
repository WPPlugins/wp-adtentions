<?php

class wpadt_adtTracking {

	function __construct() {
		// additional sub menu page
		add_action('admin_menu', array($this, 'wpadt_adt_tracking_page'));
		add_action('admin_enqueue_scripts', array($this, 'wpadt_settingsPageScript'));
	}

	function wpadt_settingsPageScript() {
		global $pagenow, $typenow;
		if ($pagenow == 'edit.php' && $typenow ==='wp_adtentions' && isset($_GET['page']) && $_GET['page'] == 'adt-tracker_page') {
		wp_enqueue_style( 'adt_css_tracker', plugins_url('../../css/admin/trackertable.css',  __FILE__) );
		}
	}
	
	function wpadt_adt_tracking_page() { 
	global $pagenow, $typenow, $reqapi, $keysaved, $settingpage;
		add_submenu_page('edit.php?post_type=wp_adtentions', 'Click counter', 'Clicks', 'manage_options', 'adt-tracker_page', array($this, 'wpadt_adt_tracking_report_page'));
		
		if ($pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] ==='wp_adtentions' && !isset($_GET['page'])) {
			if($keysaved != 1) {
				header("Location: " . $settingpage);
				die();
			}
		}
	}
	
	function wpadt_adt_tracking_report_page($post) {
	global $post, $wpdb, $reqapi, $keysaved, $settingpage;
	if($keysaved != 1) {
		header("Location: " . $settingpage);
		die();
	}
	?>
	<h2>Views and Clicks Report</h2>
	<div id="trackerwrapper">
	<?php
	
		$the_query = new WP_Query("post_type=wp_adtentions&posts_per_page=-1");
		if ($the_query->have_posts()) {
		?>		
			<table id="trackertable">
			<thead>
			<tr class="bordered">
			<th class="thbordered">Name</th>
			<th class="thbordered">ID</th>
			<th class="thbordered">Total Views</th>
			<th class="thbordered">Total Clicks</th>
			<th class="thbordered">Action</th>
			<tr>
			</thead>
			<tbody>
		<?php
			while ($the_query->have_posts()){
			$the_query->the_post();
					$popsid = get_the_ID();	
				$view = get_post_meta($popsid, '_ad_viewtracking_performance', true);
				$click = get_post_meta($popsid, '_ad_clicktracking_performance', true);	
				// echo $view['name'];
				if(isset($view['id'])) {
					?>
					<tr class="bordered">
					<td class="bordered left"><?php echo get_the_title() != "" ? get_the_title(): "no name"; ?></td>
					<td class="bordered center"><?php echo isset($view['id']) ? $view['id'] : "" ; ?></td>
					<td class="bordered center"><?php echo isset($view['id']) ? $view['count'] : "" ; ?></td>
					<td class="bordered center"><?php echo isset($click['id']) ? $click['count'] : "-" ; ?></td>
					<td class="bordered center"><?php echo "<a target='_blank' href='" . admin_url() . "post.php?post=" . $view['id'] .  "&action=edit'> Edit</a> " ; ?></td>
					</tr>
					<?php 
				} else{
				?>
					<tr class="bordered">
					<td class="bordered left"><?php echo get_the_title() != "" ? get_the_title(): "no name"; ?></td>
					<td class="bordered center"><?php echo $popsid ; ?></td>
					<td class="bordered center"><?php echo "-" ; ?></td>
					<td class="bordered center"><?php echo "-" ; ?></td>
					<td class="bordered center"><?php echo "<a target='_blank' href='" . admin_url() . "post.php?post=" . $popsid .  "&action=edit'> Edit</a> " ; ?></td>
					</tr>					
				<?php
				}
			}
			wp_reset_postdata();
			?>
			</tbody>
			</table>	
			<?php
		} else {
			echo "<span>You have no adtention to be reported! Please <a href='" . admin_url() . "post-new.php?post_type=wp_adtentions'>click here</a> to create one!</span>";		
		}
	?>
	</div>
	<?php
	}
}
	new wpadt_adtTracking();
	
?>