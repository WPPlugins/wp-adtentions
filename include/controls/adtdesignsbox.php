<?php
class wpadt_adtDesignsBox {

	function __construct(){
		$this->wpadt_tocall();
	}

	function wpadt_tocall(){
		add_action( 'add_meta_boxes', array($this, 'wpadt_container'));
	}

// End AJAX
	function wpadt_container($post_type) {
	
		$post_types = array('wp_adtentions');
		
			if ( in_array( $post_type, $post_types )) {
				
				// CUSTOM PUBLISH BOX
				add_meta_box(
					'designs_box'
					,__( 'DESIGNS', 'adtentions' )
					,array( $this, 'wpadt_baseElement' )
					,$post_type
					,'normal'
					,'low'
				);
			}
	}
	
	function wpadt_baseElement($post) {
	global $post, $poid, $reqapi;
	$cssval = get_post_meta($poid, "_adtdes_array_values", true);
	?>	
<div data-accordion-group>
    <div class="accordion" data-accordion>
        <div data-control class="data-control"><b>Container</b></div>
        <div data-content>
		<div>
			<div class="csspropcontainer designerwrapper">
			<input type="checkbox" name="adtdes[woverflowmove]" value="on" id="woverflowmove" <?php echo isset($cssval['woverflowmove']) && $cssval['woverflowmove'] == "on" ? 'checked' : ''; ?>/> <label for="woverflowmove">Hide Over Flowing Move</label>
			<input type="checkbox" name="adtdes[woverflow]" value="on" id="woverflow" <?php echo isset($cssval['woverflow']) && $cssval['woverflow'] == "on" ? 'checked' : ''; ?>/> <label for="woverflow">Hide Over Flowing Content</label>
			<input type="checkbox" name="adtdes[centerinner]" value="on" id="centerinner" <?php echo isset($cssval['centerinner']) && $cssval['centerinner'] == "on" ? 'checked' : ''; ?>/> <label for="centerinner">Centerize Content</label>
			<input type="checkbox" name="adtdes[hideeditbtn]" value="on" id="hideeditbtn" <?php echo isset($cssval['hideeditbtn']) && $cssval['hideeditbtn'] == "on" ? 'checked' : ''; ?>/> <label for="hideeditbtn">Hide Edit Button</label>
			</div>
		
			<div class="csspropcontainer">
			<b>Width:</b>
			<input type="checkbox" name="adtdes[wauto]" value="on" id="wauto" class="rightcheckbox" <?php echo (isset($cssval['wauto']) && $cssval['wauto'] == "on") || !is_array($cssval) ? 'checked' : ''; ?>/> <label for="wauto">None</label>	
			<hr>
			<input type="text" name="adtdes[wwidth]" value="<?php echo isset($cssval['wwidth']) && $cssval['wwidth'] != "" ? $cssval['wwidth'] : ""; ?>" size="2" class="adtslider_value"/>
			<select class="adtselect" name="adtdes[wwidthm]">
			<option value="px" <?php echo isset($cssval['wwidthm']) && $cssval['wwidthm'] == "px" ? 'selected' : ''; ?>>pixel</option>
			<option value="%" <?php echo isset($cssval['wwidthm']) && $cssval['wwidthm'] == "%" ? 'selected' : ''; ?>>%</option>
			</select>
			<div class="slider"></div>
			</div>
			
			<div class="csspropcontainer">
			<b>Height:</b>
			<input type="checkbox" name="adtdes[hauto]" value="on" id="hauto" class="rightcheckbox" <?php echo (isset($cssval['hauto']) && $cssval['hauto'] == "on") || !is_array($cssval) ? 'checked' : ''; ?>/> <label for="hauto">None</label>
			<hr>
			<input type="text" name="adtdes[wheight]" value="<?php echo isset($cssval['wheight']) && $cssval['wheight'] != "" ? $cssval['wheight'] : ""; ?>" size="2" class="adtslider_value"/>
			<select class="adtselect" name="adtdes[wheightm]">
			<option value="px" <?php echo isset($cssval['wheightm']) && $cssval['wheightm'] == "px" ? 'selected' : ''; ?>>pixel</option>
			<option value="%" <?php echo isset($cssval['wheightm']) && $cssval['wheightm'] == "%" ? 'selected' : ''; ?>>%</option>
			</select>
			<div class="slider"></div>
			</div>
			
			<div class="csspropcontainer">
			<b>Background color:</b>
			<input type="checkbox" name="adtdes[wbgnone]" value="on" id="wbgnone" class="rightcheckbox" <?php echo (isset($cssval['wbgnone']) && $cssval['wbgnone'] == "on") || !is_array($cssval) ? 'checked' : ''; ?>/> <label for="wbgnone">None</label>
			<hr>
			<input type="text" name="adtdes[wbgclr]" value="<?php echo isset($cssval['wbgclr']) && $cssval['wbgclr'] != "" ? $cssval['wbgclr'] : ""; ?>" size="5" class="adtslider_value adtagrbbrcolor"/>
			</div>
			
			<!--Padding-->
			<div class="csspropcontainer">
			<b>Padding:</b>
			<input type="checkbox" name="adtdes[wpaddingnone]" value="on" id="wpaddingnone" class="rightcheckbox" <?php echo isset($cssval['wpaddingnone']) && $cssval['wpaddingnone'] == "on" ? 'checked' : ''; ?>/> <label for="wpaddingnone">None</label>
			<hr>
			<div class="designerwrapper">
				<div class="shadowcontainer csspropcontainer">
				<b>Top:</b>
				<br/>
				<input type="text" name="adtdes[wpaddingtop]" value="<?php echo isset($cssval['wpaddingtop']) && $cssval['wpaddingtop'] != "" ? $cssval['wpaddingtop'] : 5; ?>" size="2" class="adtslidersmall_value"/>
				<div class="slidersmall"></div>
				</div>

				<div class="shadowcontainer csspropcontainer">
				<b>Right:</b>
				<br/>
				<input type="text" name="adtdes[wpaddingright]" value="<?php echo isset($cssval['wpaddingright']) && $cssval['wpaddingright'] != "" ? $cssval['wpaddingright'] : 5; ?>" size="2" class="adtslidersmall_value"/>
				<div class="slidersmall"></div>
				</div>
				
				<div class="shadowcontainer csspropcontainer">
				<b>Bottom:</b>
				<br/>
				<input type="text" name="adtdes[wpaddingbottom]" value="<?php echo isset($cssval['wpaddingbottom']) && $cssval['wpaddingbottom'] != "" ? $cssval['wpaddingbottom'] : 5; ?>" size="2" class="adtslidersmall_value"/>
				<div class="slidersmall"></div>
				</div>
				
				<div class="shadowcontainer csspropcontainer">
				<b>Left:</b>
				<br/>
				<input type="text" name="adtdes[wpaddingleft]" value="<?php echo isset($cssval['wpaddingleft']) && $cssval['wpaddingleft'] != "" ? $cssval['wpaddingleft'] : 5; ?>" size="2" class="adtslidersmall_value"/>
				<div class="slidersmall"></div>
				</div>
			</div>
			</div>
			
			<!--Shadow-->
			<div class="csspropcontainer shadowwrapper">
			<b>Shadow:</b>
			<input type="checkbox" name="adtdes[wshadow]" value="on" id="wshadow" class="rightcheckbox" <?php echo (isset($cssval['wshadow']) && $cssval['wshadow'] == "on") || !is_array($cssval) ? 'checked' : ''; ?>/> <label for="wshadow">None</label>
			<hr>
			<div id="shadowwrapper">
			<div class="shadowcontainer csspropcontainer">
			<b>Horizontal:</b>
			<br/>
			<input type="text" name="adtdes[wshdwhr]" value="<?php echo isset($cssval['wshdwhr']) && $cssval['wshdwhr'] != "" ? $cssval['wshdwhr'] : 0; ?>" size="2" class="adtslidersmall_value"/>
			<div class="slidersmall"></div>
			</div>

			<div class="shadowcontainer csspropcontainer">
			<b>Vertical:</b>
			<br/>
			<input type="text" name="adtdes[wshdwvr]" value="<?php echo isset($cssval['wshdwvr']) && $cssval['wshdwvr'] != "" ? $cssval['wshdwvr'] : 0; ?>" size="2" class="adtslidersmall_value"/>
			<div class="slidersmall"></div>
			</div>
			
			<div class="shadowcontainer csspropcontainer">
			<b>Blur:</b>
			<br/>
			<input type="text" name="adtdes[wshdwblr]" value="<?php echo isset($cssval['wshdwblr']) && $cssval['wshdwblr'] != "" ? $cssval['wshdwblr'] : 0; ?>" size="2" class="adtslidersmall_value"/>
			<div class="slidersmall"></div>
			</div>
			
			<div class="shadowcontainer csspropcontainer">
			<b>Spread:</b>
			<br/>
			<input type="text" name="adtdes[wshdwspr]" value="<?php echo isset($cssval['wshdwspr']) && $cssval['wshdwspr'] != "" ? $cssval['wshdwspr'] : 0; ?>" size="2" class="adtslidersmall_value"/>
			<div class="slidersmall"></div>
			</div>
			
			<div class="clear"></div>
			<div class="shadowclrcontainer csspropcontainer">
			<b>Color:</b>
			<br/>
			<input type="text" name="adtdes[wshdwclr]" value="<?php echo isset($cssval['wshdwclr']) && $cssval['wshdwclr'] != "" ? $cssval['wshdwclr'] : ""; ?>" size="5" class="adtslidersmall_value adtagrbbrcolor"/>
			</div>
			<div class="clear"></div>
			</div>
			</div>
		</div>
        </div>
    </div>
</div>	
	
	<?php
	}
}
new wpadt_adtDesignsBox();
?>