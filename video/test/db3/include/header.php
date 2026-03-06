<?php

?>
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Supernova Group Contact Database</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
<meta name="Generator" content="DaDaBIK 2.2.1  - http://www.dadabik.org/">
<script language="JavaScript">
<!--
function fill_cap(city_field){

	temp = 'document.contacts_form.'+city_field+'.value';

	city = eval(temp);
	cap=open("fill_cap.php?city="+escape(city),"schermo","toolbar=no,directories=no,menubar=no,width=170,height=
	250,resizable=yes");
}
//-->
</script>
</head>

<body
<?php
if (isset($HTTP_POST_VARS["type_mailing"])){
	if ($HTTP_POST_VARS["type_mailing"] == "labels") {
		echo " leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" onload=\"javascript:alert(
		'".$normal_messages_ar["print_warning"]."')\"";
	} // end if
} // end if
?>
leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%" height="100%" border="0" bgcolor="#666666">
<tr>
<td align="center" valign="center">
<table width="98%" height="98%" bgcolor="#000000">
<tr>
<td>
<table width="100%" height="100%" align="center" bgcolor="#EEEEEE" cellpadding="8">
<tr>
<td valign="top">
<h1>Supernova Group Contact Database</h1>
