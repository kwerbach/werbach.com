<?php

$reg_year = "2008";

$filename = "sfmixer2008.txt";
$handle = fopen($filename, "rb");
$contents = fread($handle, filesize($filename));
fclose($handle);
$rows	=	explode("\n", $contents);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Supernova <?php echo $reg_year; ?> - SF Mixer Directory</title>
	<meta name="author" content="Supernova 2008" />
    <meta name="keywords" content="supernova, supernova2006, conference, technology, internet, computing, communications, digital media, social software, business, emerging technology, tech companies, web, web 2.0, kevin werbach, san francisco" />
    <meta name="description" content="The Supernova conference focuses on the technology-driven transformation of computing, communications, digital media, and business. " />
    <meta name="robots" content="index, follow" />

	<link rel='stylesheet' type='text/css' media='all' href='http://www.werbach.com/supernova2006new/go?css=site/site_css' />
	<style type='text/css' media='screen'>@import "http://www.werbach.com/supernova2006new/go?css=site/site_css";</style>

    <link rel="alternate" type="application/rss+xml" title="supernova" href="" />
    <link rel="shortcut icon" type="image/x-ico" href="../directory/favicon.ico" />
    
<script language="javascript">
function validate()
{
	if(document.forms[0].first.value == "")
	{
		alert("Please fill out all required fields");
		document.forms[0].first.focus();
		return false;
	}
	
	if(document.forms[0].last.value == "")
	{
		alert("Please fill out all required fields");
		document.forms[0].last.focus();
		return false;
	}
	
	if(document.forms[0].email.value == "")
	{
		alert("Please fill out all required fields");
		document.forms[0].email.focus();
		return false;
	}
	
	if(document.forms[0].company.value == "")
	{
		alert("Please fill out all required fields");
		document.forms[0].company.focus();
		return false;
	}
	
	if(document.forms[0].title.value == "")
	{
		alert("Please fill out all required fields");
		document.forms[0].title.focus();
		return false;
	}

	return true;
}
</script>
    
    
  </head>
  <body>

<br />
<table border=0  cellspacing=0 cellpadding=5>
<tr align="center"><td><h2>Supernova 2008 - San Francisco Mixer Attendees</h2></td></tr>
<tr><td>
<?php 
echo "<table border=1  cellspacing=0 cellpadding=0>";
echo write_rows();
echo "</table>";
?>
</td></tr></table>

  </body>
</html>
<?php


function write_rows()
{
	global $rows;
	$c = 1;
	echo "<tr bgcolor=FFFFFF align=left><td colspan=6><b>Discussion and Reception Attendees</b></td></tr>";
	foreach ($rows as $r)
	{
		$bo = ($c == 1) ? "<b>" : "";
		$bc = ($c == 1) ? "</b>" : "";

		if(!preg_match('/\-{3}/', $r))  // SECTION BREAK
		{
			$r = str_replace("\t", "&nbsp;</td>\n<td nowrap>$bo", $r);
			echo "<tr bgcolor=FFFFFF  valign=top>\n<td >$bo" . $r . "$bo&nbsp;</td>\n</tr>\n\n";
			$c++;
		}
		else
		{
			echo "<tr><td colspan=8><b>&nbsp;</b></td></tr>";
			echo "<tr><td colspan=8  align=left bgcolor=FFFFFF><b>Reception Only Attendees</b></td></tr>";
			$c = 1;
		}
	
	}
}
?> 