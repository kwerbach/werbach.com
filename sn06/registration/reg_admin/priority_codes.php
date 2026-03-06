<?php
require "../inc_db.php";
require "inc_forms.php";

function sqlize($str)
{
		$str_sql = (get_magic_quotes_gpc()) ? $str : addslashes($str);
		return($str_sql);
}

	dbconnect();
switch ($_POST["mode"]) {		// CHECK MODE AND DO THE RIGHT THING
	case "delete selected":
	   $r = 0; // rows deleted so far
	   foreach($_POST["priority_code_id"] as $e)
	   {
		$query = "DELETE FROM sn_priority_codes WHERE priority_code_id = '" . $e . "' LIMIT 1";
		safe_query($query);
		$r++;	//add one to rows affected
	   }
	   $msg = $r . " row(s) were affected.<br>";
	   break;
	case "add":
		$query = "INSERT  sn_priority_codes (priority_code, category, price) VALUES ('" . sqlize($_POST["add_priority_code"]) . "', '" . $_POST["add_category"] . "', " . $_POST["add_price"] . ")";
		safe_query($query);
		break;
	case "update":
		$update_sql_price = ($_POST["update_price"] == "") ? "" : "price = '" . $_POST["update_price"] . "', ";
		$update_sql_category = ($_POST["update_category"] == "") ? "" : "category = '" . sqlize($_POST["update_category"]) . "', ";		
//		$query = "UPDATE sn_priority_codes SET price = '" . $_POST["update_price"] . "', category = '" . $_POST["update_category"] . "', last_modified = '" . date("Y-m-d H:i:s") ."' WHERE priority_code_id = '" . $_POST["update_priority_code"] . "' LIMIT 1";
		$query = "UPDATE sn_priority_codes SET " . $update_sql_price . $update_sql_category . " last_modified = '" . date("Y-m-d H:i:s") ."' WHERE priority_code_id = '" . $_POST["update_priority_code"] . "' LIMIT 1";
		safe_query($query);
		break;
		
	
}
$where_clause = "";
$where_clause = $_GET["where_clause"];
if($_POST['category'] != "")
{
	and_where();
	$where_clause .= "category = '" . $_POST['category'] . "'";
}

if ($where_clause != "")
{
	//$where_clause = " WHERE " . $where_clause;
	$where_clause = ($_GET["where_clause"] == "") ? " WHERE " . $where_clause : " " . $where_clause;
}



?>
	<html>

<head>

<title>Supernova 2005</title>
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
		
		<a href="snapshot.php" style="color:FFFFFF"><b>Snapshot</b></a> | <a href="attendees.php" style="color:FFFFFF"><b>Attendees</b></a> | <a href="download.php" style="color:FFFFFF"><b>Download All </b></a> | <a href="priority_codes.php" style="color:FFFFFF"><b>Priority Codes </b></a> | <a href="aliases.php" style="color:FFFFFF"><b>Email Aliases </b></a> | <a href="../register.php" style="color:FFFFFF"><b>Registration Form</b></a> </td>
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
	<font face="verdana,arial" size="1">
	
	<a href="../../program_overview.htm" style="color:7E7E7E" title="Agenda At-A-Glance"> </a><br>
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

	Manage priority codes, categories, and prices...<br>
	<br>
    </p>
<!-- START CONTENT -->
<form action="priority_codes.php" method="post">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="form_label">Priority Code </td>
		<td class="form_label">Category</td>
		<td class="form_label">Price</td>
		<td class="form_label"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="form_label"><input name="add_priority_code" type="text" id="add_priority_code"></td>
		<td class="form_label"><input name="add_category" type="text" id="add_category" size="25" maxlength="25"></td>
		<td class="form_label">$
			<input name="add_price" type="text" id="add_price" size="10" maxlength="10"></td>
		<td class="form_label"><input name="mode" type="submit" class="button" id="mode" value="add"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="form_label">&nbsp;</td>
		<td class="form_label"></td>
		<td class="form_label"></td>
		<td class="form_label"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="form_label"><select name="update_priority_code">
          	<option value="" selected>Update...</option>
          	<?php
	$query = "SELECT distinct priority_code_id, priority_code FROM sn_priority_codes WHERE priority_code IS NOT NULL ORDER BY priority_code";
	db_select_list($query, "priority_code_id", "priority_code", "");
	?>
          	          </select></td>
		<td class="form_label"><input name="update_category" type="text" id="update_category" size="25" maxlength="25"></td>
		<td class="form_label">$
			<input name="update_price" type="text" id="update_price" size="10" maxlength="10"></td>
		<td class="form_label"><input name="mode" type="submit" class="button" id="mode" value="update"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="form_label">&nbsp;</td>
		<td class="form_label"></td>
		<td class="form_label"></td>
		<td class="form_label"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="form_label">Category</td>
		<td class="form_label"></td>
		<td class="form_label"></td>
		<td class="form_label"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><select name="category">
          	<option value="">Any Category</option>
          	<?php
	$query = "SELECT distinct category FROM sn_priority_codes WHERE category IS NOT NULL ORDER BY category";
	db_select_list($query, "category", "category", $_POST['category']);
	?>
          	</select>
			<input name="submit" type="submit" class="button" value="filter"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><input name="mode" type="submit" class="button" value="delete selected"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>



<?php
	show_table();
?>
</form>
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
function show_table()
{
	global $where_clause;
	// QUERY FOR DISPLAYING RESULTS
	//$where_clause = "WHERE email = '" . $_POST['email'] . "'";//TESTING
	//$query = "select people.*, supernova_2005.seminar_event //TESTING
	$query = "select * from sn_priority_codes" . $where_clause . " LIMIT 0 , 50";
	$result = safe_query($query);
	$class = " class=\"highlight\"";
//	echo $query;  //TESTING
	if ($result)
		{
			$i = 0;
			echo "<table>";
			echo <<<EOQ
			<tr>
				  <td class="form_label">&nbsp;</td>
				  <td class="form_label"><strong>Priority Code</strong></td>
				  <td class="form_label"><strong>Category</strong></td>
				  <td class="form_label"><strong>price</strong></td>
			</tr>
EOQ;
			while ($row = mysql_fetch_array($result)) 
			{
			$class = ($class == " class=\"highlight\"") ? "" : " class=\"highlight\"";
			$i++;
			$priority_code_id = $row["priority_code_id"];
			$priority_code = $row["priority_code"];
			$category = $row["category"];
			$price = $row["price"];
			print <<<EOQ
				<tr$class>
				  <td class="form_label"><input type="checkbox" value="$priority_code_id" name="priority_code_id[]"></td>
				  <td class="form_label">$priority_code</td>
				  <td class="form_label">$category</td>
				  <td class="form_label" align="right">$$price</a></td>
				</tr>
EOQ;
			}
			echo "</table>";
			mysql_free_result($result);
		}
}		

function and_where()
{
	global $where_clause;
	if ($where_clause != "")
	{
		$where_clause .= " AND ";
	}
}
?>

