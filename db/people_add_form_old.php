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
        <td colspan="3" class="strip">&nbsp;ADD RECORD</td>
        <td><div align="center">          </div>
        </td>
        <td width="240" class="button">
          <div align="center"><input type="submit" name="add2" value="Add New Record">
          </div>
        </td>
        <td>&nbsp;</td>
        <td width="115">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#FFFFFF">&nbsp;
          <!--            <span class="fieldname2">ID</span><br>
<input class="fields" type="text" name="ID" size="40">
--> </td>
        <td width="3" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="240" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="1" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="115" nowrap bgcolor="#FFFFFF">Created:
            <?=$created_on?>
        </td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#FFCC99"><font size="+1"><strong>
          <span class="fieldname2">first</span>          
          <input class="fields" type="text" name="first" size="30" tabindex=1>
</strong></font></td>
        <td bgcolor="#FFCC99"><font size="+1"><strong>
          <span class="fieldname2">middle </span>
          <input class="fields" type="text" name="middle" size="10" tabindex=2>
</strong></font></td>
        <td width="3" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="240" bgcolor="#FFFFCC"><font size="+1"><strong>
          <span class="fieldname2">email</span>          
          <input class="fields" type="text" name="email" size="30" tabindex=4>
        </strong></font></td>
        <td width="1" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="115" nowrap bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#FFCC99"><font size="+1"><strong>
        <span class="fieldname2">last</span>        
        <input class="fields" type="text" name="last" size="40" tabindex=3>
        </strong></font></td>
        <td width="3" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="240" bgcolor="#FFFFFF">URL:
          <input class="fields" type="text" name="website" size="30" tabindex=18>
        </td>
        <td width="1" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="115" nowrap bgcolor="#FFFFFF"><input type="checkbox" name="sn_attendee" value="1">
        SN attendee?</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#FFFFFF">Nickname:
            <input class="fields" type="text" name="nickname" size="40">
</td>
        <td width="3" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="240" bgcolor="#FFFFFF">Blog:
          <input class="fields" type="text" name="blog" size="30" tabindex=19>
        </td>
        <td width="1" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="115" nowrap bgcolor="#FFFFFF"><input type="checkbox" name="sn_speaker" value="1">
        SN speaker?</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#FFFFFF">Title:
            <input class="fields" type="text" name="title" size="50" tabindex=5>
</td>
        <td width="3" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="240" bgcolor="#FFFFFF">RSS:
          <input class="fields" type="text" name="rss" size="30" tabindex=20>
        </td>
        <td width="1" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="115" nowrap bgcolor="#FFFFFF"><input type="checkbox" name="snr_subscriber" value="1">
        SN Report sub?</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#FFFFFF">Company:
            <input class="fields" type="text" name="company" size="50" tabindex=6>
</td>
        <td width="3" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="240" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="1" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="115" nowrap bgcolor="#FFFFFF"><input type="checkbox" name="werblist_subscriber" value="1">
        Werblist sub?</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#FFFFFF">Address1:
            <input class="fields" type="text" name="address1" size="50" tabindex=7>
</td>
        <td width="3" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="240" bgcolor="#FFFFFF">Asst. Name:
          <input class="fields" type="text" name="asst_name" size="26" tabindex=21>
        </td>
        <td width="1" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="115" nowrap bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#FFFFFF">Address2:
            <input class="fields" type="text" name="address2" size="50" tabindex=8>
        </td>
        <td width="3" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="240" bgcolor="#FFFFFF">Asst. Phone:
          <input class="fields" type="text" name="asst_phone" size="25" tabindex=22>
        </td>
        <td width="1" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="115" nowrap bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td width="157" bgcolor="#FFFFFF">City:
            <input class="fields" type="text" name="city" size="20" tabindex=9>
        </td>
        <td bgcolor="#FFFFFF">State:
          <input class="fields" type="text" name="province" size="4" tabindex=10>
</td>
        <td bgcolor="#FFFFFF">Zip:
            <input class="fields" type="text" name="zip" size="10" tabindex=11>
</td>
        <td width="3" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="240" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="1" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="115" nowrap bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#FFFFFF">Country:
            <input class="fields" type="text" name="country" size="40" tabindex=12>
</td>
        <td width="3" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="240" bgcolor="#CCCCCC">Opt out?
          <input type="checkbox" name="out_out" value="1">
</td>
        <td width="1" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="115" nowrap bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#FFFFFF">Phone:
            <input class="fields" type="text" name="phone" size="24" tabindex=13>
</td>
        <td bgcolor="#FFFFFF">Fax:&nbsp;
          <input class="fields" type="text" name="fax" size="16" tabindex=14></td>
        <td width="3" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="240" bgcolor="#CCCCCC">Source:
            <select name="source">
              <?
$Query2 = "Select DISTINCT sources,sources from source";
$Recordset2 = mysql_query($Query2, $Link);
?>
              <option value="" selected>-- Please Choose a Source --</option>
              <?
while ($Row = mysql_fetch_assoc ($Recordset2))
{
?>
              <option value="<? echo $Row['sources']; ?>"><? echo $Row['sources']; ?></option>
              <?
}
mysql_free_result($Recordset2);
?>
            </select>
</td>
        <td width="1" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="115" nowrap bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#FFFFFF">Cell:
        <input class="fields" type="text" name="cellphone" size="22" tabindex=15></td>
        <td bgcolor="#FFFFFF">Home:
        <input class="fields" type="text" name="home_phone" size="15" tabindex=16></td>
        <td width="3" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="240" bgcolor="#CCCCCC">Personal connection?
            <input type="checkbox" name="personal_connection" value="1">
</td>
        <td width="1" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="115" nowrap bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="3" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="240" bgcolor="#CCCCCC">Category: 
          <select name="category">
            <?
$Query2 = "Select DISTINCT categories,categories from category";
$Recordset2 = mysql_query($Query2, $Link);
?>
            <option value="" selected>-- Please Choose A Category --</option>
            <?
while ($Row = mysql_fetch_assoc ($Recordset2))
{
?>
            <option value="<? echo $Row['categories']; ?>"><? echo $Row['categories']; ?></option>
            <?
}
mysql_free_result($Recordset2);
?>
        </select></td>
        <td width="1" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="115" nowrap bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="7" bgcolor="#FFFFFF">Comments<br />
        <?php /*
          <script language="javascript1.2">
editor_generate('comments');
          </script>
          */ ?>
            <textarea class="fields" name="comments" cols="65" rows="7" tabindex=17></textarea>
<?php /*   <script language="javascript1.2">editor_generate('comments'); </script> */

?>
</td>
      </tr>
      <tr>
        <td class="strip" colspan="7"><div align="center">
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
