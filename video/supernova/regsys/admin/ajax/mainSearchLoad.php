<?php
header("Cache-Control: no-cache"); 
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

$formHelper = new formHelper;
$sqlHelper = new sqlHelper;
$table = $_GET['x_table'];
if(isset($_COOKIE['conferenceIdCk']))
{
	if($_COOKIE['conferenceIdCk'] != '')
	{
		echo "Working with: " . $sqlHelper->getDatum('reg__conference', 'working_name', 'conference_id', $_COOKIE['conferenceIdCk']);
	}		
}

if ($table != '-')
{
echo <<<EOQ
		<form name="search" id="search">
		Find $table where 
EOQ;
		$formHelper->renderSelectDb("field", "SHOW COLUMNS FROM reg__" . $_GET['x_table'], "Field", "Field", "");
echo <<<EOQ
		starts with: 
EOQ;
		$formHelper->renderTextField('foo', 10, 'x');
		$formHelper->renderHiddenField('x_table', $_GET['x_table']);
echo <<<EOQ
		</form>
EOQ;
}
?>