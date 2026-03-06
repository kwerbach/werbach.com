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

// include config, functions, common, check_table and header
include ("./include/config.php");
include ("./include/functions.php");
include ("./include/common.php");
include ("./include/check_table.php");
include ("./include/header.php");


// HTTP Variables:
/***************** GET ***************************
$form_type
	(insert,search)
	from index.php
$sql
	contains the where clause, without limit and order e.g. "where field = 'value'" (all url encoded)
	from the form or from the navigation buttons 
$page
	the actual page in records results
	from form.php (from the search form or from the navigation tool), from 0......n
$order
	the field used to order the form
$function
	the function: search/update/insert/update......
***************************************************/
if (isset($HTTP_GET_VARS["form_type"])){
	$form_type = $HTTP_GET_VARS["form_type"];
} // end if

if (isset($HTTP_GET_VARS["sql"])){
	$sql = stripslashes($HTTP_GET_VARS["sql"]);
} // end if

if (isset($HTTP_GET_VARS["page"])){
	$page = $HTTP_GET_VARS["page"];
} // end if
else{
	$page = "";
} // end else

if (isset($HTTP_GET_VARS["order"])){
	$order = stripslashes($HTTP_GET_VARS["order"]);
} // end 
else{	
	$order = "";
} // end else

if (isset($HTTP_GET_VARS["function"])){ // from the homepage
	$function = $HTTP_GET_VARS["function"];
} // end 
else{
	if (isset($HTTP_POST_VARS["function"])){
		$function = $HTTP_POST_VARS["function"];
	} // end if
	else{
		$function = "";
	} // end else
} // end else

/***************** POST ***************************
All the variables of the form
	from form.php
$where
	the where clause of delete and edit
	form form.php
$delete_sure
	set to 1 if the user is sure to delete a record
	from form.php
$insert_duplication
	set to 1 if the user want to insert anyway, even if duplication are possible.
***************************************************/

if (isset($HTTP_POST_VARS["where_field"])){
	$where_field = $HTTP_POST_VARS["where_field"];
} // end if
else{
	$where_field = "";
} // end else

if (isset($HTTP_POST_VARS["where_value"])){
	$where_value = $HTTP_POST_VARS["where_value"];
} // end if
else{
	$where_value = "";
} // end else

if (isset($HTTP_POST_VARS["delete_sure"])){
	$delete_sure = $HTTP_POST_VARS["delete_sure"];
} // end if
else{
	$delete_sure = "";
} // end else

if (isset($HTTP_POST_VARS["insert_duplication"])){
	$insert_duplication = $HTTP_POST_VARS["insert_duplication"];
} // end if
else{
	$insert_duplication = "";
} // end else

$action = "form.php";

// get the array containg label ant other information about the fields
$fields_labels_ar = build_fields_labels_array($conn, $table_name, $table_internal_name, "1");

switch($function){
	case "insert":
		if ($enable_insert == "1") {
			if ($insert_duplication != "1"){ // otherwise would be checked for two times
				// check values
				$check = 0;
				$check = check_required_fields($HTTP_POST_VARS, $fields_labels_ar);
				if ($check == 0){
					display_message($normal_messages_ar["required_fields_missed"], "", "", "");
				} // end if ($check == 0)
				else{ // required fields are ok
					// check textarea length
					$check = 0;
					$check = check_length_fields($HTTP_POST_VARS, $fields_labels_ar);
					if ($check == 0){
						display_message($normal_messages_ar["fields_max_length"], "", "", "");
					} // end if ($check == 0)
					else{ // fields length are ok
						$check = 0;
						$content_error_type = "";
						$check = check_fields_types($HTTP_POST_VARS, $fields_labels_ar, $content_error_type);
						if ($check == 0){
							display_message($normal_messages_ar["{$content_error_type}_not_valid"], "", "", "");
						} // end if ($check == 0)
						else{ // type field are ok
							$check = 0;
							$check = write_uploaded_files($HTTP_POST_FILES, $fields_labels_ar);
							if ($check == 0){
								//Need to add the reason why the upload failed: file too large, improper filename (such as a .php file), or the file couldn't be found.
								display_message($error_messages_ar["upload_error"], "", "", "");
							} // end if ($check == 0)
							else{ // uploaded files are ok
								// check for duplicated insert in the database
								$sql = build_select_duplicated_query($HTTP_POST_VARS, $conn, $db_name, $table_name, $fields_labels_ar, $string1_similar_ar, $string2_similar_ar);

								if ($sql != ""){ // if there are some duplication
								display_message("<h3>".$normal_messages_ar["duplication_possible"]."</h3>", "", "", "");
									if ($display_is_similar == 1){
										for ($i=0; $i<count($string1_similar_ar); $i++){
											display_message("<br>","","","");
											display_message($normal_messages_ar["i_think_that"],"","","");
											display_message($string1_similar_ar[$i],"","","1");
											display_message($normal_messages_ar["is_similar_to"],"","","");
											display_message($string2_similar_ar[$i],"","","1");
										} // end for
									} // end if ($display_is_similar == 1)						
									
									display_sql($sql);

									// execute the select query
									$res_contacts = execute_db("$sql", $conn);

									$results_type = "possible_duplication";
									$select_without_limit = ""; // I don't need it here, I've just a fixed number of results.

									$results_table = build_results_table($conn, $db_name, $table_name, $table_internal_name, $res_contacts, $results_type, "", "", $action, $select_without_limit, "", "");

									display_message ($normal_messages_ar["similar_records"], "", "", "");

									$insert_duplication_form = build_insert_duplication_form($HTTP_POST_VARS, $conn, $table_name, $table_internal_name);

									echo $insert_duplication_form;
									echo $results_table;
								} // end if
								else{ // no duplication
									// insert a new record
									insert_record($HTTP_POST_FILES, $HTTP_POST_VARS, $conn, $db_name, $table_name, $table_internal_name);
									
									display_message("<p>".$normal_messages_ar["insert_result"], "", "", "");
									display_message($normal_messages_ar["record_inserted"], "", "", "1");
									display_message("<h3>".$normal_messages_ar["insert_record"]."</h3>", "", "", "1");

									$form_type = "insert";
									 
									$res_details = "";

									// re-get the array containg label ant other information about the fields, could be changed in the insert (other choices......)
									$fields_labels_ar = build_fields_labels_array($conn, $table_name, $table_internal_name, "1");

									// display the form
									$form = build_form($action, $fields_labels_ar, $form_type, $res_details, $where_field, $where_value, $conn);
									echo $form;
								} // end else
							} // end else
						} // end else
					} // end else
				} // end else
			} // end if ($insert_duplication != "1")

			else{  // $insert_duplication == "1"
				
				// insert a new record
				insert_record($HTTP_POST_FILES, $HTTP_POST_VARS, $conn, $db_name, $table_name, $table_internal_name);

				display_message("<p>".$normal_messages_ar["insert_result"], "", "", "");
				display_message($normal_messages_ar["record_inserted"], "", "", "1");
				display_message("<h3>".$normal_messages_ar["insert_record"]."</h3>", "", "", "1");

				$form_type = "insert";
				$res_details = "";

				// re-get the array containg label ant other information about the fields, could be changed in the insert (other choices......)
				$fields_labels_ar = build_fields_labels_array($conn, $table_name, $table_internal_name, "1");


				// display the form
				$form = build_form($action, $fields_labels_ar, $form_type, $res_details, $where_field, $where_value, $conn);
				echo $form;
				
			} // end else
		} // end if
		break;
	case "search":
		// build the select query
		if (!isset($sql)){ // otherwise we have the $sql from navigation buttons 1 2 3 etc
            $select_without_limit = build_select_query($HTTP_POST_VARS, $conn, $db_name, $table_name, $table_internal_name, $records_per_page, $page);
        } // end if
        else{
			$select_without_limit = "select * from ".$quote."$table_name".$quote."";
			if ($sql != ""){
				$select_without_limit .= $sql;
			} // end if
        } // end else

		$sql = $select_without_limit;

		if ($order != ""){
			$sql .= " order by ".$quote.$order.$quote;
		} // end if
		
		// execute the select without limit query to get the number of results
		$res_contacts_without_limit = execute_db("$select_without_limit", $conn);

		$results_number = get_num_rows_db($res_contacts_without_limit); // get the number of results
		
		// add limit clause
		$sql .= " limit ".$page*$records_per_page." , ".$records_per_page; // if the user want to move throught pages it isn't necessary to build the first part of the sql query

		display_sql($sql);		

		// execute the select query
		$res_contacts = execute_db("$sql", $conn);

		if ($results_number != 0){ // at least one record found
		
			display_message("<br>$results_number ".$normal_messages_ar["records_found"], "", "", "1");

			if ($results_number > $records_per_page){

				$pages_number = get_pages_number($results_number, $records_per_page); // get the total number of pages

				display_message ("<br>".$normal_messages_ar["page"].($page+1).$normal_messages_ar["of"].$pages_number, "", "", ""); // "Page n of x" statement

				// build the navigation tool
				$navigation_tool = build_navigation_tool($select_without_limit, $pages_number, $page, $action, "", $order);

				// display the navigation tool
				echo "&nbsp;&nbsp;&nbsp;&nbsp;".$navigation_tool."<br><br>";
			} // end if ($results_number > $records_per_page)

			$results_type = "search";

			// build the HTML results table
			$results_table = build_results_table($conn, $db_name, $table_name, $table_internal_name, $res_contacts, $results_type, "", "", $action, $select_without_limit, $page, $order);
			
			// display the HTML results table
			echo $results_table;

            if ($mail_feature == 1){ // e-mail feature activeated
                // $send_email_form = build_send_mail_form($select_without_limit);
                // display_message("<br><table><tr><td>$send_email_form</td><td valign=\"top\">".$normal_messages_ar["mail_to_records"]."</td></tr></table>", "", "", "");

				$sql = "select name_mailing from mailing_tab where sent_mailing = '0' order by date_created_mailing desc";
				
				// execute the query
				$res_mailing = execute_db("$sql", $conn);
				if (get_num_rows_db($res_mailing) > 0){ // at least one mailing created
					$add_to_mailing_form = build_add_to_mailing_form($conn, $db_name, $res_mailing, $select_without_limit, $results_number);
					display_message("<br><table><tr><td>$add_to_mailing_form</td><td valign=\"top\">".$normal_messages_ar["all_records_found"]."</td></tr></table>", "", "", "");
				} // end if
            } // end if
		} // end if
		else{
			display_message($normal_messages_ar["no_records_found"], "", "", "");
		} // end else
		break;
	case "details":
		if ($enable_details == "1"){
			// build the details select query
			$sql = "select * from ".$quote."$table_name".$quote." where ".$quote."$where_field".$quote." = '$where_value'";

			display_sql($sql);

			display_message("<h3>".$normal_messages_ar["details_of_record"]."</h3>", "", "", "");

			// execute the select query
			$res_details = execute_db("$sql", $conn);
			
			// build the HTML details table
			$details_table = build_details_table($conn, $db_name, $table_name, $table_internal_name, $res_details);
			
			// display the HTML details table
			echo $details_table;
		} // end if
		break;
	case "edit":
		if ($enable_edit == "1"){
			// build the details select query
			$sql = "select * from ".$quote."$table_name".$quote." where ".$quote."$where_field".$quote." = '$where_value'";

			display_sql($sql);

			display_message("<h3>".$normal_messages_ar["edit_record"]."</h3>", "", "", "");

			// execute the select query
			$res_details = execute_db("$sql", $conn);
			
			$form_type = "update";

			// display the form
			$form = build_form($action, $fields_labels_ar, $form_type, $res_details, $where_field, $where_value, $conn);
			echo $form;
		} // end if
		break;
	case "update":
		if ($enable_edit == "1"){
			$check = 0;
			$check = check_required_fields($HTTP_POST_VARS, $fields_labels_ar);
			if ($check == 0){
				display_message($normal_messages_ar["required_fields_missed"], "", "", "");
			} // end if ($check == 0)
			else{ // required fields are ok
				// check textarea length
				$check = 0;
				$check = check_length_fields($HTTP_POST_VARS, $fields_labels_ar);
				if ($check == 0){
					display_message($normal_messages_ar["fields_max_length"], "", "", "");
				} // end if ($check == 0)
				else{ // fields length are ok
					$check = 0;
					$content_error_type = "";
					$check = check_fields_types($HTTP_POST_VARS, $fields_labels_ar, $content_error_type);
					if ($check == 0){
						display_message($normal_messages_ar["{$content_error_type}_not_valid"], "", "", "");
						$go_back_button = "<form>".$normal_messages_ar["please"]." <input type=\"button\" value=\"".$submit_buttons_ar["go_back"]."\" onclick=\"javascript:history.back(-1)\"> ".$normal_messages_ar["and_check_form"]."</form>";
						display_message($go_back_button, "", "", "");

					} // end if ($check == 0)
					else{ // type field are ok
						$check = 0;
						$check = write_uploaded_files($HTTP_POST_FILES, $fields_labels_ar);
						if ($check == 0){
							//Need to add the reason why the upload failed: file too large, improper filename (such as a .php file), or the file couldn't be found.
							display_message($error_messages_ar["upload_error"], "", "", "");
						}
						else { // filed uploaded are ok

							$update_type = "internal";
							
							// update the record
							update_record($HTTP_POST_FILES, $HTTP_POST_VARS, $conn, $db_name, $table_name, $table_internal_name, $where_field, $where_value, $update_type);

							display_message("<h3>".$normal_messages_ar["update_result"]."</h3>", "", "", "");
							display_message("<p>".$normal_messages_ar["record_updated"]."</p>", "", "", "1");
						} // end else
					} // end else
				} // end else
			} // end else
		} // end if
		break;
	case "delete":
		if ($enable_delete == "1") {
			if ($delete_sure == "1"){ // the user has  answered yes to the question "Are you sure?"
				// delete a record
				delete_record ($conn, $db_name, $table_name, $where_field, $where_value);
				display_message("<h3>".$normal_messages_ar["delete_result"]."</h3>", "", "", "");
				display_message("<p>".$normal_messages_ar["record_deleted"]."</p>", "", "", "1");
			} // end if
			else{ // the user hasn't already answered to the question
				// display "Are you sure?" confirmation
				display_message($normal_messages_ar["delete_are_you_sure"], "", "", "");
				$are_you_sure_form = build_are_you_sure_form($where_field, $where_value, $conn, $db_name,  $table_name, $table_internal_name);
				echo $are_you_sure_form;
			} // end else
		} // end if
		break;
	default:
		if (isset($form_type)){
			if ($form_type == "insert"){
				if ($enable_insert == "1") {
					display_message("<h3>".$normal_messages_ar["insert_record"]."</h3>", "", "", "");
					if (required_field_present($conn, $table_name, $table_internal_name)){ // at least one required field
						display_message("<p>".$normal_messages_ar["required_fields_red"]."</p>", "", "", "1");
					} // end if
				} // end if
			} // end if
			else{
				display_message("<h3>".$normal_messages_ar["search_records"]."</h3>", "", "", "");
			} // end else
			$res_details = "";
			// display the form
			$form = build_form($action, $fields_labels_ar, $form_type, $res_details, $where_field, $where_value, $conn);
			echo $form;
		} // end if
		else{
			display_message($error_messages_ar["no_functions"], "", "", "");
		} // end else
		break;
} // end swtich ($function)

// include footer
include ("./include/footer.php");
?>