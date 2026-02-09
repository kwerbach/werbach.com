<?php
require "../inc_db.php";
require "inc_forms.php";
$reg_year = "2008";
	dbconnect();

$where_clause = "";
$where_clause = $_GET["where_clause"];
if($_POST['seminar_event'] != "")
{
	and_where();
	$where_clause .= "seminar_event = '" . $_POST['seminar_event'] . "'";
}
if($_POST['priority_code'] != "")
{
	and_where();
	$where_clause .= "priority_code = '" . $_POST['priority_code'] . "'";
}

if($_POST['showcase'] != "")
{
	and_where();
	$where_clause .= "showcase = '" . $_POST['showcase'] . "'";
}

if($_POST['payment_method'] != "")
{
	and_where();
	$where_clause .= "payment_method = '" . $_POST['payment_method'] . "'";
}

if($_POST['payment_received'] != "")
{
	and_where();
	$where_clause .= "payment_received = '" . $_POST['payment_received'] . "'";
}

if($_POST['category'] != "")
{
	and_where();
	$where_clause .= "category = '" . $_POST['category'] . "'";
}

if($_POST['start_date'] != "")
{
	and_where();
	
	list($month, $day, $year ) = split( "/", $start_date );
	$start_date  = date("Y-m-d", mktime(0, 0, 0, $month  , $day, $year));
	$where_clause .= "supernova_registrations.last_modified >= '" . $start_date . "'";
}
else
{
	list($month, $day, $year ) = split( "/", $start_date );
	$start_date = mktime(0, 0, 0, date("m")  , date("d")-8, date("Y"));
}


if($_POST['end_date'] != "")
{
	and_where();
	list($month, $day, $year ) = split( "/", $end_date );
	$end_date  = date("Y-m-d", mktime(0, 0, 0, $month  , $day+1, $year));
	$where_clause .= "supernova_registrations.last_modified < '" . $end_date . "'";
}
else
{
	$end_date  = date("m/d/Y");
}




if ($where_clause != "")
{
	//$where_clause = " WHERE " . $where_clause;
	$where_clause = ($_GET["where_clause"] == "") ? " WHERE " . $where_clause : " " . $where_clause;
}

if($_POST['order_by'] != "")
{
	$order_clause = " ORDER BY " .  $_POST['order_by'] . " " . $_POST['sort_dir'];
}

?>
	<html>

<head>

<title>Attendees</title>
<style type="text/css">
a:link { color:blue; text-decoration: none }
a:visited { color:blue; text-decoration: none }
a:hover { text-decoration: underline }
</style>

<link href="../register.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style2 {font-size: 11px}
-->
</style>
<script language="javascript">
// WILL DELETE AN ITEM FROM A TABLE BASED ON ID
function delete_item(p_id, del_id)
{

	var answer = null;
	answer = prompt("type \"y\" to delete: " + name, "");
	
	if (answer == 'y' || answer == 'Y') 
	{
		str_current_loc		= document.location.pathname + document.location.search
		str_new_loc 		= 'attendee_delete.php?n=' + str_current_loc + '&i=' + del_id + '&p=' + p_id
		document.location 	= str_new_loc
	}
}
</script>
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
    <br>
          <br>
      </p>
      <!-- START CONTENT -->
      <form action="attendees.php" method="post">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="31%" class="form_label">Seminar Event</td>
            <td width="23%" class="form_label">Showcase</td>
            <td width="23%" class="form_label">Priority Code</td>
            <td width="23%" class="form_label">Category</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="31%"><select name="seminar_event">
                <option value="">Any Seminar Event</option>
                <?php
	$query = "SELECT distinct seminar_event FROM supernova_registrations WHERE seminar_event IS NOT NULL ORDER BY seminar_event";
	db_select_list($query, "seminar_event", "seminar_event", $_POST['seminar_event']);
	?>
            </select></td>
            <td width="23%"><select name="showcase">
                <option value="">Any Showcase</option>
                <?php
	$query = "SELECT distinct showcase FROM supernova_registrations WHERE showcase IS NOT NULL";
	db_select_list($query, "showcase", "showcase", $_POST['showcase']);
	?>
            </select></td>
            <td width="23%"><select name="priority_code">
                <option value="">Any Priority Code</option>
                <?php
	$query = "SELECT distinct priority_code FROM supernova_registrations WHERE priority_code IS NOT NULL ORDER BY priority_code";
	db_select_list($query, "priority_code", "priority_code", $_POST['priority_code']);
	?>
            </select></td>
            <td width="23%"><select name="category">
                <option value="">Any Category</option>
                <?php
	$query = "SELECT distinct category FROM supernova_registrations WHERE category IS NOT NULL ORDER BY category";
	db_select_list($query, "category", "category", $_POST['category']);
	?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="31%">&nbsp;</td>
            <td width="23%">&nbsp;</td>
            <td width="23%">&nbsp;</td>
            <td width="23%">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="31%" class="form_label"> Payment Method </td>
            <td width="23%" class="form_label">Payment Received </td>
            <td width="23%"><span class="form_label">Registered After </span></td>
            <td width="23%"><span class="form_label">Registered Before</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="31%"><select name="payment_method" id="payment_method">
                <option value="">Payment Method</option>
                <?php
	$query = "SELECT distinct payment_method FROM supernova_registrations WHERE payment_method IS NOT NULL ORDER BY payment_method";
	db_select_list($query, "payment_method", "payment_method", $_POST['payment_method']);
	?>
            </select></td>
            <td width="23%"><select name="payment_received" id="payment_received">
                <option value="">Payment Received</option>
                <?php
	$query = "SELECT distinct payment_received FROM supernova_registrations WHERE payment_received IS NOT NULL ORDER BY payment_received";
	db_select_list($query, "payment_received", "payment_received", $_POST['payment_received']);
	?>
            </select></td>
            <td width="23%"><select name="start_date">
                <option value="">Any Date</option>
                <?php	
		$reg_start = getdate(mktime(0, 0, 0, 1, 11, 2007));
		$reg_end = getdate(mktime(0, 0, 0, 7, 1, 2007));
		$reg_days = floor(($reg_end[0] - $reg_start[0]) / 86400); // day difference
		
		for($i= -10;$i < $reg_days+10; $i++)
		{
			
			$selected = "";
			$tomorrow = date("m/d/Y", mktime(0, 0, 0, 2, 16+$i, $reg_year));
			$selected = ($tomorrow == $_POST['start_date']) ? " selected=\"true\"" : "";
			echo "<option value=\"" . $tomorrow . "\"" . $selected .">". $tomorrow . "</option>\n";
		}
?>
            </select></td>
            <td width="23%"><select name="end_date" id="select">
                <option value="">Any Date</option>
                <?php	
		for($i= $reg_days + 7;$i > 0; $i--)  // 10 DAYS BEFORE THE START OF REGISTEING
		{
			
			$selected = "";
			$yesterday = date("m/d/Y", mktime(0, 0, 0, 6, 25-$i, $reg_year));
			$selected = ($yesterday == $_POST['end_date']) ? " selected=\"true\"" : "";
			echo "<option value=\"" . $yesterday . "\"" . $selected .">". $yesterday . "</option>\n";
		}
?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="31%">&nbsp;</td>
            <td width="23%">&nbsp;</td>
            <td width="23%">&nbsp;</td>
            <td width="23%">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><span class="form_label">Sort by:</span>
                <select name="order_by">
                  <option value="date_registered" <?php am_selected('date_registered',$order_by,'s'); ?>>Date Registered</option>
                  <option value="company" <?php am_selected('company',$order_by,'s'); ?>>Company</option>
                  <option value="last" <?php am_selected('last',$order_by,'s'); ?>>Last</option>
                  <option value="seminar_event" <?php am_selected('seminar_event',$order_by,'s'); ?>>Seminar Event</option>
                  <option value="showcase" <?php am_selected('showcase',$order_by,'s'); ?>>Showcase</option>
                  <option value="amount" <?php am_selected('amount',$order_by,'s'); ?>>Amount</option>
                  <option value="priority_code" <?php am_selected('priority_code',$order_by,'s'); ?>>Priority Code</option>
                  <option value="category" <?php am_selected('category',$order_by,'s'); ?>>Category</option>
                </select>
                <span class="style2">
                <input name="sort_dir" type="radio" value=""<?php am_selected('',$sort_dir,'r'); ?>>
        &#8593;
                <input name="sort_dir" type="radio" value="desc"<?php am_selected('desc',$sort_dir,'r'); ?>>
        &#8595; </span>
                <input name="submit" type="submit" class="button"></td>
            <td width="23%">&nbsp;</td>
            <td width="23%">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
      <?php
	show_table();
?>
    <!-- END CONTENT -->      <font face="verdana,arial" size="2">&nbsp;      </font></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
function show_table()
{
	global $where_clause;
	global $order_clause;
	global $reg_year;
	if($where_clause == "")		// NO WHERE CLAUSE
	{
		$where_clause = " WHERE seminar_year = '" . $reg_year . "'";
	}
	else
	{
		$where_clause .= " AND seminar_year = '" . $reg_year . "'";
	}
	// QUERY FOR DISPLAYING RESULTS
	//$where_clause = "WHERE email = '" . $_POST['email'] . "'";
	//$query = "select people.*, supernova_registrations.seminar_event 
	$people_fields = "people.ID,  people.user_id,  people.last,  people.first,  people.email,  people.title,  people.company,  people.address1,  people.address2,  people.city,  people.province,  people.zip,  people.country,  people.phone,  people.fax,  people.cellphone,  people.home_phone,  people.website";

	$where_clause = str_replace("category","supernova_registrations.category",$where_clause); // "category n both tables"
	$query = "select $people_fields, supernova_registrations.*
				from people JOIN supernova_registrations 
				ON people.ID = supernova_registrations.people_id" 
				. $where_clause . $order_clause . " LIMIT 0 , 5000";

	$result = safe_query($query);
//	echo "<!-- \n\n\n" . $query . "\n\n\n -->";	// TESTING
	$n_rows = mysql_num_rows($result);

	if ($result)
		{
			$i = 0;
			echo "Query returned <strong><u>$n_rows</u></strong> records - ";
			echo "<a href=\"download.php?where_clause=$where_clause\" title=\"where_clause=$where_clause\">Download Current List</a><br /><br />";  //TESTING

//			echo "<a href=\"download.php?where_clause=$where_clause\" title=\"where_clause=$where_clause\">Download Current List</a><br /><br />";
			echo "<table width=\"100%\">";
			echo <<<EOQ
			<tr>
				  <td class="form_label">&nbsp;</td>
				  <td class="form_label"><strong>First</strong></td>
				  <td class="form_label"><strong>Last</strong></td>
				  <td class="form_label"><strong>Company</strong></td>
				  <td class="form_label"><strong>Price</strong></td>
				  <td class="form_label"><strong>Seminar Event</strong></td>
				  <td class="form_label"><strong>Payment Received</strong></td>
				<td class="form_label"><strong>Email</strong></td>
			</tr>
EOQ;
			while ($row = mysql_fetch_array($result)) 
			{
			//$bg_color = ($bg_color == '#d3e0f8') ? '#ffffff' : '#d3e0f8';  //TESTING
			$class = ($class == " class=\"highlight\"") ? "" : " class=\"highlight\"";
			$i++;
			$supernova_registration_id = $row["supernova_registration_id"]; 
			$people_id 			= $row["people_id"];
			$first 				= $row["first"];
			$last 				= $row["last"];
			$company 			= $row["company"];
			$seminar_event 		= $row["seminar_event"];
			$showcase 			= $row["showcase"];
			$email 				= $row["email"];
			
			$priority_code 		= $row["priority_code"];
			$category 			= $row["category"];
			$amount 			= $row["amount"];
			$payment_received 	= $row["payment_received"];
			$date_registered 	= $row["date_registered"];
			$registration_id 	= $row["supernova_registration_id"];
			$title = "title=\"$first $last -> (PRIORITY CODE: $priority_code - CATEGORY: $category - AMOUNT: $amount - PAYMENT RECEIVED: $payment_received - DATE REGISTERED: $date_registered) - REG ID: $registration_id)\"";
			
			print <<<EOQ
				<tr$class $title>
				  <td class="form_label"><a href="details_edit.php?people_id=$people_id&supernova_registration_id=$supernova_registration_id">details</a></td>
				  <td class="form_label">$first</td>
				  <td class="form_label">$last</td>
				  <td class="form_label">$company</td>
				  <td class="form_label" align="right">$$amount</td>
				  <td class="form_label">$seminar_event</td>
				  <td class="form_label" align="center">$payment_received</td>
				  <td class="form_label"><a href="mailto:$email?subject=Supernova">$email</a></td>
				  <td class="form_label" nowrap>[<a href="#" onclick="delete_item('$people_id','$registration_id')">delete</a>]</td>
				</tr>
EOQ;
			}
			echo "</table><br />";
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
