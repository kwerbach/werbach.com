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

function build_fields_names_array($conn, $db_name, $table_name)
// goal: build an array ($fields_names_ar) containing the names of the fields of a specified table
// input: connection link, name of the database and name of the table
// output: $fields_names_ar
{
    // put the name of the table's fields in an array
    $fields = list_fields_db("$db_name", "$table_name", $conn);
    $fields_number = num_fields_db($fields);
    for ($i = 0; $i < $fields_number; $i++) {
        $fields_names_ar[$i] = field_name_db($fields, $i);
    }
    return $fields_names_ar;
} // end build_fields_names_array function

function build_tables_names_array($db_name, $exclude_internal = 1, $exclude_by_user = 1, $exclude_without_internal = 1)
// goal: build an array ($tables_names_ar) containing the names of the tables of a specified db, excluding the internal tables
// input: name of the database, $exclude_internal (1 if internal tables are excluded), $exclude_by_user (1 if the tables excluded by the user are excluded), $exclude_without_internal (1 if the tables without internal table are excluded)
// output: $tables_names_ar
{
	global $conn, $prefix_internal_table, $table_list_name;
	$tables_res=list_tables_db($db_name);
	$tables_names_ar = array();
	$z=0; // set to 0 the counter of the array (I need it, I can't use $i)
	for ($i=0; $i<get_num_rows_db($tables_res); $i++){
		$table_name_temp = tablename_db($tables_res, $i);
		if (substr($table_name_temp, 0, strlen($prefix_internal_table)) != $prefix_internal_table or $exclude_internal == 0){
			if (table_exists($db_name, $prefix_internal_table.$table_name_temp) or $exclude_without_internal == 0){
				if (table_allowed($conn, $table_name_temp) or $exclude_by_user == 0){
					if ($table_name_temp != $table_list_name){
						$tables_names_ar[$z] = tablename_db($tables_res, $i);
						$z++;
					} // end if
				} // end if
			} // end if
		} // end if
	} // end for
    return $tables_names_ar;
} // end build_tables_names_array function

function table_exists($db_name, $table_name)
// goal: check if a table exists in a db
// input: $db_name, $table_name
// output: true or false
{
	$tables_res=list_tables_db($db_name);
	for ($i=0; $i<get_num_rows_db($tables_res); $i++){
		$table_name_temp = tablename_db($tables_res, $i);
		if ($table_name_temp == $table_name){
			return true;
		} // end if
	} // end for
	return false;
} // end function table_exists


function build_fields_labels_array($conn, $table_name, $table_internal_name, $order)
// goal: build an array ($fields_labels_ar) containing the fields labels and other information about fields (e.g. the type, display/don't display) of a specified table to use in the form
// input: connection link, name of the table, name of the internal table, $order, 0/1 if shouldn't/should be order by order_form
// output: fields_labels_ar, a 2 dimensions associative array: $fields_labels_ar[field_number]["internal table field (e.g. present_insert_form_field)"]
// global $error_messages_ar, the array containg the error messages
{
	global $error_messages_ar, $quote;

    // put the labels and other information of the table's fields in an array
	$sql = "select ".$quote."name_field".$quote.", ".$quote."present_insert_form_field".$quote.", ".$quote."present_ext_update_form_field".$quote.", ".$quote."present_search_form_field".$quote.", ".$quote."required_field".$quote.", ".$quote."present_results_search_field".$quote.", ".$quote."present_details_form_field".$quote.", ".$quote."check_duplicated_insert_field".$quote.", ".$quote."type_field".$quote.", ".$quote."other_choices_field".$quote.", ".$quote."content_field".$quote.", ".$quote."label_field".$quote.", ".$quote."select_options_field".$quote.", ".$quote."separator_field".$quote.", ".$quote."foreign_key_field".$quote.", ".$quote."db_primary_key_field".$quote.", ".$quote."select_type_field".$quote.", ".$quote."prefix_field".$quote.", ".$quote."default_value_field".$quote.", ".$quote."width_field".$quote.", ".$quote."height_field".$quote.", ".$quote."maxlength_field".$quote.", ".$quote."hint_insert_field".$quote.", ".$quote."order_form_field".$quote." from ".$quote."$table_internal_name".$quote."";
	
	if ($order == "1"){
		$sql .= " order by ".$quote."order_form_field".$quote."";
	} // end if

	$res_field = execute_db("$sql", $conn);
    $i = 0;
	if (get_num_rows_db($res_field) > 0) { // at least one record
        while($field_row = fetch_row_db($res_field)){
			$fields_labels_ar[$i]["name_field"] = $field_row["name_field"]; // the name of the field
            $fields_labels_ar[$i]["present_insert_form_field"] = $field_row["present_insert_form_field"]; // 1 if the user want to display it in the insert form
			$fields_labels_ar[$i]["present_ext_update_form_field"] = $field_row["present_ext_update_form_field"]; // 1 if the user want to display it in the external update form
			$fields_labels_ar[$i]["present_search_form_field"] = $field_row["present_search_form_field"]; // 1 if the user want to display it in the search form
			$fields_labels_ar[$i]["required_field"] = $field_row["required_field"]; // 1 if the field is required in the insert (the field must be in the insert form, otherwise this flag hasn't any effect
			$fields_labels_ar[$i]["present_results_search_field"] = $field_row["present_results_search_field"]; // 1 if the user want to display it in the basic results page
			$fields_labels_ar[$i]["present_details_form_field"] = $field_row["present_details_form_field"]; // 1 if the user want to display it in the basic results page
			$fields_labels_ar[$i]["check_duplicated_insert_field"] = $field_row["check_duplicated_insert_field"]; // 1 if the field needs to be checked for duplicated insert

            $fields_labels_ar[$i]["label_field"] = $field_row["label_field"]; // the label of the field
            $fields_labels_ar[$i]["type_field"] = $field_row["type_field"]; // the type of the field
			 $fields_labels_ar[$i]["other_choices_field"] = $field_row["other_choices_field"]; // 0/1 the possibility to add another choice with select single menu
			$fields_labels_ar[$i]["content_field"] = $field_row["content_field"]; // the control type of the field (eg: numeric, alphabetic, alphanumeric)
			$fields_labels_ar[$i]["select_options_field"] = $field_row["select_options_field"]; // the options, separated by separator, possible in a select field
			$fields_labels_ar[$i]["separator_field"] = $field_row["separator_field"]; // the separator of different possible values for a select field
			$fields_labels_ar[$i]["foreign_key_field"] = $field_row["foreign_key_field"]; // the primary key (table_name.field_name) if this field is a foreign key
			$fields_labels_ar[$i]["db_primary_key_field"] = $field_row["db_primary_key_field"]; // the name of the database of the primary key
			$fields_labels_ar[$i]["select_type_field"] = $field_row["select_type_field"]; // the type of select, exact match or like
			$fields_labels_ar[$i]["prefix_field"] = $field_row["prefix_field"]; // the prefix of the field (e.g. http:// - only for text and textarea)
			$fields_labels_ar[$i]["default_value_field"] = $field_row["default_value_field"]; // the default value of the field (only for text and textarea)
			$fields_labels_ar[$i]["width_field"] = $field_row["width_field"]; // the width size of the field in case of text or textarea
			$fields_labels_ar[$i]["height_field"] = $field_row["height_field"]; // the height size of the field in case of text or textarea
			$fields_labels_ar[$i]["maxlength_field"] = $field_row["maxlength_field"]; // the maxlength of the field in case of text
			$fields_labels_ar[$i]["hint_insert_field"] = $field_row["hint_insert_field"]; // the hint to display after the field in the insert form (e.g. use only number here!!)
			$fields_labels_ar[$i]["order_form_field"] = $field_row["order_form_field"]; // the position of the field in the form
            $i++;
        } // end while
    } // end if
    else { // no records
        echo $error_messages_ar["int_db_empty"];
    } // end else
    return $fields_labels_ar;
} // end build_fields_labels_array function

function build_form($action, $fields_labels_ar, $form_type, $res_details, $where_field, $where_value, $conn)
// goal: build a tabled form by using the info specified in the array $fields_labels_ar
// input: array containing labels and other info about fields, $action (the action of the form), $form_type, $res_details, $where_field, $where_value (the last three useful just for update forms), $conn
// global: $submit_buttons_ar, the array containing the values of the submit buttons, $normal_messages_ar, the array containig the normal messages, $select_operator_feature, wheter activate or not displaying "and/or" in the search form, $default_operator, the default operator if $select_operator_feature is not activated, $db_name, $size_multiple_select, the size (number of row) of the select_multiple_menu fields, $table_name
// output: $form, the html tabled form
{
	global $submit_buttons_ar, $normal_messages_ar, $select_operator_feature, $default_operator, $db_name, $size_multiple_select, $upload_relative_url;

	global $table_name;
	
	$form = "";
	$form .= "<form name=\"contacts_form\" method=\"post\" action=\"$action?table_name=".urlencode($table_name)."&page=0&function=$form_type\" enctype=\"multipart/form-data\"><table border=\"0\">";
	//$form .= "<input type=\"hidden\" name=\"function\" value=\"$form_type\">";
	// $form .= "<input type=\"hidden\" name=\"page\" value=\"0\">";

	switch($form_type){
		case "insert":
			$number_cols = 4;
			$field_to_ceck = "present_insert_form_field";
			break;
		case "update":
			$number_cols = 4;
			$field_to_ceck = "present_insert_form_field";
			$details_row = fetch_row_db($res_details); // get the values of the details
			$form .= "<input type=\"hidden\" name=\"where_field\" value=\"$where_field\">";
			$form .= "<input type=\"hidden\" name=\"where_value\" value=\"$where_value\">";
			$form .= "<tr><td align=\"center\" colspan=\"$number_cols\"><input type=\"submit\" value=\"".$submit_buttons_ar["$form_type"]."\"></td></tr>";
			break;
		case "ext_update":
			$number_cols = 4;
			$field_to_ceck = "present_ext_update_form_field";
			$details_row = fetch_row_db($res_details); // get the values of the details
			$form .= "<input type=\"hidden\" name=\"where_field\" value=\"$where_field\">";
			$form .= "<input type=\"hidden\" name=\"where_value\" value=\"$where_value\">";
			$form .= "<tr><td align=\"center\" colspan=\"$number_cols\"><input type=\"submit\" value=\"".$submit_buttons_ar["$form_type"]."\"></td></tr>";
			break;
		case "search":
			$number_cols = 3;
			$field_to_ceck = "present_search_form_field";
			if ($select_operator_feature == "1"){
				$form .= "<tr><td align=\"center\" colspan=\"$number_cols\"><select name=\"operator\"><option value=\"and\">".$normal_messages_ar["all_conditions_required"]."</option><option value=\"or\">".$normal_messages_ar["any_conditions_required"]."</option></select></td></tr>";
			} // end if
			else{
				$form .= "<input type=\"hidden\" name=\"operator\" value=\"$default_operator\">";
			} // end else
			$form .= "<tr><td align=\"center\" colspan=\"$number_cols\"><input type=\"submit\" value=\"".$submit_buttons_ar["$form_type"]."\"></td></tr>";
			break;
	} // end switch
    
    for ($i=0; $i<count($fields_labels_ar); $i++){
        if ($fields_labels_ar[$i]["$field_to_ceck"] == "1") { // the user want to display the field in the form
			
			// build the first coloumn (label)
			//////////////////////////////////
			// I put a table inside the cell to get the same margin of the second coloumn
			$form .= "<tr><td align=\"right\" valign=\"top\" class=\"dadabikform\"><table><tr><td>";
			if ($fields_labels_ar[$i]["required_field"] == "1" and $form_type != "search"){
				$form .= "<font color=\"#ff0000\">";
			} // end if 			
			$form .= $fields_labels_ar[$i]["label_field"].": ";
			if ($fields_labels_ar[$i]["required_field"] == "1"){
				$form .= "</font>";
			} // end if
			$form .= "</td></tr></table></td><td>";
			//////////////////////////////////
			// end build the first coloumn (label)

			// build the second coloumn (input field)
			/////////////////////////////////////////
			$field_name_temp = $fields_labels_ar[$i]["name_field"];
			$foreign_key_temp = $fields_labels_ar[$i]["foreign_key_field"];
			if ($foreign_key_temp != ""){
				if (substr($foreign_key_temp, 0, 4) == "SQL:"){
					$sql = substr($foreign_key_temp, 4, strlen($foreign_key_temp)-4);
				} // end if
				else{
					$primary_key_field_temp = substr($foreign_key_temp, (strpos($foreign_key_temp, ".") + 1), (strlen($foreign_key_temp) - (strpos($foreign_key_temp, ".") + 1))); // remove "table_name."

					$primary_key_table_temp = substr($foreign_key_temp, 0, strpos($foreign_key_temp, ".")); // remove ".field_name"

					$sql = "select distinct ".$primary_key_field_temp." from ".$primary_key_table_temp; // e.g. select distinct ID from my_table
				} // end else
				// select the primary key database
				if ($fields_labels_ar[$i]["db_primary_key_field"] != ""){					
					select_db($fields_labels_ar[$i]["db_primary_key_field"], $conn);
				} // end if

				$res_primary_key = execute_db("$sql", $conn);

				// re-select the main database
				select_db("$db_name", $conn);
			} // end if

			if ($form_type == "search"){
				$select_type_select = build_select_type_select($field_name_temp."_select_type", $i, $fields_labels_ar); // build the select form with exactly or like
			} // end if
			else{
				$select_type_select = "";
			} // end else
			$form .= "<table border=\"0\"><tr>";
			switch ($fields_labels_ar[$i]["type_field"]){
				case "text":
				case "ID_user":
				case "password_record":
					$form .= "<td valign=\"top\">$select_type_select<input type=\"text\" name=\"".$field_name_temp."\"";
					if ($fields_labels_ar[$i]["width_field"] != ""){
						$form .= " size=\"".$fields_labels_ar[$i]["width_field"]."\"";
					} // end if
					$form .= " maxlength=\"".$fields_labels_ar[$i]["maxlength_field"]."\"";
					if ($form_type == "update" or $form_type == "ext_update"){
						$form .= " value=\"".htmlspecialchars($details_row["$field_name_temp"])."\"";
					} // end if
					if ($form_type == "insert"){						
						$form .= " value=\"".$fields_labels_ar[$i]["prefix_field"].$fields_labels_ar[$i]["default_value_field"]."\"";
					} // end if
					$form .= ">";
                    if (($form_type == "update" or $form_type == "insert") and $fields_labels_ar[$i]["content_field"] == "city"){						
						$form .= "<a name=\"$field_name_temp\" href=\"#$field_name_temp\" onclick=\"javascript:fill_cap('$field_name_temp')\">?</a>";
					} // end if
                    $form .= "</td>"; // add the second coloumn to the form
					break;
				case "generic_file":
				case "image_file":
					if ($form_type == 'search') { // build a textbox instead of a file input
						$form .= "<td valign=\"top\">$select_type_select<input type=\"text\" name=\"".$field_name_temp."\" size=\"".$fields_labels_ar[$i]["width_field"]."\">";						
					}
					else{
						$form .= "<td valign=\"top\">$select_type_select<input type=\"file\" name=\"".
						  $field_name_temp."\" size=\"".$fields_labels_ar[$i]["width_field"]."\">\n";
						if (($form_type == "update" or $form_type == "ext_update")){
							$file_name_temp = $details_row["$field_name_temp"];
							if ($file_name_temp != ""){
								$form .= "<br>".$normal_messages_ar["current_upload"].": <a href=\"".$upload_relative_url;
								$form .= rawurlencode(addslashes($file_name_temp));
								$form .= "\">";
								$form .= htmlspecialchars($file_name_temp);
								$form .= "</a> <input type=\"checkbox\" value=\"".htmlspecialchars($file_name_temp)."\" name=\"".$field_name_temp."_file_uploaded_delete\"> (".$normal_messages_ar['delete'].")";
							} // end if
						} // end if
					}
					$form .= "</td>"; // add the second coloumn to the form
					break;
				case "textarea":
					if ($select_type_select != ""){
						$form .= "<td valign=\"top\">$select_type_select</td>";
					} // end if 
					$form .= "<td valign=\"top\"><textarea cols=\"".$fields_labels_ar[$i]["width_field"]."\" rows=\"".$fields_labels_ar[$i]["height_field"]."\" name=\"".$field_name_temp."\">";
					if ($form_type == "update" or $form_type == "ext_update"){						
						$form .= htmlspecialchars($details_row["$field_name_temp"]);
					} // end if
					if ($form_type == "insert"){						
						$form .= $fields_labels_ar[$i]["prefix_field"].$fields_labels_ar[$i]["default_value_field"];
					} // end if
					
					$form .= "</textarea></td>"; // add the second coloumn to the form
					break;
				case "password":
					$form .= "<td valign=\"top\">$select_type_select<input type=\"password\" name=\"".$field_name_temp."\" size=\"".$fields_labels_ar[$i]["width_field"]."\" maxlength=\"".$fields_labels_ar[$i]["maxlength_field"]."\"";
					if ($form_type == "update" or $form_type == "ext_update"){						
						$form .= " value=\"".htmlspecialchars($details_row["$field_name_temp"])."\"";
					} // end if
					
					$form .= "></td>"; // add the second coloumn to the form
					break;
				case "date":
					$operator_select = "";
					switch($form_type){
						case "update":
							split_date($details_row["$field_name_temp"], $day, $month, $year);
							$date_select = build_date_select($field_name_temp, $day, $month, $year);
							break;
						case "insert":
							$date_select = build_date_select($field_name_temp,"","","");
							break;
						case "search":
							$operator_select = build_operator_select($field_name_temp."_operator");
							$date_select = build_date_select($field_name_temp,"","","");
							break;
					} // end switch
					$form .= "<td valign=\"top\">".$operator_select."</td>".$date_select; // add the second coloumn to the form
					break;
				case "insert_date":
				case "update_date":
					$operator_select = "";
					$date_select = "";
					switch($form_type){
						case "search":
							$operator_select = build_operator_select($field_name_temp."_operator");
							$date_select = build_date_select($field_name_temp,"","","");
							break;
					} // end switch
					$form .= "<td valign=\"top\">".$operator_select."</td>".$date_select."</td>"; // add the second coloumn to the form
					break;
				case "select_multiple_menu":
				case "select_multiple_checkbox":

					$form .= "<td valign=\"top\" class=\"dadabikform\">"; // first part of the second coloumn of the form

                    $options_labels_temp = substr($fields_labels_ar[$i]["select_options_field"], 1, strlen($fields_labels_ar[$i]["select_options_field"])-2); // delete the first and the last separator (-2 instead of -1 beacuse I start from 1!!)
					
					$select_labels_ar = explode($fields_labels_ar[$i]["separator_field"],$options_labels_temp);

					$select_labels_ar_number = count($select_labels_ar);

					if ($select_labels_ar_number == 1){
						$select_labels_ar_number = 0; // to remove the empty option that would be created if the field has just foreign key options and not normal options
					} // end if

					if ($fields_labels_ar[$i]["type_field"] == "select_multiple_menu"){
						$form .= "<select name=\"".$field_name_temp."[]\" size=".$size_multiple_select." multiple>";
					} // end if

					for ($j=0; $j<$select_labels_ar_number; $j++){
						if ($fields_labels_ar[$i]["type_field"] == "select_multiple_menu"){
							$form .= "<option value=\"".htmlspecialchars($select_labels_ar[$j])."\"";
						} // end if
						elseif ($fields_labels_ar[$i]["type_field"] == "select_multiple_checkbox"){
							$form .= "<input type=\"checkbox\" name=\"".$field_name_temp."[]\" value=\"".htmlspecialchars($select_labels_ar[$j])."\"";
						} // end elseif

						if ($form_type == "update" or $form_type == "ext_update"){
							$options_values_temp = substr($details_row["$field_name_temp"], 1, strlen($details_row["$field_name_temp"])-2); // delete the first and the last separator (-2 instead of -1 beacuse I start from 1!!)
							$select_values_ar = explode($fields_labels_ar[$i]["separator_field"],$options_values_temp);
							$found_flag = 0;
							$z = 0;
							while ($z<count($select_values_ar) and $found_flag == 0){
								if ($select_labels_ar[$j] == $select_values_ar[$z]){
									if ($fields_labels_ar[$i]["type_field"] == "select_multiple_menu"){
										$form .= " selected";
									} // end if
									elseif ($fields_labels_ar[$i]["type_field"] == "select_multiple_checkbox"){										
										$form .= " checked";
									} // end elseif
									$found_flag = 1;
								} // end if
								$z++;
							} // end while
						} // end if	
						if ($fields_labels_ar[$i]["type_field"] == "select_multiple_menu"){
							$form .= "> $select_labels_ar[$j]</option>";
						} // end if
						elseif ($fields_labels_ar[$i]["type_field"] == "select_multiple_checkbox"){
							$form .= "> $select_labels_ar[$j]<br>";
						} // end elseif
					} // end for - central part of the form row
					

					if ($fields_labels_ar[$i]["foreign_key_field"] != ""){
						if (get_num_rows_db($res_primary_key) > 0){
							$fields_number = num_fields_db($res_primary_key);
							while ($primary_key_row = fetch_row_db($res_primary_key)){
								
								$primary_key_value = "";
								for ($z=0; $z<$fields_number; $z++){
									$primary_key_value .= $primary_key_row[$z];
									$primary_key_value .= " - ";
								} // end for
								$primary_key_value = substr($primary_key_value, 0, strlen($primary_key_value)-3); // delete the last " - "
								
								if ($fields_labels_ar[$i]["type_field"] == "select_multiple_menu"){
									$form .= "<option value=\"".htmlspecialchars($primary_key_value)."\"";
								} // end if
								elseif ($fields_labels_ar[$i]["type_field"] == "select_multiple_checkbox"){
									$form .= "<input type=\"checkbox\" name=\"".$field_name_temp."[]\" value=\"".htmlspecialchars($primary_key_value)."\"";
								} // end elseif

								if ($form_type == "update" or $form_type == "ext_update"){
									$options_values_temp = substr($details_row["$field_name_temp"], 1, strlen($details_row["$field_name_temp"])-2); // delete the first and the last separator (-2 instead of -1 beacuse I start from 1!!)
									$select_values_ar = explode($fields_labels_ar[$i]["separator_field"],$options_values_temp);
									$found_flag = 0;
									$z = 0;
									while ($z<count($select_values_ar) and $found_flag == 0){
										if ($primary_key_value == $select_values_ar[$z]){
											if ($fields_labels_ar[$i]["type_field"] == "select_multiple_menu"){
												$form .= " selected";
											} // end if
											elseif ($fields_labels_ar[$i]["type_field"] == "select_multiple_checkbox"){								
												$form .= " checked";
											} // end elseif
											$found_flag = 1;
										} // end if
										$z++;
									} // end while
								} // end if
								if ($fields_labels_ar[$i]["type_field"] == "select_multiple_menu"){
									$form .= "> ".$primary_key_value."</option>";
								} // end if
								elseif ($fields_labels_ar[$i]["type_field"] == "select_multiple_checkbox"){
									$form .= "> ".$primary_key_value."<br>"; // second part of the form row
								} // end elseif
							} // end while
						} // end if
					} // end if ($fields_labels_ar[$i]["foreign_key_field"] != "")
					if ($fields_labels_ar[$i]["type_field"] == "select_multiple_menu"){
						$form .= "</select>";
					} // end if

					$form .= "</td>"; // last part of the second coloumn of the form
					break;

				case "select_single":

					$form .= "<td valign=\"top\">".$select_type_select."<select name=\"".$field_name_temp."\">"; // first part of the second coloumn of the form

					$field_temp = substr($fields_labels_ar[$i]["select_options_field"], 1, strlen($fields_labels_ar[$i]["select_options_field"])-2); // delete the first and the last separator  (-2 instead of -1 beacuse I start from 1!!)
					
					$select_values_ar = explode($fields_labels_ar[$i]["separator_field"],$field_temp);

					for ($j=0; $j<count($select_values_ar); $j++){
						$form .= "<option value=\"".htmlspecialchars($select_values_ar[$j])."\"";
						
						if (($form_type == "update" or $form_type == "ext_update") and $select_values_ar[$j] == $details_row["$field_name_temp"]){						
							$form .= " selected";
						} // end if
						
						$form .= ">$select_values_ar[$j]</option>"; // second part of the form row
					} // end for

					if ($fields_labels_ar[$i]["foreign_key_field"] != ""){
						if (get_num_rows_db($res_primary_key) > 0){
							$fields_number = num_fields_db($res_primary_key);
							while ($primary_key_row = fetch_row_db($res_primary_key)){
								
								$primary_key_value = "";
								for ($z=0; $z<$fields_number; $z++){
									$primary_key_value .= $primary_key_row[$z];
									$primary_key_value .= " - ";
								} // end for
								$primary_key_value = substr($primary_key_value, 0, strlen($primary_key_value)-3); // delete the last " - "								
								$form .= "<option value=\"".htmlspecialchars($primary_key_value)."\"";
							
								if (($form_type == "update" or $form_type == "ext_update") and $primary_key_value == $details_row["$field_name_temp"]){						
									$form .= " selected";
								} // end if
								
								$form .= ">".$primary_key_value."</option>"; // second part of the form row
							} // end while
						} // end if
					} // end if ($fields_labels_ar[$i]["foreign_key_field"] != "")
					
					if ($fields_labels_ar[$i]["other_choices_field"] == "1" and ($form_type == "insert" or $form_type == "update")){
						$form .= "<option value=\"......\">".$normal_messages_ar["other...."]."</option>"; // last option with "other...."
					} // end if

					$form .= "</select>";

					if ($fields_labels_ar[$i]["other_choices_field"] == "1" and ($form_type == "insert" or $form_type == "update")){
						$form .= "<input type=\"text\" name=\"".$field_name_temp."_other____"."\" maxlength=\"".$fields_labels_ar[$i]["maxlength_field"]."\"";

						if ($fields_labels_ar[$i]["width_field"] != ""){
							$form .= " size=\"".$fields_labels_ar[$i]["width_field"]."\"";
						} // end if
						$form .= ">"; // text field for other....
					} // end if 

					
					$form .= "</td>"; // last part of the second coloumn of the form
					break;
			} // end switch
			/////////////////////////////////////////	
			// end build the second coloumn (input field)
			if ($form_type == "insert" or $form_type == "update" or $form_type == "ext_update"){
				$form .= "<td class=\"dadabikform\" valign=\"top\">".$fields_labels_ar[$i]["hint_insert_field"]."</td>"; // display the insert hint if it's the insert form
			} // end if
			$form .= "</tr></table></td></tr>";
        } // end if ($fields_labels_ar[$i]["$field_to_ceck"] == "1")
    } // enf for loop for each field in the label array
	$form .= "<tr><td align=\"center\" colspan=\"$number_cols\"><input type=\"submit\" value=\"".$submit_buttons_ar["$form_type"]."\"></td></tr></table></form>";
    return $form;
} // end build_form function

function build_select_type_select($field_name, $i, $fields_labels_ar)
// goal: build a select with the select type of the file (e.g. exactly, like, >, <)
// input: $field_name, $i (the row of the field), $fields_labels_ar, array containing labels and other info about fields
// output: $select_type_select
// global: $normal_messages_ar, the array containing the normal messages
{
	global $normal_messages_ar;

	$select_type_select = "";

	$operators_ar = explode("/",$fields_labels_ar[$i]["select_type_field"]);

	if (count($operators_ar) > 1){ // more than on operator, need a select
		$select_type_select .= "<select name=\"$field_name\">";
		for ($i=0; $i<count($operators_ar); $i++){
			$select_type_select .= "<option value=\"".$operators_ar[$i]."\">".$operators_ar[$i]."</option>";
		} // end for
		$select_type_select .= "</select>";
	} // end if

	return $select_type_select;
} // end function build_select_type_select

function check_required_fields($HTTP_POST_VARS, $fields_labels_ar)
// goal: check if the user has fill all the required fields
// input: all the fields values ($HTTP_POST_VARS) and the array containing infos about fields ($fields_labels_ar)
// output: $check, set to 1 if the check is ok, otherwise 0
{
	$i =0;
	$check = 1;
	while ($i<count($fields_labels_ar) and $check == 1){
		if ($fields_labels_ar[$i]["required_field"] == "1" and $fields_labels_ar[$i]["present_insert_form_field"] == "1"){			
			$field_name_temp = $fields_labels_ar[$i]["name_field"];
			switch($fields_labels_ar[$i]["type_field"]){
				case "date":
					break; // date is always filled
				case "select_single":
					if ($fields_labels_ar[$i]["other_choices_field"] == "1" and $HTTP_POST_VARS["$field_name_temp"] == "......"){
						$field_name_other_temp = $field_name_temp."_other____";						
						if ($HTTP_POST_VARS["$field_name_other_temp"] == ""){
							$check = 0;
						} // end if
					} // end if
					else{
						if ($HTTP_POST_VARS["$field_name_temp"] == ""){
							$check = 0;
						} // end if
					} // end else
					break;
				default:
					if ($HTTP_POST_VARS["$field_name_temp"] == $fields_labels_ar[$i]["prefix_field"]){
						$HTTP_POST_VARS["$field_name_temp"] = "";
					} // end if
					if ($HTTP_POST_VARS["$field_name_temp"] == ""){
						$check = 0;
					} // end if
					break;
			} // end switch
		} // end if
		$i++;
	} // end while
	return $check;
} // end function check_required_fields

function check_length_fields($HTTP_POST_VARS, $fields_labels_ar)
// goal: check if the textarea fields contains too much text
// input: all the fields values ($HTTP_POST_VARS) and the array containing infos about fields ($fields_labels_ar)
// output: $check, set to 1 if the check is ok, otherwise 0
{
	$i =0;
	$check = 1;
	while ($i<count($fields_labels_ar) and $check == 1){
		if ($fields_labels_ar[$i]["maxlength_field"] != ""){
			switch($fields_labels_ar[$i]["type_field"]){
				case "text":
				case "password":
				case "textarea":
					$field_name_temp = $fields_labels_ar[$i]["name_field"];
					if (strlen($HTTP_POST_VARS["$field_name_temp"]) > $fields_labels_ar[$i]["maxlength_field"]){
						$check = 0;
					} // end if
					break;
				case "select_single":
					$field_name_temp = $fields_labels_ar[$i]["name_field"];
					if ($fields_labels_ar[$i]["other_choices_field"] == "1" and $HTTP_POST_VARS["$field_name_temp"] == "......"){
						$field_name_other_temp = $field_name_temp."_other____";
						if (strlen($HTTP_POST_VARS["$field_name_other_temp"]) > $fields_labels_ar[$i]["maxlength_field"]){
							$check = 0;
						} // end if
					} // end if
					else{
						if (strlen($HTTP_POST_VARS["$field_name_temp"]) > $fields_labels_ar[$i]["maxlength_field"]){
							$check = 0;
						} // end if
					} // end else
					break;
			} // end switch
		} // end if
		$i++;
	} // end while
	return $check;
} // end function check_length_fields

function write_uploaded_files($HTTP_POST_FILES, $fields_labels_ar)
// goal: check if the uploaded files are too large.
// input: all the uploaded files ($HTTP_POST_FILES) and the array containing infos about fields ($fields_labels_ar)
// output: $check, set to 1 if the check is ok, otherwise 0
{
	global $upload_directory, $max_upload_file_size, $allowed_file_exts_ar, $allowed_all_files;
	// global $HTTP_POST_FILES; // needed if time() is allowed
	$i =0;
	$check = 1;
	while ($i<count($fields_labels_ar) and $check == 1){
		switch($fields_labels_ar[$i]["type_field"]){
		  case "generic_file":
		  case "image_file":
			$field_name_temp = $fields_labels_ar[$i]["name_field"];

			if ($HTTP_POST_FILES["$field_name_temp"]['name'] != ''){

				// $HTTP_POST_FILES["$field_name_temp"]['name'] = time()."-".$HTTP_POST_FILES["$field_name_temp"]['name'];
				
				$file_name_temp = $HTTP_POST_FILES["$field_name_temp"]['tmp_name'];
				$file_name = $HTTP_POST_FILES["$field_name_temp"]['name'];
				$file_name = get_valid_name_uploaded_file($file_name);

				$file_size = $HTTP_POST_FILES["$field_name_temp"]['size'];

				$file_suffix_temp = strrchr($file_name, ".");
				$file_suffix_temp = substr($file_suffix_temp, 1, strlen($file_suffix_temp)-1); // remove the 
				
				if ( !in_array(strtolower($file_suffix_temp), $allowed_file_exts_ar) && $allowed_all_files != 1){
					$check = 0;
				} else {
					if ($file_size > $max_upload_file_size) {
						$check = 0;	
					} else { //go ahead and copy the file into the upload directory
						if (!(move_uploaded_file($file_name_temp, $upload_directory.'dadabik_tmp_file_'.$file_name))) {
							$check = 0;
						}
					}
				}				
			} // end if
		} // end switch
		$i++;
	} // end while
	//return $debugstring;
	return $check;
} // end function write_uploaded_files

function check_fields_types($HTTP_POST_VARS, $fields_labels_ar, &$content_error_type)
// goal: check if the user has well filled the form, according to the type of the field (e.g. no numbers in alphabetic fields, emails and urls correct)
// input: all the fields values ($HTTP_POST_VARS) and the array containing infos about fields ($fields_labels_ar), &$content_error_type, a string that change according to the error made (alphabetic, numeric, email, phone, url)
// output: $check, set to 1 if the check is ok, otherwise 0
{
	$i =0;
	$check = 1;
	while ($i<count($fields_labels_ar) and $check == 1){
		$field_name_temp = $fields_labels_ar[$i]["name_field"];
		if (isset($HTTP_POST_VARS["$field_name_temp"])){ // otherwise it's not included in the form
			if ($HTTP_POST_VARS["$field_name_temp"] == $fields_labels_ar[$i]["prefix_field"]){
				$HTTP_POST_VARS["$field_name_temp"] = "";
			} // end if
			if ($fields_labels_ar[$i]["type_field"] == "select_single" and $fields_labels_ar[$i]["other_choices_field"] == "1" and $HTTP_POST_VARS["$field_name_temp"] == "......"){ // other field filled
				$field_name_temp = $field_name_temp."_other____";
			} // end if
			if (($fields_labels_ar[$i]["type_field"] == "text" or $fields_labels_ar[$i]["type_field"] == "textarea" or $fields_labels_ar[$i]["type_field"] == "select_single") and $fields_labels_ar[$i]["present_insert_form_field"] == "1" and $HTTP_POST_VARS["$field_name_temp"] != ""){
				
				switch ($fields_labels_ar[$i]["content_field"]){
					case "alphabetic":
						if (contains_numerics($HTTP_POST_VARS["$field_name_temp"])){
							$check = 0;
							$content_error_type = $fields_labels_ar[$i]["content_field"];
						} // end if
						break;
					case "numeric":
						if (!is_numeric($HTTP_POST_VARS["$field_name_temp"])){
							$check = 0;
							$content_error_type = $fields_labels_ar[$i]["content_field"];
						} // end if
						break;
					case "phone":
						if (!is_valid_phone($HTTP_POST_VARS["$field_name_temp"])){
							$check = 0;
							$content_error_type = $fields_labels_ar[$i]["content_field"];
						} // end if
						break;
					case "email":
						if (!is_valid_email($HTTP_POST_VARS["$field_name_temp"])){
							$check = 0;
							$content_error_type = $fields_labels_ar[$i]["content_field"];
						} // end if
						break;
					case "web":
						if (!is_valid_url($HTTP_POST_VARS["$field_name_temp"])){
							$check = 0;
							$content_error_type = $fields_labels_ar[$i]["content_field"];
						} // end if
						break;
				} // end switch
			} // end if
		} // end if
		$i++;
	} // end while
	return $check;
} // end function check_fields_types

function build_select_duplicated_query($HTTP_POST_VARS, $conn, $db_name, $table_name, $fields_labels_ar, &$string1_similar_ar, &$string2_similar_ar)
// goal: build the select query to select the record that can be similar to the record inserted
// input: all the field values ($HTTP_POST_VARS), $conn, $db_name, $table_name, $fields_labels_ar, &$string1_similar_ar, &$string2_similar_ar (the two array that will contain the similar string found)
// output: $sql, the sql query
// global $percentage_similarity, the percentage after that two strings are considered similar, $number_duplicated_records, the maximum number of records to be displayed as duplicated
{
	global $percentage_similarity, $number_duplicated_records, $quote;
	
	// get the unique key of the table
	$unique_field_name = get_unique_field($conn, $db_name, $table_name);

	if ($unique_field_name != ""){ // a unique key exists, ok, otherwise I'm not able to select the similar record, which field should I use to indicate it?

		reset ($HTTP_POST_VARS);
		while (list($key, $value) = each ($HTTP_POST_VARS)){
			$$key = $value;
		} // end while

		$sql = "";
		$sql_select_all = "";
		$sql_select_all = "select ".$quote."$unique_field_name".$quote.", "; // this is used to select the records to check similiarity
		$select = "select * from ".$quote."$table_name".$quote."";
		$where_clause = "";	

		// build the sql_select_all clause
		$j = 0;
		// build the $fields_to_check_ar array, containing the field to check for similiarity
		$fields_to_check_ar = array();
		for ($i=0; $i<count($fields_labels_ar); $i++){
			if ($fields_labels_ar[$i]["check_duplicated_insert_field"] == "1"){
				//if (${$fields_labels_ar[$i]["name_field"]} != ""){
					$fields_to_check_ar[$j] = $fields_labels_ar[$i]["name_field"]; // I put in the array only if the field is non empty, otherwise I'll check it even if I don't need it
				//} // end if
				$sql_select_all .= $fields_labels_ar[$i]["name_field"].", ";
				$j++;
			} // end if
		} // end for
		$sql_select_all = substr ($sql_select_all, 0, strlen($sql_select_all)-2); // delete the last ", "
		$sql_select_all .= " from ".$quote."$table_name".$quote."";
		// end build the sql_select_all clause

		// at the end of the above procedure I'll have, for example, "select ID, name, email from table" if ID is the unique key, name and email are field to check

		// execute the select query
		$res_contacts = execute_db("$sql_select_all", $conn);	

		if (get_num_rows_db($res_contacts) > 0){
			while ($contacts_row = fetch_row_db($res_contacts)){ // *A* for each record in the table
				for ($i=0; $i<count ($fields_to_check_ar); $i++){ // *B* and for each field the user has inserted
					$z=0;
					$found_similarity =0; // set to 1 when a similarity is found, so that it's possible to exit the loop (if I found that a record is similar it doesn't make sense to procede with other fields of the same record)
					
					// *C* check if the field inserted are similiar to the other fields to be checked in this record (*A*)
					while ($z<count($fields_to_check_ar) and $found_similarity == 0){
						$string1_temp = ${$fields_to_check_ar[$i]}; // the field the user has inserted
						$string2_temp = $contacts_row[$z+1]; // the field of this record (*A*); I start with 1 because 0 is alwais the unique field (e.g. ID, name, email)
						
						similar_text($string1_temp, $string2_temp, $percentage);
						if ($percentage >= $percentage_similarity){ // the two strings are similar
							$where_clause .= $unique_field_name." = \"".$contacts_row["$unique_field_name"]."\" or ";
							$found_similarity = 1;
							$string1_similar_ar[]=$string1_temp;
							$string2_similar_ar[]=$string2_temp;
						} // end if the two strings are similar
						$z++;
					} // end while

				} // end for loop for each field to check
			} // end while loop for each record
		} // end if (get_num_rows_db($res_contacts) > 0)

		$where_clause = substr($where_clause, 0, strlen($where_clause)-4); // delete the last " or "
		if ($where_clause != ""){
			$sql = $select." where ".$where_clause." limit 0,".$number_duplicated_records;
		} // end if
		else{ // no duplication
			$sql = "";
		} // end else*
	} // end if if ($unique_field_name != "")
	else{ // no unique keys
		$sql = "";
	} // end else
	return $sql;	
} // end function build_select_duplicated_query

function build_insert_duplication_form($HTTP_POST_VARS, $conn, $table_name, $table_internal_name)
// goal: build a tabled form composed by two buttons: "Insert anyway" and "Go back"
// input: all the field values ($HTTP_POST_VARS), $conn, $table_name, $table_internal_name
// output: $form, the form
// global $submit_buttons_ar, the array containing the caption on submit buttons
{
	global $submit_buttons_ar;

	// get the array containg label ant other information about the fields
	$fields_labels_ar = build_fields_labels_array($conn, $table_name, $table_internal_name, "1");

	$form = "";

	$form .= "<table><tr><td>";

	$form .= "<form action=\"form.php?table_name=".urlencode($table_name)."\" method=\"post\"><input type=\"hidden\" name=\"insert_duplication\" value=\"1\"><input type=\"hidden\" name=\"function\" value=\"insert\">";

	// re-post all the fields values
	reset ($HTTP_POST_VARS);
	while (list($key, $value) = each ($HTTP_POST_VARS)){
		$$key = $value;
		
	} // end while

	for ($i=0; $i<count($fields_labels_ar); $i++){

		$field_name_temp = $fields_labels_ar[$i]["name_field"];

		if ($fields_labels_ar[$i]["present_insert_form_field"] == "1"){

			switch ($fields_labels_ar[$i]["type_field"]){
				case "select_multiple_menu":
				case "select_multiple_checkbox":
					if (isset($$field_name_temp)){
						for ($j=0; $j<count($$field_name_temp); $j++){
							$form .= "<input type=\"hidden\" name=\"".$field_name_temp."[".$j."]"."\" value=\"".htmlspecialchars(stripslashes(${$field_name_temp}[$j]))."\">";// add the field value to the sql statement
						} // end for
					} // end if
					break;
				case "date":
					$year_field = $field_name_temp."_year";
					$month_field = $field_name_temp."_month";
					$day_field = $field_name_temp."_day";

					$form .= "<input type=\"hidden\" name=\"".$year_field."\" value=\"".$$year_field."\">";
					$form .= "<input type=\"hidden\" name=\"".$month_field."\" value=\"".$$month_field."\">";
					$form .= "<input type=\"hidden\" name=\"".$day_field."\" value=\"".$$day_field."\">";
					break;
				case "select_single":
					if ($fields_labels_ar[$i]["other_choices_field"] == "1" and $HTTP_POST_VARS["$field_name_temp"] == "......"){ // other choice filled
						$field_name_other_temp = $field_name_temp."_other____";
						$form .= "<input type=\"hidden\" name=\"".$field_name_temp."\" value=\"".htmlspecialchars(stripslashes($$field_name_temp))."\">";
						$form .= "<input type=\"hidden\" name=\"".$field_name_other_temp."\" value=\"".htmlspecialchars(stripslashes($$field_name_other_temp))."\">";
					} // end if
					else{
						$form .= "<input type=\"hidden\" name=\"".$field_name_temp."\" value=\"".htmlspecialchars(stripslashes($$field_name_temp))."\">";
					} // end else
					
					break;
				default: // textual field
					if ($$fields_labels_ar[$i]["name_field"] == $fields_labels_ar[$i]["prefix_field"]){ // the field contain just the prefix
						$$fields_labels_ar[$i]["name_field"] = "";
					} // end if
						
					$form .= "<input type=\"hidden\" name=\"".$field_name_temp."\" value=\"".htmlspecialchars(stripslashes($$fields_labels_ar[$i]["name_field"]))."\">";
					break;
			} // end switch
		} // end if
	} // end for
	$form .= "<input type=\"submit\" value=\"".$submit_buttons_ar["insert_anyway"]."\"></form>";

	$form .= "</td><td>";

	$form .= "<form><input type=\"button\" value=\"".$submit_buttons_ar["go_back"]."\" onclick=\"javascript:history.back(-1)\"></form>";

	$form .= "</td></tr></table>";

	return $form;
} // end function build_insert_duplication_form

function build_send_mail_form($select_without_limit)
// goal: build an HTML form with a button "Send" to send email to all record found
// input: $select_without_limit, a sql select
// ouput: $form
// global: $submit_buttons_ar, the array containing the values of the submit buttons
{
	global $submit_buttons_ar;
	$form = "";
	$form .= "<form action=\"mail.php\" method=\"post\">";
	$form .= "<input type=\"hidden\" name=\"function\" value=\"form\">";
	$form .= "<input type=\"hidden\" name=\"select_without_limit\" value=\"$select_without_limit\">";
	$form .= "<input type=\"submit\" value=\"".$submit_buttons_ar["send"]."\">";
	$form .= "</form>";

	return $form;
} // end function send_mail_form

function build_print_labels_form($name_mailing)
// goal: build an HTML form with a button "Print labels" to print labels
// input: $name_mailing
// ouput: $print_labels_form
// global: $submit_buttons_ar, the array containing the values of the submit buttons
{
	global $submit_buttons_ar;
	$print_labels_form = "";
	$print_labels_form .= "<form action=\"mail.php\" method=\"post\">";
	$print_labels_form .= "<input type=\"hidden\" name=\"function\" value=\"send\">";
	$print_labels_form .= "<input type=\"hidden\" name=\"type_mailing\" value=\"labels\">";
	$print_labels_form .= "<input type=\"hidden\" name=\"name_mailing\" value=\"$name_mailing\">";
	$print_labels_form .= "<input type=\"submit\" value=\"".$submit_buttons_ar["print_labels"]."\">";
	$print_labels_form .= "</form>";

	return $print_labels_form;
} // end function build_print_labels_form

function build_email_form($from_addresses_ar)
// goal: build a tabled HTML form with field for a new mailing
// input: $from_addresses_ar, the array containing the from addresses
// ouput: $form
// global: $submit_buttons_ar, the array containing the values of the submit buttons and $normal_messages_ar, the array containg the normal messages
{
	global $submit_buttons_ar, $normal_messages_ar;
	$form = "";
	if (get_cfg_var("file_uploads")){
		$form .= "<form action=\"mail.php\" method=\"post\" enctype=\"multipart/form-data\">";
	} // end if
	else{
		$form .= "<form action=\"mail.php\" method=\"post\">";
	} // end else
	$form .= "<table>";
	$form .= "<tr><th>".$normal_messages_ar["mailing_name"]."</th><td><input type=\"text\" name=\"name_mailing\">&nbsp;".$normal_messages_ar["specify_mailing_name"]."</td></tr>";
	$form .= "<tr><th>".$normal_messages_ar["mailing_type"]."</th><td>".$normal_messages_ar["e-mail"]."<input type=\"radio\" name=\"type_mailing\" value=\"email\">&nbsp;&nbsp;&nbsp;&nbsp;".$normal_messages_ar["normal_mail"]."<input type=\"radio\" name=\"type_mailing\" value=\"normal_mail\"></td></tr>";
	$form .= "<tr><td colspan=\"2\"><i>".$normal_messages_ar["email_specific_fields"]."</i></td><td>";
	$form .= "<tr><td colspan=\"2\">&nbsp;</td><td>";
	$form .= "<tr><th><font color=\"#0000ff\">".$normal_messages_ar["from"]."</font></th><td>";
	$form .= "<select name=\"from_mailing\">";

	for ($i=0; $i<count($from_addresses_ar); $i++){
		$form .= "<option value=\"$i\">\"".$from_addresses_ar[$i][0]."\" &lt;".$from_addresses_ar[$i][1]."&gt;</option>";
	} // end for

	$form .= "</select>";

	$form .= "</td></tr>";
	$form .= "<tr><th><font color=\"#0000ff\">".$normal_messages_ar["subject"]."</th><td><input type=\"text\" name=\"subject_mailing\"></font></td></tr>";
	$form .= "<tr><th>".$normal_messages_ar["body"]."</th><td><input type=\"text\" name=\"salute_mailing\" value=\"".$normal_messages_ar["dear"]."\">".$normal_messages_ar["john_smith"]."<br><textarea name=\"body_mailing\" cols=\"30\" rows=\"10\"></textarea></td></tr>";
	if (get_cfg_var("file_uploads")){
		$form .= "<tr><th><font color=\"#0000ff\">".$normal_messages_ar["attachment"]."</th><td><input type=\"file\" name=\"attachment_mailing\"></font></td></tr>";
	} // end if
	$form .= "<tr><td colspan=\"2\">&nbsp;</td><td>";
	$form .= "<tr><td>".$normal_messages_ar["additional_notes_mailing"]."</th><td><textarea name=\"notes_mailing\" cols=\"30\" rows=\"10\"></textarea></td></tr>";
	$form .= "<tr><td colspan=\"2\">&nbsp;</td><td>";	
	$form .= "</table>";
	$form .= "<input type=\"hidden\" name=\"function\" value=\"new_create\">";
	$form .= "<input type=\"submit\" value=\"".$submit_buttons_ar["create_this_mailing"]."\">";
	$form .= "</form>";

	return $form;
} // end function build_email_form

function build_add_to_mailing_form($conn, $db_name, $res_mailing, $select_without_limit, $results_number)
// goal: build a tabled HTML form with add to mailing buttong and a select for choose mailing
// input: $conn, $db_name, $res_mailing, the result set of a sql select on all the mailing, $select_without_limit, the sql select on records, to pass as hidden value, $results_number, the number of records found in the search, to pass as hidden value
// output: $form, the form
// global: $submit_buttons_ar, the array containing the values of the submit buttons and $normal_messages_ar, the array containg the normal messages
{
	global $submit_buttons_ar, $normal_messages_ar;
	$mailing_select = build_mailing_select($conn, $db_name, $res_mailing);
	$form = "";
	$form .= "<form action=\"mail.php\" method=\"post\">";
	$form .= "<input type=\"submit\" value=\"".$submit_buttons_ar["add_to_mailing"]."\">";
	$form .= " $mailing_select ";
	$form .= "<input type=\"hidden\" name=\"select_without_limit\" value=\"$select_without_limit\">";
	$form .= "<input type=\"hidden\" name=\"function\"value=\"add_contacts\">";
	$form .= "<input type=\"hidden\" name=\"results_number\"value=\"$results_number\">";
	$form .= "</form>";

	return $form;
} // end function build_add_to_mailing_form

function build_mailing_select($conn, $db_name, $res_mailing)
// goal: build a select to choose the mailing
// input: $conn, $db_name, $res_mailing, the result set of a sql select on all the mailing
// output: $select, the html select
{
	$mailing_select = "";
	$mailing_select .= "<select name=\"name_mailing\">";
	while($mailing_row = fetch_row_db($res_mailing)){
		$name_mailing = $mailing_row["name_mailing"];

		$sql = "select count(*) as mailing_contact_number from mailing_contacts_tab where name_mailing = '".addslashes($name_mailing)."'";
		
		// execute the query
		$res_mailing_contact = execute_db("$sql", $conn);
		$mailing_contact_row = fetch_row_db($res_mailing_contact);
		$mailing_contact_number = $mailing_contact_row["mailing_contact_number"];

		$mailing_select .= "<option value=\"$name_mailing\">$name_mailing ($mailing_contact_number)</option>";
	} // end while
	$mailing_select .= "</select>";
	return $mailing_select;
} // end function build_mailing_select

function build_change_table_select($conn, $db_name, $exclude_not_allowed=1)
// goal: build a select to choose the table
// input: $conn, $db_name, $exclude_not_allowed
// output: $select, the html select
{
	global $table_name;
	$change_table_select = "";
	$change_table_select .= "<select name=\"table_name\">";

	if ($exclude_not_allowed == 1){

		// get the array containing the names of the tables (excluding "dadabik_" ones)
		$tables_names_ar = build_tables_names_array($db_name);
	} // end if
	else{
		// get the array containing the names of the tables (excluding "dadabik_" ones)
		$tables_names_ar = build_tables_names_array($db_name, 1, 0, 1);
	} // end else

	for($i=0; $i<count($tables_names_ar); $i++){
		$change_table_select .= "<option value=\"".htmlspecialchars($tables_names_ar[$i])."\"";
		if ($table_name == $tables_names_ar[$i]){
			$change_table_select .= " selected";
		}
		$change_table_select .= ">".$tables_names_ar[$i]."</option>";
	} // end for
	$change_table_select .= "</select>";
	if (count($tables_names_ar) == 1){
		return "";
	} // end if
	else{
		return $change_table_select;
	} // end else
} // end function build_change_table_select

function mailing_counter($conn, $db_name, $name_mailing)
// goal: count how many contact are present in a mailing
// input: $conn, $db_name, $name_mailing, the nama of the mailing
// output: $mailing_count, the number of contact
{
	$sql = "select count(*) as mailing_count from mailing_contacts_tab where name_mailing = '$name_mailing'";
	
	// execute the query
	$res_mailing_count = execute_db("$sql", $conn);
	$mailing_count_row = fetch_row_db($res_mailing_count);
	$mailing_count = $mailing_count_row["mailing_count"];
	return $mailing_count;
} // end function mailing_counter

function table_contains($table_name, $field_name, $value)
// goal: check if a table contains a record which has a field set to a specified value
// input: $table_name, $field_name, $value
// output: true or false
{
	global $conn, $quote;
	$sql = "select count(".$quote."".$field_name."".$quote.") from ".$quote."".$table_name."".$quote." where ".$quote."".$field_name."".$quote." = '".$value."'";
	$res_count = execute_db("$sql", $conn);
	$count_row = fetch_row_db($res_count);
	if ($count_row[0] > 0){
		return true;
	} // end if
	return false;
} // end function table_contains

function insert_record($HTTP_POST_FILES, $HTTP_POST_VARS, $conn, $db_name, $table_name, $table_internal_name)
// goal: insert a new record in the main database
// input $HTTP_POST_FILES (needed for the name of the files), $HTTP_POST_VARS (the array containing all the values inserted in the form), $conn, $db_name, $table_name, $table_internal_name
// output: nothing
{
	global $quote, $upload_directory;
	// get the post variables of the form
	reset ($HTTP_POST_VARS);
	while (list($key, $value) = each ($HTTP_POST_VARS)){
		$$key = $value;
	} // end while
	
	// get the array containg label ant other information about the fields
	$fields_labels_ar = build_fields_labels_array($conn, $table_name, $table_internal_name, "1");

	// build the insert statement
	/////////////////////////////
	$sql = "";
	$sql .= "insert into ".$quote."$table_name".$quote." (";
	
	for ($i=0; $i<count($fields_labels_ar); $i++){
		if ($fields_labels_ar[$i]["present_insert_form_field"] == "1" or $fields_labels_ar[$i]["type_field"] == "insert_date" or $fields_labels_ar[$i]["type_field"] == "update_date" or $fields_labels_ar[$i]["type_field"] == "ID_user" or $fields_labels_ar[$i]["type_field"] == "password_record"){ // if the field is in the form or need to be inserted because it's an insert data, an update data, an ID_user or a password_record
			$sql .= $quote.$fields_labels_ar[$i]["name_field"]."".$quote.", "; // add the field name to the sql statement
		} // end if
	} // end for

	$sql = substr("$sql", 0, (strlen($sql)-2));

	$sql .= ") values (";

	for ($i=0; $i<count($fields_labels_ar); $i++){
		if ($fields_labels_ar[$i]["present_insert_form_field"] == "1"){ // if the field is in the form
			switch ($fields_labels_ar[$i]["type_field"]){
				case "generic_file":
				case "image_file":
					$name_field_temp = $fields_labels_ar[$i]["name_field"];
					$file_name = $HTTP_POST_FILES["$name_field_temp"]['name'];
					
					if ($file_name != '') {
						$file_name = get_valid_name_uploaded_file($file_name);
					}

					$sql .= "'".$file_name."', "; // add the field value to the sql statement
					
					if ($file_name != '') {
						// rename the temp name of the uploaded file
						copy ($upload_directory.'dadabik_tmp_file_'.$file_name, $upload_directory.$file_name);
						unlink($upload_directory.'dadabik_tmp_file_'.$file_name);
					} // end if
					break;
				case "select_multiple_menu":
				case "select_multiple_checkbox":
					$sql .= "'";
					if (isset($$fields_labels_ar[$i]["name_field"])){ // otherwise the user hasn't checked any options
						for ($j=0; $j<count($$fields_labels_ar[$i]["name_field"]); $j++){
							$sql .= $fields_labels_ar[$i]["separator_field"].${$fields_labels_ar[$i]["name_field"]}[$j];// add the field value to the sql statement
						} // end for
						$sql .= $fields_labels_ar[$i]["separator_field"]; // add the last separator
					} // end if
					$sql .= "', ";
					break;
				case "date":
					$field_name_temp = $fields_labels_ar[$i]["name_field"];
					$year_field = $field_name_temp."_year";
					$month_field = $field_name_temp."_month";
					$day_field = $field_name_temp."_day";

					$mysql_date_value = $$year_field."-".$$month_field."-".$$day_field;
					$sql .= "'".$mysql_date_value."', "; // add the field value to the sql statement

					break;
				case "select_single":
					$field_name_temp = $fields_labels_ar[$i]["name_field"];
					$field_name_other_temp = $fields_labels_ar[$i]["name_field"]."_other____";

					if ($fields_labels_ar[$i]["other_choices_field"] == "1" and $$field_name_temp == "......" and $$field_name_other_temp != ""){ // insert the "other...." choice
						$sql .= "'".$$field_name_other_temp."', "; // add the field value to the sql statement

						$foreign_key_temp = $fields_labels_ar[$i]["foreign_key_field"];
						if ($foreign_key_temp != ""){
							if (substr($foreign_key_temp, 0, 4) != "SQL:"){ // with arbitrary sql statement the insert in the primary key table is not supported yet

								$primary_key_field_temp = substr($foreign_key_temp, (strpos($foreign_key_temp, ".") + 1), (strlen($foreign_key_temp) - (strpos($foreign_key_temp, ".") + 1))); // remove "table_name."

								$primary_key_table_temp = substr($foreign_key_temp, 0, strpos($foreign_key_temp, ".")); // remove ".field_name"

								if (!table_contains($primary_key_table_temp, $primary_key_field_temp, $$field_name_other_temp)){ // check if the table doesn't contains the value inserted as other

									$sql_insert_other = "insert into ".$primary_key_table_temp." (".$primary_key_field_temp.") values ('".$$field_name_other_temp."')";

									display_sql($sql_insert_other);
									
									// insert into the table of other
									$res_insert = execute_db("$sql_insert_other", $conn);
								} // end if
							} // end if
						} // end
						else{ // no foreign key field
							if (!eregi($fields_labels_ar[$i]["separator_field"].$$field_name_other_temp.$fields_labels_ar[$i]["separator_field"], $fields_labels_ar[$i]["select_options_field"])){ // the other field inserted is not already present in the $fields_labels_ar[$i]["select_options_field"] so we have to add it
								$select_options_field_updated = $fields_labels_ar[$i]["select_options_field"].$$field_name_other_temp.$fields_labels_ar[$i]["separator_field"];
								
								$sql_update_other = "update ".$quote."$table_internal_name".$quote." set ".$quote."select_options_field".$quote." = '".$select_options_field_updated."' where ".$quote."name_field".$quote." = '".$field_name_temp."'";
								display_sql($sql_update_other);
								
								// update the internal table
								$res_update = execute_db("$sql_update_other", $conn);

								// re-get the array containg label ant other information about the fields changed with the above instruction
								$fields_labels_ar = build_fields_labels_array($conn, $table_name, $table_internal_name, "1");
							} // end if
						} // end else

					} // end if
					else{
						$sql .= "'".$$field_name_temp."', "; // add the field value to the sql statement
					} // end else
					break;
				default: // textual field and select single
					if ($$fields_labels_ar[$i]["name_field"] == $fields_labels_ar[$i]["prefix_field"]){ // the field contain just the prefix
						$$fields_labels_ar[$i]["name_field"] = "";
					} // end if
					$sql .= "'".$$fields_labels_ar[$i]["name_field"]."', "; // add the field value to the sql statement
					break;
			} // end switch
			
		} // end if
		elseif ($fields_labels_ar[$i]["type_field"] == "insert_date" or $fields_labels_ar[$i]["type_field"] == "update_date"){ // if the field is not in the form but need to be inserted because it's an insert data or an update data
			$sql .= "'".date("Y-m-d H:i:s")."', "; // add the field name to the sql statement
		} // end elseif
		elseif ($fields_labels_ar[$i]["type_field"] == "ID_user"){ // if the field is not in the form but need to be inserted because it's an ID_user
			$user = get_user();
			$sql .= "'$user', "; // add the field name to the sql statement
		} // end elseif
		elseif ($fields_labels_ar[$i]["type_field"] == "password_record"){ // if the field is not in the form but need to be inserted because it's a password record
			$pass = md5(uniqid(microtime(), 1)).getmypid();
			$sql .= "'$pass', "; // add the field name to the sql statement
		} // end elseif
	} // end for

	$sql = substr("$sql", 0, (strlen($sql)-2));

	$sql .= ")";
	/////////////////////////////
	// end build the insert statement
	
	display_sql($sql);
	
	// insert the record
	$res_insert = execute_db("$sql", $conn);
} // end function insert_record

function update_record($HTTP_POST_FILES, $HTTP_POST_VARS, $conn, $db_name, $table_name, $table_internal_name, $where_field, $where_value, $update_type)
// goal: insert a new record in the main database
// input $HTTP_POST_FILES (needed for the name of the files), $HTTP_POST_VARS (the array containing all the values inserted in the form, $conn, $db_name, $table_name, $table_internal_name, $where_field, $where_value, $update_type (internal or external)
// output: nothing
// global: $ext_updated_field, the field in which we set if a field has been updated
{
    global $ext_updated_field, $quote, $upload_directory;
	// get the post variables of the form
	reset ($HTTP_POST_VARS);
	while (list($key, $value) = each ($HTTP_POST_VARS)){
		$$key = $value;
	} // end while

    switch($update_type){
        case "internal":
            $field_to_check = "present_insert_form_field";
            break;
        case "external":
            $field_to_check = "present_ext_update_form_field";
            break;
    } // end switch
	
	// get the array containg label ant other information about the fields
	$fields_labels_ar = build_fields_labels_array($conn, $table_name, $table_internal_name, "1");

	// build the update statement
	/////////////////////////////
	$sql = "";
	$sql .= "update ".$quote."$table_name".$quote." set ";
	
	for ($i=0; $i<count($fields_labels_ar); $i++){
		if ($fields_labels_ar[$i]["$field_to_check"] == "1" or $fields_labels_ar[$i]["type_field"] == "update_date"){ // if the field is in the form need to be inserted because it's an update data
			
			
			switch ($fields_labels_ar[$i]["type_field"]){
				case "generic_file":
				case "image_file":
					$name_field_temp = $fields_labels_ar[$i]["name_field"];
					$file_name = $HTTP_POST_FILES["$name_field_temp"]['name'];
					if ( $file_name != '') { // the user has selected a new file to upload
						
						$sql .= "".$quote."".$fields_labels_ar[$i]["name_field"]."".$quote." = "; // add the field name to the sql statement

						$file_name = get_valid_name_uploaded_file($file_name);

						$sql .= "'".$file_name."', "; // add the field value to the sql statement

						// rename the temp name of the uploaded file
						copy ($upload_directory.'dadabik_tmp_file_'.$file_name, $upload_directory.$file_name);
						unlink($upload_directory.'dadabik_tmp_file_'.$file_name);

						if (isset($HTTP_POST_VARS[$name_field_temp.'_file_uploaded_delete'])) { // the user want to delete a file previoulsy uploaded
							unlink($upload_directory.$HTTP_POST_VARS[$name_field_temp.'_file_uploaded_delete']);
						} // end if
					}
					elseif (isset($HTTP_POST_VARS[$name_field_temp.'_file_uploaded_delete'])) { // the user want to delete a file previoulsy uploaded
						$sql .= "".$quote."".$fields_labels_ar[$i]["name_field"]."".$quote." = "; // add the field name to the sql statement
						$sql .= "'', "; // add the field value to the sql statement
						unlink($upload_directory.$HTTP_POST_VARS[$name_field_temp.'_file_uploaded_delete']);
					}
					break;
				case "select_multiple_menu":
				case "select_multiple_checkbox":
					$sql .= "".$quote."".$fields_labels_ar[$i]["name_field"]."".$quote." = "; // add the field name to the sql statement
					$sql .= "'";
					for ($j=0; $j<count($$fields_labels_ar[$i]["name_field"]); $j++){
						$sql .= $fields_labels_ar[$i]["separator_field"].${$fields_labels_ar[$i]["name_field"]}[$j];// add the field value to the sql statement
					} // end for
					$sql .= $fields_labels_ar[$i]["separator_field"]; // add the last separator
					$sql .= "', ";
					break;
				case "update_date":
					$sql .= "".$quote."".$fields_labels_ar[$i]["name_field"]."".$quote." = "; // add the field name to the sql statement
					$sql .= "'".date("Y-m-d H:i:s")."', "; // add the field name to the sql statement
					break;
				case "date":
					$sql .= "".$quote."".$fields_labels_ar[$i]["name_field"]."".$quote." = "; // add the field name to the sql statement
					$field_name_temp = $fields_labels_ar[$i]["name_field"];
					$year_field = $field_name_temp."_year";
					$month_field = $field_name_temp."_month";
					$day_field = $field_name_temp."_day";

					$mysql_date_value = $$year_field."-".$$month_field."-".$$day_field;
					$sql .= "'".$mysql_date_value."', "; // add the field value to the sql statement

					break;
				default: // textual field and select single
					$sql .= "".$quote."".$fields_labels_ar[$i]["name_field"]."".$quote." = "; // add the field name to the sql statement
					$sql .= "'".$$fields_labels_ar[$i]["name_field"]."', "; // add the field value to the sql statement
					break;
			} // end switch			
		} // end if
	} // end for

	$sql = substr("$sql", 0, (strlen($sql)-2)); // delete the last two characters: ", "
	$sql .= " where ".$quote."$where_field".$quote." = '$where_value'";
	/////////////////////////////
	// end build the update statement
	
	display_sql($sql);
	
	// update the record
	$res_update = execute_db("$sql", $conn);

    if ($update_type == "external"){
    
        $sql = "update ".$quote."$table_name".$quote." set ".$quote."$ext_updated_field".$quote." = '1' where ".$quote."$where_field".$quote." = '$where_value' limit 1";
        display_sql($sql);
        
        // update the record
        $res_update = execute_db("$sql", $conn);
    } // end if
} // end function update_record

function build_select_query($HTTP_POST_VARS, $conn, $db_name, $table_name, $table_internal_name)
{
	global $quote;
	// get the post variables of the form
	reset ($HTTP_POST_VARS);
	while (list($key, $value) = each ($HTTP_POST_VARS)){
		$$key = $value;
	} // end while
	
	$sql = "";
	$select = "";
	$where = "";
	$select = "select * from ".$quote."$table_name".$quote."";
	
	// get the array containg label and other information about the fields
	$fields_labels_ar = build_fields_labels_array($conn, $table_name, $table_internal_name, "1");

	// build the where clause
	for ($i=0; $i<count($fields_labels_ar); $i++){
		$field_type_temp = $fields_labels_ar[$i]["type_field"];
		$field_name_temp = $fields_labels_ar[$i]["name_field"];
		$field_separator_temp = $fields_labels_ar[$i]["separator_field"];
		$field_select_type_temp = $fields_labels_ar[$i]["select_type_field"];

		if ($fields_labels_ar[$i]["present_search_form_field"] == "1"){
			switch ($field_type_temp){
				case "select_multiple_menu":
				case "select_multiple_checkbox":
					if (isset($$field_name_temp)){
						for ($j=0; $j<count(${$field_name_temp}); $j++){ // for each possible check
							if (${$field_name_temp}[$j] != ""){
								$where .= $quote.$field_name_temp."".$quote." like '%".$field_separator_temp."".${$field_name_temp}[$j].$field_separator_temp."%'";
								$where .= " $operator ";
							} // end if
						} // end for
					} // end if
					break;
				case "date":
				case "insert_date":
				case "update_date":
					$operator_field_name_temp = $field_name_temp."_operator";				
					if ($$operator_field_name_temp != ""){
						$year_field = $field_name_temp."_year";
						$month_field = $field_name_temp."_month";
						$day_field = $field_name_temp."_day";

						$mysql_date_value = $$year_field."-".$$month_field."-".$$day_field;

						$where .= "DATE_FORMAT(".$quote."$field_name_temp".$quote.", '%Y-%m-%d') ".$$operator_field_name_temp." '".$mysql_date_value."' $operator ";;
					} // end if				
					break;
				default:
					if ($$field_name_temp != ""){ // if the user has filled the field
						$select_type_field_name_temp = $field_name_temp."_select_type";
						if ($$select_type_field_name_temp != ""){ 
							switch ($$select_type_field_name_temp){								
								case "like":
									$where .= $quote.$field_name_temp."".$quote." like '%".${$field_name_temp}."%'";
									break;
								case "exactly":
									$where .= "".$quote."".$field_name_temp."".$quote." = '".${$field_name_temp}."'";
									break;
								default:
									$where .= $quote.$field_name_temp."".$quote." ".$$select_type_field_name_temp." '".${$field_name_temp}."'";			
									break;
							} // end switch
						} // end if
						else{
							switch ($field_select_type_temp){									
								case "like":
									$where .= $quote.$field_name_temp."".$quote." like '%".${$field_name_temp}."%'";
									break;
								case "exactly":
									$where .= $quote.$field_name_temp."".$quote." = '".${$field_name_temp}."'";
									break;
								default:
									$where .= $quote.$field_name_temp."".$quote." $field_select_type_temp '".${$field_name_temp}."'";
									break;
							} // end switch
						} // end else
						$where .= " $operator ";
					} // end if
					break;
			} //end switch
		} // end if
	} // end for ($i=0; $i<count($fields_labels_ar); $i++)

	$where = substr($where, 0, strlen($where) - (strlen($operator)+2)); // delete the last " and " or " or "
	if ($where != ""){
			$where = " where ".$where;
	} // end if

	// compose the entire sql statement
	$sql = $select.$where;

	return $sql;
} // end function build_select_query

function get_field_correct_displaying($field_value, $field_type, $field_content, $field_separator)
// get the correct mode to display a field, according to its content (e.g. format data, display select multiple in different rows without separator and so on
// input: $field_value, $field_type, $field_content, $field_separator
// output: $field_to_display, the field value ready to be displayed
// global: $word_wrap_col, the coloumn at which a string will be wrapped in the results
{
	global $word_wrap_col, $upload_relative_url;
	$field_to_display = "";
	switch ($field_type){
		case "generic_file":			
			$field_to_display = "<a href=\"".$upload_relative_url.rawurlencode(addslashes($field_value))."\">".htmlspecialchars($field_value)."</a>";		
			break;
		case "image_file":
			$field_to_display = "<img src=\"".$upload_relative_url.$field_value."\">";
			break;
		case "select_multiple_menu":
		case "select_multiple_checkbox":
			$field_value = substr($field_value, 1, strlen($field_value)-2); // delete the first and the last separator (-2 instead of -1 beacuse I start from 1!!)
			$select_values_ar = explode($field_separator,$field_value);
			for ($i=0; $i<count($select_values_ar); $i++){
				$field_to_display .= "$select_values_ar[$i]<br>";
			} // end for
			break;
		case "insert_date":
			if ($field_value != '0000-00-00 00:00:00'){
                $field_to_display = format_date($field_value);
            } // end if
            else{
                $field_to_display = "";
            } // end else
			break;
		case "update_date":
			if ($field_value != '0000-00-00 00:00:00'){
                $field_to_display = format_date($field_value);
            } // end if
            else{
                $field_to_display = "";
            } // end else
			break;
		case "date":
			if ($field_value != '0000-00-00 00:00:00'){
                $field_to_display = format_date($field_value);
            } // end if
            else{
                $field_to_display = "";
            } // end else
			break;

		default: // e.g. text, textarea and select sinlge
			if ($field_content == "email"){
				$field_to_display = "<a href=\"mailto:$field_value\">$field_value</a>";
			} // end if
			elseif ($field_content == "web"){
				$field_to_display = "<a href=\"$field_value\">$field_value</a>";
			} // end elseif
			else{
				$field_to_display = nl2br(wordwrap($field_value, $word_wrap_col));
			} // end else
			break;
	} // end switch
	return $field_to_display;
} // function get_field_correct_displaying

function build_results_table($conn, $db_name, $table_name, $table_internal_name, $res_contacts, $results_type, $name_mailing, $page, $action, $sql, $page, $order)
// goal: build an HTML table for basicly displaying the results of a select query or show a check mailing results
// input: $conn, $db_name, $table_name, $table_internal_name, $res_contacts, the results of the query, $results_type (search, possible_duplication, check_mailing......), $name_mailing, the name of the current mailing, $page, the results page (useful for check mailing), $action (form.php or mail.php), $sql (the sql clause), $page (o......n), $order
// output: $results_table, the HTML results table
// global: $submit_buttons_ar, the array containing the values of the submit buttons, $edit_target_window, the target window for edit/details (self, new......), $delete_icon, $edit_icon, $details_icon (the image files to use as icons), $enable_edit, $enable_delete, $enable_details (whether to enable (1) or not (0) the edit, delete and details features 
{
	global $submit_buttons_ar, $edit_target_window, $delete_icon, $edit_icon, $details_icon, $enable_edit, $enable_delete, $enable_details, $table_name, $quote;
	
	$sql = substr($sql, strlen("select * from ".$quote."$table_name".$quote.""), strlen($sql)); // I want to pass via GET just the part after where
	
	if ($action == "mail.php"){
		$function = "check_form";
	} // end if
	elseif($action == "form.php"){
		$function = "search";
	} // end elseif

	// get the array containg label ant other information about the fields
	$fields_labels_ar = build_fields_labels_array($conn, $table_name, $table_internal_name, "1");

	$unique_field_name = get_unique_field($conn, $db_name, $table_name);

	// build the results HTML table
	///////////////////////////////

	$results_table = "";

	// build the table heading
	$results_table .= "<table class=\"results\">";
	$results_table .= "<tr>";

	$results_table .= "<th class=\"results\">&nbsp;</th>"; // skip the first column for edit, delete and details

	for ($i=0; $i<count($fields_labels_ar); $i++){
			if ($fields_labels_ar[$i]["present_results_search_field"] == "1"){ // the user want to display the field in the basic search results page
				$results_table .= "<th class=\"results\">";
				if ($order != $fields_labels_ar[$i]["name_field"] and $results_type == "search" or $results_type == "check_mailing"){ // the results are not ordered by this field at the moment
					$results_table .= "<a class=\"order\" href=\"$action?&table_name=". urlencode($table_name)."&function=$function&sql=".urlencode($sql)."&name_mailing=".urlencode($name_mailing)."&page=$page&order=".urlencode($fields_labels_ar[$i]["name_field"])."\">".$fields_labels_ar[$i]["label_field"]."</a></th>"; // insert the linked name of the field in the <th>
				} // end if
				else{
					$results_table .= $fields_labels_ar[$i]["label_field"]."</th>"; // insert the  name of the field in the <th>
				} // end if
			} // end if
		} // end for
	$results_table .= "</tr>";

	// build the table body
	while ($contacts_row = fetch_row_db($res_contacts)){

		// set where clause for delete and update
		///////////////////////////////////////////
		if ($unique_field_name != ""){ // exists a unique number
			$where_field = $unique_field_name;
			$where_value = $contacts_row["$unique_field_name"];
		} // end if
		///////////////////////////////////////////
		// end build where clause for delete and update

		$results_table .= "<tr>";
		$results_table .= "<th class=\"results\">";

		if ($results_type == "check_mailing"){
			$results_table .= "<table cellspacing=\"0\" cellpadding=\"0\"><tr><td><form method=post action=\"mail.php\"><input type=\"hidden\" name=\"function\" value=\"remove_contact\"><input type=\"hidden\" name=\"name_mailing\" value=\"$name_mailing\"><input type=\"hidden\" name=\"where_field\" value=\"$where_field\"><input type=\"hidden\" name=\"where_value\" value=\"$where_value\"><input type=\"hidden\" name=\"page\" value=\"$page\"><input type=\"submit\" value=\"".$submit_buttons_ar["remove_from_mailing"]."\"></form></td></tr></table>";
		} // end if

		
		elseif ($unique_field_name != "" and ($results_type == "search" or $results_type == "possible_duplication")){ // exists a unique number: edit, delete, details make sense
			$results_table .= "<table cellspacing=\"0\" cellpadding=\"0\"><tr>";

			if ($enable_edit == "1"){ // display the edit icon 
				$results_table .= "<td><form method=post action=\"form.php?table_name=".urlencode($table_name)."\" target=\"_".$edit_target_window."\"><input type=\"hidden\" name=\"function\" value=\"edit\"><input type=\"hidden\" name=\"where_field\" value=\"$where_field\"><input type=\"hidden\" name=\"where_value\" value=\"$where_value\"><input type=\"image\" src=\"".$edit_icon."\" alt=\"".$submit_buttons_ar["edit"]."\" border=\"0\"></form></td>";
			} // end if

			if ($enable_delete == "1"){ // display the delete icon
				$results_table .= "<td><form method=post action=\"form.php?table_name=".urlencode($table_name)."\"><input type=\"hidden\" name=\"function\" value=\"delete\"><input type=\"hidden\" name=\"where_field\" value=\"$where_field\"><input type=\"hidden\" name=\"where_value\" value=\"$where_value\"><input type=\"image\" src=\"".$delete_icon."\" alt=\"".$submit_buttons_ar["delete"]."\" border=\"0\"></form></td>";
			} // end if

			if ($enable_details == "1"){ // display the details icon
				$results_table .= "<td><form method=post action=\"form.php?table_name=".urlencode($table_name)."\" target=\"_".$edit_target_window."\"><input type=\"hidden\" name=\"function\" value=\"details\"><input type=\"hidden\" name=\"where_field\" value=\"$where_field\"><input type=\"hidden\" name=\"where_value\" value=\"$where_value\"><input type=\"image\" src=\"".$details_icon."\" alt=\"".$submit_buttons_ar["details"]."\" border=\"0\"></form></td>";
			} // end if
			
			$results_table .= "</tr></table>";
		} // end if
		
		$results_table .= "</td>";
		for ($i=0; $i<count($fields_labels_ar); $i++){
			if ($fields_labels_ar[$i]["present_results_search_field"] == "1"){ // the user want to display the field in the basic search results page
				$results_table .= "<td valign=\"top\" nowrap class=\"results\">"; // start the cell
				
				$field_name_temp = $fields_labels_ar[$i]["name_field"];
				$field_value = $contacts_row["$field_name_temp"];
				$field_type = $fields_labels_ar[$i]["type_field"];
				$field_content = $fields_labels_ar[$i]["content_field"];
				$field_separator = $fields_labels_ar[$i]["separator_field"];

				$field_to_display = get_field_correct_displaying(htmlspecialchars($field_value), $field_type, $field_content, $field_separator); // get the correct display mode for the field

				$results_table .= $field_to_display; // at the field value to the table

				$results_table .= "&nbsp;</td>"; // end the cell
			} // end if
		} // end for
		
		$results_table .= "</tr>";
	} // end while
	$results_table .= "</table>";
	
	return $results_table;

} // end function build_results_table

function build_details_table($conn, $db_name, $table_name, $table_internal_name, $res_details)
// goal: build an html table with details of a record
// input: $conn, $db_name, $table_name, $table_internal_name, $res_details (the result of the query)
// ouptut: $details_table, the html table
{
	// get the array containg label ant other information about the fields
	$fields_labels_ar = build_fields_labels_array($conn, $table_name, $table_internal_name, "1");

	// build the table
	$details_table = "";

	$details_table .= "<table>";

	while ($details_row = fetch_row_db($res_details)){

		for ($i=0; $i<count($fields_labels_ar); $i++){
			if ($fields_labels_ar[$i]["present_details_form_field"] == "1"){
				$field_name_temp = $fields_labels_ar[$i]["name_field"];
				
				$field_to_display = get_field_correct_displaying(htmlspecialchars($details_row["$field_name_temp"]), $fields_labels_ar[$i]["type_field"], $fields_labels_ar[$i]["content_field"], $fields_labels_ar[$i]["separator_field"]); // get the correct display mode for the field

				$details_table .= "<tr><td valign=\"top\" align=\"right\"><b>".$fields_labels_ar[$i]["label_field"]."</b></td><td>".$field_to_display."</td></tr>";
			} // end if
		} // end for
	} // end while

	$details_table .= "</table>";

	return $details_table;
} // end function build_details_table

function build_navigation_tool($sql, $pages_number, $page, $action, $name_mailing, $order)
// goal: build a set of link to go forward and back in the result pages
// input: $sql (the sql query without limit clause, used to re-pass to form.php), $pages_number (total number of pages), $page (the page at the moment 0....n), $action, the action page (e.g. form.php or mail.php), $name_mailing, the name of the current mailing, $order, the field used to order the results
// output: $navigation_tool, the html navigation tool
{
	global $table_name, $quote;
	$sql = substr($sql, strlen("select * from ".$quote."$table_name".$quote.""), strlen($sql)); // I want to pass via GET just the part after where
	if ($action == "mail.php"){
		$function = "check_form";
	} // end if
	elseif($action == "form.php"){
		$function = "search";
	} // end elseif
	$navigation_tool = "";

	$page_group = (int)($page/10); // which group? (from 0......n) e.g. page 12 is in the page_group 1 
	$total_groups = ((int)(($pages_number-1)/10))+1; // how many groups? e.g. with 32 pages 4 groups
	$start_page = $page_group*10; // the navigation tool start with $start_page, end with $end_page
	if ($start_page+10 > $pages_number){
		$end_page = $pages_number;
	} // end if
	else{
		$end_page = $start_page+10;
	} // end else
	
	if ($page_group > 1){
		$navigation_tool .= "<a class=\"navig\" href=\"$action?&table_name=". urlencode($table_name)."&function=$function&sql=".urlencode($sql)."&name_mailing=".urlencode($name_mailing)."&page=0&order=$order\" title=\"1\">&lt;&lt;</a> ";
	} // end if
	if ($page_group > 0){
		$navigation_tool .= "<a class=\"navig\" href=\"$action?&table_name=". urlencode($table_name)."&function=$function&sql=".urlencode($sql)."&name_mailing=".urlencode($name_mailing)."&page=".((($page_group-1)*10)+9)."&order=$order\" title=\"".((($page_group-1)*10)+10)."\">&lt;</a> ";
	} // end if

	for($i=$start_page; $i<$end_page; $i++){
		if ($i != $page){
			$navigation_tool .= "<a class=\"navig\" href=\"$action?&table_name=". urlencode($table_name)."&function=$function&sql=".urlencode($sql)."&name_mailing=".urlencode($name_mailing)."&page=$i&order=$order\">".($i+1)."</a> ";
		} // end if
		else{
			$navigation_tool .= "<b>".($i+1)."</b> ";
		} //end else
	} // end for

	if(($page_group+1) < ($total_groups)){
		$navigation_tool .= "<a class=\"navig\" href=\"$action?&table_name=". urlencode($table_name)."&function=$function&sql=".urlencode($sql)."&name_mailing=".urlencode($name_mailing)."&page=".(($page_group+1)*10)."&order=$order\" title=\"".((($page_group+1)*10)+1)."\">&gt;</a> ";
	} // end elseif
	if (($page_group+1) < ($total_groups-1)){
		$navigation_tool .= "<a class=\"navig\" href=\"$action?&table_name=". urlencode($table_name)."&function=$function&sql=".urlencode($sql)."&name_mailing=".urlencode($name_mailing)."&page=".($pages_number-1)."&order=$order\" title=\"".$pages_number."\">&gt;&gt;</a> ";
	} // end if
	return $navigation_tool;
} // end function build_navigation_tool

function build_are_you_sure_form($where_field, $where_value, $conn, $db_name, $table_name, $table_internal_name)
// goal: build a form with a confirmation message and buttons yes/no before deleting a record
// input: $where_field and $where_value, field and value of the where clause of the delete query, in order to re-pass to form.php, $conn, $db_name, $table_name, $table_internal_name
// output: $are_you_sure_form, the form with the buttons
// global $submit_buttons_ar, the array containing the value of submit buttons
{
global $submit_buttons_ar, $quote;

$are_you_sure_form = "";

$where_field = stripslashes($where_field);
$where_value = stripslashes($where_value);

$sql = "select * from ".$quote."$table_name".$quote." where ".$quote."$where_field".$quote." = '$where_value'";

// execute the select query
$res_details = execute_db("$sql", $conn);

// build the HTML details table
$details_table = build_details_table($conn, $db_name, $table_name, $table_internal_name, $res_details);

$are_you_sure_form .= "<table><tr>";
$are_you_sure_form .= "<td><form method=\"post\" action=\"form.php?table_name=".urlencode($table_name)."\"><input type=\"hidden\" name=\"delete_sure\" value=\"1\"><input type=\"hidden\" name=\"function\" value=\"delete\"><input type=\"hidden\" name=\"where_field\" value=\"$where_field\"><input type=\"hidden\" name=\"where_value\" value=\"$where_value\"><input type=\"submit\" value=\"".$submit_buttons_ar["yes"]."\"></form></td>";
$are_you_sure_form .= "<td><form><input type=\"button\" onclick=\"javascript:history.back(-1)\" value=\"".$submit_buttons_ar["no"]."\"></form></td>";
$are_you_sure_form .= "</tr></table>";

$are_you_sure_form .= $details_table;

return $are_you_sure_form;
} // end function build_are_you_sure_form

function build_are_you_sure_send_form($name_mailing)
// goal: build a form with a confirmation message and buttons yes/no before sending a mailing
// input: $mailing_name, the name of the mailing
// output: $are_you_sure_send_form, the form with the buttons
// global $submit_buttons_ar, the array containing the value of submit buttons
{
global $submit_buttons_ar;

$are_you_sure_send_form = "";

$are_you_sure_send_form .= "<table><tr>";
$are_you_sure_send_form .= "<td><form method=\"post\" action=\"mail.php\"><input type=\"hidden\" name=\"function\" value=\"send\"><input type=\"hidden\" name=\"send_sure\" value=\"1\"><input type=\"hidden\" name=\"name_mailing\" value=\"$name_mailing\"><input type=\"submit\" value=\"".$submit_buttons_ar["yes"]."\"></form></td>";
$are_you_sure_send_form .= "<td><form><input type=\"button\" onclick=\"javascript:history.back(-1)\" value=\"".$submit_buttons_ar["no"]."\"></form></td>";
$are_you_sure_send_form .= "</tr></table>";

return $are_you_sure_send_form;
} // end function build_are_you_sure_send_form

function build_remove_all_form($name_mailing)
// goal: build a form with a button remove all for the check mailing page
// input: $name_mailing, the name of the mailing
// output: $remove_all_form, the form
// global: $submit_buttons_ar, the array containing the value of submit buttons
{
	global $submit_buttons_ar;
	$remove_all_form = "<form action=\"mail.php\" method=\"post\">";
	$remove_all_form .= "<input type=\"hidden\" name=\"remove_type\" value=\"all\">";
	$remove_all_form .= "<input type=\"hidden\" name=\"name_mailing\" value=\"$name_mailing\">";
	$remove_all_form .= "<input type=\"hidden\" name=\"function\" value=\"remove_contact\">";
	$remove_all_form .= "<input type=\"submit\" value=\"".$submit_buttons_ar["remove_all_from_mailing"]."\">";
	$remove_all_form .= "</form>";
	return $remove_all_form;
} // end function build_remove_all_form

function delete_record ($conn, $db_name, $table_name, $where_field, $where_value)
{
	global $quote;
	$sql = "";
	$sql .= "delete from ".$quote."$table_name".$quote." where ".$quote."$where_field".$quote." = '$where_value' limit 1";
	display_sql($sql);

	// execute the select query
	$res_contacts = execute_db("$sql", $conn);

} // end function delete_record

function required_field_present($conn, $table_name, $table_internal_name)
// goal: check if there are at least one required field
// input: $conn, $table_name, $table_internal_name
// output: true or false
{
	global $quote;

	$sql = "select count(".$quote."required_field".$quote.") as count_required from ".$quote."$table_internal_name".$quote." where ".$quote."required_field".$quote." = '1'";

	// execute the select query
	$res_count = execute_db("$sql", $conn);

	$count_row = fetch_row_db($res_count);

	$count = $count_row["count_required"];

	if ($count > 0){
		return true;
	} // end if
	else{
		return false;
	} // end else
} // end function required_field_present

function create_internal_table($conn, $table_internal_name)
// goal: drop (if present) the old internal table and create the new one.
// input: $conn, $table_internal_name
{
	global $quote;

	// drop the old table
	$sql = "DROP TABLE IF EXISTS ".$quote."$table_internal_name".$quote."";
	$res_table = execute_db("$sql", $conn);

	// create the new one
	$sql ="CREATE TABLE ".$quote."$table_internal_name".$quote." (
	  name_field varchar(50) NOT NULL default '',
	  label_field varchar(255) NOT NULL default '',
	  type_field ENUM('text','textarea','password','insert_date','update_date','date','select_single','select_multiple_menu','select_multiple_checkbox','generic_file','image_file','ID_user','password_record') NOT NULL default 'text',
	  content_field ENUM('alphabetic','alphanumeric','numeric','web','email','phone','city') NOT NULL DEFAULT 'alphanumeric',
	  present_search_form_field ENUM('0','1') DEFAULT '1' NOT NULL,
	  present_results_search_field ENUM('0','1') DEFAULT '1' NOT NULL,
	  present_details_form_field ENUM('0','1') DEFAULT '1' NOT NULL,
	  present_insert_form_field ENUM('0','1') DEFAULT '1' NOT NULL,
	  present_ext_update_form_field ENUM('0','1') DEFAULT '1' NOT NULL,
	  required_field ENUM('0','1') DEFAULT '0' NOT NULL,
	  check_duplicated_insert_field ENUM('0','1') DEFAULT '0' NOT NULL,
	  other_choices_field ENUM ('0','1') DEFAULT '0' NOT NULL,
	  select_options_field text NOT NULL default '',
	  foreign_key_field TEXT NOT NULL,
	  db_primary_key_field VARCHAR(255) NOT NULL,
	  select_type_field varchar(50) NOT NULL default 'exactly/like/>/<',
	  prefix_field TEXT NOT NULL default '',
	  default_value_field TEXT NOT NULL default '',
	  width_field VARCHAR(5) NOT NULL,
	  height_field VARCHAR(5) NOT NULL,
	  maxlength_field VARCHAR(5) NOT NULL default '100',
	  hint_insert_field VARCHAR(255) NOT NULL,
	  order_form_field smallint(6) NOT NULL,
	  separator_field varchar(2) NOT NULL default '~',
	  PRIMARY KEY  (name_field)
	) TYPE=MyISAM
	";
	$res_table = execute_db("$sql", $conn);
} // end function create_internal_table

function create_table_list_table($conn)
// goal: drop (if present) the old internal table and create the new one.
// input: $conn
{
	global $table_list_name, $quote;

	// drop the old table
	$sql = "DROP TABLE IF EXISTS ".$quote."$table_list_name".$quote."";
	$res_table = execute_db("$sql", $conn);

	// create the new one
	$sql ="CREATE TABLE ".$quote."$table_list_name".$quote." (
	  name_table varchar(255) NOT NULL default '',
	  allowed_table tinyint(4) NOT NULL default '0',
	  enable_insert_table varchar(5) NOT NULL default '',
	  enable_edit_table varchar(5) NOT NULL default '',
	  enable_delete_table varchar(5) NOT NULL default '',
	  enable_details_table varchar(5) NOT NULL default '',

	  PRIMARY KEY  (name_table),
	  UNIQUE KEY name_table (name_table)
	  ) TYPE=MyISAM
	";
	$res_table = execute_db("$sql", $conn);
} // end function create_table_list_table

function table_allowed($conn, $table_name)
// goal: check if a table is allowed to be managed by DaDaBIK
// input: $table_name
// output: true or false
{
	global $table_list_name, $db_name, $quote;
	if (table_exists($db_name, $table_list_name)){
		$sql = "select ".$quote."allowed_table".$quote." from ".$quote."$table_list_name".$quote." where ".$quote."name_table".$quote." = '$table_name'";
		$res_allowed = execute_db("$sql", $conn);
		if (get_num_rows_db($res_allowed) == 1){
			$row_allowed = fetch_row_db($res_allowed);
			$allowed_table = $row_allowed[0];
			if ($allowed_table == "0"){
				return false;
			} // end if
			else{
				return true;
			} // end else
		} // end if
		elseif (get_num_rows_db($res_allowed) == 0){ // e.g. I have an empty table
			return false;
		} // end elseif
		else{
			exit;
		} // end else
	} // end if
	else{
		return false;
	} // end else
} // end function table_allowed()

function build_enabled_features_ar($table_name)
// goal: build an array containing "0" or "1" according to the fact that a feature (insert, edit, delete, details) is enabled or not
// input: $table_name, $table_internal_name
// output: $enabled_features_ar, the array
{
	global $conn, $table_list_name, $quote;
	$sql = "select ".$quote."enable_insert_table".$quote.", ".$quote."enable_edit_table".$quote.", ".$quote."enable_delete_table".$quote.", ".$quote."enable_details_table".$quote." from ".$quote."$table_list_name".$quote." where ".$quote."name_table".$quote." = '$table_name'";
	$res_enable = execute_db("$sql", $conn);
	if (get_num_rows_db($res_enable) == 1){
		$row_enable = fetch_row_db($res_enable);
		$enabled_features_ar["insert"] = $row_enable["enable_insert_table"];
		$enabled_features_ar["edit"] = $row_enable["enable_edit_table"];
		$enabled_features_ar["delete"] = $row_enable["enable_delete_table"];
		$enabled_features_ar["details"] = $row_enable["enable_details_table"];

		return $enabled_features_ar;
	} // end if
	else{
		db_error($sql);
	} // end else
} // end if

function build_enable_features_checkboxes($table_name)
// goal: build the form that enable features
// input: name of the current table
// output: the html for the checkboxes
{
	$enabled_features_ar = build_enabled_features_ar($table_name);

	$enable_features_checkboxes = "";
	$enable_features_checkboxes .= "<input type=\"checkbox\" name=\"enable_insert\" value=\"1\"";
	$enable_features_checkboxes .= "";
	if ($enabled_features_ar["insert"] == "1"){
		$enable_features_checkboxes .= "checked";
	} // end if
	$enable_features_checkboxes .= ">Insert ";
	$enable_features_checkboxes .= "<input type=\"checkbox\" name=\"enable_edit\" value=\"1\"";
	if ($enabled_features_ar["edit"] == "1"){
		$enable_features_checkboxes .= "checked";
	} // end if
	$enable_features_checkboxes .= ">Edit ";
	$enable_features_checkboxes .= "<input type=\"checkbox\" name=\"enable_delete\" value=\"1\"";
	if ($enabled_features_ar["delete"] == "1"){
		$enable_features_checkboxes .= "checked";
	} // end if
	$enable_features_checkboxes .= ">Delete ";
	$enable_features_checkboxes .= "<input type=\"checkbox\" name=\"enable_details\" value=\"1\"";
	if ($enabled_features_ar["details"] == "1"){
		$enable_features_checkboxes .= "checked";
	} // end if
	$enable_features_checkboxes .= ">Details ";

	return $enable_features_checkboxes;
} // end function build_enable_features_checkboxes

function build_change_field_select($fields_labels_ar, $field_position)
// goal: build an html select with all the field names
// input: $fields_labels_ar, $field_position (the current selected option)
// output: the select
{
	global $conn, $db_name, $table_name;

	//$fields_names_ar = build_fields_names_array($conn, $db_name, $table_name);

	$change_field_select = "";
	$change_field_select .= "<select name=\"field_position\">";
	for ($i=0; $i<count($fields_labels_ar); $i++){
		$change_field_select .= "<option value=\"".$i."\"";
		if ($i==$field_position){
			$change_field_select .= " selected";
		} // end if
		$change_field_select .=	">".$fields_labels_ar[$i]["name_field"]."</option>";
		//$change_field_select .=	">".$fields_names_ar[$i]."</option>";
	} // end for
	$change_field_select .= "</select>";

	return $change_field_select;
} // end function build_change_field_select

function build_int_table_field_form($field_position, $int_fields_ar, $fields_labels_ar)
// goal: build a part of the internal table manager form relative to one field
// input: $field_position, the position of the field in the internal form, $int_field_ar, the array of the field of the internal table (with labels and properties), $fields_labels_ar, the array containing the fields labels and other information about fields
// output: the html form part
{
	$int_table_form = "";
	$int_table_form .= "<table border=\"0\" cellpadding=\"6\"><tr bgcolor=\"#F0F0F0\"><td><table>";
	for ($j=0; $j<count($int_fields_ar); $j++){
		$int_table_form .= "<tr>";
		$int_field_name_temp = $int_fields_ar[$j][1];
		$int_table_form .= "<td>".$int_fields_ar[$j][0]."</td><td>";
		if ($j==0){ // it's the name of the field
			$int_table_form .= $fields_labels_ar[$field_position][$int_field_name_temp];
		} // end if
		else{			
			switch ($int_fields_ar[$j][2]){
				case "text":
					$int_table_form .= "<input type=\"text\" name=\"".$int_field_name_temp."_".$field_position."\" value=\"".$fields_labels_ar[$field_position][$int_field_name_temp]."\" size=\"".$int_fields_ar[$j][3]."\">";
					break;
				case "select_yn":
					$int_table_form .= "<select name=\"".$int_field_name_temp."_".$field_position."\">";
					$int_table_form .= "<option value=\"1\"";
					if ($fields_labels_ar[$field_position][$int_field_name_temp] == "1"){
						$int_table_form .= " selected";
					} // end if	
					$int_table_form .= ">Y</option>";
					$int_table_form .= "<option value=\"0\"";
					if ($fields_labels_ar[$field_position][$int_field_name_temp] == "0"){
						$int_table_form .= " selected";
					} // end if	
					$int_table_form .= ">N</option>";
					$int_table_form .= "</select>";
					break;
				case "select_custom":
					$int_table_form .= "<select name=\"".$int_field_name_temp."_".$field_position."\">";
					$temp_ar = explode("/", $int_fields_ar[$j][3]);
					for ($z=0; $z<count($temp_ar); $z++){
						$int_table_form .= "<option value=\"".$temp_ar[$z]."\"";
						if ($fields_labels_ar[$field_position][$int_field_name_temp] == $temp_ar[$z]){
							$int_table_form .= " selected";
						} // end if	
						$int_table_form .= ">".$temp_ar[$z]."</option>";
					} // end for
					$int_table_form .= "</select>";
					break;
			} // end switch
		} // end else
		$int_table_form .= "</td>";
		$int_table_form .= "</tr>"; // end of the row
	} // end for
	$int_table_form .= "</table></td></tr></table><p>&nbsp;</p>"; // end of the row

	return $int_table_form;
}

function get_valid_name_uploaded_file ($file_name)
{
// goal: get a valid name (not already existant) for an uploaded file, e.g. if I upload a file with the name file.txt, and a file with the same name already exists, return file_2.txt, or file_3.txt......
// input: $file_name
// a valid name

	global $upload_directory;
	$valid_file_name = $file_name;
	$valid_name_found = 0;

	$dot_position = strpos($file_name, '.');

	$i = 2;
	do{
		if ( is_file($upload_directory.$valid_file_name) ) { // a file with the same name is already present
			if ($dot_position === false) { // the file doesn't have an exension
				$valid_file_name = $file_name.'_'.$i; // from pluto to pluto_2
			}
			else{
				$valid_file_name = substr($file_name, 0, $dot_position).'_'.$i.substr($file_name, $dot_position); // from pluto.txt to pluto_2,txt
			}
			$i++;
		} // end if ( is_file($upload_directory.$file_name) )
		else{
			$valid_name_found = 1;
		}
	} while ( $valid_name_found==0 );	

	return $valid_file_name;

} // end function get_valid_name_uploaded_file ($file_name)