<?php
class wpadt_adtShowShortcode{

	function __construct(){
	add_shortcode('adtscode', array($this, 'wpadt_adtshortcode'), 9999);
	}
	
	function wpadt_adtshortcode($atts, $content = null, $tag){
		global $post, $wpdb;
		extract( shortcode_atts( array(
		'id' => ''
		),	$atts ) );
		
	// ELEMENT DATA	
	$htmlcodes = html_entity_decode(get_post_meta($id, '_adt_htmlads_key', true));
	
	// DESIGN
	$adtdes = get_post_meta($id, "_adtdes_array_values", true);
	
	// TRIGGER	
	$adttrig = get_post_meta($id, "adt_show_hidetrigger", true);	
	$wa = get_post_meta($id, "adt_show_wholeadanimation", true);
	
	//PLACEMENT
	$adtplace = get_post_meta($id, "adt_display_adplacement", true);
	
	// SCRIPT AND STYLESHEET
	wp_enqueue_style( 'adt_front_style' . $id, plugin_dir_url(__FILE__) . "../../css/front/custom/wrapper" . $id . ".css");
	wp_enqueue_style( 'adt_place' . $id, plugin_dir_url(__FILE__) . "../../css/front/custom/placement" . $id . ".css");
	wp_enqueue_style( 'adt_clsmnmz', plugin_dir_url(__FILE__) . "../../css/front/default/buttons.css");
	wp_enqueue_style( 'adt_animate_two', plugin_dir_url(__FILE__) . "../../css/front/animate/animate.min.css");
	wp_enqueue_script( 'adtfrontmain_js', plugin_dir_url(__FILE__) . '../../js/front/mainfront.js', array('jquery'), '1.0.0', true );
	wp_enqueue_style( 'adt_main_style' . $id, plugin_dir_url(__FILE__) . "../../css/front/default/main.css");	
	wp_enqueue_script( 'tracker_js', plugin_dir_url(__FILE__) . '../../js/front/tracker.js', array('jquery'), '1.0.0', true );	
	wp_localize_script( 'tracker_js', 'adtSecureSubmit', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'security' => wp_create_nonce('adt-secure-submit')
	));
	
	/* $keyoption = get_option("wpad_activation_key_val"); */
	$adtfrontend = "";
	$ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "none";
	// AD ELEMENTS	wait_ajax_process.gif
$adtfrontend .= '<div id="adt_front_wrapper' . $id . '" class="adtwholewrapper adtwholewrapper' . $id . '">';
$adtfrontend .= '<div class="adtwholewrappersecond" style="display: block;" id="adt_front_wrappersecond' . $id . '">';
//tracker
$adtfrontend .= '<span class="wait_ajaxprocess_wrapper"><img class="wait_ajax_process" src="' . plugin_dir_url(__FILE__) . "../../img/wait_ajax_process.gif" . '"></span>';
$adtfrontend .= "<form class='trackingdata' style='display:none;'>";
$adtfrontend .= "<input type='hidden' class='adtid' name='id' value='" . $id . "'/>";
$adtfrontend .= "<input type='hidden' class='adttitle' name='name' value='". get_the_title($id) ."'/>";
$adtfrontend .= "<input type='hidden' class='adtcount' name='count' value='1'/>";
$adtfrontend .= "<input type='hidden' class='adtdate' name='date' value='". date("Y-m-d H:i:s") . "'/>";
$adtfrontend .= "<input type='hidden' class='adturlreferrer' name='ref' value='" . $ref . "'/>";
$adtfrontend .= "</form>";
$adtfrontend .= "<input type='hidden' class='continueview' name='' value='continue'/>";
$adtfrontend .= "<input type='hidden' class='continueclick' name='' value='continue'/>";
if((isset($adttrig['cls']) && $adttrig['cls'] == "clsbtn") || (isset($wa['strplaybtn']) && $wa['strplaybtn'] == "on")) {
		$adtfrontend .= '<div class="adt_closeminimize adt_closeminimize' . $id . '">';
			// Play Button	
			if(isset($wa['anim']) && $wa['anim'] != ""){
				if(in_array($wa['anim'], $wa)) {
				if(isset($wa['strplaybtn']) && $wa['strplaybtn'] == "on") {	
						$adtfrontend .= '<span class="adt_animebtn adt_animebtn' . $id . '" title="Play Animation"><img src="' . plugin_dir_url(__FILE__) . '../../img/animate.png"/></span>';
				?>		
						<script type="text/javascript">
							jQuery(document).ready(function($){								
								$(".adtwholewrapper").on("mouseleave touchend", function(){
										$(this).find(".adt_animebtn").hide();
								});	
								$(".adtwholewrapper").on("mouseenter touchmove", function(){
										$(this).find(".adt_animebtn").show().css("display", "inline-block");
								});
								var animationwa = "<?php echo $wa['anim']; ?> animated";
								<?php
									if(isset($wa['inneronly']) && $wa['inneronly'] == "on") {
									?>
									var thisclass = ".adtwholewrappersecond";
								<?php
									} else {
								?>
									var thisclass = ".adtwholewrapper";
								<?php
									}
								?>
								
								$(".adt_animebtn").on("mousedown touchstart", function(e){
									e.preventDefault();
									var theClassA = $(this).closest(thisclass).attr("id");
									var theid = theClassA.match(/\d+/);
									var id = "<?php echo $id; ?>";
									if(theid == id) {
									
										$(this).closest(thisclass).removeClass(animationwa).delay(0.000001).queue(function(next){ $(this).addClass(animationwa); next();});
										
										$(this).closest(thisclass).on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(e){$(this).removeClass(animationwa)});	
									}
								});
							
							});
						</script>
					<?php
				}
			 }
			}			
			// Close Button
			if(isset($adttrig['cls']) && $adttrig['cls'] == "clsbtn"){	
					$adtfrontend .= '<span class="adt_clsbtn adt_clsbtn' . $id . '" title="Close"><img src="' . plugin_dir_url(__FILE__) . '../../img/close.png"/></span>';
			}			
		$adtfrontend .= '</div>';
}

if( $htmlcodes != "") {
			$pattern = get_shortcode_regex();
				if (preg_match_all( '/'. $pattern .'/s', $htmlcodes, $matches ) && array_key_exists( 2, $matches )) {

					foreach($matches[0] as $i => $v){
						$htmlcodes = preg_replace($v , do_shortcode($v), $htmlcodes);
						$htmlcodes =  str_replace(array('[',']'), '', $htmlcodes);
					}
				}
					$adtfrontend .= $htmlcodes;
}	
	if(current_user_can('edit_posts') && !isset($adtdes['hideeditbtn'])) {
	$adtfrontend .= "<div class='edit_adt'><a href='" . home_url( '/' ) . "wp-admin/post.php?post=" . $id . "&action=edit" . "'>edit</a></div>";
	}
	$adtfrontend .= '</div>';
	$adtfrontend .= '</div><div class="clear"></div>';

?>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			var imgInside = $("#adt_front_wrapper<?php echo $id; ?>").find("img");
			if(imgInside.length > 0) {
				imgInside.each(function(){
					var thisimg = $(this);
					$(this).removeClass (function (index, css) {
						return (css.match (/(^|\s)wp-image-\S+/g) || []).join(' ');
					});
					$(this).removeClass (function (index, css) {
						return (css.match (/(^|\s)size-\S+/g) || []).join(' ');
					});
					$(this).removeClass (function (index, css) {
						return (css.match (/(^|\s)align\S+/g) || []).join(' ');
					});
					var thewidth = thisimg.attr("width") + "px";
					var theheight = thisimg.attr("height") + "px";
					thisimg.removeAttr("width").css("max-width", thewidth);
					thisimg.removeAttr("height").css("max-height", theheight);
					thisimg.css("display", "block");
				});
			}
		var parInside = $("#adt_front_wrapper<?php echo $id; ?>").find("p:first");
		if(parInside.length > 0) {
			parInside.replaceWith(parInside.html());
		}
		
		});
	</script>
	<?php	
	
$right = isset($adtdes['wpaddingright']) && $adtdes['wpaddingright'] != 0 ? $adtdes['wpaddingright'] + 2.5 . 'px' : '5px';
$top = isset($adtdes['wpaddingtop']) && $adtdes['wpaddingtop'] != 0 ? $adtdes['wpaddingtop'] + 2.5 . 'px' : '5px';
if(isset($adttrig['cls']) && $adttrig['cls'] == "clsbtn"){
	if(isset($adttrig['alwaysshow']) && $adttrig['alwaysshow'] == "on"){
	?>
		<style type="text/css">
			.adt_closeminimize<?php echo $id; ?> {
				right: <?php echo $right; ?>;
				top: <?php echo $top; ?>;
			}
		</style>
	<?php
	} else {
	?>
		<style type="text/css">
			.adt_closeminimize<?php echo $id; ?> {
			  display: none;
				right: <?php echo $right; ?>;
				top: <?php echo $top; ?>;
			}
		</style>
		<script type="text/javascript">
			jQuery(document).ready(function($){
					$(".adtwholewrapper").on("mouseleave touchend", function(){
						$(this).find(".adt_closeminimize<?php echo $id; ?>").hide();
					});
			});
		</script>
	<?php		
	}
} else {
	?>
		<style type="text/css">
			.adt_closeminimize<?php echo $id; ?> {
			  display: none;
				right: <?php echo $right; ?>;
				top: <?php echo $top; ?>;
			}
		</style>
	<?php		
}	 
?>
<style type="text/css">
.edit_adt {
bottom:  <?php echo $top; ?>;
left:  <?php echo $right; ?>;
}
</style>
<?php

/* ADT CLOSE TRIGGERS */
if(is_array($adttrig)) {
	if(isset($adttrig['cls']) && $adttrig['cls'] == "delay") {					
		if(isset($adttrig['cntdwntime']) && $adttrig['cntdwntime'] != ""){
			?>
			<script type="text/javascript">
				(function($){
				$.fn.removeIt = function(){	
				var x = this;
				var theV = x.attr("id");
				var vxid = theV.match(/\d+/);
				var vid = "<?php echo $id; ?>";
				if(vxid == vid) {
					function rmv(){
						x.fadeOut(1000, function(){ $(this).addClass("noneImportant");});
					}
					var delayrmv = "<?php echo $adttrig['cntdwntime'] * 1000; ?>";
					setTimeout(rmv, delayrmv);
				}		
				}
				}( jQuery ));
			</script>
			<?php 
		}
	}
}
		/*******************************************************************************************************
														ANIMATION
		********************************************************************************************************/	
?>
<script type="text/javascript">
jQuery(document).ready(function($){	
	window.animatestop = function(e) {
		var theClassV = $(this).attr("id");
		var thisid = theClassV.match(/\d+/);
		var eid = "<?php echo $id; ?>";
		if(thisid == eid) {
	<?php
		if(is_array($wa)) {
				//animation
		 if(isset($wa['anim']) && $wa['anim'] != ""){
			if(in_array($wa['anim'], $wa)) {
	?>				
			<?php
				if(isset($wa['inneronly']) && $wa['inneronly'] == "on") {
				?>
				var thiselem = $(this).find(".adtwholewrappersecond");
				var addclasses = "adtwholewrappersecond";
			<?php
				} else {
			?>
				var thiselem = $(this);
				var addclasses = "adtwholewrapper adtplacement" + thisid;
			<?php
				}
			?>
			 thiselem.removeClass().addClass(addclasses);
	<?php
			}
		  }
		 }
	?>
		}		
	}
});
</script>
<script type="text/javascript">
	jQuery(document).ready(function($){	
	window.animaterule = function(e) {
	var theClassD = $(this).attr("id");
	var theid = theClassD.match(/\d+/);
	var id = "<?php echo $id; ?>";
	if(theid == id) {

<?php
		/************************************************ WHOLE AD ***********************************************/
		
		if(is_array($wa)) {
			//animation
			if(isset($wa['anim']) && $wa['anim'] != ""){
			if(in_array($wa['anim'], $wa)) {
			?>				
				var animation = "<?php echo $wa['anim']; ?> animated";
				
			<?php
				if(isset($wa['inneronly']) && $wa['inneronly'] == "on") {
				?>
				var thiselem = $(this).find(".adtwholewrappersecond");
				var addclasses = "adtwholewrappersecond";
			<?php
				} else {
			?>
				var thiselem = $(this);
				var addclasses = "adtwholewrapper adtplacement" + theid;
			<?php
				}
			?>

			<?php
			// start
				// Immediate
				if(isset($wa['strtimdte']) && $wa['strtimdte'] == "on"){
					?>
					thiselem.on("fadeIn", function() {
							if(!thiselem.is(animation)) { thiselem.addClass(animation).removeIt(); }
					});
					<?php
				} 
				// On Scroll
				if(isset($wa['stronscrll']) && $wa['stronscrll'] == "on"){
					if(isset($wa['stroscr'])){
						if($wa['stroscr'] == "custompixels"){
							if(isset($wa['cstpxlval']) && $wa['cstpxlval'] != ""){
					?>
					var limit = "<?php echo $wa['cstpxlval']; ?>";					
					$(window).on("scroll touchmove", function(e){
						if($(document).height() - $(window).height() - $(window).scrollTop() <= limit) {
							if(!thiselem.is(animation) && thiselem.css("display") != "none") { thiselem.addClass(animation).removeIt(); }
						}
					});
					<?php							
							}
						} 						
					}
				}							
						
			 }
			}		
		}

?>

thiselem.on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(e){ $(this).removeClass(animation);});
			}
		};
	});
</script>			
<?php
		/*******************************************************************************************************
														End ANIMATION
		********************************************************************************************************/

/******************************************************************************************************************/

		/*******************************************************************************************************
														ADT SHOW TRIGGERS
		********************************************************************************************************/
// $addtrigarr = array_filter($adttrig);
if(is_array($adttrig)) {
?>
<script type="text/javascript">
	jQuery(document).ready(function($){
			$("#adt_front_wrapper<?php echo $id; ?>").hide();
			<?php if(isset($adtdes['woverflowmove']) && $adtdes['woverflowmove'] == "on") { ?>
				$('html').css("overflowX", "hidden");
			<?php } ?>
	});
</script>
<?php	
	if(isset($adttrig['optrigopl']) && $adttrig['optrigopl'] == "on"){
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
					$("#adt_front_wrapper<?php echo $id; ?>").removeClass("noneImportant").css("display","table");
					<?php if(isset($adtplace['adtwpospred']) && ($adtplace['adtwpospred'] == "center_left" || $adtplace['adtwpospred'] == "center" || $adtplace['adtwpospred'] == "center_right")) {
						if(isset($adtdes['wauto']) || !isset($adtdes['wwidth']) || (isset($adtdes['wwidth']) && $adtdes['wwidth'] == "")) { 
					?>
						var innerwidth = $("#adt_front_wrappersecond<?php echo $id; ?>").outerWidth();
					<?php
						}
						if(isset($adtdes['hauto']) || !isset($adtdes['wheight']) || (isset($adtdes['wheight']) && $adtdes['wheight'] == "")) { 
					?>
						var innerheight = $("#adt_front_wrappersecond<?php echo $id; ?>").outerHeight();
					<?php
						}					
					} 
					?>
					$("#adt_front_wrapper<?php echo $id; ?>").addClass("adtplacement<?php echo $id; ?>");
					if(typeof innerwidth != "undefined") {	
						$("#adt_front_wrapper<?php echo $id; ?>").css("width", innerwidth);						
					}
					if(typeof innerheight != "undefined") {	
						$("#adt_front_wrapper<?php echo $id; ?>").css("height", innerheight);						
					}
					$("#adt_front_wrapper<?php echo $id; ?>").fadeIn(100, animaterule);
			});
		</script>
		<?php
	} else {
	?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
					$("#adt_front_wrapper<?php echo $id; ?>").fadeOut(1, animaterule);
			});
		</script>
		<?php	
	}
		
		if(isset($adttrig['onscrll']) && $adttrig['onscrll'] == "on"){
			if(isset($adttrig['onscrllslt'])){
				if($adttrig['onscrllslt'] == "custompixels") {
					if(isset($adttrig['oscstmval']) && $adttrig['oscstmval'] != "") {
				?>
					<script type="text/javascript">
						jQuery(document).ready(function($){
						var limittrig = "<?php echo $adttrig['oscstmval']; ?>";
							$(window).on("scroll touchmove", function(e){
							if($("#adt_front_wrapper<?php echo $id; ?>").length) {	
								if($(document).height() - $(window).height() - $(window).scrollTop() <= limittrig) {
									if($("#adt_front_wrapper<?php echo $id; ?>").css('display') == 'none') {
										$("#adt_front_wrapper<?php echo $id; ?>").removeClass("noneImportant").css("display","table");
					<?php if(isset($adtplace['adtwpospred']) && ($adtplace['adtwpospred'] == "center_left" || $adtplace['adtwpospred'] == "center" || $adtplace['adtwpospred'] == "center_right")) {
						if(isset($adtdes['wauto']) || !isset($adtdes['wwidth']) || (isset($adtdes['wwidth']) && $adtdes['wwidth'] == "")) { 
					?>
						var innerwidth = $("#adt_front_wrappersecond<?php echo $id; ?>").outerWidth();
					<?php
						}
						if(isset($adtdes['hauto']) || !isset($adtdes['wheight']) || (isset($adtdes['wheight']) && $adtdes['wheight'] == "")) { 
					?>
						var innerheight = $("#adt_front_wrappersecond<?php echo $id; ?>").outerHeight();
					<?php
						}					
					} 
					?>
					$("#adt_front_wrapper<?php echo $id; ?>").addClass("adtplacement<?php echo $id; ?> adtwholewrapper");
					if(typeof innerwidth != "undefined") {	
						$("#adt_front_wrapper<?php echo $id; ?>").css("width", innerwidth);						
					}
					if(typeof innerheight != "undefined") {	
						$("#adt_front_wrapper<?php echo $id; ?>").css("height", innerheight);						
					}
					$("#adt_front_wrapper<?php echo $id; ?>").fadeIn(100, animaterule);
									}
								} else if($(document).height() - $(window).height() - $(window).scrollTop() > limittrig){
					<?php
					if((isset($adttrig['nevercls']) && $adttrig['nevercls'] != "never") || !isset($adttrig['nevercls'])){
					?>
						if($("#adt_front_wrapper<?php echo $id; ?>").css('display') != 'none') {
							$("#adt_front_wrapper<?php echo $id; ?>").fadeOut(100, animatestop).addClass("noneImportant");
						}					
					<?php					
					}								
					?>
								}
							}
							});
						});
					</script>			
				<?php 
					}
				}
			}
		}
	
		/*******************************************************************************************************
													End ADT SHOW TRIGGERS
		********************************************************************************************************/

/* ADT CLOSE TRIGGERS */

	if(isset($adttrig['cls']) && $adttrig['cls'] == "delay") {					
		if(isset($adttrig['cntdwntime']) && $adttrig['cntdwntime'] != ""){
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					function rmv(){
						$("#adt_front_wrapper<?php echo $id; ?>").hide();
					}
					var delayrmv = "<?php echo $adttrig['cntdwntime'] * 1000; ?>";
					setTimeout(rmv, delayrmv);
				});
			</script>			
			<?php 
		}
	}
}
/* End ADT CLOSE TRIGGERS */

	return $adtfrontend;
	
	}
}
new wpadt_adtShowShortcode();
?>