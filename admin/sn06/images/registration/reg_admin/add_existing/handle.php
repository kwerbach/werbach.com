<?php
require "../../inc_db.php";
dbconnect();

//----------------------
// INSERT ARRAY OF NAMES
//----------------------
if ($_POST["submit"] <> "")
{
	 //----------------------------
	 // ADD PEOPLE TO PROPER TABLES
	 //----------------------------
	 
	   $r = 0; // rows deleted so far
	   foreach($_POST["people"] as $p)
	   {
		insert_sn2005($p);
		create_sn_email_alais($p);
		$r++;	//add one to rows affected
	   }

	//------------
	// SHOW RESULT
	//------------
	if ($r > 0)
	{
		$statement .= "<font color=\"#00aa00\">" . $r . " row(s) were successfully added! (" . date("Y-m-d H:i:s") . ")</font>";
	}
	else
	{
		$statement .= "<font color=\"#ff0000\">No rows were added! (" . date("Y-m-d H:i:s") . ")</font>";
	}
	
	//---------------------------------------------------
	// SET COOKIE SO WE DONT NEED TO CHANGE PRIOTITY CODE
	//---------------------------------------------------
	setcookie('priority',$_POST["priority_code"],time()+2592000);  // 30 DAYS

}




//-----------------------------------------------------------------------------
// FUNCTIONS & SUBS -- FUNCTIONS & SUBS -- FUNCTIONS & SUBS -- FUNCTIONS & SUBS
//-----------------------------------------------------------------------------

//----------------------------
// ADD PERSON TO SN 2005 TABLE
//----------------------------
function insert_sn2005($ID)
{
	$insert_sn2005_fields = "people_id, ";
	$insert_sn2005_fields .= "seminar_event, ";
	$insert_sn2005_fields .= "priority_code, ";
	$insert_sn2005_fields .= "category, ";
	$insert_sn2005_fields .= "date_registered, ";
	$insert_sn2005_fields .= "status, ";
	$insert_sn2005_fields .= "payment_received, ";
	$insert_sn2005_fields .= "new_person, ";
	$insert_sn2005_fields .= "ip, ";
	$insert_sn2005_fields .= "host, ";
	$insert_sn2005_fields .= "browser, ";
	$insert_sn2005_fields .= "last_modified";
	
	$insert_sn2005_values = "'" . $ID . "', ";
	$insert_sn2005_values .= "'n/a', ";
	$insert_sn2005_values .= "'" . $_POST["priority_code"] . "', ";
	$insert_sn2005_values .= "'" . $_POST["category"] . "', ";
	$insert_sn2005_values .= "'" . date("Y-m-d") . "', ";
	$insert_sn2005_values .= "'registered', ";
	$insert_sn2005_values .= "'n/a', ";
	$insert_sn2005_values .= "'no', ";
	$insert_sn2005_values .= "'n/a', ";
	$insert_sn2005_values .= "'n/a', ";
	$insert_sn2005_values .= "'n/a', ";
	$insert_sn2005_values .= "'" . date("Y-m-d H:i:s") . "'";
	
	
	$sql_sn2005 = "INSERT INTO supernova_2005 (" . $insert_sn2005_fields . ") VALUES (" . $insert_sn2005_values . ")"; // INSERT SQL SN2005
	$result = safe_query($sql_sn2005);
}


//------------------
// CRATE EMAIL ALIAS
//------------------
function create_sn_email_alais($ID)
{
	$email_query = "SELECT * FROM people WHERE id = " . $ID;
	$result = safe_query($email_query);	
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	
	$email_alias = $row['first'] . "_" . $row['last'] .  ltrim($row['ID'] + 17, "0") . "@supernova2005.com";
	$email_alias = remove_char($email_alias);

	$insert_alias_fields = "";
	$insert_alias_fields .= "people_id, ";
	$insert_alias_fields .= "email_alias, ";
	$insert_alias_fields .= "real_email, ";
	$insert_alias_fields .= "status, ";
	$insert_alias_fields .= "last_modified";

	$insert_alias_values = "";
	$insert_alias_values .= "'" . $row['ID'] . "', ";	// people.ID
	$insert_alias_values .= "'" . $email_alias . "', ";
	$insert_alias_values .= "'" . $row['email'] . "', ";
	$insert_alias_values .= "'not activated', ";
	$insert_alias_values .= "'" . date("Y-m-d H:i:s") . "'";
	
	$sql_alias = "INSERT INTO email_aliases (" . $insert_alias_fields . ") VALUES (" . $insert_alias_values . ")"; // INSERT SQL EMAIL_ALIAS
	$result = safe_query($sql_alias);
}


//---------------------------
// REMOVE NON-EMAIL CHARATERS
//---------------------------
function remove_char($str)
{
	$str = str_replace("'", "", $str);
	$str = str_replace(" ", "", $str);
	return $str;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../register.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#380169" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">
<table width="864"  border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
  <tr>
    <td width="42" background="../../../images/background_left.gif">&nbsp;</td>
    <td width="17">&nbsp;</td>
    <td><?php echo $statement ?>&nbsp;</td>
    <td width="42" background="../../../images/background_right.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="42" background="../../../images/background_left.gif">&nbsp;</td>
    <td width="17">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="42" background="../../../images/background_right.gif">&nbsp;</td>
  </tr>  
</table>
</body>
</html>
