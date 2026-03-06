<?php
class regHelper
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
						<td><input name="conference_package" id="conference_package" type="radio" value="$package_id"/></td>
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
		$rsObj 			= $sqlHelper->queryCmd("SELECT amount, category, description, tag FROM reg__priority_code WHERE conference_id = $conferenceId AND code = $code AND DATE(NOW()) BETWEEN start_date AND end_date;");
		if($rsObj){
			$num = mysql_num_rows( $rsObj );
			if ($num == 1)
			{
				$rsRowArr = mysql_fetch_assoc($rsObj);
//				$return = $rsRowArr['amount'] . "|" . $rsRowArr['category'];
				if($details == 1)		// Let me know the specifics
				{
					return array("amount"=>$rsRowArr['amount'], "category"=>$rsRowArr['category'], "description"=>$rsRowArr['description'], "tag"=>$rsRowArr['tag']);
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
			else	// None found
			{
				$return = NULL;
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
												IF(DATE(NOW()) >= c.early_bird_cutoff_actual_date, p.amount, p.early_bird_amount) AS 'amount', 
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

	/** Get the amount, priority code, category and description 
	* @param $conferenceId int The conference code
	* @param $code string The priority code
	* @return array
	*/	
	public function setTagsAuto($conferenceId, $code, $packageId, $people_id)
	{
			if (isset($people_id))
				{
				$sqlHelper	= new sqlHelper;
				$rsObj 		= $sqlHelper->queryCmd("SELECT tag FROM reg__conference WHERE conference_id = $conferenceId
														UNION DISTINCT
														SELECT tag FROM reg__package WHERE conference_id = $conferenceId AND package_id = $packageId
														UNION DISTINCT
														SELECT tag FROM reg__priority_code WHERE conference_id = $conferenceId AND code = $code	
													;");
													
				if($rsObj)
				{
					while($rsRowArr = mysql_fetch_assoc($rsObj))
					{
	
							// TAG THAT GUY
							// setTag($people_id, $rsRowArr['tag']);
					}
				}
			}
												
	}
	
	public function setTag($people_id, $tag='')
	{
		
		// TODO: MAKE TAG AN ASSOC ARRAY ?//
		if ($tag != '')
		{
				$sqlHelper	= new sqlHelper;
				
				/** Check to se if person has aleady been give this tag */
				$rsObj 		= $sqlHelper->queryCmd("SELECT people_id, tag FROM people_tags
														WHERE people_id  = '$people_id' AND tag = '$tag';"
													);				
				
				/** Add the tag if the person has not already been tagged */
				$num = mysql_num_rows( $rsObj );
				if ($num < 1)
				{
					$rsObj 		= $sqlHelper->queryCmd("INSERT INTO `people_tags` 
																(people_id, 	tag, 	is_email_tag)
														VALUES 	($people_id, 	'$tag', 	'1');"
														);
				}
		}
	
	}
	
	/** Get the amountm, priority code, category and description.  This must come after data is in the registration table 
	* @param $conferenceId int The conference code
	* @param $type 1 = Web, 2 = Email
	* @param $format 1 = HTML, 2 = Plain Text
	* @param $replacementArr array that holds the replacement values for {{[A-Za-z0-9_]*}}
	* @return boolean
	*/	
	public function getThankYouMessage($conferenceId, $type=1, $format=1, $replacementArr)
	{
				$sqlHelper	= new sqlHelper;
				$rsObj 		= $sqlHelper->queryCmd("SELECT 'spacer', text_ty_page_body, text_email_body FROM reg__conference WHERE conference_id = $conferenceId;");
													
				$rsRowArr = mysql_fetch_row($rsObj);
				
				$message = $rsRowArr[$type];
				$pattern = '/{{[A-Za-z0-9_]*}}/';		// any number of alphanumeric characters plus "_"

//				echo $message;					// TESTING
				preg_match_all($pattern, $message, $matches);
//				print_r($matches);				// TESTING
//				echo count($matches[0]);		// TESTING
//				$replacementArr = array();//"seminar_description"=>"YOUR PACKAGE", "reg_year"=>"2008"); // TESTING
//				print_r($replacementArr);	// TESTING
				if (count($matches[0]) >= 1)
				{
					for($i = 0; $i <= count($replacementArr); $i++)
					{

						if(isset($matches[0][$i]))
						{
							$newStr = trim($matches[0][$i],'},{');
							$message = str_replace($matches[0][$i], strtoupper("<b>$replacementArr[$newStr]</b>"), $message);
						}							
					}
				}
				
				if($format == 1)		// HTML
				{
					$message = $message;
				}
				else
				{
					$message = strip_tags($message);
				}
				return $message;
				
	}
	
	public function getQuote($conferenceId=0, $quoteId=0, $numQuotes=1, $cssSuffix='')
	{
	
			if( $numQuotes > 0 )
			{
			
				$sqlHelper	= new sqlHelper;
				$quoteIdArr	= array();		// Holds the quote ids to be returned	
				$whereQuote =  $conferenceId == 0 ? "conference_id > 0" : "conference_id = $conferenceId";
			
				/** Randomize Quote(s) */
				if ($quoteId == 0)		// GET RANDOM QUOTE BY... 
				{

					$sql = "SELECT quote_id FROM reg__quote WHERE $whereQuote";
//					echo $sql "ALL QUOTES: " . $sql . "<br/>";
					$rsObj 		= $sqlHelper->queryCmd($sql);
	
					if ($rsObj) 
					{
						$num = mysql_num_rows( $rsObj );
						if ($num >= 1)
						{
							while($rsRowArr = mysql_fetch_row($rsObj))			// Put the quotes in an array
							{
								array_push($quoteIdArr, $rsRowArr[0]);
							}
						}
						else
						{
							die( ERR_122 . ' (conferenceId IN --> ' . $whereQuote . ')' );					
						}
					}
					
					shuffle($quoteIdArr);		// Mix up the array
					
					$maxNumQuotes = count($quoteIdArr) >= $numQuotes ? $numQuotes : count($quoteIdArr);  // Take the lower of # asked for and the actual number of quotes
					
	//					for($i = 0, $i < $maxNumQuotes, $i++)
	//					{
	//						echo $quoteIdArr[i];
	//					}
	
					$returnQuotesArr = array_chunk($quoteIdArr, $maxNumQuotes);		// Put an X-sized chunck of the array into another array
					
					$comma_separated = implode(",", $returnQuotesArr[0]);				// Take those peices and put them in a CSV list
					
					$whereQuoteId = " quote_id IN ($comma_separated)";				// Put it in the the WHERE
					
				}
				else		// Return one specific quote
				{
					$whereQuoteId = " quote_id = $quoteId";
				}
				
				/** Get the quotes */
				$sql 		= "SELECT DISTINCT * FROM reg__quote WHERE $whereQuoteId";
//				echo $sql;	// TESTING
				$rsObj2 		= $sqlHelper->queryCmd($sql);		// TESTING
				while($rsRowArr = mysql_fetch_assoc($rsObj2))		// Put the quotes in an array
				{
//					echo "<div class=\"quote_container$cssSuffix\">\n";
					echo "\t<div id=\"quotebody$cssSuffix\">" . $rsRowArr['quote_text'] . "</div>\n\t<div id=\"quoteauthor$cssSuffix\">" . $rsRowArr['quote_source'] . "</div>\n";
//					echo "</div>\n";
				}
			}
			return 1;		// TODO: return an array of quotes for mor flexibility
	}

	
}
?>