<?
session_start();

if (!isset($SSS_privilege))
{
$SSS_privilege = 0;
session_register("SSS_privilege");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

<title> Menu</title>
<link rel="stylesheet" href="people_styles.css" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../Werbach/Web%20Pages/asap%20db/people_styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<p class="title">Supernova Group Database</p>
<p>
<?
require("people_header.inc");
?>
<div align="center">
<table class="report" width="650" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="strip" height="35" valign="bottom"> 
            <span class="welcome">Welcome to:</span>
          </td>
        </tr>
        <tr>
          <td height="125" valign="top"><br><br>
             <div align="center">
            <span class="tablename">People</span>
             </div>
          </td>
        </tr>
        <tr>
          <td class="strip" height="40" valign="top">
      <span class="online">Online</span>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<table border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
      <div class='pagetext' align='center'>Just click on one of the hyperlinks above to get started.</div>
    </td>
  </tr>
</table>
</div>
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->

</p>
</body>
</html>
