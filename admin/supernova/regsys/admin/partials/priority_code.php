<?php
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

/**
* Page variables
*/
$keyField	= 'priority_code_id';
$table		= 'reg__priority_code';
$formHelper = new formHelper;
$$keyField	= getKey($table,$keyField,$formHelper);

?>
<?php require_once findRelativePath('includes/mainContentFrameHead.php'); ?>

</head>
<body>
<form id="mainForm" name="form1" method="post" action="<?php echo findRelativePath('handlers/update.php'); ?>">
<!-- == FORM CONTENT BEGIN ============================================================== -->
<table width="100%" border="0" cellspacing="0">
	<tr valign="top">
		<td colspan="2"><span id="formHeader"><?php echo isset($working_name) ? $working_name . " ($priority_code_id)" : '< Untitled >';  ?></span></td>
		<td colspan="2" align="right"><?php $formHelper->renderHiddenField('__priority_code_id', $priority_code_id); ?>
		  <input type="submit" name="x_submit" id="submit" value="S" />
		  <input type="button" name="x_new" id="x_new" value="N" onMouseUp="document.location = '<?php echo $_SERVER['SCRIPT_NAME']; ?>'" /></td>
	</tr>
	<tr><td colspan="4">&nbsp;</td></tr>
	<tr valign="top">
		<td>Working Name</td>
		<td><?php $formHelper->renderTextField('working_name', 50, 110); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
	  <td>Description</td>
	  <td><?php $formHelper->renderTextField('description', 30, 115); ?></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr valign="top">
	  <td>For Conference </td>
	  <td><?php $formHelper->renderSelectDB('conference_id', 'SELECT conference_id, working_name FROM reg__conference WHERE conference_status = "active"', 'conference_id', 'working_name', $conference_id, 120); ?></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr valign="top">
		<td>Code</td>
		<td><?php $formHelper->renderTextField('code', 10, 125); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Category</td>
		<td><?php $formHelper->renderTextField('category', 25, 130); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Amount</td>
		<td><?php $formHelper->renderTextField('n_Amount', 2, 135, '', $amount); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Start Date </td>
		<td><?php $formHelper->renderTextFieldDp('start_date', 140); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>End Date </td>
		<td><?php $formHelper->renderTextFieldDp('end_date', 145); ?></td>
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