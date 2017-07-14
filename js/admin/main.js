jQuery(document).ready(function($){

$(".adtshortcode_container, .adtshortcodecontainer").on("click", function(){	
$(this).select();	
});

	function getContrastYIQ(hexcolor){
		var r = parseInt(hexcolor.substr(0,2),16);
		var g = parseInt(hexcolor.substr(2,2),16);
		var b = parseInt(hexcolor.substr(4,2),16);
		var yiq = ((r*299)+(g*587)+(b*114))/1000;
		return (yiq >= 175) ? 'black' : 'white';
	}
	$(".adtagrbbrcolor").each(function(){
		$(this).iris({
			change: function(event, ui) {	
			$(this).css( 'background', ui.color.toString());
			var hexcolor = ui.color.toString().substring(1);	
			var tr = getContrastYIQ(hexcolor);
				$(this).css( 'color', tr);
			}
		});
		$(this).css( 'background', $(this).val());
		var pathname = window.location.pathname;
			if(pathname.indexOf('/edit.php') < 1) {
				var hexcolor = $(this).val().substring(1);
				var tr = getContrastYIQ(hexcolor);
			}
				$(this).css( 'color', tr);
			$(document).on('click', function (e) {
				if (!$(e.target).is(".adtagrbbrcolor, .iris-picker, .iris-picker-inner")) {
					$(".adtagrbbrcolor").iris('hide');  
				}
			});
			
			$(this).on('click', function (event) {
				$(this).iris('show');
			});
	});

	$('.accordion').accordion({
		"transitionSpeed": 400,
		"singleOpen" : false
	});
	
$("#adtwpostypecust").on("change", function(){
	var pred = $(this).closest(".csspropcontainer").find(".adtwrapperradio");	
	if($(this).is(":checked")){
		pred.prop("checked", false);
	} else {
		pred.removeAttr("checked");	
	}
});

$(".adtwrapperradio").on("change", function(){
	var pred = $(this).closest(".csspropcontainer").find("#adtwpostypepred");
	var custom = $(this).closest(".csspropcontainer").find("#adtwpostypecust");	
	if($(this).is(":checked")){
		custom.prop("checked", false);
		pred.prop("checked", true);
	} else {
		custom.removeAttr("checked");	
	}
});

$(".adtwrposa, .adtwrposb").on("change, keyup", function(){
	var pred = $(this).closest(".adtwpostypr").find("#adtwpostypepred, .adtwrapperradio");
	var custom = $(this).closest(".adtwpostypr").find("#adtwpostypecust");
		pred.prop("checked", false);
		custom.prop("checked", true);
});


/* Front Element Selector */
	$('html').niceScroll();
});