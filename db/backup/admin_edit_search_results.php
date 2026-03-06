<?
session_start();


require("admin_connect.php");
// hardwire stuff here //
$lineIndex = 0;
$linkCount = 0;
$itemNumber = 0;
$rows_per_page = 25;

if (isset($HTTP_POST_VARS['username']))
{
 $username = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['username'] : addslashes($HTTP_POST_VARS['username']);
}
if (isset($HTTP_POST_VARS['password']))
{
$password = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['password'] : addslashes($HTTP_POST_VARS['password']);
}
if (isset($HTTP_POST_VARS['privilege']))
{
$privilege = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['privilege'] : addslashes($HTTP_POST_VARS['privilege']);
}
if (!isset($HTTP_POST_VARS['privilege']))
{
$privilege = "";
}

if (isset($HTTP_POST_VARS['begin_search']))
{
 $whereclause = "WHERE ";
 if ($username <> "")
 {
     $whereclause = $whereclause . "login.username LIKE '" . $username . "' AND ";
 }
 if ($password <> "")
 {
     $whereclause = $whereclause . "login.password LIKE '" . $password . "' AND ";
 }
 if ($privilege <> "")
 {
   $whereclause = $whereclause . "login.privilege = " . $privilege . " AND ";
}

 if ( substr($whereclause,-5) == " AND ")
 {
     $whereclause = substr_replace($whereclause,"",-5);  // strip off ' AND'
 }
 else
 {
     $whereclause = substr_replace($whereclause,"",-6);  // strip off 'WHERE '
 }
 if (!isset($HTTP_SESSION_VARS['whereclause']))
 {
     session_register("whereclause");
 }
 else
 {
    $HTTP_SESSION_VARS['whereclause'] = $whereclause;
 }
}

if (!isset($whereclause))
{
 $whereclause = $HTTP_SESSION_VARS['whereclause'];
}

// counting records here //
$Link = mysql_pconnect ($Host, $User, $Password);
mysql_select_db($DBName, $Link);
$Count = "SELECT * FROM login " . $whereclause;
$Recordset = mysql_query($Count, $Link);

if (!isset($total_records))
{
     $total_records = mysql_num_rows($Recordset);
     $total_results = $total_records - 1;
     if (!isset($HTTP_SESSION_VARS['total_results']))
     {
             session_register("total_results");
     }
     else
     {
             $HTTP_SESSION_VARS['total_results'] = $total_results;
     }
}
$pages = ceil($total_records / $rows_per_page);
mysql_free_result($Recordset);

//  looking for request of screen number (alias Page Number) //
if (!isset($HTTP_GET_VARS['screen']))
{
$screen = 1;
}
else
{
$screen = $HTTP_GET_VARS['screen'];
}
$start = ($screen - 1) * $rows_per_page;

$Query = "SELECT * FROM login " . $whereclause . " ORDER BY login.username LIMIT $start, $rows_per_page";
$Recordset = mysql_query($Query, $Link);
$rows = mysql_num_rows($Recordset);

// this is the total number of chapters holding the pages //
$Chapters = ceil($pages / 10);

// this is the current chapter //
$Chapter = ceil($screen * .1);

// this would be the first page in the current chapter //
$start10 = ($Chapter * 10) - 9;

// this would be the last page in the current chapter //
$stop10 = $Chapter * 10;
if ($stop10 > $pages)
{
  $stop10 = $pages;
}

$next1 = $stop10 + 1;
$previous1 = $start10 - 1;

$Next = "admin_edit_search_results.php?screen=" . $next1;
$Previous = "admin_edit_search_results.php?screen=" . $previous1;
?>
<HTML>
<head>
<title>Admin Search Results</title>
<link rel="stylesheet" href="admin_styles.css" type="text/css">
</head>
<body topmargin=0 leftmargin=0 marginheight=0 marginwidth=0>
<?
require("admin_header.inc");
?>

<table class="results" width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="10" class="strip">&nbsp;</td>
          <td class="strip">USERNAME</td>
          <td class="strip">PASSWORD</td>
          <td class="strip">PRIVILEGE</td>
        </tr>
<?
for ($i = 0; $i < $rows; $i++)
{
  while ($Row = mysql_fetch_assoc($Recordset)) 
  {
      $newitemNumber = (($screen - 1) * $rows_per_page) + $itemNumber;
                  if ($lineIndex % 2 == 0)
                  {
?>
        <tr> 
          <td width="10" class="data1">&nbsp;</td>
          <td class="data1"><a class="datalink" href="admin_edit_detail.php?ID=<? echo $Row['ID']; ?>&itemNumber=<? echo $newitemNumber; ?>"><? echo $Row['username']; ?></a></td>
          <td class="data1"><? echo $Row['password']; ?></td>
          <td class="data1"><? echo $Row['privilege']; ?></td>
        </tr>
<?
}
else
{
?>
        <tr> 
          <td width="10" class="data2">&nbsp;</td>
          <td class="data2"><a class="datalink" href="admin_edit_detail.php?ID=<? echo $Row['ID']; ?>&itemNumber=<? echo $newitemNumber; ?>"><? echo $Row['username']; ?></a></td>
          <td class="data2"><? echo $Row['password']; ?></td>
          <td class="data2"><? echo $Row['privilege']; ?></td>
        </tr>
<?
}
?>
<?
          $lineIndex = $lineIndex + 1;
          $itemNumber = $itemNumber + 1;
  }
?>
      </table>
    </td>
  </tr>
  <tr>
    <td class="strip">&nbsp;</td>
  </tr>
</table>
<?
}
$previousurl = "admin_edit_search_results.php?" . SID . "&screen=" . ($screen - 1);
$nexturl = "admin_edit_search_results.php?" . SID . "&screen=" . ($screen + 1);
?>
<br><br>
<div align="center">
<table border="0" cellspacing="0" cellpadding="0" class="detail" width="600">
    <tr> 
      <td width="35%"> 
        <div align="center"> 
<?
if ($screen > 1 && $screen < $pages)
{
?>
          <table width="150" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#CCCCCC">
            <tr>
              <td class="button"> 
                <div align="center"> 
                  <p><a class="button" href="<? echo $previousurl ?>">PREVIOUS</a></p>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </td>
      <td width="30%"> 
        <div align="center"> </div>
      </td>
      <td width="35%">
        <div align="center"> 
<?
}
elseif ($screen > 1 && $screen == $pages)
{
?>
          <table width="150" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#CCCCCC">
            <tr> 
              <td class="button"> 
                <div align="center"> 
                  <p><a class="button" href="<? echo $previousurl ?>">PREVIOUS</a></p>
                </div>
              </td>
            </tr>
          </table>
<?
}
elseif ($screen < $pages && $screen == 1)
{
?>
          <table width="150" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#CCCCCC">
            <tr> 
              <td class="button"> 
                <div align="center"> 
                  <p><a class="button" href="<? echo $nexturl ?>"> NEXT</a></p>
                </div>
              </td>
            </tr>
          </table>
<?
}
if ($screen < $pages && $screen > 1)
{
?>
          <table width="150" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#CCCCCC">
            <tr> 
              <td class="button"> 
                <div align="center"> 
                  <p><a class="button" href="<? echo $nexturl ?>"> NEXT</a></p>
                </div>
              </td>
            </tr>
          </table>
<?
}
?>
        </div>
      </td>
    </tr>
  </table>
  <br>
<?
if ($total_records == 0)
{
?>
  <b>Sorry, no records in the database matched your search parameters. Click Back and try again. </b>
<?
}
?>
</div>
<div align="center">
<table cellpadding="0" cellspacing="2">
<?
if ($Chapter > 1)
{
?>
<td>
<a href="<?=$Previous?>">PREVIOUS 10</a>
</td>
<?
}
// loops through entire range of numbers

for ($i = $start10; $i <= $stop10; $i++)
{
$URL = "people_search_results.php?screen=" . $i;
  if ($i == $screen)
    {
    ?>
    <td>
    <table border="1" bordercolor="#000000" cellpadding="0" cellspacing="0">
    <tr>
    <td class="selected" bgcolor="#cccccc" valign="bottom" width="15"><? echo $i; ?></td>
    </tr>
    </table>
    </td>
    <?
    }
    else
    {
    ?>
  <td valign="bottom"><b>
  <a href="<?=$URL?>">&nbsp;<?=$i?></a></b>&nbsp;
    </td>
    <?
    }
}
if ($Chapter < $Chapters)
{
?>
<td>
<a href="<?=$Next?>">NEXT 10</a>
</td>
<?
}
?>
</tr>
</table>
</tr>
</table>
</div>
<div align="center">
  <table width="540" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td> 
        <div align="center">Click on the hyperlinks in the leftmost column for 
          more information. </div>
      </td>
    </tr>
  </table>
</div>
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->
</BODY>
</HTML>
