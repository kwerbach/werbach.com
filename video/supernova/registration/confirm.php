<?php
require "inc_forms.php";
require "inc_db.php";
$reg_year 	= "2008";
$is_test	=	"";		// "_test" or ""
dbconnect();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Supernova :: <?php echo $reg_year; ?> - Register</title>
	<meta name="author" content="Supernova 2007" />
    <meta name="keywords" content="supernova, supernova2007, conference, technology, internet, computing, communications, digital media, social software, business, emerging technology, tech companies, web, web 2.0, kevin werbach, san francisco" />
    <meta name="description" content="The Supernova conference focuses on the technology-driven transformation of computing, communications, digital media, and business. " />
    <meta name="robots" content="index, follow" />

	<link rel='stylesheet' type='text/css' media='all' href='http://www.werbach.com/supernova2006new/go?css=site/site_css' />
	<style type='text/css' media='screen'>@import "http://www.werbach.com/supernova2006new/go?css=site/site_css";</style>

    <link rel="alternate" type="application/rss+xml" title="supernova" href="" />
    <link rel="shortcut icon" type="image/x-ico" href="./favicon.ico" />
  </head>
  <body>
 
  <div id="wrapper">
    <div id="container">

      <div id="header">
        <h1>Supernova <?php echo $reg_year; ?>: because technology is everyone's business</h1>
      </div>
      <div id="subheader">
        <div id="whartonlogo"><a href="http://www.wharton.upenn.edu/"><img src="http://www.werbach.com/supernova2006new/i/whartonlogo.jpg" width="110" height="55" alt="Produced in Partnership with Wharton University of Pennsylvania" /></a></div>
        <div id="quote">
          <div id="quotebody">"One of the must-attends of the digerati and forward thinkers of the networked age."</div>
          <div id="quoteauthor">John Seely Brown, Former Chief Scientist, Xerox</div>

        </div>
        <div class="clear"></div>
      </div>
      
	  <ul id="navigation">
        <li><a title="Home" href="http://www.supernova<?php echo $reg_year; ?>.com/go">Home</a></li>
        <li><a title="About" href="http://www.supernova<?php echo $reg_year; ?>.com/go/about">About</a></li>
        <li><a title="Register" href="https://www.supernovagroup.net/registration/register.php">Register</a></li>
        <li><a title="Speakers" href="http://www.supernova<?php echo $reg_year; ?>.com/go/speakers">Speakers</a></li>
        <li><a title="Sessions" href="http://www.supernova<?php echo $reg_year; ?>.com/go/agenda">Sessions</a></li>
        <li><a title="Workshops" href="http://www.supernova<?php echo $reg_year; ?>.com/go/workshops">Challenge Day </a></li>
        <li><a title="Weblog" href="http://www.supernova<?php echo $reg_year; ?>.com/go/weblog">Weblog</a></li>
        <li><a title="Contact Us" href="http://www.supernova<?php echo $reg_year; ?>.com/go/contact">Contact Us</a></li>

      </ul>
		
      <div id="leftcolumn">
        <h1>Supernova 2008</h1>
        <h2>June 16-18, 2008</h2>
        <h6>San Francisco, CA</h6>
      </div>
      <div id="middlecolumn">
        <img src="http://www.supernova<?php echo $reg_year; ?>.com/i/alexandras_top.jpg" width="394" height="89" alt="Alexandra" />
        <h1>Supernova <?php echo $reg_year; ?></h1>

        <!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->

		<h2>Register</h2>
		<p>Please review your information before continuing. If you need to return to the registration form you may use your browser's back button. </p>
	<?php
	$not_from_form	= array("priority_code","category","description");	// FROM THE DATABASE BASED NOT FROM FORM
	$seminar_values = array("seminar_event","showcase","meals","priority_code");
	$payment_values = array("billing_first",
							"billing_last",
							"billing_address1",
							"billing_city",
							"billing_state",
							"billing_zip",
							"billing_country",
							"cc_type",
							"cc_number",
							"expire_month",
							"expire_year",
							"payment_method");

$contact_values = array("first",
						"last",
						"email",
						"confirm_email",
						"email_format",
						"title",
						"company",
						"address1",
						"address2",
						"city",
						"province",
						"zip",
						"country",
						"phone",
						"cellphone",
						"fax",
						"website",
						"blog");

	
	if ($_POST["payment_method"] == "credit card" and $_POST["amount"] > 0)
	{
		echo "<p>Please note that your credit card will be charged <strong>$" . $_POST["amount"] . "</strong> &#8212; the full amount of the registration.</p>";
	}
	
	echo "<strong>Registration Information:</strong><hr />";
	foreach($_POST as $key => $value)
	{
		if(in_array($key, $seminar_values))	echo "<b>" . beautify($key) . ":</b> $value<br />";
	}
	echo "<br /><br /><strong>Contact Information:</strong><hr />";
	foreach($_POST as $key => $value)
	{
		if(in_array($key, $contact_values))	echo "<b>" . beautify($key) . ":</b> $value<br />";
	}	
	echo "<br /><br /><strong>Payment Information:</strong><hr />";
	echo "<b>Amount:</b> $" . $_POST["amount"] . "<br />";
	foreach($_POST as $key => $value)
	{
		if(in_array($key, $payment_values))	echo "<b>" . beautify($key) . ":</b> $value<br />";
	}
	echo "<hr />";
/*	//TESTING
	foreach($_POST as $key => $value)
	{
		echo "\"$key\",<br />";
	}
*/
	?>
	
	<form action="thank_you<?php echo "$is_test"; ?>.php" method="post">
	<?php
	write_pc_values();
	foreach($_POST as $key => $value)
	{
		if(in_array($key, $not_from_form) == 0)	echo hidden_field ($key, $value) . "\n";
//		echo hidden_field ($key, $value) . "\n";
	}
	
	function write_pc_values()
	{
		global $reg_year;
		$cutoff_date = getdate(mktime(0,0,0,5,8,2008));  	// NO MORE EARLYBIRD @ 12:00 AM
		$today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
	
		if($today[0] >= $cutoff_date[0])					// THEN AFTER CUTOFF -> FULL PRICE
		{
			// if after 5/8
			$default_code 			= "none"; 
			$default_category 		= "attendee";
			$default_description	= "no code";
		}
		else												// THEN BEFORE CUTOFF, YOU GET EARLY BIRD
		{
				switch ($_POST["seminar_event"]) {
				case "Wharton West Challenge Day":		// NOT IN USE FOR 2008
				  	$default_code 			= "early1"; 			// X determinied by event
					$default_description	= "early bird 1-day";	// X determinied by event
				   break;
				case "2-day Conference Package":		// NOT IN USE FOR 2008
				  	$default_code 			= "early2"; 			// X determinied by event
					$default_description	= "early bird 2-day";	// X determinied by event
				   break;
				case "Supernova 2008 Conference":		// NAME OF FULL CONF
				   	$default_code 			= "early bird"; 			// X determinied by event
					$default_description	= "early bird";		// X determinied by event
				   break;
				}
				$default_category = "early bird";
		}
		
//		echo empty($_POST["priority_code"]) . "\n";
		if (empty($_POST["priority_code"]) == 1)			// THERE IS NO PRIORITY CODE, SET DEFAULTS
		{
			echo hidden_field ("priority_code", $default_code) . "\n";
			echo hidden_field ("category", $default_category) . "\n"; 
			echo hidden_field ("priority_code_description", $default_description) . "\n";
		}
		else	  											// THERE IS A PRIORITY CODE, GET PARAMS FROM DB
		{
			$where_clause 	= "WHERE priority_code = '" . $_POST["priority_code"] . "' AND for_event = 'supernova" . $reg_year . "'";	// CHANGE FOR FUTURE EVENTS
			$query 			= "SELECT priority_code, price, category, description FROM sn_priority_codes " . $where_clause;
			$result 		= safe_query($query);
			if ($result)	// FOUND RECORDS
			{
				while ($row = mysql_fetch_array($result)) 
				{
					echo hidden_field ("priority_code",  $row["priority_code"]) . "\n";
					echo hidden_field ("category", $row["category"]) . "\n";
					echo hidden_field ("priority_code_description", $row["description"]) . "\n";
				}
			}
			else 			// NO RECORDS
			{
					echo hidden_field ("priority_code", $default_code) . "\n";
					echo hidden_field ("category", "attendee") . "\n";
					echo hidden_field ("priority_code_description", $default_description) . "\n";
			}
		}
	}
	?>
	<div align="center">
	    <input type="button" class="button" value="Back To Form" onClick="window.history.go(-1)">
	    <img src="../images_reg/spacer.gif" width="20" height="10">
	    <input name="" type="submit" class="button" value="Confirm Registration">
	  </div>
	</form></p>


<!-- ----------------- END MAIN CONTENT ABOVE ------------------------ -->
      
      </div>
<!-- 
      <div id="rightcolumn">

      <div id="subnav">
	  <a title="Community Connection" href="http://www.werbach.com/supernova2006new/go/community-connection">Community Connection</a><br/>
      <a title="Audio/Video" href="http://www.werbach.com/supernova2006new/go/media-center">Media Center</a><br/>
      <a title="Connected Innovators" href="http://www.werbach.com/supernova2006new/go/connected-innovators">Connected Innovators</a><br/>
      <a id="cohosted" title="TechCrunch" href="http://www.werbach.com/supernova2006new/go/connected-innovators"><img class="right" src="http://www.werbach.com/supernova2006new/i/co-hosted_tc.gif" width="120" height="14" alt="Techcrunch" border="0" /></a><br/><br/>
       <a id="rss" title="RSS Feed" href="http://www.werbach.com/supernova2006new/go/weblog/rss_2.0"><img class="left" src="http://www.werbach.com/supernova2006new/i/rssicon.jpg" width="28" height="28" alt="RSS Icon" /> Subscribe to RSS</a>

	   </div>
		
        <div class="sponsors">Premium Sponsor</div>
        <img src="http://www.werbach.com/supernova2006new/i/att.jpg" width="95" height="45" alt="ATT" />
        <br />
        <p class="purple">A complete list of sponsors is available on our <a href="http://www.werbach.com/supernova2006new/go/sponsors">sponsors page</a>. For sponsorsorship information, please <a href="mailto:sponsor@supernova2006.com">email us</a>, or view our <a href="./../downloads/prospectus.pdf">Sponsor Prospectus</a> (PDF).</p>  <br /><br /><br />

      </div>
	  </div>
 -->
      <div class="clear"></div>

      <div id="footer"></div>
    
  </div>

  </body>
</html>
<?php
function beautify($str)
{
	$str = str_replace("_", " ", $str);
	$str = ucwords($str);
	$str = str_replace("Seminar Event", "Conference Package", $str);
	$str = str_replace("Cellphone", "Mobile Phone", $str);
	return $str;
}
?>