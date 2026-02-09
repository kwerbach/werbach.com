<? echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"; ?>
<?php
dbconnect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Supernova 2006 - Email Directory</title>
	<meta name="author" content="Supernova 2006" />
    <meta name="keywords" content="supernova, supernova2006, conference, technology, internet, computing, communications, digital media, social software, business, emerging technology, tech companies, web, web 2.0, kevin werbach, san francisco" />
    <meta name="description" content="The Supernova conference focuses on the technology-driven transformation of computing, communications, digital media, and business. " />
    <meta name="robots" content="index, follow" />

	<link rel='stylesheet' type='text/css' media='all' href='http://www.werbach.com/supernova2006new/go?css=site/site_css' />
	<style type='text/css' media='screen'>@import "http://www.werbach.com/supernova2006new/go?css=site/site_css";</style>

    <link rel="alternate" type="application/rss+xml" title="supernova" href="" />
    <link rel="shortcut icon" type="image/x-ico" href="./favicon.ico" />
    
<script language="javascript">
function validate()
{
	if(document.forms[0].first.value == "")
	{
		alert("Please fill out all required fields");
		document.forms[0].first.focus();
		return false;
	}
	
	if(document.forms[0].last.value == "")
	{
		alert("Please fill out all required fields");
		document.forms[0].last.focus();
		return false;
	}
	
	if(document.forms[0].email.value == "")
	{
		alert("Please fill out all required fields");
		document.forms[0].email.focus();
		return false;
	}
	
	if(document.forms[0].company.value == "")
	{
		alert("Please fill out all required fields");
		document.forms[0].company.focus();
		return false;
	}
	
	if(document.forms[0].title.value == "")
	{
		alert("Please fill out all required fields");
		document.forms[0].title.focus();
		return false;
	}

	return true;
}
</script>
    
    
  </head>
  <body>
 
  <div id="wrapper">
    <div id="container">

      <div id="header">
        <h1>Supernova 2006: because technology is everyone's business</h1>
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
        <li><a title="Home" href="http://www.werbach.com/supernova2006new/go">Home</a></li>
        <li><a title="About" href="http://www.werbach.com/supernova2006new/go/about">About</a></li>
        <li><a title="Register" href="https://www.supernovagroup.net/registration/register.php">Register</a></li>
        <li><a title="Speakers" href="http://www.werbach.com/supernova2006new/go/speakers">Speakers</a></li>
        <li><a title="Agenda" href="http://www.werbach.com/supernova2006new/go/agenda">Agenda</a></li>
        <li><a title="Workshops" href="http://www.werbach.com/supernova2006new/go/workshops">Workshops</a></li>
        <li><a title="Sponsors" href="http://www.werbach.com/supernova2006new/go/sponsors">Sponsors</a></li>
        <li><a title="Weblog" href="http://www.werbach.com/supernova2006new/go/weblog">Weblog</a></li>
        <li><a title="Contact Us" href="http://www.werbach.com/supernova2006new/go/contact">Contact Us</a></li>

      </ul>
		
      <div id="leftcolumn">
	    <h1>Supernova2006</h1>
        <h2>June 21-23, 2006</h2>
        <h6>San Francisco, CA</h6>
        <p><a title="Venue Information and Reserverations" href="http://www.werbach.com/supernova2006new/go/venue">Venue Information and Reservations</a></p> 
	   	
      </div>

      <div id="middlecolumn">
        <img src="http://www.werbach.com/supernova2006new/i/gardencourt.jpg" width="394" height="89" alt="Garden Court" />
        <h1>Supernova2006</h1>

<!-- ----------------- ENTER MAIN CONTENT BELOW ------------------------ -->
<?php
	show_table();
?>
<!-- ----------------- END MAIN CONTENT ABOVE ------------------------ -->
   


</div>
      <div id="rightcolumn">


		


      </div>
      <div class="clear"></div>

      <div id="footer"></div>
    </div>
  </div>

  </body>
</html>
<?php
function show_table()
{

	// QUERY FOR DISPLAYING RESULTS
	$query = "select people.first, people.last, people.company, email_aliases.email_alias
				from people JOIN email_aliases 
				ON people.ID = email_aliases.people_id
				WHERE email_aliases.email_alias LIKE '%2006.com'
				ORDER BY people.last";
//				;
	$result = safe_query($query);
//	echo $query;
	if ($result)
		{

			$class = " class=\"highlight\"";

			echo "<table>";

			while ($row = mysql_fetch_array($result)) 
			{
			$first 				= $row["first"];
			$last 				= $row["last"];
			$company			= $row["company"];
			$email_alias 		= $row["email_alias"];
			print <<<EOQ
				<tr valign="top">
				  <td><font size="2">$first $last</font></td>
				  <td><font size="2">$company</font></td>
				  <td><font size="2"><a href="mailto:$email_alias?subject=Supernova%202006">$email_alias</a></font></td>
				</tr>
EOQ;
			}
			echo "</table>";
			mysql_free_result($result);
		}
}	


// This function will connect to a MySQL database. If the attempt to connect
// fails, an error message prints out and the script will exit.

//function dbconnect ($dbname="test",$user="root",$password="",$server="localhost") // HOME 
function dbconnect ($dbname="werbach_supernova",$user="werbach",$password="sBZGTu22",$server="db53c.pair.com")
{
	if (!($mylink = mysql_connect($server,$user,$password)))
	{
		print "<h3>could not connect to database</h3>\n";
		exit;
	}
	mysql_select_db($dbname);
}


// int safe_query ([string query])

// This function will execute an SQL query against the currently open
// MySQL database. If the global variable $query_debug is not empty,
// the query will be printed out before execution. If the execution fails,
// the query and any error message from MySQL will be printed out, and
// the function will return FALSE. Otherwise, it returns the MySQL
// result set identifier.

function safe_query ($query = "")
{
	global	$query_debug;

	if (empty($query)) { return FALSE; }

	if (!empty($query_debug)) { print "<pre>$query</pre>\n"; }

	$result = mysql_query($query)
		or die("ack! query failed: "
			."<li>errorno=".mysql_errno()
			."<li>error=".mysql_error()
			."<li>query=".$query
		);
	return $result;
}

?>