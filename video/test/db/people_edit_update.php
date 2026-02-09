<?

session_start();

// constants // 
if (isset($HTTP_GET_VARS['itemNumber']))
{
$itemNumber = $HTTP_GET_VARS['itemNumber'];
}
if (isset($HTTP_GET_VARS['key']))
{
$key = $HTTP_GET_VARS['key'];
}
$whereclause = $HTTP_SESSION_VARS['whereclause'];
$fullOrderBy = $HTTP_SESSION_VARS['fullOrderBy'];
$total_results = $HTTP_SESSION_VARS['total_results'];
$updatefield = "";
// update fields below: // 
$ID = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['ID'] : addslashes($HTTP_POST_VARS['ID']);
$last = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['last'] : addslashes($HTTP_POST_VARS['last']);
$first = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['first'] : addslashes($HTTP_POST_VARS['first']);
$email = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['email'] : addslashes($HTTP_POST_VARS['email']);
$middle = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['middle'] : addslashes($HTTP_POST_VARS['middle']);
$nickname = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['nickname'] : addslashes($HTTP_POST_VARS['nickname']);
$title = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['title'] : addslashes($HTTP_POST_VARS['title']);
$company = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['company'] : addslashes($HTTP_POST_VARS['company']);
$address1 = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['address1'] : addslashes($HTTP_POST_VARS['address1']);
$address2 = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['address2'] : addslashes($HTTP_POST_VARS['address2']);
$city = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['city'] : addslashes($HTTP_POST_VARS['city']);
$province = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['province'] : addslashes($HTTP_POST_VARS['province']);
$zip = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['zip'] : addslashes($HTTP_POST_VARS['zip']);
$country = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['country'] : addslashes($HTTP_POST_VARS['country']);
$phone = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['phone'] : addslashes($HTTP_POST_VARS['phone']);
$fax = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['fax'] : addslashes($HTTP_POST_VARS['fax']);
$cellphone = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['cellphone'] : addslashes($HTTP_POST_VARS['cellphone']);
$home_phone = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['home_phone'] : addslashes($HTTP_POST_VARS['home_phone']);
$website = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['website'] : addslashes($HTTP_POST_VARS['website']);
$blog = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['blog'] : addslashes($HTTP_POST_VARS['blog']);
$rss = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['rss'] : addslashes($HTTP_POST_VARS['rss']);
$asst_name = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['asst_name'] : addslashes($HTTP_POST_VARS['asst_name']);
$asst_phone = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['asst_phone'] : addslashes($HTTP_POST_VARS['asst_phone']);
if (isset($HTTP_POST_VARS['out_out']))
{
 $out_out = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['out_out'] : addslashes($HTTP_POST_VARS['out_out']);
}
if (!isset($HTTP_POST_VARS['out_out']))
{
 $out_out = "0";
}
$source = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['source'] : addslashes($HTTP_POST_VARS['source']);
if (isset($HTTP_POST_VARS['personal_connection']))
{
 $personal_connection = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['personal_connection'] : addslashes($HTTP_POST_VARS['personal_connection']);
}
if (!isset($HTTP_POST_VARS['personal_connection']))
{
 $personal_connection = "0";
}
$category = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['category'] : addslashes($HTTP_POST_VARS['category']);
if (isset($HTTP_POST_VARS['sn_attendee']))
{
 $sn_attendee = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['sn_attendee'] : addslashes($HTTP_POST_VARS['sn_attendee']);
}
if (!isset($HTTP_POST_VARS['sn_attendee']))
{
 $sn_attendee = "0";
}
if (isset($HTTP_POST_VARS['sn_speaker']))
{
 $sn_speaker = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['sn_speaker'] : addslashes($HTTP_POST_VARS['sn_speaker']);
}
if (!isset($HTTP_POST_VARS['sn_speaker']))
{
 $sn_speaker = "0";
}
if (isset($HTTP_POST_VARS['snr_subscriber']))
{
 $snr_subscriber = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['snr_subscriber'] : addslashes($HTTP_POST_VARS['snr_subscriber']);
}
if (!isset($HTTP_POST_VARS['snr_subscriber']))
{
 $snr_subscriber = "0";
}
if (isset($HTTP_POST_VARS['werblist_subscriber']))
{
 $werblist_subscriber = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['werblist_subscriber'] : addslashes($HTTP_POST_VARS['werblist_subscriber']);
}
if (!isset($HTTP_POST_VARS['werblist_subscriber']))
{
 $werblist_subscriber = "0";
}
$comments = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['comments'] : addslashes($HTTP_POST_VARS['comments']);
$created_on = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['created_on'] : addslashes($HTTP_POST_VARS['created_on']);
$date_input = $created_on;
     list($month, $day, $year) = split('[/.-]', $date_input);
$created_on = $year . "-" . $month . "-" . $day;
$updatefield = $updatefield . "ID=" . $ID . ",";
$updatefield = $updatefield . "last='" . $last . "',";
$updatefield = $updatefield . "first='" . $first . "',";
$updatefield = $updatefield . "email='" . $email . "',";
$updatefield = $updatefield . "middle='" . $middle . "',";
$updatefield = $updatefield . "nickname='" . $nickname . "',";
$updatefield = $updatefield . "title='" . $title . "',";
$updatefield = $updatefield . "company='" . $company . "',";
$updatefield = $updatefield . "address1='" . $address1 . "',";
$updatefield = $updatefield . "address2='" . $address2 . "',";
$updatefield = $updatefield . "city='" . $city . "',";
$updatefield = $updatefield . "province='" . $province . "',";
$updatefield = $updatefield . "zip='" . $zip . "',";
$updatefield = $updatefield . "country='" . $country . "',";
$updatefield = $updatefield . "phone='" . $phone . "',";
$updatefield = $updatefield . "fax='" . $fax . "',";
$updatefield = $updatefield . "cellphone='" . $cellphone . "',";
$updatefield = $updatefield . "home_phone='" . $home_phone . "',";
$updatefield = $updatefield . "website='" . $website . "',";
$updatefield = $updatefield . "blog='" . $blog . "',";
$updatefield = $updatefield . "rss='" . $rss . "',";
$updatefield = $updatefield . "asst_name='" . $asst_name . "',";
$updatefield = $updatefield . "asst_phone='" . $asst_phone . "',";
$updatefield = $updatefield . "out_out=" . $out_out . ",";
$updatefield = $updatefield . "source='" . $source . "',";
$updatefield = $updatefield . "personal_connection=" . $personal_connection . ",";
$updatefield = $updatefield . "category='" . $category . "',";
$updatefield = $updatefield . "sn_attendee=" . $sn_attendee . ",";
$updatefield = $updatefield . "sn_speaker=" . $sn_speaker . ",";
$updatefield = $updatefield . "snr_subscriber=" . $snr_subscriber . ",";
$updatefield = $updatefield . "werblist_subscriber=" . $werblist_subscriber . ",";
$updatefield = $updatefield . "comments='" . $comments . "',";
$updatefield = $updatefield . "created_on='" . $created_on . "',";
$udfield = $updatefield;

$newudfield = rtrim($udfield); 

$updatefields = substr($newudfield,0,sizeof($newudfield)-2); 

$redirect = "people_detail.php?edit=1&key=" . $key . "&itemNumber=" . $itemNumber;

require("people_connect.php");

$Link = mysql_pconnect ($Host, $User, $Password);
mysql_select_db($DBName, $Link);
$Query = "UPDATE people SET " . $updatefields . " WHERE people.ID = " . $key;

if ($Result = mysql_query($Query, $Link))
{
 $Query2 = "SELECT * FROM people " . $whereclause;
 $Recordset = mysql_query($Query2, $Link);
 $total_records = mysql_num_rows($Recordset);
 mysql_free_result($Recordset);
 $newCount = $total_records - 1;
 if ($newCount <> $total_results)
 {
     $total_changed = 1;
     $HTTP_SESSION_VARS['total_results'] = $newCount;
 }
 else
 {
     $total_changed = 0;
 }
 if (!isset($HTTP_SESSION_VARS['total_changed']))
 {
     session_register('total_changed');
 }
 else
 {
     $HTTP_SESSION_VARS['total_changed'] = $total_changed;
 }
 header("Location:$redirect");
}
else
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

<title> Edit Detail</title>
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
<p><div class='pagetext' align='center'><b>ERROR:</b></div>
<div class='pagetext' align='center'>Chances are a required field was left blank.</div>
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->

<?
}
mysql_free_result($Recordset);
mysql_free_result($Result);
?>

<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->

</p>
</body>
</html>
