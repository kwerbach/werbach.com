<?
session_start();

include "functions.php";										// NEEDED TO CHECK VALID LOGIN
check_login($_SERVER['PHP_SELF'], $_SERVER["QUERY_STRING"]);	// NEEDED TO CHECK VALID LOGIN
?>
<html>
<head>

<title>people Search (people_search_form.php)</title>
<link rel="stylesheet" href="people_styles.css" type="text/css">

<script language="JavaScript">
<!--
function validateForm() 
{
var errors = '';

   if (errors) alert('The following error(s) occurred:\n' + errors);

  document.returnValue = (errors == '');
}

function callJavaScript(functionName) 
{
  return eval(functionName)
}
//-->
</script>

<script>
<!--
function sf(){document.search.last.focus();}
// -->
</script>

</head>

<body onload=sf() >
<?php
	require("header.php");
?>

<table class="header" width="100%" cellpadding="2" cellspacing="0">
  <tr>
     <td>
  <a class="headerlink" href="logout.php?root=people">
     HOME / LOGOUT</a>
  <a class="headerlink" href="people_search_form.php">
       SEARCH/EDIT</a>
  <a class="headerlink" href="people_add_form.php">
          ADD</a>
  <a class="headerlink" href="people_import.php">
          IMPORT</a>
     </td>
  </tr>
</table>
<br>
<div align="center"> 
<table width="650" cellpadding="0" cellspacing="0">
<tr> 
<td>
<form name="search" onSubmit="validateForm();return document.returnValue" method="POST" action="people_search_results.php">
<div align="center">
  <table width="100%" class="report" cellpadding="0" cellspacing="0">
    <tr> 
      <td class="strip">&nbsp;&nbsp;SEARCH RECORDS</td>
    </tr>
    <tr> 
      <td class="data3"> 
        <table cellspacing="0" cellpadding="0" border="0" width="100%">
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top" bgcolor="#FFFFCC">&nbsp;</td>
            <td width="48%" valign="top" bgcolor="#FFFFCC"><span class="fieldname2">last</span><br>
              <input class="fields" type="text" name="last" value="" size="40">
</td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"><span class="fieldname2">first</span><br>
              <input class="fields" type="text" name="first" value="" size="25">
</td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"><span class="fieldname2">email</span><br>
              <input class="fields" type="text" name="email" value="" size="40">
</td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top">date<br>
              <input class="fields" type="text" name="created_on" value="" size="25"></td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"><span class="fieldname2">ID</span><br>
              <input class="fields" type="text" name="ID" value="" size="7">
</td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"><span class="fieldname2">company</span><br>
              <input class="fields" type="text" name="company" value="" size="40"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td class="strip">&nbsp;</td>
    </tr>
<tr>
<td colspan="2">
<div align="center">
<input name='begin_search' type='hidden' id='begin_search' value='1'>
<input type="submit" name="submit" value="SEARCH">
</div>
</td>
</tr>
  </table>
</div>
</form>
</td>
</tr>
</table>
</div>
  <br>
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->

</p>
</body>
</html>
