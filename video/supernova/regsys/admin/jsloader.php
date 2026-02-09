<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>loader</title>
<style>
body {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
	background-color:#CCCCFF;
}
</style>
</head>

<body>
<?php 
// TESTING
// echo $_SERVER['PHP_SELF'] . "<br />";
// echo $_SERVER['QUERY_STRING']; 
?>
<?php 
if(isset( $_GET['page'] ))
{
$page = $_GET['page'];  // conference_id=2
echo <<<EOQ
	<script language="javascript">
//	alert('ready' + parent.main.location);
//	parent.main.location = "$page";
	parent.loadDiv('$page');
//	alert('ready' + parent.main.location);
	</script>
EOQ;
}
?>
</body>
</html>
