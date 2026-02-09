<?
session_start();

$redirect = "admin_login_form.php";
$SSS_page = "admin_search_form.php";
$ID = $HTTP_GET_VARS['ID'];
if (!isset($HTTP_SESSION_VARS['SSS_page']))
{
session_register("SSS_page");
}
else
{
$HTTP_SESSION_VARS['SSS_page'] = $SSS_page;
}
if (isset($HTTP_SESSION_VARS['SSS_privilege']))
{
 if ($HTTP_SESSION_VARS['SSS_privilege'] < 5) // If person has not logged in with admin privileges...
 {
     header("Location:$redirect");  // Send him/her to the login page!
 }
}
else
{
header("Location:$redirect");  // Send him/her to the login page!
}
require("admin_connect.php");

$Link = mysql_pconnect($Host, $User, $Password);
mysql_select_db($DBName, $Link); 
$Query = "DELETE FROM login WHERE login.ID = " . $ID;
if ($Result = mysql_query($Query, $Link))
{
?>
<html>
<link rel="stylesheet" href="admin_styles.css" type="text/css">
<body topmargin=0 leftmargin=0 marginheight=0 marginwidth=0>
<?
require("admin_header.inc");
?>
<p><div align="center"><b>Record successfully deleted!</b>
<?
}
else
{
?>
<p>Record not successfully deleted.  Please try again later and contact your software vendor, if the problem persists.
<?
}
?>
</div>
</body>
</html>
