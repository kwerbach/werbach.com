<?php
session_start();

$key = $HTTP_GET_VARS['key'];
$fullOrderBy = $HTTP_SESSION_VARS['fullOrderBy'];
$whereclause = $HTTP_SESSION_VARS['whereclause'];
$total_results = $HTTP_SESSION_VARS['total_results'];
require("people_connect.php");

if ($itemNumber == 0)
{
$screen = 1;
}

$Link = mysql_pconnect($Host, $User, $Password);
mysql_select_db($DBName, $Link);

$Query = "SELECT * from people where ID=$key";

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
$title = $Row['title'];
$company = $Row['company'];
$address1 = $Row['address1'];
$address2 = $Row['address2'];
$city = $Row['city'];
$province = $Row['province'];
$zip = $Row['zip'];
$country = $Row['country'];
$phone = $Row['phone'];
}
$URL = "people_edit_update.php?key=$key&itemNumber=$itemNumber&mode=$mode";
?>
<html>
<head>

<title>people Edit Detail :: Print Mailing Label</title>
<link rel="stylesheet" href="people_styles.css" type="text/css">
</head>

<body>

<?

require("header.php");
require("people_header.inc");
?>
<p></p>

<blockquote>

<p><?php echo "$user_id<br />"; ?></p>
<p><?php echo "$first "; 

	if ($middle) { echo "$middle $last";}
	else { echo "$last"; } ?><br />
	
	<?php 
		echo "$title<br />";
		echo "$company<br />";
		echo "$address1";
	if ($address2) { echo "<br/> $address2"; }
	?><br />
	
	<?php echo "$city, $province  $zip<br />";
		  echo "$country<br />";
		  
	?></p>
	
	<p><?php echo "$phone<br />";
			 echo "$email";
	?></p>

</blockquote>

<a href="people_edit_detail.php?key=<?=$key?>&itemNumber=<?=$itemNumber?>" class="button">Return to detail listing for <?php echo $user_id; ?></a>

</body>
</html>


	
	