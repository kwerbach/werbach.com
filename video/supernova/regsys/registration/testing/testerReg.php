<?php
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');
$reg_year = "2007";
$formHelper = new formHelper;			// ???: populate this in the constuctor?

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Reg Tester</title>
	<link href="../registration.css" rel="stylesheet" type="text/css" />	

<script src="<?php echo findRelativePath('includes/jquery-1.3.2.js'); ?>" type="text/javascript"></script>
<script src="<?php echo findRelativePath('includes/jquery.validate.js'); ?>" type="text/javascript"></script>
<script src="<?php echo  findRelativePath('includes/cmxforms.js' );?>" type="text/javascript"></script>

<script language="javascript">
$.validator.setDefaults({
	submitHandler: function() { alert("submitted!"); }
});




$(document).ready(function() {


	
	// validate signup form on keyup and submit
	$("#form1").validate({

		rules: {
			f1: 
			{
				required: true,
				email: true
			},
			seminar_event: "required"

		},
		messages: {
			f1: "Please enter a valid email address",
			seminar_event: "Please choose an event"
		}
	});
	
	$("#priority_code").blur(function()
	{
		alert( $( this ).val() + '|' + $("#conference_id").val() );
//		it = '?conference_id=' + $("#conference_id").val() + '&priority_code=' + $( this ).val();
	//	$("#priority_code_result").load("../ajax/getPriorityCode.php" + it, '');
//		$.post("../ajax/getPriorityCode.php", it, myfunction(data), 'json')
		 $.ajax({
   			type: "POST",
   			url: "../ajax/getPriorityCode.php",
   			data: $("#conference_id, #priority_code").serialize(),
			dataType: 'html',
   			success: function(x){
     			alert(x)
				if (x == 'free')
				{	
					$("#priority_code_result").html('free')
				}
				else if  (x == 'discount')
				{
					$("#priority_code_result").html('discount')
				}
				else
				{
					$("#priority_code_result").html('none')
				}
			   }
			 });

	}
	);
	
	function myfunction(data){
		alert(data);
	}
});
</script>
</head>	
<body><br />
<br />
<br />
<br />

<form  class="cmxform" id="form1">
<input name="f1" id="f1" value="" />
<input type="submit" id="Submit" value="submit" />

</form>
<br/><br/>
<form name="form2" id="form2">
Priority Code:<input type="text" name="priority_code" id="priority_code" value="" />
<div id="priority_code_result"></div>
<input type="text" name="conference_id" id="conference_id" value="2" />

</form>
<?php

class regHelperTest
{
	public function getPackages($conferenceId)
	{
	$sqlHelper = new sqlHelper;
	$rsObj = $sqlHelper->queryCmd("SELECT * FROM reg__package WHERE conference_id = $conferenceId;");
		if($rsObj){
			echo "";
			$listOutput = <<<EOQ
			<div id="package_container">
			<table class="package_table" >
			<tr class="package_row">
				<tr valign="top" class="package_table_header">
				<th>*</th>
				<th>Conference Packages & Fees</th>
				<th align="center">Early Bird</th>
				<th align="center">Regular</th>
			
			</tr>
EOQ;
			while($rsRowArr = mysql_fetch_assoc($rsObj))
			{
				
				$package_id			= $rsRowArr['package_id'];
				$package_name		= $rsRowArr['package_name'];
				$description		= $rsRowArr['description'];
				$early_bird_amount	= '$' . number_format($rsRowArr['early_bird_amount'], 2, '.', ',');		// 1,000.50
				$amount				= '$' . number_format($rsRowArr['amount'], 2, '.', ',');
										
				$listOutput .= <<<EOQ
					<tr valign="top" class="package_row">
						<td><input name="seminar_event" id="seminar_event" type="radio" value="$package_id"/></td>
						<td><span class="package_name">$package_name</span><br />$description</td>
						<td align="center">$early_bird_amount</td>
						<td align="center">$amount</td>
					</tr>
EOQ;
			}
			echo $listOutput;		
			echo "</table></div>";
		}
	}

	/** Just get teh basic conference info
	*/
	public function getConferenceInfo($conferenceId)
	{
		$sqlHelper = new sqlHelper;
		$rsObj = $sqlHelper->queryCmd("SELECT * FROM reg__conference WHERE conference_id = $conferenceId;");
		if($rsObj)
		{
			while($rsRowArr = mysql_fetch_assoc($rsObj))
			{
				// Allows us to just us "$field name to get the value"
				foreach($rsRowArr as $key => $value)
				{
					$$key = $value;
				}
$date = date("F j", strtotime($start_date)) . date("-j, Y", strtotime($end_date));
echo <<<EOQ
<div id="conference_container">
	<div id="h1">$conference_name</div>
	<div id="h2">$date</div>
	<div id="h3">$city, $state</div>
</div>
EOQ;
			}
			
		}
	}

	public function getConferenceVariableValues($conferenceId)
	{
		$sqlHelper = new sqlHelper;
		$rsObj = $sqlHelper->queryCmd("SELECT * FROM reg__conference WHERE conference_id = $conferenceId;");
		if($rsObj)
		{
			while($rsRowArr = mysql_fetch_assoc($rsObj))
			{
				// Allows us to just us "$field name to get the value"
				foreach($rsRowArr as $key => $value)
				{
					global $$key;
					$$key = $value;
					if (eregi('_date$', $key))
					{
						$$key = date("n/j/Y", strtotime($value)); //$value;
					}
					
				}
			}
		}
	}			
	/** Send back priority code infomation
	* @param $conferenceId The conference
	* @param $code The code supplied
	* @param $details If set to 1 then you get back the dollar amount and the ctegory. 
	* @return mixed array if a code is code is found and details are requested; string if details are not requested or code is not found.
	*/
	public function getPriorityCodeInfo($conferenceId, $code, $details=0)
	{
		$sqlHelper 		= new sqlHelper;
		$conferenceId	= $sqlHelper->toSql($conferenceId, 'number');
		$code			= $sqlHelper->toSql($code, 'text');
		$rsObj 			= $sqlHelper->queryCmd("SELECT amount, category, description FROM reg__priority_code WHERE conference_id = $conferenceId AND code = $code AND DATE(NOW()) BETWEEN start_date AND end_date;");
		if($rsObj){
			$num = mysql_num_rows( $rsObj );
			if ($num == 1)
			{
				$rsRowArr = mysql_fetch_assoc($rsObj);
//				$return = $rsRowArr['amount'] . "|" . $rsRowArr['category'];
				if($details == 1)		// Let me know the specifics
				{
					return array("amount"=>$rsRowArr['amount'], "category"=>$rsRowArr['category'], "description"=>$rsRowArr['description']);
				}
				else					// Let me know at a high level
				{
					if ($rsRowArr['amount'] == 0)
					{
						return 'free';
					}
					else
					{
						return 'discount';
					}
				
				}
			}
			else
			{
				$return = "none found";
			}
		}
	
		return $return;
	}
	
	/** Get the amountm, priority code, category and description 
	* @param $conferenceId int The conference code
	* @param $code string The priority code
	* @return array
	*/
	public function getCodeAndPackage($conferenceId, $packageId, $code=null)
	{
		$haveCode = ($code != '') ? true : false;

		if($haveCode)
		{
//			echo "do have Code";		// TESTING
			$tempResult = $this->getPriorityCodeInfo($conferenceId, $code, 1);
		}
		else
		{
//		 	echo "don't have Code";		// TESTING
			$tempResult = "no array";
		}

	
		if ( is_array( $tempResult ) )		// found a priority code
		{
				return $tempResult;			// retern the array from the priority codes
		}
		else		// get the defaults from the conferece & package table
		{
			$sqlHelper	= new sqlHelper;
			$rsObj 		= $sqlHelper->queryCmd("SELECT 
												IF(DATE(NOW()) >= c.early_bird_cutoff_actual_date, p.amount, p.early_bird_amount) AS 'actual_amount', 
												IF(DATE(NOW()) >= c.early_bird_cutoff_actual_date, 'Attendee', 'Earlybird') AS 'category',
												'temp description' AS description
													FROM reg__package p JOIN reg__conference c
													ON p.conference_id = c.conference_id
													WHERE package_id = $packageId
												;");
			
			if($rsObj){
				$num = mysql_num_rows( $rsObj );
				if ($num == 1)
				{
					$rsRowArr = mysql_fetch_assoc($rsObj);
					return $rsRowArr;		// return the defaults
				}
				else
				{
					die(ERR_121 . ' (value entered --> ' . $packageId . ')');
				}
			}
			
		}
		
	}
 


}
$regHelper = new regHelper;



// ---------------------------------------------------------------------------
echo "<hr/>";
echo "<br/><strong>get one random quote:</strong><br/>";
//$regHelper->getQuote($conferenceId=2, $quoteId=0, $numQuotes=1);
$regHelper->getQuote(2, 0, 1);
echo "<br/><strong>get one specific quote:</strong><br/>";
$regHelper->getQuote(0, 3, 1);		// NEED TO TEST WITHIN 1 SPECIFI EVENT
echo "<br/><strong>get a few quotes from ALL confs:</strong><br/>";
$regHelper->getQuote(0, 0, 3);		// Give me 3 random from all confs
echo "<br/><strong>select from differnt con:</strong><br/>";
$regHelper->getQuote(3, 0, 1);		// Give me 1 random from conf 3
echo "<br/><strong>Asking for more quotes than you have (2):</strong><br/>";
$regHelper->getQuote(3, 0, 5);		// Should only give me 2 quotes
echo "<br/><strong>Asking for more quotes than you have with STYLE:</strong><br/>";
$regHelper->getQuote(3, 0, 5, '_two');		// Should on ly give me 2 quotes
echo "<br/><strong>give me back zero quotes:</strong><br/>";
$regHelper->getQuote(2, 0, 0);		// DIES B/C not wuotes in conf 1
echo "<br/><strong>get a few non existent quotes:</strong><br/>";
$regHelper->getQuote(1, 0, 3);		// DIES B/C not wuotes in conf 1



// ---------------------------------------------------------------------------
echo "<hr/>";
echo "<br/><strong>invalid code:</strong><br/>";
print_r ($regHelper->getCodeAndPackage(2, 2, 'seven'));
$testArr =  $regHelper->getCodeAndPackage(2, 2, 'seven');
list($amount, $category, $description) = array_values($regHelper->getCodeAndPackage(2, 2, 'seven'));			//array('one', 'two', 'three');
echo "You pay $amount because you are a(n) $category ( $description )." ;

echo "<br/><strong>valid code:</strong><br/>";
print_r ($regHelper->getCodeAndPackage(2, 2, 'five'));

echo "<br/><strong>no code:</strong><br/>";
print_r ($regHelper->getCodeAndPackage(2, 2));
//echo "<br/><strong>invalid package:</strong><br/>";
//print_r ($regHelper->getCodeAndPackage(2, 99));

// ---------------------------------------------------------------------------
echo "<hr/>";
echo "<br/><strong>getPriorityCodeInfo:</strong><br/>";
print_r ( $regHelper->getPriorityCodeInfo(2, "fi've", 1) );

// ---------------------------------------------------------------------------
echo "<hr/>";
echo "<br/><strong>getPackages:</strong><br/>";
$regHelper->getPackages(2);

// ---------------------------------------------------------------------------
echo "<hr/>";
echo "<br/><strong>getConferenceInfo:</strong><br/>";
$regHelper->getConferenceInfo(2);

echo "<hr/>";


?>
<!-- our error container -->

</form>

</body>
</html>
