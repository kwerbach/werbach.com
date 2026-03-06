<?php
/*
Template Name: Speaker Info
*/
?>
<?php get_header(); ?>

	<div id="content" class="home">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h3 style="font-size: 145%;text-align:right;">Supernova2009</h3>
		
				
				<?php
        		$ch = curl_init("https://supernovahub.com/registration/output.php?d=speaker&f[]=e_conference_id&fv[]=1&f[]=e_speaker_id&fv[]=".$_GET['sid']);
        		curl_setopt($ch, CURLOPT_HEADER, 0);
        		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        		$output = curl_exec($ch);      
        		curl_close($ch);
        		//echo $output;
				$output = explode('~~',$output);
				$speaker_info = array();
				foreach($output as $key => $value) {
					$output2 = explode('|',$value);
					$tarray = array();
					foreach($output2 as $key2 => $value2) {
						$uarray = array();
						$uarray = explode(":",$value2,2);
						$tarray[trim($uarray[0])] = trim($uarray[1]);
						unset($uarray);
					}
					$speaker_info[] = $tarray;
					unset($tarray);
				}
				foreach($speaker_info as $key => $value) {
					if(!empty($value['last_name'])) {
						/** START: band aid for cases where speakers have an image name that is not just their last name */
						switch ($value['speaker_id'])	// last name, first initial
						{
							case 37:		// Bennett Ross
							case 91:		// Lisa Stone		
					
								$img	= "/imagesConf/sp_" . strtolower( $value['last_name'] . substr($value['first_name'], 0, 1) )  . "_l.jpg";
								break;
						switch ($value['speaker_id']) // first initial, last name
						{
							case 68:		// Kevin Werbach					
								$img	= "/imagesConf/sp_" . strtolower( substr($value['first_name'], 0, 1) . $value['last_name'] )  . "_l.jpg";
								break;		
							default:	// last name only
								$img	= "/imagesConf/sp_" . strtolower($value['last_name'])."_l.jpg";								
								break;
						}
						/** END: band aid for cases where speakers have an image name that is not just their last name */	
						?>
						<h2><?=$value['first_name']?> <?=$value['last_name']?><span class="spkinfo"><?=$value['company']?></span></h2>
						<div class="entry" style="margin:0;">
							<img class="spkimgbig" src="<?php bloginfo('url'); ?><?= $img ?>" alt="<?=$value['first_name']?> <?=$value['last_name']?>">
							<p><?=$value['bio']?></p>
							<p><a href="<?php bloginfo('url'); ?>/speakers/">&laquo; Back to Speakers</a></p>
						</div><!--END entry-->
						<?php
						//print_r($value);
					}	
				}
				?>
		<?php endwhile; endif; ?>

		<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
		
		</div><!--END content-->


<?php include (TEMPLATEPATH . '/sidebar-speakers.php'); ?>

<?php get_footer(); ?>