<?php

class wpadt_adTentionsBase {

	function __construct(){
		add_action( 'init', array($this, 'wpadt_custom_post_type'), 0);
		add_filter('post_updated_messages', array($this, 'wpadt_eps_updated_messages'));
		add_filter( 'gettext', array( $this, 'wpadt_change_publish_button'), 10, 2 );
		add_action('post_edit_form_tag',array($this, 'wpadt_edit_form_type_eps'));
		add_filter( 'enter_title_here', array($this, 'wpadt_custom_title_fieldplaceholder'), 10, 2 );
		add_filter('manage_wp_adtentions_posts_columns', array($this, 'wpadt_adtsh_columns_head'));
		add_action( 'manage_wp_adtentions_posts_custom_column' , array($this, 'wpadt_adtsh_columns_content'), 10, 2 );
		add_filter( 'post_row_actions', array($this, 'wpadt_remove_row_actions'), 10, 2 );
		add_filter( "manage_edit-wp_adtentions_sortable_columns", array($this, 'wpadt_adtsh_columns_head'));
		add_filter('tiny_mce_before_init',  array($this, 'wpadt_override_mce_options'));
	}

	public function wpadt_custom_post_type() {
	$labels = array(
		'name'                => _x( 'Adtentions', 'Post Type General Name', 'adtentions' ),
		'singular_name'       => _x( 'Adtentions', 'Post Type Singular Name', 'adtentions' ),
		'menu_name'           => __( 'Adtentions', 'adtentions' ),
		'parent_item_colon'   => __( 'Parent Adtentions:', 'adtentions' ),
		'all_items'           => __( 'All Adtentions', 'adtentions' ),
		'add_new_item'        => __( 'Create New Adtention', 'adtentions' ),
		'add_new'             => __( 'Create Adtention', 'adtentions' ),
		'edit_item'           => __( 'Edit Adtention', 'adtentions' ),
		'update_item'         => __( 'Update Adtention', 'adtentions' ),
		'search_items'        => __( 'Search Adtentions', 'adtentions' ),
		'not_found'           => __( 'No Adtention', 'adtentions' ),
		'not_found_in_trash'  => __( 'No Adtention in Trash', 'adtentions' ),
	);
	$args = array(
		'label'               => __( 'wp_adtentions', 'adtentions' ),
		'description'         => __( 'WP Adtentions', 'adtentions' ),
		'labels'              => $labels,
		'supports'            => array('title'),
		'taxonomies'          => array(''),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 999999,
		'menu_icon'			  => plugin_dir_url(__FILE__) . '../img/paper-plane.png',
		'can_export'          => true,
		'has_archive'         => true,
		'query_var' 		  => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'capability_type'     => 'page',
	);
	register_post_type( 'wp_adtentions', $args );

}
	
	// Custom message
	function wpadt_eps_updated_messages( $messages ) {
	global $pagenow, $typenow;
		if (($pagenow == 'edit.php' || $pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow ==='wp_adtentions' && !isset($_GET['page'])) {
			// remove_filter( 'the_content', 'wpautop' );
			$post             = get_post();
			$post_type        = get_post_type( $post );
			$post_type_object = get_post_type_object( $post_type );
				$messages[$post_type] = array(
				0  => '', // Unused. Messages start at index 1.
				1  => __( 'Adtention updated.', 'adtentions' ),
				2  => __( 'Custom field updated.', 'adtentions' ),
				3  => __( 'Custom field deleted.', 'adtentions' ),
				4  => __( 'Adtentions updated.', 'adtentions' ),
				// translators: %s: date and time of the revision
				5  => isset( $_GET['revision'] ) ? sprintf( __( 'PopUp restored to revision from %s', 'adtentions' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6  => __( 'Adtention created.', 'adtentions' ),
				7  => __( 'Adtention saved.', 'adtentions' ),
				8  => __( 'Adtention submitted.', 'adtentions' ),
				9  => sprintf(
					__( 'Adtentions scheduled for: <strong>%1$s</strong>.', 'adtentions' ),
					// translators: Publish box date format, see http://php.net/date
					date_i18n( __( 'M j, Y @ G:i', 'adtentions' ), strtotime( $post->post_date ) )
				),
				10 => __( 'Adtention draft updated.', 'adtentions' )
				);
				
				if ( $post_type_object->publicly_queryable ) {
				$permalink = get_permalink( $post->ID );
				$view_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $permalink ), __( 'View Adtentions Page', 'adtentions' ) );
				$messages[ $post_type ][1] = $view_link;
				$messages[ $post_type ][6] .= $view_link;
				$messages[ $post_type ][9] .= $view_link;

				$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
				$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview Adtentions', 'adtentions' ) );
				$messages[ $post_type ][8]  .= $preview_link;
				$messages[ $post_type ][10] .= $preview_link;
			}
		}
		return $messages;
	}
	
	// Change Publish Adtentions
		function wpadt_change_publish_button( $translation, $text ) {
		if ( 'wp_adtentions' == get_post_type()){
			if ( $text == 'Publish' ){
				return 'Create Adtention';
			}
			if ( $text == '(no title)' ){
				return 'no name';
			}	
		}
		return $translation;
		}
	
	// Enable form file upload
	function wpadt_edit_form_type_eps() {
    echo ' enctype="multipart/form-data"';
	}	
	
	function wpadt_custom_title_fieldplaceholder( $title, $post ) {
		if ( 'wp_adtentions' == $post->post_type ) {
			$title = 'Give it an identity?';
		}
		return $title;
	}
	
	function wpadt_adtsh_columns_head($columns){
	$new = array();
		foreach($columns as $key => $val) {
			if($key == 'date') {
			$new['adt_shortcode'] = "Shortcode";
			$new[$key] = $val;
			} elseif( $key == 'title') {
				$new['title'] = "Name";
			} else {
				$new[$key] = $val;
			}
		}
		return $new;
	}
	
	function wpadt_adtsh_columns_content($column, $post_id){
		$shblock = "";
		if($column == 'adt_shortcode') {
			$shblock = "<input type='text' name='' size='15' class='adtshortcodecontainer' value='[adtscode id=\"". $post_id . "\"]'/>";
		}
		
		echo $shblock;
	}	

    function wpadt_override_mce_options($initArray) {		
	global $pagenow, $typenow;
		// if (($pagenow == 'edit.php' || $pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow ==='wp_adtentions' && !isset($_GET['page'])) {
			$opts = '*[*]';
			$initArray['paste_word_valid_elements'] = $opts;
			$initArray['valid_elements'] = $opts;
			$initArray['extended_valid_elements'] = $opts;
			return $initArray;
		// }
    }
	
	function wpadt_remove_row_actions($actions, $post) {
	global $pagenow, $typenow;
		if ($pagenow == 'edit.php'&& $typenow ==='wp_adtentions' && !isset($_GET['page'])) {
			unset($actions['view']);
			unset( $actions['inline hide-if-no-js'] );
			$new = array();
			foreach($actions as $key => $val) {
				$new[$key] = $val;
				/* if($key == 'trash') {
					$clonenonce = wp_create_nonce(md5($post->ID . '_adt'));
					$new['clone'] = "<span class='wait'>processing...</span><a pid='" . $post->ID . "' nonce='" . $clonenonce . "' status='publish' postype='" . $_GET['post_type'] ."' class='cloneadt_item' href='#'>Clone</a>";
					
					$clonedraft = wp_create_nonce(md5($post->ID . 'd_adt'));
					$new['clonedraft'] = "<span class='wait'>processing...</span><a pid='" . $post->ID . "' nonce='" . $clonedraft . "' status='draft' postype='" . $_GET['post_type'] . "' class='cloneadt_item' href='#'>Clone Draft</a>";
					
					$new[$key] = $val;
					
				} else {					
					$new[$key] = $val;
				} */
			}
			
		return $new;
		} else {
		return $actions;
		}
	}
	
}

new wpadt_adTentionsBase();
?>