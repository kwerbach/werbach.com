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
 }
}
else
{
header("Location:$redirect");  // Send him/her to the login page!
}
require("people_connect.php");
$Link = mysql_pconnect ($Host, $User, $Password);
mysql_select_db($DBName, $Link); 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

<title>people Search</title>
<link rel="stylesheet" href="people_styles.css" type="text/css">
<script language="javascript">
<!--
var bName = navigator.appName;
var bVer = parseFloat(navigator.appVersion);
var browser;

if (bName == "Netscape")
 browser = "Netscape Navigator"
else
 browser = bName;

  // return 1 for Internet Explorer
  if (browser == "Netscape Navigator")
document.write("<!-- This is Netscape //-->")

  // return 2 for Navigator
  else
document.write("<style type=\"text/css\">")
document.write("<!--")
document.write(".fields{")
document.write("border : #000000;")
document.write("border-style: solid;")
document.write("border-width: 1px;")
document.write("}")
document.write("-->")
document.write("</style>")

  // return 0 for other browsers

//-->

</script>
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

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../Werbach/Web%20Pages/asap%20db/people_styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<p class="title">Supernova Group Database</p>

<?
require("people_header.inc");
?>
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
            <td width="48%" valign="top">&nbsp;</td>
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
