<?
session_start();
include "functions.php";										// NEEDED TO CHECK VALID LOGIN
check_login($_SERVER['PHP_SELF'], $_SERVER["QUERY_STRING"]);	// NEEDED TO CHECK VALID LOGIN

$itemNumber = $HTTP_GET_VARS['itemNumber'];
$key = $HTTP_GET_VARS['key'];
$fullOrderBy = $HTTP_SESSION_VARS['fullOrderBy'];
$whereclause = $HTTP_SESSION_VARS['whereclause'];
$total_results = $HTTP_SESSION_VARS['total_results'];
require("people_connect.php");
$Link = mysql_pconnect($Host, $User, $Password);
mysql_select_db($DBName, $Link);
if ($itemNumber == 0)
{
$screen = 1;
}
else
{
if (($itemNumber / 25 ) < ceil($itemNumber / 25))
      {
      $screen = ceil($itemNumber / 25);
      }
      else
      {
      $screen = ceil($itemNumber / 25) + 1;
      }
}


$backToSearch = "people_search_results.php?screen=" . $screen;

if (!$itemNumber)
	$Query = "SELECT * from people where ID=$key";
else
{
	$Query = "SELECT *";
	$Query = $Query . ", date_format(created_on, '%m/%d/%Y') as created_on";
	$Query = $Query . " FROM people " . $whereclause . $fullOrderBy . " LIMIT " . $itemNumber . ", 1";
}

$Recordset = mysql_query($Query, $Link);
while ($Row = mysql_fetch_assoc ($Recordset)) 
{
$key 					= $Row['ID'];
$ID 					= $Row['ID'];
$user_id 				= $Row['user_id'];
$last 					= $Row['last'];
$first 					= $Row['first'];
$email 					= $Row['email'];
$middle 				= $Row['middle'];
$nickname 				= $Row['nickname'];
$title 					= $Row['title'];
$company 				= $Row['company'];
$address1 				= $Row['address1'];
$address2 				= $Row['address2'];
$city 					= $Row['city'];
$province 				= $Row['province'];
$zip 					= $Row['zip'];
$country 				= $Row['country'];
$phone 					= $Row['phone'];
$fax 					= $Row['fax'];
$cellphone 				= $Row['cellphone'];
$home_phone 			= $Row['home_phone'];
$website 				= $Row['website'];
$blog 					= $Row['blog'];
$twitter 					= $Row['twitter'];
$rss 					= $Row['rss'];
$asst_name 				= $Row['asst_name'];
$asst_phone 			= $Row['asst_phone'];
$out_out 				= $Row['out_out'];
$source 				= $Row['source'];
$personal_connection 	= $Row['personal_connection'];
$category 				= $Row['category'];
$sn_attendee			= $Row['sn_attendee'];
$sn_speaker 			= $Row['sn_speaker'];
$snr_subscriber 		= $Row['snr_subscriber'];
$werblist_subscriber 	= $Row['werblist_subscriber'];
$comments 				= $Row['comments'];
$created_on 			= $Row['created_on'];
$marketer 				= $Row['marketer'];
}
$URL = "people_edit_update.php?key=$key&itemNumber=$itemNumber&mode=$mode";
?>

<html>
<head>

<title>people Edit Detail</title>
<link rel="stylesheet" href="people_styles.css" type="text/css">
<script language="JavaScript">
<!--
function validateForm() 
{
var errors = '';
// NOT IN FORM      if (document.edit.ID.value == '' || isNaN(document.edit.ID.value)) errors += 'Field ID is numeric.  Please enter a number in this field and try again.\n'
      if (document.edit.last.value == '') document.edit.last.value = " ";
      if (document.edit.first.value == '') document.edit.first.value = " ";
      if (document.edit.email.value == '') document.edit.email.value = " ";
      if (document.edit.middle.value == '') document.edit.middle.value = " ";
      if (document.edit.nickname.value == '') document.edit.nickname.value = " ";
      if (document.edit.title.value == '') document.edit.title.value = " ";
      if (document.edit.company.value == '') document.edit.company.value = " ";
      if (document.edit.address1.value == '') document.edit.address1.value = " ";
      if (document.edit.address2.value == '') document.edit.address2.value = " ";
      if (document.edit.city.value == '') document.edit.city.value = " ";
      if (document.edit.province.value == '') document.edit.province.value = " ";
      if (document.edit.zip.value == '') document.edit.zip.value = " ";
      if (document.edit.country.value == '') document.edit.country.value = " ";
      if (document.edit.phone.value == '') document.edit.phone.value = " ";
      if (document.edit.fax.value == '') document.edit.fax.value = " ";
      if (document.edit.cellphone.value == '') document.edit.cellphone.value = " ";
      if (document.edit.home_phone.value == '') document.edit.home_phone.value = " ";
      if (document.edit.website.value == '') document.edit.website.value = " ";
      if (document.edit.blog.value == '') document.edit.blog.value = " ";
// NOT IN FORM      if (document.edit.rss.value == '') document.edit.rss.value = " ";
      if (document.edit.asst_name.value == '') document.edit.asst_name.value = " ";
      if (document.edit.asst_phone.value == '') document.edit.asst_phone.value = " ";
      if (document.edit.out_out.value == '' || isNaN(document.edit.out_out.value)) errors += 'Field out_out is numeric.  Please enter a number in this field and try again.\n'
      if (document.edit.source.value == '') document.edit.source.value = " ";
// NOT IN FORM      if (document.edit.personal_connection.value == '' || isNaN(document.edit.personal_connection.value)) errors += 'Field personal_connection is numeric.  Please enter a number in this field and try again.\n'
      if (document.edit.category.value == '') document.edit.category.value = " ";
// NOT IN FORM      if (document.edit.sn_attendee.value == '' || isNaN(document.edit.sn_attendee.value)) errors += 'Field sn_attendee is numeric.  Please enter a number in this field and try again.\n'
// NOT IN FORM      if (document.edit.sn_speaker.value == '' || isNaN(document.edit.sn_speaker.value)) errors += 'Field sn_speaker is numeric.  Please enter a number in this field and try again.\n'
      if (document.edit.snr_subscriber.value == '' || isNaN(document.edit.snr_subscriber.value)) errors += 'Field snr_subscriber is numeric.  Please enter a number in this field and try again.\n'
      if (document.edit.werblist_subscriber.value == '' || isNaN(document.edit.werblist_subscriber.value)) errors += 'Field werblist_subscriber is numeric.  Please enter a number in this field and try again.\n'
      if (document.edit.comments.value == '') document.edit.comments.value = " ";
// NOT IN FORM      if (document.edit.created_on.value == '') errors += 'Field created_on is a date.  Please enter a date in this field and try again.\n'
   if (errors) alert('The following error(s) occurred:\n' + errors);
  document.returnValue = (errors == '');
}
function callJavaScript(functionName) 
{
  return eval(functionName)
}

function confirm_click(loc)
{

	var answer = null;
	answer = prompt("Type \"y\" to remove this tag from this person.", "");
	
	if (answer.toLowerCase() == 'y') 
	{
		document.location = loc
	}
}
//-->
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="people_styles.css" rel="stylesheet" type="text/css">
</head>

<body>

<?
require("header.php");
require("people_header.inc");
?>
<div align="center">
<form onSubmit="validateForm();return document.returnValue" method="post" action="<? echo $URL; ?>" name="edit">
  <table width="98%" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" class="data2">
    <tr class="strip">
      <td class="strip">&nbsp;EDIT RECORD&nbsp;&nbsp;&nbsp; 
        <input type="submit" name="add" value="Update Record"></td>
	  <td><div align="center"><a class="button" href="javascript:if (confirm(&quot;Delete this record?&quot;) == true) location.href=&quot;people_delete.php?itemNumber=<?=$itemNumber?>&key=<?=$key?>&quot;">Delete Record</a> 
</div></td>

	<td class="button">
              <div align="center"><a class="button" href='<?=$backToSearch?>'>Back to Search Results</a>
              </div></td>
			  <td>&nbsp;</td>
			  <td><div align="Center"><a class="button" href="mailing-label.php?key=<?=$key?>&itemNumber=<?=$itemNumber?>">Mailing Label</a> </div></td>
    </tr>
	<tr>
      <td colspan="1" bgcolor="#FFFFFF">ID# &nbsp;
        <!--<input class="fields" type="text" name="ID" value="<?=$ID?>" size="40">-->
        <b>
        <?=$user_id?>
      </b> </td><td bgcolor="#FFFFFF" colspan="2">Created:
        <?=$created_on?></td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF"><div align="right">      </div></td>
      </tr>
    <tr>
      <td colspan="2" bgcolor="#FFCC99">First:<br><font size="+1"><strong>
        
              <input class="fields" type="text" name="first" value="<?=$first?>" size="40" tabindex=1>
</strong></font></td>
      <td bgcolor="#FFCC99">Middle:<br><font size="+1"><strong>
        <input class="fields" type="text" name="middle" value="<?=$middle?>" size="15" tabindex=2>
      </strong></font></td>
      <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFF66"><font size="+1"><strong>
        <input class="fields" type="text" name="email" value="<?=$email?>" size="40" tabindex=4>
</strong></font></td>
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
?>&nbsp;&nbsp;&nbsp;
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
        <tr valign="top" bordercolor="#F4F4F4" class="data2">
          <td>Tags:</td>
          <td><?= write_tags($HTTP_GET_VARS['key']); ?></td>
        </tr>
        <tr valign="top" bordercolor="#F4F4F4" class="data2">
          <td>Tag As: </td>
          <td><?= write_tags_to_add($HTTP_GET_VARS['key']); ?></td>
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
      <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
<tr>
<td colspan="5">
<div align="center">
<input type="submit" name="add" value="Update Record">
</div>
</td>
</tr>
  </table> 
  </form>
<table width="650" cellpadding="0" cellspacing="0">
<tr>
<td>
<div align="center">  </div>

  <?
$previousurl = "people_edit_detail.php?" . SID . "&itemNumber=" . ($itemNumber - 1);
$nexturl = "people_edit_detail.php?" . SID . "&itemNumber=" . ($itemNumber + 1);
?>
<table border="0" cellspacing="0" cellpadding="0" class="detail" align="center">
  <tr> 
    <td> 
      <div align="center"> 
        <?
if ($itemNumber > 0 && $itemNumber <= $total_results )
{
?>
        <table width="150" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#CCCCCC">
          <tr> 
            <td class="button"> 
              <div align="center"> 
                <p><a class="button" href="<? echo $previousurl ?>">PREVIOUS</a></p>
              </div>
            </td>
          </tr>
        </table>
        <?
}
else
{
?>
        <table width="150" border="0">
          <tr> 
            <td> </td>
          </tr>
        </table>
        <?
}
?>
      </div>
    </td>
    <td> 
      <div align="center">        
        <table width="150" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#CCCCCC">
          <tr>
            <td class="button">
              <div align="center">
                <p><a class="button" href="javascript:if (confirm(&quot;Delete this record?&quot;) == true) location.href=&quot;people_delete.php?itemNumber=<?=$itemNumber?>&key=<?=$key?>&quot;">Delete
                    This Record</a></p>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </td>
    <td> 
      <div align="center"> 
        <?
if ($itemNumber >= 0 && $itemNumber < $total_results)
{
?>
        <table width="150" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#CCCCCC">
          <tr> 
            <td class="button"> 
              <div align="center"> 
                <p><a class="button" href="<? echo $nexturl ?>">NEXT</a></p>
              </div>
            </td>
          </tr>
        </table>
        <?
}
else
{
?>
        <table width="150" border="0">
          <tr> 
            <td> </td>
          </tr>
        </table>
<?
}
?>
      </div>
     </td>
    </tr>
</table>
<br>
<div align="center">
<p><a class='links' href='<?=$backToSearch?>'>Back to search results</a>
</div>
</td>
</tr>
</table>
</div>
<!--Generated for Kevin Werbach at  using ASaP! Version 3.1.37 , Copyright (C) 2000-2002 San Diego Web Partners, All Rights Reserved. Visit us at:  http://www.data-asap.com  or at:  http://www.sandiegowebpartners.com -->

</p>
</body>
</html>
