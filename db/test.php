<?php
phpinfo();

include "functions.php";
session_start();
//check_login($_SERVER['PHP_SELF'], $_SERVER["QUERY_STRING"]);


echo $_SERVER['PHP_SELF'];
echo "<hr/>";
echo $_SERVER["QUERY_STRING"];
echo "<hr/>";
echo basename($_SERVER['PHP_SELF']);
echo "<hr/>";
echo date("Y-m-d H:i:s");
echo "<hr/>";

?>
TEST
