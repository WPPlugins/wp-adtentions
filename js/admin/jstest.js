
function whereIsChecked() {
	var thiselement = "";
	var elemparentid = $(ev.target).closest("[id]").attr("id");
	var parentWithId = $(ev.target).closest("[id]").prop("tagName").toLowerCase();
	
	if($("#dhselectelement").val() == "onlythis") {
		
		if($(ev.target).prop("id").length) {
			thiselement = $(ev.target).attr("id");
		} else if($(ev.target).attr("class").length) {
			var spanclasses = $(ev.target).attr('class').replace('atselected', '').replace('athighlighter', '').trim();
				// if element have class
				if(spanclasses.length)	{					
					var elemclass = $(ev.target).attr("class").replace('atselected', '').replace('athighlighter', '').trim();
					var elmclassiter = elemclass.split(" ");
					if(elmclassiter.length > 1) {
					elemclass = elmclassiter[0];
					}
						if(iframebody.find("." + elemclass).length > 1) {
							thiselement = '{"elementdata" : [ ';
							thiselement += $(ev.target).parents().add($(ev.target))
											.map(function() {
												if($(this).find("#" + elemparentid).length < 1) {										
													var tagname = this.tagName.toLowerCase();
													var parattr = "";
													var parattrval = "";
													
													if($(this).prop("id").length) {
														parattr = "id";
														parattrval = $(this).attr("id");
													} else if($(this).attr("class").length && $(this).prop("id").length < 1){
														parattr = "class";
														parattrval = $(this).attr("class").replace('atselected', '').replace('athighlighter', '').trim();
													}
													
													var parentattr = "";
													if(parattr != "" && parattrval != "") {
														parentattr =  ', "' + parattr + '": "' + parattrval + '"';
													}
													
													var pardata = '{"tag": "' + tagname + '"' + parentattr + '}';
													
													return pardata;
												}
											}).get()
											.join( ", " );
		
											// if there are same element in the same parent, get current element order	position/ index
											if($(ev.target).closest("[id]").find("." + elemclass).length > 1) {
												var queue = $(ev.target).closest("[id]").find("." + elemclass).index(ev.target);
												thiselement += ', {"order": "' + queue + '"}';
											}
							thiselement += " ]}";
						}
				} else { // if element have no class
					var thistag = $(ev.target).prop("tagName").toLowerCase();
					
				thiselement = '{"elementdata" : [ ';
				thiselement += $(ev.target).parents().add($(ev.target))
								.map(function() {
									if($(this).find("#" + elemparentid).length < 1) {										
										var tagname = this.tagName.toLowerCase();
										var parattr = "";
										var parattrval = "";
										if($(this).prop("id").length) {
											parattr = "id";
											parattrval = $(this).attr("id");
										} else if($(this).attr("class").length && $(this).prop("id").length < 1){
											parattr = "class";
											parattrval = $(this).attr("class").replace('atselected', '').replace('athighlighter', '').trim();
										}
										var parentattr = "";
										if(parattr != "" && parattrval != "") {
											parentattr =  ', "' + parattr + '": "' + parattrval + '"';
										}
										
										var pardata = '{"tag": "' + tagname + '"' + parentattr + '}';
										
										return pardata;
									}
								}).get()
								.join( ", " );
								// if there are same element in the same parent, get current element order	position/ index
								if($(ev.target).closest("[id]").find(thistag).length > 1) {
									var queue = $(ev.target).closest("[id]").find(thistag).index(ev.target);
									thiselement += ', {"order": "' + queue + '"}';
								}
					thiselement += " ]}";
				}
		}
		
	} else if($("#dhselectelement").val() == "anykindofthiselement") {
				thiselement = '{"elementdata" : [ ';
				thiselement += $(ev.target).parents().add($(ev.target))
								.map(function() {
									if($(this).find("#" + elemparentid).length < 1) {										
										var tagname = this.tagName.toLowerCase();
										var pardata = '{"tag": "' + tagname + '}';
										return pardata;
									}
								}).get()
								.join( ", " );
					thiselement += " ]}";		
		
	} else { //Any Kind Of This Element With Same Position
				thiselement = '{"elementdata" : [ ';
				thiselement += $(ev.target).parents().add($(ev.target))
								.map(function() {
									if($(this).find("#" + elemparentid).length < 1) {										
										var tagname = this.tagName.toLowerCase();
										var pardata = '{"tag": "' + tagname + '}';
										return pardata;
									}
								}).get()
								.join( ", " );
								// if there are same element in the same parent, get current element order	position/ index
								if($(ev.target).closest("[id]").find(thistag).length > 1) {
									var queue = $(ev.target).closest("[id]").find(thistag).index(ev.target);
									thiselement += ', {"order": "' + queue + '"}';
								}
					thiselement += " ]}";		
	}
	
return thiselement;
}

$("#dhselectedelement").val(thiselement);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				function whereIsChecked() {	
					var thiselement = "";
						// if element have attribute id
						if($(ev.target).prop("id").length) {
							thiselement = $(ev.target).attr("id");
						} else if($(ev.target).attr("class").length) { // if element have no attribute id
							var elemparentid = $(ev.target).closest("[id]").attr("id");
							var spanclasses = $(ev.target).attr('class').replace('atselected', '').replace('athighlighter', '').trim();
								 
								 // if element have attribute class
								if(spanclasses.length)
								{
									var elemclass = $(ev.target).attr("class").replace('atselected', '').replace('athighlighter', '').trim();
									
									// if element contain more than 1 class, get the first one
									var elmclassiter = elemclass.split(" ");
									if(elmclassiter.length > 1) {
									elemclass = elmclassiter[0];
									}
							/* $(where).prop("checked", false); */
							/* $(wherelabel).hide(); */
							/* thiselement = elemclass; */
									//if there are other elements with same class, get current class parents data
									if(iframebody.find("." + elemclass).length > 1) {
										if($(where).is(":checked")) {
											thiselement = '{"elementdata" : [ ';
											thiselement += $(ev.target).parents().add($(ev.target))
															.map(function() {
																if($(this).find("#" + elemparentid).length < 1) {										
																	var tagname = this.tagName.toLowerCase();
																	var parattr = "";
																	var parattrval = "";
																	
																	if($(this).prop("id").length) {
																		parattr = "id";
																		parattrval = $(this).attr("id");
																	} else if($(this).attr("class").length && $(this).prop("id").length < 1){
																		parattr = "class";
																		parattrval = $(this).attr("class").replace('atselected', '').replace('athighlighter', '').trim();
																	}
																	
																	var parentattr = "";
																	if(parattr != "" && parattrval != "") {
																		parentattr =  ', "' + parattr + '": "' + parattrval + '"';
																	}
																	
																	var pardata = '{"tag": "' + tagname + '"' + parentattr + '}';
																	
																	return pardata;
																}
															}).get()
															.join( ", " );

															// if there are same element in the same parent, get current element order	position/ index
															if($(ev.target).closest("[id]").find("." + elemclass).length > 1) {
																var queue = $(ev.target).closest("[id]").find("." + elemclass).index(ev.target);
																thiselement += ', {"order": "' + queue + '"}';
															}
											thiselement += " ]}";
										}
									}
									
								} else { // if element have no class	
										
										var thistag = $(ev.target).prop("tagName").toLowerCase();
										if($(where).is(":checked")) {
											thiselement = '{"elementdata" : [ ';
											thiselement += $(ev.target).parents().add($(ev.target))
															.map(function() {
																if($(this).find("#" + elemparentid).length < 1) {										
																	var tagname = this.tagName.toLowerCase();
																	var parattr = "";
																	var parattrval = "";
																	if($(this).prop("id").length) {
																		parattr = "id";
																		parattrval = $(this).attr("id");
																	} else if($(this).attr("class").length && $(this).prop("id").length < 1){
																		parattr = "class";
																		parattrval = $(this).attr("class").replace('atselected', '').replace('athighlighter', '').trim();
																	}
																	var parentattr = "";
																	if(parattr != "" && parattrval != "") {
																		parentattr =  ', "' + parattr + '": "' + parattrval + '"';
																	}
																	
																	var pardata = '{"tag": "' + tagname + '"' + parentattr + '}';
																	
																	return pardata;
																}
															}).get()
															.join( ", " );
															// if there are same element in the same parent, get current element order	position/ index
															if($(ev.target).closest("[id]").find(thistag).length > 1) {
																var queue = $(ev.target).closest("[id]").find(thistag).index(ev.target);
																thiselement += ', {"order": "' + queue + '"}';
															}
											thiselement += " ]}";
										}
								}
						}
						
					alert(thiselement);
					$("#dhselectedelement").val(thiselement);
				}