<?php
require '../includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');
$reg_year = "2007";
$formHelper = new formHelper;			// ???: populate this in the constuctor?

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Reg Tester - Get Message</title>
	<link href="../registration.css" rel="stylesheet" type="text/css" />	

<script src="<?php echo findRelativePath('includes/jquery-1.3.2.js'); ?>" type="text/javascript"></script>
<script src="<?php echo findRelativePath('includes/jquery.validate.js'); ?>" type="text/javascript"></script>
<script src="<?php echo  findRelativePath('includes/cmxforms.js' );?>" type="text/javascript"></script>

<script language="javascript">

$(document).ready(function() {


	
	// validate signup form on keyup and submit
	$("#form1").validate({

		rules: {
			reg_year: 
			{
				required: true
			},
			seminar_description: "required"

		},
		messages: {
			reg_year: "Please enter a year (YYYY).",
			seminar_description: "Please type a package."
		}


	}
	);
	
});
</script>
</head>	
<body><br />
<br />
<br />
<br />

<form  class="cmxform" id="form1" method="post" action="">
Name of Package: <input name="seminar_description" id="seminar_description" value="" />
<br />
Conference Year: <input name="reg_year" id="reg_year" value="" />
<input type="submit" name="Submit"  id="Submit" value="submit" />

</form>
<br/><br/>
<?php
if(isset($_POST['Submit']))
{
	$regHelper = new regHelper;
	
	
	
	// ---------------------------------------------------------------------------
	echo "<hr/>";
	echo "<br/><strong>get web message:</strong><br/>";
	//$regHelper->getThankYouMessage($conferenceId, $type=1);
	echo $regHelper->getThankYouMessage(2, 1, 1, $_POST);
	
	echo "<hr/>";
	echo "<br/><strong>get email message (HTML):</strong><br/>";
	echo $regHelper->getThankYouMessage(2, 2, 1, $_POST);
	echo "<br/><strong>get email message (Plain Text):</strong><br/>";
	echo "<textarea cols=\"80\" rows=\"10\">" . $regHelper->getThankYouMessage(2, 2, 2, $_POST) . "</textarea>";
	
	
	// ---------------------------------------------------------------------------
	
	
	echo "<hr/>";
}
else
{
	echo "Please fill out the form";
}	

?>
<!-- our error container -->

</body>
</html>
