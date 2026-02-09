// JavaScript Document
//			$.validator.setDefaults({
//				submitHandler: function() { alert("submitted!"); }
//			});
//			
			
			$(document).ready(function() {
				
				// validate signup form on keyup and submit
				$("#form1").validate({
					rules: {
						conference_package: "required",
						first: "required",
						last: "required",
						email: {
							required: true,
							email: true
						},
						confirm_email: {
							required: true,
							equalTo: "#email"
						},
						title: "required",
						address1: "required",
						city: "required",
						province: "required",
						zip: "required",	
						phone: "required",
						billing_first: 
							{
								required: "#cc:checked"
							},
						billing_last: 
							{
								required: "#cc:checked"
							},
						billing_address1: 
							{
								required: "#cc:checked"
							},
						billing_city: 
							{
								required: "#cc:checked"
							},
						billing_province: 
							{
								required: "#cc:checked"
							},
						billing_zip: 
							{
								required: "#cc:checked"
							},
						cc_type: 
							{
								required: "#cc:checked"
							},
						cc_number: 
							{
								required: "#cc:checked",
								creditcard: true
							},
						expire_month: {
							required: "#cc:checked",
						    minlength: 2,
							digits: true
							},
						expire_year: {
							required: "#cc:checked",
						    minlength: 2,
							digits: true
							},
						payment_method: "required"
					},
					messages: {
						conference_package: "required",
						first: "required",
						last: "required",
						email: {
							required: "required",
							email: "required: a valid email address"
						},
						confirm_email: {
							required: "required",
							equalTo: "Please enter the same email address as above"
						},
						title: "required",
						address1: "required",
						city: "required",
						province: "required",
						zip: "required",	
						phone: "required",
						billing_first: "required",
						billing_last: "required",
						billing_address1: "required",
						billing_city: "required",
						billing_province: "required",
						billing_zip: "required",
						cc_type: "required",
						cc_number: {
							required: "required",
							creditcard: "card number is not valid"
						},
      					expire_month: "required",
						expire_year: {
							required: "required",
							minlenght: "must be a 2-digit year",
							digits: "digits only"
						},
						payment_method: "required"						
					}
				});
				
				/** Set a cookie in case they come back in a few minutes */
				$("#form1 input[type=text][id!=cc_number]").change( function() {
//					alert( $( this ).attr('name') + '|' + $( this ).val());		// TESTING
					set_cookie( $( this ).attr('name'), $( this ).val(), 30);

				}
				);
				
				
				/** Populate the field based on last answers via a cookie */
				$("#form1 input[type=text][id!=cc_number]").focus(function() {

					if($( this ).val() == '')
					{
//						alert( $( this ).attr('name') + '--' );		// TESTING
						$( this ).val(get_cookie( $( this ).attr('name') ) );
					}

				}
				);

				/** Initialize the payment methods */			
				$("#not_paying").css('display','none');
				$("#paying").css('display','inline');

				/** Show the corrent payment options based on priority code */
				$("#priority_code").blur(function()
				{
//					alert( $("#conference_id, #priority_code").serialize() );	// TESTING
					$.ajax(
					{
						type: "POST",
						url: "ajax/getPriorityCode.php",
						data: $("#conference_id, #priority_code").serialize(),
						dataType: 'text',
						success: function(x)
						{
//							alert('|' + x + '|');	// TESTING
							if (x == 'free')
							{	
								$("#not_paying input").attr('checked', 1);
								$("#not_paying input:radio").attr('checked', 1);
								$("#paying input:radio").attr('checked', 0);						
								$("#not_paying").css('display','inline');
								$("#paying").css('display','none');	
							}
							else
							{
								$("#paying input:radio").attr('checked', 0);
								$("#not_paying input:radio").attr('checked', 0);					
								$("#not_paying").css('display','none');
								$("#paying").css('display','inline');	
							}
						 }
					}
					);			

				}
				);

				$("#same_billing").click(function () {
					if( $("#same_billing").is(":checked") )		// copy value from contact info
					{
						$("#contactInfo input").each(function (i) {
							$("#billing_" +  $(this).attr("name")).val( $(this).val() );
						}
						);

						$("#ccInfo input[id!=cc_number]").each(function (i) {
								set_cookie( $( this ).attr('name'), $( this ).val(), 30);
						}
						);						
						
					}
					else
					{
						$("#ccInfo input").val('');
						
						// kill these cookies
						$("#ccInfo input").each(function (i) {
							set_cookie( $( this ).attr('name'), $( this ).val(), -30);
						}
						);
					}
				}
				);


				// clear the form after 30 minutes ) (1800000)
				setTimeout("clearForm()",1800000);
			}
			);
			


// Use this function to retrieve a cookie.
function get_cookie(name)
{
	var cname = name + "=";               
	var dc = document.cookie;             
		if (dc.length > 0) {              
		begin = dc.indexOf(cname);       
			if (begin != -1) {           
			begin += cname.length;       
			end = dc.indexOf(";", begin);
				if (end == -1) end = dc.length;
				return unescape(dc.substring(begin, end));
			} 
		}
	return '';
}

// Use this function to save a cookie.
function set_cookie(name, value, mins) 
{
  var expire = "";
  if(mins != null)
  {
    expire = new Date((new Date()).getTime() + mins * 60000);
    expire = "; expires=" + expire.toGMTString();
  }
  document.cookie = name + "=" + escape(value) + expire;
}

function clearForm()
{

					$("#form1 input[type=text]").val('');
					$("#form1 input[type=checkbox]").removeAttr("checked");
					alert( "Your form values have timedout and have been cleared for secuirty reasons." );
					document.location = 'register.php';			
}
