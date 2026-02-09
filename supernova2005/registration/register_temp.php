<?php
require "inc_db.php";
dbconnect();
function write_priority_codes()
{
	$where_clause = "WHERE for_event = 'supernova2005'";
	$query = "select priority_code, price, category from sn_priority_codes " . $where_clause;
	$result = safe_query($query);
	if ($result)
		{
			while ($row = mysql_fetch_array($result)) 
			{
			$priority_code = strtolower($row["priority_code"]);
			$price = $row["price"];
			$category = $row["category"];
			echo <<<EOQ
			case "$priority_code" : \n  \t \t \t \t
				document.form1.amount.value = $price; \t \t \t \t
				document.form1.category.value = "$category"; \t \t \t \t
				break; \n \t \t \t
EOQ;
			}
			mysql_free_result($result);
		}
}
?>
<html>
<head>
<title>Supernova 2005</title>

<style type="text/css">
a:link { color:blue; text-decoration: none }
a:visited { color:blue; text-decoration: none }
a:hover { text-decoration: underline }
</style>

<link href="register.css" rel="stylesheet" type="text/css">


<style type="text/css">
<!--
.style8 {
	font-size: small;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style10 {font-size: small}
.style13 {font-size: 11px; }
-->
</style>
</head>

<body bgcolor="#380169" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">


<center>

<table border="0" cellpadding="0" cellspacing="0">

<tr>
<td width="42" background="../images/background_left.gif"></td>
<td width="780" bgcolor="#FFFFFF">

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="304" height="155" valign="top"><a href="http://www.supernova2005.com"><img src="../images/logo.gif" width="304" height="155" alt="Home" border="0"></a></td>
	<td width="476"><img src="../images/tagline.gif" width="476" height="155"></td>
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="108"><img src="../images/topcorner.gif" width="108" height="45" alt=""></td>
	<td width="8"></td>
	<td width="1" bgcolor="#FFA813"></td>
	<td width="663">
	
		<table border="0" cellpadding="0" cellspacing="0">
		
		<tr>
		<td width="17" height="24" bgcolor="#FFA813" valign="top"></td>
		<td width="646" height="24" bgcolor="#FFA813" valign="middle">
		<font face="verdana,arial" size="2" color="#FFFFFF">
		
		<a href="../about.htm" style="color:FFFFFF"><b>About Supernova</b></a> | 
		<a href="register.php" style="color:FFFFFF"><b>Register</b></a> | 
		<a href="../community_connection.htm" style="color:FFFFFF"><b>Community Connection</b></a> | 
		<a href="http://blog.supernova2005.com/" style="color:FFFFFF"><b>Weblog</b></a> | 
		<a href="../contact.htm" style="color:FFFFFF"><b>Contact Us</b></a>
		
		</td>
		</tr>
		
		<tr>
		<td height="21" colspan="2"></td>
		</tr>
		
		</table>
	
	</td>
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="111" align="right" valign="top">
	<font face="verdana,arial" size="1">
	
	<a href="../program_overview.htm" style="color:7E7E7E" title="Agenda At-A-Glance">Program Overview</a>
	<br><br>
	<a href="../sessions.htm" style="color:7E7E7E" title="Session Descriptions and Technology Spotlight">Sessions</a>
	<br><br>
	<a href="../workshops.htm" style="color:7E7E7E">Workshops</a>
	<br><br>
	<a href="../special_events.htm" style="color:7E7E7E">Special Events</a>
	<br><br>
	<a href="../speakers.htm" style="color:7E7E7E">Speakers</a>
	<br><br>
	<a href="../sponsors.htm" style="color:7E7E7E">Sponsors</a>
	<br><br>
	<br>
	<br><br><br><br><br>
	<img src="../images/palacehotel.jpg" width="111" height="189" alt="Palace Hotel">
	<br><br><br>
	<a href="http://www.wharton.upenn.edu/campus/wharton_west"><img src="../images/whartonwest.jpg" width"111" height"215" alt="Wharton West" border="0"></a>
	<br><br>
	</td>
	<td width="5"></td>
	<td width="1" valign="top"><img src="../images/yellowline.gif" width="1" height="195" alt=""></td>
	<td width="17"></td>
	<td width="502" valign="top">
	<font face="verdana,arial" size="2">


<!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->
<form action="confirm.php" method="post" name="form1" onSubmit="return validate()">
<p><img src="../images/head_register.gif" width="502" height="50" alt="Register"><br>
	<span class="form_label style8"><span class="style10 form_label"><strong>Registration for Supernova 2005 is now closed.</strong></span></span>
<p class="form_label style8"><br>
	    For any questions about Supernova registration,
  please contact us at <a href="mailto:info@supernovagroup.net">info@supernovagroup.net</a>.
<p><span class="form_label style8"><span class="form_label  style10">Or, <a href="signup.htm">subscribe</a> to our  conference update email list for periodic updates </span></span><span class="style8">about Supernova 2006.</span><span class="form_label"><br>
	   </span>
</form>
</td>
	
	<td width="8"></td>
	<td width="1" bgcolor="#FFA813" valign="top"><img src="../images/spacer.gif" width="1" height="50" alt=""></td>
	<td width="10" valign="bottom" align="right"><img src="../images/shadepiece.gif" width="10" height="10" alt=""></td>
	<td width="125" height="100%" valign="top">
		
		<table border="0" cellpadding="0" cellspacing="0" height="100%">
		
		<tr>
		<td width="125" valign="top" height="100%">
		<img src="../images/spacer.gif" width="1" height="50" alt=""><br>		
		
		<font face="verdana,arial" size="1" color="#FFA813">

<!-- ----------------- SPONSOR AREA ------------------------ -->
		<b>PRODUCED IN PARTNERSHIP WITH
		<br>
		<a href="http://www.wharton.upenn.edu"><img src="../images/logo_wharton.gif" width="119" height="48" alt="The Wharton School" border="0"></a>
		<br><br>PREMIER SPONSOR</b></font><br>
		<a href="http://www.att.com"><img src="../images/logo_at&t.gif" alt="AT&T" width="125" height="48" border="0"></a></p>
<br><p><font face="verdana,arial" size="1" color="#FFA813"><b>PROGRAM SPONSORS</b></font><br>
            <a href="http://www.solidspace.com"><img src="../images/SilkWare125w.gif" alt="SilkRoad" border="0"></a></p>
			<br>	
		
		</td>
		</tr>
		
		<tr>
		<td width="125" height="100%" valign="bottom"><img src="../images/bottomcorner.gif" alt="" width="125" height="56" align="bottom"></td>
		</tr>
		
		</table>
		
	    
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="645" height="1" bgcolor="#FFA813"></td>
	<td><img src="../images/bottomcornerslice.gif" width="135" height="1" alt=""></td>
	</tr>
	
	</table>

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="134"><img src="../images/spacer.gif"  width="134" height="31" ></td>
	<td width="373"><font face="verdana,arial" size="1" color="#7E7E7E">
	©2005 Supernova Group LLC</font>
	</td>
	<td width="273"><img src="../images/bottommiddle.gif" width="273" height="31" alt=""></td>
	</tr>
	
	<tr>
	<td colspan="3"><img src="../images/bottom.gif" width="780" height="52" alt=""></td>
	</tr>
	
	</table>

</td>
<td width="42" background="../images/background_right.gif"></td>
</tr>

</table>
</center>

</html>
<?php
function earlybird_or_not()
{
	$cutoff_date = getdate(mktime(0,0,0,5,14,2005));  // NO MORE EARLYBIRD
	$today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
	
	if($today[0] >= $cutoff_date[0])	// FULL PRICE
	{
		echo <<<EOQ
			switch(val)
			{
				case "Wharton West Workshop Day" : 
				  base_price = "795.00";
				  break; 
				case "2-day Main Conference" : 
				  base_price = "1995.00";
				  break; 
				case "Full Conference" : 
				  base_price = "2495.00";
				  break; 		  		  
				default :
				base_price = 0;
			}
EOQ;
	}
	else  // EARLYBIRD RATES BELOW
	{
		echo <<<EOQ
			switch(val)
			{
				case "Wharton West Workshop Day" : 
				  base_price = "595.00";
				  break; 
				case "2-day Main Conference" : 
				  base_price = "1695.00";
				  break; 
				case "Full Conference" : 
				  base_price = "1995.00";
				  break; 		  		  
				default :
				base_price = 0;
			}
EOQ;
	}

}
?>