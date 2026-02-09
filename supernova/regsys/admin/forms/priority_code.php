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

// If this is a new item then default the conference id.
$conference_id	= ($$keyField == '' && isset($_COOKIE['conferenceIdCk'])) ? $_COOKIE['conferenceIdCk'] : $conference_id;
?>
<?php require_once findRelativePath('includes/mainContentFrameHead.php'); ?>
<script language="javascript">
				$(document).ready(function() 
				{
			
					// validate form on keyup and submit
					var validator = $("#mainForm").validate
						(
						{
							rules: 
							{
								working_name: "required",
								conference_id: "required",
								code: "required",
								category: "required",
								d_start_date: "required",
								d_end_date: "required"							
							},
							errorContainer: $("#errorContainer"),
							errorLabelContainer: $("ul"," #errorContainer"),
							wrapper: 'li'
	
						}
						);
						

				}
				);
				

</script>
</head>
<body>
<form id="mainForm" name="form1" method="post" action="<?php echo findRelativePath('handlers/update.php'); ?>">
<!-- == FORM CONTENT BEGIN ============================================================== -->
<table width="100%" border="0" cellspacing="0">
	<tr valign="top">
		<td colspan="2">
			<span id="formHeader"><?php echo isset($working_name) ? $working_name . " (". $$keyField . ")" : '< Untitled >';  ?></span>
			<?php $formHelper->renderHiddenField('__' . $keyField, $$keyField); ?>		</td>
<!-- == FORM BUTTONS BEGIN ============================================================== -->
		<td colspan="2" align="right" width="100">
			<img src="<?php echo findRelativePath('images/icon_save_no.gif'); ?>" alt="Save" width="25" height="25" border="0" id="btnSave" />
			<img src="<?php echo findRelativePath('images/icon_new.gif'); ?>" alt="New" width="25" height="25" border="0" id="btnNew" />		</td>
<!-- == FORM BUTTONS END ============================================================== -->
</tr>
	<tr><td colspan="4">
<!-- == ERROR CONTAINER BEGIN ============================================================== -->
	<div id="errorContainer">
	<h4>There were errors in your form submission, please see below for details.</h4>
	<ul>
		<li><label for="working_name" class="error">A working text is required.</label></li>
		<li><label for="conference_id" class="error">Please select a conference</label></li>		
		<li><label for="code" class="error">Please enter a priority code.</label></li>
		<li><label for="category" class="error">Please enter a category for the priority code.</label></li>
		<li><label for="d_start_date" class="error">You need a date for this code to start.</label></li>
		<li><label for="d_end_date" class="error">You need a date for this code to end.</label></li>
	</ul>
	</div>
<!-- == ERROR CONTAINER END ================================================================ -->	
	</td>
	</tr>		
	<tr><td colspan="4">&nbsp;</td></tr>
	<tr valign="top">
		<td>Working Name</td>
		<td><?php $formHelper->renderTextField('working_name', 50, 110); ?> <span class="required">*</span></td>
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
	  <td><?php $formHelper->renderSelectDB('conference_id', 'SELECT conference_id, working_name FROM reg__conference WHERE conference_status = "active"', 'conference_id', 'working_name', $conference_id, 120); ?> <span class="required">*</span></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr valign="top">
		<td>Code</td>
		<td><?php $formHelper->renderTextField('code', 10, 125); ?> <span class="required">*</span></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Tag</td>
		<td><?php $formHelper->renderTextField('tag', 20, 127); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Category</td>
		<td><?php $formHelper->renderTextField('category', 25, 130); ?> <span class="required">*</span></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Amount</td>
		<td><?php $formHelper->renderTextField('n_Amount', 7, 135, '', $amount); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Start Date </td>
		<td><?php $formHelper->renderTextFieldDp('start_date', 140); ?> <span class="required">*</span></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>End Date </td>
		<td><?php $formHelper->renderTextFieldDp('end_date', 145); ?> <span class="required">*</span></td>
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