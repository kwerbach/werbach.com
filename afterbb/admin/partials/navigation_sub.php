<?php
header("Cache-Control: no-cache"); 

/** This page creates the sub navigation menus from an assaoc array
* currently there are 3 elements that get loaded: 
*
* 		mainframe | searchbar | itemlist
*
* to clear the search bar or item list use a dash ("-")
*/

$a	= array();
switch (strtolower($_GET['sub_nav']))
{
	case 'conference':
				
			$a	= array('SELECT CONFERENCE::Choose a conference to work with.'=>'conference_select|-|-',
						'Conferences'=>'conference|conference|conference',
						'Packages'	=>'package_list|-|-',
						'Priority Codes'=>'priority_code_list|-|-',
						'Sponsors::Manage conference sponsors.'=>'sponsor_list|-|-',
						'Agendas'=>'agenda_list|-|-',
						'Speakers::Manage conference speakers.'=>'speaker_list|-|-',
						'Venues::Manage conference venue. There need to be venues in order to add an agenda.'=>'venue_list|-|-'
						);												
		break;
	case 'utility':
			$a	= array('Mass Tagging'=>'tag_multi|-|-',
						'Download People::Download from the entire people table. Not just attendees.'=>'download_people|-|-',
						'Quotes'=>'quote_list|-|-',						
						'Images'=>'image_list|-|-',
						'Staff::Manage staff members.'=>'staff_list|-|Staff');				
		break;
	case 'attendee':
			$a	= array('Attendee List::View attendees for the selected conference.'=>'attendee|-|-',
						'Attendee Check In::Sign in attendees at registration.'=>'attendee_check_in|-|-',
						'Add Attendees::Add attendees, speakers, and sponsors en masse.'=>'add_attendee|-|-',
						'Email Aliases'=>'email_alias_list|-|-',
						'Download Attendees::Download attendees only.'=>'download|-|-');
		break;
	case 'report':
			$a	= array('Attendee'=>'report_conference|-|-',
						'Revenue'=>'report_revenue|-|-',
						'Sponsor'=>'report_sponsor|-|-');				
		break;		
			
}
	
$sub_navigation = '';				

foreach($a as $key => $value)
{
	$text	= split('::',$key);
	$title 	= ( isset($text[1]) ) ? $text[1] : "";
	$sub_navigation .= "<a href=\"$value\" target=\"_mainContentFrame\" title=\"$title\">$text[0]</a> | ";
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