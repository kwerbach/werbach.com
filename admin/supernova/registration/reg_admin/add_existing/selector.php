<?php
require "../../inc_db.php";
require "../inc_forms.php";
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

<title>Supernova 2005</title>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
    <td><img src="../../../images_reg/supernova1.jpeg" width="200" height="109"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
	<?php require "../navig_reg_admin_child.php"; ?>
	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top"> <font face="verdana,arial" size="2">&nbsp;
      </font>
      <p></p>
        <!-- START CONTENT -->
	<form action="form.php" method="post" name="form1" target="bottomFrame" id="form1">
      <table width="400" border="0" cellpadding="0">
        <tr>
          <td nowrap="nowrap"><span class="form_label">Last name starts with:</span></td>
          <td><input type="text" name="last" /></td>
        </tr>
        <tr>
          <td nowrap="nowrap"><span class="form_label">Company starts with: </span></td>
          <td><input type="text" name="company" /></td>
        </tr>
        <tr>
          <td nowrap="nowrap">&nbsp;</td>
          <td><input name="submit" type="submit" class="button" id="submit" value="(1) Show names" /></td>
        </tr>
      </table>
	  </form>
        <!-- END CONTENT -->
    
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
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


