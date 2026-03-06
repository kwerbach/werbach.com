<?

session_start();


$itemNumber = $HTTP_GET_VARS['itemNumber'];
if (isset($HTTP_GET_VARS['ID']))
{
 $ID = $HTTP_GET_VARS['ID'];
}
$whereclause = $HTTP_SESSION_VARS['whereclause'];
$total_results = $HTTP_SESSION_VARS['total_results'];
require("admin_connect.php");

$Link = mysql_pconnect ($Host, $User, $Password);
mysql_select_db($DBName, $Link);

if ($itemNumber == 0)
{
$screen = 1;
}
else
{
if (($itemNumber / 10) < ceil($itemNumber / 10))
      {
      $screen = ceil($itemNumber / 10);
      }
      else
      {
      $screen = ceil($itemNumber / 10) + 1;
      }
}
$backToSearch = "admin_edit_search_results.php?screen=" . $screen;

$Query = "SELECT * FROM login WHERE  login.ID = " . $ID;

$Result = mysql_query($Query, $Link);

$Row = mysql_fetch_assoc($Result);

$username = $Row['username'];
$password = $Row['password'];
$privilege = $Row['privilege'];

?>
<html>
<head>
<title>Edit Detail</title>
<link rel="stylesheet" href="admin_styles.css" type="text/css">
</head>
<body topmargin=0 leftmargin=0 marginheight=0 marginwidth=0>
<?
require("admin_header.inc");
?>
<form method="post" action="admin_edit_update.php" name="main">
  <table class="detail" cellpadding="0" cellspacing="0" align="center">
    <tr> 
      <td class="strip">&nbsp;&nbsp;EDIT RECORD</td>
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
              <input type="text" name="username" size="40" value="<?=$username?>">
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
              <input type="text" name="password" value="<?=$password?>">
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
                    <td class="fieldname">PRIVILEGE</td>
                  </tr>
                </table>
              </div>
            </td>
            <td width="2%" valign="top"></td>
            <td width="80%" valign="top" class="data3"> 
              <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr> 
                  <td height="20" class="data3"> 
<?
if ($privilege == 1)
{
?>
                    <input type="radio" name="privilege" value="1" checked>
<?
}
else
{
?>
                    <input type="radio" name="privilege" value="1">
<?
}
?>
                    View </td>
                </tr>
                <tr> 
                  <td height="20" class="data3"> 
<?
if ($privilege == 2)
{
?>
                    <input type="radio" name="privilege" value="2" checked>
<?
}
else
{
?>
                    <input type="radio" name="privilege" value="2">
<?
}
?>
                    Modify </td>
                </tr>
                <tr> 
                  <td height="20" class="data3"> 
<?
if ($privilege == 3)
{
?>
                    <input type="radio" name="privilege" value="3" checked>
<?
}
else
{
?>
                    <input type="radio" name="privilege" value="3">
<?
}
?>
                    Add </td>
                </tr>
                <tr> 
                  <td height="20" class="data3"> 
<?
if ($privilege == 4)
{
?>
                    <input type="radio" name="privilege" value="4" checked>
<?
}
else
{
?>
                    <input type="radio" name="privilege" value="4">
<?
}
?>
                    Delete </td>
                </tr>
                <tr> 
                  <td height="20" class="data3"> 
<?
if ($privilege == 5)
{
?>
                    <input type="radio" name="privilege" value="5" checked>
<?
}
else
{
?>
                    <input type="radio" name="privilege" value="5">
<?
}
?>
                    Administration </td>
                </tr>
              </table>
            </td>
          </tr>
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
<input type="hidden" name="itemNumber" value="<?=$itemNumber?>">
<input type="hidden" name="ID" value="<?=$ID?>">
          <input type="submit" name="update" value="Update Individual">
        </div>
      </td>
    </tr>
  </table>
  <br>
  <table width="250" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#000000" bgcolor="#CCCCCC">
    <tr>
      <td class="button">
        <div align="center">
         <p><a class="button" href="javascript:if (confirm(&quot;Delete this record?&quot;) == true) location.href=&quot;admin_delete.php?ID=<?=$ID?>&quot;">Remove This Individual</a></p>
        </div>
      </td>
    </tr>
  </table>
</form>
<div align="center">
<a href="<?=$backToSearch?>">Back To Search Results</a>
</div>
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->
</body>
</html>
