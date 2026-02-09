<body>
<form action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post" enctype="multipart/form-data" id="something" class="uniForm">
<!-- == FORM CONTENT BEGIN ============================================================== -->
<table width="100%" border="0" cellspacing="0">
	<tr valign="top">
		<td colspan="2"><?php echo isset($conference_name) ? $conference_name : '< Untitled >';  ?></td>
		<td colspan="2" align="right"><?php $formHelper->renderHiddenField('__conference_id', $conference_id); ?>
		  <input type="submit" name="x_submit" id="submit" value="S" />
		  <input type="button" name="x_new" id="x_new" value="N" onMouseUp="document.location = '<?php echo $_SERVER['SCRIPT_NAME']; ?>'" /></td>
	</tr>
	<tr><td colspan="4">&nbsp;</td></tr>	
	<tr valign="top">
		<td>File:</td>
		<td>
			<input name="x_image" id="x_image" size="30" type="file" class="fileUpload" /><?php $formHelper->renderTextField('conference_name', 20, 5); ?>		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Working Name</td>
		<td><?php $formHelper->renderTextField('working_name', 20, 10); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Small Name</td>
		<td><?php $formHelper->renderTextFieldDp('start_date', 15); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Medium Name</td>
		<td><?php $formHelper->renderTextFieldDp('end_date', 20); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>Large Name</td>
		<td><?php $formHelper->renderTextField('city', 15, 25); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>&nbsp;</td>
		<td><?php $formHelper->renderTextField('state', 15, 30); ?></td>
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
<?php
        require '../includes/phpHelper.php';
		require findRelativePath('includes/supernova.config.php');
		
		/* use these to distinguish the sizes */
		$small		= "_s";
		$medium		= "_m";
		$large		= "_l";
		
		if(isset($_POST['submit'])){
          if (isset ($_FILES['new_image'])){
              print_r($_FILES);
			  $imagename = $_POST['prefix'] . "_" . $_FILES['new_image']['name'];
              $source = $_FILES['new_image']['tmp_name'];
              $target = "images/".$imagename;		// TODO: add file relativity and move to a place where the reg form can get at it.
              move_uploaded_file($source, $target);
 
              $imagepath = $imagename;
              $save = "images/" . $imagepath; //This is the new file you saving
              $file = "images/" . $imagepath; //This is the original file
 
              list($width, $height) = getimagesize($file) ; 
 
              $modwidth = 150; 
 
              $diff = $width / $modwidth;
 
              $modheight = $height / $diff; 
              $tn = imagecreatetruecolor($modwidth, $modheight) ; 
              $image = imagecreatefromjpeg($file) ; 
              imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 
 
              imagejpeg($tn, $save, 100) ; 
 
              $save = "images/sml_" . $imagepath; //This is the new file you saving
              $file = "images/" . $imagepath; //This is the original file
 
              list($width, $height) = getimagesize($file) ; 
 
              $modwidth = 80; 
 
              $diff = $width / $modwidth;
 
              $modheight = $height / $diff; 
              $tn = imagecreatetruecolor($modwidth, $modheight) ; 
              $image = imagecreatefromjpeg($file) ; 
              imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 
 
            imagejpeg($tn, $save, 100) ; 
            echo "Large image: <img src='images/".$imagepath."'> (path: images/".$imagepath . ")<br>"; 
            echo "Thumbnail: <img src='images/sml_".$imagepath."'> (path: images/sml_".$imagepath. ")<br>";  
 
          }
        }
?>