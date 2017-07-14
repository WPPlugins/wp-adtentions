<?php
class wpadt_adtDisplayControl{
	function __construct(){
	$this->wpadt_hook();
	}
	
	function wpadt_hook(){
	add_action( 'add_meta_boxes', array( $this, 'wpadt_container' ) );
	}
	
	function wpadt_container($post_type){
				$post_types = array('wp_adtentions');
					if ( in_array( $post_type, $post_types )) {
						add_meta_box(
								'adt_displaycontrol'
								,__( 'DISPLAY', 'adtentions' )
								,array( $this, 'wpadt_content' )
								,$post_type
								,'normal',
								'low'
						);	
					} 
	}
	
	function wpadt_content($post){
	global $wpdb, $post, $reqapi, $poid;
	$adtplace = get_post_meta($poid, "adt_display_adplacement", true);
	$adttrig = get_post_meta($poid, "adt_show_hidetrigger", true);	
	$wa = get_post_meta($poid, "adt_show_wholeadanimation", true);
	$cssval = get_post_meta($poid, "_adtdes_array_values", true);
	
	$animvals = array('none', "basicRotate", "circular", "roll", 'hinge', 'rollOut', 'zoomOut');
	
	$animlabels = array('None', "Basic Rotate", "Circular", "Roll", 'Hinge', 'Roll Out', 'Zoom Out');
	
?>
<div data-accordion-group>

	<!-- Ad PLACEMENT -->
    <div class="accordion" data-accordion>
        <div data-control class="data-control"><b>Placement</b></div>
        <div data-content>
			<div>
    <div class="accordion" data-accordion>
        <div data-control class="data-control-content"><b>Fly</b></div>
        <div data-content>
			<div>
			
			<div class="csspropcontainer adtwpostypr">
			<b>Position:</b>
				<ul class="adtwrappersltposition">
				<li>
				<input type="radio" name="adtdap[adtwpostype]" value="adtwpostypepred" id="adtwpostypepred" <?php echo isset($adtplace['adtwpostype']) && $adtplace['adtwpostype'] == "adtwpostypepred" ? 'checked' : ''; ?>/>
				<label for="adtwpostypepred" class="adt_bigger"> Predefined </label>
				</li>
				<li>
				<input type="radio" name="adtdap[adtwpostype]" value="adtwposshortcode" id="adtwposshortcode" <?php echo isset($adtplace['adtwpostype']) && $adtplace['adtwpostype'] == "adtwposshortcode" ? 'checked' : ''; ?>/>
				<label for="adtwposshortcode" class="adt_bigger"> Use Shortcode </label>				
				</li>		
				</ul>
			<hr>				
				<div id="adtpredefinedpos">
				<h2>Predefined:</h2>
				<ul class="adtwrapperpredposition">
				<li>
				<input type="radio" name="adtdap[adtwpospred]" value="top_left" class="adtwrapperradio" id="adttop_left" <?php echo isset($adtplace['adtwpospred']) && $adtplace['adtwpospred'] == "top_left" ? 'checked' : ''; ?>/>
				<label for="adttop_left"> Top Left </label>
				</li>
				<li>
				<input type="radio" name="adtdap[adtwpospred]" value="top_middle" class="adtwrapperradio" id="adttop_middle" <?php echo isset($adtplace['adtwpospred']) && $adtplace['adtwpospred'] == "top_middle" ? 'checked' : ''; ?>/>
				<label for="adttop_middle"> Top Middle </label>				
				</li>
				<li>
				<input type="radio" name="adtdap[adtwpospred]" value="top_right" class="adtwrapperradio" id="adttop_right" <?php echo isset($adtplace['adtwpospred']) && $adtplace['adtwpospred'] == "top_right" ? 'checked' : ''; ?>/>
				<label for="adttop_right"> Top Right </label>
				</li>
				<li>
				<input type="radio" name="adtdap[adtwpospred]" value="center_left" class="adtwrapperradio" id="adtcenter_left" <?php echo isset($adtplace['adtwpospred']) && $adtplace['adtwpospred'] == "center_left" ? 'checked' : ''; ?>/>
				<label for="adtcenter_left"> Center Left </label>
				</li>
				<li>
				<input type="radio" name="adtdap[adtwpospred]" value="center" class="adtwrapperradio" id="adtcenter" <?php echo isset($adtplace['adtwpospred']) && $adtplace['adtwpospred'] == "center" ? 'checked' : ''; ?>/>
				<label for="adtcenter"> Center </label>
				</li>
				<li>
				<input type="radio" name="adtdap[adtwpospred]" value="center_right" class="adtwrapperradio" id="adtcenter_right" <?php echo isset($adtplace['adtwpospred']) && $adtplace['adtwpospred'] == "center_right" ? 'checked' : ''; ?>/>
				<label for="adtcenter_right"> Center Right</label>
				</li>
				<li>
				<input type="radio" name="adtdap[adtwpospred]" value="bottom_left" class="adtwrapperradio" id="adtbottom_left" <?php echo isset($adtplace['adtwpospred']) && $adtplace['adtwpospred'] == "bottom_left" ? 'checked' : ''; ?>/>
				<label for="adtbottom_left"> Bottom Left </label>
				</li>
				<li>
				<input type="radio" name="adtdap[adtwpospred]" value="bottom_middle" class="adtwrapperradio" id="adtbottom_middle" <?php echo isset($adtplace['adtwpospred']) && $adtplace['adtwpospred'] == "bottom_middle" ? 'checked' : ''; ?>/>
				<label for="adtbottom_middle"> Bottom Middle </label>
				</li>
				<li>
				<input type="radio" name="adtdap[adtwpospred]" value="bottom_right" class="adtwrapperradio" id="adtbottom_right" <?php echo isset($adtplace['adtwpospred']) && $adtplace['adtwpospred'] == "bottom_right" ? 'checked' : ''; ?>/>
				<label for="adtbottom_right"> Bottom Right </label>
				</li>
				</ul>
				</div>	
				
				<div id="adtpredefinedposmargin">
				<b>Add distance:</b><p></p>
					<div class="shadowcontainer csspropcontainer">
					<b>Top:</b>
					<br/>
					<input type="text" name="adtdap[wmargintop]" value="<?php echo isset($adtplace['wmargintop']) && $adtplace['wmargintop'] != "" ? $adtplace['wmargintop'] : 0; ?>" size="2" class="adtslidersmall_value"/>
					<div class="slidersmall"></div>
					</div>

					<div class="shadowcontainer csspropcontainer">
					<b>Right:</b>
					<br/>
					<input type="text" name="adtdap[wmarginright]" value="<?php echo isset($adtplace['wmarginright']) && $adtplace['wmarginright'] != "" ? $adtplace['wmarginright'] : 0; ?>" size="2" class="adtslidersmall_value"/>
					<div class="slidersmall"></div>
					</div>
					
					<div class="shadowcontainer csspropcontainer">
					<b>Bottom:</b>
					<br/>
					<input type="text" name="adtdap[wmarginbottom]" value="<?php echo isset($adtplace['wmarginbottom']) && $adtplace['wmarginbottom'] != "" ? $adtplace['wmarginbottom'] : 0; ?>" size="2" class="adtslidersmall_value"/>
					<div class="slidersmall"></div>
					</div>
					
					<div class="shadowcontainer csspropcontainer">
					<b>Left:</b>
					<br/>
					<input type="text" name="adtdap[wmarginleft]" value="<?php echo isset($adtplace['wmarginleft']) && $adtplace['wmarginleft'] != "" ? $adtplace['wmarginleft'] : 0; ?>" size="2" class="adtslidersmall_value"/>
					<div class="slidersmall"></div>
					</div>
				</div>	
				<p>	
				<hr></hr>
				<div class="clear"></div>
			</div>		

			</div>
		</div>
			</div>	

			</div>
		</div>
	</div>
	
	<!-- TRIGGER -->
<div class="accordion" data-accordion>
        <div data-control class="data-control"><b>Show/Hide Trigger</b></div>
        <div data-content>
			<div class="row_container">
			
			<div class="csspropcontainer adtuserhelper">
			<h2>Combine them or select which one you like!</h2>
			</div>
			
    <div class="accordion" data-accordion>
        <div data-control class="data-control-content"><b>Open trigger</b></div>
        <div data-content>
			<div class="row_container">
			
			<div class="csspropcontainer">
			<input type="checkbox" name="adttrig[optrigopl]" value="on" id="onpageload" <?php echo isset($adttrig['optrigopl']) && $adttrig['optrigopl'] == "on" ? 'checked' : ''; ?>/> <label for="onpageload">Immediate/ On Page Load</label>
			</div>	

			<div class="csspropcontainer">
			<input type="checkbox" name="adttrig[onscrll]" value="on" id="adttrigonscrll" <?php echo isset($adttrig['onscrll']) && $adttrig['onscrll'] == "on" ? 'checked' : ''; ?>/> <label for="adttrigonscrll" class="adt_bigger">On Page Scroll:</label>
			<hr>
			
			
			<p></p>
			<input type="text" size="2" name="adttrig[oscstmval]" value="<?php echo isset($adttrig['oscstmval']) && $adttrig['oscstmval'] != "" ? $adttrig['oscstmval'] : ''; ?>" id="adttrigoscstmval" class="adtslider_value"/>
			<input type="radio" name="adttrig[onscrllslt]" value="custompixels" id="adttrigoscstmon" <?php echo isset($adttrig['onscrllslt']) && $adttrig['onscrllslt'] == "custompixels" ? 'checked' : ''; ?>/> 
			<label for="adttrigoscstmon">pixels before bottom of page</label>
			<div class="slider"></div>
			</div>			
			</div>
		</div>
	</div>

    <div class="accordion" data-accordion>
        <div data-control class="data-control-content"><b>Close trigger</b></div>
        <div data-content>
			<div class="row_container">
			<div class="csspropcontainer">
			<input type="radio" name="adttrig[cls]" value="clsbtn" id="adttrigclsuscho" <?php echo isset($adttrig['cls']) && $adttrig['cls'] == "clsbtn" ? 'checked' : ''; ?>/> <label for="adttrigclsuscho">Close button</label>
			<input type="checkbox" name="adttrig[alwaysshow]" value="on" id="alwaysshowclsbtn" <?php echo isset($adttrig['alwaysshow']) && $adttrig['alwaysshow'] == "on" ? 'checked' : ''; ?>/> <label for="alwaysshowclsbtn">Always show</label>
			</div>	

			<div class="csspropcontainer">
			<input type="radio" name="adttrig[cls]" value="delay" id="adttrigclstimer" <?php echo isset($adttrig['cls']) && $adttrig['cls'] == "delay" ? 'checked' : ''; ?>/> <label for="adttrigclstimer">Delay</label> - (this can take effect only if adtention is not hidden before the times below!)
			<hr>
			<label for="adttrigcntdwntime">After:</label>
			<input type="text" size="2" name="adttrig[cntdwntime]" value="<?php echo isset($adttrig['cntdwntime']) && $adttrig['cntdwntime'] != "" ? $adttrig['cntdwntime'] : ''; ?>" id="adttrigcntdwntime" class="adtslider_value"/>
			<label for="adttrigcntdwntime">seconds</label>
			<div class="slider"></div>
			</div>
			</div>
		</div>
	</div>
	
			</div>
		</div>
	</div>	
	
	<!-- ANIMATION -->
    <div class="accordion" data-accordion>
        <div data-control class="data-control"><b>Animation</b></div>
        <div data-content>
			<div class="row_container">
					<div class="accordion" data-accordion>
						<div data-control class="data-control-content-children"><b>Select Animation</b></div>
						<div data-content>
							<div class="row_container">
							<input type="checkbox" name="wa[inneronly]" value="on" id="inneronly" <?php echo isset($wa['inneronly']) && $wa['inneronly'] == "on" ? 'checked' : ''; ?>/> <label for="inneronly">Animate inner content only</label>
							<button id="wrapperanim" class="button button-small anim">Preview Animation</button>	
							<div class="clear"></div>
								<div class="csspropcontainerchildren">
						<select class="adtsltmultiple wa_anim" name="wa[anim]">	
						<?php
						foreach($animvals as $key => $optval){
						?>
							<option value="<?php echo $optval; ?>" <?php echo isset($wa['anim']) && $wa['anim'] == $optval ? 'selected' : ''; ?>><?php echo $animlabels[$key]; ?></option>
						<?php
						}
						?>
						</select>		
								</div>
								<div id="previewanimationbox">
								<div class="previewanimationbox"></div>
								</div>
								
							</div>
						</div>
					</div>

					<div class="accordion" data-accordion>
						<div data-control class="data-control-content-children"><b>Animation trigger</b></div>
						<div data-content>
							<div class="row_container">
					<div class="accordion" data-accordion>
						<div data-control class="data-control-content-children-inner"><b>Start</b></div>
						<div data-content>
							<div class="row_container">
			
			<div class="csspropcontainer">
			<input type="checkbox" name="wa[strtimdte]" value="on" id="wastrtimdte" <?php echo isset($wa['strtimdte']) && $wa['strtimdte'] == "on" ? 'checked' : ''; ?>/> <label for="wastrtimdte">Immediate</label>
			</div>	

			<div class="csspropcontainer">
			<input type="checkbox" name="wa[stronscrll]" value="on" id="wastronscrll" <?php echo isset($wa['stronscrll']) && $wa['stronscrll'] == "on" ? 'checked' : ''; ?>/> <label for="wastronscrll" class="adt_bigger">On Page Scroll:</label>
			<hr>
			<p></p>
			<input type="text" size="2" name="wa[cstpxlval]" value="<?php echo isset($wa['cstpxlval']) && $wa['cstpxlval'] != "" ? $wa['cstpxlval'] : ''; ?>" id="wacstpxlval" class="adtslider_value"/>
			<input type="radio" name="wa[stroscr]" value="custompixels" id="wacustompixels" <?php echo isset($wa['stroscr']) && $wa['stroscr'] == "custompixels" ? 'checked' : ''; ?>/> 
			<label for="wacustompixels">pixels before bottom of page</label>
			<div class="slider"></div>
			</div>	
							</div>
						</div>
					</div>			
					
						</div>
						</div>
					</div>
			</div>
		</div>
	</div>		
	
	
</div>
	
<?php
	 
	}

}
new wpadt_adtDisplayControl();
?>