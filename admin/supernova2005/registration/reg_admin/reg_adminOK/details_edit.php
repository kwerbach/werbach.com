<?php
require "../inc_db.php";
require "../inc_forms.php";
dbconnect();
$sn2005_fields = array("seminar_event","showcase","priority_code","category","amount","email_format","status","payment_method","payment_received","new_person","last_modified");  // supernova_registrations FIELDS TO BE UPDATED
$people_fields = array("last","first","email","middle","nickname","title","company","address1","address2","city","province","zip","country","phone","fax","cellphone","home_phone","website","blog","rss","asst_name","asst_phone","out_out","source","personal_connection","category","sn_attendee","sn_speaker","snr_subscriber","werblist_subscriber","comments");  // PEOPLE FIELDS TO BE UPDATES
if($_POST["submit"] == "Update")  // THIS FORM WAS SUBMITED
{
	update_sn($sn2005_fields);
	update_people($people_fields);
	$attendee_ref = $_POST["attendee_ref"];
}
else  // THE FORM WAS NOT SUBMITED
{
	$attendee_ref = $_SERVER["HTTP_REFERER"];
}

?>
	<html>

<head>

<title>Supernova - Attendee Details</title>
<script language="javascript">
function go_attendees()
{
	document.location = "<? echo $attendee_ref ?>"
}
</script>
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
	<font face="verdana,arial" size="1">	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
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

	Supernova 2005 registration summary... <br>
	<br>
    </p>
<!-- START CONTENT -->
	<form action="" method="post">
	<?php
	$query = "SELECT people.*, supernova_registrations.* 
				FROM people JOIN supernova_registrations 
				ON people.ID = supernova_registrations.people_id
				WHERE supernova_registrations.people_id = " . $_GET["people_id"];
	$result = safe_query($query);
	while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
	{
		foreach($row as $key => $value)
		{
			//echo hidden_field ($key, $value) . "\n";
			
//			echo $key . ": " . text_field ($key, $value, strlen($value) + 5, "", "") . "<br />\n";
			if(in_array($key, $sn2005_fields) || in_array($key, $people_fields))
			{
				echo "<b>" . beautify($key) . "</b>: <input type=\"text\" name=\"" . $key . "\" size=\"30\" value=\"". $value . "\"><br />\n\n";
			}
			else
			{
				echo "<b>" . beautify($key) . "</b>: $value<br />\n\n";
			}
		}
	}
	echo "<input type=\"hidden\" name=\"people_id\" value=\"" . $_GET["people_id"] . "\">\n\n";
	echo "<input type=\"hidden\" name=\"attendee_ref\" value=\"" . $attendee_ref . "\">\n\n";
	?>
	<br>
	<div align="center">
	    <input type="button" class="button" value="Back" onClick="go_attendees()">
	    <img src="../../images/spacer.gif" width="20" height="10">
	    <input name="submit" type="submit" class="button" value="Update">		
	  </div>
</form>
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
function update_sn($sn_arr)
{
	foreach($_POST as $key => $value)  // FOR EACH KEY IN THE POST ARRAY SHOW ME THE VALUE
	{
		if($value != "" && in_array($key, $sn_arr) == TRUE) // THERE IS A VALUE AND THE KEY IS IN THE GOOD LIST
		{
			if(get_magic_quotes_gpc() == 1)  // MAGIC QUOTES OR WHAT
			{
				$update_sn_reg_fields = $update_sn_reg_fields . $key . " = '" . $value . "', ";
			}
			else	// NO MAGIC, ADD SLASHES
			{
				$update_sn_reg_fields = $update_sn_reg_fields . $key . " = '" . addslashes($value) . "', ";
			}
		}
	}

	$update_sn_reg_fields .= " last_modified = '" . date("Y-m-d H:i:s") . "'";
	$sql_sn_reg = "UPDATE supernova_registrations SET " . $update_sn_reg_fields . " WHERE people_id = '" . $_POST["people_id"] . "' LIMIT 1"; // UPDATE SQL
	$result = safe_query($sql_sn_reg);	
}

function update_people($people_arr)
{

	foreach($_POST as $key => $value)  // FOR EACH KEY IN THE POST ARRAY SHOW ME THE VALUE
	{
		if($value != "" && in_array($key, $people_arr) == TRUE) // THERE IS A VALUE AND THE KEY IS IN THE GOOD LIST
		{
			if(get_magic_quotes_gpc() == 1)  // MAGIC QUOTES OR WHAT
			{
				$update_people_fields = $update_people_fields . $key . " = '" . $value . "', ";
			}
			else	// NO MAGIC, ADD SLASHES
			{
				$update_people_fields = $update_people_fields . $key . " = '" . addslashes($value) . "', ";
			}
		}
	}

	$update_people_fields .= " last_modified = '" . date("Y-m-d H:i:s") . "'";
	$sql_people = "UPDATE people SET " . $update_people_fields . " WHERE ID = '" . $_POST["people_id"] . "' LIMIT 1"; // UPDATE SQL
	$result = safe_query($sql_people);	
}

function beautify($str)
{
	$str = str_replace("_", " ", $str);
	$str = ucwords($str);
	$str = str_replace("Seminar Event", "Conference Package", $str);
	$str = str_replace("Cellphone", "Mobile Phone", $str);
	return $str;
}
?>