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

// db functions
function connect_db($server, $user, $password)
{
	global $debug_mode;
	if ($debug_mode == "1"){
		$conn = @mysql_connect($server, $user, $password) or die ('<p>Error during database connection.<br>MySQL server said: '.mysql_error());
	} // end if
	else{
		$conn = mysql_connect($server, $user, $password) or die ('<p>Error during database connection.');
	} // end else
	return $conn;
}

function list_tables_db($dbase)
{
	global $debug_mode;
	return mysql_list_tables($dbase);
}

function tablename_db($res, $i)
{
	global $debug_mode;
	return mysql_tablename($res, $i);
}

function select_db($dbase, $conn)
{
	global $debug_mode;
	if ($debug_mode == "1"){
		mysql_select_db($dbase, $conn) or die ('<p>Error during database selection.<br>MySQL server said: '.mysql_error());
	} // end if
	else{
		mysql_select_db($dbase, $conn) or die ('<p>Error during database selection.');
	} // end else

}

function execute_db($sql_statm, $conn)
{
	global $debug_mode;
	if ($debug_mode == "1"){
		$results = mysql_query("$sql_statm", $conn) or die ('<p>Error during query execution.<br>'.$sql_statm.'<br>MySQL server said: '.mysql_error());
	} // end if
	else{
		$results = mysql_query("$sql_statm", $conn) or die ('<p>Error during query execution.');
	} // end else
	return $results;
}

function fetch_row_db($results)
{
	global $debug_mode;
	$fetch = mysql_fetch_array ($results);
	return $fetch;
}

function get_num_rows_db($results)
{
	global $debug_mode;
	$number = mysql_num_rows($results);
	return $number;
}

function get_last_ID_db()
{
	global $debug_mode;
	return mysql_insert_id();
}
 
function list_fields_db($db_name, $table_name, $conn)
{
	global $debug_mode;
   	$fields = mysql_list_fields ("$db_name", "$table_name", $conn);
	return $fields;
}
 
function num_fields_db($fields)
{
	global $debug_mode;
	$fields_number = mysql_num_fields ($fields);
	return $fields_number;
}
 
function field_name_db($fields, $i)
{
	global $debug_mode;
    $field_name = mysql_field_name ($fields, $i);
    return $field_name;
}

function db_create_db($db_name)
{
	global $debug_mode;
    $i = mysql_create_db($db_name);
}

function field_flags_db($fields, $i)
{
	$flags = mysql_field_flags($fields, $i);
	return $flags;
}

function fetch_field_db($res)
{
	global $debug_mode;
	$field_type = mysql_fetch_field($res);
	return $field_type;
}
?>