<?php
require "inc_forms.php";
require "inc_db.php";
dbconnect();
?>
<html>

<head>

<title>Supernova 2005</title>
<style type="text/css">
a:link { color:blue; text-decoration: none }
a:visited { color:blue; text-decoration: none }
a:hover { text-decoration: underline }
</style>

<link href="register.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#380169" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">


<center>

<table border="0" cellpadding="0" cellspacing="0">

<tr>
<td width="42" background="../images_reg/background_left.gif"></td>
<td width="780" bgcolor="#FFFFFF">

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="304" height="155" valign="top"><a href="http://www.supernova2006.com"><img src="../images_reg/logo.gif" width="304" height="155" alt="Home" border="0"></a></td>
	<td width="476"><img src="../images_reg/tagline.gif" width="476" height="155"></td>
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="108"><img src="../images_reg/topcorner.gif" width="108" height="45" alt=""></td>
	<td width="8"></td>
	<td width="1" bgcolor="#FFA813"></td>
	<td width="663">
	
		<table border="0" cellpadding="0" cellspacing="0">
		
		<tr>
		<td width="17" height="24" bgcolor="#FFA813" valign="top"></td>
		<td width="646" height="24" bgcolor="#FFA813" valign="middle">
		<font face="verdana,arial" size="2" color="#FFFFFF">
		
		<a href="http://www.supernova2006.com/about.htm" style="color:FFFFFF"><b>About Supernova</b></a> | 
		<a href="register.php" style="color:FFFFFF"><b>Register</b></a> | 
		<a href="http://www.supernova2006.com/community_connection.htm" style="color:FFFFFF"><b>Community Connection</b></a> | 
		<a href="http://www.supernova2006.com/contact.htm" style="color:FFFFFF"><b>Contact Us</b></a>
		
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
	
	<font face="verdana,arial" size="1"><a href="http://www.supernova2006.com/program_overview.htm" style="color:7E7E7E" title="Agenda At-A-Glance">Program Overview</a> <br>
    <br>
    <a href="http://www.supernova2006.com/techcrunch.htm" style="color:7E7E7E">Connected Innovators</a><br>
    <br>
    <a href="http://www.supernova2006.com/buzz.htm" style="color:7E7E7E">Press Buzz </a><br>
    <br>
    <a href="http://www.supernova2006.com/venue.htm" style="color:7E7E7E" title="Information on the Palace Hotel and maps to Wharton West">Venue</a></font><br>	<br>
	<br><br><br><br><br>
	<img src="../images_reg/palacehotel06.jpg" width="111" height="189" alt="Palace Hotel">
	<br><br><br>
	<a href="http://www.wharton.upenn.edu/campus/wharton_west"><img src="../images_reg/whartonwest06.jpg" width"111" height"215" alt="Wharton West" border="0"></a>
	<br><br>	</td>
	<td width="5"></td>
	<td width="1" valign="top"><img src="../images_reg/yellowline.gif" width="1" height="195" alt=""></td>
	<td width="17"></td>
	<td width="502" valign="top">
	<font face="verdana,arial" size="2">


<!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->

	<p><img src="../images_reg/head_register.gif" width="502" height="50" alt="Register">
	<br>

	Please review your information before continuing. If you need to return to the registration form you may use your browser's back button. </p>
	<?php
	$not_from_form	= array("priority_code","category","description");	// FROM THE DATABASE BASED NOT FROM FORM
	$seminar_values = array("seminar_event","showcase","meals","priority_code");
	$payment_values = array("billing_first",
							"billing_last",
							"billing_address1",
							"billing_city",
							"billing_state",
							"billing_zip",
							"billing_country",
							"cc_type",
							"cc_number",
							"expire_month",
							"expire_year",
							"payment_method");

$contact_values = array("first",
						"last",
						"email",
						"confirm_email",
						"email_format",
						"title",
						"company",
						"address1",
						"address2",
						"city",
						"province",
						"zip",
						"country",
						"phone",
						"cellphone",
						"fax",
						"website",
						"blog");

	
	if ($_POST["payment_method"] == "credit card" and $_POST["amount"] > 0)
	{
		echo "<p>Please note that your credit card will be charged <strong>$" . $_POST["amount"] . "</strong> &#8212; the full amount of the registration.</p>";
	}
	
	echo "<strong>Registration Information:</strong><hr />";
	foreach($_POST as $key => $value)
	{
		if(in_array($key, $seminar_values))	echo "<b>" . beautify($key) . ":</b> $value<br />";
	}
	echo "<br /><br /><strong>Contact Information:</strong><hr />";
	foreach($_POST as $key => $value)
	{
		if(in_array($key, $contact_values))	echo "<b>" . beautify($key) . ":</b> $value<br />";
	}	
	echo "<br /><br /><strong>Payment Information:</strong><hr />";
	echo "<b>Amount:</b> $" . $_POST["amount"] . "<br />";
	foreach($_POST as $key => $value)
	{
		if(in_array($key, $payment_values))	echo "<b>" . beautify($key) . ":</b> $value<br />";
	}
	echo "<hr />";
/*	//TESTING
	foreach($_POST as $key => $value)
	{
		echo "\"$key\",<br />";
	}
*/
	?>
	
	<form action="thank_you.php" method="post">
	<?php
	write_pk_values();
	foreach($_POST as $key => $value)
	{
		if(in_array($key, $not_from_form) == 0)	echo hidden_field ($key, $value) . "\n";
//		echo hidden_field ($key, $value) . "\n";
	}
	
	function write_pk_values()
	{
		
		$cutoff_date = getdate(mktime(0,0,0,5,13,2006));  	// NO MORE EARLYBIRD @ 12:00 AM
		$today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
	
		if($today[0] >= $cutoff_date[0])					// THEN AFTER CUTOFF -> FULL PRICE
		{
			// if after 5/12
			$default_code 			= "none"; 
			$default_category 		= "attendee";
			$default_description	= "no code";
		}
		else												// THEN BEFORE CUTOFF
		{
				switch ($_POST["seminar_event"]) {
				case "Wharton West Workshop Day":
				  	$default_code 			= "early1"; 			// X determinied by event
					$default_description	= "early bird 1-day";	// X determinied by event
				   break;
				case "2-day Main Conference":
				  	$default_code 			= "early2"; 			// X determinied by event
					$default_description	= "early bird 2-day";	// X determinied by event
				   break;
				case "Full Conference":
				   	$default_code 			= "early3"; 			// X determinied by event
					$default_description	= "early bird 3-day";	// X determinied by event
				   break;
				}
				$default_category = "early bird";
		}
		
//		echo empty($_POST["priority_code"]) . "\n";
		if (empty($_POST["priority_code"]) == 1)			// THERE IS NO PRIORITY CODE, SET DEFAULTS
		{
			echo hidden_field ("priority_code", $default_code) . "\n";
			echo hidden_field ("category", $default_category) . "\n"; 
			echo hidden_field ("priority_code_description", $default_description) . "\n";
		}
		else	  											// THERE IS A PRIORITY CODE, GET PARAMS FROM DB
		{
			$where_clause 	= "WHERE priority_code = '" . $_POST["priority_code"] . "' AND for_event = 'supernova2006'";	// CHANGE FOR FUTURE EVENTS
			$query 			= "SELECT priority_code, price, category, description FROM sn_priority_codes " . $where_clause;
			$result 		= safe_query($query);
			if ($result)	// FOUND RECORDS
			{
				while ($row = mysql_fetch_array($result)) 
				{
					echo hidden_field ("priority_code",  $row["priority_code"]) . "\n";
					echo hidden_field ("category", $row["category"]) . "\n";
					echo hidden_field ("priority_code_description", $row["description"]) . "\n";
				}
			}
			else 			// NO RECORDS
			{
					echo hidden_field ("priority_code", $default_code) . "\n";
					echo hidden_field ("category", "attendee") . "\n";
					echo hidden_field ("priority_code_description", $default_description) . "\n";
			}
		}
	}
	?>
	<div align="center">
	    <input type="button" class="button" value="Back To Form" onClick="window.history.go(-1)">
	    <img src="../images_reg/spacer.gif" width="20" height="10">
	    <input name="" type="submit" class="button" value="Confirm Registration">
	  </div>
	</form>
    </td>
	
	<td width="8"></td>
	<td width="1" bgcolor="#FFA813" valign="top"><img src="../images_reg/spacer.gif" width="1" height="50" alt=""></td>
	<td width="10" valign="bottom" align="right"><img src="../images_reg/shadepiece.gif" width="10" height="10" alt=""></td>
	<td width="125" height="100%" valign="top">
		
		<table border="0" cellpadding="0" cellspacing="0" height="100%">
		
		<tr>
		<td width="125" valign="top" height="100%">
		<img src="../images_reg/spacer.gif" width="1" height="50" alt=""><br>		
		
		<font face="verdana,arial" size="1" color="#FFA813">

<!-- ----------------- SPONSOR AREA ------------------------ -->
		<b>PRODUCED IN PARTNERSHIP WITH
		<br>
		<img src="../images_reg/logo_wharton.gif" width="119" height="48" alt="The Wharton School">
		<br><br>
		</b></font></p>
<br>
<p>&nbsp;</p>
		
		</td>
		</tr>
		
		<tr>
		<td width="125" height="100%" valign="bottom"><img src="../images_reg/bottomcorner.gif" alt="" width="125" height="56" align="bottom"></td>
		</tr>
		
		</table>
		
	    
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="645" height="1" bgcolor="#FFA813"></td>
	<td><img src="../images_reg/bottomcornerslice.gif" width="135" height="1" alt=""></td>
	</tr>
	
	</table>

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="134"></td>
	<td width="373"><font face="verdana,arial" size="1" color="#7E7E7E">
	©2006 Supernova Group LLC
	</td>
	<td width="273"><img src="../images_reg/bottommiddle.gif" width="273" height="31" alt=""></td>
	</tr>
	
	<tr>
	<td colspan="3"><img src="../images_reg/bottom.gif" width="780" height="52" alt=""></td>
	</tr>
	
	</table>

</td>
<td width="42" background="../images_reg/background_right.gif"></td>
</tr>

</table>
</center>

</html>
<?php
function beautify($str)
{
	$str = str_replace("_", " ", $str);
	$str = ucwords($str);
	$str = str_replace("Seminar Event", "Conference Package", $str);
	$str = str_replace("Cellphone", "Mobile Phone", $str);
	return $str;
}
?>