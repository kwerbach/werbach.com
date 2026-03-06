<?php 
if(!isset($regHelper))	// CHECH THIS BECAUSE OF RENDER PARTIAL ON THE TY PAGE
{
	$regHelper = new regHelper;
	$regHelper->getConferenceVariableValues(2);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title><?php echo $conference_name; ?></title>
	<meta name="author" content="Supernova 2008" />
<meta name="keywords" content="supernova, supernova2008, conference, technology, internet, computing, communications, digital media, social software, business, emerging technology, tech companies, web, web 2.0, kevin werbach, san francisco" />
<meta name="description" content="The Supernova conference focuses on the technology-driven transformation of computing, communications, digital media, and business. " />
<meta name="robots" content="index, follow" />

	<link rel='stylesheet' type='text/css' media='all' href='register.css' />
	<link rel='stylesheet' type='text/css' media='all' href='registration.css' />

    <link rel="alternate" type="application/rss+xml" title="supernova" href="http://feeds.feedburner.com/SupernovaWeblog" />
    <link rel="shortcut icon" type="image/x-ico" href="../favicon.ico" />
  <?php require "inc_register_head.php"; ?>
  
  </head>
  <body>
 
  <div id="wrapper">
    <div id="container">
      <div id="header">
        <h1>Supernova 2008: because technology is everyone's business</h1>
      </div>
      <div id="subheader">
        <div id="whartonlogo"><a href="http://www.wharton.upenn.edu/"><img src="http://www.supernova2009.com/i/whartonlogo.jpg" width="110" height="55" alt="Produced in Partnership with Wharton University of Pennsylvania" /></a></div>
        <div id="quote">
		<?php
		$regHelper->getQuote(2, 0, 1);	
		?>
        </div>
        <div class="clear"></div>
      </div>
      
	   <ul id="navigation">
        <li><a title="Home" href="http://www.supernova2009.com/go">Home</a></li>
        <li><a title="About" href="http://www.supernova2009.com/go/about">About</a></li>
        <li><a title="Register" href="https://www.supernovagroup.net/registration/register.php">Register</a></li>
        <li><a title="Speakers" href="http://www.supernova2009.com/go/speakers">Speakers</a></li>
        <li><a title="Agenda" href="http://www.supernova2009.com/go/agenda">Program Overview</a></li>
        <li><a title="Challenge Days" href="http://www.supernova2009.com/go/schedule">Agenda</a></li>
        <li><a title="Sponsors" href="http://www.supernova2009.com/go/sponsors">Sponsors</a></li>
        <li><a title="Weblog" href="http://www.conversationhub.com">Weblog</a></li>
        <li><a title="Contact Us" href="http://www.supernova2009.com/go/contact">Contact</a></li>
      </ul>
		
		<div id="leftcolumn">
			<h1>Supernova 2009</h1>
			<h2>December 1-3</h2>
			<h6>San Francisco, CA</h6>
			<div class="clear"></div>
		</div>
		<div id="middlewide">
				<!-- MAIN CONTENT BEGIN -->
				<img src="http://www.supernova2009.com/i/speakers_horiz.jpg" width="385" height="70" alt="speakers"  />
				<h1><?php global $conference_name; echo $conference_name; ?></h1>
		  