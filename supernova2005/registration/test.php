<?php
require "inc_db.php";
dbconnect();

$query = "UPDATE email_aliases SET status = 'abc', last_modified = '" . date("Y-m-d H:i:s") ."' WHERE email_alias_id = '00060' LIMIT 1";
safe_query($query);
echo strtoupper(substr($_POST["last"] . $_POST["first"] . $_POST["email"] , 0, 3)) . rand(1111,9999);

show_table();

function show_table()
{
	echo "<hr>";
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
?>