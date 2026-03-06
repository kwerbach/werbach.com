<?php
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

/**
* Page variables
*/

?>
<?php require_once findRelativePath('includes/mainContentFrameHead.php'); ?>
</head>

<body>
<?php getAttendee(2); ?>
</body>
</html>
<?php 
	function getAttendee($conferenceId)
	{
	$sqlHelper = new sqlHelper;
	
	$colsStr	= 'people.first, people.last,people.email';
	$whereStr	= "WHERE reg__attendee.conference_id = $conferenceId";
	$sqlStr 	= "SELECT  $colsStr 
				FROM reg__attendee 
					LEFT JOIN reg__conference ON (reg__attendee.conference_id = reg__conference.conference_id)
					LEFT JOIN people ON people.ID = reg__attendee.people_id
					LEFT JOIN reg__email_alias ON people.ID = reg__email_alias.people_id $whereStr ;";
	$rsObj = $sqlHelper->queryCmd($sqlStr);
		if($rsObj){
			echo "";
			$listOutput = <<<EOQ
			<div id="package_container">
			<table class="" width="100%" border="1" >
			<tr class="">
				<tr valign="top" class="package_table_header">
				<th>&nbsp;</th>
				<th>first</th>
				<th align="center">last</th>
				<th align="center">emial</th>
			
			</tr>
EOQ;
			while($rsRowArr = mysql_fetch_assoc($rsObj))
			{
				
				$first		= $rsRowArr['first'];
				$last		= $rsRowArr['last'];
				$email		= $rsRowArr['email'];
										
				$listOutput .= <<<EOQ
					<tr valign="top" class="package_row">
						<td><input name="attendee" id="attendee" type="radio" value=""/></td>
						<td>$first</td>
						<td>$last</td>
						<td>$email</td>
					</tr>
EOQ;
			}
			echo $listOutput;		
			echo "</table></div>";
		}
	}

?>