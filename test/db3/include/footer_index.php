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

// get the number of contacts in the database
$sql = "select count(*) from ".$quote."$table_name".$quote."";

// select the database
select_db("$db_name", $conn);

// execute the select query
$res_count = execute_db("$sql", $conn);

while ($count_row = fetch_row_db($res_count)){
	$records_number = $count_row[0];
} // end while

$change_table_select = build_change_table_select($conn, $db_name);
?>

<hr>
<table width="100%">
<tr>
	<td align="left">(<?php echo $normal_messages_ar["records_in_database"].$records_number; ?>)<br><br><font size="1">Powered by: <a href="http://www.dadabik.org/">DaDaBIK</a></font></td>
	<td align="right">
	<?php
	if ($change_table_select != ""){
	?>
	<form method="get" action="index.php">
	<? echo $change_table_select; ?>
	<input type="submit" value="<?php echo $submit_buttons_ar["change_table"]; ?>"></form>
	<?php
	}
	?></td>
</tr>
</table>

</td>
</tr>
</table>

</td>
</tr>
</table>

</td>
</tr>
</table>

</body>
</html>