<?php
require "../inc_db.php";
require "inc_forms.php";
$reg_year = "2008";
	
dbconnect();
$sql 	= "DELETE FROM supernova_registrations WHERE supernova_registration_id = '" . $_GET['i'] . "' LIMIT 1";
$result	= safe_query($sql);

$sql2 	= "DELETE FROM email_aliases  WHERE people_id = '" . $_GET['p'] . "' AND for_event = 'Supernova " . $reg_year . "' LIMIT 1"; 
$result	= safe_query($sql2);

header("Location: " . $_GET['n']);


echo $sql;
echo "<hr/>";
echo $sql2;
echo "<hr/>";
echo $_GET['n'];
echo "<hr/>";
echo $_GET['p'];

?>