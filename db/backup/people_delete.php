<?

session_start();

$key = $HTTP_GET_VARS['key'];
$total_results = $HTTP_SESSION_VARS['total_results'];
 $itemNumber = $HTTP_GET_VARS['itemNumber'];
 if ($itemNumber == 0)
 {
 $screen = 1;
 }
 else
 {
$itemNumber = $itemNumber - 1;
 if (($itemNumber / 25 ) < ceil($itemNumber / 25))
      {
      $screen = ceil($itemNumber / 25);
      }
      else
      {
      $screen = ceil($itemNumber / 25) + 1;
      }
 }
$backToSearch = "people_search_results.php?screen=" . $screen;

require("people_connect.php");

$Link = mysql_pconnect ($Host, $User, $Password);
mysql_select_db($DBName, $Link);
$Query = "DELETE FROM people WHERE people.ID = " . $key;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

<title> Delete</title>
<link rel="stylesheet" href="people_styles.css" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../Werbach/Web%20Pages/asap%20db/people_styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<p class="title">Supernova Group Database</p>
<p>
<?
require("people_header.inc");
?>
<?
if ($Result = mysql_query($Query, $Link))
{
?>
<p><div class='pagetext' align='center'><b>Record successfully deleted!</b></div>
<?
if (isset($itemNumber))
{
?>
<p><div align='center'><a class='links' href='<?=$backToSearch?>'>Back to Search Results</a></div>
<?
}
?>
<?
}
else
{
?>
<p><div class='pagetext' align='center'>Record not successfully deleted.  Please try again later and contact your software vendor, if the problem persists.</div>
<?
}
?>
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->

</p>
</body>
</html>
