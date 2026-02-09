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
<link href="<?php echo findRelativePath('includes/jquery.autocomplete.css') ?>" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo findRelativePath('includes/jquery.autocomplete.js'); ?>'></script>
<script language="JavaScript">

<!--

$(document).ready(function() {

	$("#tag").autocomplete("../ajax/search_tag.php", {
		width: 260,
		selectFirst: false
	}
	);
	
 });

//-->

</script>  
</head>
<body>
<form id="mainForm" name="form1" method="post" action="<?php echo findRelativePath('handlers/download_file.php'); ?>">
<!-- == FORM CONTENT BEGIN ============================================================== -->
<table width="100%" border="0" cellspacing="0">
	<tr valign="top">
		<td colspan="2"><span id="formHeader">Download Attendees</span></td>
		<td colspan="2" align="right"><input type="submit" name="x_submit" id="submit" value="S" />
			<input type="button" name="x_new" id="x_new" value="N" onMouseUp="document.location = '<?php echo $_SERVER['SCRIPT_NAME']; ?>'" /></td>
	</tr>
	<tr valign="top">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td >Download <u>All</u> Attendees</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>
			Columns:
			<?php $formHelper->renderRadio ("cols", "email", "email","email"); ?>
			<?php $formHelper->renderRadio ("cols", "full", "full"); ?>	
			<!--	<?php $formHelper->renderRadio ("cols", "custom", "custom"); ?>		 -->
		</td>
		<td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Tag:
		<?php 
			$formHelper->renderTextField("tag", 25, 110, array("autocomplete"=>"off"));
		?>
		
</td>
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
</table>

<!-- == FORM CONTENT END ================================================================ -->  
</form>
</body>