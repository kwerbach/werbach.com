<?php
// This file handles form submission
// the key field must be prefixed with 2 underscores ("__")
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

$fieldArr = array();				// Will hold field names
$valueArr = array();				// Will hold field values
$sqlHelper = new sqlHelper;
$sqlHelper->arrToSql($_POST);		// Cycle through associative array to put into SQL

$tableIdValue		= explode('|',findTableIdValue($_POST));
$tableNameStr		= 'reg__' . $tableIdValue[0];				// table name
$tableIdFieldStr	= $tableIdValue[1];							// name of primary key field
$tableIdValueStr	= $tableIdValue[2];							// value of primary key
$whereClauseStr		= ' WHERE ' . $tableIdValue[1] . ' = ' . $tableIdValue[2];  // TODO: WORK ON SOMETHING FOR AN ARRAY

/** 
* Check for an existing record
*/
if ($tableIdValueStr == '') // Insert
{
	$tableIdValueStr = $sqlHelper->sqlInsert($fieldArr, $valueArr, $tableNameStr);
	$querySrting = "?$tableIdValue[1]=$tableIdValueStr";
}
else // Update
{
	$sqlHelper->sqlUpdate($fieldArr, $valueArr, $tableNameStr, $whereClauseStr);
}
// echo $_SERVER['HTTP_REFERER'] . $querySrting;	// TESTING
header("Location:  " . $_SERVER['HTTP_REFERER'] . $querySrting);

// FUNCTIONS BELOW //////////////////////////////////////////////////////////////

/**
* Look for the field prefixed with 2 underscores ("__") then parse out the filed name and the value
* @param array The array to cycle through
* @return string
*/
function findTableIdValue($tempArray)
{
	foreach($tempArray as $key => $value)
	{
		if(substr($key, 0, 2) == '__')
		{
			// table | table id field | id value
			return substr($key, 2, strlen($key)-5) .'|'. substr($key, 2, strlen($key)) .'|' . $value;	// 5 = 2 (the prefice + 3 (lenght of '_id')
		}
	}	
}
?>