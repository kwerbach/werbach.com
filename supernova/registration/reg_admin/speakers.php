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
else
{
	$order_clause = " ORDER BY Last ASC";
}

?>
	<html>

<head>

<title>Speakers</title>
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
      <form action="speakers.php" method="post">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="31%" class="form_label">&nbsp;</td>
            <td width="23%" class="form_label">&nbsp;</td>
            <td width="23%" class="form_label">&nbsp;</td>
            <td width="23%" class="form_label">&nbsp;</td>
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
                  <option value="last" <?php am_selected('last',$order_by,'s'); ?>>Last</option>
                  <option value="date_registered" <?php am_selected('date_registered',$order_by,'s'); ?>>Date Registered</option>
                  <option value="company" <?php am_selected('company',$order_by,'s'); ?>>Company</option>
                  <option value="priority_code" <?php am_selected('priority_code',$order_by,'s'); ?>>Priority Code</option>

                </select>              <span class="style2">
                <input name="sort_dir" type="radio" value=""<?php am_selected('',$sort_dir,'r'); ?>>
        &#8593;
                <input name="sort_dir" type="radio" value="desc"<?php am_selected('desc',$sort_dir,'r'); ?>>
        &#8595; </span>
            </td>
            <td width="23%"><input name="submit" type="submit" class="button"></td>
            <td width="23%">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
      <strong>Speakers</strong><br><?php
	show_table("'speaker07','speaker08','speaker09','speaker10'");  // FIX
?>

<br>
<br>
<strong>Assistants</strong><br>
<?php
	show_table("'speak_asst'");
?>
    <!-- END CONTENT -->      <font face="verdana,arial" size="2">&nbsp;      </font></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
function show_table($in="''")
{
	global $where_clause;
	global $order_clause;
	global $reg_year;
	$where_clause_b4 = $where_clause;
	if($where_clause == "")		// NO WHERE CLAUSE
	{
		$where_clause = " WHERE seminar_year = '" . $reg_year . "' AND priority_code IN (" . $in. ")";
	}
	else
	{
		$where_clause .= " AND seminar_year = '" . $reg_year . "' AND priority_code IN (" . $in. ")";
	}
	// QUERY FOR DISPLAYING RESULTS
	//$where_clause = "WHERE email = '" . $_POST['email'] . "'";
	//$query = "select people.*, supernova_registrations.seminar_event 
	$people_fields = "people.ID,  people.user_id,  people.last,  people.first,  people.email,  people.title,  people.company,  people.address1,  people.address2,  people.city,  people.province,  people.zip,  people.country,  people.phone,  people.fax,  people.cellphone,  people.home_phone,  people.website, people.asst_email";

	$where_clause = str_replace("category","supernova_registrations.category",$where_clause); // "category n both tables"
	$query = "select $people_fields, supernova_registrations.*
				from people JOIN supernova_registrations 
				ON people.ID = supernova_registrations.people_id" 
				. $where_clause . $order_clause . " LIMIT 0 , 5000";

	$result = safe_query($query);
//	echo $query;  //TESTING
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
					<td class="form_label"><strong>Email</strong></td>
					<td class="form_label"><strong>Assistant</strong></td>
					<td class="form_label"><strong>&nbsp;</strong></td>
			</tr>
EOQ;
			while ($row = mysql_fetch_array($result)) 
			{
			//$bg_color = ($bg_color == '#d3e0f8') ? '#ffffff' : '#d3e0f8';  //TESTING
			$class = ($class == " class=\"highlight\"") ? "" : " class=\"highlight\"";
			$i++;
			$people_id 			= $row["people_id"];
			$first 				= $row["first"];
			$last 				= $row["last"];
			$company 			= $row["company"];
			$seminar_event 		= $row["seminar_event"];
			$showcase 			= $row["showcase"];
			$email 				= $row["email"];
			$asst_email 		= $row["asst_email"];			
			
			$priority_code 		= $row["priority_code"];
			$category 			= $row["category"];
			$amount 			= $row["amount"];
			$payment_received 	= $row["payment_received"];
			$date_registered 	= $row["date_registered"];
			$registration_id 	= $row["supernova_registration_id"];
			$title = "title=\"$first $last -> (PRIORITY CODE: $priority_code - CATEGORY: $category - AMOUNT: $amount - PAYMENT RECEIVED: $payment_received - DATE REGISTERED: $date_registered) - REG ID: $registration_id)\"";
			
			print <<<EOQ
				<tr$class $title valign="top">
				  <td class="form_label"><a href="details_edit.php?people_id=$people_id">details</a></td>
				  <td class="form_label">$first</td>
				  <td class="form_label">$last</td>
				  <td class="form_label">$company</td>
				  <td class="form_label"><a href="mailto:$email?subject=Supernova">$email</a></td>
  				  <td class="form_label">$asst_email</td>
				  <td class="form_label" nowrap>[<a href="#" onclick="delete_item('$people_id','$registration_id')">delete</a>]</td>
				</tr>
EOQ;
			}
			echo "</table><br />";
			mysql_free_result($result);
		}
		$where_clause = $where_clause_b4;
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
