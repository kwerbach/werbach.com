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

if($_POST['for_event'] != "")
{
	and_where();
	$where_clause .= "for_event = '" . $_POST['for_event'] . "'";
}

if ($where_clause != "")
{
	//$where_clause = " WHERE " . $where_clause;
	$where_clause = ($_GET["where_clause"] == "") ? " WHERE " . $where_clause : " " . $where_clause;
}



?>
	<html>

<head>

<title>Supernova - Email Aliases</title>
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
      <!-- START CONTENT -->
</font>
      <p>List of Supernova email aliases...<br>
          <br>
      </p>
      <!-- START CONTENT -->
      <form action="aliases.php" method="post">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="form_label">Status</td>
            <td class="form_label">Event</td>
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
            </td>
            <td><select name="for_event">
                <option value="">Any Event</option>
                <?php
	$query = "SELECT distinct for_event FROM email_aliases WHERE for_event IS NOT NULL ORDER BY for_event DESC";
	db_select_list($query, "for_event", "for_event", $_POST['for_event']);
	?>
            </select></td>
            <td><input name="submit" type="submit" class="button" value="filter"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input name="mode" type="submit" class="button" value="delete selected">
            </td>
            <td><input name="mode" type="submit" class="button" value="activate selected"></td>
            <td><input name="mode" type="submit" class="button" value="deactivate selected"></td>
          </tr>
        </table>
        <?php
	show_table();
?>
      </form>
      <!-- END CONTENT -->
    <font face="verdana,arial" size="2">&nbsp;      </font></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
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
				ON people.ID = email_aliases.people_id" . $where_clause . " LIMIT 0 , 1000";
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
			$email_alias_id 	= $row["email_alias_id"];			
			$first 				= $row["first"];
			$last 				= $row["last"];
			$email_alias 		= $row["email_alias"];
			$real_email 		= $row["real_email"];
			$status 			= $row["status"];
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