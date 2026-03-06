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

<link href="../../register.css" rel="stylesheet" type="text/css">
<script language="javascript">
function calc_category()
{
	if(document.form1.priority_code.value == "")
	{
		document.form1.category.value = "regular";
	}
	else
	{
		switch (document.form1.priority_code.value.toLowerCase()) 
		{ 
			
			<?php write_priority_codes(); ?>
			default : 
				document.form1.category.value = "regular";
		} 
	}
}
</script>
</head>

<body bgcolor="#380169" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">


<table border="0" cellpadding="0" cellspacing="0">

<tr>
<td width="42" background="../../../images/background_left.gif"></td>
<td width="780" rowspan="2" bgcolor="#FFFFFF">	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="17" height="100%"></td>
	<td valign="top">
	<p>
	  <!-- START CONTENT -->
</p>
<form action="handle.php" method="post" name="form1" target="middleFrame">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td class="form_label">Prioity Code </td>
	  </tr>
	<tr>
	  <td valign="top"><select name="priority_code" id="priority_code" onchange="calc_category();">
          <option value="">none</option>
          <?php
	$query = "SELECT distinct priority_code FROM sn_priority_codes ORDER BY priority_code";
	db_select_list($query, "priority_code", "priority_code", $_COOKIE["priority"]);
	?>
      </select></td>
	  </tr>
	<tr>
		<td class="form_label">People: </td>
		</tr>
	<tr valign="top">
		<td><select name="people[]" size="15" multiple id="people[]">
          	<?php
	$query = "SELECT ID, CONCAT(last,', ',first, ' (', company, ')') AS name FROM people " . $where_clause . ' ORDER BY last, first, company';

//	$query = "SELECT ID, CONCAT(last,', ',first, ' (', LEFT(company, 10), '...)') AS name FROM people " . $where_clause . ' ORDER BY last,company';
	db_select_list($query, "ID", "name", "");
	?>
          	</select>
		  <span class="form_label">
		  </span></td>
		</tr>
	<tr>
	  <td><span class="form_label"></span></td>
	  </tr>
	<tr>
	  <td>
	  	<input type="hidden" name="category" id="category" value="regular">
		<input name="submit" type="submit" class="button" value="(2) Add to Supernova 2005">
	  </td>
	  </tr>
</table>

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
        <td width="373"><font face="verdana,arial" size="1" color="#7E7E7E"> &copy;2005 Supernova Group LLC </font></td>
        <td width="273"><img src="../../../images/bottommiddle.gif" width="273" height="31" alt=""></td>
      </tr>
      <tr>
        <td colspan="3"><img src="../../../images/bottom.gif" width="780" height="52" alt=""></td>
      </tr>
    </table></td>

<td width="42" rowspan="2" background="../../../images/background_right.gif"></td>
</tr>
<tr>
  <td background="../../../images/background_left.gif"></td>
</tr>

</table>

</html>
<?php
function write_priority_codes()
{
	$where_clause = "WHERE for_event = 'supernova2005'";
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


