<?php
require "../inc_db.php";
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

<link href="../register.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#380169" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">


<center>

<table border="0" cellpadding="0" cellspacing="0">

<tr>
<td width="42" background="../../images/background_left.gif"></td>
<td width="780" bgcolor="#FFFFFF">

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="304" height="155" valign="top"><a href="http://www.supernova2005.com"><img src="../../images/logo.gif" width="304" height="155" alt="Home" border="0"></a></td>
	<td width="476"><img src="../../images/tagline.gif" width="476" height="155"></td>
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="108"><img src="../../images/topcorner.gif" width="108" height="45" alt=""></td>
	<td width="8"></td>
	<td width="1" bgcolor="#FFA813"></td>
	<td width="663">
	
		<table border="0" cellpadding="0" cellspacing="0">
		
		<tr>
		<td width="17" height="24" bgcolor="#FFA813" valign="top"></td>
		<td width="646" height="24" bgcolor="#FFA813" valign="middle">
		<font face="verdana,arial" size="2" color="#FFFFFF">
		
		<a href="snapshot.php" style="color:FFFFFF"><b>Snapshot</b></a> | <a href="attendees.php" style="color:FFFFFF"><b>Attendees</b></a> | <a href="download.php" style="color:FFFFFF"><b>Download All </b></a> | <a href="priority_codes.php" style="color:FFFFFF"><b>Priority Codes </b></a> | <a href="aliases.php" style="color:FFFFFF"><b>Email Aliases </b></a> | <a href="../register.php" style="color:FFFFFF"><b>Registration Form</b></a> </td>
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
	<td width="111" height="100%" align="right" valign="top">
	<font face="verdana,arial" size="1">
	
	<a href="../../program_overview.htm" style="color:7E7E7E" title="Agenda At-A-Glance">Snapshot</a><br>
	<br>
	<a href="../../sessions.htm" style="color:7E7E7E" title="Session Descriptions and Technology Spotlight">Attendees</a>
	<br>
	<br>
	<a href="../../workshops.htm" style="color:7E7E7E">Email Aliases </a>
	<br>
	<br>
	<a href="../../special_events.htm" style="color:7E7E7E">Download All </a>
	<br>
	<br>
     <br>
	<img src="../../images/palacehotel.jpg" width="111" height="189" alt="Palace Hotel">
	<br><br><br>
	<a href="http://www.wharton.upenn.edu/campus/wharton_west"><img src="../../images/whartonwest.jpg" width"111" height"215" alt="Wharton West" border="0"></a>
	<br><br>	</td>
	<td width="5"></td>
	<td width="1" valign="top"><img src="../../images/yellowline.gif" width="1" height="195" alt=""></td>
	<td width="17"></td>
	<td valign="top">
	<font face="verdana,arial" size="2">


<!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->

	<p><img src="../../images/head_register.gif" width="502" height="50" alt="Register">
	<br>

	Download attendee list... <br>
	<br>
    </p>
<!-- START CONTENT -->
<table>
<?php
	write_to_csv();
?>
</table>
<!-- END CONTENT -->    
    
    </td>
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="780" height="1" bgcolor="#FFA813"></td>
<!-- 	<td bgcolor="#FFA813"><img src="../../images/bottomcornerslice.gif" width="135" height="1" alt="" ></td>-->
	</tr>
	
	</table>

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="134"></td>
	<td width="373"><font face="verdana,arial" size="1" color="#7E7E7E">
	©2005 Supernova Group LLC
	</td>
	<td width="273"><img src="../../images/bottommiddle.gif" width="273" height="31" alt=""></td>
	</tr>
	
	<tr>
	<td colspan="3"><img src="../../images/bottom.gif" width="780" height="52" alt=""></td>
	</tr>
	
	</table>

</td>
<td width="42" background="../../images/background_right.gif"></td>
</tr>

</table>
</center>

</html>
<?php
function write_to_csv()
{
	$bg_color = '#d3e0f8';
	// QUERY FOR DISPLAYING RESULTS
	$where_clause = stripslashes($_GET['where_clause']);
	$query = "select people.*, supernova_2005.*
				from people JOIN supernova_2005 
				ON people.ID = supernova_2005.people_id" . $_GET['where_clause'];
	$result = safe_query($query);
	if ($result)
		{
			//$dataToWrite = "\"number\",\"first\",\"title\",\"company\",\"email\"";
			$dataToWrite = "\"supernova_2005_id\",\"people_id\",\"last\",\"first\",\"email\",\"title\",\"company\",\"address1\",\"address2\",\"city\",\"province\",\"zip\",\"country\",\"phone\",\"fax\",\"cellphone\",\"home_phone\",\"website\",\"seminar_event\",\"showcase\",\"priority_code\",\"category\",\"amount\",\"payment_method\",\"payment_received\",\"email_format\",\"status\",\"date_registered\",\"cc_trans_id\",\"new_person\",\"last_modified\"";
			$i = 0;
			while ($row = mysql_fetch_array($result)) 
			{
			//$bg_color = ($bg_color == '#d3e0f8') ? '#ffffff' : '#d3e0f8';
			$class = ($bg_color == " class=\"highlight\"") ? "" : " class=\"highlight\"";
			//$i++;
			$supernova_2005_id = $row["supernova_2005_id"];
			$people_id = $row["people_id"];
			$last = $row["last"];
			$first = $row["first"];
			$email = $row["email"];
			$title = $row["title"];
			$company = $row["company"];
			$address1 = $row["address1"];
			$address2 = $row["address2"];
			$city = $row["city"];
			$province = $row["province"];
			$zip = $row["zip"];
			$country = $row["country"];
			$phone = $row["phone"];
			$fax = $row["fax"];
			$cellphone = $row["cellphone"];
			$home_phone = $row["home_phone"];
			$website = $row["website"];
			$seminar_event = $row["seminar_event"];
			$showcase = $row["showcase"];
			$priority_code = $row["priority_code"];
			$category = $row["category"];
			$amount = $row["amount"];
			$payment_method = $row["payment_method"];
			$payment_received = $row["payment_received"];
			$email_format = $row["email_format"];
			$status = $row["status"];
			$date_registered = $row["date_registered"];
			$cc_trans_id = $row["cc_trans_id"];
			$new_person = $row["new_person"];
			$last_modified = $row["last_modified"];

			$dataToWrite = $dataToWrite . "\n\"$supernova_2005_id\",\"$people_id\",\"$last\",\"$first\",\"$email\",\"$title\",\"$company\",\"$address1\",\"$address2\",\"$city\",\"$province\",\"$zip\",\"$country\",\"$phone\",\"$fax\",\"$cellphone\",\"$home_phone\",\"$website\",\"$seminar_event\",\"$showcase\",\"$priority_code\",\"$category\",\"$amount\",\"$payment_method\",\"$payment_received\",\"$email_format\",\"$status\",\"$date_registered\",\"$cc_trans_id\",\"$new_person\",\"$last_modified\"";
			}
			mysql_free_result($result);

			$fileName = "data2.csv";
			$filePointer = fopen($fileName,"w");
			$dataToWrite = stripslashes($dataToWrite); 
			fwrite($filePointer, "$dataToWrite\n");
			fclose($filePointer);
		
			print <<<EOQ
				<tr$class>
				  <td colspan="5" class="form_label">To save your file: right-click <a href="$fileName">HERE</a> > Save Target As...</td>
				</tr>
EOQ;
	
		}
		else // no rows to down load
		{
			
			print <<<EOQ
				<tr$class>
				  <td colspan="5" class="form_label">File contains <b>0</b> records!</td>
				</tr>
EOQ;

		}

		echo $query = "<!-- select people.*, supernova_2005.*
				from people JOIN supernova_2005 
				ON people.ID = supernova_2005.people_id" . $_GET['where_clause'] . " -->";


}
?>