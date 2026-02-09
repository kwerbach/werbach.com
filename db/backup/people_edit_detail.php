<?
session_start();

$itemNumber = $HTTP_GET_VARS['itemNumber'];
$key = $HTTP_GET_VARS['key'];
$fullOrderBy = $HTTP_SESSION_VARS['fullOrderBy'];
$whereclause = $HTTP_SESSION_VARS['whereclause'];
$total_results = $HTTP_SESSION_VARS['total_results'];
require("people_connect.php");
$Link = mysql_pconnect($Host, $User, $Password);
mysql_select_db($DBName, $Link);
if ($itemNumber == 0)
{
$screen = 1;
}
else
{
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

if (!$itemNumber)
	$Query = "SELECT * from people where ID=$key";
else
{
	$Query = "SELECT *";
	$Query = $Query . ", date_format(created_on, '%m/%d/%Y') as created_on";
	$Query = $Query . " FROM people " . $whereclause . $fullOrderBy . " LIMIT " . $itemNumber . ", 1";
}

$Recordset = mysql_query($Query, $Link);
while ($Row = mysql_fetch_assoc ($Recordset)) 
{
$key = $Row['ID'];
$ID = $Row['ID'];
$user_id = $Row['user_id'];
$last = $Row['last'];
$first = $Row['first'];
$email = $Row['email'];
$middle = $Row['middle'];
$nickname = $Row['nickname'];
$title = $Row['title'];
$company = $Row['company'];
$address1 = $Row['address1'];
$address2 = $Row['address2'];
$city = $Row['city'];
$province = $Row['province'];
$zip = $Row['zip'];
$country = $Row['country'];
$phone = $Row['phone'];
$fax = $Row['fax'];
$cellphone = $Row['cellphone'];
$home_phone = $Row['home_phone'];
$website = $Row['website'];
$blog = $Row['blog'];
$rss = $Row['rss'];
$asst_name = $Row['asst_name'];
$asst_phone = $Row['asst_phone'];
$out_out = $Row['out_out'];
$source = $Row['source'];
$personal_connection = $Row['personal_connection'];
$category = $Row['category'];
$sn_attendee = $Row['sn_attendee'];
$sn_speaker = $Row['sn_speaker'];
$snr_subscriber = $Row['snr_subscriber'];
$werblist_subscriber = $Row['werblist_subscriber'];
$comments = $Row['comments'];
$created_on = $Row['created_on'];
}
$URL = "people_edit_update.php?key=$key&itemNumber=$itemNumber&mode=$mode";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

<title>people Edit Detail</title>
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
      if (document.edit.ID.value == '' || isNaN(document.edit.ID.value)) errors += 'Field ID is numeric.  Please enter a number in this field and try again.\n'
      if (document.edit.last.value == '') document.edit.last.value = " ";
      if (document.edit.first.value == '') document.edit.first.value = " ";
      if (document.edit.email.value == '') document.edit.email.value = " ";
      if (document.edit.middle.value == '') document.edit.middle.value = " ";
      if (document.edit.nickname.value == '') document.edit.nickname.value = " ";
      if (document.edit.title.value == '') document.edit.title.value = " ";
      if (document.edit.company.value == '') document.edit.company.value = " ";
      if (document.edit.address1.value == '') document.edit.address1.value = " ";
      if (document.edit.address2.value == '') document.edit.address2.value = " ";
      if (document.edit.city.value == '') document.edit.city.value = " ";
      if (document.edit.province.value == '') document.edit.province.value = " ";
      if (document.edit.zip.value == '') document.edit.zip.value = " ";
      if (document.edit.country.value == '') document.edit.country.value = " ";
      if (document.edit.phone.value == '') document.edit.phone.value = " ";
      if (document.edit.fax.value == '') document.edit.fax.value = " ";
      if (document.edit.cellphone.value == '') document.edit.cellphone.value = " ";
      if (document.edit.home_phone.value == '') document.edit.home_phone.value = " ";
      if (document.edit.website.value == '') document.edit.website.value = " ";
      if (document.edit.blog.value == '') document.edit.blog.value = " ";
      if (document.edit.rss.value == '') document.edit.rss.value = " ";
      if (document.edit.asst_name.value == '') document.edit.asst_name.value = " ";
      if (document.edit.asst_phone.value == '') document.edit.asst_phone.value = " ";
      if (document.edit.out_out.value == '' || isNaN(document.edit.out_out.value)) errors += 'Field out_out is numeric.  Please enter a number in this field and try again.\n'
      if (document.edit.source.value == '') document.edit.source.value = " ";
      if (document.edit.personal_connection.value == '' || isNaN(document.edit.personal_connection.value)) errors += 'Field personal_connection is numeric.  Please enter a number in this field and try again.\n'
      if (document.edit.category.value == '') document.edit.category.value = " ";
      if (document.edit.sn_attendee.value == '' || isNaN(document.edit.sn_attendee.value)) errors += 'Field sn_attendee is numeric.  Please enter a number in this field and try again.\n'
      if (document.edit.sn_speaker.value == '' || isNaN(document.edit.sn_speaker.value)) errors += 'Field sn_speaker is numeric.  Please enter a number in this field and try again.\n'
      if (document.edit.snr_subscriber.value == '' || isNaN(document.edit.snr_subscriber.value)) errors += 'Field snr_subscriber is numeric.  Please enter a number in this field and try again.\n'
      if (document.edit.werblist_subscriber.value == '' || isNaN(document.edit.werblist_subscriber.value)) errors += 'Field werblist_subscriber is numeric.  Please enter a number in this field and try again.\n'
      if (document.edit.comments.value == '') document.edit.comments.value = " ";
      if (document.edit.created_on.value == '') errors += 'Field created_on is a date.  Please enter a date in this field and try again.\n'
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
<link href="people_styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<p class="title">Supernova Group Database</p>
<p>
<?
require("people_header.inc");
?>
<div align="center">
<form onSubmit="validateForm();return document.returnValue" method="post" action="<? echo $URL; ?>" name="edit">
  <table width="98%" border="1" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF" class="data2">
    <tr class="strip"><td class="strip">&nbsp;EDIT RECORD</td>
	<td><div align="center">
<input type="submit" name="add" value="Update Record">
</div></td>

	<td class="button">
              <div align="center">
                <p><a class="button" href="javascript:if (confirm(&quot;Delete this record?&quot;) == true) location.href=&quot;people_delete.php?itemNumber=<?=$itemNumber?>&key=<?=$key?>&quot;">Delete
                    This Record</a></p>
              </div></td>
			  <td>&nbsp;</td>
			  <td><div align="Center"><a class="button" href='<?=$backToSearch?>'>Back to search results</a></div></td>
	</tr>
	<tr>
      <td colspan="3" bgcolor="#FFFFFF">ID# &nbsp;
        <!--<input class="fields" type="text" name="ID" value="<?=$ID?>" size="40">-->
        <b>
        <?=$user_id?>
      </b> </td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="29%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="27%" bgcolor="#FFFFFF">Created:
          <?=$created_on?>
      </td>
    </tr>
    <tr>
      <td width="30%" colspan="2" bgcolor="#FFFFCC">First:<br><font size="+1"><strong>
        
              <input class="fields" type="text" name="first" value="<?=$first?>" size="40">
</strong></font></td>
      <td width="10%" bgcolor="#FFFFCC">Middle:<br><font size="+1"><strong>
        <input class="fields" type="text" name="middle" value="<?=$middle?>" size="20">
      </strong></font></td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="29%" bgcolor="#FFFFCC"><font size="+1"><strong>
        <input class="fields" type="text" name="email" value="<?=$email?>" size="40">
</strong></font></td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFCC">Last:<br><font size="+1"><strong>
        <input class="fields" type="text" name="last" value="<?=$last?>" size="40">
</strong></font></td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="29%" bgcolor="#FFFFFF">Website:
          <input class="fields" type="text" name="website" value="<?=$website?>" size="40">
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="27%" bgcolor="#FFFFFF">SN attendee?
          <?
if ( $sn_attendee == 1 )
{
?>
          <input type="checkbox" name="sn_attendee" value="1" checked>
          <?
}
else
{
?>
          <input type="checkbox" name="sn_attendee" value="1">
          <?
}
?>
</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Nickname:
          <input class="fields" type="text" name="nickname" value="<?=$nickname?>" size="40">
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="29%" bgcolor="#FFFFFF">Blog:
          <input class="fields" type="text" name="blog" value="<?=$blog?>" size="40"></td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="27%" bgcolor="#FFFFFF">SN speaker?
          <?
if ( $sn_speaker == 1 )
{
?>
          <input type="checkbox" name="sn_speaker" value="1" checked>
          <?
}
else
{
?>
          <input type="checkbox" name="sn_speaker" value="1">
          <?
}
?>
</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Title:
          <input class="fields" type="text" name="title" value="<?=$title?>" size="60">
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="29%" bgcolor="#FFFFFF">RSS:
          <input class="fields" type="text" name="rss" value="<?=$rss?>" size="40"></td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="27%" bgcolor="#FFFFFF">SNR subscriber?
          <?
if ( $snr_subscriber == 1 )
{
?>
          <input type="checkbox" name="snr_subscriber" value="1" checked>
          <?
}
else
{
?>
          <input type="checkbox" name="snr_subscriber" value="1">
          <?
}
?>
</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Company:
          <input class="fields" type="text" name="company" value="<?=$company?>" size="40">
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="29%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="27%" bgcolor="#FFFFFF">Werblist subscriber?
          <?
if ( $werblist_subscriber == 1 )
{
?>
          <input type="checkbox" name="werblist_subscriber" value="1" checked>
          <?
}
else
{
?>
          <input type="checkbox" name="werblist_subscriber" value="1">
          <?
}
?>
</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Address1:
          <input class="fields" type="text" name="address1" value="<?=$address1?>" size="60">
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="29%" bgcolor="#FFFFFF">Asst. Name:
          <input class="fields" type="text" name="asst_name" value="<?=$asst_name?>" size="40"></td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Address2:
      <input class="fields" type="text" name="address2" value="<?=$address2?>" size="60"></td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="29%" bgcolor="#FFFFFF">Asst. Phone:
          <input class="fields" type="text" name="asst_phone" value="<?=$asst_phone?>" size="40">
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td width="28%" bgcolor="#FFFFFF">City:
          <input class="fields" type="text" name="city" value="<?=$city?>" size="40">
</td>
      <td width="5%" bgcolor="#FFFFFF">State:
          <input class="fields" type="text" name="province" value="<?=$province?>" size="15">
</td>
      <td bgcolor="#FFFFFF">Zip:
          <input class="fields" type="text" name="zip" value="<?=$zip?>" size="10">
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="29%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Country:
          <input class="fields" type="text" name="country" value="<?=$country?>" size="40">
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="29%" bgcolor="#CCCCCC">Opt out?
          <?
if ( $out_out == 1 )
{
?>
          <input type="checkbox" name="out_out" value="1" checked>
          <?
}
else
{
?>
          <input type="checkbox" name="out_out" value="1">
          <?
}
?>
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Phone:
        <input class="fields" type="text" name="phone" value="<?=$phone?>" size="25">
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="29%" bgcolor="#CCCCCC">Source:
          <select name="source">
            <?
if ($source <> '' && $source <> ' ')
{
     $Query2 = "Select * from source WHERE sources LIKE '" . $source . "'";
     $Recordset2 = mysql_query($Query2, $Link);
     while ($Row = mysql_fetch_assoc ($Recordset2))
     {
         $sources_selected = $Row['sources'];
     }
     mysql_free_result($Recordset2);
}
else
{
     $sources_selected = 'unknown';
}
$Query3 = "Select DISTINCT sources,sources from source";
$Recordset3 = mysql_query($Query3, $Link);
?>
            <option value="<?=$source?>" selected>
            <?=$sources_selected?>
            </option>
            <?
while ($Row = mysql_fetch_assoc ($Recordset3))
{
?>
            <option value="<? echo $Row['sources']; ?>"><? echo $Row['sources']; ?></option>
            <?
}
mysql_free_result($Recordset3);
?>
          </select>
      </td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Fax:&nbsp;
        <input class="fields" type="text" name="fax" value="<?=$fax?>" size="25">
      </td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="29%" bgcolor="#CCCCCC">Personal connection?
          <?
if ( $personal_connection == 1 )
{
?>
          <input type="checkbox" name="personal_connection" value="1" checked>
          <?
}
else
{
?>
          <input type="checkbox" name="personal_connection" value="1">
          <?
}
?>
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Cell:
          <input class="fields" type="text" name="cellphone" value="<?=$cellphone?>" size="25">
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="29%" bgcolor="#CCCCCC">Category:
          <select name="category">
            <?
if ($category <> '' && $category <> ' ')
{
     $Query2 = "Select * from category WHERE categories LIKE '" . $category . "'";
     $Recordset2 = mysql_query($Query2, $Link);
     while ($Row = mysql_fetch_assoc ($Recordset2))
     {
         $categories_selected = $Row['categories'];
     }
     mysql_free_result($Recordset2);
}
else
{
     $categories_selected = 'unknown';
}
$Query3 = "Select DISTINCT categories,categories from category";
$Recordset3 = mysql_query($Query3, $Link);
?>
            <option value="<?=$category?>" selected>
            <?=$categories_selected?>
            </option>
            <?
while ($Row = mysql_fetch_assoc ($Recordset3))
{
?>
            <option value="<? echo $Row['categories']; ?>"><? echo $Row['categories']; ?></option>
            <?
}
mysql_free_result($Recordset3);
?>
          </select></td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Home:
          <input class="fields" type="text" name="home_phone" value="<?=$home_phone?>" size="25"></td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="29%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="29%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td height="50" colspan="5" bgcolor="#FFFFFF">Comments<br>
          <textarea class="fields" name="comments" cols="60" rows="8"><?=$comments?>
          </textarea>
          <script language="javascript1.2">
editor_generate('comments');
          </script>
</td>
    </tr>
	<tr> 
      <td class="strip" colspan="7">&nbsp;</td>
    </tr>
<tr>
<td colspan="7">
<div align="center">
<input type="submit" name="add" value="Update Record">
</div>
</td>
</tr>
  </table> 
  </form>
<table width="650" cellpadding="0" cellspacing="0">
<tr>
<td>
<div align="center">  </div>

  <?
$previousurl = "people_edit_detail.php?" . SID . "&itemNumber=" . ($itemNumber - 1);
$nexturl = "people_edit_detail.php?" . SID . "&itemNumber=" . ($itemNumber + 1);
?>
<table border="0" cellspacing="0" cellpadding="0" class="detail" align="center">
  <tr> 
    <td> 
      <div align="center"> 
        <?
if ($itemNumber > 0 && $itemNumber <= $total_results )
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
else
{
?>
        <table width="150" border="0">
          <tr> 
            <td> </td>
          </tr>
        </table>
        <?
}
?>
      </div>
    </td>
    <td> 
      <div align="center">        
        <table width="150" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#CCCCCC">
          <tr>
            <td class="button">
              <div align="center">
                <p><a class="button" href="javascript:if (confirm(&quot;Delete this record?&quot;) == true) location.href=&quot;people_delete.php?itemNumber=<?=$itemNumber?>&key=<?=$key?>&quot;">Delete
                    This Record</a></p>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </td>
    <td> 
      <div align="center"> 
        <?
if ($itemNumber >= 0 && $itemNumber < $total_results)
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
else
{
?>
        <table width="150" border="0">
          <tr> 
            <td> </td>
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
<div align="center">
<p><a class='links' href='<?=$backToSearch?>'>Back to search results</a>
</div>
</td>
</tr>
</table>
</div>
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->

</p>
</body>
</html>
