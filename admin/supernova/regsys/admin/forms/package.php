<?php
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

/**
* Page variables
*/
$keyField	= 'package_id';
$table		= 'reg__package';
$formHelper = new formHelper;
$$keyField	= getKey($table,$keyField,$formHelper);

// If this is a new item then default the conference id.
$conference_id	= ($$keyField == '' && isset($_COOKIE['conferenceIdCk'])) ? $_COOKIE['conferenceIdCk'] : $conference_id;
// If this is a new item then default the conference id.
$conference_id	= ($$keyField == '' && isset($_COOKIE['conferenceIdCk'])) ? $_COOKIE['conferenceIdCk'] : $conference_id;
?>
<?php require_once findRelativePath('includes/mainContentFrameHead.php'); ?>

</head>
<body>
<form id="mainForm" name="form1" method="post" action="<?php echo findRelativePath('handlers/update.php'); ?>">
<!-- == FORM CONTENT BEGIN ============================================================== -->
<table width="100%" border="0" cellspacing="0">
	<tr valign="top">
		<td colspan="2"><span id="formHeader"><?php echo isset($working_name) ? $working_name . " ($conference_id)" : '< Untitled >';  ?></span></td>
		<td colspan="2" align="right"><?php $formHelper->renderHiddenField('__package_id', $package_id); ?>
		  <input type="submit" name="x_submit" id="submit" value="S" />
		  <input type="button" name="x_new" id="x_new" value="N" onMouseUp="document.location = '<?php echo $_SERVER['SCRIPT_NAME']; ?>'" /></td>
	</tr>
	<tr><td colspan="4">&nbsp;</td></tr>
	<tr valign="top">
		<td>Package Name</td>
		<td>
			<?php $formHelper->renderTextField('package_name', 50, 100); ?>		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Working Name</td>
		<td><?php $formHelper->renderTextField('working_name', 50, 110); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
	  <td>Description</td>
	  <td><?php $formHelper->renderTextarea('description', $description, 30, 3); ?></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr valign="top">
	  <td>For Conference </td>
	  <td><?php $formHelper->renderSelectDB('conference_id', 'SELECT conference_id, working_name FROM reg__conference WHERE conference_status = "active"', 'conference_id', 'working_name', $conference_id, 113); ?></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr valign="top">
		<td>Package Type</td>
		<td><?php $formHelper->renderSelectDB('package_type', 'SELECT list_value, list_text FROM reg__list WHERE list_name = "package_type"', 'list_value', 'list_text', $package_type, 115); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Amount</td>
		<td><?php $formHelper->renderTextField('n_amount', 7, 120, '', $amount); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Early Bird Amount </td>
		<td><?php $formHelper->renderTextField('n_early_bird_amount', 7, 125, '', $early_bird_amount); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>List Order </td>
		<td><?php $formHelper->renderTextField('n_list_order', 2, 130, '', $list_order); ?></td>
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