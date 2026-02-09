<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" href="admin_styles.css" type="text/css">
<script language="javascript">
<!--
var bName = navigator.appName;
var bVer = parseFloat(navigator.appVersion);
var browser;

if (bName == "Netscape")
 browser = "Netscape Navigator"
else
 browser = bName;

  // return 1 for Internet Explorer
  if (browser == "Netscape Navigator")
document.write("<!-- This is Netscape //-->")

  // return 2 for Navigator
  else
document.write("<style type=\"text/css\">")
document.write("<!--")
document.write(".fields{")
document.write("border : #000000;")
document.write("border-style: solid;")
document.write("border-width: 1px;")
document.write("}")
document.write("-->")
document.write("</style>")

  // return 0 for other browsers

//-->

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body topmargin=0 leftmargin=0 marginheight=0 marginwidth=0>
<?
require("admin_header.inc");
?>
<form method="post" action="admin_login.php" name="login">
              <div class="welcomemessage" align="center">Please Log In</div>
        <div align="center"> <br>
    <table class="detail" cellpadding="0" cellspacing="0" align="center">
      <tr> 
        <td class="strip">&nbsp;&nbsp;ADMIN LOGIN</td>
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
              <td width="80%" valign="top" class="data1"> 
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
              <td width="80%" valign="top" class="data1"> 
                <input class="fields" type="password" name="password" size="40">
              </td>
            </tr>
            <tr> 
            <tr> 
            <tr> 
            <tr> 
              <td width="194" height="1" valign="top"><img width="194" height="1" src="transparent.gif"></td>
              <td width="6" height="1" valign="top"><img width="6" height="1" src="transparent.gif"></td>
              <td width="410" height="1" valign="top"><img width="410" height="1" src="transparent.gif"></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr> 
        <td class="strip">&nbsp;</td>
      </tr>
      <tr> 
        <td width="600" colspan="2"> 
          <div align="center"> 
            <input type="submit" name="login" value="                     Log In                     ">
          </div>
        </td>
      </tr>
    </table>
    <br>
  </div>
</form>
<p>&nbsp;</p>
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->
</body>
</html>
