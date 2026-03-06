<?php
require "../inc_db.php";
require "inc_forms.php";
dbconnect();

switch ($_POST["mode"]) {		// CHECK MODE AND DO THE RIGHT THING
	case "delete selected":
	   $r = 0; // rows deleted so far
	   foreach($_POST["email_alias_id"] as $e)
	   {
		$query = "DELETE FROM email_aliases WHERE email_alias_id = '" . $e . "' LIMIT 1";
		safe_query($query);
		$r++;	//add one to rows affected
	   }
	   $msg = $r . " row(s) were affected.<br>";
	   break;
	case "activate selected":
	   $r = 0; // rows affected so far
	   foreach($_POST["email_alias_id"] as $e)
	   {
		$query = "UPDATE email_aliases SET status = 'activated', last_modified = '" . date("Y-m-d H:i:s") ."' WHERE email_alias_id = '" . $e . "' LIMIT 1";
		safe_query($query);
		$r++;	//add one to rows affected
	   }
	   $msg = $r . " row(s) were affected.<br>";
	   break;
	case "deactivate selected":
	   $r = 0; // rows affected so far
	   foreach($_POST["email_alias_id"] as $e)
	   {
		$query = "UPDATE email_aliases SET status = 'deactivated', last_modified = '" . date("Y-m-d H:i:s") ."' WHERE email_alias_id = '" . $e . "' LIMIT 1";
		safe_query($query);
		$r++;	//add one to rows affected
	   }
	   $msg = $r . " row(s) were affected.<br>";
	   break;
}

$where_clause = "";
$where_clause = $_GET["where_clause"];
if($_POST['seminar_event'] != "")
{
	and_where();
	$where_clause .= "seminar_event = '" . $_POST['seminar_event'] . "'";
}
if($_POST['status'] != "")
{
	and_where();
	$where_clause .= "status = '" . $_POST['status'] . "'";
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

	List of Supernova 2005 email aliases...<br>
	<br>
    </p>
<!-- START CONTENT -->
<form action="aliases.php" method="post">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="form_label">Status</td>
		<td class="form_label"></td>
		<td class="form_label"></td>
		</tr>
	<tr>
		<td><select name="status">
          	<option value="">Any Status</option>
          	<?php
	$query = "SELECT distinct status FROM email_aliases WHERE status IS NOT NULL";
	db_select_list($query, "status", "status", $_POST['status']);
	?>
          	</select>
			<input name="submit" type="submit" class="button" value="filter"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
	<tr>
		<td><input name="mode" type="submit" class="button" value="delete selected"> </td>
		<td><input name="mode" type="submit" class="button" value="activate selected"></td>
		<td><input name="mode" type="submit" class="button" value="deactivate selected"></td>
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
	//$where_clause = "WHERE email = '" . $_POST['email'] . "'";
	//$query = "select people.*, supernova_2005.seminar_event 
	$query = "select email_aliases.*, people.first, people.last
				from people JOIN email_aliases 
				ON people.ID = email_aliases.people_id" . $where_clause . " LIMIT 0 , 50";
	$result = safe_query($query);
//	echo $query;
	if ($result)
		{
			$i = 0;
			$class = " class=\"highlight\"";

			echo "<table>";
			echo <<<EOQ
			<tr>
				  <td class="form_label">&nbsp;</td>
				  <td class="form_label"><strong>Name</strong></td>
				  <td class="form_label"><strong>SN Email Alias</strong></td>
				  <td class="form_label" align="center"><strong>==></strong></td>				  
				  <td class="form_label"><strong>Real Email</strong></td>
				  <td class="form_label"><strong>Status</strong></td>				  
			</tr>
EOQ;
			while ($row = mysql_fetch_array($result)) 
			{
			//$bg_color = ($bg_color == '#d3e0f8') ? '#ffffff' : '#d3e0f8';  //TESTING
			$class = ($class == " class=\"highlight\"") ? "" : " class=\"highlight\"";
			$i++;
			$email_alias_id = $row["email_alias_id"];			
			$first = $row["first"];
			$last = $row["last"];
			$email_alias = $row["email_alias"];
			$real_email = $row["real_email"];
			$status = $row["status"];
			print <<<EOQ
				<tr$class>
				  <td class="form_label"><input type="checkbox" name="email_alias_id[]" value="$email_alias_id"></td>
				  <td class="form_label">$first $last</td>
				  <td class="form_label"><a href="mailto:$email_alias?subject=Registration">$email_alias</a></td>
				  <td class="form_label" align="center">==></td>
				  <td class="form_label"><a href="mailto:$real_email?subject=Registration">$real_email</a></td>
  				  <td class="form_label">$status</td>
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

