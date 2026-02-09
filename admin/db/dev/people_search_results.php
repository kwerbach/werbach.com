<?
session_start();

include ("functions.php");
# Redirect must be a full URL or it won't work
$redirect = "http://werbach.com/db/login_form.php";
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
$THISuniqueID = "people1512200315619";
$lineIndex = 0;
$linkCount = 0;
$itemNumber = 0;
$get = 0;
$post = 0;
$newID = 0;
$rows_per_page = 50;
$pages = 1;
$screen = 1;
$preOrder = " ORDER BY people.";
// looking for uniqueID information here //
if (!isset($HTTP_SESSION_VARS['uniqueID']))
{
$uniqueID = "people1512200315619";
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

//  looking for request of screen number (alias Page Number) //
if (!isset($HTTP_GET_VARS['screen']))
{
$screen = 1;
}
else
{
$screen = $HTTP_GET_VARS['screen'];
}

//****************************************************************************

if (isset($HTTP_POST_VARS['export']))
{
	$Link = mysql_pconnect ($Host, $User, $Password);
	mysql_select_db($DBName, $Link);
	$fields = get_fields();
	$whereclause = $_SESSION['whereclause'];

	$result = $HTTP_POST_VARS['export'] == 'Export All' ? mysql_query("SELECT $fields from people $whereclause ORDER BY last")
														: mysql_query("SELECT last, first, email from people $whereclause ORDER BY last");

	if (mysql_num_rows($result) != 0)
	{
		$export_table = array();

		// build 2D array
		for  ($i = 0; $row = mysql_fetch_row($result); $i++)
			$export_table[$i] = $row;

		mysql_close($Link);
		output_file($filename, $export_table);
	}
}


//****************************************************************************


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

if ($total_records == 1)
{
	$Row = mysql_fetch_assoc($Recordset);

	header("Location: people_edit_detail.php?key={$Row['ID']}&itemNumber=0");
	exit;
}

?>

<html>
<head>

<title>people Search Results</title>
<link rel="stylesheet" href="people_styles.css" type="text/css">

<script language="JavaScript">
function Trim(TRIM_VALUE){
	if(TRIM_VALUE.length < 1){
		return"";
	}
	TRIM_VALUE = RTrim(TRIM_VALUE);
	TRIM_VALUE = LTrim(TRIM_VALUE);
	if(TRIM_VALUE==""){
	return "";
	}
	else{
	return TRIM_VALUE;
	}
} //End Function

function RTrim(VALUE){
	var w_space = String.fromCharCode(32);
	var v_length = VALUE.length;
	var strTemp = "";
	if(v_length < 0){
	return"";
	}
	var iTemp = v_length -1;

	while(iTemp > -1){
		if(VALUE.charAt(iTemp) != w_space){
			strTemp = VALUE.substring(0,iTemp +1);
			break;
		}
		iTemp = iTemp-1;

	} //End While
	return strTemp;
} //End Function

function LTrim(VALUE){
	var w_space = String.fromCharCode(32);
	if(v_length < 1){
		return"";
	}
	var v_length = VALUE.length;
	var strTemp = "";

	var iTemp = 0;

	while(iTemp < v_length){
		if(VALUE.charAt(iTemp) != w_space){
			strTemp = VALUE.substring(iTemp,v_length);
			break;
		}
		iTemp = iTemp + 1;
	} //End While
	return strTemp;
} //End Function

function validate(aTextField){
	aTextField.replace(/^\s*/, "" );
	aTextField.replace(/\s*$/, "" );

	if(Trim(aTextField) == 0){
		alert("You must provide a filename.");
		return false;
	}
	return true;
}
</script>

</head>

<body>

<?php
require("header.php");
require("people_header.inc");
?>
<div align="center">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td>

<?

print "<form name='form' action='people_search_results.php?screen=$screen' method='post' onsubmit=\"return validate(document.form.filename.value);\" >";
?>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="10" class="strip">&nbsp;</td>

          <td class="strip">ID<br>sort <a class='orderby' href='people_search_results.php?asapOrder=user_id&screen=<?=$screen?>'>&uarr;</a>
		  <a class='orderby' href='people_search_results.php?asapOrder=user_id&asapDesc=1&screen=<?=$screen?>'>&darr;</a></td>

<!-- ORDER BY ID
          <td class="strip">ID<br>sort <a class='orderby' href='people_search_results.php?asapOrder=ID&screen=<?=$screen?>'>/\</a>
		  <a class='orderby' href='people_search_results.php?asapOrder=ID&asapDesc=1&screen=<?=$screen?>'>\/</a></td>
-->

          <td class="strip">last<br>sort <a class='orderby' href='people_search_results.php?asapOrder=last&screen=<?=$screen?>'>&uarr;</a>
          <a class='orderby' href='people_search_results.php?asapOrder=last&asapDesc=1&screen=<?=$screen?>'>&darr;</a></td>
          <td class="strip">first<br>sort <a class='orderby' href='people_search_results.php?asapOrder=first&screen=<?=$screen?>'>&uarr;</a>
          <a class='orderby' href='people_search_results.php?asapOrder=first&asapDesc=1&screen=<?=$screen?>'>&darr;</a></td>
          <td class="strip">email<br>sort <a class='orderby' href='people_search_results.php?asapOrder=email&screen=<?=$screen?>'>&uarr;</a>
          <a class='orderby' href='people_search_results.php?asapOrder=email&asapDesc=1&screen=<?=$screen?>'>&darr;</a></td>
          <td class="strip">title<br>sort <a class='orderby' href='people_search_results.php?asapOrder=title&screen=<?=$screen?>'>&uarr;</a>
          <a class='orderby' href='people_search_results.php?asapOrder=title&asapDesc=1&screen=<?=$screen?>'>&darr;</a></td>
          <td class="strip">company<br>sort <a class='orderby' href='people_search_results.php?asapOrder=company&screen=<?=$screen?>'>&uarr;</a>
          <a class='orderby' href='people_search_results.php?asapOrder=company&asapDesc=1&screen=<?=$screen?>'>&darr;</a></td>
          <td class="strip">phone<br>sort <a class='orderby' href='people_search_results.php?asapOrder=phone&screen=<?=$screen?>'>&uarr;</a>
          <a class='orderby' href='people_search_results.php?asapOrder=phone&asapDesc=1&screen=<?=$screen?>'>&darr;</a></td>
</tr>
<?
for ($i = 0; $i < $rows; $i++)
{
  while ($Row = mysql_fetch_assoc($Recordset))
  {
      $newitemNumber = (($screen - 1) * $rows_per_page) + $itemNumber;

	  $rowclass = $lineIndex % 2 == 0 ? "data1" : "data2";

	  $checked = mysql_num_rows(mysql_query("select people.id from people, export where filename='$filename' and export.people_id = ".$Row['ID'])) > 0 ? "checked='checked'" : "";


	  print "
	   <tr>
		 <td width='10' class='$rowclass'>&nbsp;</td>
          <td class='$rowclass'><a class='datalink' href='people_edit_detail.php?key={$Row['ID']}&itemNumber=$newitemNumber'>{$Row['user_id']}</a></td>
          <td class='$rowclass'>{$Row['last']}</td>
          <td class='$rowclass'>{$Row['first']}</td>
          <td class='$rowclass'>{$Row['email']}</td>
          <td class='$rowclass'>{$Row['title']}</td>
          <td class='$rowclass'>{$Row['company']}</td>
          <td class='$rowclass'>{$Row['phone']}</td>
	  </tr>";


  	  $itemNumber = $itemNumber + 1;
	  $lineIndex = $lineIndex + 1;
  }
}

$rowclass = $rowclass == "data1" ? "data2" : "data1";
$filename = $HTTP_SESSION_VARS['filename'];

print "
<tr>
	<td class='$rowclass' colspan='9'><b>Filename:</b><br/><input type='text' name='filename' value='$filename'/><input class='button' type='submit' name='export' value='Export Small'/><input class='button' type='submit' name='export' value='Export All'/></td>
</tr>";
?>
</table>
</form>
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
