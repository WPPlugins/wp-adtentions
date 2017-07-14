jQuery(document).ready(function($){
	$( ".slider" ).slider({
		range: "max",
		min: 0,
		max: 1000,
		value: $(this).closest(".csspropcontainer").find(".adtslider_value").val(),
		slide: function( event, ui ) {
		$(this).closest(".csspropcontainer").find(".adtslider_value").val(ui.value);
			if($(this).hasClass("adtwrposa")){
				var pred = $(this).closest(".adtwpostypr").find("#adtwpostypepred, .adtwrapperradio");
				var custom = $(this).closest(".adtwpostypr").find("#adtwpostypecust");
					if(custom.not(":checked")){
					pred.prop("checked", false);
					custom.prop("checked", true);			
					}
			}
		}
	});
	
	$(".adtslider_value").on("change, keyup", function(){
		$(this).closest(".csspropcontainer").find( ".slider" ).slider({
		value: $(this).val()
		});
	});
	
	$(".adtslider_value").each(function(i, v){
	if(!$(this).hasClass("adtagrbbrcolor")) {
		$(this).closest(".csspropcontainer").find( ".slider" ).slider({
		value: $(this).val()
		});
	}
	});	
	
	
	$( ".slidersmall" ).slider({
		range: "max",
		min: 0,
		max: 10,
		value: $(this).closest(".csspropcontainer").find(".adtslidersmall_value").val(),
		slide: function( event, ui ) {
		$(this).closest(".csspropcontainer").find(".adtslidersmall_value").val(ui.value);
		}
	});
	
	$(".adtslider_value").on("change, keyup", function(){
		$(this).closest(".csspropcontainer").find( ".slidersmall" ).slider({
		value: $(this).val()
		});
	});
	
	$(".adtslidersmall_value").each(function(i, v){
	if(!$(this).hasClass("adtagrbbrcolor")) {
		$(this).closest(".csspropcontainer").find( ".slidersmall" ).slider({
		value: $(this).val()
		});
	}
	});
	
});