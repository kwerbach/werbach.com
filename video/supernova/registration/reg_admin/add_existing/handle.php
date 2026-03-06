<?php
require "../../inc_db.php";
$reg_year = "2008";
$pack	= "w";
$cat		= "x";
$desc		= "y";
$price		= "z";
dbconnect();
get_pc_values();	// FIND OUT CATEGORY & DESCRIPTION FOR THE GIVEN PRIORITY CODE


//----------------------
// INSERT ARRAY OF NAMES
//----------------------

if ($_POST["submit"] <> "")
{
	   foreach($_POST["people"] as $p)
	   {
			$ids .= $p . ",";
			create_sn_email_alais($p);
			$r++;				// ADD ONE TO ROWS AFFECTED
	   }
		$ids 				= trim($ids,",");
		$added_sn_reg_rows 	= insert_sn_reg($ids);
/*	 
	
	
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
*/
	//------------
	// SHOW RESULT
	//------------
	if ($added_sn_reg_rows > 0)
	{
		$statement .= "<font color=\"#00aa00\">" . $added_sn_reg_rows . " row(s) were successfully added to the supernova registration table! " . $r . " alias(es) created. (" . date("Y-m-d H:i:s") . ")</font>";
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
// ADD PERSON TO SN REG TABLE
//----------------------------
function insert_sn_reg($ID)
{
	global $reg_year;
	global $pack;	// EVENT pack
	global $cat;	// EVENT CATEGORY
	global $desc;	// CATEGORY DESC
	global $price;	// PRICE BASED ON PRIORITY CODE
	
	
	$insert_sn_reg_fields = "people_id, ";
	$insert_sn_reg_fields .= "seminar_year, ";
	$insert_sn_reg_fields .= "seminar_event, ";
	$insert_sn_reg_fields .= "priority_code, ";
	$insert_sn_reg_fields .= "category, ";
	$insert_sn_reg_fields .= "priority_code_description, ";	
	$insert_sn_reg_fields .= "amount, ";		

	$insert_sn_reg_fields .= "date_registered, ";
	$insert_sn_reg_fields .= "status, ";
	$insert_sn_reg_fields .= "payment_received, ";
	$insert_sn_reg_fields .= "payment_method, ";
	$insert_sn_reg_fields .= "new_person, ";
	$insert_sn_reg_fields .= "ip, ";
	$insert_sn_reg_fields .= "host, ";
	$insert_sn_reg_fields .= "browser, ";
	$insert_sn_reg_fields .= "last_modified";
	
// VALUES BELOW
//	$insert_sn_reg_values = "'" . $ID . "', ";  // DONE IN THE SQL
 	$insert_sn_reg_values = "'" . $reg_year . "', ";
	$insert_sn_reg_values .= "'" . $pack . "', ";
	$insert_sn_reg_values .= "'" . $_POST["priority_code"] . "', ";
	$insert_sn_reg_values .= "'" . $cat . "', ";
	$insert_sn_reg_values .= "'" . $desc . "', ";
	$insert_sn_reg_values .= "'" . $price . "', ";	
	
	$insert_sn_reg_values .= "'" . date("Y-m-d") . "', ";
	$insert_sn_reg_values .= "'registered', ";
	$insert_sn_reg_values .= "'" . $_POST["payment_received"] . "', ";
	$insert_sn_reg_values .= "'other', ";
	$insert_sn_reg_values .= "'no', ";
	$insert_sn_reg_values .= "'n/a', ";
	$insert_sn_reg_values .= "'n/a', ";
	$insert_sn_reg_values .= "'n/a', ";
	$insert_sn_reg_values .= "'" . date("Y-m-d H:i:s") . "'";
	
	
//	$sql_sn2005 = "INSERT INTO supernova_registrations (" . $insert_sn_reg_fields . ") VALUES (" . $insert_sn_reg_values . ")"; // INSERT SQL SN2005
	
	$sql_reg = "INSERT INTO supernova_registrations (" . $insert_sn_reg_fields . ") SELECT ID," . $insert_sn_reg_values . " FROM people WHERE ID IN ($ID)";
//	echo $sql_reg;
	$result = safe_query($sql_reg);
	return mysql_affected_rows();
}




//------------------
// CRATE EMAIL ALIAS
//------------------
function create_sn_email_alais($ID)
{
	global $reg_year;
	$email_query = "SELECT * FROM people WHERE id = " . $ID;
	$result = safe_query($email_query);	
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	
	$email_alias = $row['first'] . "_" . $row['last'] .  ltrim($row['ID'] + 17, "0") . "@supernova" . $reg_year . ".com";
	$email_alias = remove_char($email_alias);

	$insert_alias_fields = "";
	$insert_alias_fields .= "people_id, ";
	$insert_alias_fields .= "email_alias, ";
	$insert_alias_fields .= "real_email, ";
	$insert_alias_fields .= "for_event, ";
	$insert_alias_fields .= "status, ";
	$insert_alias_fields .= "last_modified";

	$insert_alias_values = "";
	$insert_alias_values .= "'" . $row['ID'] . "', ";	// people.ID
	$insert_alias_values .= "'" . $email_alias . "', ";
	$insert_alias_values .= "'" . $row['email'] . "', ";
	$insert_alias_values .= "'Supernova " . $reg_year . "', ";
	$insert_alias_values .= "'not activated', ";
	$insert_alias_values .= "'" . date("Y-m-d H:i:s") . "'";
	
	$sql_alias = "INSERT INTO email_aliases (" . $insert_alias_fields . ") VALUES (" . $insert_alias_values . ")"; // INSERT SQL EMAIL_ALIAS
//  echo $sql_alias;
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


//---------------------------
// GET price, category, description
//---------------------------
function get_pc_values()
	{
		global $reg_year;
		global $pack;	// EVENT pack
		global $cat;	// EVENT CATEGORY
		global $desc;	// CATEGORY DESC
		global $price;	// PRICE BASED ON PRIORITY CODE
		

		$where_clause 	= "WHERE priority_code = '" . $_POST["priority_code"] . "' AND for_event = 'supernova" . $reg_year . "'";	// CHANGE FOR FUTURE EVENTS
		$query 			= "SELECT seminar_event, priority_code, price, category, description FROM sn_priority_codes " . $where_clause;
		$result 		= safe_query($query);
		if ($result)	// FOUND RECORDS
		{
			while ($row = mysql_fetch_array($result)) 	// FOUND A MATCHING PRIORITY CODE
			{
				$pack 	= $row["seminar_event"];	
				$pc 	= $row["priority_code"];
				$cat	= $row["category"];
				$desc	= $row["description"];
				$price	= $row["price"];
			}
		}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../register.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-top: 0px;
}
-->
</style></head>

<body>
<div align="center">
<?php echo $statement ?>
</div>
</body>
</html>
