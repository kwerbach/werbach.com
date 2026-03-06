<?php
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

/**
* Page variables
*/
$keyField	= 'download_id';
$table		= 'reg__download';
$formHelper = new formHelper;
$$keyField	= getKey($table,$keyField,$formHelper);

?>
<?php require_once findRelativePath('includes/mainContentFrameHead.php'); ?>
<script language="JavaScript">

<!--

$(document).ready(function() {

		$("#conferenceId").change(function()
		{
			set_cookie('conferenceIdCk', $(this).val(), 10080)		// 10080 = 1 week
			alert( 'Conference Updated' );

		}
		);

 }
 );

//-->

</script>  
</head>
<body>
<form id="mainForm" name="form1" method="post" action="<?php echo findRelativePath('handlers/download_file.php'); ?>">
<!-- == FORM CONTENT BEGIN ============================================================== -->
<table width="100%" border="0" cellspacing="0">
	<tr valign="top">
		<td colspan="2"><span id="formHeader">Select A Conference</span></td>
		<td colspan="2" align="right"><input type="submit" name="x_submit" id="submit" value="S" />
	</tr>
	<tr valign="top">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Conference:
		<?php 
			$formHelper->renderSelectDb("conferenceId", "SELECT conference_id, working_name FROM reg__conference ORDER BY conference_id DESC;", "conference_id", "working_name", $_COOKIE['conferenceIdCk']);
		?>
		
</td>
		<td>
		<script language="javascript">
		document.write(get_cookie('conferenceIdCk'));
		</script>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>&nbsp;</td>
		<td><?php echo $_COOKIE['conferenceIdCk']; ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>

<!-- == FORM CONTENT END ================================================================ -->  
</form>
</body>