
var doctor_toggle = 1;
var secretary_toggle = 1;
var staff_toggle = 1;

function AJAX_POST( filename, toBeSended ) 			// establish ajax connection and get the content of json file
{
	var ret_data;
	
	$.ajax
	({
			url: filename,						// url of file
			type: "POST",						// post method
			data: toBeSended,					// sended data
			dataType: "json",					// type will be json
			async: false,						// wait for file to be ready
		
			success: function( data )
			{
				ret_data = data;				// returning data
			}
	});
	
 	return ret_data;
}


$(document).ready(function() 
{
	//$( "#accordion" ).accordion();

	/*
	 $("#login-button").click(function(event){
			 event.preventDefault();
		 
		 //$('form').fadeOut(500);
		 //$('.wrapper').addClass('form-success');
	});
	*/

	$("#doctor_button").click(function(event){
			 event.preventDefault();
		 
		$('#doctor_table').toggle(500);
		if( doctor_toggle == 0)
		{
			$('#doctor_button').html('Hide Doctors');
			doctor_toggle = 1;
		} 
		else
		{
			$('#doctor_button').html('Show Doctors');
			doctor_toggle = 0;
		} 			

	});


	$("#secretary_button").click(function(event){
		 event.preventDefault();
	 
	$('#secretary_table').toggle(500);
	if( secretary_toggle == 0)
	{
		$('#secretary_button').html('Hide Secretaries');
		secretary_toggle = 1;
	} 
	else
	{
		$('#secretary_button').html('Show Secretaries');
		secretary_toggle = 0;
	} 			

	});
	


	$("#staff_button").click(function(event){
		 event.preventDefault();
	 
	$('#staff_table').toggle(500);
	if( staff_toggle == 0)
	{
		$('#staff_button').html('Hide Staffs');
		staff_toggle = 1;
	} 
	else
	{
		$('#staff_button').html('Show Staffs');
		staff_toggle = 0;
	} 			

	});
	
	


});



//e1818897@ceng.metu.edu.tr
