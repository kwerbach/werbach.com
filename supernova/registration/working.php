<?php
/*
require "inc_db.php";
dbconnect();

// SEE WHO IS IN THE PEOPLE TABLE /////////////////////////////
	echo "SEE WHO IS IN THE PEOPLE TABLE<br/>";
	$query = "UPDATE temp_working_table t INNER JOIN people p ON t.email = p.email SET t.people_id = p.id, t.user_id = p.user_id;";
	$result = safe_query($query);
	echo $query;
	echo "<br/>";
	
// HOW MANY ARE NOT IN /////////////////////////////////////
	echo "HOW MANY ARE NOT IN<br/>";
	$query = "SELECT * FROM temp_working_table  WHERE People_Id = 0 ";
	$result = safe_query($query);
	echo "<hr/>";
	while ($row = mysql_fetch_array($result))
	{
		echo $row["People_Id"]."<hr/>";
	}


//  PUT THE NEWBIES INTO THE PEOPLE TABLE ////////////////////////////////////////////////////////////
	echo "PUT THE NEWBIES INTO THE PEOPLE TABLE<br/>";
	$query = "INSERT INTO people (last, first, company, email,  created_on, last_modified, user_id) 
				(SELECT first_name, last_name, company, email, '2008-05-28 18:18:18', '2008-05-28 18:18:18', CONCAT(LEFT(last_name, 3), " . rand(1111,9999) . ") FROM temp_working_table WHERE People_Id = 0);";
	echo $query ."<br/>";
	$result = safe_query($query);


// SEE THE NEWBIES IN THE PEOPLE TABLE /////////////////////////////////////////
	echo "SEE THE NEWBIES IN THE PEOPLE TABLE<br/>";
	$query = "SELECT * FROM people WHERE created_on = '2008-05-28 18:18:18'";
	$result = safe_query($query);
	echo "<hr/>";
	while ($row = mysql_fetch_array($result))
	{
		echo $row["ID"]."<hr/>";
	}



// SEE WHO IS IN THE PEOPLE TABLE /////////////////////////////
	echo "SEE WHO IS IN THE PEOPLE TABLE<br/>";
	$query = "UPDATE temp_working_table t INNER JOIN people p ON t.email = p.email SET t.people_id = p.id, t.user_id = p.user_id;";
	$result = safe_query($query);
	echo $query;
	echo "<br/>";
	
// HOW MANY ARE NOT IN /////////////////////////////////////
	echo "HOW MANY ARE NOT IN - 0?<br/>";
	$query = "SELECT * FROM temp_working_table WHERE people_id != 0";
	$result = safe_query($query);
	echo "<hr/>";
	while ($row = mysql_fetch_array($result))
	{
		echo $row["People_Id"]."<hr/>";
	}


// REGISTER THE PEOPLE FOR 2008 /////////////////////////////////////
	$query = "INSERT INTO `supernova_registrations` (`people_id` , `seminar_year` , `seminar_event` , `showcase` , `priority_code` , 	`category` , `priority_code_description` , `amount` , `email_format` , 	`status` , 		`hotel_status` , 	`meals` , 	`payment_received` , `payment_method` , `date_registered` , `cc_trans_id` , `cc_declined_reason` , `new_person` , `ip` , `host` , `browser` , `last_modified` ) 
					SELECT people_id, '2008', 'Supernova 2008 Conference', 'no', 'FOK', 												'comp',		'Friend of Kevin 2008', 				'0', 							'HTML', 		'registered', 	'unknown', 			NULL , 		'n/a',				'other','2008-05-28', NULL , 'n/a', NULL , '192.168.1.2', NULL , '', '2008-05-28 18:18:18' 
							FROM temp_working_table";
	$result = safe_query($query);
	
// GIVE THEM EMAIL ALIASES /////////////////
$query = "INSERT INTO `email_aliases` (`people_id` , `email_alias` , `real_email` , `for_event` , `status` , `last_modified` )
			SELECT people_id', CONCAT(First_Name, '_', Last_Name, people_id + 17, '@supernova2008.com') , email, 'Supernova 2008', 'not activated', '2008-05-28 18:18:18' FROM temp_working_table;";
	$result = safe_query($query);	
*/
?>
