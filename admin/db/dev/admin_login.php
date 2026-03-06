<?

session_start();

$invalid = "admin_login_invalid.php";
$username = $HTTP_POST_VARS['username'];
$password = $HTTP_POST_VARS['password'];
$SSS_page = $HTTP_SESSION_VARS['SSS_page'];

require("admin_connect.php");
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
mysql_free_result($Recordset);
   $found = 1;
  }
if ($found == 1)
{
 $SSS_privilege = $privilege;
 if (!isset($HTTP_SESSION_VARS['SSS_privilege']))
 {
     session_register("SSS_privilege");
 }
 else
 {
     $HTTP_SESSION_VARS['SSS_privilege'] = $SSS_privilege;
 }
 header("Location:$SSS_page");  // Send him/her to the page they requested!
}
else
{
header("Location:$invalid");  // Send him/her login invalid!
}

?>
