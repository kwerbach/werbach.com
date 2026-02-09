<?php 
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');
header("Cache-Control: no-cache"); 


$orderByStr		= isset($_GET['x_order']) 		? $_GET['x_order'] 		: '';
$orderByDir		= isset($_GET['x_orderDir']) 	? $_GET['x_orderDir'] 	: ''; 
if(isset($_COOKIE['conferenceIdCk']))
{
	$_GET['conference_id']	= $_COOKIE['conferenceIdCk'];
}

$listDisplay	= new listDisplay($_GET['x_list'], $_GET, array($orderByStr=>$orderByDir), array()); 
?>