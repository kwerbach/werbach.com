<?php
session_start();
if (!isset($HTTP_SESSION_VARS['SSS_privilege']))
{
 session_register("SSS_privilege");
}
?>
<html>
<head>

<title>Login</title>
<link rel="stylesheet" href="people_styles.css" type="text/css">
<script>
<!--
function sf(){document.login.username.focus();}
// -->
</script>
</head>

<body onLoad=sf()>
<?php
require("header.php");
require("people_header.inc");
?>
<div align="center"> 
<table width="650" cellpadding="0" cellspacing="0">
<tr>
<td>
<form method="post" action="login.php" name="login">
              <div class="welcomemessage" align="center">Please Log In</div><br>
        <div align="center"> <br>
    <table class="report" width="100%" cellpadding="0" cellspacing="0" align="center">
      <tr> 
        <td class="strip"></td>
      </tr>
      <tr> 
        <td class="data3"> 
          <table cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr> 
              <td height="16" colspan="3" valign="top"> 
                <hr class="line" size="1">
              </td>
            </tr>
            <tr> 
              <td width="18%" valign="top"> 
                <div align="right"> 
                  <table cellpadding="1" cellspacing="0" width="80%">
                    <tr> 
                      <td class="fieldname">USERNAME</td>
                    </tr>
                  </table>
                </div>
              </td>
              <td width="2%" valign="top"></td>
              <td width="80%" valign="top" class="data3"> 
                <input class="fields" type="text" name="username" size="40" value="">
              </td>
            </tr>
            <tr> 
            <tr> 
              <td height="16" colspan="3" valign="top"> 
                <hr class="line" size="1">
              </td>
            </tr>
            <tr> 
              <td width="18%" valign="top"> 
                <div align="right"> 
                  <table cellpadding="1" cellspacing="0" width="80%">
                    <tr> 
                      <td class="fieldname">PASSWORD</td>
                    </tr>
                  </table>
                </div>
              </td>
              <td width="2%" valign="top"></td>
              <td width="80%" valign="top" class="data3"> 
                <input class="fields" type="password" name="password" size="40">
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr> 
        <td class="strip">&nbsp;</td>
      </tr>
      <tr> 
        <td colspan="2"> 
          <div align="center"> 
            <input type="submit" name="login" value="Log In">
          </div>
        </td>
      </tr>
    </table>
    <br>
  </div>
</form>
<div align="center">If you are immediately returned to this page, you may not have the access<br>privileges required to complete the transaction you requested.<br><br></div>
</td>
</tr>
</table>
</div>
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->

</p>
</body>
</html>
