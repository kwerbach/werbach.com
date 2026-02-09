<?php
        require '../includes/phpHelper.php';
		require findRelativePath('includes/supernova.config.php');
		
		/* use these to distinguish the sizes */
		$small		= "_s";
		$medium		= "_m";
		$large		= "_l";
		
		$imagePath	= UPLOAD_IMPAGE_PATH;
		
		
		if(isset($_POST['x_submit'])){
          if (isset ($_FILES['x_image'])){
//              print_r($_POST);		// TESTING

			$srcFile	= uploadImage($imagePath);// get the file onto the server
			
			if (!empty($_POST["small_width"]));	
			{
				$output = resizeImageByWidth($srcFile, $_POST["small_width"], $imagePath, $small); // modify the file
				echo "Small image: <img src='".$output."'><br>"; // show us what we did
			}


			if (!empty($_POST["medium_width"]))
			{
				$output = resizeImageByWidth($srcFile, $_POST["medium_width"], $imagePath, $medium); // modify the file
				echo "Medium image: <img src='".$output."'><br>"; // show us what we did
			}


			if (!empty($_POST["large_width"]));	
			{
				$output = resizeImageByWidth($srcFile, $_POST["large_width"], $imagePath, $large); // modify the file
				echo "Large image: <img src='".$output."'><br>"; // show us what we did
			}

          }
        }

/*		if ($tableIdValueStr == '') // Insert
		{
			$tableIdValueStr = $sqlHelper->sqlInsert($fieldArr, $valueArr, $tableNameStr);
			$querySrting = "?$tableIdValue[1]=$tableIdValueStr";
		}
		else // Update
		{
			$sqlHelper->sqlUpdate($fieldArr, $valueArr, $tableNameStr, $whereClauseStr);
		}*/
		// echo $_SERVER['HTTP_REFERER'] . $querySrting;	// TESTING
//		header("Location:  " . $_SERVER['HTTP_REFERER'] . $querySrting);


// FUNCTIONS BELOW //////////////////////////////////////////////////////////////

	
		function uploadImage($imageDir)
		{
		
//              print_r($_FILES);		// TESTING
			  $imagename 	= $_FILES['x_image']['name'];
              $imagepath	= $imageDir;
			  $source 		= $_FILES['x_image']['tmp_name'];
              $target 		= $imagepath.$imagename;		// TODO: add file relativity and move to a place where the reg form can get at it.
              
			  move_uploaded_file($source, $target);
 
              $imagepath = $imagename;

              return $target; //This is the original file		
		
		}
		
		
		function resizeImageByWidth($currentFile, $newWidth, $newPath='', $suffix='', $prefix='')
		{
//			echo '<hr/>currentFile: ' . $currentFile . '<hr/>';		// TESTING
			$filePathArr	= explode("/", $currentFile);
			
//			echo '<hr/>count($filePathArr): ' . count($filePathArr) . '<hr/>';	// TESTING
//			echo '<hr/>filePathArr[count($filePathArr) - 1]: ' . $filePathArr[count($filePathArr) - 1] . '<hr/>'; // TESTING
			$fileNameArr	= explode(".", $filePathArr[count($filePathArr) - 1]);
			$fileBase		= $fileNameArr[0];
			$fileExt		= $fileNameArr[1];
			
			list($width, $height) = getimagesize($currentFile); 
			
			$modwidth 	= $newWidth; 
			$diff 		= $width / $modwidth;
			$modheight 	= $height / $diff;
			
			$tn = imagecreatetruecolor($modwidth, $modheight) ; 
			$image = imagecreatefromjpeg($currentFile); 
			imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 

			$newFile	= $newPath . $prefix. $fileBase . $suffix . "." . $fileExt;
//			echo '<hr/>' . $newFile . '<hr/>';		// TESTING
			
			imagejpeg($tn, $newFile, 100) ; 
			
			return $newFile;
		}
?>