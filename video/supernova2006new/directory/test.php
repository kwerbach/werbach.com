<?php
$filename = "sfmixer2008.txt";
$handle = fopen($filename, "rb");
$contents = fread($handle, filesize($filename));
fclose($handle);
$rows	=	explode("\n", $contents);
echo "<table border=1  cellspacing=0 cellpadding=0>";
echo write_rows();
echo "</table>";




function write_rows()
{
	global $rows;
	$c = 1;
	echo "<tr><td colspan=6><b>Discussion and Reception Attendees</b></td></tr>";
	foreach ($rows as $r)
	{
		$bo = ($c == 1) ? "<b>" : "";
		$bc = ($c == 1) ? "</b>" : "";

		if(!preg_match('/\-{3}/', $r))  // SECTION BREAK
		{
			$r = str_replace("\t", "&nbsp;</td>\n<td nowrap>$bo", $r);
			echo "<tr>\n<td nowrap>$bo" . $r . "$bo&nbsp;</td>\n</tr>\n\n";
			$c++;
		}
		else
		{
			echo "<tr><td colspan=6><b>&nbsp;</b></td></tr>";
			echo "<tr><td colspan=6><b>Reception Only Attendees</b></td></tr>";
			$c = 1;
		}
	
	}
}
?> 