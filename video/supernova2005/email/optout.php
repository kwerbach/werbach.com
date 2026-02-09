<?php 
require "../registration/inc_db.php"; 
require "../registration/inc_forms.php"; 
dbconnect();
$people_table 		= "people_testing";

if(isset($_GET["e"]))	// FORM HAS BEEN POSTED
{
	$where_clause 	= " WHERE email = '" . "ddinatale@w3on.com" . "'";		//$_POST['email']
	$query 			= "SELECT ID FROM " . $people_table . " WHERE email = '" . $_GET["e"] . "' LIMIT 0 , 1";
	echo $query . "<hr/><hr/>"; 
	$result 		= safe_query($query);

	if ($result)							// QUERY WAS SUCCESSFUL
	{
		$n_rows = mysql_num_rows($result);	// HOW MANY ROWS?
			while ($row = mysql_fetch_array($result)) 
			{

				$ID 	= $row["ID"];
				// REMOVE FROM PEOPLE TAGS WHERE "IS_EMAIL"
				$sql1 	= "DELETE FROM people_tags WHERE is_email_tag = 1 AND people_id = " . $ID;
				echo $sql1 . "<hr/><hr/>";
				// INSERT INTO DO NOT EMAIL TABLE
				$sql2 	= "INSERT INTO people_dne (people_id, email) VALUES ($ID," . $_GET["e"] . ")";
				echo $sql2 . "<hr/><hr/>";
			}
		
	}


//unset($_GET["e"]);	// TO PREVENT DOUBLE SUBMISSIONS
}



?>




<html>
<head>
    <meta name="robots" content="noindex,nofollow">
    <title>Unsubscribe Complete</title>
    <link rel="stylesheet" href="http://ui.constantcontact.com/ui/includes/Roving/comm_style.jsp" type="text/css">

</head>
<body bgcolor="#FFFFFF">



<img src="../images/snlogo300.jpg" border="0"><br>

<table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <center>
                <hr color="#000099" noshade size="1" width="100%" align="center">
                <font class="headerfont2" color="#380169">You have successfully unsubscribed</font>
                <hr noshade size="1" width="98%" align="center">
                <p>
                    <font class="mainfont" color="#380169">Thank you - We have received your unsubscribe request and have removed</font>
                    <font class="mainboldfont" color="#380169"><?php echo $_GET["e"]; ?></font><font class="mainfont" font color="#380169"> from our list.</font>
                </p>
            </center>
        </td>
    </tr>
<!--
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <font class="mainsmallfont" color="#380169">
                <center>
                    Supernova Group uses <img src="http://img.constantcontact.com/letters/images/safe_unsubscribe_logo.gif" border="0"> which guarantees the permanent removal of your email address from the Supernova Group&nbsp;list.
                    <a href="optin.jsp?m=1100436926029&ea=supernova%40w3on.com&lang=en" >Click here</a> if you have unsubscribed in error.
                </center>
                <hr color="#000099" noshade size="1" width="100%" align="center">
                Constant Contact may only be used to email to permission-based lists; sending of Unsolicited Commercial Email (UCE/SPAM) results in account termination. <a href="report_abuse.jsp?m=1100436926029&ea=supernova%40w3on.com&t=1101179811291&lang=en" >Report Abuse</a>&nbsp;|&nbsp;<a href="http://ui.constantcontact.com/roving/CCPrivacyPolicy.jsp">Email Privacy Policy</a>
            </font>
        </td>
    </tr>
-->
</table>
</html>


<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////
// FUNTIONS BELOW /////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

function update_people()
{
	global $people_table;
	global $not_people_fields;
	$update_people_fields = "";

	foreach($_POST as $key => $value)  									// FOR EACH KEY IN THE POST ARRAY SHOW ME THE VALUE
	{
		if($value != "" && in_array($key, $not_people_fields) == FALSE) // THERE IS A VALUE AND THE KEY IS NOT ON THE BAD LIST
		{
			$update_people_fields = (get_magic_quotes_gpc()) ? $update_people_fields . $key . " = '" . $value . "', " : $update_people_fields . $key . " = '" . addslashes($value) . "', ";
		}
	}
	$update_people_fields = $update_people_fields . " last_modified = '" . date("Y-m-d H:i:s") . "'";
	$sql_people = "UPDATE " . $people_table . " SET " . $update_people_fields . " WHERE ID = '" . $_POST['id'] . "' LIMIT 1"; // UPDATE SQL
	echo $sql_people . "<hr/>";
	$result = safe_query($sql_people);
}

function insert_people()
{
//	global $ID;  					// PEOPLE ID	//TETSING
	global $people_table;
	global $not_people_fields;	
	global $new_person;  			// PEOPLE YOU ALREADY KNOW?
	$insert_people_fields = "";		// FIELDS TO INSERT
	$insert_people_values = "";		// VALUES FOR THOSE FIELDS

	
	foreach($_POST as $key => $value)  // FOR EACH KEY IN THE POST ARRAY SHOW ME THE VALUE
	{
		if($value != "" && in_array($key, $not_people_fields) == FALSE) // THERE IS A VALUE AND THE KEY NOT ON THE BAD LIST
		{
			$insert_people_fields = $insert_people_fields . $key . ", ";
			$insert_people_values = (get_magic_quotes_gpc()) ? $insert_people_values . "'" . $value . "', " : $insert_people_values . "'" . addslashes($value) . "', ";
		}
	}
	
	$insert_people_fields .= "user_id, ";
	$insert_people_fields .= "source, ";
	$insert_people_fields .= "created_on, ";
	$insert_people_fields .= "last_modified";
		
	$insert_people_values .= "'" . strtoupper(substr(remove_char($_POST["last"] . $_POST["first"] . $_POST["email"]) , 0, 3)) . rand(1111,9999) . "', ";
	$insert_people_values .= "'email opt-in', ";
	$insert_people_values .= "'" . date("Y-m-d H:i:s") . "', ";
	$insert_people_values .= "'" . date("Y-m-d H:i:s") . "'";
	
// REAL	$sql_sn2005 = "INSERT INTO people (" . $insert_people_fields . ") VALUES (" . $insert_people_values . ")"; // INSERT SQL SN2005
	$sql_people = "INSERT INTO " . $people_table . " (" . $insert_people_fields . ") VALUES (" . $insert_people_values . ")"; // INSERT SQL SN2005 //TESTING
	$result = safe_query($sql_people);
	echo $sql_people . "<hr/>";
	return(mysql_insert_id());
}

function add_to_list($id)
{
   		$query = "INSERT  INTO people_tags( people_id, user_id, tag, is_email_tag, Time_Added ) 
					SELECT ID,  user_id, " . $_POST["email_list"] . ", 1, NOW() 
					FROM people
						WHERE ID
						IN ($id) ";
		echo $query . "<hr/><hr/>";
		safe_query($query);
}
?>