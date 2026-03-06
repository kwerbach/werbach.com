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
?>
<?php
if ($enable_insert == "1"){
?>
<p><a href="form.php?form_type=insert&table_name=<?php echo urlencode($table_name); ?>"><?php echo $submit_buttons_ar["insert"]; ?></a>
<?php
}
?>

<p><a href="form.php?form_type=search&table_name=<?php echo urlencode($table_name); ?>"><?php echo $submit_buttons_ar["search/update/delete"]; ?></a>

<p><a href="form.php?function=search&sql=&page=0&table_name=<?php echo urlencode($table_name); ?>"><?php echo $normal_messages_ar["show_all_records"]; ?></a>

<p>&nbsp;</p>

<?php
if ($mail_feature == 1){
?>
	<form method="post" action="mail.php"><input type="hidden" name="function" value="new_form"><input type="submit" value="<?php echo $submit_buttons_ar["new_mailing"]; ?>"></form>
<?php
	$sql = "select name_mailing from mailing_tab where sent_mailing = '0' order by date_created_mailing desc";
	// select the database
	select_db("$db_name", $conn);
	// execute the query
	$res_mailing = execute_db("$sql", $conn);
	if (get_num_rows_db($res_mailing) > 0){ // at least one mailing created
		$mailing_select = build_mailing_select($conn, $db_name, $res_mailing);
?>

<form method="post" action="mail.php"><input type="hidden" name="function" value="check_form"><input type="submit" value="<?php echo $submit_buttons_ar["check_existing_mailing"]; ?>"><?php display_message($mailing_select, "", "", ""); ?></form>

<form method="post" action="mail.php"><input type="hidden" name="function" value="send"><input type="submit" value="<?php echo $submit_buttons_ar["send_mailing"]; ?>"><?php display_message($mailing_select, "", "", ""); ?></form>

<?php
	} // end if
} // end if
?>
<?php
// include footer
include ("./include/footer_index.php");
?>