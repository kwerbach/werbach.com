<?php

require_once 'people_connect.php';

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



?>