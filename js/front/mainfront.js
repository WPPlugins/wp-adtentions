jQuery(document).ready(function($){
	$(".adtwholewrapper").on("mouseenter touchmove", function(){
		$(this).find(".adt_closeminimize, .edit_adt").show();
	});
$(".adtwholewrapper").on("mouseleave touchend", function(){
		$(this).find(".edit_adt").hide();
});	
	$(".adt_clsbtn").on("click touchstart", function(e){
		e.preventDefault();
		$(this).closest(".adtwholewrapper").remove();
	});
});

(function ($) {
      $.each(['fadeIn', 'fadeOut'], function (i, ev) {
        var el = $.fn[ev];
        $.fn[ev] = function () {
          this.trigger(ev);
          return el.apply(this, arguments);
        };
      });
})(jQuery);