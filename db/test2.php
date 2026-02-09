<?php
session_start();
echo "<hr/>";
echo $_SESSION["go_to_page"];
echo "<hr/>";
echo $_SERVER['SCRIPT_FILENAME'];
echo "<hr/>";
echo $_SESSION['SSS_privilege'];
echo "<hr/>";
echo date("Y-m-d H:i:s");
echo "<hr/>";
?>
TEST 2