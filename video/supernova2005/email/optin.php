<?php 
require "../registration/inc_forms.php"; 
?>

<html>

<head>

<title>Supernova 2006</title>
<style type="text/css">
a:link { color:blue; text-decoration: none }
a:visited { color:blue; text-decoration: none }
a:hover { text-decoration: underline }
.style3 {font-family: verdana,arial,sans-serif; font-size: 12px; }
</style>
<script language="javascript">
function validate()
{
	if(document.forms[0].first.value == "")
	{
		alert("Please fill out all required fields");
		document.forms[0].first.focus();
		return false;
	}
	
	if(document.forms[0].last.value == "")
	{
		alert("Please fill out all required fields");
		document.forms[0].last.focus();
		return false;
	}
	
	if(document.forms[0].email.value == "")
	{
		alert("Please fill out all required fields");
		document.forms[0].email.focus();
		return false;
	}
	
	if(document.forms[0].company.value == "")
	{
		alert("Please fill out all required fields");
		document.forms[0].company.focus();
		return false;
	}
	
	if(document.forms[0].title.value == "")
	{
		alert("Please fill out all required fields");
		document.forms[0].title.focus();
		return false;
	}

	return true;
}
</script>
</head>

<!-- <body bgcolor="#380169" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0"> -->
<body bgcolor="#ffffff" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">


<center>

<table border="0" cellpadding="0" cellspacing="0">

<tr>
<td width="42" background="../images/background_left.gif"></td>
<td width="780" bgcolor="#FFFFFF">

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="304" height="155" valign="top"><a href="http://www.supernova2005.com"><img src="http://werbach.com/supernova2005/images/logo.gif" width="304" height="155" alt="Home" border="0"></a></td>
	<td width="476"><img src="http://werbach.com/supernova2005/images/tagline.gif" width="476" height="155"></td>
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="108"><img src="http://werbach.com/supernova2005/images/topcorner.gif" width="108" height="45" alt=""></td>
	<td width="8"></td>
	<td width="1" bgcolor="#FFA813"></td>
	<td width="663">
	
		<table border="0" cellpadding="0" cellspacing="0">
		
		<tr>
		<td width="17" height="24" bgcolor="#FFA813" valign="top"></td>
		<td width="646" height="24" bgcolor="#FFA813" valign="middle">
		<font face="verdana,arial" size="2" color="#FFFFFF">
		
		<a href="../about.htm" style="color:FFFFFF"><b>About Supernova</b></a> | 
		<a href="../community_connection.htm" style="color:FFFFFF"><b>Community Connection</b></a> | 
		<a href="https://www.supernova2005.com/registration/register.php" style="color:FFFFFF"><b>Register</b></a> | <a href="../contact.htm" style="color:FFFFFF"><b>Contact Us</b></a>
		
		</font></td>
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
	<td width="111" align="right" valign="top">	<font face="verdana,arial" size="1">
	
	<a href="../program_overview.htm" style="color:7E7E7E" title="Agenda At-A-Glance">Program Overview</a>
	<br>
	<br>
	<a href="../buzz.htm" style="color:7E7E7E">Press Buzz
	</a><br><br>
	<a href="../venue.htm" style="color:7E7E7E" title="Information on the Palace Hotel and maps to Wharton West">Venue</a>	<br>
	<br>
	
	<a href="http://feeds.feedburner.com/supernova2005"><img src="../images/xml.gif" alt="XML" width="36" height="14" border="0"></a><br><br><br><br><br><br>
	<img src="../images/spacer.gif" width="111" height="20" alt="Palace Hotel"><br>
	<br><br>
	</font></td>
	<td width="5"></td>
	<td width="1" valign="top"><img src="http://werbach.com/supernova2005/images/yellowline.gif" width="1" height="195" alt=""></td>
	<td width="17"></td>
	<td valign="top">
	  <p><font face="verdana,arial" size="2">
  

      <!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->
  

	  <br>
<!-- COPY BEGIN -->
	  <br>
Please select the Supernova mailing list(s) you would like to join. </font>	    </p>
	  <form name="form1" method="post" action="optin_thank_you.php" onsubmit="return validate();">
	    <table width="60%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="20">&nbsp;</td>
            <td><input name="email_list[]" type="checkbox" id="email_list" value="Supernova Report">              
              <font face="verdana,arial" size="2">Supernova Report<br>
              </font></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td><input name="email_list[]" type="checkbox" id="email_list" value="Conference Update">
              <font face="verdana,arial" size="2">Conference Update</font></td>
            <td>&nbsp;</td>
          </tr>
        </table>
	    <p> <!-- BEGIN: Subscriber Information -->
                <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td colspan="2" width="100%">
                        <p><font face="verdana,arial" size="2"><span class="style3"><strong>Update Your Information</strong><br>
                              <br>
Please provide your information here. Items marked with an '*' require a response for signup.</span></font><br>
                        <br>
                        </p></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">First Name*:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle"><?php text_field ("first", $first, $size=15, "100", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">Last Name*:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle"><?php text_field ("last", $last, $size=15, "50", "") ?></td>
                </tr>
                
                <tr>
                  <td nowrap align="right"><span class="style3">Email*: &nbsp;</span></td>
                  <td valign="middle"><?php text_field ("email", $email, 25, "100", "") ?></td>
                </tr>
                <tr>
                    <td nowrap align="right"><span class="style3">Company Name*:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle"><?php text_field ("company", $company, 25, "50", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">Job Title*:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle"><?php text_field ("title", $title, $size=25, "50", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">Cell Phone :&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle">
                    <?php text_field ("cellphone", $cellphone, "15", "15", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">Address Line 1:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle">                    <?php text_field ("address1", $address1, "25", "50", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">Address Line 2:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle">
                    <?php text_field ("address2", $address2, "25", "50", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">City:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle">                    <?php text_field ("city", $city, "25", "25", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3"><font class="mainfont">State/Province (US/Canada):&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle"><select name="province">
<option value="<?php echo $province; ?>"><?php echo $province; ?></option>
<option  value="AL">Alabama</option>
<option  value="AK">Alaska</option>
<option  value="AB">Alberta</option>
<option  value="AZ">Arizona</option>
<option  value="AR">Arkansas</option>
<option  value="BC">British Columbia</option>
<option  value="CA">California</option>
<option  value="CO">Colorado</option>
<option  value="CT">Connecticut</option>
<option  value="DE">Delaware</option>
<option  value="DC">District of Columbia</option>
<option  value="FL">Florida</option>
<option  value="GA">Georgia</option>
<option  value="HI">Hawaii</option>
<option  value="ID">Idaho</option>
<option  value="IL">Illinois</option>
<option  value="IN">Indiana</option>
<option  value="IA">Iowa</option>
<option  value="KS">Kansas</option>
<option  value="KY">Kentucky</option>
<option  value="LA">Louisiana</option>
<option  value="ME">Maine</option>
<option  value="MB">Manitoba</option>
<option  value="MD">Maryland</option>
<option  value="MA">Massachusetts</option>
<option  value="MI">Michigan</option>
<option  value="MN">Minnesota</option>
<option  value="MS">Mississippi</option>
<option  value="MO">Missouri</option>
<option  value="MT">Montana</option>
<option  value="NE">Nebraska</option>
<option  value="NV">Nevada</option>
<option  value="NB">New Brunswick</option>
<option  value="NH">New Hampshire</option>
<option  value="NJ">New Jersey</option>
<option  value="NM">New Mexico</option>
<option  value="NY">New York</option>
<option  value="NF">Newfoundland</option>
<option  value="NC">North Carolina</option>
<option  value="ND">North Dakota</option>
<option  value="NT">Northwest Territories</option>
<option  value="NS">Nova Scotia</option>
<option  value="OH">Ohio</option>
<option  value="OK">Oklahoma</option>
<option  value="ON">Ontario</option>
<option  value="OR">Oregon</option>
<option  value="PA">Pennsylvania</option>
<option  value="PE">Prince Edward Island</option>
<option  value="QC">Quebec</option>
<option  value="RI">Rhode Island</option>
<option  value="SK">Saskatchewan</option>
<option  value="SC">South Carolina</option>
<option  value="SD">South Dakota</option>
<option  value="TN">Tennessee</option>
<option  value="TX">Texas</option>
<option  value="UT">Utah</option>
<option  value="VT">Vermont</option>
<option  value="VA">Virginia</option>
<option  value="WA">Washington</option>
<option  value="WV">West Virginia</option>
<option  value="WI">Wisconsin</option>
<option  value="WY">Wyoming</option>
<option  value="YT">Yukon Territory</option>
</select></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">Zip/Postal Code:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle">                    <?php text_field ("zip", $zip , "10", "10", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">How did you find out about us?*:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle">                    <?php text_field ("source", $source, $size=25, "50", "") ?></td>
                </tr>
                <tr align="center">
                  <td colspan="2" nowrap>                    <input name="submit" type="submit" id="submit" value="Submit"></td>
                  </tr>
                </table>
<!-- END: Subscriber Information -->
	  </form>
	  <p><font face="verdana,arial" size="2"><br>
	    	    </font></p>	  
	  <p><font face="verdana,arial" size="2">      </font></p>
	  <font face="verdana,arial" size="2"><p></p>
        </font>
<!-- CONTENT END -->		</td>
	
	<td width="5"></td>
	<td width="25" align="right" valign="top">
	<font face="verdana,arial" size="1">
	&nbsp;	</font></td>
	<td width="8"></td>
	<td width="1" bgcolor="#FFA813" valign="top"><img src="http://werbach.com/supernova2005/images/spacer.gif" width="1" height="50" alt=""></td>
	<td width="10" valign="bottom" align="right"><img src="http://werbach.com/supernova2005/images/shadepiece.gif" width="10" height="10" alt=""></td>
	<td width="125" height="100%" valign="top">
		
		<table border="0" cellpadding="0" cellspacing="0" height="100%">
		
		<tr>
		<td width="125" valign="top" height="100%">		<div align="center">
		  <p><img src="http://werbach.com/supernova2005/images/spacer.gif" width="1" height="50" alt=""><br>		
		      <font face="verdana,arial" size="1" color="#FFA813">
    
            <!-- ----------------- SPONSOR AREA ------------------------ -->
		      <b>		      </b></font><font face="verdana,arial" size="1" color="#FFA813"><b>PRODUCED IN PARTNERSHIP WITH
		              <br>
		              <a href="http://www.wharton.upenn.edu"><img src="http://werbach.com/supernova2005/images/logo_wharton.gif" alt="The Wharton School" width="119" height="48" vspace="3" border="0"></a>
		              <br>
		              <br>
		              <br>
		        </b></font>
            <font face="verdana,arial" size="2">
            <a href="http://knowledge.wharton.upenn.edu"><img src="../images/kaw_logo.gif" alt="Knowledge @ Wharton" width="119" height="40" border="0"></a><br>
            <br>
            </font><font size="1" face="verdana,arial"><br>
            </font><font face="verdana,arial" size="2">
            </font></p>
		  <font size="1" face="verdana,arial"><br>
	      </font></div></td>
		</tr>
		
		<tr>
		<td width="125" height="100%" valign="bottom"><img src="http://werbach.com/supernova2005/images/bottomcorner.gif" alt="" width="125" height="56" align="bottom"></td>
		</tr>
		
		</table>
		
	    
	</tr>
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="645" height="1" bgcolor="#FFA813"></td>
	<td><img src="http://werbach.com/supernova2005/images/bottomcornerslice.gif" width="135" height="1" alt=""></td>
	</tr>
	
	</table>

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="134"></td>
	<td width="373"><font face="verdana,arial" size="1" color="#7E7E7E">
	©2006 Supernova Group LLC
	</font></td>
	<td width="273"><img src="http://werbach.com/supernova2005/images/bottommiddle.gif" width="273" height="31" alt=""></td>
	</tr>
	
	<tr>
	<td colspan="3"><img src="http://werbach.com/supernova2005/images/bottom.gif" width="780" height="52" alt=""></td>
	</tr>
	
	</table>

</td>
<td width="42" background="../images/background_right.gif"></td>
</tr>

</table>
</center>

</html>

