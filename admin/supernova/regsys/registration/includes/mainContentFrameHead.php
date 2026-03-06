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
<script language="javascript">
// This script is common to all forms
	$(this).ready(function(){
		/**
		* focus forms on the first editable form element when the page loads
		*/
		var obj = $("#mainForm input:first[type!=hidden][type!=submit][type!=button][type!=image]")
		obj.focus()
	}
	);


</script>
<!-- HEAD ENDS ON MAIN PART OF PAGE -->