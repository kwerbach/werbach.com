<?php
/*
***********************************************************************************
DaDaBIK (DaDaBIK is a DataBase Interfaces Kreator) http://www.dadabik.org/
Copyright (C) 2001-2002  Eugenio Tacchini

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

If you want to contact me by e-mail, this is my address: eugenio@pc.unicatt.it

***********************************************************************************

I am instructor and Web developer at the Master of MiNE (Management in the Network Economy) Program, a Berkeley-style program in Italy.
If you want to know more about it please visit: http://mine.pc.unicatt.it/

***********************************************************************************
*/
?>
<?php

// include config, functions, common and header
include ("./include/config.php");
include ("./include/functions.php");
include ("./include/common.php");
include ("./include/header_admin.php");

// variables:
// GET
// table_name form admin.php
if (isset($HTTP_GET_VARS["table_name"])){
	$table_name = urldecode($HTTP_GET_VARS["table_name"]);
} // end if
else{
	$table_name = "";
} // end else

// POST
// $install from install.php (set to 1 when user click on install)

if (isset($HTTP_POST_VARS["install"])){
	$install = $HTTP_POST_VARS["install"];
} // end if
else{
	$install = "";
} // end else

if ($db_name != "" and $prefix_internal_table != ""){
	if ($install == "1"){
		if ($table_name != ""){
			$tables_names_ar[0] = $table_name;
			
			if (!table_exists($db_name, $table_list_name)){
				// drop (if present) the old table list table and create the new one
				create_table_list_table($conn);
			} // end if
		} // end if
		else{
			// get the array containing the names of the tables (excluding "dadabik_" ones)
			$tables_names_ar = build_tables_names_array($db_name, 1, 0, 0);

			// drop (if present) the old table list table and create the new one
			create_table_list_table($conn);
		} // end else

		for ($i=0; $i<count($tables_names_ar); $i++){
			$table_name_temp = $tables_names_ar[$i];
			$table_internal_name_temp = $prefix_internal_table.$table_name_temp;

			$unique_field_name = get_unique_field($conn, $db_name, $table_name_temp);

			// get the array containing the names of the fields
			$fields_names_ar = build_fields_names_array($conn, $db_name, $table_name_temp);

			// drop (if present) the old internal table and create the new one.
			create_internal_table($conn, $table_internal_name_temp);

			// delete the previous record about the table
			$sql = "delete from ".$quote."$table_list_name".$quote." where ".$quote."name_table".$quote." = '$table_name_temp'";			
			$res_delete = execute_db("$sql", $conn);

			// add the table to the table list table and set allowed to 1
			$sql = "insert into ".$quote."$table_list_name".$quote." (".$quote."name_table".$quote.", ".$quote."allowed_table".$quote.", ".$quote."enable_insert_table".$quote.", ".$quote."enable_edit_table".$quote.", ".$quote."enable_delete_table".$quote.", ".$quote."enable_details_table".$quote.") values ('$table_name_temp', '1', '1', '1', '1', '1')";			
			$res_insert = execute_db("$sql", $conn);

			for ($j=0; $j<count($fields_names_ar); $j++){
				// insert a new record in the internal table with the name of the field as name and label
				$sql = "insert into ".$quote."$table_internal_name_temp".$quote." (".$quote."name_field".$quote.", ".$quote."label_field".$quote.", ".$quote."order_form_field".$quote.") values ('$fields_names_ar[$j]', '$fields_names_ar[$j]', '".($j+1)."')";
				
				$res_insert = execute_db("$sql", $conn);
			} // end for
			
			if (table_exists($db_name, $table_internal_name_temp)){ // just a check if always is fine
				echo "<p>Internal table <b>$table_internal_name_temp</b> correctly created......";
			} // end if
			else{
				echo "<p>An error during installation occured";
				exit;
			} // end else

			if ($unique_field_name == ""){
				echo "<p>Your table <b>$table_name_temp</b> hasn't any primary keys set, if you don't set a primary key DaDaBIK won't show the edit/delete/details buttons.";
			} // end if
		} // end for
		echo "<p>......DaDaBIK correctly installed!!";
		echo "<p>You can now manage your database with DaDaBIK, starting from <a href=\"index.php\">index.php</a>";
		echo "<p>In order to customize DaDaBIK you have to use the <a href=\"admin.php\">administration page</a>.";
	} // end if ($install == "1")
	else{
		echo "<form name=\"install_form\" action=\"install.php?table_name=".urlencode($table_name)."\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"install\" value=\"1\">";
		echo "<input type=\"submit\" value=\"Click this button to install DaDaBIK\">";
		echo "</form>";
	} // end else
} // end if ($db_name != "" and $prefix_internal_table != "")
else{
	echo "<p>Please specify db_name and prefix_internal_table in config.php";
} // end else

// include footer
include ("./include/footer_admin.php");
?>