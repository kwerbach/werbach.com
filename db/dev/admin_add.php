<?

session_start();

$username = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['username'] : addslashes($HTTP_POST_VARS['username']);
$password = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['password'] : addslashes($HTTP_POST_VARS['password']);
if (isset($HTTP_POST_VARS['privilege']))
{
$privilege = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['privilege'] : addslashes($HTTP_POST_VARS['privilege']);
}
if (!isset($HTTP_POST_VARS['privilege']))
{
$privilege = "1";
}

$fieldname = "";
$fieldname = $fieldname . "username,";
$fieldname = $fieldname . "password,";
$fieldname = $fieldname . "privilege";
$insertfield = "";
$insertfield = $insertfield . "'" . $username . "',";
$insertfield = $insertfield . "'" . $password . "',";
$insertfield = $insertfield . $privilege;

require("admin_connect.php");

$Link = mysql_pconnect($Host, $User, $Password);
mysql_select_db($DBName, $Link); 
$query1 = "INSERT INTO login (" . $fieldname . ")";
$query2 = " VALUES (" . $insertfield . ")";
$Query = $query1 . $query2;
if ($Result = mysql_query($Query, $Link))
{
?>
<html>
<link rel="stylesheet" href="admin_styles.css" type="text/css">
<body topmargin=0 leftmargin=0 marginheight=0 marginwidth=0>
<?
require("admin_header.inc");
?>
<p><div align="center"><b>Record successfully added!</b></div>
</body>
</html>
<?
}
else
{
?>
<html>
<link rel="stylesheet" href="admin_styles.css" type="text/css">
<body topmargin=0 leftmargin=0 marginheight=0 marginwidth=0>
<?
require("admin_header.inc");
?>
<p><b>ERROR:  Record was not successfully added</b></p>
<p>Chances are a required field was left blank.  Click back and try again.
<p><a href="admin_menu.php">Continue</a>
</body>
</html>
<?
}
?>
