<?php
// DEFAULT DB INFO - PRODUCTION WEB SERVER
$configArr['dbInfo']['dbHost'] 			= 'db53c.pair.com';
$configArr['dbInfo']['dbUserName'] 		= 'werbach';
$configArr['dbInfo']['dbUserPassword'] 	= 'sBZGTu22';
$configArr['dbInfo']['dbName'] 			= 'werbach_supernova';

// DB INFO DESKTOP
if ($_SERVER['DOCUMENT_ROOT'] == '//Nas01/PUBLIC DISK/Dave/www'){
	$configArr['dbInfo']['dbHost'] 			= 'localhost';
	$configArr['dbInfo']['dbUserName'] 		= 'root';
	$configArr['dbInfo']['dbUserPassword'] 	= '';
	$configArr['dbInfo']['dbName'] 			= 'supernova';
}
// DB INFO LAPTOP
if ($_SERVER['DOCUMENT_ROOT'] == 'C:/Documents and Settings/All Users/Documents/www'){
	$configArr['dbInfo']['dbHost'] 			= 'localhost';
	$configArr['dbInfo']['dbUserName'] 		= 'root';
	$configArr['dbInfo']['dbUserPassword'] 	= 'root';
	$configArr['dbInfo']['dbName'] 			= 'supernova_dev';
}
// DB INFO WORK
if ($_SERVER['DOCUMENT_ROOT'] == 'E:/My Docs/www'){
	$configArr['dbInfo']['dbHost'] 			= 'localhost';
	$configArr['dbInfo']['dbUserName'] 		= 'root';
	$configArr['dbInfo']['dbUserPassword'] 	= 'root';
	$configArr['dbInfo']['dbName'] 			= 'supernova';	
}	
	
	define('DB_HOST',$configArr['dbInfo']['dbHost']);
	define('DB_USER_NAME',$configArr['dbInfo']['dbUserName']);
	define('DB_USER_PASSWORD',$configArr['dbInfo']['dbUserPassword']);
	define('DB_NAME',$configArr['dbInfo']['dbName']);

//  CONSTANTS
	define('UPLOAD_IMPAGE_PATH', "../../imagesConf/");


// ERROR DEFINITIONS
	// SQL ERRORS (DATA TYPE ERRORS)
	define('ERR_101','Died with: Error 101 - Tried to enter something other than a number!');
	define('ERR_102','Died with: Error 102 - Tried to enter a date in a format other than mm/dd/yyyy!');
	
	// SQL ERRORS (DATA CONTENT ERRORS)
	define('ERR_121','Died with: Error 121 - No Package/Conference Combo Found!');
	define('ERR_122','Died with: Error 122 - No Quotes Fount!');	
	
	// FILE ERRORS
	define('ERR_901','Died with: Error 901 - Relative file not found!');
// DEFINE TABLE JOINS	
?>
