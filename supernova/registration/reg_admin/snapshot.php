<?php
require "../inc_db.php";
$reg_year = "2008";
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
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
    <td><img src="../../images_reg/supernova1.jpeg" width="200" height="109"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php require "navig_reg_admin.php"; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top"> <font face="verdana,arial" size="2">
      <!-- START CONTENT -->
<p></p>
         <table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <?php
echo one_value("count(*)", "", "&#8226; People Registered: ");
echo one_value("sum(amount)", "", "&#8226; Total Revenue: $");
echo one_value("count(*)", " WHERE date_registered < '2007-05-13'", "&#8226; Number of early birds: ");
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
<!-- NEW TABLE -->	  
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
	  

<!-- NEW TABLE -->
<table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="form_label"><strong>Revenue Breakdown</strong></td>
        </tr>
      </table>
      <br />
<?php
write_rev_breakdown();
?>
      <br />
<!-- NEW TABLE -->
      <table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="form_label"><strong>Payment Totals</strong></td>
        </tr>
      </table>
      <br />
      <?php
write_payment_amounts();	
?>
      <br />
<!-- NEW TABLE -->	  
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
<!-- NEW TABLE -->	  
      <table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="form_label"><strong>Categories</strong></td>
        </tr>
      </table>
      <br />
      <?php
write_detailed_counts("category", 0);
?>
      <br />


<!-- NEW TABLE -->
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
<!-- NEW TABLE -->	  
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
      </font></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
global $bg_color;
$bg_color = '#ffffff"';
function show_counts($title="Count",$field_name="*", $where_clause="")
{
	global $reg_year;
	if($where_clause == "")		// NO WHERE CLAUSE
	{
		$where_clause = " WHERE seminar_year = '" . $reg_year . "'";
	}
	else
	{
		$where_clause .= " AND seminar_year = '" . $reg_year . "'";
	}
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
				<img src="../images/yellowline.gif" width="$bar_width" height="5"></td>
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
	global $reg_year;
	if($limit > 0)
	{
		$limit_num = "LIMIT " . $limit;
	}
	$query = "SELECT DISTINCT " . $field . ", COUNT($field) AS the_count 
				FROM supernova_registrations 
				WHERE " . $field . " IS NOT NULL AND seminar_year = '" . $reg_year . "' 
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
	global $reg_year;
	if($where_clause == "")		// NO WHERE CLAUSE
	{
		$where_clause = " WHERE seminar_year = '" . $reg_year . "'";
	}
	else
	{
		$where_clause .= " AND seminar_year = '" . $reg_year . "'";
	}
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

function write_rev_breakdown()
{

	global $reg_year;
	
	// GET PAYING PEOPLE
	$p_query = "SELECT DISTINCT COUNT(*) AS the_count 
				FROM supernova_registrations 
				WHERE Amount > 0 AND seminar_year = '" . $reg_year . "' 
				ORDER BY the_count DESC LIMIT 1";
	$p_result = safe_query($p_query);
	
	while ($row = mysql_fetch_array($p_result))
	{
		$p_count = $row["the_count"];
	}
	mysql_free_result($p_result);
	
	// GET NON-PAYING PEOPLE
	$c_query = "SELECT DISTINCT COUNT(*) AS the_count 
				FROM supernova_registrations 
				WHERE Amount = 0 AND seminar_year = '" . $reg_year . "' 
				ORDER BY the_count DESC LIMIT 1";
	$c_result = safe_query($c_query);
	
	while ($row = mysql_fetch_array($c_result))
	{
		$c_count = $row["the_count"];
	}
	mysql_free_result($c_result);
	
	$total 		= $p_count + $c_count;
	$p_percent	= round(100 * ($p_count / $total));
	$c_percent	= round(100 * ($c_count / $total));	
	
echo <<<EOQ
	<table width="350"  border="1" align="center" cellpadding="0" cellspacing="0">
       		<tr bgcolor="#d3e0f8">
				<td width="100" class="form_label"><strong>Paying</strong></td>
				<td width="150" bgcolor="#d3e0f8">
				<img src="../images/yellowline.gif" width="$p_percent" height="5"></td>
				<td width="33" align="center" class="form_label">$p_count</td>
				<td width="33" align="center" class="form_label">$p_percent%</td>
				<td width="34" align="center" class="form_label">
					<a href="attendees.php?where_clause=WHERE Amount > 0 AND seminar_year = '$reg_year'">view</a>
				</td>
       		</tr>		
       		<tr bgcolor="#ffffff">
				<td width="100" class="form_label"><strong>Complimentary</strong></td>
				<td width="150" bgcolor="#ffffff">
				<img src="../images/yellowline.gif" width="$c_percent" height="5"></td>
				<td width="33" align="center" class="form_label">$c_count</td>
				<td width="33" align="center" class="form_label">$c_percent%</td>
				<td width="34" align="center" class="form_label">
					<a href="attendees.php?where_clause=WHERE Amount = 0 AND seminar_year = '$reg_year'">view</a>
				</td>
       		</tr>
	</table>
EOQ;

}

function write_payment_amounts()
{

	global $reg_year;
	
	// GET PAYING PEOPLE
	$p_query = "SELECT DISTINCT SUM(Amount) AS the_count 
				FROM supernova_registrations 
				WHERE Amount > 0 AND payment_received = 'yes' AND seminar_year = '" . $reg_year . "'
				ORDER BY the_count DESC LIMIT 1";
	$p_result = safe_query($p_query);
	
	while ($row = mysql_fetch_array($p_result))
	{
		$p_sum = $row["the_count"];
	}
	mysql_free_result($p_result);
	
	// GET NON-PAYING PEOPLE
	$o_query = "SELECT DISTINCT SUM(Amount) AS the_count 
				FROM supernova_registrations 
				WHERE Amount > 0 AND payment_received <> 'yes' AND seminar_year = '" . $reg_year . "'
				ORDER BY the_count DESC LIMIT 1";
	$o_result = safe_query($o_query);
	
	while ($row = mysql_fetch_array($o_result))
	{
		$o_sum = $row["the_count"];
	}
	mysql_free_result($o_result);
	
	$total 		= $p_sum + $o_sum;
	$p_percent	= round(100 * ($p_sum / $total));
	$o_percent	= round(100 * ($o_sum / $total));	
	
echo <<<EOQ
	<table width="350"  border="1" align="center" cellpadding="0" cellspacing="0">
       		<tr bgcolor="#d3e0f8">
				<td width="100" class="form_label"><strong>Payment Received</strong></td>
				<td width="150" bgcolor="#d3e0f8">
				<img src="../images/yellowline.gif" width="$p_percent" height="5"></td>
				<td width="33" align="center" class="form_label">$p_sum</td>
				<td width="33" align="center" class="form_label">$p_percent%</td>
				<td width="34" align="center" class="form_label">
					<a href="attendees.php?where_clause=WHERE Amount > 0 AND seminar_year = '$reg_year'">view</a>
				</td>
       		</tr>		
       		<tr bgcolor="#ffffff">
				<td width="100" class="form_label"><strong>Payment Not Received </strong></td>
				<td width="150" bgcolor="#ffffff">
				<img src="../images/yellowline.gif" width="$c_percent" height="5"></td>
				<td width="33" align="center" class="form_label">$o_sum</td>
				<td width="33" align="center" class="form_label">$o_percent%</td>
				<td width="34" align="center" class="form_label">
					<a href="attendees.php?where_clause=WHERE Amount = 0 AND seminar_year = '$reg_year'">view</a>
				</td>
       		</tr>
	</table>
EOQ;

}


?>
