<?
session_start();

if (!isset($SSS_privilege))
{
$SSS_privilege = 0;
session_register("SSS_privilege");
}
$SSS_page = "admin_menu.php";
session_register("SSS_page");
?>
<html>
<script language="JavaScript">
<!--
function reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.pgW=innerWidth; document.pgH=innerHeight; onresize=reloadPage; }}
  else if (innerWidth!=document.pgW || innerHeight!=document.pgH) location.reload();
}
reloadPage(true);
// -->
</script>
<title>Admministration Menu</title>
<link rel="stylesheet" href="admin_styles.css" type="text/css">
<body topmargin=0 leftmargin=0 marginheight=0 marginwidth=0>
<?
require("admin_header.inc");
?>
<p>&nbsp;</p><table width="650" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#000000">
  <tr>
    <td>
      <table width="650" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="strip" height="35" valign="bottom"> 
            <div id="Layer1" style="position:relative; z-index:5; left: 15px; top: 2px" class="welcome">Welcome 
              to:</div>
          </td>
        </tr>
        <tr>
          <td height="125" valign="top"> 
            <div id="Layer3" style="position:relative; z-index:5; left: 85px; top: 30px" class="tablename">Admin Login</div>
          </td>
        </tr>
        <tr>
          <td class="strip" height="40" valign="top">
            <div id="Layer2" style="position:relative; z-index:5; left: 85px; top: 0px" class="online">Online</div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
      <div align="center">Just click on one of the hyperlinks above to get started.</div>
    </td>
  </tr>
</table>
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->
</body>
</html>
