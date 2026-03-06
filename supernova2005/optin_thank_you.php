<?php 
require "registration/inc_db.php"; 
require "registration/inc_forms.php"; 
dbconnect();
$people_table 		= "people";					// PEOPLE OR PEOPLE_TESTING
$not_people_fields 	= array("submit",
							"email_list",
							"is_new",
							"id"); 				// THESE FIELDS ARE **NOT** IN THE PEOPLE TABLE SO DON'T USE THEM
							
if(isset($_POST["submit"]))						// THEM FORM HAS BEEN POSTED
{
	$where_clause 	= " WHERE email = '" . $_POST['email'] . "'";
	$query 			= "SELECT ID, email, company, address1, address2, cellphone FROM " . $people_table . $where_clause . " LIMIT 0 , 1";
	$result 		= safe_query($query);		// QUERY THAT CHECKS FOR EXISTING RECORDS

	if ($result)								// QUERY WAS SUCCESSFUL
	{
		$n_rows = mysql_num_rows($result);		// HOW MANY ROWS?
		if ($n_rows == 1)						// THERE IS ONE RECORD IN THE DB, COMPARE SOME FIELDS AND EMAIL IF THERE IS A CHANGE
		{
			$row 		= mysql_fetch_array($result, MYSQL_ASSOC);
			$ID 		= $row["ID"];			// GET PEOPLE ID FROM PEOPLE
			$company 	= $row["company"];
			$address1 	= $row["address1"];
			$address2 	= $row["address2"];
			$cellphone 	= $row["cellphone"];
			$body 		= compare_fields($company, $address1, $address2, $cellphone);
			if(strlen($body) > 1)				// IF THERE IS A BODY VALUE THEN VALUES HAVE BEEN UPDATED
			{
				send_email($body);				// SEND EMAIL TO KEVIN IF FIELDS HAVE CHANGED
			}
		}
		else									// THERE IS NOT A MATCHING RECORD IN THE DB -> DO INSERT
		{
			$ID = insert_people();				// PUT THEM IN THE PEOPLE TABLE
		}


		if (isset($_POST["email_list"]))
		{
			foreach($_POST["email_list"] as $e) 	// TAG THEM
			{
				add_to_list($ID, $e);
			}
		}
		
		unset($_POST["submit"]);				// TO PREVENT DOUBLE SUBMISSIONS
	}
}	

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

</head>

<!-- <body bgcolor="#380169" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0"> -->
<body bgcolor="#ffffff" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">


<center>

<table border="0" cellpadding="0" cellspacing="0">

<tr>
<td width="42" background="images/background_left.gif"></td>
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
		
		<a href="about.htm" style="color:FFFFFF"><b>About Supernova</b></a> | 
		<a href="community_connection.htm" style="color:FFFFFF"><b>Community Connection</b></a> | 
		<a href="https://www.supernova2005.com/registration/register.php" style="color:FFFFFF"><b>Register</b></a> | <a href="contact.htm" style="color:FFFFFF"><b>Contact Us</b></a>
		
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
	
	<a href="program_overview.htm" style="color:7E7E7E" title="Agenda At-A-Glance">Program Overview</a> <br>
    <br>
    <a href="techcrunch.htm" style="color:7E7E7E">Connected Innovators </a><br>
    <br>
    <a href="buzz.htm" style="color:7E7E7E">Press Buzz </a><br>
    <br>
    <a href="venue.htm" style="color:7E7E7E" title="Information on the Palace Hotel and maps to Wharton West">Venue</a>	<br>
	<br>
	
	<a href="http://feeds.feedburner.com/supernova2005"><img src="images/xml.gif" alt="XML" width="36" height="14" border="0"></a><br><br><br>
	<img src="images/spacer.gif" width="113" height="20" alt="Palace Hotel"><br>
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
      <span class="style3"><strong>Thank you for updating </strong></span><strong>y</strong><span class="style3"><strong>our </strong></span><strong>i</strong><span class="style3"><strong>nformation</strong></span></font>	<font face="verdana,arial" size="1"><br>
      <img src="images/spacer.gif" width="441" height="100" alt="Palace Hotel"></font> </p>
	  <p>
	    <!-- CONTENT END -->
	  </p>	  </td>
	
	<td width="5"></td>
	<td width="85" align="right" valign="top">	<font face="verdana,arial" size="1">
	<img src="http://werbach.com/supernova2005/images/spacer.gif" width="1" height="50" alt=""><br>


</font></td>
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
            <a href="http://knowledge.wharton.upenn.edu"><img src="images/kaw_logo.gif" alt="Knowledge @ Wharton" width="119" height="40" border="0"></a><br>
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
<td width="42" background="images/background_right.gif"></td>
</tr>

</table>
</center>

</html>

<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////
// FUNTIONS BELOW /////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

function insert_people()
{
//	global $ID;  						// PEOPLE ID	//TETSING
	global $people_table;
	global $not_people_fields;	
	$insert_people_fields = "";			// FIELDS TO INSERT
	$insert_people_values = "";			// VALUES FOR THOSE FIELDS

	
	foreach($_POST as $key => $value)  	// FOR EACH KEY IN THE POST ARRAY SHOW ME THE VALUE
	{
		if($value != "" && in_array($key, $not_people_fields) == FALSE) // THERE IS A VALUE AND THE KEY NOT ON THE BAD LIST
		{
			$insert_people_fields = $insert_people_fields . $key . ", ";
			$insert_people_values = (get_magic_quotes_gpc()) ? $insert_people_values . "'" . $value . "', " : $insert_people_values . "'" . addslashes($value) . "', ";
		}
	}
	
	$insert_people_fields .= "user_id, ";
	$insert_people_fields .= "created_on, ";
	$insert_people_fields .= "last_modified";
		
	$insert_people_values .= "'" . strtoupper(substr(remove_char($_POST["last"] . $_POST["first"] . $_POST["email"]) , 0, 3)) . rand(1111,9999) . "', ";
	$insert_people_values .= "'" . date("Y-m-d H:i:s") . "', ";
	$insert_people_values .= "'" . date("Y-m-d H:i:s") . "'";
	
	$sql_people = "INSERT INTO " . $people_table . " (" . $insert_people_fields . ") VALUES (" . $insert_people_values . ")"; // INSERT SQL SN2005 //TESTING
	$result = safe_query($sql_people);
	return(mysql_insert_id());
}

function compare_fields($c, $a1, $a2, $cp)
{
	global $not_people_fields;
	
	if($c <> $_POST["company"])	// COMPANY CHANGED
	{
		$body .= "Company has changed from \"$c\" to \"" . $_POST["company"] . "\"\r\n<br/><br/>";
		$changed = 1;
	}
	
	if($a1 <> $_POST["address1"])	// ADDRERSS1 CHANGED
	{
		$body .= "Address1 has changed from \"$a1\" to \"" . $_POST["address1"] . "\"\r\n<br/><br/>";
		$changed = 1;
	}
	
	if($a2 <> $_POST["address2"])	// ADDRERSS2 CHANGED
	{
		$body .= "Address2 has changed from \"$a2\" to \"" . $_POST["address2"] . "\"\r\n<br/><br/>";
		$changed = 1;
	}
	
	if($cp <> $_POST["cellphone"])	// PHONE CHANGED
	{
		$body .= "Cell Phone has changed from \"$cellphone\" to \"" . $_POST["cellphone"] . "\"\r\n<br/><br/>";
		$changed = 1;
	}		
	
	if($changed == 1)		// THERE HAS BEEN A CHANGE
	{
		$body .=  "This data may have changed as well...<br/><br/>";
		foreach($_POST as $key => $value)		// FOR EVERY FORM VALUE
		{
			if(in_array($key, $not_people_fields) == 0)	$body .= "$key: $value \n<br/>";  // IF IT IS A PEOPLE FIELD SHOW US
		}
		$body = "This message is from the opt-in page. There has been a change for " . $_POST["first"] . " " . $_POST["last"] . ".\r\n<br/><br/>" . $body;
		return $body;
	}
}

function add_to_list($id, $list)
{
   		$query = "INSERT  INTO people_tags( people_id, user_id, tag, is_email_tag, Time_Added ) 
					SELECT ID,  user_id, '" . $list . "', 1, NOW() 
					FROM people
						WHERE ID
						IN ($id) ";
		safe_query($query);
}

function send_email($body)
{
	$to 		= "kevin@werbach.com";												// TO
	$subject	= "Info Change From Opt-in List";									// SUBJECT
	$headers 	.= 'From: Supernova Group <info@supernovagroup.net>' . "\r\n";		// FROM
	$headers 	.= 'Bcc: ddinatale@w3on.com' . "\r\n";								// BCC FOR TESTING - PLEASE REMOVE
	$headers 	.= "Content-type: text/html; charset=iso-8859-1" . "\r\n";			// MAKE HTML


	mail($to,$subject,$body,$headers);  											// SEND IT
}


function remove_char($str)
{
	$str = str_replace("'", "", $str);
	$str = str_replace(" ", "", $str);
	return $str;
}

function show_what_i_did()
{
	// QUERY FOR DISPLAYING RESULTS
	/*
	$where_clause 	= " WHERE email = '" . $_POST['email'] . "'";		//$_POST['email']
	$query 			= "SELECT * FROM " . $people_table . " " . $where_clause . " LIMIT 0 , 1";
	echo $query . "<hr/><hr/>";
	$result 		= safe_query($query);

	if ($result)							// QUERY WAS SUCCESSFUL
	{
		$n_rows = mysql_num_rows($result);	// HOW MANY ROWS?
			while ($row = mysql_fetch_array($result)) 
			{

				for ($i=0; $i < mysql_num_fields($result); $i++) 	// GET VARIALBES FROM DB
				{ 
					${mysql_field_name($result, $i)} = $row[mysql_field_name($result, $i)]; 
				}
				
			}
		
	}
	*/


}
?>