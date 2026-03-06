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
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>DaDaBIK - http://www.dadabik.org/</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
<meta name="Generator" content="DaDaBIK 2.2.1  - http://www.dadabik.org/">
<script language="JavaScript">
<!--
function fill_cap(city_field){

	temp = 'document.contacts_form.'+city_field+'.value';

	city = eval(temp);
	cap=open("fill_cap.php?city="+escape(city),"schermo","toolbar=no,directories=no,menubar=no,width=170,height=250,resizable=yes");
}
//-->
</script>
</head>

<body 
<?php
if (isset($HTTP_POST_VARS["type_mailing"])){
	if ($HTTP_POST_VARS["type_mailing"] == "labels") {
		echo " leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" onload=\"javascript:alert('".$normal_messages_ar["print_warning"]."')\"";
	} // end if
} // end if
?>
leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%" height="100%" border="0" bgcolor="#F0A300">
<tr>
<td align="center" valign="center">
<table width="95%" height="95%" bgcolor="#000000">
<tr>
<td>
<table width="100%" height="100%" align="center" bgcolor="#FFCC99" cellpadding="10">
<tr>
<td valign="top">
<h1>DaDaBIK 2.2.1</h1>