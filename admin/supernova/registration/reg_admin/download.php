<?php
require "../inc_db.php";
dbconnect();
?>
	<html>

<head>

<title>Supernova - Download</title>
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
      <p>Download attendee list... <br>
        <br>
</p>
      <!-- START CONTENT -->
      <table>
        <?php
	write_to_csv();
?>
      </table>
      <!-- END CONTENT -->
    <p><font face="verdana,arial" size="2">      </font></p></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
function write_to_csv()
{
	$bg_color = '#d3e0f8';
	// QUERY FOR DISPLAYING RESULTS
	$where_clause = stripslashes($_GET['where_clause']);
	
	$query = "SELECT people.* , supernova_registrations.*, email_aliases.email_alias
				FROM people
				JOIN supernova_registrations ON people.ID = supernova_registrations.people_id
				JOIN email_aliases ON people.ID = email_aliases.people_id" . $_GET['where_clause'];	
			
				$today = getdate() ;
				$for_event = 'Supernova ' . $today['year'];				
				if ($_GET['where_clause'] == "")
				{
					$query .= " WHERE email_aliases.for_event = '" . $for_event . "'";
				}
				else 
				{
					$query .= " AND email_aliases.for_event = '" . $for_event . "'";
				}
//	echo $query;	 // TESTING
	$result = safe_query($query);
	if ($result)
		{
			for ($i=0; $i < mysql_num_fields($result); $i++) 	// Table Header
			{ 
				$dataToWrite .= "\"" . mysql_field_name($result, $i)."\","; 
			}
			$dataToWrite = trim($dataToWrite,",");
			$dataToWrite .= "\r\n";
			$fields=mysql_num_fields($result);
			while ($row = mysql_fetch_row($result)) 			// Table body
			{ 
				for ($f=0; $f < $fields; $f++) 
				{
					$dataToWrite .= "\"" . $row[$f] . "\","; 
				}
				$dataToWrite = trim($dataToWrite,",");
				$dataToWrite .= "\r\n";
			}
		
		
			mysql_free_result($result);

			$fileName = "data2.csv";
			$filePointer = fopen($fileName,"w");
			$dataToWrite = stripslashes($dataToWrite); 
			fwrite($filePointer, "$dataToWrite\n");
			fclose($filePointer);
		
			print <<<EOQ
				<tr$class>
				  <td colspan="5" class="form_label">To save your file: right-click <a href="$fileName">HERE</a> > Save Target As...</td>
				</tr>
EOQ;
	
		}
		else // no rows to down load
		{
			
			print <<<EOQ
				<tr$class>
				  <td colspan="5" class="form_label">File contains <b>0</b> records!</td>
				</tr>
EOQ;

		}

		echo $query = "<!-- select people.*, supernova_2005.*
				from people JOIN supernova_2005 
				ON people.ID = supernova_2005.people_id" . $_GET['where_clause'] . " -->";


}
?>