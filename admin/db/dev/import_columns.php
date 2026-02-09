<html><head><title>Columns for Import</title></head><body>

<?php
	require_once('functions.php');
	$Link = mysql_pconnect ($Host, $User, $Password);
	mysql_select_db($DBName, $Link);
	$row = explode(",", get_fields());
	
	foreach ($row as $col)
		print "$col<br/>";
?>
	
</body></html>	