<?

session_start();
require("people_connect.php");

$Link = mysql_pconnect ($Host, $User, $Password);
mysql_select_db($DBName, $Link);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

<title>people Add</title>
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
<script language="Javascript1.2"><!-- // load htmlarea
_editor_url = "htmlarea/";                     // URL to htmlarea files
var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
if (win_ie_ver >= 5.5) {
  document.write('<scr' + 'ipt src="' +_editor_url+ 'editor.js"');
  document.write(' language="Javascript1.2"></scr' + 'ipt>');  
} else { document.write('<scr'+'ipt>function editor_generate() { return false; }</scr'+'ipt>'); }
// --></script>

<script language="JavaScript">
<!--
function validateForm() 
{
var errors = '';

      if (document.add.ID.value == '' || isNaN(document.add.ID.value)) errors += 'Field ID is numeric.  Please enter a number in this field and try again.\n'
      if (document.add.last.value == '') document.add.last.value = " ";
      if (document.add.first.value == '') document.add.first.value = " ";
      if (document.add.email.value == '') document.add.email.value = " ";
      if (document.add.middle.value == '') document.add.middle.value = " ";
      if (document.add.nickname.value == '') document.add.nickname.value = " ";
      if (document.add.title.value == '') document.add.title.value = " ";
      if (document.add.company.value == '') document.add.company.value = " ";
      if (document.add.address1.value == '') document.add.address1.value = " ";
      if (document.add.address2.value == '') document.add.address2.value = " ";
      if (document.add.city.value == '') document.add.city.value = " ";
      if (document.add.province.value == '') document.add.province.value = " ";
      if (document.add.zip.value == '') document.add.zip.value = " ";
      if (document.add.country.value == '') document.add.country.value = " ";
      if (document.add.phone.value == '') document.add.phone.value = " ";
      if (document.add.fax.value == '') document.add.fax.value = " ";
      if (document.add.cellphone.value == '') document.add.cellphone.value = " ";
      if (document.add.home_phone.value == '') document.add.home_phone.value = " ";
      if (document.add.website.value == '') document.add.website.value = " ";
      if (document.add.blog.value == '') document.add.blog.value = " ";
      if (document.add.rss.value == '') document.add.rss.value = " ";
      if (document.add.asst_name.value == '') document.add.asst_name.value = " ";
      if (document.add.asst_phone.value == '') document.add.asst_phone.value = " ";
      if (document.add.out_out.value == '' || isNaN(document.add.out_out.value)) errors += 'Field out_out is numeric.  Please enter a number in this field and try again.\n'
      if (document.add.source.value == '') document.add.source.value = " ";
      if (document.add.personal_connection.value == '' || isNaN(document.add.personal_connection.value)) errors += 'Field personal_connection is numeric.  Please enter a number in this field and try again.\n'
      if (document.add.category.value == '') document.add.category.value = " ";
      if (document.add.sn_attendee.value == '' || isNaN(document.add.sn_attendee.value)) errors += 'Field sn_attendee is numeric.  Please enter a number in this field and try again.\n'
      if (document.add.sn_speaker.value == '' || isNaN(document.add.sn_speaker.value)) errors += 'Field sn_speaker is numeric.  Please enter a number in this field and try again.\n'
      if (document.add.snr_subscriber.value == '' || isNaN(document.add.snr_subscriber.value)) errors += 'Field snr_subscriber is numeric.  Please enter a number in this field and try again.\n'
      if (document.add.werblist_subscriber.value == '' || isNaN(document.add.werblist_subscriber.value)) errors += 'Field werblist_subscriber is numeric.  Please enter a number in this field and try again.\n'
      if (document.add.comments.value == '') document.add.comments.value = " ";
      if (document.add.created_on.value == '') errors += 'Field created_on is a date.  Please enter a date in this field and try again.\n'

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
<p>
<?
require("people_header.inc");
?>
<div align="center"> 
<table width="650" cellpadding="0" cellspacing="0">
<tr> 
<td>
<form onSubmit="validateForm();return document.returnValue" name="add" method="post" action="people_add.php">
<div align="center"> 
  <table width="100%" class="report" cellpadding="0" cellspacing="0">
    <tr> 
      <td class="strip">&nbsp;&nbsp;ADD NEW RECORD</td>
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
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top">&nbsp;
<!--            <span class="fieldname2">ID</span><br>
<input class="fields" type="text" name="ID" size="40">
-->
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">last</span><br>
<input class="fields" type="text" name="last" size="40">
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">first</span><br>
<input class="fields" type="text" name="first" size="40">
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">email</span><br>
<input class="fields" type="text" name="email" size="40">
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">middle</span><br>
<input class="fields" type="text" name="middle" size="40">
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">nickname</span><br>
<input class="fields" type="text" name="nickname" size="40">
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">title</span><br>
<input class="fields" type="text" name="title" size="40">
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">company</span><br>
<input class="fields" type="text" name="company" size="40">
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">address1</span><br>
<input class="fields" type="text" name="address1" size="40">
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">address2</span><br>
<input class="fields" type="text" name="address2" size="40">
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">city</span><br>
<input class="fields" type="text" name="city" size="40">
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">state</span><br>
<input class="fields" type="text" name="province" size="40">
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">zip</span><br>
<input class="fields" type="text" name="zip" size="40">
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">country</span><br>
<input class="fields" type="text" name="country" size="40">
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">phone</span><br>
<input class="fields" type="text" name="phone" size="40">
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">fax</span><br>
<input class="fields" type="text" name="fax" size="40">
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">cellphone</span><br>
<input class="fields" type="text" name="cellphone" size="40">
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">home phone</span><br>
<input class="fields" type="text" name="home_phone" size="40">
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">website</span><br>
<input class="fields" type="text" name="website" size="40">
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">blog</span><br>
<input class="fields" type="text" name="blog" size="40">
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">rss</span><br>
<input class="fields" type="text" name="rss" size="40">
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">assistant name</span><br>
<input class="fields" type="text" name="asst_name" size="40">
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">assistant phone</span><br>
<input class="fields" type="text" name="asst_phone" size="40">
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">opt-out?</span><br>
<input type="checkbox" name="out_out" value="1">
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">source</span><br>
              <select name="source">
<?
$Query2 = "Select DISTINCT sources,sources from source";
$Recordset2 = mysql_query($Query2, $Link);
?>
                <option value="" selected>Choose</option>
<?
while ($Row = mysql_fetch_assoc ($Recordset2))
{
?>
                <option value="<? echo $Row['sources']; ?>"><? echo $Row['sources']; ?></option>
<?
}
mysql_free_result($Recordset2);
?>
</select>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">personal connection?</span><br>
<input type="checkbox" name="personal_connection" value="1">
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">category</span><br>
              <select name="category">
<?
$Query2 = "Select DISTINCT categories,categories from category";
$Recordset2 = mysql_query($Query2, $Link);
?>
                <option value="" selected>Choose</option>
<?
while ($Row = mysql_fetch_assoc ($Recordset2))
{
?>
                <option value="<? echo $Row['categories']; ?>"><? echo $Row['categories']; ?></option>
<?
}
mysql_free_result($Recordset2);
?>
</select>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">SN attendee?</span><br>
<input type="checkbox" name="sn_attendee" value="1">
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">SN speaker?</span><br>
<input type="checkbox" name="sn_speaker" value="1">
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">SNR subscriber?</span><br>
<input type="checkbox" name="snr_subscriber" value="1">
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            <span class="fieldname2">werblist subscriber?</span><br>
<input type="checkbox" name="werblist_subscriber" value="1">
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
            <td width="98%"colspan="3" valign="top"> 
            <span class="fieldname2">comments</span><br>
<textarea class="fields" name="comments" cols="60" rows="8"></textarea>
<script language="javascript1.2">
editor_generate('comments');
</script>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
		  <!--
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td width="48%" valign="top"> 
            	<span class="fieldname2">created on</span><br>
				<span class='data3'>(mm/dd/yyyy)</span><br>
				<input class="fields" type="text" name="created_on" size="40">
            </td>
		  </tr>-->
        </table>
      </td>
    </tr>
	
    <tr> 
      <td class="strip">&nbsp;</td>
    </tr>
<tr>
<td colspan="2">
<div align="center">
<input type="submit" name="add" value="Add New Record">
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
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->

</p>
</body>
</html>
