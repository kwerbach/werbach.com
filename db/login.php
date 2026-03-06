<?php
session_start();
$username = trim($HTTP_POST_VARS['username']);     // Get user's name from form on previous page
$password = trim($HTTP_POST_VARS['password']);     // Get password from form on previous page

// $_SESSION["go_to_page"] IS THE PAGE THAT WAS ORIGINALLY REQUESTED
$go_to_page = ($_SESSION["go_to_page"] == "") ? "people_search_form.php"  : $_SESSION["go_to_page"];
$invalid 	= "login_invalid.php";
$SSS_page 	= $HTTP_SESSION_VARS['SSS_page'];

require("people_connect.php");
$Link = mysql_pconnect ($Host, $User, $Password);
mysql_select_db($DBName, $Link);
$Query = "SELECT * FROM login WHERE login.username = '" . $username . "' AND login.password = '" . $password . "'";
$Recordset = mysql_query($Query, $Link);
$rows = mysql_num_rows($Recordset);
if ($rows == 0)
  {
  $found = 0;
  }
else
  {
  while ($Row = mysql_fetch_assoc($Recordset)) 
      {
          $privilege = $Row['privilege'];
      }
   $found = 1;
  }
mysql_free_result($Recordset);
if ($found == 1)
{
     $SSS_privilege = $privilege;
     $HTTP_SESSION_VARS['SSS_privilege'] = $SSS_privilege;
//header("Location:people_search_form.php");  // Send him/her to the page they requested!
header("Location:$go_to_page");  // Send him/her to the page they requested!
}
else
{
header("Location:$invalid");  // Send him/her login invalid!
}

?>
