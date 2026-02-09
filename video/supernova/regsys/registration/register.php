<?php
require 'includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');

$conference_id = 2;
$formHelper = new formHelper;
$regHelper = new regHelper;
$regHelper->getConferenceVariableValues($conference_id);

// ------------- above is page specific
include "includes/inc_header.php"; 
?>
<!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->
		<h2>Register</h2>

		<form class="cmxform" name="form1" id="form1"  method="post" action="confirm.php">
		<p> <span class="form_label">To register, please select a conference package and then complete and submit the information below.</span><br /><br /></p>
		
			
<?php
$regHelper->getPackages($conference_id);
?>

<label for="conference_package" class="error">Please select your event package</label>
<p> <span class="form_label">
              <!-- ----------------- BEGIN FORM BELOW ------------------------ -->
          The cut-off deadline for Early Bird registration is <?php echo $early_bird_cutoff_display_date; ?>. On-site registration rates are higher than those listed here. <br />
          <br />
          <span class="required">* </span>indicates a required field <br />
          <br />
            </span> </p>
            <table  border="1" cellpadding="5" cellspacing="0" bordercolor="#FFCC99">
              <tr>
                <td><p class="form_label"><strong>Networking Event RSVP: </strong><br />
                        <br />
                You and all conference participants are invited to our kcik-off networking event &mdash; The Wharton West Reception &mdash; on Wednesday, June 20, from 5:30pm to 8:30pm at the Wharton West campus building.
                <input name="showcase" type="checkbox" id="showcase" value="yes" />
                <br />
                <br />
                Yes, I plan on attending the Wharton West kick-off event. </p>
                    <p class="form_label"><strong>Special Meal Request:</strong><br />
                        <br />
                 <input name="meals" type="checkbox" id="meals" value="vegetarian" />
                I require vegetarian meals.<br />
                  </p></td>
              </tr>
            </table>
            <p> </p>
            <p> </p>
            <table  border="0" cellspacing="0">
              <tr>
                <td class="form_label"><img src="../images_reg/spacer.gif" width="10" height="5" /></td>
              </tr>
              <tr>
                <td class="form_label">&nbsp;</td>
              </tr>
              <tr>
                <td class="form_label">If you have a <strong>priority code</strong>, enter it here:
                    <input name="priority_code" id="priority_code" type="text" size="10" maxlength="10" />
                    <input type="hidden" name="conference_id" id="conference_id" value="2" />
					<div id="priority_code_result"></div>	
				</td>
              </tr>
              <tr>
                <td class="form_label"><img src="../images_reg/spacer.gif" width="10" height="15" /></td>
              </tr>
            </table>
            <br />
            <!-- START CONTACT INFO -->
            <table id="contactInfo">
              <tr>
                <td colspan="2" class="form_label"><font size="4" color="#380169"><b>Contact Information</b></font></td>
              </tr>
              <tr>
                <td class="form_label"><img src="../images_reg/spacer.gif" width="110" height="10" /></td>
                <td class="form_label"><img src="../images_reg/spacer.gif" width="375" height="10" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> First</td>
                <td><input name="first" id="first" type="text" size="15" maxlength="25" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">* </span>Last</td>
                <td><input name="last" id="last" type="text" size="15" maxlength="25" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Email</td>
                <td><input type="text" id="email" name="email" size="25" maxlength="100"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Confirm Email</td>
                <td><input type="text" id="confirm_email" name="confirm_email" size="25" maxlength="100"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label">Email Format</td>
                <td class="form_label"><input name="email_format" id="email_format" type="radio" value="HTML" checked="checked" />
              HTML
                <input name="email_format" id="email_format" type="radio" value="Plain Text" />
              Plain Text </td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Title</td>
                <td><input type="text" name="title" id="title" size="25" maxlength="100"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Company</td>
                <td><input type="text" name="company" id="company" size="25" maxlength="100"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Address1</td>
                <td><input type="text" name="address1" id="address1" size="30" maxlength="60"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label">Address2</td>
                <td><input type="text" name="address2" id="address2" size="30" maxlength="60"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> City</td>
                <td><input type="text" name="city" id="city" size="15" maxlength="100"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> State/Province</td>
                <td><input type="text" name="province" id="province" size="2" maxlength="2"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Zip</td>
                <td><input type="text" name="zip" id="zip" size="10" maxlength="10"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label">Country</td>
                <td><input type="text" name="country" id="country" size="20" maxlength="100"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">* </span>Phone</td>
                <td><input type="text" name="phone" id="phone" size="20" maxlength="100"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label">Mobile Phone</td>
                <td><input name="cellphone" id="cellphone" type="text" size="20" maxlength="100"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label">Fax</td>
                <td><input type="text" name="fax" id="fax" size="20" maxlength="100"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label">Website</td>
                <td><input type="text" name="website" id="website" size="30" maxlength="100"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label"> Weblog</td>
                <td class="form_label"><input type="text" name="blog" id="blog" size="30" maxlength="100" /></td>
              </tr>
            </table>
            <!-- END CONTACT INFO  -->
            <br />
            <img src="../images_reg/hrfade.gif" width="48" height="4" alt="" /><br />
            <!-- BEGIN CC TABLE -->
            <table id="ccInfo">
              <tr>
                <td colspan="2" class="form_label"><font size="4" color="#380169"><b>Credit Card Information</b></font></td>
              </tr>
              <tr>
                <td colspan="2" class="form_label"><img src="../images_reg/spacer.gif" width="10" height="5" /></td>
              </tr>
              <tr>
                <td colspan="2" class="form_label">Our secure server uses SSL encryption to safeguard your personal information, including your address and credit card information. </td>
              </tr>
              <tr>
                <td colspan="2" class="form_label"><img src="../images_reg/spacer.gif" width="10" height="5" /></td>
              </tr>
              <tr>
                <td colspan="2" class="form_label"><input name="same_billing" type="checkbox" id="same_billing" value="yes"/>
              My credit card information is the same as my contact information.</td>
              </tr>
              <tr>
                <td class="form_label"><img src="../images_reg/spacer.gif" width="110" height="10" /></td>
                <td class="form_label"><img src="../images_reg/spacer.gif" width="375" height="10" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> First </td>
                <td class="form_label"><input name="billing_first" type="text" id="billing_first" size="15" maxlength="50"/>
              (as it appears on your card) </td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Last </td>
                <td><span class="form_label">
                  <input name="billing_last" type="text" id="billing_last" size="15" maxlength="50"/>
                </span></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Billing Address</td>
                <td><input name="billing_address1" type="text" id="billing_address1" maxlength="60"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Billing City</td>
                <td><input type="text" name="billing_city" id="billing_city" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Billing State</td>
                <td><input type="text" name="billing_province" id="billing_province" size="2" maxlength="2"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Billing Zip</td>
                <td><input type="text" name="billing_zip" id="billing_zip" size="10" maxlength="10"/></td>
              </tr>
              <tr>
                <td align="right" class="form_label">Billing Country</td>
                <td><input type="text" name="billing_country" id="billing_country" size="20" maxlength="100" /></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Card Type </td>
                <td><select name="cc_type" id="cc_type" onblur="set_cookie(this.name, this.selectedIndex, 30);">
                    <option value="" selected="selected">Card Type</option>
                    <option value="Visa">Visa</option>
                    <option value="Master Card">Master Card</option>
                    <option value="American Express">American Express</option>
                    <option value="Discover">Discover</option>
                </select></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Card Number </td>
                <td class="form_label"><input type="text" name="cc_number" id="cc_number" size="16" maxlength="16"  /><!--autocomplete="off"--></td>
              </tr>
              <tr>
                <td align="right" class="form_label"><span class="required">*</span> Expiration Date </td>
                <td class="form_label">
				<input type="text"  name="expire_month" id="expire_month" size="2" maxlength="2" />
				/
				<input type="text" name="expire_year" id="expire_year" size="2" maxlength="2" />
              (mm/yy) </td>
              </tr>
            </table>
            <!-- END CC TABLE -->
            <br />
            <img src="../images_reg/hrfade.gif" width="48" height="4" alt="" /><br />
            <!-- PAYMENT OPTIONS BEGIN -->
            <table>
              <tr>
                <td colspan="2" class="form_label"><font size="4" color="#380169"><b>Payment Options</b></font></td>
              </tr>
              <tr>
                <td colspan="2" class="form_label"><img src="../images_reg/spacer.gif" width="10" height="5" /></td>
              </tr>
              <tr>
                <td colspan="2" class="form_label"> In addition to Credit Cards, registrations are accepted via Bank Wire Transfer and Company Check drawn on US Funds. Checks should be made payable to: Supernova Group LLC. <br />
                    <br />
              If you have any questions about these alternative payment options, please e-mail: <a href="mailto:info@supernovagroup.net">info@supernovagroup.net</a>. <br />
              <br />
				
				<span class="required">*</span>Please choose a payment method:
				<span id="not_paying">
					<input name="payment_method" id="payment_method" type="radio" value="n/a" onclick="set_cookie(this.name, this.value, 30);" />n/a
				</span>
				<span id="paying" style="visibility:visible;">
					<input name="payment_method" id="cc" type="radio" value="credit card" onclick="set_cookie(this.name, this.value, 30);" checked="checked" />credit card
					<input name="payment_method" id="payment_method" type="radio" value="bank wire transfer" onclick="set_cookie(this.name, this.value, 30);" />bank wire transfer 
					<input name="payment_method" id="payment_method" type="radio" value="check" onclick="set_cookie(this.name, this.value, 30);" />check 
				</span>
				<br />
				<label for="payment_method" class="error">Please select your payment method</label>

				</td>
              </tr>
            </table>
            <!-- END PAYMENT OPTIONS -->
            <p align="center">
              <input type="submit" name="submit" value="Submit Registration" class="button" />
            </p>
            <table>
              <tr>
                <td class="form_label"> <br />
                    <img src="../images_reg/hrfade.gif" width="48" height="4" alt="" /><br />
                    <br />
                    <p><strong>You may also submit registration information by fax</strong>. Please print out the registration form, complete it and fax it to: <strong>(877) 241-1465</strong>. <br />
                        <br />
                        <strong>Hotel registration:</strong> online registration for discounted rooms at The Westin St. Francis are available via the <a href="http://www.werbach.com/supernova2006new/go/venue">Venue</a> page.</p>
                    <p><strong>Press/analyst registration:</strong> If you are interested in Supernova press/analyst passes, please <a href="mailto:info@supernovagroup.net">email us</a> with full details on your affiliation. We evaluate each application individually. <br />
                        <strong><br />
                Cancellation Policy:</strong> Written cancellations received before <?php echo $cancellation_policy_date; ?> will be accepted subject to a service charge of $250. Subsequent cancellations are liable for the full-conference registration fee. Substitutions can be done at anytime prior to the conference. Please send email to <a href="mailto:info@supernovagroup.net">info@supernovagroup.net</a> if you would like to make a substitution. <br />
                <br />
                <strong>Our mailing address:</strong><br />
                Supernova Group LLC<br />
                825 Stoke Road<br />
                Villanova, PA 19085<br />
                USA </p></td>
              </tr>
            </table>
          </form>
          <!-- ----------------- END MAIN CONTENT ABOVE ------------------------ -->

</td></tr></table>
<?php include "includes/inc_footer.php"; ?>