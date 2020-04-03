 

	jQuery(document).ready(function() {
		
		
		
	//-----------------------
	
	jQuery(".update_package").live("click", function(){ 
		
		var update_package = jQuery(this).attr('rel');
		
		var bidding_interval_name_cell 	= jQuery("#bidding_interval_name_cell"+update_package).val();	
		var high_limit_cell 			= jQuery("#high_limit_cell"+update_package).val();	
		var low_limit_cell				= jQuery("#low_limit_cell"+update_package).val();	
		
		
		
		jQuery.ajax({
						url: SITE_URL + "/wp-admin/admin-ajax.php",
						type:'POST',
						data:'action=update_package&id='+ update_package +'&bidding_interval_name_cell=' + 
						bidding_interval_name_cell + '&high_limit_cell=' + high_limit_cell + 
						'&low_limit_cell=' + low_limit_cell,
						success: function (text) {  
						
							//text = text.slice(0, -1);
							jQuery('#my_pkg_cell' + update_package).animate({ backgroundColor: "green" }, 'fast');
							jQuery('#my_pkg_cell' + update_package).animate({ backgroundColor: "white" }, 'fast');
							return false;
						  }
					 });
			
		return false;
	});
		
		
		//-----------------------
	
	jQuery(".delete_package").live("click", function(){ 
		
		var delete_package = jQuery(this).attr('rel');
	
		jQuery.ajax({
						url: SITE_URL + "/wp-admin/admin-ajax.php",
						type:'POST',
						data:'action=delete_package&id=' + delete_package,
						success: function (text) {  
						
							//text = text.slice(0, -1);
							jQuery('#my_pkg_cell' + delete_package).animate({ backgroundColor: "red" }, 'slow');
							jQuery("#my_pkg_cell" + delete_package).remove();
							return false;
						  }
					 });
			
		return false;
	});
	
	
	//----------------------
		
		
		jQuery("#new_package_action").live("click", function(){ 
	
	
	var bidding_interval_name_new 	= jQuery("#bidding_interval_name_new");	
	var low_limit_new 				= jQuery("#low_limit_new");	
	var high_limit_new 				= jQuery("#high_limit_new");	
	
	//if(specific_name == 0) { alert("Please input some name."); return false; }
	
	jQuery.ajax({
						url: SITE_URL + "/wp-admin/admin-ajax.php",
						type:'POST',
						data:'action=new_package_action&bidding_interval_name_new='+ bidding_interval_name_new.val() 
						+'&low_limit_new=' + low_limit_new.val() + '&high_limit_new=' + high_limit_new.val(),
						success: function (text) {  
						
							text = text.slice(0, -1);
							
							var myObject = eval('(' + text + ')');
							
							bidding_interval_name_new.val("");
							low_limit_new.val("");
							high_limit_new.val("");
							
							var my_packages_stuff = jQuery("#my_packages_stuff");
							
							my_packages_stuff.append('<div class="MY_mo_gogo" id="my_pkg_cell'+myObject.id+'">' + 
                
								'<div class="go_go1">' +
								'<div class="go_go2_1">Price Range Name:</div>'+ 
								'<div class="go_go2_2"><input name="" id="bidding_interval_name_cell'+myObject.id+'"' +
								' value="'+myObject.bidding_interval_name+'" /></div>' +
								'</div>' +
															
								'<div class="go_go1">' +
								'<div class="go_go2_1">Low Limit('+ SITE_CURRENCY +'):</div>' +
								'<div class="go_go2_2"><input name="" id="low_limit_cell'+myObject.id+'" value="'+ myObject.low_limit +'" /></div>' +
								'</div>' +	
								
								'<div class="go_go1">' +
								'<div class="go_go2_1">High Limit('+ SITE_CURRENCY +'):</div>' + 
								'<div class="go_go2_2"><input name="" id="high_limit_cell'+myObject.id+'" value="'+ myObject.high_limit +'" /> </div>' +
								'</div>' +
							
								'<div class="go_go1"><a href="" rel="'+ myObject.id +'" class="update_package green_btn2">Update Package</a>' + 
								'<a href="#" rel="'+ myObject.id +'" class="delete_package green_btn">Delete Package</a>' +
								'</div>' +
						
							'</div>');
							jQuery('#my_pkg_cell' + myObject.id).animate({ backgroundColor: "green" }, 'fast');
							jQuery('#my_pkg_cell' + myObject.id).animate({ backgroundColor: "white" }, 'fast');
							jQuery("#my_pkg_cell" + myObject.id).focus();
							
							return false;
						  }
					 });
	
					return false;
		});
		
		//-------------------------
		
		
		
		
	});