jQuery(document).ready(function($){
		var alls = Array("#exclude_home", "#home_only", "#exclude_archive", "#archive_only", ".ptype_epschkbox", ".tax_epschkbox", ".items_epschkbox");
		for(var i = 0; i < alls.length; i++) {
			if($(alls[i]).is(":checked")){
			$("#all_location").prop("checked", false);
			}
		}
		
		var any = Array(".ptype_epschkbox", ".tax_epschkbox", ".items_epschkbox");
			for(var i = 0; i < any.length; i++) {
				if($(any[i]).is(":checked")){
					var whether = $("#mainboard").find(".plus_minus");
					if(whether.html() == "+"){
					whether.html("-");
					}			
				}
			}
			
			$("#no_404_page").on('change', function(){
				if($(this).is(":checked")){
				$('#mainboard').find("#404_page").prop("checked", false);
				}		
			});
			
			$("#404_page").on('change', function(){
				if($(this).is(":checked")){
				$('#mainboard').find("#no_404_page").prop("checked", false);
				}		
			});
			
		function chekChecked(){
			//ALL LOCATION
			if($("#all_location").is(":checked")) {
				$("#exclude_home, #home_only, #exclude_archive, #archive_only, .ptype_epschkbox, .tax_epschkbox, .items_epschkbox").attr("disabled", true).prop("checked", false);
			}	
			
			if($("#exclude_home").is(":checked")) {
			$("#home_only").attr("disabled", true).prop("checked", false);
			}
			
			if($("#home_only").is(":checked")) {
			$("#exclude_home").attr("disabled", true).prop("checked", false);
			}
			
			if($("#exclude_archive").is(":checked")) {
			$("#archive_only").attr("disabled", true).prop("checked", false);
			}
			
			if($("#archive_only").is(":checked")) {
			$("#exclude_archive").attr("disabled", true).prop("checked", false);
			}

			if($('.ptype_epschkbox').is(":checked")){
			var allchk = $('.ptype_epschkbox:checked').closest(".ptype_nameli").find(".tax_epschkbox, .items_epschkbox");
			allchk.prop("checked", false).attr("disabled", true).prop("indeterminate", false);
			}
			
			
			// TAXONOMY
			if($(".tax_epschkbox").is(":checked")) {
			
				var taxonames = $(".tax_epschkbox:checked")
				.closest('.ptype_nameli')
				.find('.taxo_names').css("display");	
				var txn = $(".tax_epschkbox:checked")
				.closest('.ptype_nameli').find('.taxo_names');
				
				if(taxonames == 'none') {
					txn.show();	
					$(".tax_epschkbox:checked").closest('.ptype_nameli')
					.find('.ptype_name')
					.find('.plus_minus')
					.html('-');
				}
				
				
				var indp_items = $(".tax_epschkbox:checked")
				.closest('.ptype_nameli')
				.find('.independent_items');		
				var items_to_check = $(".tax_epschkbox:checked")
				.closest('.tax_parentsli')
				.find('.items_epschkbox');		
				var parent_to_check = $(".tax_epschkbox:checked")
				.closest('.ptype_nameli')
				.find('.ptype_epschkbox');			
				
					items_to_check.prop("checked", false).attr("disabled", true);
					parent_to_check.prop("indeterminate", true).prop("checked", false);	

				var tax_checkbox = $(".tax_epschkbox:checked").closest(".ptype_nameli").find('.tax_epschkbox');
				
				var all_checkbox = $(".tax_epschkbox:checked").closest(".ptype_nameli").find('.tax_epschkbox').length;
				var cbx_checked = $(".tax_epschkbox:checked").closest(".ptype_nameli").find('.tax_epschkbox:checked').length;
				
				if(items_to_check > 0) {
				all_checkbox += $(".tax_epschkbox:checked").closest(".ptype_nameli").find('.items_epschkbox').length;		
				cbx_checked += $(".tax_epschkbox:checked").closest(".ptype_nameli").find('.items_epschkbox:checked').length;
				}

				var indp_items_chk = $(".tax_epschkbox:checked").closest('.ptype_nameli').find('.independent_items:checked');
				
				if(all_checkbox == cbx_checked){
				
					if(indp_items.length < 1) {
					parent_to_check.prop("indeterminate", false).prop("checked", true);
					tax_checkbox.prop("checked", false).attr("disabled", true);	
					}  else {
					if(indp_items_chk.length == indp_items.length){
					parent_to_check.prop("indeterminate", false).prop("checked", true);
					tax_checkbox.prop("checked", false).attr("disabled", true);
					indp_items.prop("checked", false).attr("disabled", true);
					}
					}
					
				} else if(all_checkbox > cbx_checked && cbx_checked != 0) {
					parent_to_check.prop("indeterminate", true).prop("checked", false);
				} else {
					parent_to_check.prop("indeterminate", false).prop("checked", false);
				}
			
			}
			//
					
			// ITEMS
			if($('.items_epschkbox').is(":checked")){
				
				var taxonames = $(".items_epschkbox:checked")
				.closest('.ptype_nameli')
				.find('.taxo_names').css("display");	
				var txn = $(".items_epschkbox:checked")
				.closest('.ptype_nameli').find('.taxo_names');
				
				if(taxonames == 'none') {
					txn.show();	
					$(".items_epschkbox:checked").closest('.ptype_nameli')
					.find('.ptype_name')
					.find('.plus_minus')
					.html('-');
				}
			
			
				var itemnames = $('.items_epschkbox:checked')
				.closest('.tax_parentsli, .ptype_nameli')
				.find('.cate_names').css("display");	
				
				var itn = $('.items_epschkbox:checked')
				.closest('.tax_parentsli, .ptype_nameli')
				.find('.cate_names');	
				
				if(itemnames == 'none') {
					itn.show();	
					$('.items_epschkbox:checked')
					.closest('.tax_parentsli, .ptype_nameli')
					.find('.plus_minus').html('-');
				}			
				
				var ptype = $('.items_epschkbox:checked').closest(".ptype_nameli").find('.ptype_epschkbox');		
				var taxos = $('.items_epschkbox:checked').closest(".tax_parentsli").find('.tax_epschkbox');
				var checkallitems = $('.items_epschkbox:checked').closest(".tax_parentsli").find(".check-all-items");
				var items = $('.items_epschkbox:checked').closest(".tax_parentsli").find('.items_epschkbox');
				var items_checked = $('.items_epschkbox:checked').closest(".tax_parentsli").find('.items_epschkbox:checked');		
				var alltax_chbx = $('.items_epschkbox:checked').closest(".ptype_nameli").find('.tax_epschkbox').length;

				// FIND ALL CHECKBOXES AND EXCLUDE PARENT
				var all_chkbox = $('.items_epschkbox:checked').closest(".ptype_nameli").find('.items_epschkbox').length;
				var allcbx_checked = $('.items_epschkbox:checked').closest(".ptype_nameli").find('.items_epschkbox:checked').length;		
				// IF ALL ITEMS UNDER TAXONOMY ARE CHECKED - CHECK PARENT TAXONOMY 
				if(items.length == items_checked.length) {		
					taxos.prop("indeterminate", false).prop("checked", true);
					checkallitems.prop("indeterminate", false).prop("checked", true);
					if(taxos.length > 0){
						items.prop("checked", false).attr("disabled", true);
					checkallitems.prop("checked", false).attr("disabled", true);
					} 
					
				} else if(items.length > items_checked.length && items_checked.length != 0) {		
					taxos.prop("indeterminate", true).prop("checked", false);
					checkallitems.prop("indeterminate", true).prop("checked", false);
				} else {
					taxos.prop("indeterminate", false).prop("checked", false);
					checkallitems.prop("indeterminate", false).prop("checked", false);
				}		
				//alert(all_chkbox + "  " + allcbx_checked);

				var alltax_chbx_chk = $('.items_epschkbox:checked').closest(".ptype_nameli").find('.tax_epschkbox:checked').length;	

				////alert(all_chkbox + "       "  + allcbx_checked);
				
				var indp_items = $('.items_epschkbox:checked').closest('.ptype_nameli').find('.independent_items');
				var indp_items_chk = $('.items_epschkbox:checked').closest('.ptype_nameli').find('.independent_items:checked');
				
				// IF ALL CHECKBOXES ARE CHECKED - CHECK PARENT POST TYPE
				if(allcbx_checked == all_chkbox) {
					if(alltax_chbx < 1) {
						ptype.prop("indeterminate", false).prop("checked", true);
						//alert(all_chkbox - allcbx_checked);
					} else {
						if(alltax_chbx == alltax_chbx_chk) {
							ptype.prop("indeterminate", false).prop("checked", true);
							//alert("B");
						}
					}
				} else if(all_chkbox > allcbx_checked){	
						//ptype.prop("indeterminate", false).prop("checked", false);
						
					if(alltax_chbx < 1) {
						if(indp_items_chk.length != 0) {
						ptype.prop("indeterminate", true).prop("checked", false);
						//alert("MMM");
						} else {
						ptype.prop("indeterminate", false).prop("checked", false);
						//alert("555");
						}
					} else {
						if(alltax_chbx == alltax_chbx_chk && indp_items.length == indp_items_chk.length) {
							ptype.prop("indeterminate", false).prop("checked", true);
							//alert("D");
						} else if(alltax_chbx_chk < 1 && indp_items_chk.length < 1 ){
							
							if(allcbx_checked != 0 ) {
							ptype.prop("indeterminate", true).prop("checked", false);
							} else {
							ptype.prop("indeterminate", false).prop("checked", false);
							}
							
							//alert("XXX");
						} else if(alltax_chbx == alltax_chbx_chk && indp_items_chk.length < 1){
							ptype.prop("indeterminate", true).prop("checked", false);
							//alert("Where");
						} else if(alltax_chbx == alltax_chbx_chk && indp_items_chk.length != 0){
							ptype.prop("indeterminate", true).prop("checked", false);
							//alert("This");
						} else if(alltax_chbx_chk < 1 && indp_items.length == indp_items_chk.length){
							ptype.prop("indeterminate", true).prop("checked", false);
							//alert("Next");
						} else if(alltax_chbx_chk != 0 && indp_items.length == indp_items_chk.length){
							ptype.prop("indeterminate", true).prop("checked", false);
							//alert("Zoo");
						} else if(alltax_chbx_chk != 0 || indp_items_chk.length != 0){
							ptype.prop("indeterminate", true).prop("checked", false);
							//alert("Vooooo");
						} 
					} 
						
				} else {
					if(alltax_chbx < 1) {
					ptype.prop("indeterminate", false).prop("checked", false);
					//alert("E");
					} else {
					if(alltax_chbx == alltax_chbx_chk) {
					ptype.prop("indeterminate", true).prop("checked", false);
					//alert("F");
					}
					}
				}
			}
			
			//
		}
		
		chekChecked();
		
		function aboutAllLocation(){
		var all_of_chk_chkbox = $('#mainboard').find('input[type="checkbox"]:checked').length;
		all_of_chk_chkbox += $('.p_types').find('input[type="checkbox"]:checked').length;
			if(all_of_chk_chkbox > 0){
			$("#all_location").prop("checked", false);
			}
		}
		
		
		function changeColor() {
			var whole_checked = $('.p_types').find('input[type="checkbox"]:checked').length;	
			if(whole_checked > 0 ){
				$(".specify_ptypes").closest('td').find('.plus_minus').css('background', '#0a7d12');			
				if($('.p_types').is(":hidden")) {
				$('.p_types').show();
				}
			
			} else {
				$(".specify_ptypes").closest('td').find('.plus_minus').removeAttr('style');
			}
		}	
		changeColor();
		
		$("#all_location").on("change", function(){	
		if($(this).is(":checked")) {
		$("#exclude_home, #home_only, #exclude_archive, #archive_only, .ptype_epschkbox, .tax_epschkbox, .tax_epschkbox_hidden, .items_epschkbox").attr("disabled", true).prop("checked", false);
		} else {
		$("#exclude_home, #home_only, #exclude_archive, #archive_only, .ptype_epschkbox, .tax_epschkbox, .tax_epschkbox_hidden, .items_epschkbox").attr("disabled", false);
		}
		});	
		
		$("#exclude_home").on("change", function(){	
		if($(this).is(":checked")) {
		$("#home_only").attr("disabled", true).prop("checked", false);
		} else {
		$("#home_only").attr("disabled", false);
		}
		aboutAllLocation();		
		});
		
		$("#home_only").on("change", function(){	
		if($(this).is(":checked")) {
		$("#exclude_home").attr("disabled", true).prop("checked", false);
		} else {
		$("#exclude_home").attr("disabled", false);
		}
		aboutAllLocation();		
		});
		
		$("#exclude_archive").on("change", function(){	
		if($(this).is(":checked")) {
		$("#archive_only").attr("disabled", true).prop("checked", false);
		} else {
		$("#archive_only").attr("disabled", false);
		}
		aboutAllLocation();	
		});
		
		
		$("#archive_only").on("change", function(){	
		if($(this).is(":checked")) {
		$("#exclude_archive").attr("disabled", true).prop("checked", false);
		} else {
		$("#exclude_archive").attr("disabled", false);
		}
		aboutAllLocation();	
		});	
		
		
		var deep = Array(".ptype_epschkbox", ".tax_epschkbox", ".items_epschkbox");
		for(var i = 0; i < deep.length; i++) {
		$(deep[i]).on("change", function(){
		aboutAllLocation();	
		});
		}
		
		$(".specify_ptypes").on("click", function(e){
		e.preventDefault();
		$(this).parent('tr').find('.plus_minus').html('-');	
		
			var taxonames = $('.p_types').css("display");	
			var txn = $('.p_types');
			
			if(taxonames == 'none') {
				txn.show();	
				$(this).closest('td').find('.plus_minus').html('-');
			} else {
				txn.hide();	
				$(this).closest('td').find('.plus_minus').html('+');
			}

			var whole_checked = $('.p_types').find('input[type="checkbox"]:checked').length;
		
			if(whole_checked > 0 ) {
				$(this).closest('td').find('.plus_minus').css('background', '#0a7d12');
			} else {
				$(this).closest('td').find('.plus_minus').removeAttr('style');
			}
			
		});


		$(".ptype_name").on("click", function(e){
			var taxonames = $(this).closest('.ptype_nameli').find('.taxo_names').css("display");	
			var txn = $(this).closest('.ptype_nameli').find('.taxo_names');
			
			if(taxonames == 'none') {
				txn.show();	
				$(this).find('.plus_minus').html('-');
			} else {
				txn.hide();	
				$(this).find('.plus_minus').html('+');
			}		
		});
		
		$(".tax_parents").on("click", function(e){
			var taxonames = $(this).closest('.tax_parentsli').find('.cate_names').css("display");	
			var txn = $(this).closest('.tax_parentsli').find('.cate_names');
			
			if(taxonames == 'none') {
				txn.show();	
				$(this).find('.plus_minus').html('-');
			} else {
				txn.hide();	
				$(this).find('.plus_minus').html('+');
			}		
		});
		

		// POST TYPE CHECKED
		$('.ptype_epschkbox').on("change", function(){
			var allchk = $(this).closest(".ptype_nameli").find('input[type=checkbox]');
		
		  if($(this).is(":checked")){			
				allchk.prop("checked", false).attr("disabled", true).prop("indeterminate", false);
				$(this).prop("checked", true).attr("disabled", false);
			} else {
				allchk.prop("checked", false).attr("disabled", false).prop("indeterminate", false);
				$(this).prop("checked", false).attr("disabled", false);
			}
			
			changeColor();
		});
		

		
		// TAXONOMY CHANGE
		$('.tax_epschkbox').on("change", function(e){
			
			var indp_items = $(this).closest('.ptype_nameli').find('.independent_items');		
			var items_to_check = $(this).closest('.tax_parentsli').find('.items_epschkbox');		
			var parent_to_check = $(this).closest('.ptype_nameli').find('.ptype_epschkbox');
			
			if($(this).is(":checked")) {
				items_to_check.prop("checked", false).attr("disabled", true);
				parent_to_check.prop("indeterminate", true).prop("checked", false);			
			} else {
				items_to_check.prop("checked", false).attr("disabled", false);
				parent_to_check.prop("indeterminate", false).prop("checked", false);
			}

			var tax_checkbox = $(this).closest(".ptype_nameli").find('.tax_epschkbox');
			
			var all_checkbox = $(this).closest(".ptype_nameli").find('.tax_epschkbox').length;
			var cbx_checked = $(this).closest(".ptype_nameli").find('.tax_epschkbox:checked').length;
			
			if(items_to_check > 0) {
			all_checkbox += $(this).closest(".ptype_nameli").find('.items_epschkbox').length;		
			cbx_checked += $(this).closest(".ptype_nameli").find('.items_epschkbox:checked').length;
			}

			var indp_items_chk = $(this).closest('.ptype_nameli').find('.independent_items:checked');
			
			if(all_checkbox == cbx_checked){
			
				if(indp_items.length < 1) {
				parent_to_check.prop("indeterminate", false).prop("checked", true);
				tax_checkbox.prop("checked", false).attr("disabled", true);	
				}  else {
				if(indp_items_chk.length == indp_items.length){
				parent_to_check.prop("indeterminate", false).prop("checked", true);
				tax_checkbox.prop("checked", false).attr("disabled", true);
				indp_items.prop("checked", false).attr("disabled", true);
				}
				}
				
			} else if(all_checkbox > cbx_checked && cbx_checked != 0) {
				parent_to_check.prop("indeterminate", true).prop("checked", false);
			} else {
				parent_to_check.prop("indeterminate", false).prop("checked", false);
			}
				
			changeColor();	
		
		});
		
		
		// Check all items
		$(".check-all-items").on("change", function(){
			/* var items = $(this).closest(".tax_parentsli").find('.items_epschkbox');
			var items_checked = $(this).closest(".tax_parentsli").find('.items_epschkbox:checked');	 */
			if($(this).is(":checked")) {
				$(this).closest(".tax_parentsli").find(".items_epschkbox").prop("checked", true);
			} else {
				$(this).closest(".tax_parentsli").find(".items_epschkbox").prop("checked", false);
			}
			/* if(items.length == items_checked.length) {
				
			} */
		});
		
		// ITEMS CHANGE
		$('.items_epschkbox').on("change", function(){
			
			var ptype = $(this).closest(".ptype_nameli").find('.ptype_epschkbox');		
			var taxos = $(this).closest(".tax_parentsli").find('.tax_epschkbox');
			var checkallitems = $(this).closest(".tax_parentsli").find(".check-all-items");
			var items = $(this).closest(".tax_parentsli").find('.items_epschkbox');
			var items_checked = $(this).closest(".tax_parentsli").find('.items_epschkbox:checked');		
			var alltax_chbx = $(this).closest(".ptype_nameli").find('.tax_epschkbox').length;

			// FIND ALL CHECKBOXES AND EXCLUDE PARENT
			var all_chkbox = $(this).closest(".ptype_nameli").find('.items_epschkbox').length;
			var allcbx_checked = $(this).closest(".ptype_nameli").find('.items_epschkbox:checked').length;		
			// IF ALL ITEMS UNDER TAXONOMY ARE CHECKED - CHECK PARENT TAXONOMY 
			if(items.length == items_checked.length) {		
				taxos.prop("indeterminate", false).prop("checked", true);
				checkallitems.prop("indeterminate", false).prop("checked", true);
				if(taxos.length > 0){
					items.prop("checked", false).attr("disabled", true);
				} 
				
			} else if(items.length > items_checked.length && items_checked.length != 0) {		
				taxos.prop("indeterminate", true).prop("checked", false);
				checkallitems.prop("indeterminate", true).prop("checked", false);
			} else {
				taxos.prop("indeterminate", false).prop("checked", false);
				checkallitems.prop("indeterminate", false).prop("checked", false);
			}		
			//alert(all_chkbox + "  " + allcbx_checked);

			var alltax_chbx_chk = $(this).closest(".ptype_nameli").find('.tax_epschkbox:checked').length;	

			////alert(all_chkbox + "       "  + allcbx_checked);
			
			var indp_items = $(this).closest('.ptype_nameli').find('.independent_items');
			var indp_items_chk = $(this).closest('.ptype_nameli').find('.independent_items:checked');
			
			// IF ALL CHECKBOXES ARE CHECKED - CHECK PARENT POST TYPE
			if(allcbx_checked == all_chkbox) {
				if(alltax_chbx < 1) {
					ptype.prop("indeterminate", false).prop("checked", true);
					//alert(all_chkbox - allcbx_checked);
				} else {
					if(alltax_chbx == alltax_chbx_chk) {
						ptype.prop("indeterminate", false).prop("checked", true);
						//alert("B");
					}
				}
			} else if(all_chkbox > allcbx_checked){	
					//ptype.prop("indeterminate", false).prop("checked", false);
					
				if(alltax_chbx < 1) {
					if(indp_items_chk.length != 0) {
					ptype.prop("indeterminate", true).prop("checked", false);
					//alert("MMM");
					} else {
					ptype.prop("indeterminate", false).prop("checked", false);
					//alert("555");
					}
				} else {
					if(alltax_chbx == alltax_chbx_chk && indp_items.length == indp_items_chk.length) {
						ptype.prop("indeterminate", false).prop("checked", true);
						//alert("D");
					} else if(alltax_chbx_chk < 1 && indp_items_chk.length < 1 ){
						
						if(allcbx_checked != 0 ) {
						ptype.prop("indeterminate", true).prop("checked", false);
						} else {
						ptype.prop("indeterminate", false).prop("checked", false);
						}
						
						//alert("XXX");
					} else if(alltax_chbx == alltax_chbx_chk && indp_items_chk.length < 1){
						ptype.prop("indeterminate", true).prop("checked", false);
						//alert("Where");
					} else if(alltax_chbx == alltax_chbx_chk && indp_items_chk.length != 0){
						ptype.prop("indeterminate", true).prop("checked", false);
						//alert("This");
					} else if(alltax_chbx_chk < 1 && indp_items.length == indp_items_chk.length){
						ptype.prop("indeterminate", true).prop("checked", false);
						//alert("Next");
					} else if(alltax_chbx_chk != 0 && indp_items.length == indp_items_chk.length){
						ptype.prop("indeterminate", true).prop("checked", false);
						//alert("Zoo");
					} else if(alltax_chbx_chk != 0 || indp_items_chk.length != 0){
						ptype.prop("indeterminate", true).prop("checked", false);
						//alert("Vooooo");
					} 
				} 
					
			} else {
				if(alltax_chbx < 1) {
				ptype.prop("indeterminate", false).prop("checked", false);
				//alert("E");
				} else {
				if(alltax_chbx == alltax_chbx_chk) {
				ptype.prop("indeterminate", true).prop("checked", false);
				//alert("F");
				}
				}
			}
			
			if(ptype.is(":checked")){
			$(this).closest(".ptype_nameli").find('.tax_epschkbox, .items_epschkbox').prop("checked", false).attr("disabled", true);
			}
			
			changeColor();
		});
		
		$("#by_datea, #by_dateb").datepicker({
		dateFormat : 'yy-mm-dd'
		});
		
		$("#by_datea, #by_dateb").on('change', function(){
			var field_a = $("#by_datea").val();
			var field_b = $("#by_dateb").val();
			
			if(Date.parse(field_a) > Date.parse(field_b)) {
				$("#by_dateb").val(field_a);
			}
		});
		
		
		$("#clear_dates").on('click', function(){
			var field_a = $("#by_datea").val();
			var field_b = $("#by_dateb").val();		
			if(field_a != "") {
				$("#by_datea").val("");
			}		
			if(field_b != "") {
				$("#by_dateb").val("");
			}
		});
		
		$("#by_datea, #by_dateb").datepicker({
		dateFormat : 'yy-mm-dd'
		});	
});	