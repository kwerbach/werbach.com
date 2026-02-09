<?php
require "inc_db.php";
$people_table 	= "people"; 	 // "PEOPLE_TESTING" IS THE TESING TABLE
$is_test	=	"_test";		// "_test" --> testing or "" --> live
// THINGS TO CHANGE YEAR TO YEAR - BEGIN

$reg_year 		= "2008";					// CHANGE THIS EVERY YEAR
$conf_dates		= "June 16-18, 2008";		// e.g. June 20-22, 2007
$conf_domain	= "supernova2008.com";		// NOT IN USE YET 1/4/2007
$conf_city		= "San Francisco, CA";		// e.g. San Francisco, CA



// THINGS TO CHANGE YEAR TO YEAR - END

if ($_POST['email'] != "")
{
	dbconnect();

	$payment_received 		= "no"; 	// NOTHING HAS BEEN PAIDED FOR
	$status 				= "";		// SEMINAR STATUS -> registerd
	$cc_declined_reason 	= "N/A";  	// MADE UP DEFULT REASON FOR DECLINED CC - IN CAPS SO I CAN TELL IT IS NOT SET BY A.N AIM
	$cc_trans_id 			= ""; 		// AUTHOIZE.NET TRANSACTION ID
	$ID 					= "";		// THE people TABLE ID
	$seminar_description 	= seminar_desc($_POST["seminar_event"]);
	$email_alias = "";

	
	// QUERY FOR DISPLAYING RESULTS
	$where_clause 	= "WHERE email = '" . $_POST['email'] . "'";
	$query 			= "select * from " . $people_table . " " . $where_clause . " LIMIT 0 , 1";
	$result 		= safe_query($query);

	if ($result)							// QUERY WAS SUCCESSFUL
	{
		$n_rows = mysql_num_rows($result);	// HOW MANY ROWS?
		if ($n_rows == 1)					// THERE IS ONE RECORD IN THE DB -> DO UPDATE
		{
			$row 		= mysql_fetch_array($result, MYSQL_ASSOC);
			$ID 		= $row["ID"];		// GET PEOPLE ID FROM PEOPLE
			$new_person = "no";				// THEY ARE AN OLD PERSON - THEY WERE IN THE DB
			update_people();				// UPDATE ANY NEW INFORMATION
		}
		elseif ($n_rows > 1)  				// MORE THAN 1 ROW... THIS SHOULD NEVER HAPPEN
		{
			echo "There are multiple records for you in the database.  Please email ddinatale@w3on.com with this information";
		}
		else								// THERE IS NOT A MATCHING RECORD IN THE DB -> DO INSERT
		{
			$new_person = "yes";			// NOT PREVIOUSLY IN DB => NEW PERSON
			$ID = insert_people();			// PUT THEM IN THE PEOPLE TABLE
		}
		
		
		
// THESE THINGS ARE HAPPENING NO MATTER HOW MANY ROWS ARE FOUND		
		if($_POST['amount'] == 0 || $_POST['payment_method'] != "credit card")			// DIDN'T HAVE TO PAY?
		{
			$payment_received 	= "no";		// MIGHT AS WELL HAVE PAID
			$status 			= "registered";
			if($_POST['amount'] == 0)			// IF YOUR AMOUNT IS $0
			{
				$payment_received = "n/a";		// PAYMENT IS N/A
			}
		}
		else
		{
			authorize_aim();		// FUNCTION THAT MAKES PAYMENT // 1 -> CC APPROVED, 2 -> DECLINED, 3 -> ERROR
		}
		
		// CHECK TO SEE IF THEY HAVE ALREADY REGISTERD
		$sn_where_clause = "WHERE people_id = $ID";
		$sn_reg_query = "select people_id from supernova_registrations " . $sn_where_clause . " LIMIT 0 , 1";
		$sn_reg_result = safe_query($sn_reg_query);
		$sn_rows = mysql_num_rows($sn_reg_result);		// HOW MANY ROWS?
		
		if ($sn_rows == 0)								// THEY ARE REGISTERING FOR THE FIRST TIME
		{
			insert_sn_reg(); 							// PUT THEM INTO THE supernova_registrations TABLE
			
		}
		else									// THEY HAVE ALREADY REGISTERED
		{
			update_sn_reg();					// REREGISTERING AND ARE ALREADY IN THE supernova_registrations TABLE
		}
		create_sn_email_alais();  				// CREATE AN EMAIL ALIAS FOR THEM -> FIRST_LASTID@supernova20xx.com
		send_confirm_email($email_alias, $ID);	// LET THEM KNOW HOW THE OUTCOME VIA EMAIL
	}
	else 				// QUERY FAILED
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
	global $reg_year;
	$update_people_fields = "";
	$not_people_fields = array("submit",
								"priority_code",
								"category",
								"priority_code_description",
								"confirm_email",
								"email_format",
								"meals",
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
								"billing_country",
								"cc_type",
								"cc_number",
								"expire_month",
								"expire_year");  	// THESE FIELDS ARE **NOT** IN THE PEOPLE TABLE SO DON'T USE THEM
	foreach($_POST as $key => $value)  				// FOR EACH KEY IN THE POST ARRAY SHOW ME THE VALUE
	{
		if($value != "" && in_array($key, $not_people_fields) == FALSE) // THERE IS A VALUE AND THE KEY IS NOT ON THE BAD LIST
		{
			if(get_magic_quotes_gpc() == 1)  		// IF MAGIC QUOTES = YES
			{
				$update_people_fields = $update_people_fields . $key . " = '" . $value . "', ";
			}
			else									// NO MAGIC, ADD SLASHES
			{
				$update_people_fields = $update_people_fields . $key . " = '" . addslashes($value) . "', ";
			}
		}
	}
	$update_people_fields 	= $update_people_fields . " last_modified = '" . date("Y-m-d H:i:s") . "'";
	$sql_people 			= "UPDATE " . $people_table . " SET " . $update_people_fields . " WHERE email = '" . $_POST['email'] . "' LIMIT 1"; // UPDATE SQL
	$result 				= safe_query($sql_people);
}

function insert_people()
{
	global $people_table;
	global $new_person;  			// PEOPLE YOU ALREADY KNOW?
	global $reg_year;				// YEAR OF REGISTRATION
	$insert_people_fields = "";		// FIELDS TO INSERT
	$insert_people_values = "";		// VALUES FOR THOSE FIELDS

	$not_people_fields = array("submit",
								"priority_code",
								"category",
								"priority_code_description",
								"confirm_email",
								"email_format",
								"meals",
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
								"billing_country",
								"cc_type",
								"cc_number",
								"expire_month",
								"expire_year");  // THESE FIELDS ARE **NOT** IN THE PEOPLE TABLE SO DON'T USE THEM
	foreach($_POST as $key => $value)  			// FOR EACH KEY IN THE POST ARRAY SHOW ME THE VALUE
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
	$insert_people_values .= "'Supernova " . $reg_year . "', ";					// CHANGE FOR SUBSEQUENT YEARS
	$insert_people_values .= "'" . date("Y-m-d H:i:s") . "', ";
	$insert_people_values .= "'" . date("Y-m-d H:i:s") . "'";
	
	$sql_people = "INSERT INTO " . $people_table . " (" . $insert_people_fields . ") VALUES (" . $insert_people_values . ")"; // INSERT SQL people TABLE
	$result 	= safe_query($sql_people);
	return(mysql_insert_id());
}

function insert_sn_reg()	// INSERT PEOPLE INTO THE REGISTRATION TABLE
{
	global $ID;  			// PEOPLE ID
	global $new_person; 	// NEW OR OLD PERSON
	global $reg_year;		// YEAR OF REGISTRATION
	global $payment_received;
	global $status;
	global $cc_trans_id;
	global $cc_declined_reason;
		
	$insert_sn_reg_fields = "";
	$insert_sn_reg_values = "";

	$sn_reg_fields = array("seminar_event","showcase","meals","priority_code","category","priority_code_description","amount","email_format","status","payment_method","cc_trans_id","last_modified");  // supernova_registrations FIELDS -> GOOD LIST
	foreach($_POST as $key => $value)  								// FOR EACH KEY IN THE POST ARRAY SHOW ME THE VALUE
	{
		if($value != "" && in_array($key, $sn_reg_fields) == TRUE) 	// THERE IS A VALUE AND THE KEY IS IN THE GOOD LIST
		{
			$insert_sn_reg_fields = $insert_sn_reg_fields . $key . ", ";
			$insert_sn_reg_values = (get_magic_quotes_gpc()) ? $insert_sn_reg_values . "'" . $value . "', " : $insert_sn_reg_values . "'" . addslashes($value) . "', ";			
		}
	}
	$insert_sn_reg_fields = "people_id, " . $insert_sn_reg_fields;
	$insert_sn_reg_fields .= "seminar_year, ";
	$insert_sn_reg_fields .= "date_registered, ";
	$insert_sn_reg_fields .= "status, ";
	$insert_sn_reg_fields .= "cc_trans_id, ";
	$insert_sn_reg_fields .= "cc_declined_reason, ";
	$insert_sn_reg_fields .= "payment_received, ";
	$insert_sn_reg_fields .= "new_person, ";
	$insert_sn_reg_fields .= "ip, ";
	$insert_sn_reg_fields .= "host, ";
	$insert_sn_reg_fields .= "browser, ";
	$insert_sn_reg_fields .= "last_modified";
	
	$insert_sn_reg_values = $ID . ", ". $insert_sn_reg_values;
	$insert_sn_reg_values .= "'" . $reg_year . "', ";				// CHANGE FOR SUBSEQUENT YEARS
	$insert_sn_reg_values .= "'" . date("Y-m-d") . "', ";
	$insert_sn_reg_values .= "'" . $status  . "', ";
	$insert_sn_reg_values .= "'" . $cc_trans_id  . "', ";
	$insert_sn_reg_values .= "'" . $cc_declined_reason  . "', ";
	$insert_sn_reg_values .= "'" . $payment_received  . "', ";
	$insert_sn_reg_values .= "'" . $new_person . "', ";
	$insert_sn_reg_values .= "'" . $_SERVER['REMOTE_ADDR'] . "', ";
	$insert_sn_reg_values .= "'" . $_SERVER['REMOTE_HOST'] . "', ";
	$insert_sn_reg_values .= "'" . $_SERVER['HTTP_USER_AGENT'] . "', ";
	$insert_sn_reg_values .= "'" . date("Y-m-d H:i:s") . "'";
	
	
	$sql_sn_reg = "INSERT INTO supernova_registrations (" . $insert_sn_reg_fields . ") VALUES (" . $insert_sn_reg_values . ")"; // INSERT SQL FOR supernova_registrations TABLE
	$result 	= safe_query($sql_sn_reg);
}

function update_sn_reg()
{
	global $ID;  				// PEOPLE ID
	global $new_person; 		// NEW OR OLD PERSON
	global $reg_year;			// YEAR OF REGISTRATION
	global $payment_received;
	global $status;
	global $cc_trans_id;
	global $cc_declined_reason;
	
	$update_sn_reg_fields = "";

	$sn_reg_fields = array("seminar_event","showcase","meals","priority_code","category","priority_code_description","amount","email_format","status","payment_method","cc_trans_id","last_modified");  // supernova_registration FIELDS -> GOOD LIST
	foreach($_POST as $key => $value)  								// FOR EACH KEY IN THE POST ARRAY SHOW ME THE VALUE
	{
		if($value != "" && in_array($key, $sn_reg_fields) == TRUE) 	// THERE IS A VALUE AND THE KEY IS IN THE GOOD LIST
		{
			if(get_magic_quotes_gpc() == 1)  						// MAGIC QUOTES OR WHAT
			{
				$update_sn_reg_fields = $update_sn_reg_fields . $key . " = '" . $value . "', ";
			}
			else													// NO MAGIC, ADD SLASHES
			{
				$update_sn_reg_fields = $update_sn_reg_fields . $key . " = '" . addslashes($value) . "', ";
			}
		}
	}

	
	$update_sn_reg_fields 	.= " seminar_year = '" . $reg_year . "', ";					// CHANGE FOR SUBSEQUENT YEARS
	$update_sn_reg_fields 	.= " payment_received = '" . $payment_received . "', ";
	$update_sn_reg_fields 	.= " cc_trans_id = '" . $cc_trans_id . "', ";
	$update_sn_reg_fields 	.= " cc_declined_reason = '" . $cc_declined_reason . "', ";
	$update_sn_reg_fields 	.= " status = '" . $status . "', ";
	$update_sn_reg_fields 	.= " date_registered = '" . date("Y-m-d") . "', ";
	$update_sn_reg_fields 	.= " last_modified = '" . date("Y-m-d H:i:s") . "'";
	$sql_sn_reg 			= "UPDATE supernova_registrations SET " . $update_sn_reg_fields . " WHERE people_id = '" . $ID . "' LIMIT 1"; // UPDATE SQL
	$result = safe_query($sql_sn_reg);	

}

function create_sn_email_alais()
{
	// remove bad characters (' " " ,)
	global $ID;  // PEOPLE ID
	global $email_alias;
	global $reg_year;			// YEAR OF REGISTRATION

	$email_query = "SELECT * FROM email_aliases WHERE people_id = " . $ID . " AND for_event = 'Supernova " . $reg_year . "'";
	$result = safe_query($email_query);	
	$n_rows = mysql_num_rows($result);		// HOW MANY ROWS?
	
	if($n_rows == 0)		// PERSON DOES NOT HAVE AN EMAIL ALIAS FOR THIS YEAR
	{
		$email_alias = $_POST['first'] . "_" . $_POST['last'] .  ltrim($ID + 17, "0") . "@supernova" . $reg_year . ".com";	// CHANGE FOR SUBSEQUENT YEARS
		$email_alias = remove_char($email_alias);
	
		$insert_alias_fields = "";
		$insert_alias_fields .= "people_id, ";
		$insert_alias_fields .= "email_alias, ";
		$insert_alias_fields .= "real_email, ";
		$insert_alias_fields .= "for_event, ";
		$insert_alias_fields .= "status, ";
		$insert_alias_fields .= "last_modified";
	
	
		$insert_alias_values = "";
		$insert_alias_values .= "'" . $ID . "', ";							// people.ID
		$insert_alias_values .= "'" . $email_alias . "', ";
		$insert_alias_values .= "'" . $_POST['email'] . "', ";
		$insert_alias_values .= "'Supernova " . $reg_year . "', ";						// CHANGE FOR SUBSEQUENT YEARS
		$insert_alias_values .= "'not activated', ";
		$insert_alias_values .= "'" . date("Y-m-d H:i:s") . "'";
		
	
		$sql_alias = "INSERT INTO email_aliases (" . $insert_alias_fields . ") VALUES (" . $insert_alias_values . ")"; // INSERT SQL EMAIL_ALIAS
		$result = safe_query($sql_alias);
	}
	else		// PERSON DOES HAVE AN ALIAS FOR THIS YEAR -> DON'T INSERT JUST GET THEIR OLD ALIAS
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
	global $reg_year;			// YEAR OF REGISTRATION
	global $is_test;
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
		"x_description"			=> "Supernova " . $reg_year . ": " . $_POST["seminar_event"],
		"x_amount"				=> $_POST["amount"],
		"x_first_name"			=> $_POST["billing_first"],
		"x_last_name"			=> $_POST["billing_last"],
		"x_address"				=> $_POST["billing_address1"],
		"x_city"				=> $_POST["billing_city"],
		"x_state"				=> $_POST["billing_state"],
		"x_zip"					=> $_POST["billing_zip"],
		"PriorityCode"			=> $_POST["priority_code"],
		"billing_country"		=> $_POST["billing_country"],
	);
	
	$fields = "";
	foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";
	

// Post the transaction (see the code for specific information):

if($is_test == "_test")		// THEN WE ARE TESTING
	{
		$ch = curl_init("https://certification.authorize.net/gateway/transact.dll"); // <-- USE THIS ONE FOR TESTING;	URL of gateway for cURL to post to 
		$test_flag = "testing";
	}
	else	// WE ARE NOT TESTING
	{
		$ch = curl_init("https://secure.authorize.net/gateway/transact.dll"); 	// <-- USE THIS ONE FOR LIVE CC PROCESSING;	URL of gateway for cURL to post to 
	}
	curl_setopt($ch, CURLOPT_HEADER, 0); 									// set to 0 to eliminate header info from response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 							// Returns response data instead of TRUE(1)
	curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); 			// use HTTP POST to send form data
	$resp = curl_exec($ch); 												//execute post and get results
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
	// CHANGE FOR SUBSEQUENT YEARS !*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!
/* REMOVED FOR 2008; LEAVING B/C IT COULD BE BACK IN 2009
	switch ($se)
	{
		case "Wharton West Challenge Day":
			$sem_desc_str = "the Wharton West Challenge Day events on June 20";
			break;
		case "2-day Conference Package":
			$sem_desc_str = "all sessions/events at St. Francis, June 21 - 22";
			break;
		case "Full Conference":
			$sem_desc_str = "the events at Wharton and all Conference events, June 20 - 22";
			break;
		default	:
			$sem_desc_str = "the conference";
	}
*/	
	$sem_desc_str = "all conference session and events";	// STATIC FOR 2008
	return $sem_desc_str;
}







// SEND THE MAIL
function send_confirm_email($ea, $eif)
{
	global $seminar_description;
	global $payment_received;
	global $cc_declined_reason;
	global $reg_year;			// YEAR OF REGISTRATION
	global $conf_dates;			// DATES OF SEMINAR
	global $ID;  // PEOPLE ID
	$body = "";


if($_POST["email_format"] != "Plain Text")		// NO PLAIN TEXT BEGIN
{

$body .=  <<<EOQ

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Supernova $reg_year -- Register</title>
	<meta name="author" content="Supernova 2008" />
    <meta name="keywords" content="supernova, supernova2008, conference, technology, internet, computing, communications, digital media, social software, business, emerging technology, tech companies, web, web 2.0, kevin werbach, san francisco" />
    <meta name="description" content="The Supernova conference focuses on the technology-driven transformation of computing, communications, digital media, and business. " />
    <meta name="robots" content="index, follow" />

	<link rel='stylesheet' type='text/css' media='all' href='http://www.supernova2008.com/go?css=site/site_css' />
	<style type='text/css' media='screen'>@import "http://www.supernova2008.com/go?css=site/site_css";</style>

    <link rel="alternate" type="application/rss+xml" title="supernova" href="" />
    <link rel="shortcut icon" type="image/x-ico" href="./favicon.ico" />
  </head>
  <body>
 
  <div id="wrapper">
    <div id="container">

      <div id="header">
        <h1>Supernova $reg_year: because technology is everyone's business</h1>
      </div>
      <div id="subheader">
        <div id="whartonlogo"><a href="http://www.wharton.upenn.edu/"><img src="http://www.supernova2008.com/i/whartonlogo.jpg" width="110" height="55" alt="Produced in Partnership with Wharton University of Pennsylvania" /></a></div>
        <div id="quote">
          <div id="quotebody">"One of the must-attends of the digerati and forward thinkers of the networked age."</div>
          <div id="quoteauthor">John Seely Brown, Former Chief Scientist, Xerox</div>

        </div>
        <div class="clear"></div>
      </div>
      
	  <ul id="navigation">
        <li><a title="Home" href="http://www.supernova$reg_year.com/go">Home</a></li>
        <li><a title="About" href="http://www.supernova$reg_year.com/go/about">About</a></li>
        <li><a title="Register" href="https://www.supernovagroup.net/registration/register.php">Register</a></li>
        <li><a title="Speakers" href="http://www.supernova$reg_year.com/go/speakers">Speakers</a></li>
        <li><a title="Agenda" href="http://www.supernova$reg_year.com/go/agenda">Sessions</a></li>
        <li><a title="Workshops" href="http://www.supernova$reg_year.com/go/workshops">Challenge Day </a></li>
        <li><a title="Weblog" href="http://www.supernova$reg_year.com/go/weblog">Weblog</a></li>
        <li><a title="Contact Us" href="http://www.supernova$reg_year.com/go/contact">Contact Us</a></li>

      </ul>
		
      <div id="leftcolumn">
	    <h1>Supernova $reg_year</h1>
        <h2>$conf_dates</h2>
        <h6>$conf_city</h6>
        <p><a title="Venue Information and Reserverations" href="http://www.supernova$reg_year.com/go/venue">Venue Information and Reservations</a></p> 
      </div>

      <div id="middlecolumn">
        <img src="http://www.supernova$reg_year.com/i/alexandras_top.jpg" width="394" height="89" alt="Alexandra" />
        <h1>Supernova $reg_year $test_flag</h1>
EOQ;
} // NO PLAIN TEXT END
$body .= <<<EOQ
<!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->
EOQ;

if($payment_received == "no" && $_POST['payment_method'] == "credit card") // NO PAYMENT AND THE PRESON TRIED TO PAY
{
$subject = "Supernova " . $reg_year . " Registration - PENDING ";		// CHANGE FOR SUBSEQUENT YEARS
$body .= <<<EOQ
<p>Your payment has not been accepted (Reason: $cc_declined_reason).  We have saved your registration information, pending confirmation of the payment.  If you believe your payment has been rejected in error, please re-submit the form.  Otherwise, please <a href="mailto:info@supernovagroup.net">contact us</a> to confirm your payment.</p>

Thanks.
<img src="http://www.supernovagroup.net/registration/images/pending.gif?id=$eif">
EOQ;
}
else  // PAYMENT HAS BEEN RECEVIED - INCLUDES PEOPLE THAT CLICKED "OTHER"  // PEOPLE THAT DIDN'T PAY BY CC
{
$subject = "Supernova " . $reg_year . " Registration Confirmation";		// CHANGE FOR SUBSEQUENT YEARS
$body .= "Dear " . $_POST["first"] . ", <br><br>\n\n";

if($_POST["payment_method"] == "credit card" && $_POST["amount"] > 0) // YOU ARE PAYING MORE THAN $0 WITH A CC
{
	$body .=		"Your credit card payment of $" . $_POST["amount"] . " has been approved.<br><br>\n <!--  Your transaction number is " . $pieces[6] . "-->";
}

if($_POST['amount'] > 0 && $_POST['payment_method'] != "credit card")  // YOU CHOSE "OTHER" AND IT LOOKS LIKE YOU OWE MONEY
{
	if($_POST["priority_code"] == "none" || $_POST["priority_code"] == "early1" || $_POST["priority_code"] == "early2" && $_POST["priority_code"] == "early3") // YOU HAVE A DEFAULT PRIORITY CODE SO YOU SHOULD BE PAYING SOMETHING
	{
		$body .= "Your registration has been received, and will be confirmed when your pending payment (if any) is approved.<br><br>";
	}
}


$body .= <<<EOQ

We are thrilled you will be joining us at Supernova $reg_year, $conf_dates, in San Francisco, CA. Your confirmed Supernova conference pass entitles you to attend $seminar_description.<br><br>

You are responsible for your own hotel accommodations. We have arranged for a block of discounted rooms at the Westin St. Francis Hotel, where the conference will be held; you can make reservations directly on the Supernova Conference <a href="http://www.supernova$reg_year.com/go/venue">Web site</a> after February 1, $reg_year.<br><br>

We will be creating a special Supernova email alias for you. This will allow you to contact other conference attendees without revealing your private email address, and will give you access to personalized content via the Supernova Web site. You will receive an email notification when your email alias has been activated prior to the conference. Your email alias will be ($ea).<br><br>

As the Conference approaches, check the <a href="http://www.supernova$reg_year.com">Supernova Web Site</a> for additional details on pre-conference editorial and blogs, speakers, sessions and conference-related events.<br><br>


<font size="4" color="#FDA714"><b>We look forward to seeing you in San Francisco!</b></font><br><br>

<font size="2">Kevin Werbach, and the Supernova Group
<img src="http://www.supernovagroup.net/registration/images/confirm.gif?id=$eif">

EOQ;

}

$body .= <<<EOQ
<!-- ----------------- END MAIN CONTENT ABOVE ------------------------ -->
      
      </div>



      <div class="clear"></div>

      <div id="footer"></div>
    
  </div>

  </body>
</html>
EOQ;

// end email body ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////


	$to = $_POST['email'];
	$headers .= 'From: Supernova Group <info@supernovagroup.net>' . "\r\n";
	$headers .= 'Bcc: ddinatale@w3on.com' . "\r\n";
	if ($_POST["email_format"] != "Plain Text")  // USING HTML
	{
		$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
	}
	else  // PLAIN TEXT PLEASE
	{
		$body = strip_tags($body);							//PLAIN TEXT SO REMOVE HTML
	}

mail($to,$subject,$body,$headers);  						// SEND IT
mail("kevin@werbach.com","New Registration - " . $_POST["first"] . " " . $_POST["last"], $_POST["first"] . " " . $_POST["last"] . " - " . $subject . " (PEOPLE ID: " . $ID . ")",$headers);  		// SEND IT TO KEVIN
}


function thank_you()		// DISPLAYS THE THANKS YOU PAGE
{
global $reg_year;			// YEAR OF REGISTRATION
global $conf_dates;
global $conf_city;
global $conf_domain;

echo <<<EOQ

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Supernova $reg_year --Register</title>
	<meta name="author" content="Supernova $reg_year" />
    <meta name="keywords" content="supernova, supernova2007, conference, technology, internet, computing, communications, digital media, social software, business, emerging technology, tech companies, web, web 2.0, kevin werbach, san francisco" />
    <meta name="description" content="The Supernova conference focuses on the technology-driven transformation of computing, communications, digital media, and business. " />
    <meta name="robots" content="index, follow" />

	<link rel='stylesheet' type='text/css' media='all' href='http://www.supernova2007.com/go?css=site/site_css' />
	<style type='text/css' media='screen'>@import "http://www.supernova2007.com/go?css=site/site_css";</style>

    <link rel="alternate" type="application/rss+xml" title="supernova" href="" />
    <link rel="shortcut icon" type="image/x-ico" href="./favicon.ico" />
  </head>
  <body>
 
  <div id="wrapper">
    <div id="container">

      <div id="header">
        <h1>Supernova $reg_year: because technology is everyone's business</h1>
      </div>
      <div id="subheader">
        <div id="whartonlogo"><a href="http://www.wharton.upenn.edu/"><img src="http://www.supernova$reg_year.com/i/whartonlogo.jpg" width="110" height="55" alt="Produced in Partnership with Wharton University of Pennsylvania" /></a></div>
        <div id="quote">
          <div id="quotebody">"One of the must-attends of the digerati and forward thinkers of the networked age."</div>
          <div id="quoteauthor">John Seely Brown, Former Chief Scientist, Xerox</div>

        </div>
        <div class="clear"></div>
      </div>
      
	  <ul id="navigation">
        <li><a title="Home" href="http://www.supernova$reg_year.com/go">Home</a></li>
        <li><a title="About" href="http://www.supernova$reg_year.com/go/about">About</a></li>
        <li><a title="Register" href="https://www.supernovagroup.net/registration/register.php">Register</a></li>
        <li><a title="Speakers" href="http://www.supernova$reg_year.com/go/speakers">Speakers</a></li>
        <li><a title="Sessions" href="http://www.supernova$reg_year.com/go/agenda">Agenda</a></li>
        <li><a title="Workshops" href="http://www.supernova$reg_year.com/go/workshops">Challenge Days</a></li>
        <li><a title="Weblog" href="http://www.supernova$reg_year.com/go/weblog">Weblog</a></li>
        <li><a title="Contact Us" href="http://www.supernova$reg_year.com/go/contact">Contact Us</a></li>

      </ul>
		
      <div id="leftcolumn">
        <h1>Supernova $reg_year</h1>
        <h2>$conf_dates</h2>
        <h6>$conf_city</h6>
      </div>

      <div id="middlecolumn">
        <img src="http://www.supernova$reg_year.com/i/alexandras_top.jpg" width="394" height="89" alt="Alexandra" />
        <h1>Supernova $reg_year</h1>  <!-- THINGS TO CHANGE YEAR TO YEAR -->

        <!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->

		<h2>Register</h2>
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


	if ($payment_received == "yes" || $payment_received == "n/a")  	// PAYMENT APPROVED OR THEY DIDN'T NEED TO PAY -> GREAT
	{
			if($_POST["payment_method"] == "credit card" && $_POST["amount"] > 0) // YOU ARE PAYING MORE THAN $0 WITH A CC
			{
				$msg .=		"<p><font color=\"#FFAA10\">Your credit card payment of $" . $_POST["amount"] . " has been approved.</font></p> <!--  Your transaction number is " . $pieces[6] . "-->";
			}
			
			$msg .= 	<<<EOQ

			<p>We are thrilled you will be joining us for the Supernova $reg_year Conference in San Francisco, CA. Your confirmed Supernova conference pass entitles you to attend $seminar_description.</p>

			<p>You will be receiving a confirmation email that will serve as your proof of registration.</p>
			
			<p>We look forward to seeing you in San Francisco!</p>
			
			<p>Kevin Werbach, and the Supernova Group</p>
			
			Email: <a href="mailto:info@supernovagroup.net">info@supernovagroup.net</a><br />
			Web: <a href="http://www.supernova$reg_year.com/">www.supernova$reg_year.com</a><br /><br />$test_flag
EOQ;
	}
	else 					// PAYMENT NOT RECIEVED OR YOU WERE NOT APPROVED -> NOT SO GREAT :(
	{
		if($_POST["payment_method"] == "credit card") // YOU TRIED TO PAY WITH A CC BUT COULD NOT
		{
			$msg = "<p><font color=\"#FF0000\">Your payment has not been accepted (Reason: " . $cc_declined_reason . ").  We have saved your registration information, pending confirmation of the payment.  If you believe your payment has been rejected in error, please <a href=\"register.php\">re-submit the form</a>.  Otherwise, please contact us <a href=\"mailto:info@supernovagroup.net?subject=Payment+Declined\">info@supernovagroup.net</a> to confirm your payment.</p></font><p>Thanks.</p><br />";
		}
		else		// PAYMENT METHOD WAS "OTHER"
		{
			$msg = "<p><font color=\"#FF0000\">Your payment has not been received.  We have saved your registration information, pending confirmation of the payment.  Please contact us <a href=\"mailto:info@supernovagroup.net?subject=Payment+Other\">info@supernovagroup.net</a> to confirm your payment.</p></font><p>Thanks.</p><br />";
		}

	}


echo $_POST["first"] . ",<br/><br/> Thank you for registering.<br><br>";
echo $msg;


/////////^^^^////////////^^^^/////////////////////////^^^^///////////////^^^^///////////////^^^^/////
/////////////////// THANK YOU PAGE BODY ///////////////////// THANK YOU PAGE BODY ///////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
echo <<<EOQ
<!-- ----------------- END MAIN CONTENT ABOVE ------------------------ -->
      
      </div>

      <div class="clear"></div>

      <div id="footer"></div>
    
  </div>

  </body>
</html>
EOQ;
}

?>