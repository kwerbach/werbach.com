<?php 
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');
header("Cache-Control: no-cache"); 

$regHelper = new regHelper;
echo $regHelper->getPriorityCodeInfo($_POST['conference_id'], $_POST['priority_code']);

//echo $_SERVER['QUERY_STRING'];
//echo json_encode(array("name"=>"John","time"=>"2pm")); 
?>