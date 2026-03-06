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
$itemNumber = $HTTP_GET_VARS['itemNumber'];
if (isset($HTTP_GET_VARS['key']))
{
 $key = $HTTP_GET_VARS['key'];
}
$fullOrderBy = $HTTP_SESSION_VARS['fullOrderBy'];
$whereclause = $HTTP_SESSION_VARS['whereclause'];
$total_results = $HTTP_SESSION_VARS['total_results'];
if (isset($HTTP_SESSION_VARS['total_changed']))
{
 $total_changed = $HTTP_SESSION_VARS['total_changed'];
}
else
{
 $total_changed = 0;
}
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
if (isset($HTTP_GET_VARS['edit']))
{
$Query = "SELECT *";
$Query = $Query . ", date_format(created_on, '%m/%d/%Y') as created_on";
$Query = $Query . " FROM people WHERE ID = " . $key;
$Result = mysql_query($Query, $Link);
$Row = mysql_fetch_assoc($Result);
$ID = $Row['ID'];
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
if ($out_out == 1)
 {
 $out_out = 'yes';
 }
else
 {
 $out_out = 'no';
 }
$source = $Row['source'];
$personal_connection = $Row['personal_connection'];
if ($personal_connection == 1)
 {
 $personal_connection = 'yes';
 }
else
 {
 $personal_connection = 'no';
 }
$category = $Row['category'];
$sn_attendee = $Row['sn_attendee'];
if ($sn_attendee == 1)
 {
 $sn_attendee = 'yes';
 }
else
 {
 $sn_attendee = 'no';
 }
$sn_speaker = $Row['sn_speaker'];
if ($sn_speaker == 1)
 {
 $sn_speaker = 'yes';
 }
else
 {
 $sn_speaker = 'no';
 }
$snr_subscriber = $Row['snr_subscriber'];
if ($snr_subscriber == 1)
 {
 $snr_subscriber = 'yes';
 }
else
 {
 $snr_subscriber = 'no';
 }
$werblist_subscriber = $Row['werblist_subscriber'];
if ($werblist_subscriber == 1)
 {
 $werblist_subscriber = 'yes';
 }
else
 {
 $werblist_subscriber = 'no';
 }
$comments = $Row['comments'];
$created_on = $Row['created_on'];
}
else
{
$Query = "SELECT *";
$Query = $Query . ", date_format(created_on, '%m/%d/%Y') as created_on";
$Query = $Query . " FROM people " . $whereclause . $fullOrderBy . " LIMIT " . $itemNumber . ", 1";
$Result = mysql_query($Query, $Link);
$Row = mysql_fetch_assoc($Result);
$key = $Row['ID'];
$ID = $Row['ID'];
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
if ($out_out == 1)
 {
 $out_out = 'yes';
 }
else
 {
 $out_out = 'no';
 }
$source = $Row['source'];
$personal_connection = $Row['personal_connection'];
if ($personal_connection == 1)
 {
 $personal_connection = 'yes';
 }
else
 {
 $personal_connection = 'no';
 }
$category = $Row['category'];
$sn_attendee = $Row['sn_attendee'];
if ($sn_attendee == 1)
 {
 $sn_attendee = 'yes';
 }
else
 {
 $sn_attendee = 'no';
 }
$sn_speaker = $Row['sn_speaker'];
if ($sn_speaker == 1)
 {
 $sn_speaker = 'yes';
 }
else
 {
 $sn_speaker = 'no';
 }
$snr_subscriber = $Row['snr_subscriber'];
if ($snr_subscriber == 1)
 {
 $snr_subscriber = 'yes';
 }
else
 {
 $snr_subscriber = 'no';
 }
$werblist_subscriber = $Row['werblist_subscriber'];
if ($werblist_subscriber == 1)
 {
 $werblist_subscriber = 'yes';
 }
else
 {
 $werblist_subscriber = 'no';
 }
$comments = $Row['comments'];
$created_on = $Row['created_on'];
}
$URL = "people_edit_detail.php?key=" . $key . "&itemNumber=" . $itemNumber;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

<title>people Detail</title>
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
<table width="650" cellpadding="0" cellspacing="0">
<tr>
<td>
<div align="center"> 
  <table width="100%" class="report" border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td class="strip" colspan="2">&nbsp;&nbsp;DETAIL PAGE</td>
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
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">ID</span><br>
            <?=$ID?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">last</span><br>
            <?=$last?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">first</span><br>
            <?=$first?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">email</span><br>
<?
if ($email <> "" && $email <> " ")
{
?>
            <a class="hyperlink"  href="mailto:<?=$email?>"><?=$email?></a>
<?
}
else
{
?>
            No link available
<?
}
?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">middle</span><br>
            <?=$middle?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">nickname</span><br>
            <?=$nickname?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">title</span><br>
            <?=$title?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">company</span><br>
            <?=$company?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">address1</span><br>
            <?=$address1?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">address2</span><br>
            <?=$address2?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">city</span><br>
            <?=$city?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">state</span><br>
            <?=$province?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">zip</span><br>
            <?=$zip?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">country</span><br>
            <?=$country?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">phone</span><br>
            <?=$phone?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">fax</span><br>
            <?=$fax?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">cellphone</span><br>
            <?=$cellphone?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">home phone</span><br>
            <?=$home_phone?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">website</span><br>
            <?=$website?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">blog</span><br>
            <?=$blog?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">rss</span><br>
            <?=$rss?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">assistant name</span><br>
            <?=$asst_name?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">assistant phone</span><br>
            <?=$asst_phone?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">opt-out?</span><br>
            <?=$out_out?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">source</span><br>
            <?=$source?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">personal connection?</span><br>
            <?=$personal_connection?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">category</span><br>
            <?=$category?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">SN attendee?</span><br>
            <?=$sn_attendee?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">SN speaker?</span><br>
            <?=$sn_speaker?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">SNR subscriber?</span><br>
            <?=$snr_subscriber?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">werblist subscriber?</span><br>
            <?=$werblist_subscriber?>
          </td>
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">comments</span><br>
            <?=$comments?>
          </td>
          </tr>
          <tr> 
            <td height="16" colspan="4" valign="top"> 
              <hr class="line" size="1">
            </td>
          </tr>
          <tr> 
            <td width="2%" valign="top">&nbsp;</td>
            <td class="data3" width="48%" valign="top"> 
            <span class="fieldname2">created on</span><br>
            <?=$created_on?>
          </td>
        </table>
      </td>
    </tr>
    <tr> 
      <td class="strip" colspan="2">&nbsp;</td>
    </tr>
  </table>
  <br>
</div>
  <?
if ($total_changed == 1)
{
$nexturl = "people_detail.php?" . SID . "&itemNumber=" . $itemNumber;
}
else
{
$nexturl = "people_detail.php?" . SID . "&itemNumber=" . ($itemNumber + 1);
}
$previousurl = "people_detail.php?" . SID . "&itemNumber=" . ($itemNumber - 1);
$total_changed = 0;
?>
<div align="center">
<table border="0" cellspacing="0" cellpadding="0" class="detail" align="center">
  <tr> 
    <td> 
      <div align="center"> 
        <?
if ($itemNumber > 0 && $itemNumber <= $total_results )
{
?>
        <table width="100" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#CCCCCC">
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
        <table width="100" border="0">
          <tr> 
            <td></td>
          </tr>
        </table>
        <?
}
?>
      </div>
    </td>
    <td> 
      <div align="center">
        <table width="120" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#CCCCCC">
          <tr>
            <td class="button">
              <div align="center">
                <p><a class="button" href="<?=$URL?>">Edit This Record</a></p>
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
        <table width="100" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#CCCCCC">
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
        <table width="100" border="0">
          <tr>
            <td></td>
          </tr>
        </table>
<?
}
?>
      </div>
     </td>
    </tr>
</table>
</div>
<br>
<div align="center">
<a class='links' href='<? echo $backToSearch; ?>'>Back to search results</a>
</div>
</td>
</tr>
</table>
</div>
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->

</p>
</body>
</html>
