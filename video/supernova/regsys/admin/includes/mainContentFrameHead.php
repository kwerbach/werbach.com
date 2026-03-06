<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Supernova Form Header</title>
<link href="<?php echo findRelativePath('admin/adminStyle.css'); ?>" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo findRelativePath('includes/jquery-1.3.2.js'); ?>" type="text/javascript"></script>
<script language="javascript" src="<?php echo findRelativePath('includes/ui.core.js'); ?>" type="text/javascript"></script>
<script language="javascript" src="<?php echo findRelativePath('includes/ui.datepicker.js'); ?>" type="text/javascript"></script>
<script language="javascript" src="<?php echo findRelativePath('includes/jquery.validate.js'); ?>" type="text/javascript"></script>
<script language="javascript" src="<?php echo findRelativePath('includes/cmxforms.js'); ?>" type="text/javascript"></script>
<script language="javascript" src="<?php echo findRelativePath('includes/common.js'); ?>" type="text/javascript"></script>
<script language="javascript">
// This script is common to all forms
	$(this).ready(function(){
		/** THESE THINGS HAPPEN FOR ALL FORMS */
		
		/**
		* focus forms on the first editable form element when the page loads
		*/
		var obj = $("#mainForm input:first[type!=hidden][type!=submit][type!=button][type!=image]")
		obj.focus()
		
		$("#mainForm input").change(function()
		{
			$("#btnSave").attr("src", "<?php echo findRelativePath('images/icon_save_yes.gif'); ?>");
		}
		).focus(function()
		{
			$(this).css("border-color", "#990099");
		}
		).blur(function()
		{
			$(this).css("border-color", "#FF6600");
		}
		);
		
		$("#btnSave").click( function () {
			$("#mainForm").submit();
		}
		).hover(function()
		{
			$(this).css("cursor","pointer");
		}
		);
		
		$("#btnNew").click( function () { 
			if ($("#btnSave").attr("src").indexOf('icon_save_yes.gif') != -1 )
			{
				if(confirm("Do you want to save your changes? \n\nClick OK to go back and SAVE\nClick CANCEL to close WITHOUT saving."))
				{
					alert("To Save:\n   1) click OK\n   2) click SAVE button");  // HOW TO SAVE
				}
				else
				{
					document.location = '<?php echo $_SERVER['SCRIPT_NAME']; ?>';
				}
			} 
			else
			{
				document.location = '<?php echo $_SERVER['SCRIPT_NAME']; ?>';
			}
		}
		).hover(function()
		{
			$(this).css("cursor","pointer");
		}
		);

	}
	);


</script>
<!-- HEAD ENDS ON MAIN PART OF PAGE -->