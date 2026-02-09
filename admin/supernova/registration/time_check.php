<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Time Check</title>
</head>

<body>
<?
$cutoff_date 	= getdate(mktime(3,0,0,5,6,2008));  	// NO MORE EARLYBIRD @ 12:00 AM
$right_now		= time();
$today 			= getdate(mktime(3, 0, 0, date("m")  , date("d"), date("Y")));
echo date("Y-m-d H:i:s",$cutoff_date[0]);
echo "<hr/>";
echo date("Y-m-d H:i:s",$right_now);
echo "<hr/>";
echo date("Y-m-d H:i:s",$today[0]);
echo "<hr/>";
echo "<hr/>";


$gm_cutoff_date 	= getdate(gmmktime(10,0,0,5,5,2008));  	// NO MORE EARLYBIRD -AS OF HMS MDY
$gm_right_now		= getdate(gmmktime(gmdate("G"), gmdate("i"), gmdate("s"), gmdate("m")  , gmdate("d"), gmdate("Y")));
$gm_today 			= ""; //getdate(gmmktime(10, 0, 0, date("m")  , date("d"), date("Y")));
$gm_today 			= ""; //
echo "GMT time to stop<br/>";
echo gmdate("Y-m-d H:i:s",$gm_cutoff_date[0]);
echo "<hr/>";
echo "GMT Time right now:<br/>";
echo $gm_right_now[0];
echo "<br/>";
echo gmdate("Y-m-d H:i:s",$gm_right_now[0]);
echo "<hr/>";
echo "<hr/>";
if($gm_right_now[0] >= $gm_cutoff_date[0])					
{
	echo gmdate("Y-m-d H:i:s",$gm_right_now[0]) . " is after <br/>" . gmdate("Y-m-d H:i:s",$gm_cutoff_date[0]);
}
else
{
	echo gmdate("Y-m-d H:i:s",$gm_right_now[0]) . " is before <br/>" . gmdate("Y-m-d H:i:s",$gm_cutoff_date[0]);
}

echo "<hr/>";
echo "<hr/>";echo "<hr/>";
echo "<hr/>";

	$cutoff_date = getdate(gmmktime(10,0,0,5,6,2008));  	// NO MORE EARLYBIRD @ 12:00 AM
	$today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
	
	if($today[0] >= $cutoff_date[0])					// FULL PRICE
	{
	
	}
	else
	{
	
	}
	
	/*
	at 10 GMT / 6 EDT stop taking stuff
	
	
	
	*/
?>
</body>
</html>
