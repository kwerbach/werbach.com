<?php
require 'includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

$conferenceId	= 2;			// TESTING
$regHelper	= new regHelper;
$regHelper->getConferenceVariableValues($conferenceId);
global $sqlHelper;
$sqlHelper = new sqlHelper;

global $payment_received;
global $cc_trans_id;
global $cc_declined_reason;
global $replaceMessageArr;			
echo "52by9Xq6Q5W9nHzh";
$people_table 	= "people"; 	 			// "PEOPLE_TESTING" IS THE TESING TABLE

if ($_POST['email'] != "")
{

	// SET DEFAULT VALUES
	$replaceMessageArr		= $_POST;		// VALUES TO USE WHEN REPLACEING TEXT IN TY MESSAGE BODY
	$payment_received 		= "no"; 	// NOTHING HAS BEEN PAIDED FOR YET (DEFAULT)
	$status 				= "";		// SEMINAR STATUS -> registerd
	$cc_declined_reason 	= "N/A";  	// MADE UP DEFULT REASON FOR DECLINED CC - IN CAPS SO I CAN TELL IT IS NOT SET BY A.N AIM
	$cc_trans_id 			= ""; 		// AUTHOIZE.NET TRANSACTION ID
	$ID 					= "";		// THE people TABLE ID
//	$seminar_description 	= seminar_desc($_POST["conference_package"]);
	$packageId				= $_POST['package_id'];
	$priorityCode			= $_POST['priority_code'];
	$email_alias = "";

	
	// SEE IF WE ALREADY HAVE INFO FOR THIS ATTENDEE IN THE PEOPLE TABLE
	$where_clause 	= "WHERE email = '" . $_POST['email'] . "'";
	$query 			= "SELECT * FROM " . $people_table . " " . $where_clause . " LIMIT 0 , 1";
	$result 		= $sqlHelper->queryCmd($query);

	if ($result)													// QUERY DID NOT BLOW UP
	{
		
		$n_rows = mysql_num_rows($result);							// HOW MANY ROWS?
		
		if ($n_rows == 1)											// THERE IS ONE RECORD IN THE DB -> DO UPDATE
		{
			$row 		= mysql_fetch_array($result, MYSQL_ASSOC);
			$ID 		= $row["ID"];								// GET PEOPLE ID FROM PEOPLE
			$new_person = "no";										// THEY ARE AN OLD PERSON - THEY WERE IN THE DB
			update_people();										// UPDATE ANY NEW INFORMATION
		}
		elseif ($n_rows > 1)  										// MORE THAN 1 ROW... THIS SHOULD NEVER HAPPEN
		{
			echo "There are multiple records for you in the database.  Please email ddinatale@w3on.com with this information";
		}
		else														// THERE IS NOT A MATCHING RECORD IN THE DB -> DO INSERT
		{
			$new_person = "yes";									// NOT PREVIOUSLY IN DB -> NEW PERSON
			$ID = insert_people();									// PUT THEM IN THE PEOPLE TABLE
		}
		
		
		
		// THESE THINGS ARE HAPPENING NO MATTER HOW MANY ROWS ARE FOUND		
		if($_POST['amount'] == 0 || $_POST['payment_method'] != "credit card")			// NO COST OR NO CC -> DON'T HAVE TO PAY?
		{
			$payment_received 	= "yes";							// MIGHT AS WELL HAVE PAID
			$status 			= "registered";						// THEY ARE ALL SET FOR THE CONFERENCE
			if($_POST['amount'] == 0)								// IF YOUR AMOUNT IS $0
			{
				$payment_received = "n/a";							// PAYMENT IS N/A
			}
		}
		else														// HAVE TO PAY MORE THAN $0 WITH CC
		{
			authorize_aim();										// FUNCTION THAT MAKES PAYMENT // 1 -> CC APPROVED, 2 -> DECLINED, 3 -> ERROR
		}
		
		//setPaymentMessage($amount, $paymentMethod, $priorityCode='404 NONE GIVEN', $ccDeclinedReason='404 NONE GIVEN')
		$paymentMessage = setPaymentMessage($_POST['amount'], $_POST['payment_method'], $priorityCode, $cc_declined_reason);						// GET PAYMENT STATUS MESSAGE
		
		// CHECK TO SEE IF THEY HAVE ALREADY REGISTERD				//
		$sn_where_clause	= "WHERE people_id = $ID";
		$sn_reg_query 		= "SELECT people_id FROM reg__attendee " . $sn_where_clause . " LIMIT 0 , 1";
		$sqlHelper			= new sqlHelper;
		$sn_reg_result 		= $sqlHelper->queryCmd($sn_reg_query);
		$sn_rows 			= mysql_num_rows($sn_reg_result);		// HOW MANY ROWS?
		
		if ($sn_rows == 0)											// THEY ARE REGISTERING FOR THE FIRST TIME
		{
			insert_sn_reg(); 										// PUT THEM INTO THE reg__attendee TABLE
		}
		else														// THEY HAVE ALREADY REGISTERED
		{
			update_sn_reg();										// REREGISTERING AND ARE ALREADY IN THE reg__attendee TABLE
		}
		
		$email_alias = createEmailAlais();  									// CREATE AN EMAIL ALIAS FOR THEM -> FIRST_LASTID@supernova20xx.com
		
		$replaceMessageArr = array_merge($_POST, array("email_alias"=>$email_alias));
		$replaceMessageArr = array_merge($replaceMessageArr, array("payment_message"=>$paymentMessage));
		
		/* Tag Registrant Begin  									//
		* WARNING: if somebody re-regeisters becasue of a previous failue, 
		* they could switch packages or p codes and be tagged twice!
		*/
		$conferenceTag	= $sqlHelper->getDatum('reg__conference', 'tag', 'conference_id', $conferenceId);
		$regHelper->setTag($ID, $conferenceTag);
		
		$priorityCodeArr	=	$regHelper->getPriorityCodeInfo($conferenceId, $priorityCode, 1);
		$regHelper->setTag($ID, $priorityCodeArr['tag']);
	
		$packageTag	= $sqlHelper->getDatum('reg__package', 'tag', 'package_id', $packageId);
		$regHelper->setTag($ID, $packageTag);	
		/* Tag Registrant End */
		

		sendConfirmEmail($ID, $paymentMessage);					// LET THEM KNOW HOW THE OUTCOME VIA EMAIL
	}
	else 															// QUERY FAILED
	{
		echo "Bad Query!!!";
	}
	

//	echo "<hr/>END";	//TESTING
//	exit;				//TESTING

	thank_you($paymentMessage);													// WRITE THE THANK YOU PAGE - LET THEM KNOW HOW THE OUTCOME VIA BROWSER
	
}
else																// YOU DON'T HAVE EMAIL FOR SOME REASON
{
	header("Location: register.php"); 								// Redirect browser
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

								"conference_id",
								"description",
								"conference_package",
								"package_id",
								"showcase",
								"description",
								"tag",
								
								"priority_code",
								"category",
								"priority_code_description",
								"confirm_email",
								"email_format",
								"meals",
								"conf",
								"extra_event",
								"amount",
								"same_billing",
								"payment_method",
								"billing_first",
								"billing_last",
								"billing_address1",
								"billing_city",
								"billing_province",
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
	$sqlHelper				= new sqlHelper;
	$result 				= $sqlHelper->queryCmd($sql_people);
}

function insert_people()
{
	
	global $people_table;
	global $new_person;  			// PEOPLE YOU ALREADY KNOW?
	global $reg_year;				// YEAR OF REGISTRATION
	$insert_people_fields = "";		// FIELDS TO INSERT
	$insert_people_values = "";		// VALUES FOR THOSE FIELDS
	
	// THESE FIELDS ARE **NOT** IN THE PEOPLE TABLE SO DON'T USE THEM
	$not_people_fields = array("submit",
								"conference_id",
								"description",
								"conference_package",
								"package_id",
								"showcase",
								"description",
								"tag",
								
								"priority_code",
								"category",
								"priority_code_description",
								"confirm_email",
								"email_format",
								"meals",
								"conference_package",
								"showcase",
								"amount",
								"same_billing",
								"payment_method",
								"billing_first",
								"billing_last",
								"billing_address1",
								"billing_city",
								"billing_province",
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
	$insert_people_fields .= "comments, ";
	$insert_people_fields .= "created_on, ";
	$insert_people_fields .= "last_modified";
		
	$insert_people_values .= "'" . strtoupper(substr(remove_char($_POST["last"] . $_POST["first"] . $_POST["email"]) , 0, 3)) . rand(1111,9999) . "', ";
	$insert_people_values .= "'Supernova " . $reg_year . "', ";					// CHANGE FOR SUBSEQUENT YEARS
	$insert_people_values .= "'Created from Supernova conference sign-up', ";
	$insert_people_values .= "'" . date("Y-m-d H:i:s") . "', ";
	$insert_people_values .= "'" . date("Y-m-d H:i:s") . "'";
	
	$sql_people = "INSERT INTO " . $people_table . " (" . $insert_people_fields . ") VALUES (" . $insert_people_values . ")"; // INSERT SQL people TABLE
	$sqlHelper				= new sqlHelper;
	$result 				= $sqlHelper->queryCmd($sql_people);
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

	$sn_reg_fields = array("conference_package","extra_event","meals","priority_code","category","priority_code_description","amount","email_format","status","payment_method","cc_trans_id","last_modified");  // reg__attendee FIELDS -> GOOD LIST
	foreach($_POST as $key => $value)  								// FOR EACH KEY IN THE POST ARRAY SHOW ME THE VALUE
	{
		if($value != "" && in_array($key, $sn_reg_fields) == TRUE) 	// THERE IS A VALUE AND THE KEY IS IN THE GOOD LIST
		{
			$insert_sn_reg_fields = $insert_sn_reg_fields . $key . ", ";
			$insert_sn_reg_values = (get_magic_quotes_gpc()) ? $insert_sn_reg_values . "'" . $value . "', " : $insert_sn_reg_values . "'" . addslashes($value) . "', ";			
		}
	}
	$insert_sn_reg_fields = "people_id, " . $insert_sn_reg_fields;
	$insert_sn_reg_fields .= "conference_id, ";
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
	$insert_sn_reg_values .= "'" . $_POST['conference_id'] . "', ";				// CHANGE FOR SUBSEQUENT YEARS
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
	
	
	$sql_sn_reg = "INSERT INTO reg__attendee (" . $insert_sn_reg_fields . ") VALUES (" . $insert_sn_reg_values . ")"; // INSERT SQL FOR reg__attendee TABLE
	$sqlHelper				= new sqlHelper;
	$result 				= $sqlHelper->queryCmd($sql_sn_reg);
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

	$sn_reg_fields = array("conference_package","extra_event","meals","priority_code","category","priority_code_description","amount","email_format","status","payment_method","cc_trans_id","last_modified");  // supernova_registration FIELDS -> GOOD LIST
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

	
	$update_sn_reg_fields 	.= " conference_id = '" . $_POST['conference_id'] . "', ";					// CHANGE FOR SUBSEQUENT YEARS
	$update_sn_reg_fields 	.= " payment_received = '" . $payment_received . "', ";
	$update_sn_reg_fields 	.= " cc_trans_id = '" . $cc_trans_id . "', ";
	$update_sn_reg_fields 	.= " cc_declined_reason = '" . $cc_declined_reason . "', ";
	$update_sn_reg_fields 	.= " status = '" . $status . "', ";
	$update_sn_reg_fields 	.= " date_registered = '" . date("Y-m-d") . "', ";
	$update_sn_reg_fields 	.= " last_modified = '" . date("Y-m-d H:i:s") . "'";
	$sql_sn_reg 			= "UPDATE reg__attendee SET " . $update_sn_reg_fields . " WHERE people_id = '" . $ID . "' LIMIT 1"; // UPDATE SQL
	$sqlHelper				= new sqlHelper;
	$result 				= $sqlHelper->queryCmd($sql_sn_reg);	

}

/** Create email alias */
function createEmailAlais()
{
	// remove bad characters (' " " ,)
	global $ID;  // PEOPLE ID
	global $email_alias;
	global $reg_year;			// YEAR OF REGISTRATION

	$email_query = "SELECT * FROM reg__email_alias WHERE people_id = " . $ID . " AND conference_id = " . $_POST['conference_id'];
	$sqlHelper				= new sqlHelper;
	$result 				= $sqlHelper->queryCmd($email_query);	
	$n_rows = mysql_num_rows($result);		// HOW MANY ROWS?
	
	if($n_rows == 0)		// PERSON DOES NOT HAVE AN EMAIL ALIAS FOR THIS YEAR
	{
	
		$conferenceDomain	= $sqlHelper->getDatum('reg__conference', 'conference_domain', 'conference_id', $_POST['conference_id']);
		
		$email_alias = $_POST['first'] . "_" . $_POST['last'] .  ltrim($ID + 17, "0") . "@" . $conferenceDomain;	// CHANGE FOR SUBSEQUENT YEARS
		
		$email_alias = remove_char($email_alias);
	
		$insert_alias_fields = "";
		$insert_alias_fields .= "people_id, ";
		$insert_alias_fields .= "email_alias, ";
		$insert_alias_fields .= "real_email, ";
		$insert_alias_fields .= "conference_id, ";
		$insert_alias_fields .= "status, ";
		$insert_alias_fields .= "last_modified";
	
	
		$insert_alias_values = "";
		$insert_alias_values .= "'" . $ID . "', ";							// people.ID
		$insert_alias_values .= "'" . $email_alias . "', ";
		$insert_alias_values .= "'" . $_POST['email'] . "', ";
		$insert_alias_values .= $_POST['conference_id'] . ", ";
		$insert_alias_values .= "'not activated', ";
		$insert_alias_values .= "'" . date("Y-m-d H:i:s") . "'";
		
	
		$sql_alias = "INSERT INTO reg__email_alias (" . $insert_alias_fields . ") VALUES (" . $insert_alias_values . ")"; // INSERT SQL EMAIL_ALIAS
		$sqlHelper				= new sqlHelper;
		$result 				= $sqlHelper->queryCmd($sql_alias);
	}
	else		// PERSON DOES HAVE AN ALIAS FOR THIS YEAR -> DON'T INSERT JUST GET THEIR OLD ALIAS
	{
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$email_alias = $row["email_alias"];
	}
	return $email_alias;
}

function remove_char($str)
{
	$str = str_replace("'", "", $str);
	$str = str_replace(" ", "", $str);
	return $str;
}


/** Process payment with Authorize.net */
function authorize_aim()
{
	global $cc_declined_reason;
	global $reg_year;			// YEAR OF REGISTRATION
	$auth_net_login_id			= "6TnSF6a5E";
	$auth_net_tran_key			= "52by9Xq6Q5W9nHzh";
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
		"x_description"			=> "Supernova " . $reg_year . ": " . $_POST["conference_package"],
		"x_amount"				=> $_POST["amount"],
		"x_first_name"			=> $_POST["billing_first"],
		"x_last_name"			=> $_POST["billing_last"],
		"x_address"				=> $_POST["billing_address1"],
		"x_city"				=> $_POST["billing_city"],
		"x_state"				=> $_POST["billing_province"],
		"x_zip"					=> $_POST["billing_zip"],
		"PriorityCode"			=> $_POST["priority_code"],
		"billing_country"		=> $_POST["billing_country"],
	);
	
	$fields = "";
	foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";
	

// Post the transaction (see the code for specific information):

//TESTING	$ch = curl_init("https://certification.authorize.net/gateway/transact.dll"); // URL of gateway for cURL to post to <-- USE THIS ONE FOR TESTING
	$ch = curl_init("https://secure.authorize.net/gateway/transact.dll"); 	// <-- USE THIS ONE FOR LIVE CC PROCESSING
	curl_setopt($ch, CURLOPT_HEADER, 0); 									// set to 0 to eliminate header info from response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 							// Returns response data instead of TRUE(1)
	curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); 			// use HTTP POST to send form data
	$resp = curl_exec($ch); 												//execute post and get results
	curl_close ($ch);


// TESTING	echo '<hr/>*' . $resp . '*<hr/>';
	$pieces = explode("|", $resp);

	global $payment_received;
	global $status;
	global $cc_trans_id;
	global $cc_declined_reason;
	
	/*TESTING
	for ($i = 0; $i < count($pieces); $i++)
	{
		echo $pieces[$i]  . "<hr/>*";
	}
	*/

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
		$cc_declined_reason = "|" . $pieces[3] . "|";
		$status = "pending";
	}

}





















/** Get Payment Message */
function setPaymentMessage($amount, $paymentMethod, $priorityCode='404 NONE GIVEN', $ccDeclinedReason='404 NONE GIVEN')
{
	global $payment_received;
	$paymentMessage	= '';
	
	if($amount == 0)								// You are coming for free no message
	{
//		$paymentMessage	= "Code: " . $priorityCode . "<br>\n<br>\n";
		return $paymentMessage;
	}	
	
	
	if($paymentMethod == "credit card")				// You are paying by credit card. Because we got this far you must bepaying more than $0
	{
		if($payment_received == "yes") 				// Thanks your card will be charged $x
		{
			$paymentMessage	= "Your credit card payment of $" . $amount . " has been approved.<br>\n<br>\n";
		}
		else										// Sorry your payment did not fly
		{
			$paymentMessage	= "<p><font color=\"#FF0000\">Your payment has not been accepted (Reason: " . $ccDeclinedReason . ").  	
								We have saved your registration information, pending confirmation of the payment.  If you believe 
								your payment has been rejected in error, please <a href=\"register.php\">re-submit the form</a>.  
								Otherwise, please contact us <a href=\"mailto:info@supernovagroup.net?subject=Payment+Declined\">info@supernovagroup.net</a> to confirm your payment.</p>
								</font>";
		}
	}
	else											// You are paying by something other than a credit card
	{
		$paymentMessage	= "Your registration has been received, and will be confirmed when your pending payment (if any) is approved.";
	}

	return $paymentMessage;
}

/** Send confirmation Email */
function sendConfirmEmail($eif, $paymentMessage='')
{
	global $payment_received;
	global $replaceMessageArr;
	global $conference_name;
	$regHelper	= new regHelper;
	
	$msg =	"";
	
	if ($_POST["email_format"] != "Plain Text")  // USING HTML
	{
		$msg .= renderPartial('includes/inc_header.php',$conference_name);
	}
	
	if($payment_received == "no")
	{
		$subject = "Supernova Registration - PENDING ";		// CHANGE FOR SUBSEQUENT YEARS
	}
	else  // PAYMENT HAS BEEN RECEVIED - INCLUDES PEOPLE THAT CLICKED "OTHER"
	{
		$subject = $conference_name . " Registration Confirmation";		// CHANGE FOR SUBSEQUENT YEARS
	}
	
	/** Write the message */
	$regHelper	= new regHelper;
	$msg 		.= $paymentMessage;
	$msg 		.= $regHelper->getThankYouMessage(2, 2, 1, $replaceMessageArr);
	$msg 		.= "<img src=\"http://www.supernovagroup.net/registration/images/confirm.gif?id=$eif\">";

	if ($_POST["email_format"] != "Plain Text")  // USING HTML
	{
		$msg .= renderPartial('includes/inc_footer.php');
	}
// end email body ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////


	$to = $_POST['email'];
	$headers = 'From: Supernova Group <info@supernovagroup.net>' . "\r\n";
	$headers .= 'Bcc: ddinatale@w3on.com' . "\r\n";
	if ($_POST["email_format"] != "Plain Text")  // USING HTML
	{
		$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
	}
	else  // PLAIN TEXT PLEASE
	{
		$msg = strip_tags($msg);							//PLAIN TEXT SO REMOVE HTML
	}

echo "<strong>EMAIL:</strong><hr/>Email Headers: " . $headers . "<br /><br />Subject: " . $subject . "<br /><br />Body:<br /> " . $msg . "<hr/>";		// TESTING
// mail($to,$subject,$msg,$headers);  						// SEND IT
mail("ddinatale@w3on.com",$subject,$msg,$headers);  		// SEND IT
// mail("kevin@werbach.com","New Registration - " . $_POST["first"] . " " . $_POST["last"], $_POST["first"] . " " . $_POST["last"] . " - " . $subject . " (PEOPLE ID: " . $ID . ")",$headers);  		// SEND IT TO KEVIN
}

//\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\//
function thank_you($paymentMessage)		// DISPLAYS THE THANKS YOU PAGE
{
	global $replaceMessageArr;
	global $conference_name;
	$regHelper	= new regHelper;
	
	include "includes/inc_header.php"; 
	echo "<!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->
		<h2>Register</h2>";

	$msg 		= $paymentMessage . "<br><br>\n";
	$msg 		.= 	$regHelper->getThankYouMessage(2, 1, 1, $replaceMessageArr);
	
	echo $_POST["first"] . ",<br/><br/> Thank you for registering.<br><br>\n";
	
	echo $msg;
	
	echo "<!-- ----------------- END MAIN CONTENT ABOVE ------------------------ -->";	

	include "includes/inc_footer.php";
}

?>