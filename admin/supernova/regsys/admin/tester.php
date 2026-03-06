<?php
// TESTING ONLY BELOW ////////////////////

require '../includes/supernova.config.php';
function __autoload($class_name) {
    require_once "../classes/$class_name.php";
}

// TESTING ONLY ABOVE ////////////////////











function findRelativePath($filename, $args = null) {
	$__file_relativity = '';
	while (realpath($__file_relativity.$filename) === FALSE && strlen($__file_relativity) < 60 ) 
		{ $__file_relativity = "../".$__file_relativity; }
	if (is_file($__file_relativity.$filename)) {
		return $__file_relativity.$filename;
	}
	else
	{
		die (ERR_901 . " (File: $filename)");	
	}	
}


function render_partial($filename, $args = null) {
	$__file_relativity = "";
	while (realpath($__file_relativity.$filename) === FALSE && strlen($__file_relativity) < 60 ) 
		{ $__file_relativity = "../".$__file_relativity; }
		
    if (is_file($__file_relativity.$filename)) {
        ob_start();
        include $__file_relativity.$filename;
        $contents = ob_get_contents();
        ob_end_clean();
        echo $contents;
        return TRUE;
    }
    return FALSE;
}

function outputRaw($table, $format='d',$incKey=1,$delimiter="|",$filterValueStr='',$filterFieldStr='')
{
	$sqlHelper = new sqlHelper;
	$strSql	= outputRawSql($table, $filterValueStr,$filterFieldStr);
	$rsObj	= $sqlHelper->queryCmd($strSql);
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
*
*
*
*/
function outputRawSql($tableStr, $filterValueStr='', $filterFieldStr='', $whereArr='')
{
	if($filterValueStr != '')
	{
//		$sqlWhere		= sqlHelper->sqlWhereBuilder($whereArr);
		$filterField	= ($filterFieldStr == '') ? $tableStr . "_id" : $filterFieldStr;
		$strWhere		= " WHERE $filterField = '$filterValueStr'";
	}
	$tmpSql = "SELECT * FROM reg__" . $tableStr . $strWhere ;
		
	return $tmpSql;
}

echo "START<hr/>";
// PARAMS >>>>>

//echo findRelativePath('includes/jquery-1.3.2.js');
//render_partial('renderMe.php?test=bar');
//outputRaw();
echo outputRawSql('package', 'three', 'package_name');
echo "<hr/>All From Packages";
outputRaw('package','p');
echo "<hr/>Package Id 3";
outputRaw('package','d', null, ',',3);
echo "<hr/>";
outputRaw('package','p',1, null, 'three', 'package_name');
// <<<<< PARAMS
echo "<hr/>END";
?>