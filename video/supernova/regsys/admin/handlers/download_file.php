<?php
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

$whereStr	=	'';
 		/**
		 * Exports a csv file of all recalls
		 */
			switch ($_POST['cols']) 
			{
				case 'custom':
					$colsStr	= 'people.first';
					break;
				case 'full':
					$colsStr	= 'reg__attendee.*, people.*, reg__conference.conference_name';
					break;					
				default:
					$colsStr	= 'people.first, people.last,people.email';
					break;					
			}
			
			if(ISSET($_POST['tag']))
			{
				if($_POST['tag'] != '')
				{
					$whereStr	= "WHERE people.ID IN (SELECT people_id FROM people_tags WHERE tag = '" . $_POST['tag'] . "');";
				}
			}
			
			$sqlStr 	= "SELECT  $colsStr 
							FROM reg__attendee 
								LEFT JOIN reg__conference ON (reg__attendee.conference_id = reg__conference.conference_id)
								LEFT JOIN people ON people.ID = reg__attendee.people_id
								LEFT JOIN reg__email_alias ON people.ID = reg__email_alias.people_id $whereStr ;";
						
			$sqlHelper	= new sqlHelper;
			$rsObj = $sqlHelper->queryCmd($sqlStr);
			$csvOutput	=	'';
			
			if($rsObj)
			{
				$totalRowsNum = mysql_num_rows($rsObj);
				if($totalRowsNum>0)
				{

					/** Write header row */
					for ($i=0; $i < mysql_num_fields($rsObj); $i++) 	// Table Header
					{ 
						$csvOutput .= "\"" . mysql_field_name($rsObj, $i)."\","; 
					}
					$csvOutput = trim($csvOutput,",");
					$csvOutput .= "\r\n";
					
					/** Write data rows */
					$fields=mysql_num_fields($rsObj);
					while ($row = mysql_fetch_row($rsObj)) 			// Table body
					{ 
						for ($f=0; $f < $fields; $f++) 
						{
							$csvOutput .= "\"" . $row[$f] . "\","; 
						}
						$csvOutput = trim($csvOutput,",");
						$csvOutput .= "\r\n";
					}

					header('Content-type: application/octet-stream');
					header('Content-Disposition: attachment; filename='.date('Y-m-d').'.csv');
					print $csvOutput;
					exit(); 
				}
			}
?>