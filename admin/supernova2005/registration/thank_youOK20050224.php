<?php
require "inc_db.php";
$people_table = "people";  // "PEOPLE_TESTING" IS THE TESING TABLE

if ($_POST['email'] != "")
{
	dbconnect();

	$payment_received = "no"; // NOTHING HAS BEEN PAIDED FOR
	$status = "";	// SEMINAR STATUS -> registerd
	$cc_declined_reason = "N/A";  // MADE UP DEFULT REASON FOR DECLINED CC - IN CAPS SO I CAN TELL IT IS NOT SET BY A.N AIM
	$cc_trans_id = ""; // AUTHOIZE.NET TRANSACTION ID
	$ID = "";
	$seminar_description = seminar_desc($_POST["seminar_event"]);
	$email_alias = "";

	
	// QUERY FOR DISPLAYING RESULTS
	$where_clause = "WHERE email = '" . $_POST['email'] . "'";
	$query = "select * from " . $people_table . " " . $where_clause . " LIMIT 0 , 1";
	$result = safe_query($query);

	if ($result)		// QUERY WAS SUCCESSFUL
	{
		$n_rows = mysql_num_rows($result);		// HOW MANY ROWS?
		if ($n_rows == 1)				// THERE IS ONE RECORD IN THE DB -> DO UPDATE
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$ID = $row["ID"];				// GET PEOPLE ID FROM PEOPLE
			$new_person = "no";				// THEY ARE AN OLD PERSON - THEY WERE IN THE DB
			update_people();				// UPDATE ANY NEW INFORMATION
		}
		elseif ($n_rows > 1)  // MORE THAN 1 ROW... THIS SHOULD NEVER HAPPEN
		{
			echo "There are multiple records for you in the database.  Please email ddinatale@w3on.com with this information";
		}
		else	// THERE IS NOT A MATCHING RECORD IN THE DB -> DO INSERT
		{
			$new_person = "yes";				// NOT PREVIOUSLY IN DB => NEW PERSON
			$ID = insert_people();					// PUT THEM IN THE PEOPLE TABLE
		}
		
		
		
// THESE THINGS ARE HAPPENING NO MATTER HOW MANY ROWS ARE FOUND		
		if($_POST['amount'] == 0 || $_POST['payment_method'] != "credit card")			// DIDN'T HAVE TO PAY
		{
			$payment_received = "yes";		// MIGHT AS WELL HAVE PAID
			$status = "registered";
		}
		else
		{
		authorize_aim();		// FUNCTION THAT MAKES PAYMENT // 1 -> CC APPROVED, 2 -> DECLINED, 3 -> ERROR
		//	$status = "????"; 	//TESTING - Registered or Pending WHATEVER IS THE APPROPRIATE OUTCOME
		}
		
		// CHECK TO SEE IF THEY HAVE ALREADY REGISTERD
		$sn2005_where_clause = "WHERE people_id = $ID";
		$sn2005_query = "select people_id from supernova_2005 " . $sn2005_where_clause . " LIMIT 0 , 1";
		$sn2005_result = safe_query($sn2005_query);
		$sn_rows = mysql_num_rows($sn2005_result);		// HOW MANY ROWS?
		
		if ($sn_rows == 0)				// THEY ARE REGISTERING FOR THE FIRST TIME
		{
			insert_sn2005(); 			// PUT THEM INTO THE SN 2005 TABLE
			
		}
		else
		{
			update_sn2005();			// REREGISTERING AND ARE ALREADY IN THE SN 2005 TABLE
		}
		create_sn_email_alais();  	// CRESTE AN EMAIL ALIAS FOR THEM -> FIRST_LASTID@supernova2005.com
		send_confirm_email($email_alias, $ID);		// LET THEM KNOW HOW THE OUTCOME VIA EMAIL
	}
	else // QUERY FAILED
	{
		echo "Bad Query!!!";
	}
	thank_you();		//WRITE THE THANK YOU PAGE - LET THEM KNOW HOW THE OUTCOME VIA BROWSER
	
}
else
{
	header("Location: register.php"); /* Redirect browser */
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
// FUNTIONS BELOW /////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

function update_people()
{
	global $people_table;
	$update_people_fields = "";
	$not_people_fields = array("submit",
								"priority_code",
								"category",
								"confirm_email",
								"email_format",
								"seminar_event",
								"showcase",
								"amount",
								"same_billing",
								"payment_method",
								"billing_first",
								"billing_last",
								"billing_address1",
								"billing_city",
								"billing_state",
								"billing_zip",
								"cc_type",
								"cc_number",
								"expire_month",
								"expire_year");  // THESE FIELDS ARE **NOT** IN THE PEOPLE TABLE SO DON'T USE THEM
	foreach($_POST as $key => $value)  // FOR EACH KEY IN THE POST ARRAY SHOW ME THE VALUE
	{
		if($value != "" && in_array($key, $not_people_fields) == FALSE) // THERE IS A VALUE AND THE KEY IS NOT ON THE BAD LIST
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
	$update_people_fields = $update_people_fields . " last_modified = '" . date("Y-m-d H:i:s") . "'";
	$sql_people = "UPDATE " . $people_table . " SET " . $update_people_fields . " WHERE email = '" . $_POST['email'] . "' LIMIT 1"; // UPDATE SQL
	$result = safe_query($sql_people);
}

function insert_people()
{
//	global $ID;  			// PEOPLE ID	//TETSING
	global $people_table;
	global $new_person;  	// PEOPLE YOU ALREADY KNOW?
	$insert_people_fields = "";		// FIELDS TO INSERT
	$insert_people_values = "";		// VALUES FOR THOSE FIELDS

	$not_people_fields = array("submit",
								"priority_code",
								"category",
								"confirm_email",
								"email_format",
								"seminar_event",
								"showcase",
								"amount",
								"same_billing",
								"payment_method",
								"billing_first",
								"billing_last",
								"billing_address1",
								"billing_city",
								"billing_state",
								"billing_zip",
								"cc_type",
								"cc_number",
								"expire_month",
								"expire_year");  // THESE FIELDS ARE **NOT** IN THE PEOPLE TABLE SO DON'T USE THEM
	foreach($_POST as $key => $value)  // FOR EACH KEY IN THE POST ARRAY SHOW ME THE VALUE
	{
		if($value != "" && in_array($key, $not_people_fields) == FALSE) // THERE IS A VALUE AND THE KEY NOT ON THE BAD LIST
		{
			$insert_people_fields = $insert_people_fields . $key . ", ";
			$insert_people_values = (get_magic_quotes_gpc()) ? $insert_people_values . "'" . $value . "', " : $insert_people_values . "'" . addslashes($value) . "', ";
		}
	}
	
	$insert_people_fields .= "source, ";
	$insert_people_fields .= "created_on, ";
	$insert_people_fields .= "last_modified";
	
	$insert_people_values .= "'Supernova 2005', ";
	$insert_people_values .= "'" . date("Y-m-d H:i:s") . "', ";
	$insert_people_values .= "'" . date("Y-m-d H:i:s") . "'";
	
// REAL	$sql_sn2005 = "INSERT INTO people (" . $insert_people_fields . ") VALUES (" . $insert_people_values . ")"; // INSERT SQL SN2005
	$sql_sn2005 = "INSERT INTO " . $people_table . " (" . $insert_people_fields . ") VALUES (" . $insert_people_values . ")"; // INSERT SQL SN2005 //TESTING
	$result = safe_query($sql_sn2005);
	return(mysql_insert_id());
}

function insert_sn2005()
{
	global $ID;  // PEOPLE ID
	global $new_person; // NEW OR OLD PERSON
	global $payment_received;
	global $status;
	global $cc_trans_id;
	global $cc_declined_reason;
		
	$insert_sn2005_fields = "";
	$insert_sn2005_values = "";

	$sn2005_fields = array("seminar_event","showcase","priority_code","category","amount","email_format","status","payment_method","cc_trans_id","last_modified");  // supernova_2005 FIELDS -> GOOD LIST
	foreach($_POST as $key => $value)  // FOR EACH KEY IN THE POST ARRAY SHOW ME THE VALUE
	{
		if($value != "" && in_array($key, $sn2005_fields) == TRUE) // THERE IS A VALUE AND THE KEY IS IN THE GOOD LIST
		{
			$insert_sn2005_fields = $insert_sn2005_fields . $key . ", ";
			$insert_sn2005_values = (get_magic_quotes_gpc()) ? $insert_sn2005_values . "'" . $value . "', " : $insert_sn2005_values . "'" . addslashes($value) . "', ";			
		}
	}
	$insert_sn2005_fields = "people_id, " . $insert_sn2005_fields;
	$insert_sn2005_fields .= "date_registered, ";
	$insert_sn2005_fields .= "status, ";
	$insert_sn2005_fields .= "cc_trans_id, ";
	$insert_sn2005_fields .= "cc_declined_reason, ";
	$insert_sn2005_fields .= "payment_received, ";
	$insert_sn2005_fields .= "new_person, ";
	$insert_sn2005_fields .= "ip, ";
	$insert_sn2005_fields .= "host, ";
	$insert_sn2005_fields .= "browser, ";
	$insert_sn2005_fields .= "last_modified";
	
	$insert_sn2005_values = $ID . ", ". $insert_sn2005_values;
	$insert_sn2005_values .= "'" . date("Y-m-d") . "', ";
	$insert_sn2005_values .= "'" . $status  . "', ";
	$insert_sn2005_values .= "'" . $cc_trans_id  . "', ";
	$insert_sn2005_values .= "'" . $cc_declined_reason  . "', ";
	$insert_sn2005_values .= "'" . $payment_received  . "', ";
	$insert_sn2005_values .= "'" . $new_person . "', ";
	$insert_sn2005_values .= "'" . $_SERVER['REMOTE_ADDR'] . "', ";
	$insert_sn2005_values .= "'" . $_SERVER['REMOTE_HOST'] . "', ";
	$insert_sn2005_values .= "'" . $_SERVER['HTTP_USER_AGENT'] . "', ";
	$insert_sn2005_values .= "'" . date("Y-m-d H:i:s") . "'";
	
	
	$sql_sn2005 = "INSERT INTO supernova_2005 (" . $insert_sn2005_fields . ") VALUES (" . $insert_sn2005_values . ")"; // INSERT SQL SN2005
	$result = safe_query($sql_sn2005);
}

function update_sn2005()
{
	global $ID;  // PEOPLE ID
	global $new_person; // NEW OR OLD PERSON
	global $payment_received;
	global $status;
	global $cc_trans_id;
	global $cc_declined_reason;
	
	$update_sn2005_fields = "";

	$sn2005_fields = array("seminar_event","showcase","priority_code","category","amount","email_format","status","payment_method","cc_trans_id","last_modified");  // supernova_2005 FIELDS -> GOOD LIST
	foreach($_POST as $key => $value)  // FOR EACH KEY IN THE POST ARRAY SHOW ME THE VALUE
	{
		if($value != "" && in_array($key, $sn2005_fields) == TRUE) // THERE IS A VALUE AND THE KEY IS IN THE GOOD LIST
		{
			if(get_magic_quotes_gpc() == 1)  // MAGIC QUOTES OR WHAT
			{
				$update_sn2005_fields = $update_sn2005_fields . $key . " = '" . $value . "', ";
			}
			else	// NO MAGIC, ADD SLASHES
			{
				$update_sn2005_fields = $update_sn2005_fields . $key . " = '" . addslashes($value) . "', ";
			}
		}
	}

	
	$update_sn2005_fields .= " payment_received = '" . $payment_received . "', ";
	$update_sn2005_fields .= " cc_trans_id = '" . $cc_trans_id . "', ";
	$update_sn2005_fields .= " cc_declined_reason = '" . $cc_declined_reason . "', ";
	$update_sn2005_fields .= " status = '" . $status . "', ";
	$update_sn2005_fields .= " date_registered = '" . date("Y-m-d") . "', ";
	$update_sn2005_fields .= " last_modified = '" . date("Y-m-d H:i:s") . "'";
	$sql_sn2005 = "UPDATE supernova_2005 SET " . $update_sn2005_fields . " WHERE people_id = '" . $ID . "' LIMIT 1"; // UPDATE SQL
	$result = safe_query($sql_sn2005);	

}

function create_sn_email_alais()
{
	// remove bad characters (' " " ,)
	global $ID;  // PEOPLE ID
	global $email_alias;

	$email_query = "SELECT * FROM email_aliases WHERE people_id = " . $ID;
	$result = safe_query($email_query);	
	$n_rows = mysql_num_rows($result);		// HOW MANY ROWS?
	
	if($n_rows == 0)
	{
		$email_alias = $_POST['first'] . "_" . $_POST['last'] .  ltrim($ID + 17, "0") . "@supernova2005.com";
		$email_alias = remove_char($email_alias);
	
		$insert_alias_fields = "";
		$insert_alias_fields .= "people_id, ";
		$insert_alias_fields .= "email_alias, ";
		$insert_alias_fields .= "real_email, ";
		$insert_alias_fields .= "status, ";
		$insert_alias_fields .= "last_modified";
	
		$insert_alias_values = "";
		$insert_alias_values .= "'" . $ID . "', ";	// people.ID
		$insert_alias_values .= "'" . $email_alias . "', ";
		$insert_alias_values .= "'" . $_POST['email'] . "', ";
		$insert_alias_values .= "'not activated', ";
		$insert_alias_values .= "'" . date("Y-m-d H:i:s") . "'";
		
	
		$sql_alias = "INSERT INTO email_aliases (" . $insert_alias_fields . ") VALUES (" . $insert_alias_values . ")"; // INSERT SQL EMAIL_ALIAS
		$result = safe_query($sql_alias);
	}
	else
	{
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$email_alias = $row["email_alias"];
	}

}

function remove_char($str)
{
	$str = str_replace("'", "", $str);
	$str = str_replace(" ", "", $str);
	return $str;
}



function authorize_aim()
{
	global $cc_declined_reason;
	
	$auth_net_login_id			= "Supernova978";
	$auth_net_tran_key			= "iLlMW6PEuJHe8hMD";
	$auth_net_url				= "https://certification.authorize.net/gateway/transact.dll";
	
	$authnet_values				= array
	(
		"x_login"				=> $auth_net_login_id,
		"x_version"				=> "3.1",
		"x_delim_char"			=> "|",
		"x_delim_data"			=> "TRUE",
		"x_url"					=> "FALSE",
		"x_test_request"		=> "FALSE",
		"x_type"				=> "AUTH_CAPTURE",
		"x_method"				=> "CC",
	 	"x_tran_key"			=> $auth_net_tran_key,
	 	"x_relay_response"		=> "FALSE",
		"x_card_num"			=> $_POST["cc_number"],
		"x_exp_date"			=> $_POST["expire_month"] . $_POST["expire_year"],
		"x_description"			=> "Supernova 2005: " . $_POST["seminar_event"],
		"x_amount"				=> $_POST["amount"],
		"x_first_name"			=> $_POST["billing_first"],
		"x_last_name"			=> $_POST["billing_last"],
		"x_address"				=> $_POST["billing_address1"],
		"x_city"				=> $_POST["billing_city"],
		"x_state"				=> $_POST["billing_state"],
		"x_zip"					=> $_POST["billing_zip"],
		"PriorityCode"			=> $_POST["priority_code"],
	);
	
	$fields = "";
	foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";
	

// Post the transaction (see the code for specific information):

//TESTING	$ch = curl_init("https://certification.authorize.net/gateway/transact.dll"); // URL of gateway for cURL to post to <-- USE THIS ONE FOR TESTING
	$ch = curl_init("https://secure.authorize.net/gateway/transact.dll"); // <-- USE THIS ONE FOR LIVE CC PROCESSING
	curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
	curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); // use HTTP POST to send form data
	$resp = curl_exec($ch); //execute post and get results
	curl_close ($ch);

	$pieces = explode("|", $resp);

	global $payment_received;
	global $status;
	global $cc_trans_id;
	global $cc_declined_reason;
	if ($pieces[0] == 1)  	// APPROVED -> GREAT
	{
		$payment_received = "yes";
		$msg = "<p><font color=\"#2CE012\">Your credit card payment has been approved.</font></p> <!--  Your transaction number is " . $pieces[6] . "-->";
		$status = "registered";
		$cc_trans_id = $pieces[6];
		$cc_declined_reason = "n/a";
	}
	else 					// NOT APPROVED -> NOT SO GREAT
	{
		$payment_received = "no";
		$cc_declined_reason = $pieces[3];
		$status = "pending";
	}

}

function seminar_desc($se)
{

	switch ($se)
	{
		case "Wharton West Workshop Day":
			$sem_desc_str = "the Wharton West Workshop and Technology Showcase on June 20";
			break;
		case "2-day Main Conference":
			$sem_desc_str = "the main conference, June 21 -22";
			break;
		case "Full Conference":
			$sem_desc_str = "the full 3-day conference, June 20 - 22";
			break;
		default	:
			$sem_desc_str = "the conference";
	}
	return $sem_desc_str;
}







// SEND THE MAIL
function send_confirm_email($ea, $eif)
{
	global $seminar_description;
	global $payment_received;
	global $cc_declined_reason;

$body = "<html><head></head><body>";

if($payment_received == "no")
{
$supernova_logo = "<div align=\"center\"><img src=\"http://www.supernova2005.com/registration/snglogo.jpg?id=$eif\" /></div>";		// THE "G" IS FOR GOOD
$subject = "Supernova 2005 Registration - PENDING ";
$body .= <<<EOQ
<p>Your payment has not been accepted (Reason: $cc_declined_reason).  We have saved your registration information, pending confirmation of the payment.  If you believe your payment has been rejected in error, please re-submit the form.  Otherwise, please contact us <email> to confirm your payment.</p>

Thanks.
EOQ;
}
else  // PAYMENT HAS BEEN RECEVIED
{
$supernova_logo = "<div align=\"center\"><img src=\"http://www.supernova2005.com/registration/snblogo.jpg?id=$eif\"/></div>";	// THE "B" IS FOR BAD
$subject = "Supernova 2005 Registration Confirmation";
$body .= "<p>Dear " . $_POST["first"] . ", </p>\n";
$body .= <<<EOQ

<p>We are thrilled you will be joining us at Supernova 2005, June 20 - 22, in San Francisco, CA. Your confirmed conference registration entitles you to attend:  $seminar_description </p>

<p>You and all conference participants are invited to our kick-off networking event -- The Wharton West Technology Showcase -- on Monday, June 20, from 5:30pm to 8:30pm at the Wharton West facility. Registration for the main conference will be available at Wharton West all day on June 20, and at the Palace Hotel on June 21, beginning at 7:30am.  Please visit our Web site for additional information and maps to the <a href="http://www.supernova2005.com/venue.html">Conference venues</a>.</p>

<p>You are responsible for your own hotel accommodations. We have arranged for a block of rooms at the Palace Hotel, where the conference will be held, at a discounted conference rate of $239 until May 27, 2005. You can <a href="http://www.starwoodmeeting.com/StarGroupsWeb/res?id=0501316836&key=42857">make reservations</a> directly on the Supernova conference Website.</p>

<p>We will be creating a special Supernova email alias for you.  This will allow you to contact other conference attendees without revealing your private email address, and will give you access to personalized content on the Supernova Community Connection. You will receive email notification when your email alias has been activated, prior to the conference.  Your email alias will be ($ea).</p>

<p>As the conference approaches, check the <a href="http://www.supernova2005.com">Supernova Website</a> for additional details on speakers, sessions, and conference-related events.  </p>

<p>We look forward to seeing you in San Francisco!</p>

<p>Kevin Werbach, and the Supernova Group</p>

Email: <a href="mailto:info@supernovagroup.net">info@supernovagroup.net</a><br />
Web: <a href="http://www.supernova2005.com/">www.supernova2005.com</a><br />
</body>
</html>

EOQ;

}

// end email body ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////


	$to = $_POST['email'];
	$headers .= 'From: Supernova Group <info@supernovagroup.net>' . "\r\n";
	$headers .= 'Bcc: ddinatale@w3on.com' . "\r\n";
	if ($_POST["email_format"] != "Plain Text")  // USING HTML
	{
		$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
		$body = $supernova_logo . $body;					// PUT HEADER IMAGE
	}
	else  // PLAIN TEXT PLEASE
	{
		$body = strip_tags($body);							//PLAIN TEXT SO REMOVE HTML
	}

mail($to,$subject,$body,$headers);  						// SEND IT
}


function thank_you()
{


echo <<<EOQ

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
<td width="42" background="../images/background_left.gif"></td>
<td width="780" bgcolor="#FFFFFF">

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="304" height="155" valign="top"><a href="http://www.supernova2005.com"><img src="../images/logo.gif" width="304" height="155" alt="Home" border="0"></a></td>
	<td width="476"><img src="../images/tagline.gif" width="476" height="155"></td>
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="108"><img src="../images/topcorner.gif" width="108" height="45" alt=""></td>
	<td width="8"></td>
	<td width="1" bgcolor="#FFA813"></td>
	<td width="663">
	
		<table border="0" cellpadding="0" cellspacing="0">
		
		<tr>
		<td width="17" height="24" bgcolor="#FFA813" valign="top"></td>
		<td width="646" height="24" bgcolor="#FFA813" valign="middle">
		<font face="verdana,arial" size="2" color="#FFFFFF">
		
		<a href="../about.htm" style="color:FFFFFF"><b>About Supernova</b></a> | 
		<a href="register.php" style="color:FFFFFF"><b>Register</b></a> | 
		<a href="../community_connection.htm" style="color:FFFFFF"><b>Community Connection</b></a> | 
		<a href="../community_connection.htm" style="color:FFFFFF"><b>Weblog</b></a> | 
		<a href="../contact.htm" style="color:FFFFFF"><b>Contact Us</b></a>
		
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
	
	<a href="../program_overview.htm" style="color:7E7E7E" title="Agenda At-A-Glance">Program Overview</a>
	<br><br>
	<a href="../sessions.htm" style="color:7E7E7E" title="Session Descriptions and Technology Spotlight">Sessions</a>
	<br><br>
	<a href="../workshops.htm" style="color:7E7E7E">Workshops</a>
	<br><br>
	<a href="../special_events.htm" style="color:7E7E7E">Special Events</a>
	<br><br>
	<a href="../speakers.htm" style="color:7E7E7E">Speakers</a>
	<br><br>
	<a href="../sponsors.htm" style="color:7E7E7E">Sponsors</a>
	<br><br>
	<a href="../venue.htm" style="color:7E7E7E" title="Information on the Palace Hotel and maps to Wharton West">Venue</a>
	<br><br><br><br><br><br>
	<img src="../images/palacehotel.jpg" width="111" height="189" alt="Palace Hotel">
	<br><br><br>
	<a href="http://www.wharton.upenn.edu/campus/wharton_west"><img src="../images/whartonwest.jpg" width"111" height"215" alt="Wharton West" border="0"></a>
	<br><br>
	</td>
	<td width="5"></td>
	<td width="1" valign="top"><img src="../images/yellowline.gif" width="1" height="195" alt=""></td>
	<td width="17"></td>
	<td width="502" valign="top">
	<font face="verdana,arial" size="2">


<!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->
	<p><img src="../images/head_register.gif" width="502" height="50" alt="Register">
	<br>
	
EOQ;


/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////// THANK YOU PAGE BODY ///////////////////// THANK YOU PAGE BODY ///////////////////////
///VVVV//////////////////VVVV//////////////////VVVV/////////////////////////VVVV//////////////VVVV///////
global $ID;
global $email_alias;
global $seminar_description;
global $payment_received;
global $cc_declined_reason;

	if ($payment_received == "yes")  	// APPROVED -> GREAT
	{
			if($_POST["payment_method"] == "credit card" && $_POST["amount"] > 0) // YOU ARE PAYING MORE THAN $0 WITH A CC
			{
				$msg .=		"<p><font color=\"#FFAA10\">Your credit card payment has been approved.</font></p> <!--  Your transaction number is " . $pieces[6] . "-->";
			}
			
			$msg .= 	<<<EOQ

			<p>We are thrilled you will be joining us for the Supernova 2005 Conference, June 20 - 22, in San Francisco, CA. Your confirmed Supernova conference pass entitles you to attend: $seminar_description.</p>

			<p>You will be receiving a confirmation email that will serve as your proof of registration.</p>
			
			<p>We look forward to seeing you in San Francisco!</p>
			
			<p>Kevin Werbach, and the Supernova Group</p>
			
			Email: <a href="mailto:info@supernovagroup.net">info@supernovagroup.net</a><br />
			Web: <a href="http://www.supernova2005.com/">www.supernova2005.com</a><br /><br />
EOQ;
	}
	else 					// NOT APPROVED -> NOT SO GREAT
	{
		$msg = "<p><font color=\"#FF0000\">Your payment has not been accepted (Reason: " . $cc_declined_reason . ").  We have saved your registration information, pending confirmation of the payment.  If you believe your payment has been rejected in error, please <a href=\"register.php\">re-submit the form</a>.  Otherwise, please contact us <a href=\"mailto:info@supernovagroup.net?subject=Payment+Declined\">info@supernovagroup.net</a> to confirm your payment.</p><p>Thanks.</p><br /></font>";
	}


echo $_POST["first"] . ",<br/><br/> Thank you for registering.<br><br>";
echo $msg;


/////////^^^^////////////^^^^/////////////////////////^^^^///////////////^^^^///////////////^^^^/////
/////////////////// THANK YOU PAGE BODY ///////////////////// THANK YOU PAGE BODY ///////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
echo <<<EOQ
<!-- ----------------- ENTER MAIN CONTENT ABOVE ------------------------ -->
</td>
	
	<td width="8"></td>
	<td width="1" bgcolor="#FFA813" valign="top"><img src="../images/spacer.gif" width="1" height="50" alt=""></td>
	<td width="10" valign="bottom" align="right"><img src="../images/shadepiece.gif" width="10" height="10" alt=""></td>
	<td width="125" height="100%" valign="top">
		
		<table border="0" cellpadding="0" cellspacing="0" height="100%">
		
		<tr>
		<td width="125" valign="top" height="100%">
		<img src="../images/spacer.gif" width="1" height="50" alt=""><br>		
		
		<font face="verdana,arial" size="1" color="#FFA813">

<!-- ----------------- SPONSOR AREA ------------------------ -->
		<b>PRODUCED IN PARTNERSHIP WITH
		<br>
		<img src="../images/logo_wharton.gif" width="119" height="48" alt="The Wharton School">
		<br><br>
		
		</td>
		</tr>
		
		<tr>
		<td width="125" height="100%" valign="bottom"><img src="../images/bottomcorner.gif" alt="" width="125" height="56" align="bottom"></td>
		</tr>
		
		</table>
		
	    
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="645" height="1" bgcolor="#FFA813"></td>
	<td><img src="../images/bottomcornerslice.gif" width="135" height="1" alt=""></td>
	</tr>
	
	</table>

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="134"><img src="../images/spacer.gif"  width="134" height="31" ></td>
	<td width="373"><font face="verdana,arial" size="1" color="#7E7E7E">
	©2005 Supernova Group LLC</font>
	</td>
	<td width="273"><img src="../images/bottommiddle.gif" width="273" height="31" alt=""></td>
	</tr>
	
	<tr>
	<td colspan="3"><img src="../images/bottom.gif" width="780" height="52" alt=""></td>
	</tr>
	
	</table>

</td>
<td width="42" background="../images/background_right.gif"></td>
</tr>

</table>
</center>

</html>
EOQ;
}

?>