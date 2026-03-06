<?php
# Random HTML ver.1.0 - (C)2000, Blake McDonald (webmaster@dark-library.com)

#### you don't need to edit this file ####

$settings_log = "settings.php";

require("$settings_log");

if($action=="options_update"){
$show_type = $show_type_new; }

$updates_file = "log.txt";

?>
<html><head>
<style type="text/css">
INPUT, TEXTAREA, SELECT, CHECKBOX
{background: black;color: #FFFFFF;border-color: #afae8b;}
FONT{text-decoration: none;}
BODY{text-decoration: none;font-family: Arial;color: #afae8b;}
A{font-family: Arial;text-decoration: underline;}
A:link{color: #FF9900;text-decoration: none;}
A:active{color: #FF9900;text-decoration: none;}
A:visited{color: #FF9900;text-decoration: none;}
A:hover{color: #FFFFFF;text-decoration: none;}
hr{color: #FF9900;}
</style>
<title>Random HTML Admin</title>
<SCRIPT LANGUAGE="JAVASCRIPT">
<!-- start
function NewWindow(mypage, myname, w, h, top, left, scroll, resize, status, menubar, toolbar, resizable) {
var winl = (screen.width - w) / 2;
var wint = (screen.height - h) / 2;
winops = 'height='+h+',width='+w+',top='+top+',left='+left+',scrollbars='+scroll+',resize='+resize+',status='+status+',toolbar='+toolbar+',resizable='+resizable+''
win = window.open(mypage, myname, winops)
if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
}
if (window!= top)
top.location.href=location.href
// -->
</script>

</head><body text=#afae8b bgcolor=#000000>



<?php
// checks if password has been set

// Log password into file

if($action=="submit_password"){
if($new_pass1 != $new_pass2 || empty($new_pass1)) {
echo "<font color=red>Password ERROR! Please try again...</font><p>";
}
}

if($action=="submit_password" && $new_pass1 == $new_pass2 && !empty($new_pass1) && !empty($new_pass2)){

$fp = fopen($settings_log, "w");
$fw = fwrite($fp, "<?php
\$show_type=1;
\$pass=\"$new_pass1\";
?>");
		fclose($fp);
echo "<center><br><big>Password has been set.<br><a href=$PHP_SELF>Go log in</a></a></big></center><p>";

} else {

if(empty($show_type) || empty($pass)) {

echo"<center><br><br>";

echo"
This is your first time using the script<br>
Please enter a password below that will be used when logging in
<FORM action=?action=submit_password method=POST>
<table><tr><td>
<small>Password:<br><INPUT TYPE=password NAME=new_pass1 SIZE=10><br>
Again:<br><INPUT TYPE=password NAME=new_pass2 SIZE=10><br>
<INPUT TYPE=submit VALUE=\"Submit\"></small>
</form>
</td></tr></table>
</center>
";


} else {

if($password!=$pass) {

echo"
<center>
<font color=red><h1>Log in</h1></font>
<FORM action=?action=loged_in method=POST>
<INPUT TYPE=password NAME=password SIZE=10>
<INPUT TYPE=submit VALUE=\"Log in\">
</form>
</center>
";
}


if($action=="loged_in" && $password==$pass) {

echo "<center><font color=red><h1>Random HTML Admin</h1></font></center>";

		$fp = fopen($updates_file, "r");
		$x = fread($fp, filesize ($updates_file));
		fclose($fp);

$x = stripslashes ($x);
$update = stripslashes ($update);

if ($update_file=="1") {


		$fp = fopen($updates_file, "w");
		$fw = fwrite($fp, $update);
		fclose($fp);

$x=$update;

echo "<font color=red>Random HTML log has been updated!</font><br>";

}


echo "
<script>
function addBreak()
{
  var area = document.forms[0].update
  area.value = area.value + \"\\n\\n[%%BREAK%%]\\n\\n\"
}
</script>
<table><tr><td>
<FORM action=\"?action=loged_in&update_file=1\" method=POST>
Random Codes:<br><textarea name=update rows=20 cols=85>$x</textarea>
<INPUT TYPE=hidden NAME=\"password\" VALUE=\"$pass\"><br>
<INPUT TYPE=submit VALUE=Update>
<INPUT TYPE=reset VALUE=\"Restore from last Updated\">
---------------<INPUT TYPE=Button VALUE=\"Add Break\" onClick=\"addBreak();\">
---------------<a href=\"?action=options&password=$pass\" onclick=\"NewWindow(this.href,'name','500', '400', '0', '150', 'no','no', 'no', 'no', 'no', 'no');return false;\"><strong>Options</strong></a>
--<a href=\"?action=help&password=$pass\" onclick=\"NewWindow(this.href,'name','500', '400', '0', '150', 'yes','no', 'no', 'no', 'no', 'no');return false;\"><strong>Help</strong></a>
</form>

";

$x= str_replace ("[%%BREAK%%]","<hr>", $x);

echo "
<center>
<big>Pre-View</big><hr>
<table width=700 border=0 cellspacing=0 cellpadding=0>
<tr>
<td valign=top>
$x
</td>
</tr>
</table>
<hr>
</td></tr></table>
</center>
";
}

if ($action=="loged_in" && $password!=$pass) {

echo "<center><font color=red>Wrong Password!!!</font><p></center>";

}

if($action=="options" || $action=="options_update" && $password==$pass) {
echo "
<center>
<font color=red><h1>Options</h1></font>
";

if($action=="options_update" && $update_pass1 == $update_pass2) {

if(!empty($update_pass1) && !empty($update_pass2)){
$new_pass = $update_pass1;
} else { $new_pass = $pass; }


$fp = fopen($settings_log, "w");
$fw = fwrite($fp, "<?php
\$show_type=$show_type_new;
\$pass=\"$new_pass\";
?>");
		fclose($fp);

		$pass = $new_pass;

echo "<font color=red>Options have been updated!</font>";
} else 
if($update_pass1 != $update_pass2){

echo "<font color=red>Password ERROR!</font>";

}

if($show_type == "1"){
$value1 = "SELECTED";
} else
if($show_type == "2"){
$value2 = "SELECTED";
} else
if($show_type == "3"){
$value3 = "SELECTED";
}

echo "
<table width=95%><tr><td>
<FORM action=\"?action=options_update&password=$pass\" method=POST>

HTML display type:<br>
  <SELECT NAME=show_type_new>
  <OPTION $value1 value=1>Cycle
  <OPTION $value2 value=2>Controlled Random
  <OPTION $value3 value=3>Total Random</SELECT>
  <br><small>*Go to help for details</small><p>

<br>Change Password (enter twice)<br>
<INPUT TYPE=password NAME=update_pass1 SIZE=10><br>
<INPUT TYPE=password NAME=update_pass2 SIZE=10><p>
<INPUT TYPE=submit VALUE=\"Update options\">
</form>

</td></tr></table>
</center>
";

		}
	}
}

if($action == "help" && $password == $pass){ ?>
<center>
<font color=red><h1>Help</h1></font>
<table width=95%><tr><td>
To inset HTML codes for display just paste or type the code into the form and separate each one by a break. You can insert breaks by hitting the insert break button. When you update the log file those codes will be sent for random display right away. You can also view how each code looks below the form. A divider is used to separates each random code.<p>

<big>Random Type Descriptions</big><br>
<b>Cycle</b>: This goes though the entire html codes in a cycle or sequence. This will result in having each HTML code displayed the same amount of times.<br>
<b>Controlled Random</b>: This shows a random html code but it won't show the same code twice in a row.<br>
<b>Total Random</b>:  This will show a totally random HTML code.<p>

To display the random code put this on the page where you want it and put in the full system path to the random.php file.<p>
&lt;?php include("/full/system/path/random.php"); ?&gt;

<p>
<hr><p>

If you find a bug or add to/improve the script please contact me at <a href=mailto:webmaster@dark-library.com>webmaster@dark-library.com</a> and tell me about it.
<p>

<hr><p>

</td></tr></table>
</center>
<?php } ?>
<small>Random HTML by <a href=mailto:webmaster@dark-library.com>Blake McDonald</a>, &copy;2000</small>
</body></html>
