<?php
require "../inc_db.php";
dbconnect();
?>
	<html>

<head>

<title>Supernova - Revenue Snapshot</title>
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
    <td>
	<?php require "navig_reg_admin.php"; ?>
	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top"> <font face="verdana,arial" size="2">
      <!-- START CONTENT --></font>
      <p>Supernova 2006 registration summary... <br>
        <br>
</p>
      <!-- START CONTENT -->
      <table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <?php
echo one_value("count(*)", "", "&#8226; People Registered: ");
echo one_value("sum(amount)", "", "&#8226; Total Revenue: $");
echo one_value("sum(amount)", "WHERE payment_received = 'yes'", "&#8226; Revenue Received: $");
echo one_value("sum(amount)", "WHERE payment_received = 'no'", "&#8226; Revenue Outstanding: $");
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
          <td class="form_label"><strong>Payment NOT Received by <strong>Declined Reasons</strong></strong></td>
        </tr>
      </table>
      <br />
      <?php
write_detailed_sums("cc_declined_reason", 0, 0);
?>
      <br>
      <br />
      <table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="form_label"><strong>Payment Methods</strong></td>
        </tr>
      </table>
      <br />
      <?php
write_detailed_counts("payment_method", 0);
?>
      <br>
      <br />
      <table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="form_label"><strong>Payments Received by Event Package </strong></td>
        </tr>
      </table>
      <br />
      <?php
write_detailed_sums("seminar_event", 0, 1);
?>
      <br>
      <br>
      <table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="form_label"><strong>Payments NOT Received by Event Package </strong></td>
        </tr>
      </table>
      <br />
      <?php
write_detailed_sums("seminar_event", 0, 0);
?>
      <br>
      <br>
      <table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="form_label"><strong>Payments Received by Category</strong></td>
        </tr>
      </table>
      <br />
      <?php
write_detailed_sums("category", 0, 1);
?>
      <br>
      <br>
      <table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="form_label"><strong>Payments NOT Received by Category</strong></td>
        </tr>
      </table>
      <br />
      <?php
write_detailed_sums("category", 0, 0);
?>
      <br>
      <br />
      <table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="form_label"><strong>Payments Received by Priority Code</strong></td>
        </tr>
      </table>
      <br />
      <?php
write_detailed_sums("priority_code", 0, 1);
?>
      <br>
      <br>
      <table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="form_label"><strong>Payments NOT Received by Priority Code</strong></td>
        </tr>
      </table>
      <br />
      <?php
write_detailed_sums("priority_code", 0, 0);
?>
      <br>
      <br />
      <table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="form_label"><strong>Payments Received by Priority Code Description</strong></td>
        </tr>
      </table>
      <br />
      <?php
write_detailed_sums("priority_code_description", 0, 1);
?>
      <br>
      <br>
      <table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="form_label"><strong>Payments NOT Received by Priority Code Description</strong></td>
        </tr>
      </table>
      <br />
      <?php
write_detailed_sums("priority_code_description", 0, 0);
?>
      <br>
      <br />
      <table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="form_label"><strong>Payments Received</strong></td>
        </tr>
      </table>
      <br />
      <?php
write_detailed_counts("payment_received", 0);
?>
      <br />
      <table width="400"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="form_label"><strong>Payment Method</strong></td>
        </tr>
      </table>
      <br />
      <?php
write_detailed_counts("payment_method", 0);
?>
      <br />
      <!-- END CONTENT -->
    <p><font face="verdana,arial" size="2">      </font></p></td>
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





function write_detailed_sums($field, $limit=0, $paid=2)
{
	if($paid == 0)		// NOT PAID
	{
		$not_paid_clause = " AND payment_received = 'no'";
	}
	if($paid == 1) 		// PAID
	{
		$not_paid_clause = " AND payment_received = 'yes'";
	}	
	if($paid == 2)		// ANY PAYMENT STATUS
	{
		$not_paid_clause = "";
	}	
	if($limit > 0)
	{
		$limit_num = "LIMIT " . $limit;
	}
	$query = "SELECT " . $field . ", SUM(amount) AS the_amount 
				FROM supernova_registrations 
				WHERE " . $field . " IS NOT NULL " . $not_paid_clause . "
				GROUP BY " . $field . "
				ORDER BY the_amount DESC " . $limit_num;
	$result = safe_query($query);
	echo "<table width=\"350\"  border=\"1\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";


	while ($row = mysql_fetch_array($result))
	{
		$bg_color = ($bg_color == '#d3e0f8') ? '#ffffff' : '#d3e0f8';
		$f = $row[$field];
		$a = $row["the_amount"];
		$p = ($a > 0) ? round($a / 21346 * 100) : 0;
		$a = number_format($a, -2);
		$bar_width = round($p * 1.5);
		$sql_val = addslashes($f);
print <<<EOQ
		<tr bgcolor="$bg_color">
		<td class="form_label">$f</td>
		<td width="150">
		<img src="../../images/yellowline.gif" width="$bar_width" height="5"></td>
		<td class="form_label" align="right">$a</td>
		<td class="form_label" align="right">$p%</td>
		<td width="34" align="center" class="form_label">
			<a href="attendees.php?where_clause=WHERE $field = '$sql_val' $not_paid_clause">view</a>
		</td>
		</tr>
EOQ;
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