<?php
require 'includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

$suffix = date("y");
// ------------- above is page specific
include "includes/inc_header.php"; 
?>
<!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->
<h2>Sign Up for More Information</h2>
<!-- ----------------- BEGIN FORM BELOW ------------------------ -->
<!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->

<!-- BEGIN FORM  -->
<form class="cmxform" name="form1" id="form1"  method="post" action="<?php findRelativePath('ajax/handle.php'); ?>">
	<br />
	
	<table width="475" border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td colspan="2" class="head"><h3>Supernova email lists</h3></td>
		</tr>
		<tr>
			<td style="border:none;">
<!-- BEGIN FORM CONTENT -->	
			<div id="signUpContainer">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="30%" align="right" class="form_label"><span class="required">*</span> First</td>
						<td width="70%"><input name="first" id="first" type="text" size="15" maxlength="25" /></td>
					</tr>
					<tr>
						<td width="30%" align="right" class="form_label"><span class="required">* </span>Last</td>
						<td width="70%"><input name="last" id="last" type="text" size="15" maxlength="25" /></td>
					</tr>
					<tr>
						<td width="30%" align="right" class="form_label"><span class="required">*</span> Email</td>
						<td width="70%"><input type="text" id="email" name="email" size="25" maxlength="100"/></td>
					</tr>
					<tr>
						<td width="30%" align="right" class="form_label"><span class="required">*</span> Confirm Email</td>
						<td width="70%"><input type="text" id="x_confirm_email" name="x_confirm_email" size="25" maxlength="100"/></td>
					</tr>
					<tr>
						<td width="30%" 
align="right" class="form_label"><span class="required">* 
</span>Company</td>
						<td width="70%"><input type="text" name="company" id="company" size="25" maxlength="100"/></td>
					</tr>
					<tr valign="top">
						<td width="30%" align="right" class="form_label"> Subscribe to  lists:<br />
							<br />
							<br />
							<br />
							<br />
							<br />
							<br />
							<br />
							<br />
							</td>
						<td width="70%" class="form_label"><table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr valign="top">
									<td valign="top" style="border:none;"><input name="general_info" type="checkbox" id="info_req_type" value="ConfInfo<?php echo $suffix ?>" checked="checked"  validate="required:true, minlength:2" /></td>
									<td valign="top" style="border:none;"><strong>General Info:</strong> periodic Conference and other event details and updates</td>
								</tr>
								<tr>
									<td valign="top" style="border:none;"><input name="hub_info" type="checkbox" id="info_req_type" value="HubInfo<?php echo $suffix ?>" checked="checked" /></td>
									<td valign="top" style="border:none;"><strong>Supernova Hub Info:</strong> schedule/topics for weekly NetworkAge Briefing
										teleconferences and other 'Hub' highlights</td>
								</tr>
								<tr>
									<td valign="top" style="border:none;"><input name="sponsor_info" id="info_req_type" type="checkbox" value="SponsorInfo<?php echo $suffix ?>" /></td>
									<td valign="top" style="border:none;"><strong>Sponsor Info:</strong> regular updates on sponsorship programs and opportunities</td>
								</tr>
							</table>
							</td>
					</tr>
					<tr>
						<td colspan="2" style="border:none;">
							<label for="first" class="error">&#8226; First name is required.<br/></label>
							<label for="last" class="error">&#8226; Last name is required.<br/></label>							
							<label for="email" class="error">&#8226; You must supply a valid email address.<br/></label>
							<label for="x_confirm_email" class="error">&#8226; Email confirmation is required.<br/></label>
							<label for="x_confirm_email" class="error">&#8226; The confirmation email and email must match.<br/></label>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" class="form_label">
							<div id="msgContainer">
							<input type="submit" name="submit" id="submitSignup" value="Submit" class="button" />
							</div>
						</td>
					</tr>
				</table>
		</div>
<!-- END FORM CONTENT -->		
		</td>
		
		</tr>
		
	</table>
</form>
</td>
</tr>
</table>
<!-- END FORM -->	
<?php include "includes/inc_footer.php"; ?>
