<?php
# Random HTML ver.1.0 - (C)2000, Blake McDonald (webmaster@dark-library.com)

# FULL System path to the Random HTML folder, no trailing slash

$sys_path_dir = "/usr/www/users/werbach/supernova2006new/random";

#
################ STOP! ###############3

require("$sys_path_dir/settings.php");

$logfile = "$sys_path_dir/log.txt";
$number_show = "$sys_path_dir/show.txt";

############# cycle

if($show_type == 1) {

		$fp = fopen($logfile, "r") or die ("<div id=\"quotebody\">\"As good as any conference anywhere.\"</div><div id=\"quoteauthor\">Lee Stein, CEO, Virtual Group</div>");
		$html_codes = fread($fp, filesize($logfile));
		fclose($fp);
			$arrays_html = explode("[%%BREAK%%]",$html_codes);
			$total = count($arrays_html);

			$number_file = file($number_show);
			
			if($number_file[0] < $total) {
				$to_show_number = $number_file[0];
				} else {
				$to_show_number = 0;
				}
		$arrays_html[$to_show_number] = stripslashes($arrays_html[$to_show_number]);
		echo $arrays_html[$to_show_number];

			$to_show_number++;
				$fo = fopen($number_show, "w");
        		fputs($fo, "$to_show_number"); 
        		fclose($fo);
}

############ controlled random

if($show_type == 2) {

		$fp = fopen($logfile, "r");
		$html_codes = fread($fp, filesize($logfile));
		fclose($fp);
			$arrays_html = explode("[%%BREAK%%]",$html_codes);
			$total = count($arrays_html);
			$number_file = file($number_show);

				srand((double)microtime()*1000000);
				$random_html = rand(0,$total-1);

		while($random_html == $number_file[0]) {


		$random_html = rand(0,$total-1);

	}

		$arrays_html[$random_html] = stripslashes($arrays_html[$random_html]);
		echo $arrays_html[$random_html];

			$fo = fopen($number_show, "w");
        		fputs($fo, "$random"); 
        		fclose($fo);
}

############ total random

if($show_type == 3) {

		$fp = fopen($logfile, "r");
		$html_codes = fread($fp, filesize($logfile));
		fclose($fp);
			$arrays_html = explode("[%%BREAK%%]",$html_codes);
			$total = count($arrays_html);
			$number_file = file($number_show);

				srand((double)microtime()*1000000);
				$random_html = rand(0,$total-1);

		$random_html = rand(0,$total-1);
		$arrays_html[$random_html] = stripslashes($arrays_html[$random_html]);
		echo $arrays_html[$random_html];
}

?>
