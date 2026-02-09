<?php 
require "../registration/inc_db.php"; 
require "../registration/inc_forms.php"; 
dbconnect();
$people_table 		= "people_testing";			// PEOPLE OR PEOPLE_TESTING
$not_people_fields 	= array("submit",
							"email_list",
							"is_new",
							"id"); 				// THESE FIELDS ARE **NOT** IN THE PEOPLE TABLE SO DON'T USE THEM
							
if(isset($_POST["submit"]))						// THEM FORM HAS BEEN POSTED
{
	$where_clause 	= " WHERE email = '" . $_POST['email'] . "'";
	$query 			= "SELECT ID, email, company, address1, address2, cellphone FROM " . $people_table . $where_clause . " LIMIT 0 , 1";
	$result 		= safe_query($query);		// QUERY THAT CHECKS FOR EXISTING RECORDS

	if ($result)								// QUERY WAS SUCCESSFUL
	{
		$n_rows = mysql_num_rows($result);		// HOW MANY ROWS?
		if ($n_rows == 1)						// THERE IS ONE RECORD IN THE DB, COMPARE SOME FIELDS AND EMAIL IF THERE IS A CHANGE
		{
			$row 		= mysql_fetch_array($result, MYSQL_ASSOC);
			$ID 		= $row["ID"];			// GET PEOPLE ID FROM PEOPLE
			$company 	= $row["company"];
			$address1 	= $row["address1"];
			$address2 	= $row["address2"];
			$cellphone 	= $row["cellphone"];
			$body 		= compare_fields($company, $address1, $address2, $cellphone);
			if(strlen($body) > 1)				// IF THERE IS A BODY VALUE THEN VALUES HAVE BEEN UPDATED
			{
				send_email($body);				// SEND EMAIL TO KEVIN IF FIELDS HAVE CHANGED
			}
		}
		else									// THERE IS NOT A MATCHING RECORD IN THE DB -> DO INSERT
		{
			$ID = insert_people();				// PUT THEM IN THE PEOPLE TABLE
		}


		if (isset($_POST["email_list"]))
		{
			foreach($_POST["email_list"] as $e) 	// TAG THEM
			{
				add_to_list($ID, $e);
			}
		}
		
		unset($_POST["submit"]);				// TO PREVENT DOUBLE SUBMISSIONS
	}
}	

?>

<html>

<head>

<title>Supernova 2006</title>
<style type="text/css">
a:link { color:blue; text-decoration: none }
a:visited { color:blue; text-decoration: none }
a:hover { text-decoration: underline }
.style3 {font-family: verdana,arial,sans-serif; font-size: 12px; }
</style>

</head>

<!-- <body bgcolor="#380169" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0"> -->
<body bgcolor="#ffffff" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">


<center>

<table border="0" cellpadding="0" cellspacing="0">

<tr>
<td width="42" background="../images/background_left.gif"></td>
<td width="780" bgcolor="#FFFFFF">

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="304" height="155" valign="top"><a href="http://www.supernova2005.com"><img src="http://werbach.com/supernova2005/images/logo.gif" width="304" height="155" alt="Home" border="0"></a></td>
	<td width="476"><img src="http://werbach.com/supernova2005/images/tagline.gif" width="476" height="155"></td>
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="108"><img src="http://werbach.com/supernova2005/images/topcorner.gif" width="108" height="45" alt=""></td>
	<td width="8"></td>
	<td width="1" bgcolor="#FFA813"></td>
	<td width="663">
	
		<table border="0" cellpadding="0" cellspacing="0">
		
		<tr>
		<td width="17" height="24" bgcolor="#FFA813" valign="top"></td>
		<td width="646" height="24" bgcolor="#FFA813" valign="middle">
		<font face="verdana,arial" size="2" color="#FFFFFF">
		
		<a href="../about.htm" style="color:FFFFFF"><b>About Supernova</b></a> | 
		<a href="../community_connection.htm" style="color:FFFFFF"><b>Community Connection</b></a> | 
		<a href="https://www.supernova2005.com/registration/register.php" style="color:FFFFFF"><b>Register</b></a> | <a href="../contact.htm" style="color:FFFFFF"><b>Contact Us</b></a>
		
		</font></td>
		</tr>
		
		<tr>
		<td height="21" colspan="2"></td>
		</tr>
		
		</table>
	
	</td>
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="111" align="right" valign="top">
	<font face="verdana,arial" size="1">
	
	<a href="../program_overview.htm" style="color:7E7E7E" title="Agenda At-A-Glance">Program Overview</a>
	<br>
	<br>
	<a href="../buzz.htm" style="color:7E7E7E">Press Buzz
	</a><br><br>
	<a href="../venue.htm" style="color:7E7E7E" title="Information on the Palace Hotel and maps to Wharton West">Venue</a>	<br>
	<br>
	
	<a href="http://feeds.feedburner.com/supernova2005"><img src="../images/xml.gif" alt="XML" width="36" height="14" border="0"></a><br><br><br><br><br><br>
	<img src="http://werbach.com/supernova2005/images/palacehotel06.jpg" width="111" height="189" alt="Palace Hotel">
	<br><br><br>
	<a href="http://www.wharton.upenn.edu/campus/wharton_west"><img src="http://werbach.com/supernova2005/images/whartonwest06.jpg" width"111" height"215" alt="Wharton West" border="0"></a>
	</font></td>
	<td width="5"></td>
	<td width="1" valign="top"><img src="http://werbach.com/supernova2005/images/yellowline.gif" width="1" height="195" alt=""></td>
	<td width="17"></td>
	<td valign="top">
	  <p><font face="verdana,arial" size="2">
  

      <!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->
  
	<img src="http://werbach.com/supernova2005/images/quote.gif" width="412" height="115" alt="Rotating Quotes">
	  <br>
	  <br>
<!-- COPY BEGIN -->
	  <br>
Please select the Supernova mailing list(s) you would like to join. </font>	    </p>
	  <form name="form1" method="post" action="">
	    <table width="60%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="20">&nbsp;</td>
            <td><input name="email_list[]" type="checkbox" id="email_list" value="Supernova Report">              
              <font face="verdana,arial" size="2">Supernova Report<br>
              </font></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td><input name="email_list[]" type="checkbox" id="email_list" value="Conference Update">
              <font face="verdana,arial" size="2">Conference Update</font></td>
            <td>&nbsp;</td>
          </tr>
        </table>
	    <p><font face="verdana,arial" size="2"><span class="style3">Please provide your information here. Items marked with an '*' require a response for signup. </span></font><br>
 <!-- BEGIN: Subscriber Information -->
                <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td colspan="2" width="100%">
                        <p><font face="verdana,arial" size="2"><span class="style3">Update Your Information<br>
                              <br>
Please provide your information here. Items marked with an '*' require a response for signup.</span></font><br>
                        <br>
                        </p></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">First Name*:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle"><?php text_field ("first", $first, $size=15, "100", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">Last Name*:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle"><?php text_field ("last", $last, $size=15, "50", "") ?></td>
                </tr>
                
                <tr>
                  <td nowrap align="right"><span class="style3">Email*: &nbsp;</span></td>
                  <td valign="middle"><?php text_field ("email", $email, 25, "100", "") ?></td>
                </tr>
                <tr>
                    <td nowrap align="right"><span class="style3">Company Name*:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle"><?php text_field ("company", $company, 25, "50", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">Job Title*:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle"><?php text_field ("title", $title, $size=25, "50", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">Cell Phone :&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle">
                    <?php text_field ("cellphone", $cellphone, "15", "15", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">Address Line 1:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle">                    <?php text_field ("address1", $address1, "30", "50", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">Address Line 2:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle">
                    <?php text_field ("address2", $address2, "30", "50", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">City:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle">                    <?php text_field ("city", $city, "25", "25", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3"><font class="mainfont">State/Province (US/Canada):&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle"><select name="province">
<option value="<?php echo $province; ?>"><?php echo $province; ?></option>
<option  value="AL">Alabama</option>
<option  value="AK">Alaska</option>
<option  value="AB">Alberta</option>
<option  value="AZ">Arizona</option>
<option  value="AR">Arkansas</option>
<option  value="BC">British Columbia</option>
<option  value="CA">California</option>
<option  value="CO">Colorado</option>
<option  value="CT">Connecticut</option>
<option  value="DE">Delaware</option>
<option  value="DC">District of Columbia</option>
<option  value="FL">Florida</option>
<option  value="GA">Georgia</option>
<option  value="HI">Hawaii</option>
<option  value="ID">Idaho</option>
<option  value="IL">Illinois</option>
<option  value="IN">Indiana</option>
<option  value="IA">Iowa</option>
<option  value="KS">Kansas</option>
<option  value="KY">Kentucky</option>
<option  value="LA">Louisiana</option>
<option  value="ME">Maine</option>
<option  value="MB">Manitoba</option>
<option  value="MD">Maryland</option>
<option  value="MA">Massachusetts</option>
<option  value="MI">Michigan</option>
<option  value="MN">Minnesota</option>
<option  value="MS">Mississippi</option>
<option  value="MO">Missouri</option>
<option  value="MT">Montana</option>
<option  value="NE">Nebraska</option>
<option  value="NV">Nevada</option>
<option  value="NB">New Brunswick</option>
<option  value="NH">New Hampshire</option>
<option  value="NJ">New Jersey</option>
<option  value="NM">New Mexico</option>
<option  value="NY">New York</option>
<option  value="NF">Newfoundland</option>
<option  value="NC">North Carolina</option>
<option  value="ND">North Dakota</option>
<option  value="NT">Northwest Territories</option>
<option  value="NS">Nova Scotia</option>
<option  value="OH">Ohio</option>
<option  value="OK">Oklahoma</option>
<option  value="ON">Ontario</option>
<option  value="OR">Oregon</option>
<option  value="PA">Pennsylvania</option>
<option  value="PE">Prince Edward Island</option>
<option  value="QC">Quebec</option>
<option  value="RI">Rhode Island</option>
<option  value="SK">Saskatchewan</option>
<option  value="SC">South Carolina</option>
<option  value="SD">South Dakota</option>
<option  value="TN">Tennessee</option>
<option  value="TX">Texas</option>
<option  value="UT">Utah</option>
<option  value="VT">Vermont</option>
<option  value="VA">Virginia</option>
<option  value="WA">Washington</option>
<option  value="WV">West Virginia</option>
<option  value="WI">Wisconsin</option>
<option  value="WY">Wyoming</option>
<option  value="YT">Yukon Territory</option>
</select></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">Zip/Postal Code:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle">                    <?php text_field ("zip", $zip , "10", "10", "") ?></td>
                </tr>
                
                <tr>
                    <td nowrap align="right"><span class="style3">How did you find out about us?*:&nbsp;&nbsp;</span></td>
                    <td width="100%" valign="middle">                    <?php text_field ("source", $source, $size=25, "50", "") ?></td>
                </tr>
                <tr align="center">
                  <td colspan="2" nowrap>                    <input name="submit" type="submit" id="submit" value="Submit"></td>
                  </tr>
                </table>
<!-- END: Subscriber Information -->
	  </form>
	  <p><font face="verdana,arial" size="2"><br>
	    	    </font></p>	  
	  <p><font face="verdana,arial" size="2">      </font></p>
	  <font face="verdana,arial" size="2"><p></p>
        </font>
<!-- CONTENT END -->		</td>
	
	<td width="5"></td>
	<td width="85" align="right" valign="top">
	<font face="verdana,arial" size="1">
	<img src="http://werbach.com/supernova2005/images/spacer.gif" width="1" height="50" alt=""><br>


<!-- ----------------- MIDDLE RIGHT COLUMN CONTENT ------------------------ -->

	
	<img src="http://werbach.com/supernova2005/images/kevin_thumb.jpg" width="40" height="44" alt="Kevin Werbach"><br>	
	Supernova is<br>
	produced by<br>
	<a href="http://www.werbach.com/about.html">Kevin Werbach</a><br>
	(Assistant<br>
	Professor at<br>
	The Wharton<br>
	School). Stay<br>
	up-to-date<br>
	with the<br>
	<a href="http://www.werbach.com/blog" "text-decoration:underline">Werblog</a>.<br>
	<br><br>
	
	<img src="http://werbach.com/supernova2005/images/report_icon.gif" width="26" height="38" alt="Supernova Report"><br>
	<b>Supernova<br>
	Report</b><br>
	<a href="../signup.htm">Sign up</a> for<br>
	the free<br>
	 email newsletter<br>
	updating the<br>
	path to the<br>
	decentralized<br>
	future!
	
	</font></td>
	<td width="8"></td>
	<td width="1" bgcolor="#FFA813" valign="top"><img src="http://werbach.com/supernova2005/images/spacer.gif" width="1" height="50" alt=""></td>
	<td width="10" valign="bottom" align="right"><img src="http://werbach.com/supernova2005/images/shadepiece.gif" width="10" height="10" alt=""></td>
	<td width="125" height="100%" valign="top">
		
		<table border="0" cellpadding="0" cellspacing="0" height="100%">
		
		<tr>
		<td width="125" valign="top" height="100%">
		<div align="center">
		  <p><img src="http://werbach.com/supernova2005/images/spacer.gif" width="1" height="50" alt=""><br>		
		      <font face="verdana,arial" size="1" color="#FFA813">
    
            <!-- ----------------- SPONSOR AREA ------------------------ -->
		      <b>		      </b></font><font face="verdana,arial" size="1" color="#FFA813"><b>PRODUCED IN PARTNERSHIP WITH
		              <br>
		              <a href="http://www.wharton.upenn.edu"><img src="http://werbach.com/supernova2005/images/logo_wharton.gif" alt="The Wharton School" width="119" height="48" vspace="3" border="0"></a>
		              <br>
		              <br>
		              <br>
		        </b></font><font face="verdana,arial" size="1" color="#FFA813"><b>MEDIA SPONSORS</b></font><br>
            <a href="http://www.news.com"><img src="../images/cnet.gif" alt="CNET" width="119" height="30" vspace="7" border="0"></a><br>
            <a href="http://www.redherring.com"><img alt="Red Herring" src="../images/redherring.gif" width="120" height="50" vspace="3" border="0"></a><font face="verdana,arial" size="2"><br>
            <br>
            <a href="http://knowledge.wharton.upenn.edu"><img src="../images/kaw_logo.gif" alt="Knowledge @ Wharton" width="119" height="40" border="0"></a><br>
            <br>
            <a href="http://www.guidewiregroup.com"><img src="../images/guidewiregroup.gif" alt="Guidewire Group" width="119" height="22" border="0"></a>
            <br>
            <br>
            </font><font size="1" face="verdana,arial"><br>
            A complete list of Supernova 2005 sponsors is available on our <a href="../sponsors.htm">sponsors</a> page. <br>
            </font><font face="verdana,arial" size="2"><br>
            <br>
              <font size="1" color="#FFA813">
              <b>SPONSORSHIP OPPORTUNITIES </b></font>
            </font></p>
		  <font size="1" face="verdana,arial">If you are interested in finding out more about Supernova 2006 sponsorships, please review our <a href="../downloads/prospectus.pdf">sponsor prospectus</a>, and <a href="mailto:sponsor@supernovagroup.net">email us</a>. <br>
          <br>
		    <br>
	      </font></div></td>
		</tr>
		
		<tr>
		<td width="125" height="100%" valign="bottom"><img src="http://werbach.com/supernova2005/images/bottomcorner.gif" alt="" width="125" height="56" align="bottom"></td>
		</tr>
		
		</table>
		
	    
	</tr>
	
	</table>
	
	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="645" height="1" bgcolor="#FFA813"></td>
	<td><img src="http://werbach.com/supernova2005/images/bottomcornerslice.gif" width="135" height="1" alt=""></td>
	</tr>
	
	</table>

	<table border="0" cellpadding="0" cellspacing="0">
	
	<tr>
	<td width="134"></td>
	<td width="373"><font face="verdana,arial" size="1" color="#7E7E7E">
	©2005 Supernova Group LLC
	</font></td>
	<td width="273"><img src="http://werbach.com/supernova2005/images/bottommiddle.gif" width="273" height="31" alt=""></td>
	</tr>
	
	<tr>
	<td colspan="3"><img src="http://werbach.com/supernova2005/images/bottom.gif" width="780" height="52" alt=""></td>
	</tr>
	
	</table>

</td>
<td width="42" background="../images/background_right.gif"></td>
</tr>

</table>
</center>

</html>

<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////
// FUNTIONS BELOW /////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

function insert_people()
{
//	global $ID;  						// PEOPLE ID	//TETSING
	global $people_table;
	global $not_people_fields;	
	$insert_people_fields = "";			// FIELDS TO INSERT
	$insert_people_values = "";			// VALUES FOR THOSE FIELDS

	
	foreach($_POST as $key => $value)  	// FOR EACH KEY IN THE POST ARRAY SHOW ME THE VALUE
	{
		if($value != "" && in_array($key, $not_people_fields) == FALSE) // THERE IS A VALUE AND THE KEY NOT ON THE BAD LIST
		{
			$insert_people_fields = $insert_people_fields . $key . ", ";
			$insert_people_values = (get_magic_quotes_gpc()) ? $insert_people_values . "'" . $value . "', " : $insert_people_values . "'" . addslashes($value) . "', ";
		}
	}
	
	$insert_people_fields .= "user_id, ";
	$insert_people_fields .= "created_on, ";
	$insert_people_fields .= "last_modified";
		
	$insert_people_values .= "'" . strtoupper(substr(remove_char($_POST["last"] . $_POST["first"] . $_POST["email"]) , 0, 3)) . rand(1111,9999) . "', ";
	$insert_people_values .= "'" . date("Y-m-d H:i:s") . "', ";
	$insert_people_values .= "'" . date("Y-m-d H:i:s") . "'";
	
	$sql_people = "INSERT INTO " . $people_table . " (" . $insert_people_fields . ") VALUES (" . $insert_people_values . ")"; // INSERT SQL SN2005 //TESTING
	$result = safe_query($sql_people);
	return(mysql_insert_id());
}

function compare_fields($c, $a1, $a2, $cp)
{
	global $not_people_fields;
	
	if($c <> $_POST["company"])	// COMPANY CHANGED
	{
		$body .= "Company has changed from \"$c\" to \"" . $_POST["company"] . "\"\r\n<br/><br/>";
		$changed = 1;
	}
	
	if($a1 <> $_POST["address1"])	// ADDRERSS1 CHANGED
	{
		$body .= "Address1 has changed from \"$a1\" to \"" . $_POST["address1"] . "\"\r\n<br/><br/>";
		$changed = 1;
	}
	
	if($a2 <> $_POST["address2"])	// ADDRERSS2 CHANGED
	{
		$body .= "Address2 has changed from \"$a2\" to \"" . $_POST["address2"] . "\"\r\n<br/><br/>";
		$changed = 1;
	}
	
	if($cp <> $_POST["cellphone"])	// PHONE CHANGED
	{
		$body .= "Cell Phone has changed from \"$cellphone\" to \"" . $_POST["cellphone"] . "\"\r\n<br/><br/>";
		$changed = 1;
	}		
	
	if($changed == 1)		// THERE HAS BEEN A CHANGE
	{
		$body .=  "This data may have changed as well...<br/><br/>";
		foreach($_POST as $key => $value)		// FOR EVERY FORM VALUE
		{
			if(in_array($key, $not_people_fields) == 0)	$body .= "$key: $value \n<br/>";  // IF IT IS A PEOPLE FIELD SHOW US
		}
		$body = "This message is from the opt-in page. There has been a change for " . $_POST["first"] . " " . $_POST["last"] . ".\r\n<br/><br/>" . $body;
		return $body;
	}
}

function add_to_list($id, $list)
{
   		$query = "INSERT  INTO people_tags( people_id, user_id, tag, is_email_tag, Time_Added ) 
					SELECT ID,  user_id, '" . $list . "', 1, NOW() 
					FROM people
						WHERE ID
						IN ($id) ";
		safe_query($query);
}

function send_email($body)
{
	$to 		= "ddinatale@w3on.com";	//"kevin@werbach.com";						// TO
	$subject	= "Info Change From Opt-in List";									// SUBJECT
	$headers 	.= 'From: Supernova Group <info@supernovagroup.net>' . "\r\n";		// FROM
//	$headers 	.= 'Bcc: ddinatale@w3on.com' . "\r\n";								// BCC
	$headers 	.= "Content-type: text/html; charset=iso-8859-1" . "\r\n";			// MAKE HTML


	mail($to,$subject,$body,$headers);  											// SEND IT
}


function remove_char($str)
{
	$str = str_replace("'", "", $str);
	$str = str_replace(" ", "", $str);
	return $str;
}

function show_what_i_did()
{
	// QUERY FOR DISPLAYING RESULTS
	/*
	$where_clause 	= " WHERE email = '" . $_POST['email'] . "'";		//$_POST['email']
	$query 			= "SELECT * FROM " . $people_table . " " . $where_clause . " LIMIT 0 , 1";
	echo $query . "<hr/><hr/>";
	$result 		= safe_query($query);

	if ($result)							// QUERY WAS SUCCESSFUL
	{
		$n_rows = mysql_num_rows($result);	// HOW MANY ROWS?
			while ($row = mysql_fetch_array($result)) 
			{

				for ($i=0; $i < mysql_num_fields($result); $i++) 	// GET VARIALBES FROM DB
				{ 
					${mysql_field_name($result, $i)} = $row[mysql_field_name($result, $i)]; 
				}
				
			}
		
	}
	*/


}
?>