<?php
require "../inc_db.php";
dbconnect();
?>
	<html>

<head>

<title>Supernova - Registration Snapshot</title>
<style type="text/css">
a:link { color:blue; text-decoration: none }
a:visited { color:blue; text-decoration: none }
a:hover { text-decoration: underline }
</style>

<link href="../register.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#380169" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">


<center>

<table border="0" cellpadding="0" cellspacing="0">

<tr>
<td width="42" background="../../images/background_left.gif"></td>
<td width="780" bgcolor="#FFFFFF">

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="304" height="155" valign="top"><a href="http://www.supernova2005.com"><img src="../../images/logo.gif" width="304" height="155" alt="Home" border="0"></a></td>
	<td width="476"><img src="../../images/tagline.gif" width="476" height="155"></td>
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="108"><img src="../../images/topcorner.gif" width="108" height="45" alt=""></td>
	<td width="8"></td>
	<td width="1" bgcolor="#FFA813"></td>
	<td width="663">
	
		<table border="0" cellpadding="0" cellspacing="0">
		
		<tr>
		<td width="17" height="24" bgcolor="#FFA813" valign="top"></td>
		<td width="646" height="24" bgcolor="#FFA813" valign="middle">
		<font face="verdana,arial" size="2" color="#FFFFFF">
		
		<a href="snapshot.php" style="color:FFFFFF"><b>Snapshot</b></a> | <a href="attendees.php" style="color:FFFFFF"><b>Attendees</b></a> | <a href="download.php" style="color:FFFFFF"><b>Download </b></a> | <a href="https://www.supernova2005.com/registration/reg_admin/add_existing/" style="color:FFFFFF"><b>Add New </b></a> | <a href="priority_codes.php" style="color:FFFFFF"><b>Priority Codes </b></a> | <a href="aliases.php" style="color:FFFFFF"><b>Aliases </b></a> | <a href="../register.php" style="color:FFFFFF"><b>Reg. Form</b></a> </td>
		</tr>
		
		<tr>
		<td height="21" colspan="2"></td>
		</tr>
		
		</table>
	
	</td>
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="111" height="100%" align="right" valign="top">
	<font face="verdana,arial" size="1">	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
     <br>
	<img src="../../images/palacehotel.jpg" width="111" height="189" alt="Palace Hotel">
	<br><br><br>
	<a href="http://www.wharton.upenn.edu/campus/wharton_west"><img src="../../images/whartonwest.jpg" width"111" height"215" alt="Wharton West" border="0"></a>
	<br><br>	</td>
	<td width="5"></td>
	<td width="1" valign="top"><img src="../../images/yellowline.gif" width="1" height="195" alt=""></td>
	<td width="17"></td>
	<td valign="top">
	<font face="verdana,arial" size="2">


<!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->

	<p><img src="../../images/head_register.gif" width="502" height="50" alt="Register">
	<br>

	Supernova 2006 registration summary... <br>
	<br>
    </p>
<!-- START CONTENT -->

<table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">

<?php
echo one_value("count(*)", "", "&#8226; People Registered: ");
echo one_value("sum(amount)", "", "&#8226; Total Revenue: $");
echo one_value("count(*)", " WHERE date_registered < '2006-05-13'", "&#8226; Number of early birds: ");
echo one_value("count(new_person)", " WHERE new_person = 'yes'", "&#8226; People added to contact list: ");
?>

</table>
<br />

<table width="350"  border="1" align="center" cellpadding="0" cellspacing="0">
<?php
show_counts("Registered","*", "");
?>
</table>
<br />
<table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="form_label"><strong>Events</strong></td>
	</tr>
</table>
<br />
<?php
write_detailed_counts("seminar_event", 0);
?>
<br />
<table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td class="form_label"><strong>Showcase</strong></td>
</tr>
</table>
<br />
<?php
write_detailed_counts("showcase", 0);
?>
<br />
<table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="form_label"><strong>Priority Codes</strong></td>
	</tr>
</table>
<br />
<?php
write_detailed_counts("priority_code", 0);
?>
<br />
<table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="form_label"><strong> Categories</strong></td>
	</tr>
</table>
<br />
<?php
write_detailed_counts("category", 0);
?>
<br />
<table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="form_label"><strong>Priority Code Description</strong></td>
	</tr>
</table>
<br />
<?php
write_detailed_counts("priority_code_description", 0);
?>
<br />
<table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="form_label"><strong>Top 5 Registration Dates</strong></td>
	</tr>
</table>
<br />
<?php
write_detailed_counts("date_registered", 5);
?>
<br />
<table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="form_label"><strong>New Person</strong></td>
	</tr>
</table>
<br />
<?php
write_detailed_counts("new_person", 0);
?>
<br />

<!-- END CONTENT -->    
    
    </td>
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="780" height="1" bgcolor="#FFA813"></td>
<!-- 	<td bgcolor="#FFA813"><img src="../../images/bottomcornerslice.gif" width="135" height="1" alt="" ></td>-->
	</tr>
	
	</table>

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="134"></td>
	<td width="373"><font face="verdana,arial" size="1" color="#7E7E7E">
	©2005 Supernova Group LLC
	</td>
	<td width="273"><img src="../../images/bottommiddle.gif" width="273" height="31" alt=""></td>
	</tr>
	
	<tr>
	<td colspan="3"><img src="../../images/bottom.gif" width="780" height="52" alt=""></td>
	</tr>
	
	</table>

</td>
<td width="42" background="../../images/background_right.gif"></td>
</tr>

</table>
</center>

</html>
<?php
global $bg_color;
$bg_color = '#ffffff"';
function show_counts($title="Count",$field_name="*", $where_clause="")
{
	$query = "select $field_name from supernova_registrations " . $where_clause;
	$result = safe_query($query);
	if ($result)
			{
					$the_count = mysql_num_rows($result);
			}
			if ($title == "Registered")
			{
				global $total_count;
				$total_count = mysql_num_rows($result);
			}
	mysql_free_result($result);
	global $bg_color;
	global $total_count;
	$bg_color = ($bg_color == '#d3e0f8') ? '#ffffff' : '#d3e0f8';
	$the_percent = round(($the_count / $total_count) * 100);
	$bar_width = round($the_percent * 1.5);
	print <<<EOQ
			<!-- <tr><td colspan="5">$the_count</td></tr> -->
       		<tr bgcolor="$bg_color">
				<td width="100" class="form_label"><strong>$title</strong></td>
				<td width="150" bgcolor="$bg_color">
				<img src="../../images/yellowline.gif" width="$bar_width" height="5"></td>
				<td width="33" align="center" class="form_label">$the_count</td>
				<td width="33" align="center" class="form_label">$the_percent%</td>
				<td width="34" align="center" class="form_label">
					<a href="attendees.php?where_clause=$where_clause">view</a>
				</td>
       		</tr>	
EOQ;
}



function write_detailed_counts($field, $limit=0)
	{
	if($limit > 0)
	{
		$limit_num = "LIMIT " . $limit;
	}
	$query = "SELECT DISTINCT " . $field . ", COUNT($field) AS the_count 
				FROM supernova_registrations 
				WHERE " . $field . " IS NOT NULL 
				GROUP BY " . $field .  "
				ORDER BY the_count DESC " . $limit_num;
	$result = safe_query($query);
	echo "<table width=\"350\"  border=\"1\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
	
	while ($row = mysql_fetch_array($result))
	{
		$field_value = (get_magic_quotes_gpc()) ? $row["$field"] : addslashes($row["$field"]);
		show_counts(strtolower($row[$field]),$field, "WHERE " . $field . " = '" . $field_value . "'");
	}
	echo "</table>";
	mysql_free_result($result);
}

function one_value($field_name,$where_clause,$title="result")
{
	$query = "select " . $field_name . " as the_field from supernova_registrations " . $where_clause;
	$result = safe_query($query);
	if ($result)
	{
	 	$row = mysql_fetch_row($result);
			echo "\n\t<tr><td class=\"form_label\">";
			echo "\n\t\t" . $title . $row[0];
			echo "\n\t</td></tr>";
	}
	else
	{
		echo $title . "???";
	}
}	
?>