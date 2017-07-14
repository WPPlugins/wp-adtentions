jQuery(document).ready(function($){

	$("#wrapperanim").on("click", function(e){
		e.preventDefault();
		var sltval = $(".wa_anim").val();
				$(".previewanimationbox").css({"z-index": 999999}).addClass(sltval + " animated");
		$(".previewanimationbox").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){$(".previewanimationbox").removeClass(sltval + " animated").removeAttr("style");});
	});
	
	$(".wa_anim").on("change", function(e){
		e.preventDefault();
		var sltval = $(this).val();
				$(".previewanimationbox").css({"z-index": 999999}).addClass(sltval + " animated");
		$(".previewanimationbox").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){$(".previewanimationbox").removeClass(sltval + " animated").removeAttr("style");});
	});	
	
});