<?php
//-----------------------------------------------------------------------------
/* 		
		author: Thomaz Ebihara
		http://www.php-freebies.com 	
		date: November 2005
		script version: 1.0
*/
//-----------------------------------------------------------------------------
?>
<?php
$file = file('quotes.txt');
$quotes = array();
$authors = array();
$count = 0;
foreach($file as $k => $v)
	{
	if(preg_match("#^\r?\n$#", $v) == 0)
		{
		$count++;
		
		if($count % 2 == 1)
			{
			preg_match("#quote\:(.+)\r?\n?#i", $v, $matches);
			$quotes[] = trim($matches[1]);
			}
		else
			{
			preg_match("#author\:(.+)\r?\n?#i", $v, $matches);
			$authors[] = trim($matches[1]);
			}
		}
	}
$rnd = array_rand($quotes);
$rnd_quote = $quotes[$rnd];
$rnd_author = $authors[$rnd];
echo "$rnd_quote";
echo "$rnd_author";
?>