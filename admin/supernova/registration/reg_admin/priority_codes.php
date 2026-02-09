<?php
require "../inc_db.php";
require "inc_forms.php";
$reg_year = "2008";
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
		$query = "INSERT INTO sn_priority_codes (priority_code, category, description, price, for_event, seminar_event) VALUES ('" . sqlize($_POST["add_priority_code"]) . "', '" . sqlize($_POST["add_category"]) . "', '" . sqlize($_POST["add_description"]) . "', '" . $_POST["add_price"] . "', 'supernova" . $reg_year . "','" . sqlize($_POST["add_seminar_event"]) . "')";
		safe_query($query);
		break;
	case "update":
		$update_sql_price 		= ($_POST["update_price"] == "") 		? "" : "price = '" . $_POST["update_price"] . "', ";
		$update_sql_category 	= ($_POST["update_category"] == "") 	? "" : "category = '" . sqlize($_POST["update_category"]) . "', ";
		$update_sql_description	= ($_POST["update_description"] == "") 	? "" : "description = '" . sqlize($_POST["update_description"]) . "', ";				
		$update_sql_sem_event 	= ($_POST["update_seminar_event"] == "") 	? "" : "seminar_event = '" . sqlize($_POST["update_seminar_event"]) . "', ";

//		$query = "UPDATE sn_priority_codes SET price = '" . $_POST["update_price"] . "', category = '" . $_POST["update_category"] . "', last_modified = '" . date("Y-m-d H:i:s") ."' WHERE priority_code_id = '" . $_POST["update_priority_code"] . "' LIMIT 1";
		$query = "UPDATE sn_priority_codes SET " . $update_sql_price . $update_sql_category . $update_sql_description  . $update_sql_sem_event . " last_modified = '" . date("Y-m-d H:i:s") ."' WHERE priority_code_id = '" . $_POST["update_priority_code"] . "' LIMIT 1";
		safe_query($query);
		break;
		
	
}
$where_clause = "";
$where_clause = $_GET["where_clause"];

if($_POST['for_event'] != "")
{
	and_where();
	$where_clause .= "for_event = '" . $_POST['for_event'] . "'";
}

if($_POST['category'] != "")
{
	and_where();
	$where_clause .= "category = '" . sqlize($_POST['category']) . "'";
}

if ($where_clause != "")
{
	//$where_clause = " WHERE " . $where_clause;
	$where_clause = ($_GET["where_clause"] == "") ? " WHERE " . $where_clause : " " . $where_clause;
}



?>
	<html>

<head>

<title>Supernova - Priority Codes</title>
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
      <p>Manage priority codes, categories, and prices...<br>
        <br>
</p>
      <!-- START CONTENT -->
      <form action="priority_codes.php" method="post">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="form_label">Priority Code </td>
            <td class="form_label">Category</td>
            <td class="form_label">Description</td>
            <td class="form_label">Price</td>
            <td class="form_label">Package</td>
            <td class="form_label"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="form_label"><input name="add_priority_code" type="text" id="add_priority_code" size="10" maxlength="25"></td>
            <td class="form_label"><input name="add_category" type="text" id="add_category" size="12" maxlength="25"></td>
            <td class="form_label"><input name="add_description" type="text" id="add_description" size="14" maxlength="25"></td>
            <td class="form_label">$
                <input name="add_price" type="text" id="add_price" size="8" maxlength="8"></td>
            <td class="form_label"><select name="add_seminar_event" id="add_seminar_event">
                    <option value="Full Conference" selected>Full</option>
                    <option value="2-day Main Conference">2-Day</option>
                    <option value="Wharton West Challenge Day">Wharton Day</option>
                    <option value="Gala">Gala</option>
                    <option value="Wharton Reception">WW Reception</option>
                  </select></td>
            <td class="form_label"><input name="mode" type="submit" class="button" id="mode" value="add"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="form_label">&nbsp;</td>
            <td class="form_label"></td>
            <td class="form_label"></td>
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
            <td class="form_label"><input name="update_category" type="text" id="update_category" size="12" maxlength="25"></td>
            <td class="form_label"><input name="update_description" type="text" id="update_description" size="14" maxlength="25"></td>
            <td class="form_label">$
                <input name="update_price" type="text" id="update_price" size="8" maxlength="8"></td>
            <td class="form_label"><select name="update_seminar_event" id="update_seminar_event">
              <option value="Full Conference" selected>Full</option>
              <option value="2-day Main Conference">2-day</option>
              <option value="Wharton West Challenge Day">Wharton Day</option>
                                  <option value="Gala">Gala</option>
                    <option value="Wharton Reception">WW Reception</option>
            </select></td>
            <td class="form_label"><input name="mode" type="submit" class="button" id="mode" value="update"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="form_label">&nbsp;</td>
            <td class="form_label"></td>
            <td class="form_label"></td>
            <td class="form_label"></td>
            <td class="form_label"></td>
            <td class="form_label"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="form_label">Category</td>
            <td class="form_label">Event</td>
            <td class="form_label"></td>
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
            </td>
            <td><select name="for_event">
                <option value="">Any Event</option>
                <?php
	$query = "SELECT distinct for_event FROM sn_priority_codes WHERE for_event IS NOT NULL ORDER BY for_event DESC";
	db_select_list($query, "for_event", "for_event", $_POST['for_event']);
	?>
            </select></td>
            <td>&nbsp;</td>
            <td><input name="submit" type="submit" class="button" value="filter"></td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><input name="mode" type="submit" class="button" value="delete selected"></td>
            <td>&nbsp;</td>
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
    <p><font face="verdana,arial" size="2">      </font></p></td>
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
				  <td class="form_label"><strong>Description</strong></td>
				  <td class="form_label"><strong>Price</strong></td>
				  <td class="form_label"><strong>Event</strong></td>
				  <td class="form_label"><strong>Seminar Event</strong></td>				  
			</tr>
EOQ;
			while ($row = mysql_fetch_array($result)) 
			{
			$class = ($class == " class=\"highlight\"") ? "" : " class=\"highlight\"";
			$i++;
			$priority_code_id 	= $row["priority_code_id"];
			$priority_code 		= $row["priority_code"];
			$category 			= $row["category"];
			$description 		= $row["description"];
			$price 				= $row["price"];
			$for_event 			= $row["for_event"];
			$seminar_event 		= $row["seminar_event"];			
			print <<<EOQ
				<tr$class>
				  <td class="form_label"><input type="checkbox" value="$priority_code_id" name="priority_code_id[]"></td>
				  <td class="form_label">$priority_code</td>
				  <td class="form_label">$category</td>
				  <td class="form_label">$description</td>
				  <td class="form_label" align="right">$$price</td>
				  <td class="form_label">$for_event</td>
				  <td class="form_label">$seminar_event</td>				  
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