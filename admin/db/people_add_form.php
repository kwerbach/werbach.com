<?
session_start();
require("people_connect.php");

$Link = mysql_pconnect ($Host, $User, $Password);
mysql_select_db($DBName, $Link);
?>

<html>
<head>

<title>people Add</title>

<script>
<!--
function sf(){document.add.first.focus();}
// -->
</script>

<script language="JavaScript">
<!--
function validateForm() 
{
var errors = '';

      if (document.add.ID.value == '' || isNaN(document.add.ID.value)) errors += 'Field ID is numeric.  Please enter a number in this field and try again.\n'
      if (document.add.last.value == '') document.add.last.value = " ";
      if (document.add.first.value == '') document.add.first.value = " ";
      if (document.add.email.value == '') document.add.email.value = " ";
      if (document.add.middle.value == '') document.add.middle.value = " ";
      if (document.add.nickname.value == '') document.add.nickname.value = " ";
      if (document.add.title.value == '') document.add.title.value = " ";
      if (document.add.company.value == '') document.add.company.value = " ";
      if (document.add.address1.value == '') document.add.address1.value = " ";
      if (document.add.address2.value == '') document.add.address2.value = " ";
      if (document.add.city.value == '') document.add.city.value = " ";
      if (document.add.province.value == '') document.add.province.value = " ";
      if (document.add.zip.value == '') document.add.zip.value = " ";
      if (document.add.country.value == '') document.add.country.value = " ";
      if (document.add.phone.value == '') document.add.phone.value = " ";
      if (document.add.fax.value == '') document.add.fax.value = " ";
      if (document.add.cellphone.value == '') document.add.cellphone.value = " ";
      if (document.add.home_phone.value == '') document.add.home_phone.value = " ";
      if (document.add.website.value == '') document.add.website.value = " ";
      if (document.add.blog.value == '') document.add.blog.value = " ";
      if (document.add.rss.value == '') document.add.rss.value = " ";
      if (document.add.asst_name.value == '') document.add.asst_name.value = " ";
      if (document.add.asst_phone.value == '') document.add.asst_phone.value = " ";
      if (document.add.out_out.value == '' || isNaN(document.add.out_out.value)) errors += 'Field out_out is numeric.  Please enter a number in this field and try again.\n'
      if (document.add.source.value == '') document.add.source.value = " ";
      if (document.add.personal_connection.value == '' || isNaN(document.add.personal_connection.value)) errors += 'Field personal_connection is numeric.  Please enter a number in this field and try again.\n'
      if (document.add.category.value == '') document.add.category.value = " ";
      if (document.add.sn_attendee.value == '' || isNaN(document.add.sn_attendee.value)) errors += 'Field sn_attendee is numeric.  Please enter a number in this field and try again.\n'
      if (document.add.sn_speaker.value == '' || isNaN(document.add.sn_speaker.value)) errors += 'Field sn_speaker is numeric.  Please enter a number in this field and try again.\n'
      if (document.add.snr_subscriber.value == '' || isNaN(document.add.snr_subscriber.value)) errors += 'Field snr_subscriber is numeric.  Please enter a number in this field and try again.\n'
      if (document.add.werblist_subscriber.value == '' || isNaN(document.add.werblist_subscriber.value)) errors += 'Field werblist_subscriber is numeric.  Please enter a number in this field and try again.\n'
      if (document.add.comments.value == '') document.add.comments.value = " ";
      if (document.add.created_on.value == '') errors += 'Field created_on is a date.  Please enter a date in this field and try again.\n'

   if (errors) alert('The following error(s) occurred:\n' + errors);

  document.returnValue = (errors == '');
}

function callJavaScript(functionName) 
{
  return eval(functionName)
}
//-->
</script>

<link href="people_styles.css" rel="stylesheet" type="text/css">
</head>

<body onLoad=sf()>

<?php
require("header.php");
require("people_header.inc");
?>
<div align="center">
 <form onSubmit="validateForm();return document.returnValue" name="add" method="post" action="people_add.php">
    <table align="center" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" class="data2">
      <tr class="strip">
        <td class="strip">&nbsp;ADD RECORD</td>
        <td><div align="center">          </div>
        </td>
        <td class="button">
          <div align="center"><input type="submit" name="add2" value="Add New Record">
          </div>
        </td>
	<td>&nbsp;</td>
	<td style="strip"><div align="right">Created:
          <?=$created_on?>
	  </div></td>
      </tr>
	  
	  	<tr>
      <td colspan="3" bgcolor="#FFFFFF">ID# &nbsp;
        <!--<input class="fields" type="text" name="ID" value="<?=$ID?>" size="40">-->
        <b>
        <?=$user_id?>
      </b> </td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF"><div align="left"></div></td>
      </tr>
    <tr>
      <td colspan="2" bgcolor="#FFCC99">First:<br><font size="+1"><strong>
        
              <input class="fields" type="text" name="first" value="<?=$first?>" size="40" tabindex=1>
</strong></font></td>
      <td bgcolor="#FFCC99">Middle:<br><font size="+1"><strong>
        <input class="fields" type="text" name="middle" value="<?=$middle?>" size="15" tabindex=2>
      </strong></font></td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFF66">Email:<br>
        <input class="fields" type="text" name="email" value="<?=$email?>" size="40" tabindex=4>
</td>
      </tr>
    <tr>
      <td colspan="3" bgcolor="#FFCC99">Last:<br><font size="+1"><strong>
        <input class="fields" type="text" name="last" value="<?=$last?>" size="40" tabindex=3>
</strong></font></td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">Website:
          <input class="fields" type="text" name="website" value="<?=$website?>" size="40">
</td>
      </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Nickname:
          <input class="fields" type="text" name="nickname" value="<?=$nickname?>" size="40">
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">Blog:
          <input class="fields" type="text" name="blog" value="<?=$blog?>" size="40" tabindex=19></td>
      </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Title:
          <input class="fields" type="text" name="title" value="<?=$title?>" size="60" tabindex=5>
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">Asst. Name:
        <input class="fields" type="text" name="asst_name" value="<?=$asst_name?>" size="40" tabindex=21></td>
      </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Company:
          <input class="fields" type="text" name="company" value="<?=$company?>" size="40" tabindex=6>
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">Asst. Phone:
        <input class="fields" type="text" name="asst_phone" value="<?=$asst_phone?>" size="40" tabindex=22></td>
      </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Address1:
          <input class="fields" type="text" name="address1" value="<?=$address1?>" size="60" tabindex=7>
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">Asst. Email:
        <input class="fields" type="text" name="asst_email" value="<?=$asst_email?>" size="40" tabindex=22></td>
      </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Address2:
      <input class="fields" type="text" name="address2" value="<?=$address2?>" size="60" tabindex=8></td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    <tr>
      <td bgcolor="#FFFFFF">City:
          <input class="fields" type="text" name="city" value="<?=$city?>" size="40" tabindex=9>
</td>
      <td bgcolor="#FFFFFF">State:
          <input class="fields" type="text" name="province" value="<?=$province?>" size="10" tabindex=10>
</td>
      <td bgcolor="#FFFFFF">Zip:
          <input class="fields" type="text" name="zip" value="<?=$zip?>" size="10" tabindex=11>
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">SNR subscriber?
        <?
if ( $snr_subscriber == 1 )
{
?>
        <input type="checkbox" name="snr_subscriber" value="1" checked>
        <?
}
else
{
?>
        <input type="checkbox" name="snr_subscriber" value="1">
        <?
}
?> &nbsp;&nbsp;&nbsp;
        Werblist subscriber?
        <?
if ( $werblist_subscriber == 1 )
{
?>
        <input type="checkbox" name="werblist_subscriber" value="1" checked>
        <?
}
else
{
?>
        <input type="checkbox" name="werblist_subscriber" value="1">
        <?
}
?></td>
      </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Country:
          <input class="fields" type="text" name="country" value="<?=$country?>" size="40" tabindex=12>
</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FF9999">Opt out?
          <?
if ( $out_out == 1 )
{
?>
          <input type="checkbox" name="out_out" value="1" checked>
          <?
}
else
{
?>
          <input type="checkbox" name="out_out" value="1">
          <?
}
?>
</td>
      </tr>
    <tr>
      <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;      </td>
      </tr>
    <tr>
      <td bgcolor="#FFFFFF">Phone:
        <input class="fields" type="text" name="phone" value="<?=$phone?>" size="25" tabindex=13>
</td><td bgcolor="#FFFFFF">Fax:&nbsp;
  <input class="fields" type="text" name="fax" value="<?=$fax?>" size="15" tabindex=14></td>
      <td bgcolor="#FFFFFF">Twitter:
        <input class="fields" type="text" name="twitter" value="<?=$twitter?>" size="15" tabindex=16></td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td rowspan="2" bgcolor="#CCCCCC"><table width="250" border="0" cellpadding="2">
        <tr bordercolor="#F4F4F4" class="data2">
          <td>Source:
              <select name="source">
                <?
if ($source <> '' && $source <> ' ')
{
     $Query2 = "Select * from source WHERE sources LIKE '" . $source . "'";
     $Recordset2 = mysql_query($Query2, $Link);
     while ($Row = mysql_fetch_assoc ($Recordset2))
     {
         $sources_selected = $Row['sources'];
     }
     mysql_free_result($Recordset2);
}
else
{
     $sources_selected = 'unknown';
}
$Query3 = "Select DISTINCT sources,sources from source";
$Recordset3 = mysql_query($Query3, $Link);
?>
                <option value="<?=$source?>" selected>
                <?=$sources_selected?>
                </option>
                <?
while ($Row = mysql_fetch_assoc ($Recordset3))
{
?>
                <option value="<? echo $Row['sources']; ?>"><? echo $Row['sources']; ?></option>
                <?
}
mysql_free_result($Recordset3);
?>
            </select></td>
          <td>marketer?
              <?
if ( $marketer == 1 )
{
?>
              <input type="checkbox" name="marketer" value="1" checked>
              <?
}
else
{
?>
              <input type="checkbox" name="marketer" value="1">
              <?
}
?></td>
        </tr>
        <tr bordercolor="#F4F4F4" class="data2">
          <td>Category:
              <select name="category">
                <?
if ($category <> '' && $category <> ' ')
{
     $Query2 = "Select * from category WHERE categories LIKE '" . $category . "'";
     $Recordset2 = mysql_query($Query2, $Link);
     while ($Row = mysql_fetch_assoc ($Recordset2))
     {
         $categories_selected = $Row['categories'];
     }
     mysql_free_result($Recordset2);
}
else
{
     $categories_selected = 'unknown';
}
$Query3 = "Select DISTINCT categories,categories from category";
$Recordset3 = mysql_query($Query3, $Link);
?>
                <option value="<?=$category?>" selected>
                <?=$categories_selected?>
                </option>
                <?
while ($Row = mysql_fetch_assoc ($Recordset3))
{
?>
                <option value="<? echo $Row['categories']; ?>"><? echo $Row['categories']; ?></option>
                <?
}
mysql_free_result($Recordset3);
?>
            </select></td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
      </tr>
    <tr>
      <td bgcolor="#FFFFFF">Mobile:
          <input class="fields" type="text" name="cellphone" value="<?=$cellphone?>" size="20" tabindex=15>
</td>
<td bgcolor="#FFFFFF">Home:
  <input class="fields" type="text" name="home_phone" value="<?=$home_phone?>" size="15" tabindex=16></td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    <tr>
      <td height="50" colspan="2" bgcolor="#FFFFFF">Comments<br>
          <textarea class="fields" name="comments" cols="60" rows="7" tabindex=17><?=$comments?>
          </textarea>
          <?php /*<script language="javascript1.2">
editor_generate('comments');
          </script> */ ?>
</td>
      <td colspan="3" valign="top" bgcolor="#FFFFCC">&nbsp;</td>
    </tr>
      <tr>
        <td colspan="5" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td class="strip" colspan="5"><div align="center">
          <input type="submit" name="add" value="Add New Record">
        </div></td>
      </tr>
    </table>
  </form>
  <p>&nbsp;</p>
  </p>
</div>
</body>
</html>
