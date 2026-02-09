
<?php
require "inc_db.php";
require "inc_forms.php";
if ($_POST['email'] != "")
{
	dbconnect();
		
	// QUERY FOR DISPLAYING RESULTS

	$where_clause = "WHERE email = '" . $_POST['email'] . "'";
	$query = "select * from people " . $where_clause . " LIMIT 0 , 1";
	$result = safe_query($query);
	if ($result)
	{
			while ($row = mysql_fetch_array($result)) 
			{
				$first = $row["first"];
				$last = $row["last"];
				$email = $row["email"];
				print <<<EOQ
					<table>
						<tr bgcolor="$bg_color">
						  <td>$first</td>
						  <td>$last</td>
						  <td>$email</td>
						</tr>
					</table>
					
EOQ;
			}
			echo "Hi";
			mysql_free_result($result);
		}
		else
		{
			echo "no results!";
		}
}
else
{
	echo "no email!";
}

?>