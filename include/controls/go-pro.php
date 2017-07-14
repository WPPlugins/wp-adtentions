<?php
class wpadt_GoProBox {

	function __construct(){
		$this->wpadt_tocall();
	}

	function wpadt_tocall(){
		add_action( 'add_meta_boxes', array($this, 'wpadt_container'));
	}

	function wpadt_container($post_type) {
	
		$post_types = array('wp_adtentions');
		
			if (in_array( $post_type, $post_types)) {
				
				// CUSTOM PUBLISH BOX
				add_meta_box(
					'gopro_box'
					,__( 'Go Pro', 'adtentions' )
					,array( $this, 'wpadt_baseElement' )
					,$post_type
					,'normal'
					,'low'
				);
				
			}	
	}
	
	function wpadt_baseElement($post) {
	?>
	
<div class="tab-container">
<!-- ADS IMAGE -->
	<div class="elementswrapperin">
		<a target="_blank" href="http://adtentions.soursoptree.com/"><img width="100%" src="<?php echo plugin_dir_url(__FILE__) . '../../img/go-pro.png'; ?>"/></a>
	</div>
</div>
	<?php
	}
}
new wpadt_GoProBox();
?>