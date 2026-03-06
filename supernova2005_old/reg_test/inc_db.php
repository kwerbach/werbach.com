<?php
// DB FUNCTIONS

// void dbconnect ([string database name [, string user name [, string password [, string server name]]]])

// This function will connect to a MySQL database. If the attempt to connect
// fails, an error message prints out and the script will exit.

//function dbconnect ($dbname="test",$user="root",$password="",$server="localhost") // HOME 
function dbconnect ($dbname="werbach_supernova",$user="werbach",$password="sBZGTu22",$server="db53c.pair.com")
{
	if (!($mylink = mysql_connect($server,$user,$password)))
	{
		print "<h3>could not connect to database</h3>\n";
		exit;
	}
	mysql_select_db($dbname);
}


// int safe_query ([string query])

// This function will execute an SQL query against the currently open
// MySQL database. If the global variable $query_debug is not empty,
// the query will be printed out before execution. If the execution fails,
// the query and any error message from MySQL will be printed out, and
// the function will return FALSE. Otherwise, it returns the MySQL
// result set identifier.

function safe_query ($query = "")
{
	global	$query_debug;

	if (empty($query)) { return FALSE; }

	if (!empty($query_debug)) { print "<pre>$query</pre>\n"; }

	$result = mysql_query($query)
		or die("ack! query failed: "
			."<li>errorno=".mysql_errno()
			."<li>error=".mysql_error()
			."<li>query=".$query
		);
	return $result;
}

?>