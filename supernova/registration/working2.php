<title>WORKING</title><?php
require "inc_db.php";
dbconnect();

// CHANGE SWAP FIRST AND LAST
$query = 'SELECT * '
        . ' FROM people'
        . ' WHERE ID'
        . ' IN ( '
        . ' SELECT people_id'
        . ' FROM supernova_registrations'
        . ' WHERE `last_modified` = \'2008-05-28 18:18:18\' ) AND ID >=79976';
/*		
$query = 'SELECT * '
        . ' FROM people'
        . ' WHERE ID'
        . ' IN ( '
        . ' SELECT people_id'
        . ' FROM supernova_registrations'
        . ' WHERE `last_modified` = \'2008-05-28 18:18:18\' ) AND ID =79976';	
*/		
$query  = 'UPDATE `people` SET `user_id` = UCASE( user_id ) ,'
        . ' `middle` = first,'
        . ' `first` = last,'
        . ' `last` = middle,'	
        . ' `middle` = \'\','				
        . ' `last_modified` = \'2008-05-29 18:18:18\' WHERE `last_modified` = \'2008-05-28 18:18:18\' ) AND `ID` > \'79984\' AND  `ID` <= \'79994\' LIMIT 1 ;'
        . ' '; 

	
echo $query."<hr/>";
//$result = safe_query($query);

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
		echo $dataToWrite;
		}
		mysql_free_result($result);

/*
	$query = "SELECT * FROM temp_working_table WHERE People_Id = 0";
	$result = safe_query($query);
	echo "<hr/>";
	while ($row = mysql_fetch_array($result))
	{
		echo $row["People_Id"]."<hr/>";
	}



//////////////////////////////////////////////////////////////

	$query = "INSERT INTO people (last, first, company, email,  created_on, last_modified) VALUES
				SELECT first_name, last_name, company, email, '2008-05-28 18:18:18', '2008-05-28 18:18:18' FROM temp_working_table WHERE People_Id = 0";
	$result = safe_query($query);


///////////////////////////////////////////

	$query = "SELECT * FROM people WHERE created_on = '2008-05-28 18:18:18'";
	$result = safe_query($query);
	echo "<hr/>";
	while ($row = mysql_fetch_array($result))
	{
		echo $row["ID"]."<hr/>";
	}
*/
/*
// EXPORT SOMTHNG TO CSV
$query = 'SELECT p.ID, p.last, p.first, p.email, p.company'
        . ' FROM people p'
        . ' WHERE p.ID'
        	. ' IN ( '
        . ' SELECT DISTINCT people_id'
        . ' FROM `people_tags` '
        . ' WHERE tag'
        	. ' IN ( \'2005 Attendee\', \'2006 Attendee\', \'2007 Attendee\' ) AND people_id NOT '
       		. ' IN ( '
        		. ' SELECT people_id'
        		. ' FROM supernova_registrations'
        		. ' WHERE seminar_year = \'2008\' OR category = \'press\' ) ) AND p.out_out !=1';

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
		echo $dataToWrite;
		}
		mysql_free_result($result);
*/
?>
