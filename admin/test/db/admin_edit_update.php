<?
session_start();


$itemNumber = $HTTP_POST_VARS['itemNumber'];
if (isset($HTTP_POST_VARS['ID']))
{
 $ID = $HTTP_POST_VARS['ID'];
}
$whereclause = $HTTP_SESSION_VARS['whereclause'];
$total_results = $HTTP_SESSION_VARS['total_results'];
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

if ($itemNumber == 0)
{
$screen = 1;
}
else
{
if (($itemNumber / 10) < ceil($itemNumber / 10))
      {
      $screen = ceil($itemNumber / 10);
      }
      else
      {
      $screen = ceil($itemNumber / 10) + 1;
      }
}
$backToSearch = "admin_edit_search_results.php?screen=" . $screen;

$updatefields = "";
$updatefields = $updatefields . "username='" . $username . "',";
$updatefields = $updatefields . "password='" . $password . "',";
$updatefields = $updatefields . "privilege=" . $privilege;

require("admin_connect.php");

$Link = mysql_pconnect ($Host, $User, $Password);
mysql_select_db($DBName, $Link);

$Query = "UPDATE login SET " . $updatefields . " WHERE login.ID = " . $ID;

if ($Result = mysql_query($Query, $Link))
{
?>
<html>
<link rel="stylesheet" href="admin_styles.css" type="text/css">
<body topmargin=0 leftmargin=0 marginheight=0 marginwidth=0>
<?
require("admin_header.inc");
?>
<br><div align="center"><b>Record successfully updated!</b>
<p><a href="<?=$backToSearch?>">Back To Search Results</a></div>
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
<p><b>ERROR:</b></p>
<p>Chances are a required field was left blank.
<p><a href="admin_menu.php">Continue</a>
</body>
</html>
<?
}
?>
