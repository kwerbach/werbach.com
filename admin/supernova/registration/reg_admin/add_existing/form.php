<?php
require "../../inc_db.php";
require "../inc_forms.php";
$reg_year = "2008";
dbconnect();
if ($_POST['submit'] != "")
{
	if($_POST['last'] != "")
	{
		and_where();
		$where_clause .= 'last LIKE \'' . $_POST["last"] . '%\'';
	}
	if($_POST['company'] != "")
	{
		and_where();
		$where_clause .= "company LIKE '" . $_POST['company'] . "%'";
	}
}
else
	{
	$where_clause .= 'last LIKE \'a%\'';
	}	

if ($where_clause != "")
{
	$where_clause = "WHERE " . $where_clause ;
}

?>
	<html>

<head>

<title>Supernova <?php echo $reg_year ?></title>
<style type="text/css">
a:link { color:blue; text-decoration: none }
a:visited { color:blue; text-decoration: none }
a:hover { text-decoration: underline }
</style>

<link href="../../../register.css" rel="stylesheet" type="text/css">
<script language="javascript">
function calc_category()
{
	if(document.form1.priority_code.value == "")
	{
		document.form1.category.value = "attendee";
	}
	else
	{
		switch (document.form1.priority_code.value.toLowerCase()) 
		{ 
			
			<?php write_priority_codes(); ?>
			default : 
				document.form1.category.value = "attendee";
		} 
	}
	return true;
}
</script>
</head>

<body>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td>&nbsp;</td>
    <td valign="top"> <font face="verdana,arial" size="2">&nbsp;
      </font>
      <p>
        <!-- START CONTENT -->
      </p>
      <form action="handle.php" method="post" name="form1" target="middleFrame" onSubmit="return calc_category();">
        <table width="600"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="form_label">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">              <table width="100%" >
                <tr>
                  <td><span class="form_label">Prioity Code</span></td>
                  <td>Payment Received</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><select name="priority_code" id="priority_code">
                    <?php
		$query = "SELECT priority_code, CONCAT(priority_code, ' ($', price, ')') AS price FROM sn_priority_codes WHERE for_event = 'supernova" . $reg_year . "' ORDER BY priority_code";
		db_select_list($query, "priority_code", "price", $_COOKIE["priority"]);
		?>
                  </select></td>
                  <td><input name="payment_received" type="radio" value="yes" checked="checked">
yes 
  <input name="payment_received" type="radio" value="no"> 
  no
  <input name="payment_received" type="radio" value="n/a"> 
  n/a</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td class="form_label">People: </td>
          </tr>
          <tr valign="top">
            <td><select name="people[]" size="10" multiple id="people[]">
                <?php
	$query = "SELECT ID, CONCAT(last,', ',first, ' (', company, ')') AS name FROM people " . $where_clause . ' ORDER BY last, first, company';

//	$query = "SELECT ID, CONCAT(last,', ',first, ' (', LEFT(company, 10), '...)') AS name FROM people " . $where_clause . ' ORDER BY last,company';
	db_select_list($query, "ID", "name", "");
	?>
              </select>
                <span class="form_label"> </span></td>
          </tr>
          <tr>
            <td><span class="form_label"></span></td>
          </tr>
          <tr>
            <td>
              <input name="submit" type="submit" class="button" value="(2) Add to Supernova <?php echo $reg_year; ?>">            </td>
          </tr>
        </table>
      </form>
      <!-- END CONTENT -->
    <p><font face="verdana,arial" size="2">      </font></p></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
function write_priority_codes()
{
	$where_clause = "WHERE for_event = 'supernova2006'";
	$query = "select priority_code, price, category from sn_priority_codes " . $where_clause;
	$result = safe_query($query);
	if ($result)
		{
			while ($row = mysql_fetch_array($result)) 
			{
			$priority_code = strtolower($row["priority_code"]);
			$category = $row["category"];
			echo <<<EOQ
			case "$priority_code" : \n  \t \t \t \t
				document.form1.category.value = "$category"; \t \t \t \t
				break; \n \t \t \t
EOQ;
			}
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


