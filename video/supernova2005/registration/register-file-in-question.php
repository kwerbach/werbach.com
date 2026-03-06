<?php
require "inc_db.php";
dbconnect();
function write_priority_codes()
{
	$where_clause = "WHERE for_event = 'supernova2005'";
	$query = "select priority_code, price, category from sn_priority_codes " . $where_clause;
	$result = safe_query($query);
	if ($result)
		{
			while ($row = mysql_fetch_array($result)) 
			{
			$priority_code = strtolower($row["priority_code"]);
			$price = $row["price"];
			$category = $row["category"];
			echo <<<EOQ
			case "$priority_code" : \n  \t \t \t \t
				document.form1.amount.value = $price; \t \t \t \t
				document.form1.category.value = "$category"; \t \t \t \t
				break; \n \t \t \t
EOQ;
			}
			mysql_free_result($result);
		}
}
?>
<html>
<head>
<title>Supernova 2005</title>
<script language="javascript">
var base_price = 0;
var payment_method = "credit card";

/*
function set_payment_method(str)  //TESTING
{
	payment_method = str;
}
*/

function set_base_price(val)
{
<?php earlybird_or_not(); ?>

}

function calc_price()
{
	if(document.form1.priority_code.value == "")
	{
		document.form1.amount.value = base_price;
		document.form1.category.value = "none";
	}
	else
	{
		switch (document.form1.priority_code.value.toLowerCase()) 
		{ 
			
			<?php write_priority_codes(); ?>
			default : 
				document.form1.amount.value = base_price;
				document.form1.category.value = "none";
		} 
	}
	set_cookie("amount", document.form1.amount.value, 30);
	set_cookie("category", document.form1.category.value, 30)
}

function same_bill(chkd)
{
	if(chkd == 1)
	{
		document.form1.billing_first.value = document.form1.first.value;
		set_cookie("billing_first", document.form1.first.value, 30)
		document.form1.billing_last.value = document.form1.last.value;
		set_cookie("billing_last", document.form1.last.value, 30)
		document.form1.billing_address1.value = document.form1.address1.value;
		set_cookie("billing_address1", document.form1.address1.value, 30)		
		document.form1.billing_city.value = document.form1.city.value;
		set_cookie("billing_city", document.form1.city.value, 30)		
		document.form1.billing_state.value = document.form1.province.value;
		set_cookie("billing_state", document.form1.province.value, 30)
		document.form1.billing_zip.value = document.form1.zip.value;
		set_cookie("billing_zip", document.form1.zip.value, 30)
		
	}
	else
	{
		document.form1.billing_first.value = "";
		set_cookie("billing_first", "", 30)
		document.form1.billing_last.value = "";
		set_cookie("billing_last", "", 30)
		document.form1.billing_address1.value = "";
		set_cookie("billing_address1", "", 30)
		document.form1.billing_city.value = "";
		set_cookie("billing_city", "", 30)
		document.form1.billing_state.value = "";
		set_cookie("billing_state", "", 30)
		document.form1.billing_zip.value = "";
		set_cookie("billing_zip", "", 30)	
	}
}

// REQUIRED FIELDS
array_required_text = new Array("first","last","email","confirm_email",
"address1","city","province","zip","phone");

array_required_cc = new Array("billing_first","billing_last","billing_address1","billing_city",
"billing_state","billing_zip","cc_number","expire_month","expire_year");

array_required_radio = new Array("seminar_event");
array_required_radio_msg = new Array();		// GIVES MESSAGES TO SPECIFIC RADIO FIELDS THAT ARE NOT VALID
array_required_radio_msg[0] = "Please choose an attendee package";


// BEGIN FORM VALIDATION
function validate()
{
	// CHECK REQUIRED RADIO BUTTONS
	for(r=0;r<array_required_radio.length;r++)	//FOR ALL OF THE REQUIRED RADIO BUTTONS DO THIS...
	{
		radio_ok = 0;	// no radios have been found yet
		for(n = 0; n < document.form1[array_required_radio[r]].length; n++)	// FOR ALL OF THE OPTIONS DO THIS...
		{	
			if(document.form1[array_required_radio[r]][n].checked == 1)	// IF SOMTHING IN THE GROUP IS CHECKED ADD 1
			{
				radio_ok++;		//FOUND ONE, ADDING ONE
			}
		}
		if(radio_ok == 0)		// IF ZERO => NOTHING FOUND TO BE CHECKED
		{
			alert(array_required_radio_msg[r]);
			return false;
		}		
	}
	
	// CHECK REQUIRED TEXT FIELDS
	for(r=0;r<array_required_text.length;r++)
	{
		if(document.form1[array_required_text[r]].value == "")
		{
			alert("Please fill in all required fields");
			document.form1[array_required_text[r]].focus();
			return false;
		}
	}


for(p=0;p<document.form1.payment_method.length;p++)  // LENGTH OF PAYMENT METHOD
{
	if(document.form1.payment_method[p].checked == 1 && document.form1.payment_method[p].value == "credit card")  // IF CHECKED VALUE = CC THEN
	{
		for(r=0;r<array_required_cc.length;r++)
		{
			if(document.form1[array_required_cc[r]].value == "")
			{
				alert("Please fill in all required credit card fields");
				document.form1[array_required_cc[r]].focus();
				return false;
			}
		}
	
		if(document.form1.cc_type.value == "")
		{
			alert("Please choose a credit card type.");
			return false;
		}
	}
}
	


	if(document.form1.email.value == "" || (document.form1.email.value != document.form1.confirm_email.value))
	{
		alert("email is a required field and must be confirmed");
		document.form1.confirm_email.value = "";
		document.form1.email.focus();
		return false;
	}
	
	if (email_check(document.form1.email.value) == false)
	{
		alert("Email is a required field and must be confirmed");
		document.form1.email.focus();
		return false
	}


	return true;
}

function email_check(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    return false
		 }

 		 return true					
}

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
	return null;
}

// Use this function to save a cookie.
function set_cookie(name, value, days) 
{
  var expire = "";
  if(days != null)
  {
    expire = new Date((new Date()).getTime() + days * 86400000);
    expire = "; expires=" + expire.toGMTString();
  }
  document.cookie = name + "=" + escape(value) + expire;
}

function single_option_cookie(n,v,chkd)
{
	if(chkd == 1)
	{
		set_cookie(n, v, 30)
	}
	else
	{
		set_cookie(n, "no", 30)
	}
}

function init()
{
	// TEXT FIELDS THAT A COOKIE WAS SET FOR
	arr_cookie_fields = new Array("priority_code","first","last","email","confirm_email","title","company",
	"address1","address2","city","province","zip","country","phone","cellphone","fax","website","blog",
	"billing_first","billing_last","billing_address1","billing_city","billing_state","billing_zip",
	"cc_number","expire_month","expire_year",
	"priority_code","category","amount");
	
	// CHECK & SET THE VALUES
	for (i = 0; i < arr_cookie_fields.length; i++)
	{
		if (get_cookie(arr_cookie_fields[i]))
		{
			document.form1[arr_cookie_fields[i]].value = get_cookie(arr_cookie_fields[i]);
		}
	}
	
	// CHECK FOR SEMINAR EVENT
	for(i=0;i<document.form1.seminar_event.length;i++)
	{
		if(document.form1.seminar_event[i].value == get_cookie("seminar_event"))
		{
			document.form1.seminar_event[i].checked = 1;
			set_base_price(get_cookie("seminar_event")); //TESTING
//			calc_price();				//TESTING
		}
	}

	// CHECK FOR EMAIL FORMAT
	for(i=0;i<document.form1.email_format.length;i++)
	{
		if(document.form1.email_format[i].value == get_cookie("email_format"))
		{
			document.form1.email_format[i].checked = 1;
		}
	}	
	
	// CHECK FOR PAYMENT_METHOD
	for(i=0;i<document.form1.payment_method.length;i++)
	{
		if(document.form1.payment_method[i].value == get_cookie("payment_method"))
		{
			document.form1.payment_method[i].checked = 1;
		}
	}		
	
	
	// CHECK FOR SHOCASE
	if(get_cookie("showcase") == "yes")
	{
		document.form1.showcase.checked = 1;
	}
	// CHECK FOR SAME BILLING
	if(get_cookie("same_billing") == "yes")
	{
		document.form1.same_billing.checked = 1;
	}
	
	// SET CARD TYPE
	//document.form1.cc_type.value = get_cookie("cc_type");  //TESTING
	if(get_cookie("cc_type") > 0)
	{
		si = get_cookie("cc_type");
		document.form1.cc_type.options[si].selected = 1;
	}
}
</script>
<style type="text/css">
a:link { color:blue; text-decoration: none }
a:visited { color:blue; text-decoration: none }
a:hover { text-decoration: underline }
</style>

<link href="register.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#380169" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" onLoad="init();">


<center>

<table border="0" cellpadding="0" cellspacing="0">

<tr>
<td width="42" background="../images/background_left.gif"></td>
<td width="780" bgcolor="#FFFFFF">

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="304" height="155" valign="top"><a href="http://www.supernova2005.com"><img src="../images/logo.gif" width="304" height="155" alt="Home" border="0"></a></td>
	<td width="476"><img src="../images/tagline.gif" width="476" height="155"></td>
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="108"><img src="../images/topcorner.gif" width="108" height="45" alt=""></td>
	<td width="8"></td>
	<td width="1" bgcolor="#FFA813"></td>
	<td width="663">
	
		<table border="0" cellpadding="0" cellspacing="0">
		
		<tr>
		<td width="17" height="24" bgcolor="#FFA813" valign="top"></td>
		<td width="646" height="24" bgcolor="#FFA813" valign="middle">
		<font face="verdana,arial" size="2" color="#FFFFFF">
		
		<a href="../about.htm" style="color:FFFFFF"><b>About Supernova</b></a> | 
		<a href="register.php" style="color:FFFFFF"><b>Register</b></a> | 
		<a href="../community_connection.htm" style="color:FFFFFF"><b>Community Connection</b></a> | 
		<a href="http://blog.supernova2005.com/" style="color:FFFFFF"><b>Weblog</b></a> | 
		<a href="../contact.htm" style="color:FFFFFF"><b>Contact Us</b></a>
		
		</td>
		</tr>
		
		<tr>
		<td height="21" colspan="2"></td>
		</tr>
		
		</table>
	
	</td>
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="111" align="right" valign="top">
	<font face="verdana,arial" size="1">
	
	<a href="../program_overview.htm" style="color:7E7E7E" title="Agenda At-A-Glance">Program Overview</a>
	<br><br>
	<a href="../sessions.htm" style="color:7E7E7E" title="Session Descriptions and Technology Spotlight">Sessions</a>
	<br><br>
	<a href="../workshops.htm" style="color:7E7E7E">Workshops</a>
	<br><br>
	<a href="../special_events.htm" style="color:7E7E7E">Special Events</a>
	<br><br>
	<a href="../speakers.htm" style="color:7E7E7E">Speakers</a>
	<br><br>
	<a href="../sponsors.htm" style="color:7E7E7E">Sponsors</a>
	<br><br>
	<a href="../venue.htm" style="color:7E7E7E" title="Information on the Palace Hotel and maps to Wharton West">Venue</a>
	<br><br><br><br><br><br>
	<img src="../images/palacehotel.jpg" width="111" height="189" alt="Palace Hotel">
	<br><br><br>
	<a href="http://www.wharton.upenn.edu/campus/wharton_west"><img src="../images/whartonwest.jpg" width"111" height"215" alt="Wharton West" border="0"></a>
	<br><br>
	</td>
	<td width="5"></td>
	<td width="1" valign="top"><img src="../images/yellowline.gif" width="1" height="195" alt=""></td>
	<td width="17"></td>
	<td width="502" valign="top">
	<font face="verdana,arial" size="2">


<!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->	
<p><img src="../images/head_register.gif" width="502" height="50" alt="Register">
	<br>
	<span class="form_label">To register, please select a  conference package and then complete and submit the form below. <br>
	<br>
	The cut-off deadline for Early Bird registration  is May 13, 2005.<br><br>
	</span>
<table width="100%" cellpadding="3" cellspacing="1">
	<tr bgcolor="#FFC562">
		<td class="form_label"><strong>Conference Package</strong><strong>s &amp; Fees </strong></td>
		<td align="center" valign="top"><span class="form_label"><strong>Early Bird </strong></span></td>
		<td align="center" valign="top"><span class="form_label"><strong>Regular</strong></span></td>
	</tr>
	<tr bgcolor="#FFCC99">
		<td><span class="form_label">			<strong>
			Wharton West Workshop Day:</strong><br>
               Access to all workshops on June 20.</span></td>
		<td align="center" valign="top"><span class="form_label">$595.00</span></td>
		<td align="center" valign="top"><span class="form_label">$795.00</span></td>
	</tr>
	<tr bgcolor="#FFCC99">
		<td><span class="form_label">               <strong>2-day Main Conference: </strong><br>
               All sessions on June 21 &ndash; 22.</span></td>
		<td align="center" valign="top" class="form_label">$1,695.00</td>
		<td align="center" valign="top" class="form_label">$1,995.00</td>
	</tr>
	<tr bgcolor="#FFCC99">
		<td><span class="form_label">               <strong>Full Conference:</strong> <br>
               Workshop day and all Conference events, 
               June 20 &ndash; 22.</span></td>
		<td align="center" valign="top" class="form_label">$1,995.00</td>
		<td align="center" valign="top" class="form_label">$2,495.00</td>
	</tr>
</table>
<form action="confirm.php" method="post" name="form1" onSubmit="return validate()">
<p>	<span class="form_label">
	<!-- ----------------- BEGIN FORM BELOW ------------------------ -->
	<span class="required">* </span>indicates a required field <br>
	<br>
	<span class="required">* </span><strong>Please select one of these <strong>conference</strong> packages:</strong></span><br>
	<br>
	<span class="form_label">
     <input name="seminar_event" type="radio" value="Wharton West Workshop Day" onClick="set_base_price(this.value);calc_price();set_cookie(this.name, this.value, 30);">
     Wharton West Workshop Day     <br>
     <input name="seminar_event" type="radio" value="2-day Main Conference" onClick="set_base_price(this.value);calc_price();set_cookie(this.name, this.value, 30);">
     2-day Main Conference
     <br>
     <input name="seminar_event" type="radio" value="Full Conference" onClick="set_base_price(this.value);calc_price();set_cookie(this.name, this.value, 30);">
     Full Conference</span></p>
<table width="100%"  border="1" cellpadding="5" cellspacing="0" bordercolor="#FFCC99">
	<tr>
		<td><span class="form_label">
			<strong>Special Networking Event: </strong><br>
			<br>
			You and all conference participants are invited to our kick-off networking
			event -- The Wharton West Technology Showcase -- on Monday, June 20, from
			5:30pm to 8:30pm at the Wharton West facility.<br>
			<br>
			<input name="showcase" type="checkbox" id="showcase" value="yes" onClick="single_option_cookie(this.name, this.value, this.checked);">
Yes, I plan on attending the Wharton West kick-off event.<br>
		</span></td>
	</tr>
</table>
<p>
<p>	<table width="100%"  border="0" cellspacing="0">
	<tr>
		<td width="500" class="form_label"><img src="../images/spacer.gif" width="10" height="5"></td>
	</tr>
	<tr>
		<td class="form_label">&nbsp;</td>
	</tr>
	<tr>
		<td class="form_label">If you have a <strong>priority code</strong>, enter
		  it here:
			<input name="priority_code" type="text" size="10" maxlength="10" onBlur="calc_price();set_cookie(this.name, this.value, 30)">
			<input type="hidden" name="category" value="none">
			<input name="amount" type="hidden" id="amount" size="8" maxlength="6"></td>
	</tr>
	<tr>
	  <td class="form_label"><img src="../images/spacer.gif" width="10" height="15"></td>
	  </tr>
	</table>
	<hr />
<!-- START CONTACT INFO -->	
	<table width="100%">
	<tr>
		<td colspan="2" class="form_label"><strong>Contact Information:</strong></td>
		</tr>
	<tr>
		<td class="form_label"><img src="../images/spacer.gif" width="110" height="10"></td>
		<td class="form_label"><img src="../images/spacer.gif" width="375" height="10"></td>
	</tr>
	<tr>
		<td width="110" align="right" class="form_label"><span class="required">*</span> First</td>
		<td width="364"><input name="first" type="text" size="15" maxlength="100" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label"><span class="required">* </span>Last</td>
		<td><input name="last" type="text" size="15" maxlength="100" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label"><span class="required">*</span> Email</td>
		<td><input name="email" type="text" size="25" maxlength="100" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label"><span class="required">*</span> Confirm Email</td>
		<td><input name="confirm_email" type="text" size="25" maxlength="100" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label">Email Format</td>
		<td class="form_label"><input name="email_format" type="radio" value="HTML" onClick="set_cookie(this.name, this.value, 30)">
			HTML 
				<input name="email_format" type="radio" value="Plain Text" onClick="set_cookie(this.name, this.value, 30)">
				Plain Text </td>
	</tr>
	<tr>
		<td width="110" align="right" class="form_label">Title</td>
		<td><input name="title" type="text" size="25" maxlength="100" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label">Company</td>
		<td><input name="company" type="text" size="25" maxlength="100" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label"><span class="required">*</span> Address1</td>
		<td><input name="address1" type="text" size="45" maxlength="60" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label">Address2</td>
		<td><input name="address2" type="text" size="45" maxlength="60" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label"><span class="required">*</span> City</td>
		<td><input name="city" type="text" size="15" maxlength="100" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label"><span class="required">*</span> State/Province</td>
		<td><input name="province" type="text" size="2" maxlength="2" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label"><span class="required">*</span> Zip</td>
		<td><input name="zip" type="text" size="10" maxlength="10" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label">Country</td>
		<td><input name="country" type="text" size="20" maxlength="100" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label"><span class="required">* </span>Phone</td>
		<td><input name="phone" type="text" size="20" maxlength="100" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label">Mobile Phone</td>
		<td><input name="cellphone" type="text" size="20" maxlength="100" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label">Fax</td>
		<td><input name="fax" type="text" size="20" maxlength="100" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label">Website</td>
		<td><input name="website" type="text" size="45" maxlength="100" onBlur="set_cookie(this.name, this.value, 30)"></td>
		</tr>
	<tr>
		<td width="110" align="right" class="form_label"> Weblog</td>
	     <td class="form_label"><input name="blog" type="text" id="blog" onBlur="set_cookie(this.name, this.value, 30)" size="45" maxlength="100"></td>
	</tr>
</table>	
<!-- END CONTACT INFO  -->
    <hr>
    <!-- BEGIN CC TABLE -->
<table width="100%">
	<tr>
     	<td colspan="2" class="form_label"><strong>Credit Card  Information:</strong></td>
	</tr>
	<tr>
		<td colspan="2" class="form_label"><img src="../images/spacer.gif" width="10" height="5"></td>
	</tr>
	<tr>
		<td colspan="2" class="form_label">Our secure server uses SSL encryption to safeguard your personal information, including your address and credit card information. </td>
	</tr>
	<tr>
     	<td colspan="2" class="form_label"><img src="../images/spacer.gif" width="10" height="5"></td>
	</tr>
	<tr>
		<td colspan="2" class="form_label"><input name="same_billing" type="checkbox" id="same_billing" onClick="same_bill(this.checked);single_option_cookie(this.name, this.value, this.checked);" value="yes">
			My credit card information is the same as my contact information.</td>
		</tr>
	<tr>
		<td class="form_label"><img src="../images/spacer.gif" width="110" height="10"></td>
		<td class="form_label"><img src="../images/spacer.gif" width="375" height="10"></td>
	</tr>
	<tr>
		<td align="right" class="form_label"><span class="required">*</span> First </td>
		<td class="form_label"><input name="billing_first" type="text" id="billing_first" size="15" maxlength="50" onBlur="set_cookie(this.name, this.value, 30)">
			(as it appears on your card) </td>
	</tr>
	<tr>
		<td align="right" class="form_label"><span class="required">*</span> Last </td>
		<td><span class="form_label">
			<input name="billing_last" type="text" id="billing_last" size="15" maxlength="50" onBlur="set_cookie(this.name, this.value, 30)">
		</span></td>
	</tr>
	<tr>
		<td align="right" class="form_label"><span class="required">*</span> Billing Address</td>
		<td><input name="billing_address1" type="text" id="billing_address1" maxlength="60" onBlur="set_cookie(this.name, this.value, 30)"></td>
	</tr>
	<tr>
		<td align="right" class="form_label"><span class="required">*</span> Billing City</td>
				<td><input name="billing_city" type="text" id="billing_city"></td>
	</tr>
	<tr>
		<td align="right" class="form_label"><span class="required">*</span> Billing State</td>
		<td><input name="billing_state" type="text" id="billing_state" size="2" maxlength="2" onBlur="set_cookie(this.name, this.value, 30)"></td>
	</tr>
	<tr>
     	<td align="right" class="form_label"><span class="required">*</span> Billing Zip</td>
     	<td><input name="billing_zip" type="text" id="billing_zip" size="10" maxlength="10" onBlur="set_cookie(this.name, this.value, 30)"></td>
	</tr>
	<tr>
		<td align="right" class="form_label"><span class="required">*</span> Card Type </td>
		<td><select name="cc_type" id="cc_type" onBlur="set_cookie(this.name, this.selectedIndex, 30);">
			<option value="" selected>Card Type</option>
			<option value="Visa">Visa</option>
			<option value="Master Card">Master Card</option>
		</select></td>
	</tr>
	<tr>
		<td align="right" class="form_label"><span class="required">*</span> Card Number </td>
		<td class="form_label"><input name="cc_number" type="text" id="cc_number" size="16" maxlength="16" onBlur="set_cookie(this.name, this.value, 30);"></td>
	</tr>
	<tr>
		<td align="right" class="form_label"><span class="required">*</span> Expiration Date </td>
		<td class="form_label"><input name="expire_month" type="text" id="expire_month" size="2" maxlength="2" onBlur="set_cookie(this.name, this.value, 30);">
			/
				<input name="expire_year" type="text" id="expire_year" size="2" maxlength="2" onBlur="set_cookie(this.name, this.value, 30);"> 
				(mm/yy) </td>
	</tr>
</table>
<!-- END CC TABLE -->	
<hr>
<!-- PAYMENT OPTIONS BEGIN -->
<table width="500">
	<tr>
		<td colspan="2" class="form_label"><strong>Payment Options: </strong></td>
	</tr>
	<tr>
		<td colspan="2" class="form_label"><img src="../images/spacer.gif" width="10" height="5"></td>
	</tr>
	<tr>
		<td colspan="2" class="form_label"> In addition to Credit Cards, registrations are accepted via Bank Wire Transfer and Company Check drawn on US Funds. Checks should be made payable to: Supernova Group LLC. <br>
			<br>
			If you have any questions about these alternative payment options, please e-mail: <a href="mailto:info@supernovagroup.net">info@supernovagroup.net</a>.
			<br>
			<br>
			<span class="required">* </span>Please choose a payment method:
			<input name="payment_method" type="radio" value="credit card" onClick="set_cookie(this.name, this.value, 30);" checked>
			credit card
			<input name="payment_method" type="radio" value="other" onClick="set_cookie(this.name, this.value, 30);">
			other</td>
	</tr>
</table>
<!-- END PAYMENT OPTIONS -->
<p align="center">
	<input type="submit" name="submit" value="Submit Registration" class="button">
</p>
<table>
	<tr>
		<td colspan="2" class="form_label">
		<hr>
		<strong>You may also submit registration information by fax</strong>. Please
		print out the registration form, complete it and fax it to: <strong>1-877-241-1465</strong>. <strong><br>
		      <br>
		      Hotel registration:</strong> please go to our <a href="../venue.htm">Venue</a> page for information on how to register for rooms at the Palace Hotel at a special discounted rate.<br>
			     <strong><br>
			Cancellation Policy:</strong> Written cancellations received before May 13, 2005 will be accepted subject to a service charge of $250. Subsequent cancellations are liable for the full-conference registration fee. Substitutions can be done at anytime prior to the conference. Please send email to <a href="mailto:info@supernovagroup.net">info@supernovagroup.net</a> if you would like to make a substitution.
			<br><br>
			<strong>Our mailing address is:</strong><br>
			Supernova Group LLC<br>
			825 Stoke Road<br>
			Villanova, PA 19085<br>
			1 (877) 803-7101<br>
			USA
			
			</td>
		</tr>
	<tr>
		<td class="form_label">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
</form>
<br><!-- ----------------- END FORM ABOVE ------------------------ -->
    </p></td>
	
	<td width="8"></td>
	<td width="1" bgcolor="#FFA813" valign="top"><img src="../images/spacer.gif" width="1" height="50" alt=""></td>
	<td width="10" valign="bottom" align="right"><img src="../images/shadepiece.gif" width="10" height="10" alt=""></td>
	<td width="125" height="100%" valign="top">
		
		<table border="0" cellpadding="0" cellspacing="0" height="100%">
		
		<tr>
		<td width="125" valign="top" height="100%">
		<img src="../images/spacer.gif" width="1" height="50" alt=""><br>		
		
		<font face="verdana,arial" size="1" color="#FFA813">

<!-- ----------------- SPONSOR AREA ------------------------ -->
		<b>PRODUCED IN PARTNERSHIP WITH
		<br>
		<a href="http://www.wharton.upenn.edu"><img src="../images/logo_wharton.gif" width="119" height="48" alt="The Wharton School" border="0"></a>
		<br><br>PREMIER SPONSOR</b></font><br>
		<a href="http://www.att.com"><img src="../images/logo_at&t.gif" alt="AT&T" width="125" height="48" border="0"></a></p>
<br><p>&nbsp;</p>
			<br>	
		
		</td>
		</tr>
		
		<tr>
		<td width="125" height="100%" valign="bottom"><img src="../images/bottomcorner.gif" alt="" width="125" height="56" align="bottom"></td>
		</tr>
		
		</table>
		
	    
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="645" height="1" bgcolor="#FFA813"></td>
	<td><img src="../images/bottomcornerslice.gif" width="135" height="1" alt=""></td>
	</tr>
	
	</table>

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="134"><img src="../images/spacer.gif"  width="134" height="31" ></td>
	<td width="373"><font face="verdana,arial" size="1" color="#7E7E7E">
	©2005 Supernova Group LLC</font>
	</td>
	<td width="273"><img src="../images/bottommiddle.gif" width="273" height="31" alt=""></td>
	</tr>
	
	<tr>
	<td colspan="3"><img src="../images/bottom.gif" width="780" height="52" alt=""></td>
	</tr>
	
	</table>

</td>
<td width="42" background="../images/background_right.gif"></td>
</tr>

</table>
</center>

</html>
<?php
function earlybird_or_not()
{
	$cutoff_date = getdate(mktime(0,0,0,5,14,2005));  // NO MORE EARLYBIRD
	$today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
	
	if($today[0] >= $cutoff_date[0])	// FULL PRICE
	{
		echo <<<EOQ
			switch(val)
			{
				case "Wharton West Workshop Day" : 
				  base_price = "795.00";
				  break; 
				case "2-day Main Conference" : 
				  base_price = "1995.00";
				  break; 
				case "Full Conference" : 
				  base_price = "2495.00";
				  break; 		  		  
				default :
				base_price = 0;
			}
EOQ;
	}
	else  // EARLYBIRD RATES BELOW
	{
		echo <<<EOQ
			switch(val)
			{
				case "Wharton West Workshop Day" : 
				  base_price = "595.00";
				  break; 
				case "2-day Main Conference" : 
				  base_price = "1695.00";
				  break; 
				case "Full Conference" : 
				  base_price = "1995.00";
				  break; 		  		  
				default :
				base_price = 0;
			}
EOQ;
	}

}
?>