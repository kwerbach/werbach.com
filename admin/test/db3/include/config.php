<?php
/*
**********************************************************************************
*
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

**********************************************************************************
*

I am instructor and Web developer at the Master of MiNE (Management in the Network
Economy) Program, a Berkeley-style program in Italy.
If you want to know more about it please visit: http://mine.pc.unicatt.it/

**********************************************************************************
*
*/
?>
<?php
// this is the configuration file, to install DaDaBIK you have to specify *at least* $host, $user, $pass, $db_name

//////////////////////////////////////////////////// please specify at least the following parameters
// select MySQL server host
$host = "db53c.pair.com"; // e.g. "localhost" if DaDaBIK and MySQL run on the same computer

// select database user
$user = "werbach"; // this user must have the right permission in order to create tables e.g. "root"

// select database password
$pass = "sBZGTu22";

// select database name
$db_name = "werbach_supernova";

//////////////////////////////////////////////////// please specify at least the above parameters

// select relative url from the DaDaBIK root dir to the upload folder - please put slash (/) at the end
$upload_relative_url = "uploads/";

// select absolute filepath - please put slash (/) at the end
// e.g. "c:\\data\\web\\dadabik\\uploads\\" on windows systems
// e.g. "/home/my/path/dadabik/uploads/" on unix systems
// make sure the webserver can write to this folder
$upload_directory = '/usr/home/werbach/public_html/db/uploads/';

// select max size in bytes allowed for the uploaded files
$max_upload_file_size = 20000000;

// select allowed file extensions (users will be able to upload only files having these extensions)
$allowed_file_exts_ar[0] = "jpg";
$allowed_file_exts_ar[1] = "gif";
$allowed_file_exts_ar[2] = "tif";
$allowed_file_exts_ar[3] = "tiff";
$allowed_file_exts_ar[4] = "txt";
$allowed_file_exts_ar[5] = "rtf";
$allowed_file_exts_ar[6] = "doc";
$allowed_file_exts_ar[7] = "xls";
$allowed_file_exts_ar[8] = "htm";
$allowed_file_exts_ar[9] = "html";
$allowed_file_exts_ar[10] = "csv";

$allowed_all_files = 0; // set to 1 if you want to allow all extensions, and also file without extension

// select internal table name
$prefix_internal_table = "dadabik_2_"; // you can leave this option as is

// select table_list_name name
$table_list_name = "dadabik_table_list";  // you can leave this option as is, you must leave this option

// select number of results per page
$records_per_page = 15;

// select maximum number of records to be displayed as duplicated
$number_duplicated_records = 30;

// select similarity percentage for duplicated insert check
$percentage_similarity = 80;

// display the main sql statements (insert/search/delete/update) for debugging (0/1);
$display_sql = 0;

// display all the sql statements and the MySQL error messages in case of DB error for debugging (0/1);
$debug_mode = 0;

// display the "I think that x is similar to y......" statement during duplication check (0/1);
$display_is_similar = 0;

// the size (number of row) of the select_multiple_menu fields
$size_multiple_select = 3;

// allow the choice "and/or" directly in the form during the search (0/1)
$select_operator_feature = 1;

// default operator (or/and), if the previous is set to 0
$default_operator = "and";

// target window for details/edit, "self" is the same window, "blank" a new window
$edit_target_window = "self";

// select the coloumn at which a text, textarea, password and select sinlge field will be wrapped
$word_wrap_col = "40";

// select the format used to display date field (literal_english, latin, numeric_english)
// e.g. literal_english: May 31, 2002 - latin: 31/5/2002 - numeric_english: 5-31-2002
// note that, depending on your system, you can have problem displaying dates prior to 01-01-1970

$date_format = "literal_english";

// select date field separator (divides day, month and year; used only with latin and numeric_english date
$date_separator = "-";

// select start and end year for date field
$start_year = 1968;
$end_year = 2003;

// select the image files to use as icons for delete, edit, details
$delete_icon = "images/delete.gif";
$edit_icon = "images/update.gif";
$details_icon = "images/details.gif";

// select language (uncomment the right row by deleting //)
include ("./include/languages/english.php");
//include ("./include/languages/italian.php");
//include ("./include/languages/german.php");
//include ("./include/languages/dutch.php");
//include ("./include/languages/spanish.php");
//include ("./include/languages/french.php");

?>
