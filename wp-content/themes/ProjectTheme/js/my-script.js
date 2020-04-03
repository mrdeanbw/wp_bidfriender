var $ = jQuery;

$(document).ready(function() {

	$(".cancel_order").click(function (){		
		
		var id = $(this).attr('rel');
		$("#cancel_order_div_id_" + id).toggle('slow');
		return false;
	});

});

