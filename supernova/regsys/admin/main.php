<?php
require 'includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');
$formHelper = new formHelper;			// ???: populate this in the constuctor?

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Supernove Template</title>
<link href="adminStyle.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="includes/jquery-1.3.2.js" type="text/javascript"></script>
<script language="javascript">

	$(document).ready(function(){
		/**
		* Change the sub nav on click and on hover
		*/
		mainNavigCurrentSection	= '';
		mainNavigLastHover 		= '';
		to2						= null;	
		
		$("#navigation_main a").click(
		function(event)
		{
			$("#navigation_sub").load("partials/navigation_sub.php?sub_nav=" + $(this).attr('href') );
			mainNavigCurrentSection = $(this).attr('href');
			return false;
		}
		);

		$("#navigation_main a").hover(
		function(event)
		{
			mainNavigLastHover = $(this).attr('href');
			to = setTimeout("$('#navigation_sub').load('partials/navigation_sub.php?sub_nav=' + mainNavigLastHover)",500);
			clearTimeout(to2)		// stop the sub default from loading
		},
		function(event)
		{
			clearTimeout(to);
			if ( mainNavigCurrentSection !='' )
			{
				to2 = setTimeout("$('#navigation_sub').load('partials/navigation_sub.php?sub_nav=' + mainNavigCurrentSection)",1000)
			}				
		}
		);



		/**
		* Control what happens when a sub navigation link is clicked
		*/
		$("#navigation_sub a").live("click", function(event)
		{
			contextStr = $(this).attr('href')

//			alert( contextStr ); 		// TESTING	

			lastIndex = 0
			if( contextStr.indexOf('/') != -1 )				// href is a full URL
			{
				contextStr	= getContextStr(contextStr)		
			}
			
			if ( contextStr != '')
			{
				loadDiv(contextStr);		// TEMP --> needs to update the jsloader
			}
			else
			{
				alert( $(this).text() + ' is under construction!' )
			}
//			var page = escape($(this).attr('href'))
//			$("#_loader").attr('src', 'jsloader.php?page=' + page);
			return false;
		}		
		);

		/**
		* Update the searchlist when somthing is enterd in a seach field
		*/		
		$("#search input").live("keyup", function(event)
		{
//			alert( $( this ).attr('name') + '=' + $( this ).val() );	// TESTING
			it = $("#search select option:selected").val() + '=' + escape($( this ).val());
			it = it + '&x_list=' + $("#search input:last").val()
//			alert(it);	// TESTING
			
			if ( $("#search select option:selected").val() != '' )
			{
				$("div#_itemList").load("ajax/itemListLoad.php?" + it);
			}			
		}
		);

		/**
		* Load default page
		*/
//		$("#_loader").attr('src', 'jsloader.php?page=' + 'forms/conference.php');  // this would be the partial form				
//		$("#mainFormContent").load('forms/conference.php');

		/**
		* Load pages via iframe and ajax so we can use the browsers back button
		*/
/*		
		$("#itemList a").click(
		function(event)
		{
//			alert($(this).html());		// TESTING
//			alert($("#_loader").attr('src')); // TESTING
			alert($(this).attr('href')); // TESTING	

			var page = escape($(this).attr('href'))
			$("#_loader").attr('src', 'jsloader.php?page=' + page);
			return false;
		}		
		);
*/		


		
	}
	);

/**
* Works with _loader iframe
*/	
function loadDiv(str)
{
//	alert('loadDiv: ' + str + '.php');	// TESTING
//	$("_mainContentFrame").load(str + '.php');

	arr = str.split("|"); 
	
	if (arr[0] != undefined && arr[0] != '')
	{
		$("#_mainContentFrame").attr('src', 'forms/' + arr[0] + '.php');
	}
	
	if (arr[1] != undefined && arr[1] != '')
	{
		$("#_searchList").load("ajax/mainSearchLoad.php?x_table=" + arr[1]);
	}
//	alert($("#_searchList").html())		// TESTING
	if (arr[2] != undefined && arr[2] != '')
	{
		$("#_itemList").load("ajax/itemListLoad.php?x_list=" + arr[2]);
	}
}	

function loadSubNav()
{
		alert(mainNavigLastHover);
		$("#navigation_sub").load("partials/navigation_sub.php?sub_nav=" + mainNavigLastHover);
}	

function getContextStr(str)
{
	for (i = 0; i < str.length; i++)
	{
		if( lastIndex >= 0 &&  str.indexOf('/', lastIndex + 1) != -1 )
		{
			lastIndex = str.indexOf('/', lastIndex + 1)
		}
	}
	
	str = str.substring(lastIndex + 1,str.length);
//	alert('getContextStr: ' + str);		// TESTING
	str = unescape(str);
//	alert('getContextStr (unescape): ' + str);		// TESTING
	return str;	
}	
</script>
</head>

<body>
<table width="1000" border="0">
  <tr>
    <td width="75">&nbsp;</td>
<!-- == MAIN AREA BEGIN ================================================================= -->
    <td>
	
	<table width="850" border="0" cellspacing="0">
<!-- == MAIN NAVIGATION BEGIN ========================================================== -->
      <tr>
        <td colspan="3">
		<table id="navigation" width="100%" border="0">
			<tr>
                <td id="navigation_main">
					<?php require findRelativePath('partials/navigation_main.php'); ?>
				</td>
			</tr>
			<tr>
				<td id="navigation_sub">&nbsp;
					
				</td>
			</tr>
		</table>        </td>
        </tr>
<!-- == MAIN NAVIGATION END  ============================================================ -->

      <tr>
<!-- == SEARCH BAR BEGIN ================================================================ -->		  
      	<td colspan="2" valign="top" id="_searchList">&nbsp;
		
		</td>
<!-- == SEARCH BAR END ================================================================== -->	
      	<td>&nbsp;</td>
      	</tr>
      <tr>
<!-- == LIST BEGIN ====================================================================== -->      
        <td width="150" valign="top">
        <div id="list">
		<table width="100%" border="0" cellspacing="0" id="_itemListTable">
<!-- == LIST ROWS BEGIN ================================================================= --> 
		<tr>
			<td>
			<div id="_itemList">
			&nbsp;
			</div>			
			</td>
		</tr>
<!-- == LIST ROWS END =================================================================== --> 			
		</table>
        </div>
<!-- == JS AJAX LOADER BEGIN ============================================================ -->
			<iframe src="jsloader.php" width="100" height="50" name="_loader" id="_loader" scrolling="no" frameborder="0"></iframe>
<!-- == JS AJAX LOADER END ============================================================== -->
<!-- == LIST END ======================================================================== -->         
<!-- == FORM BEGIN ====================================================================== -->  
        <td width="600" valign="top">
			<iframe src="blank.php" width="600" name="_mainContentFrame" id="_mainContentFrame" frameborder="0" scrolling="auto" height="750"></iframe>		
		</td>
<!-- == FORM END ======================================================================== -->          
        <td width="100">&nbsp;</td>
      </tr>
    </table>
    </td>
<!-- == MAIN AREA END =================================================================== -->
    <td width="75">&nbsp;</td>
  </tr>
</table>

</body>
</html>
