<?

session_start();


?>
<html>
<title>/Login Edit search</title>
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
<body topmargin=0 leftmargin=0 marginheight=0 marginwidth=0>
<?
require("admin_header.inc");
?>
<form method="POST" action="admin_edit_search_results.php">
  <table class="detail" cellpadding="0" cellspacing="0" align="center">
    <tr> 
      <td class="strip">&nbsp;&nbsp;SEARCH INDIVIDUALS</td>
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
              <input class="fields" type="text" name="password" size="40">
            </td>
          </tr>
          <tr> 
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
                    <td class="fieldname">PRIVILEGES</td>
                  </tr>
                </table>
              </div>
            </td>
            <td width="2%" valign="top"></td>
            <td width="80%" valign="top" class="data3"> 
              <div class="data3" align="left"> 
                <input type="radio" name="privilege" value="1">
                View<br>
                <input type="radio" name="privilege" value="2">
                Modify<br>
                <input type="radio" name="privilege" value="3">
                Add<br>
                <input type="radio" name="privilege" value="4">
                Delete<br>
                <input type="radio" name="privilege" value="5">
                Administration</div>
            </td>
          </tr>
          <tr> 
        </table>
      </td>
    </tr>
    <tr> 
      <td class="strip">&nbsp;</td>
    </tr>
    <tr> 
      <td width="600" colspan="2"> 
        <div align="center"> 
          <input name='begin_search' type='hidden' id='begin_search' value='1'>
          <input type="submit" name="add" value="Search Users">
        </div>
      </td>
    </tr>
  </table>
  <div align="center"><br>
  <table width="540" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td> 
        <div align="left">
          Leave all fields blank to see all records. Enter information you may 
          know about the record you are searching for into any of the fields and 
          then click <b>Search</b>.<br>
          <br>
          Follow partial entries with the % symbol. For example, entering <b>A%</b> 
          into a field would narrow your search to records in which that field 
          contains text beginning with the letter <b>A</b>.</div>
      </td>
    </tr>
  </table>
</div>
</form>
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->
</body>
</html>
