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
if ($host != "" and $user != "" and $db_name != "") {
	// connect server
	$conn = connect_db("$host", "$user", "$pass");

	$mysql_server_version = mysql_get_server_info($conn);

	$mysql_server_version_ar = explode('.', $mysql_server_version);

	if (!isset($mysql_server_version_ar) || !isset($mysql_server_version_ar[0])) {
        $mysql_server_version_ar[0] = 3;
    }
    if (!isset($mysql_server_version_ar[1])) {
        $mysql_server_version_ar[1] = 21;
    }
    if (!isset($mysql_server_version_ar[2])) {
        $mysql_server_version_ar[2] = 0;
    }

	$mysql_server_version = (int)sprintf('%d%02d%02d', $mysql_server_version_ar[0], $mysql_server_version_ar[1], intval($mysql_server_version_ar[2]));

	if ($mysql_server_version > 32306){
		$quote = "`";
	} // end if
	else{
		$quote = "";
	} // end else

	// select the database
	select_db("$db_name", $conn);
} // end if
else{
	echo "<p>Please specify host, username and database name in config.php";
	exit;
} // end else

$complete_table_names_ar = build_tables_names_array($db_name, 1, 0, 0); // excluding dadabik_ ones

if (count($complete_table_names_ar) == 0){ // no table a part from dadabik_ones
	echo "<p>Your database is empty. No tables found";
	exit;
} // end if

if (get_magic_quotes_gpc()==1){
	echo "<p>To run DaDaBIK you need to set magic_quotes_gpc to <b>on</b> in php.ini";
	exit;
} // end if

if (!isset($mail_feature)){
	$mail_feature = "";
} // end if
?>
