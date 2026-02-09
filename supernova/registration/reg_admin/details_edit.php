<?php
require "../inc_db.php";
require "../inc_forms.php";
$reg_year = "2008";
dbconnect();
$do_not_show_fields = array("middle","nickname","home_phone","website","blog","rss","out_out","source","personal_connection","sn_attendee","sn_speaker","snr_subscriber","werblist_subscriber","autoid","2005_speaker","sn_attendee06","sn_attendee05","sn_attendee04","sn_attendee03","sn_attendee02","sn_sponsor06","sn_sponsor05","sn_sponsor04","sn_sponsor03","sn_sponsor02","skype","conf_update","marketer","sn_speaker06","sn_speaker05","sn_speaker04","sn_speaker03","sn_speaker02");  // DON'T SHOW THESE FIELDS
$sn2005_fields = array("seminar_event","showcase","priority_code","category","amount","email_format","status","payment_method","payment_received","new_person","last_modified");  // supernova_registrations FIELDS TO BE UPDATED
$people_fields = array("last","first","email","middle","nickname","title","company","address1","address2","city","province","zip","country","phone","fax","cellphone","home_phone","website","blog","rss","asst_name","asst_phone","asst_email","out_out","source","personal_connection","category","sn_attendee","sn_speaker","snr_subscriber","werblist_subscriber","comments");  // PEOPLE FIELDS TO BE UPDATES

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
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
    <td><img src="../../images_reg/supernova1.jpeg" width="200" height="109"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
	<?php require "navig_reg_admin.php"; ?>
	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top"> <font face="verdana,arial" size="2">
      <!-- START CONTENT --></font>
      <p>Supernova <?php echo $reg_year; ?> registration summary... <br>
          <br>
      </p>
      <!-- START CONTENT -->
      <form action="" method="post">
        <?php
	$query = "SELECT people.*, supernova_registrations.* 
				FROM people JOIN supernova_registrations 
							ON people.ID = supernova_registrations.people_id
				WHERE supernova_registrations.supernova_registration_id = " . $_GET["supernova_registration_id"];
	$result = safe_query($query);
	while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
	{
		$sn_id = hidden_field ('supernova_registration_id', $row["supernova_registration_id"]);  // JUST GET THE REG_ID
		foreach($row as $key => $value)
		{
			//echo hidden_field ($key, $value) . "\n";
			
//			echo $key . ": " . text_field ($key, $value, strlen($value) + 5, "", "") . "<br />\n";
			if((in_array(strtolower($key), $do_not_show_fields)))
			{
				echo "<!--" . $key . "-->\n";
			}
			elseif(in_array($key, $sn2005_fields) || in_array($key, $people_fields))
			{
				echo "<b>" . beautify($key) . "</b>: <input type=\"text\" name=\"" . $key . "\" size=\"30\" value=\"". $value . "\"><br />\n\n";
			}
			else
			{
				echo "<b>" . beautify($key) . "</b>: $value<br />\n\n";
			}
		}
	}
	echo $sn_id ."\n\n";		// THE REGISTRATION ID
	echo "<input type=\"hidden\" name=\"people_id\" value=\"" . $_GET["people_id"] . "\">\n\n";
	echo "<input type=\"hidden\" name=\"attendee_ref\" value=\"" . $attendee_ref . "\">\n\n";
	?>
        <br>
        <div align="center">
          <input type="button" class="button" value="Back" onClick="go_attendees()">
          <img src="../../images_reg/spacer.gif" width="20" height="10">
          <input name="submit" type="submit" class="button" value="Update">
        </div>
      </form>
      <!-- END CONTENT -->      <font face="verdana,arial" size="2">&nbsp;      </font></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
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
	$sql_sn_reg = "UPDATE supernova_registrations SET " . $update_sn_reg_fields . " WHERE supernova_registration_id = '" . $_POST["supernova_registration_id"] . "' LIMIT 1"; // UPDATE SQL
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