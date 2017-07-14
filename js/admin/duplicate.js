jQuery(document).ready(function($){
	$(".cloneadt_item").on("click", function(e){
		e.preventDefault();
		$(this).hide();
		$(this).prev("span").show();
		var id = $(this).attr("pid");
		var nonce = $(this).attr("nonce");
		var status = $(this).attr("status");
		var postype = $(this).attr("postype");
		// alert();
		var data = {
			'action' : 'clone_ad',
			'pid' : id,
			 security : nonce,
			'nonce': nonce,
			'status': status,
			'postype': postype
		};
		
		$.post(ajaxurl, data, function(response){
			window.location.href=window.location.href;
		});
	});
});