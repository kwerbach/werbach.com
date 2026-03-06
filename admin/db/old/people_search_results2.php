<?
session_start();


$redirect = "login_form.php";
$SSS_page = "people_search_form.php";
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
 if ($HTTP_SESSION_VARS['SSS_privilege'] < 1) // If person has not logged in with view privileges...
 {
     header("Location:$redirect");  // Send him/her to the login page!
     die();
 }
}
else
{
header("Location:$redirect");  // Send him/her to the login page!
die();
}
require("people_connect.php");
// hardwired stuff here //
$THISuniqueID = "people15122003113316";
$lineIndex = 0;
$linkCount = 0;
$itemNumber = 0;
$get = 0;
$post = 0;
$newID = 0;
$rows_per_page = 25;
$pages = 1;
$screen = 1;
$preOrder = " ORDER BY people.";
// looking for uniqueID information here //
if (!isset($HTTP_SESSION_VARS['uniqueID']))
{
$uniqueID = "people15122003113316";
 session_register('uniqueID');
}
if (isset($HTTP_SESSION_VARS['uniqueID']))
{
 if ($HTTP_SESSION_VARS['uniqueID'] <> $THISuniqueID)
 {
     $newID = 1;
     $HTTP_SESSION_VARS['uniqueID'] = $THISuniqueID;
 }
}

// looking to see Ascending or Descending //
if (isset($HTTP_GET_VARS['asapDesc']))
{
 $asapDesc = " DESC";
}
else
{
 $asapDesc = " ASC";
}
// looking for variables from url //
if (isset($HTTP_GET_VARS['ID']))
{
 $ID = (get_magic_quotes_gpc()) ? $HTTP_GET_VARS['ID'] : addslashes($HTTP_GET_VARS['ID']);
 $get = 1;
}
if (isset($HTTP_GET_VARS['last']))
{
 $last = (get_magic_quotes_gpc()) ? $HTTP_GET_VARS['last'] : addslashes($HTTP_GET_VARS['last']);
 $get = 1;
}
if (isset($HTTP_GET_VARS['first']))
{
 $first = (get_magic_quotes_gpc()) ? $HTTP_GET_VARS['first'] : addslashes($HTTP_GET_VARS['first']);
 $get = 1;
}
if (isset($HTTP_GET_VARS['email']))
{
 $email = (get_magic_quotes_gpc()) ? $HTTP_GET_VARS['email'] : addslashes($HTTP_GET_VARS['email']);
 $get = 1;
}
if (isset($HTTP_GET_VARS['company']))
{
 $company = (get_magic_quotes_gpc()) ? $HTTP_GET_VARS['company'] : addslashes($HTTP_GET_VARS['company']);
 $get = 1;
}
if (isset($HTTP_GET_VARS['phone']))
{
 $phone = (get_magic_quotes_gpc()) ? $HTTP_GET_VARS['phone'] : addslashes($HTTP_GET_VARS['phone']);
 $get = 1;
}
if ($get == 1)
{
$whereclause = "WHERE ";
if (isset($ID))
{
     $whereclause = $whereclause . "people.ID LIKE '%" . $ID . "%' AND ";
}
if (isset($last))
{
     $whereclause = $whereclause . "people.last LIKE '%" . $last . "%' AND ";
}
if (isset($first))
{
     $whereclause = $whereclause . "people.first LIKE '%" . $first . "%' AND ";
}
if (isset($email))
{
     $whereclause = $whereclause . "people.email LIKE '%" . $email . "%' AND ";
}
if (isset($company))
{
     $whereclause = $whereclause . "people.company LIKE '%" . $company . "%' AND ";
}
if (isset($phone))
{
     $whereclause = $whereclause . "people.phone LIKE '%" . $phone . "%' AND ";
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
     session_register('whereclause');
 }
 else
 {
     $HTTP_SESSION_VARS['whereclause'] = $whereclause;
 }
     $fullOrderBy = " ORDER BY people.last";
 if (!isset($HTTP_SESSION_VARS['fullOrderBy']))
 {
     session_register('fullOrderBy');
 }
 else
 {
     $HTTP_SESSION_VARS['fullOrderBy'] = $fullOrderBy;
 }
}
// looking for variables from search form //
if (isset($HTTP_POST_VARS['ID']))
{
 $ID = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['ID'] : addslashes($HTTP_POST_VARS['ID']);
 $post = 1;
}
if (isset($HTTP_POST_VARS['last']))
{
 $last = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['last'] : addslashes($HTTP_POST_VARS['last']);
 $post = 1;
}
if (isset($HTTP_POST_VARS['first']))
{
 $first = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['first'] : addslashes($HTTP_POST_VARS['first']);
 $post = 1;
}
if (isset($HTTP_POST_VARS['email']))
{
 $email = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['email'] : addslashes($HTTP_POST_VARS['email']);
 $post = 1;
}
if (isset($HTTP_POST_VARS['company']))
{
 $company = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['company'] : addslashes($HTTP_POST_VARS['company']);
 $post = 1;
}
if (isset($HTTP_POST_VARS['phone']))
{
 $phone = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['phone'] : addslashes($HTTP_POST_VARS['phone']);
 $post = 1;
}

// looking to see if we've come from a search form //
if ($post == 1)
{
$whereclause = "WHERE ";
if ($ID <> "")
{
     $whereclause = $whereclause . "people.ID LIKE '%" . $ID . "%' AND ";
}
if ($last <> "")
{
     $whereclause = $whereclause . "people.last LIKE '%" . $last . "%' AND ";
}
if ($first <> "")
{
     $whereclause = $whereclause . "people.first LIKE '%" . $first . "%' AND ";
}
if ($email <> "")
{
     $whereclause = $whereclause . "people.email LIKE '%" . $email . "%' AND ";
}
if ($company <> "")
{
     $whereclause = $whereclause . "people.company LIKE '%" . $company . "%' AND ";
}
if ($phone <> "")
{
     $whereclause = $whereclause . "people.phone LIKE '%" . $phone . "%' AND ";
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
     session_register('whereclause');
 }
 else
 {
     $HTTP_SESSION_VARS['whereclause'] = $whereclause;
 }
     $fullOrderBy = " ORDER BY people.last";
 if (!isset($HTTP_SESSION_VARS['fullOrderBy']))
 {
     session_register('fullOrderBy');
 }
 else
 {
     $HTTP_SESSION_VARS['fullOrderBy'] = $fullOrderBy;
 }
}
// looking to see if we've received some commands to orderby a certain field //
if (isset($HTTP_GET_VARS['asapOrder']))
{
 $asapOrder = $HTTP_GET_VARS['asapOrder'];
 $fullOrderBy = $preOrder . $asapOrder . $asapDesc;
 $HTTP_SESSION_VARS['fullOrderBy'] = $fullOrderBy;
 $whereclause = $HTTP_SESSION_VARS['whereclause'];
}
// looking to see if search without search form and reusing session if set //
if ($get == 0 && $post == 0)
{
 if (!isset($HTTP_SESSION_VARS['fullOrderBy']))
 {
     $fullOrderBy = " ORDER BY people.last";
     session_register('fullOrderBy');
 }
 else
 {
     if($newID == 1)
     {
         $fullOrderBy = " ORDER BY people.last";
         $HTTP_SESSION_VARS['fullOrderBy'] = $fullOrderBy;
     }
     else
     {
         $fullOrderBy = $HTTP_SESSION_VARS['fullOrderBy'];
     }
 }

 if (!isset($HTTP_SESSION_VARS['whereclause']))
 {
     $whereclause = "WHERE ";
     if ( substr($whereclause,-5) == " AND ")
     {
         $whereclause = substr_replace($whereclause,"",-5);  // strip off ' AND'
     }
     else
     {
         $whereclause = substr_replace($whereclause,"",-6);  // strip off 'WHERE '
     }
     session_register('whereclause');
 }
 else
 {
     if($newID == 1)
     {
         $whereclause = "WHERE ";
         if ( substr($whereclause,-5) == " AND ")
         {
             $whereclause = substr_replace($whereclause,"",-5);  // strip off ' AND'
         }
         else
         {
             $whereclause = substr_replace($whereclause,"",-6);  // strip off 'WHERE '
         }
         $HTTP_SESSION_VARS['whereclause'] = $whereclause;
     }
     else
     {
         $whereclause = $HTTP_SESSION_VARS['whereclause'];
     }
 }
}

// counting records here //

$Link = mysql_pconnect ($Host, $User, $Password);
mysql_select_db($DBName, $Link);
$Count = "SELECT * FROM people " . $whereclause;
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

//  handling column totals here //
$IDQuery = "SELECT SUM(ID) as IDTotal FROM people " . $whereclause;
$IDRecordset = mysql_query($IDQuery, $Link);
while ($Row = mysql_fetch_assoc($IDRecordset))
{
     $IDTotal = $Row['IDTotal'];
}
mysql_free_result($IDRecordset);

//  attempting to concatenate //
$IDQuery = "SELECT CONCAT('ID',ID) as concat FROM people " . $whereclause;
$IDRecordset = mysql_query($IDQuery, $Link);
while ($Row = mysql_fetch_assoc($IDRecordset))
{
     $concat = $Row['concat'];
}
mysql_free_result($IDRecordset);

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
// Querying database here //

$Query = "SELECT *";
$Query = $Query . " FROM people " . $whereclause . $fullOrderBy . " LIMIT $start, $rows_per_page";
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

$Next = "people_search_results.php?screen=" . $next1;
$Previous = "people_search_results.php?screen=" . $previous1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

<title>people Search Results</title>
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
<div align="center"> 
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td>

<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="10" class="strip">&nbsp;</td>
          <td class="strip">ID<br>sort <a class='orderby' href='people_search_results.php?asapOrder=ID&screen=<?=$screen?>'>/\</a>
          <a class='orderby' href='people_search_results.php?asapOrder=ID&asapDesc=1&screen=<?=$screen?>'>\/</a></td>
          <td class="strip">last<br>sort <a class='orderby' href='people_search_results.php?asapOrder=last&screen=<?=$screen?>'>/\</a>
          <a class='orderby' href='people_search_results.php?asapOrder=last&asapDesc=1&screen=<?=$screen?>'>\/</a></td>
          <td class="strip">first<br>sort <a class='orderby' href='people_search_results.php?asapOrder=first&screen=<?=$screen?>'>/\</a>
          <a class='orderby' href='people_search_results.php?asapOrder=first&asapDesc=1&screen=<?=$screen?>'>\/</a></td>
          <td class="strip">email<br>sort <a class='orderby' href='people_search_results.php?asapOrder=email&screen=<?=$screen?>'>/\</a>
          <a class='orderby' href='people_search_results.php?asapOrder=email&asapDesc=1&screen=<?=$screen?>'>\/</a></td>
          <td class="strip">title<br>sort <a class='orderby' href='people_search_results.php?asapOrder=title&screen=<?=$screen?>'>/\</a>
          <a class='orderby' href='people_search_results.php?asapOrder=title&asapDesc=1&screen=<?=$screen?>'>\/</a></td>
          <td class="strip">company<br>sort <a class='orderby' href='people_search_results.php?asapOrder=company&screen=<?=$screen?>'>/\</a>
          <a class='orderby' href='people_search_results.php?asapOrder=company&asapDesc=1&screen=<?=$screen?>'>\/</a></td>
          <td class="strip">phone<br>sort <a class='orderby' href='people_search_results.php?asapOrder=phone&screen=<?=$screen?>'>/\</a>
          <a class='orderby' href='people_search_results.php?asapOrder=phone&asapDesc=1&screen=<?=$screen?>'>\/</a></td>
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
<td width="10" class="data1"><a class="datalink" href="people_detail.php?key=<? echo $Row['ID']; ?>&itemNumber=<? echo $newitemNumber; ?>">></a></td>
          <td class="data1"><a class="datalink" href="people_detail.php?key=<? echo $Row['ID']; ?>&itemNumber=<? echo $newitemNumber; ?>"><? echo $Row['ID']; ?></a></td>
          <td class="data1"><? echo $Row['last']; ?></td>
          <td class="data1"><? echo $Row['first']; ?></td>
          <td class="data1"><? echo $Row['email']; ?></td>
          <td class="data1"><? echo $Row['title']; ?></td>
          <td class="data1"><? echo $Row['company']; ?></td>
          <td class="data1"><? echo $Row['phone']; ?></td>
</tr>
<?
}
else
{
?>
<tr>
<td width="10" class="data2"><a class="datalink2" href="people_detail.php?key=<? echo $Row['ID']; ?>&itemNumber=<? echo $newitemNumber; ?>">></a></td>
          <td class="data2"><a class="datalink" href="people_detail.php?key=<? echo $Row['ID']; ?>&itemNumber=<? echo $newitemNumber; ?>"><? echo $Row['ID']; ?></a></td>
          <td class="data2"><? echo $Row['last']; ?></td>
          <td class="data2"><? echo $Row['first']; ?></td>
          <td class="data2"><? echo $Row['email']; ?></td>
          <td class="data2"><? echo $Row['title']; ?></td>
          <td class="data2"><? echo $Row['company']; ?></td>
          <td class="data2"><? echo $Row['phone']; ?></td>
</tr>
<?
  }
  $itemNumber = $itemNumber + 1;
  $lineIndex = $lineIndex + 1;
}
}
?>
<tr class="strip">
<td width="10">&nbsp;</td>
<td>ID number is <? echo $Row['concat']; ?></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>
    </td>
  </tr>
  <tr>
    <td class="strip">&nbsp;Records =&nbsp;<?=$total_records?></td>
  </tr>
</table>
<br><br>
<?
$previousurl = "people_search_results.php?" . SID . "&screen=" . ($screen - 1);
$nexturl = "people_search_results.php?" . SID . "&screen=" . ($screen + 1);
?>
<div align="center">
<table border="0" cellspacing="0" cellpadding="0">
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
                  <p><a class="button" href="<? echo $nexturl ?>">NEXT</a></p>
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
                  <p><a class="button" href="<? echo $nexturl ?>">NEXT</a></p>
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
  <b><span class='pagetext'>Sorry, no records in the database matched your search parameters. Click Back and try again. </span></b>
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
<a class='links' href='<?=$Previous?>'>10 PREVIOUS</a>
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
  <a class='links' href='<?=$URL?>'><?=$i?></a></b>
    </td>
    <?
    }
}
if ($Chapter < $Chapters)
{
?>
<td>
<a class='links' href='<?=$Next?>'>NEXT 10</a>
</td>
<?
}
?>
</tr>
</table>
<?
mysql_free_result($Recordset);
?>
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->
</div>
</td>
</tr>
</table>
</div>

</p>
</body>
</html>
