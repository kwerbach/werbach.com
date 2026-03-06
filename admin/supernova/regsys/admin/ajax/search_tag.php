<?php
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');
header("Cache-Control: no-cache"); 

$sqlStr	= "SELECT DISTINCT tag FROM people_tags ORDER BY tag";
$items	= array();

$sqlHelper = new sqlHelper;
$rsObj = $sqlHelper->queryCmd($sqlStr);
	if($rsObj)
	{
		while($rsRowArr = mysql_fetch_row($rsObj))
		{
			array_push($items, $rsRowArr[0]);
		}
	}

$q = strtolower($_GET["q"]);
if (!$q) return;

foreach ($items as $key=>$value) {
//	if (strpos(strtolower($key), $q) !== false) {
	if (strpos(strtolower($value), $q) !== false) {	
//		echo "$key|$value\n";		// USE FOR HIDDEN VALUE AND KEY // TESING 
		echo "$value|$value\n";
	}
}

?>