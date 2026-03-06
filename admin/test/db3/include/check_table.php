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
// get the array containing the names of the tables (excluding "dadabik_" ones, not allowed and without internal)
$tables_names_ar = build_tables_names_array($db_name);
if (count($tables_names_ar) == 0){
	echo "<p>It is impossible to run DaDaBIK, possible reasons:<br>- no tables installed or<br>- you have decided to exclude all the tables from the DaDaBIK interface.<br><br>Please go tho the administration interface.";
	exit;
} // end
else{
	if (!isset($HTTP_GET_VARS["table_name"])){
		$table_name = $tables_names_ar[0];
	} // end if
	else{
		$table_name = urldecode($HTTP_GET_VARS["table_name"]);
		if (!table_allowed($conn, $table_name)){ // someone try to manage a not-allowed table by changing the url
			exit;
		} // end if
	} // end else
	$enabled_features_ar = build_enabled_features_ar($table_name);

	$enable_insert = $enabled_features_ar["insert"];
	$enable_edit = $enabled_features_ar["edit"];
	$enable_delete = $enabled_features_ar["delete"];
	$enable_details = $enabled_features_ar["details"];

	$table_internal_name = $prefix_internal_table.$table_name;
} // end else
?>