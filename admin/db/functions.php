<?php

require_once ("people_connect.php");

function get_fields()
{
	$result = mysql_query("SHOW COLUMNS FROM people");
	$flist = array();
	for ($i = 0; $row = mysql_fetch_row($result);)
		if (!($row[0] == 'user_id' || $row[0] == 'ID' || $row[0] == 'autoID' || $row[0] == 'created_on'))
			$flist[$i++] = $row[0];
	return implode(",", $flist);
}

function get_fields_small()
{
	return "last, first, email ";
}

function get_unique_id($last)
{
	$letter_part = strlen($last) >= 3 ? strtoupper(substr($last,0,3)) : strtoupper($last);
	do{											// make sure this new user_id doesn't exist. 
		$number_part = rand(1000,9999);
	}while (mysql_num_rows(mysql_query("select ID from people where user_id='".$letter_part.$number_part."'")) > 0);
	
	return $letter_part.$number_part;
}

//returns a 2D array on success, returns false otherwise.
//
function input_file($filename)
{
	if ($infile = file($filename))
	{
		$delim = "\t";

		for ($i = 0; $i < count($infile); $i++)
			$infile[$i] = explode($delim, $infile[$i]);	

		return $infile;
	}

	return false;
}

function check_login($p="login_form.php",$qs="")
{
	if($_SESSION["SSS_privilege"] == "")	// IF PRIVS HAVEN'T BEEN SET
	{
		$gtp = ($p == "") ? "login_form.php"  : basename($p);		// BASENAME ONLY WORKS IF ALL FILES ARE IN SAME DIR
		$gtp = ($qs == "") ? $gtp  : $gtp .= "?" . $qs;						// APPEND THE QS ID THERE IS ONE

		$_SESSION["go_to_page"] = $gtp; 	// GO TO PAGE;
		header("Location:login_form.php");
	}  
	else
	{
		$_SESSION["SSS_privilege"] = $_SESSION["SSS_privilege"];			// RESET VALUE TO EXTED TTL 
	}
	
}


// $filename: the file to create
// $table: a 2D array[row][col]
// returns true on success.
//
function output_file(&$filename, $table)
{
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment; filename=$filename;");
	header("Content-Transfer-Encoding: binary");

	$filename = "";
	$content = "";
	
	for($i = 0; $i < count($table); $i++)
		$content .= (str_replace("\r","",str_replace("\n","",implode("\t", $table[$i]))) . "\r\n");

	$size = array_sum(count_chars($content));
	header("Content-Length: ".$size);
	echo $content;
	exit;
}

// WRITE PEOPLE TAGS
function write_tags($id)
{
	global $Link;
	$where_clause 	= " WHERE people_id  = " . $id;
	$query 			= "SELECT tag FROM people_tags " . $where_clause;
//	$result 		= safe_query($query);		// QUERY THAT CHECKS FOR EXISTING RECORDS
	$result 		= mysql_query($query, $Link);
	$tags			= "";
	if ($result)								// QUERY WAS SUCCESSFUL
	{
		while ($row = mysql_fetch_row($result)) 
		{
			// IF EDIT IS FOUND AFTER THE 0th CHAR THEN ADD A HREF
			$tags .= (strpos($_SERVER['PHP_SELF'], "_edit_") > 0 ) ? "<a href=\"javascript:confirm_click('tag_remove.php?id=". $id . "&tag=" . $row[0] . "')\" " : "";
			$tags .= (strpos($_SERVER['PHP_SELF'], "_edit_") > 0 ) ? "title=\"click to remove this person from the " . $row[0] . " group\">" : "";
			$tags .= $row[0];
			$tags .= (strpos($_SERVER['PHP_SELF'], "_edit_") > 0 ) ? "</a>" : "";
			$tags .= ", ";
		} 
	}
	$tags = trim($tags, ", ");
	return $tags;
}

function write_tags_to_add($id)
{
	global $Link;
	$where_clause 	= " WHERE people_id  <> " . $id;
	$query 			= "SELECT DISTINCT tag, is_email_tag FROM people_tags " . $where_clause . " ORDER BY tag";
//	$result 		= safe_query($query);		// QUERY THAT CHECKS FOR EXISTING RECORDS
	$result 		= mysql_query($query, $Link);
	$tags			= "";
	$select_field = "<select name=\"add_tag\">\n";
	$select_field .= "<option value=\"\">Select a tag...</option>\n";
	if ($result)								// QUERY WAS SUCCESSFUL
	{
		while ($row = mysql_fetch_row($result)) 
		{
			$select_field .= $row[0] . ", ";
			$select_field .= "<option value=\"$row[0]:$row[1]\">$row[0]</option>\n";
		} 
	}
	$select_field .= "</select>";
	return $select_field;
}

?>