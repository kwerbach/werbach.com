<?

session_start();

// constants //
$fieldname = "";
$insertfield = "";

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
$fieldname = $fieldname . "ID,";
$fieldname = $fieldname . "last,";
$fieldname = $fieldname . "first,";
$fieldname = $fieldname . "email,";
$fieldname = $fieldname . "middle,";
$fieldname = $fieldname . "nickname,";
$fieldname = $fieldname . "title,";
$fieldname = $fieldname . "company,";
$fieldname = $fieldname . "address1,";
$fieldname = $fieldname . "address2,";
$fieldname = $fieldname . "city,";
$fieldname = $fieldname . "province,";
$fieldname = $fieldname . "zip,";
$fieldname = $fieldname . "country,";
$fieldname = $fieldname . "phone,";
$fieldname = $fieldname . "fax,";
$fieldname = $fieldname . "cellphone,";
$fieldname = $fieldname . "home_phone,";
$fieldname = $fieldname . "website,";
$fieldname = $fieldname . "blog,";
$fieldname = $fieldname . "rss,";
$fieldname = $fieldname . "asst_name,";
$fieldname = $fieldname . "asst_phone,";
$fieldname = $fieldname . "out_out,";
$fieldname = $fieldname . "source,";
$fieldname = $fieldname . "personal_connection,";
$fieldname = $fieldname . "category,";
$fieldname = $fieldname . "sn_attendee,";
$fieldname = $fieldname . "sn_speaker,";
$fieldname = $fieldname . "snr_subscriber,";
$fieldname = $fieldname . "werblist_subscriber,";
$fieldname = $fieldname . "comments,";
$fieldname = $fieldname . "created_on,";
$fieldnamestr = $fieldname;

$newfieldname = rtrim($fieldnamestr); 

$fieldnames = substr($newfieldname,0,sizeof($newfieldname)-2);   //  strip off ',' 
$insertfield = $insertfield . "" . $ID . ",";
$insertfield = $insertfield . "'" . $last . "',";
$insertfield = $insertfield . "'" . $first . "',";
$insertfield = $insertfield . "'" . $email . "',";
$insertfield = $insertfield . "'" . $middle . "',";
$insertfield = $insertfield . "'" . $nickname . "',";
$insertfield = $insertfield . "'" . $title . "',";
$insertfield = $insertfield . "'" . $company . "',";
$insertfield = $insertfield . "'" . $address1 . "',";
$insertfield = $insertfield . "'" . $address2 . "',";
$insertfield = $insertfield . "'" . $city . "',";
$insertfield = $insertfield . "'" . $province . "',";
$insertfield = $insertfield . "'" . $zip . "',";
$insertfield = $insertfield . "'" . $country . "',";
$insertfield = $insertfield . "'" . $phone . "',";
$insertfield = $insertfield . "'" . $fax . "',";
$insertfield = $insertfield . "'" . $cellphone . "',";
$insertfield = $insertfield . "'" . $home_phone . "',";
$insertfield = $insertfield . "'" . $website . "',";
$insertfield = $insertfield . "'" . $blog . "',";
$insertfield = $insertfield . "'" . $rss . "',";
$insertfield = $insertfield . "'" . $asst_name . "',";
$insertfield = $insertfield . "'" . $asst_phone . "',";
$insertfield = $insertfield . "" . $out_out . ",";
$insertfield = $insertfield . "'" . $source . "',";
$insertfield = $insertfield . "" . $personal_connection . ",";
$insertfield = $insertfield . "'" . $category . "',";
$insertfield = $insertfield . "" . $sn_attendee . ",";
$insertfield = $insertfield . "" . $sn_speaker . ",";
$insertfield = $insertfield . "" . $snr_subscriber . ",";
$insertfield = $insertfield . "" . $werblist_subscriber . ",";
$insertfield = $insertfield . "'" . $comments . "',";
$insertfield = $insertfield . "'" . $created_on . "',";
$insertfieldstr = $insertfield;

$newinsertfield = rtrim($insertfieldstr); 

$insertfields = substr($newinsertfield,0,sizeof($newinsertfield)-2); 

require("people_connect.php");

$Link = mysql_pconnect ($Host, $User, $Password);
mysql_select_db($DBName, $Link);

$query1 = "INSERT INTO people (" . $fieldnames . ")";
$query2 = " VALUES (" . $insertfields . ")";
$Query = $query1 . $query2;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

<title> Add</title>
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
<?
if ($Result = mysql_query($Query, $Link))
{
?>
<p><div class='pagetext' align="center"><b>Record successfully added!</b></div>
<?
}
else
{
?>

<p><div class='pagetext' align='center'>ERROR:  Record was not successfully added!</div><p>
<p><div class='pagetext' align='center'>Chances are a required field was left blank or this record already exists.  Click back and try again.</div>
<p><div align='center'><a class='links' href='people_menu.php'>Continue</a></div>
<?
}
?>
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->

</p>
</body>
</html>
