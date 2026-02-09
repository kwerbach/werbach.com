<?php
require 'includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

$conference_id	= 2;			// TESTING
//$package_id 	= 2;			// TESTING
//$priority_code	= 'FOK09';		// TESTING
$payment_method	= 'credit card';
$sqlHelper = new sqlHelper;
$formHelper = new formHelper;
$regHelper = new regHelper;
$regHelper->getConferenceVariableValues($conference_id);
$package_id		= $_POST['conference_package'];
$package_name 	= $sqlHelper->getDatum('reg__package', 'package_name', 'package_id', $package_id);
$_POST['conference_package']	= $package_name;
// list($amount, $category, $description) = array_values($regHelper->getCodeAndPackage($conference_id, $package_id, $priority_code));

//	$not_from_form	= array("amount","category","description");			// FROM THE DATABASE BASED NOT FROM FORM
	$not_from_form = $regHelper->getCodeAndPackage($conference_id, $package_id, $_POST['priority_code']);
	$not_from_form['amount'] = number_format($not_from_form['amount'],2,'.','');
	$tmpArr = array("conference_id"=>$conference_id, "package_id"=>$package_id);
	$not_from_form	= array_merge( $not_from_form, $tmpArr );
//	print_r($not_from_form);	// TESTING
	/** Seminar specific information */
	$seminar_values = array("conference_package","showcase","meals","priority_code");

	$payment_values = array("billing_first",
							"billing_last",
							"billing_address1",
							"billing_city",
							"billing_state",
							"billing_zip",
							"billing_country",
							"cc_type",
							"cc_number",
							"expire_month",
							"expire_year",
							"payment_method");

	$contact_values = array("first",
							"last",
							"email",
							"confirm_email",
							"email_format",
							"title",
							"company",
							"address1",
							"address2",
							"city",
							"province",
							"zip",
							"country",
							"phone",
							"cellphone",
							"fax",
							"website",
							"blog");

// ------------- above is page specific
include "includes/inc_header.php"; 
?>
<!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->
		<h2>Register</h2>
		<p>Please review your information before continuing. If you need to return to the registration form you may use your browser's back button. </p>
<?php

	/* Confirm message */
	if ($payment_method == "credit card" and $not_from_form['amount'] > 0)
	{
		echo "<p>Please note that your credit card will be charged <strong>$" . $not_from_form['amount'] . "</strong> &#8212; the full amount of the registration.</p>";
	}

	/* Registration Information */	
	echo "<strong>Registration Information:</strong><hr />";
	foreach($_POST as $key => $value)
	{
		if(in_array($key, $seminar_values))	echo "<b>" . beautify($key) . ":</b> $value<br />";
	}
	

	/* Contact Information */		
	echo "<br /><br /><strong>Contact Information:</strong><hr />";
	foreach($_POST as $key => $value)
	{
		if(in_array($key, $contact_values))	echo "<b>" . beautify($key) . ":</b> $value<br />";
	}	
	

	/* Payment Information */			
	echo "<br /><br /><strong>Payment Information:</strong><hr />";
	echo "<b>Amount:</b> $" . $not_from_form['amount'] . "<br />";
	foreach($_POST as $key => $value)
	{
		if(in_array($key, $payment_values))	echo "<b>" . beautify($key) . ":</b> $value<br />";
	}
	echo "<hr />";


// TESTING
//	foreach($_POST as $key => $value)
//	{
//		echo "\"$key\",<br />";
//	}

	?>
	
	<form action="thank_you.php" method="post">
	<?php
	
	/* Print the derived fields */
	foreach($not_from_form as $key => $value)
	{
		echo $formHelper->renderHiddenField ($key, $value) . "\n";
	}
	
	/* Print the rest of the fields */
	foreach($_POST as $key => $value)
	{
		if(in_array($key, $not_from_form) == 0)	echo $formHelper->renderHiddenField ($key, $value) . "\n";
	}	
	
	?>
	<div align="center">
	    <input type="button" class="button" value="Back To Form" onClick="window.history.go(-1)">
	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    <input name="" type="submit" class="button" value="Confirm Registration">
	  </div>
	</form></p>
<!-- ----------------- END MAIN CONTENT ABOVE ------------------------ -->
<?php include "includes/inc_footer.php"; ?>
<?php
function beautify($str)
{
	$str = str_replace("_", " ", $str);
	$str = ucwords($str);
	$str = str_replace("Seminar Event", "Conference Package", $str);
	$str = str_replace("Cellphone", "Mobile Phone", $str);
	return $str;
}
?>