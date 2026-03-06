<?php
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

/**
* Page variables
*/

// If this is a new item then default the conference id.
$conference_id	= (isset($_COOKIE['conferenceIdCk'])) ? $_COOKIE['conferenceIdCk'] : $conference_id;
?>
<?php require_once findRelativePath('includes/mainContentFrameHead.php'); ?>


<script language="javascript">

<!--

 $(document).ready(function() {
  
  	/*- toggle attendee details */
   $("tr[id=attendee_row]").click(function(event)
		{
			$(this).next().toggle();
   		}
		);
   
 }
 );
//-->

</script>
</head>

<body>
<?php getAttendee(2); ?>
</body>
</html>
<?php 
	function getAttendee($conferenceId)
	{
	$sqlHelper = new sqlHelper;
	
	$colsStr	= 'a.attendee_id, p.first, p.last, p.email, a.conference_package, a.priority_code, a.date_registered';
	$whereStr	= "WHERE a.conference_id = $conferenceId";
	$sqlStr 	= "SELECT  $colsStr 
					FROM reg__attendee a 
						LEFT JOIN reg__conference c ON (a.conference_id = c.conference_id)
						LEFT JOIN people p ON p.ID = a.people_id
						LEFT JOIN reg__email_alias e ON p.ID = e.people_id $whereStr ;";
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
			$fields=mysql_num_fields($rsObj);
			while($rsRowArr = mysql_fetch_assoc($rsObj))
			{
				
		

				for ($f=0; $f < $fields; $f++) 
				{
					$fieldName 	= mysql_field_name($rsObj, $f);
					$$fieldName = $rsRowArr[$fieldName]; 
//					echo "$fieldName = $$fieldName <br/>";		// TESTING
				}
	
										
				$listOutput .= <<<EOQ
					<tr valign="top" class="attendee_row" id="attendee_row">
						<td><input name="attendee" id="attendee" type="checkbox" value="$attendee_id"/></td>
						<td>$first</td>
						<td>$last</td>
						<td>$email</td>
					</tr>
					<tr valign="top" class="attendee_row_details" id="row$attendee_id" title="row$attendee_id">
						<td colspan="4">details (coming soon)</td>
					</tr>					
EOQ;
			}
			echo $listOutput;		
			echo "</table></div>";
		}
	}

?>