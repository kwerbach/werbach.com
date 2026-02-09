<?php
header("Cache-Control: no-cache"); 
require 'includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

// Check for data table
if(!isset($_REQUEST['d']))
{
	die (ERR_151);
}

// Check to see that filter count matches
if(isset($_REQUEST['f']) || isset($_REQUEST['fv']))
{
	if (count($_REQUEST['f']) != count($_REQUEST['fv'])) 
	{
		die (ERR_152);
	}
}

// Check for debug
if(isset($_REQUEST['debug']))
{
	print_r($_REQUEST);
	echo "---\n\n\n";
}

// Build where array
$whereArr = array();
if(isset($_REQUEST['f']))
{
	for ($i = 0; $i < count($_REQUEST['f']); $i++)
	{
		$whereArr[$_REQUEST['f'][$i]] = $_REQUEST['fv'][$i];
	}
}

// Set parameters
$data 		= $_REQUEST['d'];
$filter		= $whereArr;
$cols 		= (isset($_REQUEST['cols'])) 	? $_REQUEST['cols'] 	: '*';
$rf		 	= (isset($_REQUEST['rf'])) 		? $_REQUEST['rf'] 		: 'd';
$del 		= (isset($_REQUEST['del'])) 	? $_REQUEST['del'] 		: '|';
$k 			= (isset($_REQUEST['k'])) 		? $_REQUEST['k'] 		: '1';

// Output the data
outputRaw($data, $filter, $cols, $rf, $del, $k);

///////////////////////////////////////////////////////////////////////////////////////////////////////
//// FUNCTIONS ////////////////////////////////////////////////////////////////////////////////////////

/** outputRaw returns table data to be used in word press
* @param $data string This is the table name or or reference to joins
* @param $filter array Filter dataset on there values.
* @param $cols string A comma separated sting of fields to return.
* @param $format string How you want the data to be returned. Default is pipe delimited.
* @param $incKey boolean Include the key/field name with the delimited data value.
* @param $delimiter string The charater that will delimit the string.

* POST:
*	d 		= table name (required)
*	f[]		= array of fields to filter on (required)
*				Note:
*					- prefix the field with "e_" for equals  (e.g. e_name --> name = '<value>')
*					- prefix the field with nothing for "like"   (e.g. e_name --> name LIKE '<value>%')
*	fv[]	= files of values (required)
*				Note:
*					- there must be one FV[] for each f[]
*	cols	= A comma separated list of fields to return
*	rf		= return format.
*				Note:
*					- deafult: value separator is a pipe ("|") delimited, and line is "~~\n"
*					- d = delimited (default)
*					- j = json
*					- p = PHP print_r
*					- x = XML
*	k		= return the field/key name with the delimited value.
*				Note:
*					- values 1 or 0
*					- default is 1
*					- field/key name will be separated from the value with a ":"
*	del		= change the default delimiter
*				Note:
*					- default delimiter is a pipe ("|")	
*	debug	= print posted data to the screen
*				Note:
*					- value <anything>
*					- if debug is passed the "post" will be printed
*					
* 	Working example: /output.php?d=package&f[]=e_conference_id&fv[]=2&cols=package_name,amount&rf=d&k=0&del=,					
*/

function outputRaw($data, $filter, $cols='*', $format='d',$delimiter="|",$incKey=1)
{
	$sqlHelper 	= new sqlHelper;
	$strSql		= outputRawSql($data, $filter, $cols);
	$rsObj		= $sqlHelper->queryCmd($strSql);
	$delimited	=	'';
			if($rsObj)
			{
				$returnArr = array();
				while($rsRowArr = mysql_fetch_assoc($rsObj))
				{
					array_push($returnArr, $rsRowArr);
				}

				$xml	=	"<record_set>";
				
				foreach($returnArr as $recordArr)		// for each record
				{
					$xml	.=	"<record>";
					foreach($recordArr as $key => $value )	// for each value in the record
					{
						// include field name
						$delimited	.= (1 == $incKey) ? "$key:$value$delimiter" : "$value$delimiter";
						$xml		.= "\t<$key><![CDATA[$value]]></$key>\n";

					}
					$delimited	= trim($delimited,$delimiter);	// end the row
					$delimited	.= "~~\n";						// end the row
					
					$xml	.=	"</record>";						// end the record
				}
				
					$xml	.=	"</record_set>";
				
				switch ($format) 
				{
					case 'j':
						echo json_encode($returnArr);
						break;	
					case 'p':		// PHP ARRAY		
						echo print_r($returnArr);
						break;
					case 'x':		// PHP ARRAY		
						echo "<?xml version=\"1.0\"?>" . $xml;
						break;						
					default:
						echo $delimited;
				}	
			}
}

/** Create a SQL statment for the Output Raw Function
* @param $dataStr string
* @param $whereArr array
* @param $colsStr string
* @return string SQL statement
*/
function outputRawSql($dataStr, $whereArr=array(), $colsStr='*')
{
	$sqlHelper 	= new sqlHelper;
	$sqlWhere	= '';

	// build where clause
	if(count($whereArr) > 0)
	{
		$sqlWhere		= $sqlHelper->sqlWhereBuilder($whereArr);
	}

	// build find or create (in the case of a join) the correct table
	switch ($dataStr) 
	{
		case 'xxx':
			$tableStr	= "conference";
			break;
		default:
			// must be a table name
			$tableStr	= $dataStr;
	}

	$tmpSql = "SELECT $colsStr FROM reg__" . $tableStr . $sqlWhere ;
		
	return $tmpSql;
}
?>