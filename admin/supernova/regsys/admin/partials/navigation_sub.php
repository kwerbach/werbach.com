<?php
header("Cache-Control: no-cache"); 

/** This page creates the sub navigation menus from an assaoc array
* currently there are 3 elements that get loaded: mainframe|searchbar|itemlist
* to clear the search bar or item list use a dash ("-")
*/

$a	= array();
switch (strtolower($_GET['sub_nav']))
{
	case 'conference':
				
			$a	= array('SELECT CONFERENCE'=>'conference_select|-|-',
						'Conferences'=>'conference|conference|conference',
						'Packages'	=>'package|package|package',
						'Priority Codes'=>'priority_code',
						'Sponsors'=>'',
						'Agendas'=>'',
						'Speakers'=>'',
						'Categories'=>'',	
						'Venues'=>'venue|venue|-'
						);												
		break;
	case 'utility':
			$a	= array('Tags'=>''	,
						'Mass Tagging'=>'',
						'Download'=>'download|-|-'		,
						'Images'=>'image|-|-',
						'List Manager'=>'');				
		break;
	case 'attendee':
			$a	= array('Attendee List'=>'attendee|-|-');				
		break;					
}
	
$sub_navigation = '';				

foreach($a as $key => $value)
{
	$sub_navigation .= "<a href=\"$value\" target=\"_mainContentFrame\">$key</a> | ";
}

if ($sub_navigation == '')
{
	$sub_navigation = "No Sub Links";
}
else
{
	$sub_navigation = rtrim($sub_navigation, ' | ');
}
echo $sub_navigation;
?>