<?php
class wpadt_adtElementsBox {

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
					'elements_box'
					,__( 'CONTENTS', 'adtentions' )
					,array( $this, 'wpadt_baseElement' )
					,$post_type
					,'normal'
					,'low'
				);
				
			}	
	}
	
	function wpadt_baseElement($post) {
	global $post, $poid, $reqapi, $keysaved, $settingpage;
	
	if($keysaved != 1) {
		header("Location: " . $settingpage);
		die();
	}

	$htmlcodes = get_post_meta( $poid, '_adt_htmlads_key', true);
	wp_nonce_field( 'adt_custom_box', 'adt_custom_box_nonce' );
	?>
	
<div id="elementswrapper" class="tab-container">
<!-- ADS IMAGE -->
	<div id="adtimagebox" class="elementswrapperin">
		<div id="adtuseadshtml">
		<?php 
		$content = $htmlcodes != "" ? html_entity_decode($htmlcodes) : "";
		$settings = array('media_buttons' => true, 'textarea_name' => 'adtusehtmlads', 'editor_class' => 'adtusehtmlads', 'textarea_rows' => '', 'textarea_cols' => '', 'wpautop' => false);
		wp_editor($content, "adtusehtmlads", $settings);
		?>		
		</div>
	</div>
</div>
	<?php
	}
}
new wpadt_adtElementsBox();
?>