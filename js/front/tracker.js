jQuery(document).ready(function($){

/*View Counter*/
	function adtfrontviewsajaxer(){
		$(".adtwholewrapper").each(function(){
			var thisad = $(this);
			var viewsign = thisad.find(".continueview");
			var appear = $(window).scrollTop() >= thisad.offset().top + thisad.outerHeight() - window.innerHeight;
			if(viewsign.length) {
				if(thisad.css("display") != "none"){
					if(appear){
					viewsign.remove();	
					var array = thisad.find(".trackingdata").serialize();
							var data = {
								'action' : 'trackadperformance',
								security: adtSecureSubmit.security,
								'view' : true,
								'array' : array
							};			
							$.post(adtSecureSubmit.ajaxurl, data, function(response){
								
							});
					}
				}
			}		
		});	
	}
	
	adtfrontviewsajaxer();
	
	$(window).on("scroll touchmove", function(e){
		adtfrontviewsajaxer();
	});
	
	$(document).on("mousemove mouseenter mouseleave touchstart touchmove touchend mousedown", function(e){
		adtfrontviewsajaxer();
	});	
	
/*Click Counter*/	
		$(".adtwholewrapper").each(function(){
				var thisad = $(this);
				var url = thisad.find("a");
				var array = thisad.find(".trackingdata").serialize();
			url.each(function() {	
				$(this).on("click touchstart", function(e){
					if($(e.target).parent().is(".edit_adt")) {
						window.location = $(this).attr("href");
						return;
					}
					$(this).closest(".adtwholewrapper").find(".wait_ajaxprocess_wrapper").show();
				var urlval = $(this).attr("href");
				var clicksign = thisad.find(".continueclick");
				if(clicksign.length) {
				  clicksign.remove();
					e.preventDefault();
					var blank = $(this).attr("target");
					var data = {
						'action' : 'trackadperformance',
						security: adtSecureSubmit.security,
						'click' : true,
						'array' : array
					};			
					$.post(adtSecureSubmit.ajaxurl, data, function(response){
						
							if(blank == "_blank") { 
								var popup = window.open(urlval,true);
								 setTimeout( function() {
									if(!popup || popup.outerHeight === 0) {
									alert("Please disable popup blocker for this site for your better experience!");
										window.location = urlval;
									} else {
										var openurl = window.open(urlval, '_blank');
										openurl.focus();
									} 
								}, 10);
							} else {
								window.location = urlval;
							}									
					});
				  }
				});
			});
			thisad.on("click touchstart", function(e){
			if($(e.target).parent().is(".adt_clsbtn")) {
				return;
			}
			var clicksign = thisad.find(".continueclick");	
			if(clicksign.length) {
			  clicksign.remove();
				e.preventDefault();
				var data = {
					'action' : 'trackadperformance',
					security: adtSecureSubmit.security,
					'click' : true,
					'array' : array
				};			
				$.post(adtSecureSubmit.ajaxurl, data, function(response){
														
				});
			  }
			});	
		});		
	

});