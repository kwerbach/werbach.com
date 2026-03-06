#!/usr/local/bin/perl
#Place nothing above the line with #!/usr/local/bin/perl
#Make sure the line above is pointing to where your perl language
#actually is! If this is incorrect, other places to look include:
#   /usr/bin/perl  /usr/sbin/perl  /sbin/perl 
#
$|=1;
#Do not touch the line above this!
#
# (c) 1997 by BigNoseBird.Com
#This program is intended to be used as a learning tool. It  
#is given freely AS IS and comes with no warranty. The author
#is not responsible for any damages caused by its use or     
#misuse.
#
#  requires that the hidden variable "action" contain VIEW or VOTE
#  requires that the hidden variable "filebase" contains a value
#    to define which survey this is.
#
#  Unix dependencies: needs "grep" or "fgrep" to work.
#  fgrep is preferable as it is the "fast" grep!
#
#Format of log file. Delimited by ':' for easy import into various dbs
#id_number:IP_addr:Weekday:Mnth:Day:Yr:Hr:min:sec:ITEM1:value:ITEM2:value:
#
#
   $ENFORCEMENT="0"; # no restriction on how many times a person votes
#  $ENFORCEMENT="1"; # means prevent people from voting in the same hour

   $DATA_PATH="/";  #Physical path to data files if not running this
                     #script in your base cgi-bin directory.
#  example: $DATA_PATH="/home/httpd/cgi-bin/survey/";

   $SITE_URL="http://werbach.com"; #Your site's default URL
   $IMAGE_PATH="$SITE_URL/simages/"; #The directory under your main
                                     #web, where the graphics are.
   $PIXEL_SCALE=350;   #Maximum length of graphic: No reason to change it.

   $GREP="/usr/bin/fgrep"; #this should locate grep or fgrep on most systems
               #if not on yours, then see the instructions in the
               #grep_hunt subroutine near the bottom of the script.see the instructions in the
               #grep_hunt subroutine near the bottom of the script.

   $EXIT_PAGE="$SITE_URL/barebones/index.html"; #Link out of survey result screen

   

   &parse_input;
   &validate;
   &load_colors;

   if ($fields{'action'} eq "VIEW")
    {
      &view_results;
      exit;
    }

   if ($fields{'action'} eq "VOTE")
    {
    &is_repeater;
    if ($REPEATER eq "0") 
     {
       $tmp_lock="$fields{'filebase'}.lock";
       &LockIt ("$tmp_lock");
       &get_unique;
       &write_data;
       &UnLockIt ("$tmp_lock");
     }
      &view_results;
      exit;
    }

####This subroutine creates the HTML code result of the survey data
sub view_results
{
   &get_sample_size;
   $j=0;
   @tmp_cnt=();
   &print_head;
   &get_list;
   foreach (@to_get)
    {
      @label_text=();
      $get_it=@to_get[$j];
      &get_labels;
      &read_data;
      &find_max;
      $i=0;
      print "<P><B>@label_text[1]</B>\n";
      print "<TABLE BORDER=1>";
      foreach (@tmp_cnt)
       {
         $lab=@label_text[$i+2];
         $wide=int(@tmp_cnt[$i] * $factor);
         $colr=@colors[$i];
         $pct=int((@tmp_cnt[$i]/$ssize)*100);
         print " <TR>\n";
         print "<TD WIDTH=85>$lab</TD>";
         print "<TD WIDTH=45>@tmp_cnt[$i]</TD>";
         print "<TD WIDTH=45>$pct\%</TD>";
         if (@tmp_cnt[$i] > 0)
           {
            print "<TD><IMG SRC=\"$IMAGE_PATH$colr\" ";
            print " BORDER=0 HEIGHT=8 WIDTH=$wide></TD>\n";
           }
           else
           {
            print "<TD>&nbsp;</TD>\n";
           }
         print " </TR>\n";
         $i++;
       }
      print "</TABLE><P>\n";
      @tmp_cnt=();
      $j++;
    }
    print "<P><BLOCKQUOTE>\n";
    print "<B>Free Survey Script created by </B>";
    print "<A HREF=\"http://bignosebird.com/\"><B>BigNoseBird.Com</B></A>";
    print "<P></BLOCKQUOTE>\n";
}

###READ IN THE TEXT INFORMATION FILE FOR HEADINGS AND LABELS
sub get_labels
{
   open(TEXT_FILE,"$GREP $get_it: $DATA_PATH$textsource|");
    while ($tx_rec=<TEXT_FILE>)
     {
       chop $tx_rec;
       @label_text = split(/:/,$tx_rec);
     }
     close(TEXT_FILE);
}

###READ THE SURVEY RESULTS FILE
sub read_data
{
   open(DATA_FILE,"$GREP $get_it: $DATA_PATH$datasource|");
    while ($in_rec=<DATA_FILE>)
     {
       chop $in_rec;
       @rec = split(/:/,$in_rec);
       @tmp_cnt[@rec[1]]++;
     }
   close DATA_FILE;
}

###FOR EACH QUESTION, FIND THE MAX VALUE AND SCALE THE RESULT IN PIXELS
sub find_max
{
   $b=0;
   $factor=1;
   $maxwide=1;
   foreach (@tmp_cnt)
    {
     if (@tmp_cnt[$b] > $maxwide)
       {
         $maxwide = @tmp_cnt[$b];
       }
     $b++;
    }
   $factor = $PIXEL_SCALE/$maxwide;
}

#Here is where we pop in our little image files
#Shuffle them to suite your tastes! This allows for up
#to 20 different response catagories per question
sub load_colors
{
   @colors=("blue.gif","cherry.gif","green.gif",
            "navy.gif","pink.gif", "teal.gif",
            "sky.gif","red.gif","yellow.gif",
            "black.gif",
            "blue.gif","cherry.gif","green.gif",
            "navy.gif","pink.gif", "teal.gif",
            "sky.gif","red.gif","yellow.gif",
            "black.gif");
}

###Print the usual header to the screen
sub print_head
{
   print "Content-type: text/html\n\n";
   print "<HTML><BODY BGCOLOR=#FFFFFF>";

   if ($fields{'action'} eq "VOTE")
    {
      if ($REPEATER eq "0")
       {
         print "<P><H2>Thank you for answering our survey!</H2>";
       }
       else
       {
        print "<P><H2>You already voted!</H2>";
       }
    }

   print "<B>CURRENT SURVEY RESULTS</B><BR>";
   print "<B>FOR $ssize ENTRIES</B><P>";
   print "<I>Percentages may not add up to 100% due to rounding</I><BR>\n";
   print "<P>\n";
   print "<A HREF=$EXIT_PAGE><B>To exit this screen</B></A>\n";
}

#Read the configuration file to figure out what to do and get our labels
sub get_list
{
   $x=0;
   open(TEXT_FILE,"<$DATA_PATH$textsource");
    while ($tx_rec=<TEXT_FILE>)
     {
       chop $tx_rec;
       if ($tx_rec eq "")
         {
          next;
         }
       @to_get[$x] = split(/:/,$tx_rec,2);
       $x++;
     }
     close(TEXT_FILE);
}

###Decode the input string
sub parse_input
{
  $k=0;
  read(STDIN,$temp,$ENV{'CONTENT_LENGTH'});
  @pairs=split(/&/,$temp);
  foreach $item(@pairs)
   {
    ($key,$content)=split(/=/,$item,2);
    $content=~tr/+/ /;
    $content=~s/%(..)/pack("c",hex($1))/ge;
    $fields{$key}=$content;
    $k++;
    $item{$k}=$key;
    $response{$k}=$content;
   }
   $user_id= $ENV{'REMOTE_ADDR'};
   $datasource="$fields{'filebase'}.dat";
   $textsource="$fields{'filebase'}.cfg";
   $cntsource ="$fields{'filebase'}.cnt";
   $logsource ="$fields{'filebase'}.log";
}

###Send our output to the screen, log, and datafile
sub write_data
{
   $z=1;
   open(DATA_OUT,">>$DATA_PATH$datasource");
   open(LOG_OUT,">>$DATA_PATH$logsource");
   print LOG_OUT "$unique:$user_id:";
   print LOG_OUT "$day:$month:$num:$year:$hour:$minute:$second:";
   while ( $item{$z} gt " ")
    {                                                 
     if ( $item{$z} ne "action" && $item{$z} ne "filebase" )
      {
       print DATA_OUT "$item{$z}:$response{$z}\n"; 
       print LOG_OUT  "$item{$z}:$response{$z}:"; 
       print "$item{$z}:$response{$z}\n"; 
      }
     $z++;                                           
    }
   print LOG_OUT "\n";
   close(DATA_OUT);
   close(LOG_OUT);
}

###Before doing anything, make sure we have a valid call
sub validate
{
   if ($fields{'filebase'} eq "")
    {
      print "Content-type: text/html\n\n";
      print "<H1>Survey Files Not Defined</H1>\n";
    }
   if ($fields{'action'} eq "")
    {
      print "Content-type: text/html\n\n";
      print "<H1>Incorrect Calling of Script!</H1>\n";
    }
}

###This gets us a unique number to assign each survey entry
sub get_unique
{
   $cntsource ="$fields{'filebase'}.cnt";
    open(CNT,"<$DATA_PATH$cntsource");
    while ($unique=<CNT>)
     {
       if ( $unique lt "1")
        {
          $unique=0;
        } 
        last;
     }
    $unique++;
    close(CNT);
    open(CNT,">$DATA_PATH$cntsource");
    print CNT "$unique";
    close(CNT);    
}

#Derive all the elements of the current date and time
sub get_time
{
 $date=localtime(time);
 ($day, $month, $num, $time, $year) = split(/\s+/,$date);
 ($hour, $minute, $second) = split(/:/,$time);
}


### Lock the files (this routine borrowed from Selena Sol!)
sub LockIt {  
    local ($lock_file) = @_;

    local ($endtime);  
    $endtime = 60;
    $endtime = time + $endtime;
#   We set endtime to wait 60 seconds

    while (-e $lock_file && time < $endtime) {
        # Do Nothing
    }
    open(LOCK_FILE, ">$DATA_PATH$lock_file");    
#    flock(LOCK_FILE, 2); # 2 exclusively locks the file
} # end of get_file_lock

### Unlock the files (this routine borrowed from Selena Sol!)
sub UnLockIt {
    local ($lock_file) = @_;
       
# 8 unlocks the file
#    flock(LOCK_FILE, 8);
    close(LOCK_FILE);
    unlink($lock_file);

} # end of ReleaseFileLock   

###Grab the sample size from the counter file so we can do percentages
sub get_sample_size
{
   $cntsource ="$fields{'filebase'}.cnt";
    open(CNT,"<$DATA_PATH$cntsource");
    while ($ssize=<CNT>)
     {
       if ( $ssize lt "1")
        {
          $ssize=1;
        } 
        last;
    }
    close(CNT);
}

###This routine looks at the log to see if this IP address has made
###an entry during the current clock hour on this day.
###If ENFORCEMENT is turned on and a record is found, then REPEATER
###is set to 1, otherwise REPEATER is set to 0.
sub is_repeater
{
   &get_time;
   $REPEATER="0";
   if ($ENFORCEMENT eq "1")
    {
     open(LOG_IN,"$GREP ':$user_id:$day:$month:$num:$year:$hour:' $DATA_PATH$logsource|");
     while ($dup_check=<LOG_IN>)
      {
         chop $dup_check;
         $REPEATER=1;
      }
     close(LOG_IN);
   }
}

#id_number:IP_addr:Weekday:Mnth:Day:Yr:Hr:min:sec:ITEM1:value:ITEM2:value:


sub grep_hunt
{
  if ( -e "/bin/fgrep")
   {$GREP="/bin/fgrep"; return;}

  if ( -e "/bin/grep")
   {$GREP="/bin/grep"; return;}

  if ( -e "/usr/bin/grep")
   {$GREP="/usr/bin/grep"; return;}

  if ( -e "/sbin/fgrep")
   {$GREP="/sbin/fgrep"; return;}

  if ( -e "/usr/sbin/fgrep")
   {$GREP="/usr/sbin/fgrep"; return;}

  if ( -e "/usr/bin/fgrep")
   {$GREP="/usr/bin/fgrep"; return;}

  if ( -e "/usr/sbin/grep")
   {$GREP="/usr/sbin/grep"; return;}

  if ( -e "/sbin/grep")
   {$GREP="/sbin/grep"; return;}

   print "Content-type: text/html\n\n";
   print "ERROR! Unable to find grep utility.\n";

#if grep on your system is not in the list above,
#change one of the $GREP= to be equal to your 
#system's grep command.

}

