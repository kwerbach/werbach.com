<?php
require_once("people_connect.php");
$Link = mysql_pconnect ($Host, $User, $Password);
mysql_select_db($DBName, $Link);
$Query = "DELETE FROM people_tags WHERE people_id = " . $_GET["id"] . " AND tag = '" . $_GET["tag"] . "'";
mysql_query($Query)	or die("ack! query failed: "
				."<li>errorno=".mysql_errno()
				."<li>error=".mysql_error()
				."<li>query=".$Query);
//echo $Query;
$redirect = "people_edit_detail.php?key=" . $_GET["id"];
//echo $redirect;
header("Location:$redirect");


?>