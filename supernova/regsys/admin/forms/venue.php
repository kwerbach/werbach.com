<?php
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

/**
* Page variables
*/
$keyField	= 'venue_id';
$table		= 'reg__venue';
$formHelper = new formHelper;
$$keyField	= getKey($table,$keyField,$formHelper);
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
								venue_name: "required",
								working_name: "required"								
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
<form id="mainForm" name="mainForm" class="cmxform"  method="post" action="<?php echo findRelativePath('handlers/update.php'); ?>">
<!-- == FORM CONTENT BEGIN ============================================================== -->
<table width="100%" border="0" cellspacing="0">
	<tr valign="top">
		<td colspan="2">
			<span id="formHeader"><?php echo isset($working_name) ? $working_name . " (". $$keyField . ")" : '< Untitled >';  ?></span>
			<?php $formHelper->renderHiddenField('__' . $keyField, $$keyField); ?>		</td>
<!-- == FORM BUTTONS BEGIN ============================================================== -->
		<td colspan="2" align="right">
			<img src="<?php echo findRelativePath('images/icon_save_no.gif'); ?>" alt="Save" width="25" height="25" border="0" id="btnSave" />
			<img src="<?php echo findRelativePath('images/icon_new.gif'); ?>" alt="New" width="25" height="25" border="0" id="btnNew" />		</td>
<!-- == FORM BUTTONS END ============================================================== -->
</tr>
	<tr><td colspan="4">
<!-- == ERROR CONTAINER BEGIN ============================================================== -->
	<div id="errorContainer">
	<h4>There were errors in your form submission, please see below for details.</h4>
	<ul>
		<li><label for="venue_name" class="error">Venue name is required</label></li>
	</ul>
	</div>
<!-- == ERROR CONTAINER END ================================================================ -->	
	</td></tr>	
	<tr valign="top">
		<td>Name</td>
		<td>
			<?php $formHelper->renderTextField('venue_name', 50, 105); ?>
			<span class="required">*</span></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Working Name</td>
		<td><?php $formHelper->renderTextField('working_name', 20, 110, array("title"=>"The name that will be shown in the admin tool.")); ?>
			<span class="required">*</span></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Address 1</td>
		<td><?php $formHelper->renderTextField('address_1', 50, 115); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Address 2</td>
		<td><?php $formHelper->renderTextField('address_2', 50, 120); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>City, State ZIP </td>
		<td><?php $formHelper->renderTextField('city', 20, 120); ?>, 
	    <?php $formHelper->renderTextField('state', 2, 121, 2); ?> 
		<?php $formHelper->renderTextField('zip', 5, 123, 6); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Website</td>
		<td><?php $formHelper->renderTextField('web_site', 50, 130, 255); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Link 1 </td>
		<td><?php $formHelper->renderTextField('link_1', 50, 135, 255); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
	  <td>Link 2 </td>
	  <td><?php $formHelper->renderTextField('link_2', 50, 140, 255); ?></td>
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
		<td colspan="2">Description [<a href="#" id="description" onClick="hideShow(this.id)">+</a>]</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td colspan="4"><?php $formHelper->renderTextarea('description', $description, 80, 8, 905, array("style"=>"display:none"),'text_description'); ?></td>
		</tr>
	<tr valign="top">
		<td colspan="2">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td colspan="2">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>

<!-- == FORM CONTENT END ================================================================ -->  
</form>
</body>