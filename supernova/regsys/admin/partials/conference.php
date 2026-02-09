<?php
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

/**
* Page variables
*/
$keyField	= 'conference_id';
$table		= 'reg__conference';
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
								conference_name: "required",
								working_name: "required",
								tag: "required"
							},
							errorContainer: $("#errorContainer"),
							errorLabelContainer: $("ul"," #errorContainer"),
							wrapper: 'li',
	
						}
						);
						

				}
				);
				
				function hideShow(obj)
				{
					src_elem = ("#" + obj)
					var target_elem = "#text_" + obj;
				     $(target_elem).toggle("medium", function()
					 	{
							if( $(src_elem).text() == "+" )
							{
								$(src_elem).text("-")
							}
							else
							{
								$(src_elem).text("+")
							}
						 }

					 
					 );
					 
				}
</script>
</head>
<body>
<form id="mainForm" name="mainForm" class="cmxform"  method="post" action="<?php echo findRelativePath('handlers/update.php'); ?>">
<!-- == FORM CONTENT BEGIN ============================================================== -->
<table width="100%" border="0" cellspacing="0">
	<tr valign="top">
		<td colspan="2"><span id="formHeader"><?php echo isset($working_name) ? $working_name . " ($conference_id)" : '< Untitled >';  ?></span></td>
		<td colspan="2" align="right"><?php $formHelper->renderHiddenField('__conference_id', $conference_id); ?>
		  <input type="submit" name="x_submit" id="submit" value="S" />
		  <input type="button" name="x_new" id="x_new" value="N" onMouseUp="document.location = '<?php echo $_SERVER['SCRIPT_NAME']; ?>'" /></td>
	</tr>
	<tr><td colspan="4">
<!-- == ERROR CONTAINER BEGIN ============================================================== -->
	<div id="errorContainer">
	<h4>There were errors in your form submission, please see below for details.</h4>
	<ul>
		<li><label for="conference_name" class="error">Conference name is required</label></li>
		<li><label for="working_name" class="error">Working name is required</label></li>
		<li><label for="tag" class="error">A default tag name is required (e.g. "2008 Attendee")</label></li>
	</ul>
	</div>
<!-- == ERROR CONTAINER END ================================================================ -->	
	</td></tr>	
	<tr valign="top">
		<td>Name</td>
		<td>
			<?php $formHelper->renderTextField('conference_name', 20, 105, array("title"=>"The name to be dispayed on the website.")); ?>
			<span class="required">*</span></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Working Name</td>
		<td><?php $formHelper->renderTextField('working_name', 20, 110); ?>
			<span class="required">*</span></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Start Date</td>
		<td><?php $formHelper->renderTextFieldDp('start_date', 115); ?></td>
		<td>Early Bird Date (Shown)</td>
		<td><?php $formHelper->renderTextFieldDp('early_bird_cutoff_display_date', 200); ?></td>
	</tr>
	<tr valign="top">
		<td>End Date</td>
		<td><?php $formHelper->renderTextFieldDp('end_date', 120); ?></td>
		<td>Early Bird Date (Actual)</td>
		<td><?php $formHelper->renderTextFieldDp('early_bird_cutoff_actual_date', 205, array("title"=>"This is the real date that the early bird rate stops")); ?></td>
	</tr>
	<tr valign="top">
		<td>City</td>
		<td><?php $formHelper->renderTextField('city', 15, 125); ?></td>
		<td>Cancellation Policy Date</td>
		<td><?php $formHelper->renderTextFieldDp('cancellation_policy_date', 210); ?></td>
	</tr>
	<tr valign="top">
		<td>State</td>
		<td><?php $formHelper->renderTextField('state', 15, 130); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Conference Tag</td>
		<td><?php $formHelper->renderTextField('tag', 15, 135); ?>
			<span class="required">*</span></td>
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
		<td>Thank You Page Text <!--[<a href="#" id="ty_page_body" onClick="hideShow(this.id)">-</a>]--></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td colspan="4"><?php $formHelper->renderTextarea('text_ty_page_body', $text_ty_page_body, 80, 8, 905); ?></td>
		</tr>
	<tr valign="top">
		<td colspan="2">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td colspan="2">Thank You Email Text <!--[<a href="#" id="email_body" onClick="hideShow(this.id)">-</a>]--></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td colspan="4"><?php $formHelper->renderTextarea('text_email_body', $text_email_body, 80, 8, 910); ?></td>
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