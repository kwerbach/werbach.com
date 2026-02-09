
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Supernova 2008 - Register</title>
	<meta name="author" content="Supernova 2007" />
    <meta name="keywords" content="supernova, supernova2007, conference, technology, internet, computing, communications, digital media, social software, business, emerging technology, tech companies, web, web 2.0, kevin werbach, san francisco" />
    <meta name="description" content="The Supernova conference focuses on the technology-driven transformation of computing, communications, digital media, and business. " />
    <meta name="robots" content="index, follow" />

	<link rel='stylesheet' type='text/css' media='all' href='http://www.werbach.com/supernova2006new/go?css=site/site_css' />
	<style type='text/css' media='screen'>@import "http://www.werbach.com/supernova2006new/go?css=site/site_css";</style>

    <link rel="alternate" type="application/rss+xml" title="supernova" href="" />
    <link rel="shortcut icon" type="image/x-ico" href="./favicon.ico" />
	
	<script language="javascript">
var base_price = 1495;
var payment_method = "credit card";


function set_base_price(val)
{
			switch(val)
			{
				case "Supernova 2008 Conference" : 		// WAS FULL CONFERENCE
				  base_price = "1495.00";
				  break; 		  		  
				default :
				base_price = 1495;
			}
}

function calc_price()
{
	if(document.form1.priority_code.value == "")
	{
		document.form1.amount.value = base_price;
		document.form1.category.value = "attendee";
	}
	else
	{
		switch (document.form1.priority_code.value.toLowerCase()) 
		{ 
			case "testdave" : 
				document.form1.amount.value = 1.00; 	 	 	 	
				document.form1.category.value = "Testing"; 	 	 	 	
				break; 
 	 		case "tc08" : 
				document.form1.amount.value = <? earlybird_or_not_single() ?>; 	 	 	 	
				document.form1.category.value = "attendee"; 	 	 	 	
				break; 
  	 	 	default : 
				document.form1.amount.value = base_price;
				document.form1.category.value = "attendee";
		} 
	}
	set_cookie("amount", document.form1.amount.value, 30);
	set_cookie("category", document.form1.category.value, 30)
	
	if(document.form1.amount.value == 0)
	{
		document.getElementById("paying").style.visibility = "hidden";
		document.getElementById("not_paying").style.visibility = "visible";
		document.form1.payment_method[0].checked = 1;		// n/a & CLEAR THE REST
		document.form1.payment_method[1].checked = 0;
		document.form1.payment_method[2].checked = 0;
		document.form1.payment_method[3].checked = 0;
//		alert("Free Free Free");	// TESTING
	}
	else
	{
		document.getElementById("paying").style.visibility = "visible";
		document.getElementById("not_paying").style.visibility = "hidden";
		document.form1.payment_method[0].checked = 0;		// n/a &  LEAVE THE REST ALONE
//		alert("Not Free Not Free Not Free");	// TESTING
	}
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
		document.form1.billing_country.value = document.form1.country.value;
		set_cookie("billing_country", document.form1.country.value, 30)		
		
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
"title","company","address1","city","province","zip","phone");

array_required_cc = new Array("billing_first","billing_last","billing_address1","billing_city",
"billing_state","billing_zip","cc_number","expire_month","expire_year");

// ONE RADIO BUTTON IN A GROUP
array_required_radio = new Array("payment_method");
array_required_radio_msg = new Array();		// GIVES MESSAGES TO SPECIFIC RADIO FIELDS THAT ARE NOT VALID
array_required_radio_msg[0] = "Please choose a payment method";


// BEGIN FORM VALIDATION
function validate()
{
	calc_price()		// ONE FINAL CHECK
	// CHECK REQUIRED RADIO BUTTONS

// THIS IS FOR WHEN THERE IS ONE RADIO BUTTON TO VALIDATE
if(document.form1.seminar_event.checked == 0)			// IF ZERO => NOTHING FOUND TO BE CHECKED	
		{
			alert("Please choose an attendee package");
			return false;
		}	
		
//	THIS IS FOR MULTIPLE (NORMAL) RADIO BUTTONS TO VALIDATE

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
		// CHECK FOR CC INFO
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
	
	
	// CHECK FOR SHOWCASE
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

function form_timeout()
{
	document.location = "form_timeout.php";
}
</script>
  </head>
<body onLoad="init();setTimeout('form_timeout()', 3600000);">
  <div id="wrapper">
    <div id="container">
      <div id="header">
        <h1>Supernova 2008: because technology is everyone's business</h1>
      </div>
      <div id="subheader">
        <div id="whartonlogo"><a href="http://www.wharton.upenn.edu/"><img src="http://www.supernova2006.com/i/whartonlogo.jpg" width="110" height="55" alt="Produced in Partnership with Wharton University of Pennsylvania" /></a></div>
        <div id="quote">
          <div id="quotebody">
		  


<div id="quotebody">"As good as any conference anywhere."</div>
<div id="quoteauthor">Lee Stein, CEO, Virtual Group</div>

		</div>
        </div>
        <div class="clear"></div>
      </div>
      <ul id="navigation">
        <li><a title="Home" href="http://www.supernova2008.com/go">Home</a></li>
        <li><a title="About" href="http://www.supernova2008.com/go/about">About</a></li>
        <li><a title="Register" href="https://www.supernovagroup.net/registration/register.php">Register</a></li>
        <li><a title="Speakers" href="http://www.supernova2008.com/go/speakers">Speakers</a></li>
        <li><a title="Agenda" href="http://www.supernova2008.com/go/agenda">Agenda</a></li>
        <li><a title="Challenge Days" href="http://www.supernova2008.com/go/workshops">Challenge Days</a></li>
        <li><a title="Sponsors" href="http://www.supernova2008.com/go/sponsors">Sponsors</a></li>
        <li><a title="Weblog" href="http://www.supernova2008.com/go/weblog">Weblog</a></li>
        <li><a title="Contact Us" href="http://www.supernova2008.com/go/contact">Contact Us</a></li>
		
		
      </ul>
      <div id="leftcolumn">
        <h1>Supernova 2008</h1>
        <h2>June 16-18, 2008</h2>
        <h6>San Francisco, CA</h6>
        <br />
        <br />
        <br />
        <br />
      </div>
      <div id="middlecolumn"> <img src="http://www.supernova2006.com/i/alexandras_top.jpg" width="394" height="89" alt="Alexandra" />
          <h1>Supernova 2008</h1>
          <!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->
          <h2>Special TechCrunch Registration</h2>

          <!--<p>There is <strong>one conference package</strong> for Supernova 2008 attendees - it includes an opening  general session and Networking Gala the evening of June 16, 2008, at the <a href="http://www.ahl-missionbay.com/" target="_blank">Mission Bay Conference Center</a>, San Francisco, CA, and; a series of interactive “Challenge” sessions and reception on June 17 – 18, at the <a href="http://www.wharton.upenn.edu/campus/wharton_west/" target="_blank">Wharton West Campus</a>, San Francisco, CA. </p>-->
  <!-- BEGIN CONF OPTIONS -->
        
   

          <form action="confirm.php" method="post" name="form1" id="form1" onsubmit="return validate()">
            <p> To register using the TechCrunch discount rate, please select the conference package below and  then complete the following form and submit the information.<span class="form_label"><br />
                  <br />
            </span> </p>
            <table cellpadding="3" cellspacing="1">
              <tr bgcolor="#F7D388">
                <td align="center" valign="center"><span class="required">*</span></td>
                <td class="form_label" valign="center"><strong>Conference Package</strong><strong>s &amp; Fees <br />
                (with TechCrunch discount)</strong></td>
                <td align="center" valign="center"><span class="form_label"><strong>Regular</strong></span></td>
              </tr>
              <tr bgcolor="#FCEED0" valign="top">
                <td><input name="seminar_event" type="radio" style="background : #FCEED0" value="Supernova 2008 Conference" onclick="set_base_price(this.value);calc_price();set_cookie(this.name, this.value, 30);" /></td>
                <td><span class="form_label"> <strong>Supernova 2008 Conference June 16-18</strong> <br />
              Includes all sessions/events at Mission Bay Conference Center and Wharton West</span></td>
                <td align="center" valign="top" class="form_label">$1,495</td>
              </tr>
            </table>
<!-- END CONF OPTIONS -->			
            <p> <span class="form_label">
<!-- ----------------- BEGIN FORM BELOW ------------------------ -->
        <!--  The cut-off deadline for Early Bird registration is May 5, 2008. On-site registration rates are higher than those listed here. -->
      
          <span class="form_label">
          <input name="priority_code" type="hidden" onblur="calc_price();set_cookie(this.name, this.value, 30)" value="tc08" size="10" maxlength="10" />
          <input type="hidden" name="category" value="attendee" />
          <input name="amount" type="hidden" id="amount" size="8" maxlength="6" />
          </span>
          <!--
				<strong>Networking Event RSVP: </strong><br />
                 <br />
                All conference participants are invited to our kick-off networking event on Wednesday, June 20, from 5:30-8:30pm at the Wharton West facility.<br />
                <br />
                <input name="showcase" type="checkbox" id="showcase" value="yes" onclick="single_option_cookie(this.name, this.value, this.checked);" />
                Yes, I plan to attend the Wharton West reception. 
				</p> 
-->
</p>

          
<p><strong>Special Meal Request:</strong>  I require vegetarian meals.  <input name="meals" type="checkbox" id="meals" value="vegetarian" onclick="single_option_cookie(this.name, this.value, this.checked);" />
</p>
            <br />
            
            <!-- START CONTACT INFO -->
            <table>
              <tr>
                <td colspan="2" class="form_label"><font size="4" color="#380169"><b>Contact Information</b></font></td>
              </tr>
              <tr>
                <td class="form_label"><img src="../images_reg/spacer.gif" width="110" height="10" /></td>
                <td class="form_label"><img src="../images_reg/spacer.gif" width="375" height="10" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> First</td>
                <td><input name="first" type="text" size="15" maxlength="100" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">* </span>Last</td>
                <td><input name="last" type="text" size="15" maxlength="100" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Email</td>
                <td><input name="email" type="text" size="25" maxlength="100" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Confirm Email</td>
                <td><input name="confirm_email" type="text" size="25" maxlength="100" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label">Email Format</td>
                <td class="form_label"><input name="email_format" type="radio" value="HTML" onclick="set_cookie(this.name, this.value, 30)" />
              HTML
                <input name="email_format" type="radio" value="Plain Text" onclick="set_cookie(this.name, this.value, 30)" />
              Plain Text </td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Title</td>
                <td><input name="title" type="text" size="25" maxlength="100" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Company</td>
                <td><input name="company" type="text" size="25" maxlength="100" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Address1</td>
                <td><input name="address1" type="text" size="30" maxlength="60" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label">Address2</td>
                <td><input name="address2" type="text" size="30" maxlength="60" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> City</td>
                <td><input name="city" type="text" size="15" maxlength="100" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> State/Province</td>
                <td><input name="province" type="text" size="2" maxlength="2" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Zip</td>
                <td><input name="zip" type="text" size="10" maxlength="10" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label">Country</td>
                <td><input name="country" type="text" size="20" maxlength="100" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">* </span>Phone</td>
                <td><input name="phone" type="text" size="20" maxlength="100" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label">Mobile Phone</td>
                <td><input name="cellphone" type="text" size="20" maxlength="100" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label">Fax</td>
                <td><input name="fax" type="text" size="20" maxlength="100" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label">Website</td>
                <td><input name="website" type="text" size="30" maxlength="100" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"> Weblog</td>
                <td class="form_label"><input name="blog" type="text" id="blog" onblur="set_cookie(this.name, this.value, 30)" size="30" maxlength="100" /></td>
              </tr>
            </table>
            <!-- END CONTACT INFO  -->
            <br />
            <img src="../images_reg/hrfade.gif" width="48" height="4" alt="" /><br />
            <!-- BEGIN CC TABLE -->
            <table>
              <tr>
                <td colspan="2" class="form_label"><font size="4" color="#380169"><b>Credit Card Information</b></font></td>
              </tr>
              <tr>
                <td colspan="2" class="form_label"><img src="../images_reg/spacer.gif" width="10" height="5" /></td>
              </tr>
              <tr>
                <td colspan="2" class="form_label">Our secure server uses SSL encryption to safeguard your personal information, including your address and credit card information. </td>
              </tr>
              <tr>
                <td colspan="2" class="form_label"><img src="../images_reg/spacer.gif" width="10" height="5" /></td>
              </tr>
              <tr>
                <td colspan="2" class="form_label"><input name="same_billing" type="checkbox" id="same_billing" onclick="same_bill(this.checked);single_option_cookie(this.name, this.value, this.checked);" value="yes" />
              My credit card information is the same as my contact information.</td>
              </tr>
              <tr>
                <td class="form_label"><img src="../images_reg/spacer.gif" width="110" height="10" /></td>
                <td class="form_label"><img src="../images_reg/spacer.gif" width="375" height="10" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> First </td>
                <td class="form_label"><input name="billing_first" type="text" id="billing_first" size="15" maxlength="50" onblur="set_cookie(this.name, this.value, 30)" />
              (as it appears on your card) </td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Last </td>
                <td><span class="form_label">
                  <input name="billing_last" type="text" id="billing_last" size="15" maxlength="50" onblur="set_cookie(this.name, this.value, 30)" />
                </span></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Billing Address</td>
                <td><input name="billing_address1" type="text" id="billing_address1" maxlength="60" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Billing City</td>
                <td><input name="billing_city" type="text" id="billing_city" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Billing State</td>
                <td><input name="billing_state" type="text" id="billing_state" size="2" maxlength="2" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Billing Zip</td>
                <td><input name="billing_zip" type="text" id="billing_zip" size="10" maxlength="10" onblur="set_cookie(this.name, this.value, 30)" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label">Billing Country</td>
                <td><input name="billing_country" type="text" id="billing_country" onblur="set_cookie(this.name, this.value, 30)" size="20" maxlength="100" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Card Type </td>
                <td><select name="cc_type" id="cc_type" onblur="set_cookie(this.name, this.selectedIndex, 30);">
                    <option value="" selected="selected">Card Type</option>
                    <option value="Visa">Visa</option>
                    <option value="Master Card">Master Card</option>
                    <option value="American Express">American Express</option>
                    <option value="Discover">Discover</option>
                </select></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Card Number </td>
                <td class="form_label"><input name="cc_number" type="text" id="cc_number" size="16" maxlength="16" onblur="set_cookie(this.name, this.value, -30);" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Expiration Date </td>
                <td class="form_label"><input name="expire_month" type="text" id="expire_month" size="2" maxlength="2" onblur="set_cookie(this.name, this.value, -30);" />
              /
                <input name="expire_year" type="text" id="expire_year" size="2" maxlength="2" onblur="set_cookie(this.name, this.value, -30);" />
              (mm/yy) </td>
              </tr>
            </table>
            <!-- END CC TABLE -->
            <br />
            <img src="../images_reg/hrfade.gif" width="48" height="4" alt="" /><br />
            <!-- PAYMENT OPTIONS BEGIN -->
            <table>
              <tr>
                <td colspan="2" class="form_label"><font size="4" color="#380169"><b>Payment Options</b></font></td>
              </tr>
              <tr>
                <td colspan="2" class="form_label"><img src="../images_reg/spacer.gif" width="10" height="5" /></td>
              </tr>
              <tr>
                <td colspan="2" class="form_label"><p>In addition to Credit Cards, registrations are accepted via  Bank Wire Transfer and Company Check drawn on US Funds. Checks should be made  payable to: Supernova Group LLC and sent to the address at the bottom of the  page. </p>
                  If you have any questions about these alternative payment options,  please e-mail:  <a href="mailto:info@supernovagroup.net">info@supernovagroup.net</a>. <br />
              <br />
              <span class="required">* </span>Please choose a payment method: <br />
<span id="not_paying" style="visibility:hidden;" >
			<input name="payment_method" type="radio" value="n/a" onclick="set_cookie(this.name, this.value, 30);" />n/a
</span>
<span id="paying" style="visibility:visible;">
              <input name="payment_method" type="radio" value="credit card" onclick="set_cookie(this.name, this.value, 30);" checked="checked" />credit card
              <input name="payment_method" type="radio" value="bank wire transfer" onclick="set_cookie(this.name, this.value, 30);" />bank wire transfer 
              <input name="payment_method" type="radio" value="check" onclick="set_cookie(this.name, this.value, 30);" />check 
</span>

</td>
              </tr>
            </table>
            <!-- END PAYMENT OPTIONS -->
            <p align="center">
              <input type="submit" name="submit" value="Submit Registration" class="button" /> 
            </p>
            <table>
              <tr>
                <td class="form_label"> <br />
                    <img src="../images_reg/hrfade.gif" width="48" height="4" alt="" />


						<br />
						<br />
						<strong>You may also submit registration  information by fax or email</strong>. Please print out the  registration form, complete it and fax it to: <strong>(877) 803-7101</strong>; or, email  it to: <a href="mailto:info@supernovagroup.net">info@supernovagroup.net</a>.
						<br />
						<br />
						<strong>Hotel registration:</strong> special hotel rates will be made available for hotels  close to the Supernova venues. Please check back soon for more information.
						<br />
						<br />
						<strong>Press/analyst registration:</strong> If you are interested in Supernova press/analyst passes, please <a href="mailto:press@supernovagroup.net">email us</a> with full details on your  affiliation. We evaluate each application individually. 
						<br />
						<br />
						<strong>Cancellation Policy:</strong> Written cancellations received before May 5, 2008  will be accepted subject to a service charge of $250. Subsequent cancellations  are liable for the full-conference registration fee.
						<br />
						<br />
						<strong>Substitutions:</strong> can be done  at any time prior to the conference. Please send email to <a href="mailto:info@supernovagroup.net">info@supernovagroup.net</a> if you would like to make a substitution.
						<br />
						<br />


                      <strong>Our mailing address:</strong><br />
                      Supernova Group LLC<br />
                      825 Stoke Road<br />
                      Villanova, PA 19085<br />
                      USA </p></td>
              </tr>
            </table>
        </form><!-- ----------------- END MAIN CONTENT ABOVE ------------------------ -->
      </div>
      <!--       <div id="rightcolumn">


        <div id="subnav"> <a title="Special Events" href="http://www.supernova2006.com/go/special-events">Special Events</a><br/>
            <a title="Community Connection" href="http://www.supernova2006.com/go/community-connection">Community Connection</a><br/>
            <a title="Audio/Video" href="http://www.supernova2006.com/go/media-center">Media Center</a><br/>
            <a title="Connected Innovators" href="http://www.supernova2006.com/go/connected-innovators">Connected Innovators</a><br/>
            <a id="cohosted" title="TechCrunch" href="http://www.supernova2006.com/go/connected-innovators"><img class="right" src="http://www.supernova2006.com/i/co-hosted_tc.gif" width="120" height="14" alt="Techcrunch" border="0" /></a><br />
            <a id="rss" title="RSS Feed" href="http://feeds.feedburner.com/SupernovaWeblog"><img class="left" src="http://www.supernova2006.com/i/rssicon.jpg" width="28" height="28" alt="RSS Icon" /> Subscribe to RSS</a> </div>
        <p class="purple">A complete list of 2006 sponsors is available on our <a href="http://www.supernova2006.com/go/sponsors">sponsors page</a>. For sponsorrship information, please <a href="mailto:sponsor@supernovagroup.net">email us</a>.</p>
        <br />
        <br />
        <br />
      </div> -->
      <div class="clear"></div>
      <div id="footer"></div>
    </div>
  </div>
  </body>
</html>
<?php
function earlybird_or_not_single()
{
	$gm_cutoff_date 	= getdate(gmmktime(10,0,0,5,6,2008));  																	// NO MORE EARLYBIRD AS OF GMT: HMS MDY (EDT is a 4hr diff in May)
	$gm_right_now		= getdate(gmmktime(gmdate("G"), gmdate("i"), gmdate("s"), gmdate("m")  , gmdate("d"), gmdate("Y")));  	// CURRENT GMT	
	if($gm_right_now[0] >= $gm_cutoff_date[0])		// FULL PRICE	
	{
		echo "1495.00";
	}
	else  													// EARLYBIRD RATES BELOW
	{
		echo "1195.00";
	}

}
?>