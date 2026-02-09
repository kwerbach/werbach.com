<?php 
function __autoload($class_name) {
    require_once findRelativePath("classes/$class_name.php");
}

function findRelativePath($filename, $args = null) {
	$__file_relativity = '';
	while (realpath($__file_relativity.$filename) === FALSE && strlen($__file_relativity) < 60 ) 
		{ $__file_relativity = "../".$__file_relativity; }
	if (is_file($__file_relativity.$filename)) {
		return $__file_relativity.$filename;
	}
	else
	{
		die (ERR_901 . " (File: $filename)");	
	}	
}

/**
* If there is a key field set then load up the form
*/
function getKey($table,$keyField,$formHelper)
{
	if(isset($_GET[$keyField]))		
	{
		$$keyField = $_GET[$keyField];
		$formHelper->populateForm($table, $keyField);
	}
	else
	{
		$$keyField = '';
	};
	return $$keyField;
}


/** renderPartial loads in an included file
* @param $filename
* @return	
*/
function renderPartial($filename, $args = null) {
	$__file_relativity = "";
	while (realpath($__file_relativity.$filename) === FALSE && strlen($__file_relativity) < 60 ) 
		{ $__file_relativity = "../".$__file_relativity; }
		
    if (is_file($__file_relativity.$filename)) {
        ob_start();
        include $__file_relativity.$filename;
        $contents = ob_get_contents();
        ob_end_clean();
//        echo $contents;	// TESTING
        return $contents;
    }
    return FALSE;
}

?>