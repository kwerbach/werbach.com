<?php
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

/**
* Page variables
*/
$keyField	= 'image_id';
$table		= 'reg__image';
$formHelper = new formHelper;
$$keyField	= getKey($table,$keyField,$formHelper);
?>
<?php require_once findRelativePath('includes/mainContentFrameHead.php'); ?>
<body>
<form action="<?php echo findRelativePath('handlers/image_upload.php'); ?>" method="post" enctype="multipart/form-data" name="mainForm" class="cmxform" >
<!-- == FORM CONTENT BEGIN ============================================================== -->
<table width="100%" border="0" cellspacing="0">
	<tr valign="top">
		<td colspan="2"><?php echo isset($conference_name) ? $conference_name : '< Untitled >';  ?></td>
		<td colspan="2" align="right"><?php $formHelper->renderHiddenField('__image_id', $image_id); ?>
		  <input type="submit" name="x_submit" id="submit" value="S" />
		  <input type="button" name="x_new" id="x_new" value="N" onMouseUp="document.location = '<?php echo $_SERVER['SCRIPT_NAME']; ?>'" /></td>
	</tr>
	<tr><td colspan="4">&nbsp;</td></tr>	
	<tr valign="top">
		<td>File:</td>
		<td>
			<input name="x_image" id="x_image" size="30" type="file" class="fileUpload" /></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
<!--	<tr valign="top">
		<td>New File Name</td>
		<td><?php $formHelper->renderTextField('new_file_name', 3, 110); ?> (optional)</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>-->
	<tr valign="top">
		<td>Working Name</td>
		<td><?php $formHelper->renderTextField('working_name', 25, 110); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Category</td>
		<td><?php $formHelper->renderSelect('category', array('logo','staff','speaker','sponsor')); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Small Width</td>
		<td><?php $formHelper->renderTextField('small_width', 3, 120); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Medium Width</td>
		<td><?php $formHelper->renderTextField('medium_width', 3, 130); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Large Width</td>
		<td><?php $formHelper->renderTextField('large_width', 3, 140); ?></td>
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
</table>

<!-- == FORM CONTENT END ================================================================ -->  
</form>
</body>
