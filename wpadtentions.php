<?php
/*
Plugin Name: WP Adtentions
Plugin URI: http://adtentions.soursoptree.com/
Description: Advanced placement for shortcode, html codes, images, video embed and advertisement for wordpress. Make your ad moving or show it using different ways. Keep your visitors stay engaged or play in your site instead of leaving it! Eliminate ad blindness, bounce rate and increase ad clicks, which means increase on your revenue. Ad Placement and Shortcode Display Helper with animation. Give more places for any shortcode to show or create animated ad.
Version: 0.2
Author: Ari Susanto
Author URI: http://soursoptree.com/
*/
require_once("include/required_files.php");
add_filter('tiny_mce_before_init', 'wpadt_filter_tiny_mce_before_init');
function wpadt_filter_tiny_mce_before_init( $options ) {
global $pagenow, $typenow;
if (($pagenow == 'edit.php' || $pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow ==='wp_adtentions' && !isset($_GET['page'])) {
    if ( ! isset( $options['extended_valid_elements'] ) ) {
        $options['extended_valid_elements'] = 'style';
    } else {
        $options['extended_valid_elements'] .= ',style';
    }

    if ( ! isset( $options['valid_children'] ) ) {
        $options['valid_children'] = '+body[style]';
    } else {
        $options['valid_children'] .= ',+body[style]';
    }

    if ( ! isset( $options['custom_elements'] ) ) {
        $options['custom_elements'] = 'style';
    } else {
        $options['custom_elements'] .= ',style';
    }
	return $options;
	}
	return $options;
}

add_filter('wp_default_editor', 'wpadt_set_default_editor');
function wpadt_set_default_editor( $type ) {
	global $pagenow, $typenow;
	if (($pagenow == 'edit.php' || $pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow ==='wp_adtentions' && !isset($_GET['page'])) {
    if('wp_adtentions' == $post_type)
        return 'html';
	}
    return $type;
}

function wpadt_tinymce_remove_root_block_tag( $init ) {
	global $pagenow, $typenow;
	if (($pagenow == 'edit.php' || $pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow ==='wp_adtentions' && !isset($_GET['page'])) {	
    $init['wpautop'] = false; 
    $init['force_p_newlines'] = false; 
    $init['forced_root_block'] = false;
    $init['apply_source_formatting'] = true;
    $init['remove_linebreaks'] = false;
    $init['entity_encoding'] = "";
	}
    return $init;
}
add_filter( 'tiny_mce_before_init', 'wpadt_tinymce_remove_root_block_tag' );

?>