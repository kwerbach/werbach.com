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
$ID = $Row['user_id'];
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
$ID = $Row['user_id'];
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
<br>
<span class="strip">Detail View</span>
<table width="98%" border="1" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF" class="data2">
  <tr>
    <td colspan="3" bgcolor="#FFFFFF">ID# &nbsp;
        <?=$ID?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="29%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="27%" bgcolor="#FFFFFF">Created:
        <?=$created_on?>
    </td>
  </tr>
  <tr>
    <td width="30%" colspan="2" bgcolor="#FFFFCC"><font size="+1"><strong>
      <?=$first?>
    </strong></font></td>
    <td width="10%" bgcolor="#FFFFCC"><font size="+1"><strong>
      <?=$middle?>
    </strong></font></td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="29%" bgcolor="#FFFFCC"><font size="+1"><strong>
      <?
if ($email <> "" && $email <> " ")
{
?>
      <a class="hyperlink"  href="mailto:<?=$email?>">
      <?=$email?>
      </a>
      <?
}
else
{
?>
      No link available
      <?
}
?>
    </strong></font></td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFFCC"><font size="+1"><strong>
      <?=$last?>
    </strong></font></td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="29%" bgcolor="#FFFFFF">Website:
        <?=$website?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="27%" bgcolor="#FFFFFF">SN attendee?
        <?=$sn_attendee?>
    </td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFFFF">Nickname:
        <?=$nickname?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="29%" bgcolor="#FFFFFF">Blog:
        <?=$blog?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="27%" bgcolor="#FFFFFF">SN speaker?
        <?=$sn_speaker?>
    </td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFFFF">Title: <?=$title?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="29%" bgcolor="#FFFFFF">RSS:
        <?=$rss?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="27%" bgcolor="#FFFFFF">SNR subscriber?
        <?=$snr_subscriber?>
    </td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFFFF">Company: <?=$company?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="29%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="27%" bgcolor="#FFFFFF">Werblist subscriber?
        <?=$werblist_subscriber?>
    </td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFFFF">Address1:       <?=$address1?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="29%" bgcolor="#FFFFFF">Asst. Name:
        <?=$asst_name?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFFFF">Address2: <?=$address2?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="29%" bgcolor="#FFFFFF">Asst. Phone:
        <?=$asst_phone?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td width="28%" bgcolor="#FFFFFF">City: <?=$city?>
    </td>
    <td width="5%" bgcolor="#FFFFFF">State: <?=$province?>
    </td>
    <td bgcolor="#FFFFFF">Zip: <?=$zip?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="29%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFFFF">Country:       <?=$country?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="29%" bgcolor="#CCCCCC">Opt out?
        <?=$out_out?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFFFF">Phone:
        <?=$phone?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="29%" bgcolor="#CCCCCC">Source:
        <?=$source?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFFFF">Fax:
        <?=$fax?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="29%" bgcolor="#CCCCCC">Personal connection?
        <?=$personal_connection?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFFFF">Cell:
        <?=$cellphone?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="29%" bgcolor="#CCCCCC">Category:
        <?=$category?>
    </td>
    <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="27%" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFFFF">Home:
        <?=$home_phone?>
    </td>
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
        <?=$comments?>
    </td>
  </tr>
</table>
<div align="center">
  <table width="650" cellpadding="0" cellspacing="0">
<tr>
<td>
<br>
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
