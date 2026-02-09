<?
session_start();

// validate session info???

require_once("people_connect.php");
require_once("functions.php");

$Link = mysql_pconnect ($Host, $User, $Password);
mysql_select_db($DBName, $Link);

$mode = $HTTP_GET_VARS['mode'];
$key = $HTTP_GET_VARS['key'];

if ($mode == "overwrite")
{
	mysql_query("delete from people where ID=$key");		// remove old data
	$fields = get_fields_small();

	if (mysql_query("insert into people (user_id, $fields) select user_id, $fields from duplicates where pid=$key"))
		mysql_query("delete from duplicates where pid=$key");
	else
		die("failed to move data.<br/>". mysql_error());
}
else if ($mode == "nothing")
{
	mysql_query("delete from duplicates where pid=$key");
}
else if ($mode == "edit")
{
	mysql_query("delete from duplicates where pid=$key");
	header("Location: people_edit_detail.php?key=$key&mode=dupe");
	exit;	// shouldn't get past the above statement.
}
?>
<title> Import</title>
<link rel="stylesheet" href="people_styles.css" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="people_styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<p class="title">Supernova Group Database</p>
<p>

<?
require("people_header.inc");

if ($HTTP_POST_VARS['submit'] == 'Import')
{
	if ($_FILES['file'])
	{
		$importfile = $_FILES['file']['tmp_name'];

		$fields = get_fields_small() . ",created_on ";

		if ($data = input_file($importfile))
		{
			for ($i = 0; $i < count($data); $i++)
			{
				$user_id = get_unique_id($data[$i][0]);
				$date = "NOW()";

				if (!trim($data[$i][0]))		// an empty line in the import file
					continue;

				//              	 									last              first             email
				$values = str_replace("\r", "", str_replace("\n", "", "'{$data[$i][0]}', '{$data[$i][1]}', '{$data[$i][2]}'"));

				// put duplicates into duplicates table
				if ( (mysql_num_rows(mysql_query("select ID from people where email='{$data[$i][2]}'")) > 0) )
				{
					$key = mysql_result($result,0);
					mysql_query("insert ignore into duplicates (ID, pid, user_id, $fields) values(1, $key, '$user_id', $values, $date)") or die("1.".mysql_error());
				}
				else		// everything is fine so add to db.
				{
					mysql_query("insert ignore into people (user_id, $fields) values('$user_id', $values, $date)") or die("2. ".mysql_error());
				}
			}
		}
		else
			print "Failed to open file.";
	}
}

if (mysql_num_rows(mysql_query("select pid from duplicates")) > 0)	// then there are duplicates, let's handle them.
{
	print "Some records could not be added because they conflict with another record that is currently in the database.<br/>";

	print "<table cellpadding='5' cellspacing='5'>";
	print "<tr><th colspan='3'>Duplicate</th><th width='200'>Existing</th></tr>";
	print "<tr><td><b>Last</b></td><td><b>First</b></td><td><b>Email</b></td><td align='center'><b>Action</b></td></tr>";

	$result = mysql_query("select pid, last, first, email from duplicates order by last") or die(mysql_error());

	while ($row = mysql_fetch_array($result))
	{
		print "<tr>
				<td width='100'>{$row['last']}</td>
				<td width='100'>{$row['first']}</td>
				<td width='100'>{$row['email']}</td>
				<td align='center'><a href='people_import.php?mode=overwrite&key={$row['pid']}'>Overwrite</a> |
					<a href='people_import.php?mode=nothing&key={$row['pid']}' >Skip</a> |
					<a href='people_import.php?mode=edit&key={$row['pid']}' >Edit</a></td>
			   </tr>";
	}
	print "</table>";
	exit;
}
else if ($HTTP_POST_VARS['submit'] == 'Import')
{
	print "<p align='center'><b>Records successfully added</b></p>";
	exit;
}

$fields = get_fields_small();
?>

<p>Your import file should be tab-delimited and have the following fields:<br/><li><b><?=$fields?></b></li></p>

<!--<em>exactly</em> <a href='import_columns.php' target='newwindow'>these</a> columns in order.</p>-->

<form action='people_import.php' enctype='multipart/form-data' method='post'>
<input type='hidden' name='MAX_FILE_SIZE' value='131072'/>
<table class='report' align='center' cellpadding='5' cellspacing='0'>
<tr><td class='strip'>Import</td></tr>
<tr><td align='center' class='data3'>
	<table cellpadding='5'>
		<tr>
			<td class='data3'><b>Filename:</b><br/><input class='file' type='file' name='file'/><input class='button' type='submit' name='submit' value='Import'/></td>
		</tr>
	</table>
</td></tr>
</table>

</form>