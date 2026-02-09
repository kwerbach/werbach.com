#!/usr/local/bin/perl
# $Id: formmail.pl,v 1.24 2018/01/29 20:18:18 erik5 Exp $

### Updated by pair Networks for added security and spam protection
### See: http://www.pair.com/pair/support/library/systemcgi/formmail.html

##############################################################################
# FormMail                      Version 1.5                                  #
# Copyright 1996 Matt Wright    mattw@misha.net                              #
# Created 6/9/95                Last Modified 04/04/2001                     #
# Additional security and bug fixes added for use on pair Networks' servers  #
# See: http://www.pair.com/pair/support/library/systemcgi/formmail.html      #
# Scripts Archive at:           http://www.worldwidemart.com/scripts/        #
##############################################################################
# COPYRIGHT NOTICE                                                           #
# Copyright 1996 Matthew M. Wright  All Rights Reserved.                     #
#                                                                            #
# FormMail may be used and modified free of charge by anyone so long as this #
# copyright notice and the comments above remain intact.  By using this      #
# code you agree to indemnify Matthew M. Wright from any liability that      #
# might arise from it's use.                                                 #
#                                                                            #
# Selling the code for this program without prior written consent is         #
# expressly forbidden.  In other words, please ask first before you try and  #
# make money off of my program.                                              #
##############################################################################

use strict;
use CGI qw(param);
use Crypt::OpenPGP;
use LWP::UserAgent;
use URI::Escape;
use JSON;

# Needed for CGI 4.05+
$CGI::LIST_CONTEXT_WARN = 0;

## RECAPTCHA - user must configure their private key here
my $PRIVATE_KEY = 'your_private_key_goes_here';


# *********** DO NOT EDIT BELOW THIS LINE ********************



my @CONFIG_FIELDS = qw(recipient subject email realname redirect background
                    bgcolor link_color vlink_color print_blank_fields
                    text_color alink_color title print_config return_link_title
                    required sort return_link_url env_report username
                    missing_fields_redirect print_config_to_html 
                    encryption_pubkey encryption_userid encryption_type
                    g-recaptcha-response obscured_fields);

my @DAYS     = qw(Sunday Monday Tuesday Wednesday Thursday Friday Saturday);

my @MONTHS   = qw(January February March April May June July
                  August September October November December);

my $userfile = '.formmail';

my $query    = new CGI;

# Retrieve Date
my $date = &get_date;

#build config hash  
my %CONFIG = &hash_config_data;

#make sure method=post
&error('request_method') 
   if $ENV{'REQUEST_METHOD'} !~ /^POST$/i;

# Check Required Fields
&check_required;

# Check Recipient of mail
&check_recipient;

# Check Recaptcha field
&check_recaptcha if $PRIVATE_KEY &&
   ($PRIVATE_KEY !~ /your_private_key_goes_here/i);

# Send E-Mail
&send_mail;

# Return HTML Page or Redirect User
&return_html;

sub get_date {
   my ($sec,$min,$hour,$mday,$mon,$year,$wday) = localtime();
   return sprintf ("%s, %s, %d, %d at %02d:%02d:%02d",
                    $DAYS[$wday],
                    $MONTHS[$mon],
                    $mday,
                    $year + 1900,
                    $hour,
                    $min,
                    $sec);

}

sub hash_config_data {
    my %hash;
    foreach (@CONFIG_FIELDS) {
        $hash{$_} = $query->param($_) if $query->param($_);
    } 
    
    return %hash;
} #end sub hash_config_data 

sub check_required {

    # ensure that there are no newlines in any fields which  
    # will be used in the header.  
    if ($CONFIG{'subject'} =~ /(\n|\r)/m || $CONFIG{'email'} =~ /(\n|\r)/m ||
        $CONFIG{'realname'} =~ /(\n|\r)/m || $CONFIG{'recipient'} =~ /(\n|\r)/m) {
        &error('invalid_headers');
    }

    # Fix XSS + HTTP Header Injection
    foreach my $f (qw(redirect return_link_url)) {
        # Strip new lines
        $CONFIG{$f} =~ s/(\n|\r)//mg;

        # Only allow certain handlers, to avoid javascript:/data: tricks
        if ($CONFIG{$f} !~ /^\s*\// &&
            $CONFIG{$f} !~ /^\s*(http|https|ftp):\/\//) {
            $CONFIG{$f} = '';
        }
    }

   my @required = split(/,/,$CONFIG{'required'});
   
   push(@required,'g-recaptcha-response') if $PRIVATE_KEY &&
         ($PRIVATE_KEY !~ /your_private_key_goes_here/i);

   my @error_fields;

   foreach (@required) {
       (my $field = $_) =~ s/(^\s+|\s+$)//g; 
       if (!$query->param($field)) { push(@error_fields, $field); } 
   }

   &error('missing_fields',@error_fields) if @error_fields;
}

sub check_recaptcha {
  my $data = "secret=$PRIVATE_KEY&remoteip=$ENV{REMOTE_HOST}" .
             "&response=" . uri_escape($CONFIG{'g-recaptcha-response'});

  my $ua = new LWP::UserAgent;
  my $req = new HTTP::Request 'POST', 'https://www.google.com/recaptcha/api/siteverify';
  $req->content_type('application/x-www-form-urlencoded');
  $req->content($data);
  my $res = $ua->request($req);

  my $resp = JSON->new->decode($res->content);

  # handle bad news
  if ($resp->{success} eq 'false') {
    &error('bad_recaptcha_response');
  } elsif ($resp->{success} eq '') {
    # unknown
    &error('unknown_recaptcha_error');
  }

  # we're good
}

sub check_recipient {
    my $user;
    ($user) = ($ENV{'DOCUMENT_ROOT'} =~ m#/usr/wwws?/users/([a-z0-9_\-]+)#i);
    ($user) = ($ENV{'DOCUMENT_ROOT'} =~ m#/usr/home/([a-z0-9_\-]+)/public_html#i) unless $user;
    $user = $CONFIG{username} unless $user;

    $CONFIG{recipient} =~ s/\s+//g;
    my @recipient = split(/,/, $CONFIG{recipient});

    foreach my $address (@recipient) {
        my ($domain) = ($address =~ /^[^@%!]+\@([A-Za-z0-9\.\-]+)$/) 
            or &error('invalid_recipient');
        &error('bad_recipient') unless ($domain =~ /^pair.com$/i) ||
              &in_rcpt($domain) || &in_userfile($address,$user);
    }

} #end sub check_recipient

sub in_rcpt { 

   my $domain = shift;

   open(FILE,'/var/qmail/control/morercpthosts') || return 0;
   while (<FILE>) { chomp; return 1 if /(^\Q$domain\E$)|(\@\Q$domain\E$)/i; } 
   close(FILE);

   return 0;
} #end sub in_rcpt

sub in_userfile {
    my $address = shift;
    my $user = lc(shift);

    return 0 if $user !~ /^[a-z0-9]+$/;

    open my $FILE, "/usr/home/$user/$userfile" or return 0;
    while (<$FILE>) {
        chomp; 
        return 1 if /^\s*\Q$address\E\s*$/i;
    }

    return 0; 
}

sub return_html {

   if ($CONFIG{'redirect'} =~ m#https?://.+\..+#) {
      # print the redirectional location header.
      print "Location: $CONFIG{'redirect'}\n\n";
   } else {
      $CONFIG{'title'} ||= 'Thank You';
 
      my $body = &body_attributes;  

      print "Content-type: text/html\n\n";
      print <<"      %%%";
      <html>
        <head>
          <title>$CONFIG{'title'}</title>
        </head>
        <body $body>
          <center>
             <h1>$CONFIG{'title'}</h1>
          </center>
          Below is what you submitted to $CONFIG{'recipient'} on $date 
          <p><hr><p>
      %%%

      my @list = &get_fields('html');
      foreach (@list) { print "$_<p>"; }

      print "<p><hr><p>"; 

      if ($CONFIG{print_config_to_html}) {
          print "Config Fields:<br><br>";
          $CONFIG{print_config_to_html} =~ s/\s//g;
          my @print_config = split(/,/,$CONFIG{print_config_to_html});
          foreach (@print_config) {
             print "&nbsp;&nbsp;&nbsp;$_: $CONFIG{$_}<br>" if $CONFIG{$_};
          }
          print "<p><hr><p>";
      }

      # Check for a Return Link
      if ($CONFIG{'return_link_url'} =~ m#https?://.+\..+# && $CONFIG{'return_link_title'}) {
          print <<"          %%%";
          <center>
            <a href=\"$CONFIG{'return_link_url'}\">$CONFIG{'return_link_title'}</a>
          </center>
          %%%
      }
   
      print "</body></html>";
   
   } #end else

} #end sub 

sub send_mail {

   $CONFIG{'subject'} ||= 'WWW form submission';  
   $CONFIG{realname} and $CONFIG{realname} = "($CONFIG{realname})";

   #filter NULL characters and new line
   foreach (qw(subject email realname recipient )) {
      $CONFIG{$_} =~ s/\0|\r|\n//g;
   }
 
   if ($CONFIG{'email'}) {
     ($ENV{'QMAILUSER'},$ENV{'QMAILHOST'}) = split(/@/,$CONFIG{'email'});
   }

   # if encrypting, check for the public key before starting mail
   my $pubring;
   if ($CONFIG{encryption_userid}) {
       my $path = $ENV{REQUEST_URI}|| $ENV{SCRIPT_NAME};

       my ($uname) = ($path =~ m#/cgiwrap/([^\/]+)/#);

       my $default_pubring;
       if ($uname) {
           $default_pubring = "/usr/home/$uname/.pgp/pubring.pkr";
           $default_pubring = "/usr/home/$uname/.gnupg/pubring.gpg"
               if $CONFIG{encryption_type} =~ /gpg/i;
       }

       $pubring = $CONFIG{encryption_pubkey} || $default_pubring;
  
       $pubring or &error('encryption_pubring'); 
       (-e $pubring) or &error('encryption_pubring');
   }

   open(MAIL,"|/var/qmail/bin/qmail-inject") || &error('mail_error');
   print MAIL <<"%%%";
From: $CONFIG{'email'} $CONFIG{'realname'}
To: $CONFIG{'recipient'}
Subject: $CONFIG{'subject'}
X-Posted-From: $ENV{'REMOTE_ADDR'}

%%%

   my $txt = <<"%%%";
Below is the result of your feedback form.
It was submitted by $CONFIG{'email'} $CONFIG{'realname'} on: $date
 
---------------------------------------------------------------------------\n
%%%

   if ($CONFIG{'print_config'}) {
       $CONFIG{'print_config'} =~ s/\s//g;
       my @print_config = split(/,/,$CONFIG{'print_config'});
       foreach (@print_config) { $txt .= "$_: $CONFIG{$_}\n\n" unless !$CONFIG{$_}; }
       $txt .= "------------------------- end config fields ----------------------------\n\n";
   }

   my @list = &get_fields;
   $txt .= "$_\n\n" for @list;

   $txt .= "---------------------------------------------------------------------------\n";

   # Send Any Environment Variables To Recipient.
   $CONFIG{'env_report'} =~ s/\s//g;
   my @env_report = split(/,/,$CONFIG{'env_report'});
   $txt .= "$_: $ENV{$_}\n" for @env_report;

   if ($CONFIG{encryption_userid}) {
       my $pgp = Crypt::OpenPGP->new(PubRing => $pubring);

       $pgp or error('crypt_error');

       my $ciphertext = $pgp->encrypt(
              Data       => $txt,
              Recipients => $CONFIG{encryption_userid},
              Armour     => 1,
       );
  
       $ciphertext or error('crypt_error');

       $txt = $ciphertext;
   }

   print MAIL $txt;
   close(MAIL);
}

sub get_fields {
    my $format = shift;

    my @list;
    my @sort_order;

    $_ = $CONFIG{'sort'};
    if (/alphabetic/) {  #sort fields and push them
        @sort_order = sort $query->param;
    } elsif (s/^order://) {
        my %done;
        my @order = split (/,/, $_);
        foreach (@order) {
            (my $field = $_) =~ s/(^\s+|\s+$)//g; 
            push(@sort_order,$field);
        }
        @done{@sort_order} = @sort_order;
        push @sort_order, grep {!$done{$_}} $query->param;
    } else {
        @sort_order = $query->param;
    }

    # obscure specific fields for html output
    my %obscured; 
    %obscured = map {$_,1} split(/\s*,\s*/, $CONFIG{obscured_fields})
        if $format eq 'html' and $CONFIG{obscured_fields};

    foreach my $field (@sort_order) {
        my $val;
        foreach my $value ($query->param($field)) {
            $val .= " $value";
        }
        next if (!$CONFIG{'print_blank_fields'} && (!$val || $val =~ /^\s+$/));

        $val =~ s/./*/g if $obscured{$field};

        push(@list, "$field: $val") unless ($CONFIG{$field} or 
                                           ($field eq 'print_blank_fields'));
    }                                      #in case someone sets p_b_f = 0

    return @list;
 
} #end sub sort_list

sub error {

    my ($error,@error_fields) = @_;

    my %titles = ('bad_recipient'    => 'Bad Recipient',
                 'file_unopened'     => 'Unable to open file',
                 'request_method'    => 'Request Method',
                 'missing_fields'    => 'Missing Fields',
                 'invalid_headers'   => 'Invalid Header Fields',
                 'encryption_pubring' => 'Public Key ERROR',
                 'crypt_error'       => 'Error encrypting mail',
                 'mail_error'        => 'Error sending mail',
                 'invalid_recipient' => 'Invalid Recipient',
                 'bad_recaptcha_response' => 'Incorrect RECAPTCHA',
                 'unknown_recaptcha_error' => 'Unknown RECAPTCHA Error'
                );
    my $body = &body_attributes;

    if (($error eq 'missing_fields') &&
        ($CONFIG{'missing_fields_redirect'} =~ m#https?://.+\..+#)) {
        # print the redirectional location header.
        print "Location: $CONFIG{'missing_fields_redirect'}\n\n";
    } else {
        print "Content-type: text/html\n\n";
        print <<"        %%%";
        <html>
          <head>
            <title>$titles{$error}</title>
          </head>
          <body $body>
            <center><table width=700><tr><td align=center>
            <h1>Error: $titles{$error}</h1>
            </td></tr><tr><td>
        %%%

        if ($error eq 'bad_recipient') {
            print <<"            %%%";
            One of the recipients of the information on this form is
            not a customer of pair Networks or is not currently configured
            as a valid recipient. Sorry.
            %%%
         } elsif ($error eq 'invalid_recipient') {
            print <<"            %%%";
            One of the recipients of the information on this 
            form is not valid.
            %%%
        } elsif ($error eq 'file_unopened') {
            print "No way to determine if recipient is valid. \n";
        } elsif ($error eq 'request_method') {
            print <<"            %%%";
            The Request Method of the Form you submitted did not match
            POST. Please check the form, and make sure that method=POST.
            <p><hr><p>
            <center>
              <a href=\"$ENV{'HTTP_REFERER'}\">Back to the Submission Form</a>
            </center>
            %%%
        } elsif ($error eq 'missing_fields') {
            print <<"            %%%";
            The following fields were left blank in your submission form:<p>
            <ul>
            %%%
            foreach my $missing_field (@error_fields) {
               print "<li>$missing_field\n";
            }
            print <<"            %%%";
            </ul>
            <p><hr><p>
            These fields must be filled out before you can successfully submit
            the form.  Please return to the
            <a href=\"$ENV{'HTTP_REFERER'}\">Fill Out Form</a> and try again.
            %%%
        } elsif ($error eq 'encryption_pubring') {
            print <<"            %%%";
               I couldn't find your public key for encrypting the message. 
               Make sure the path is correct and that it exists.
            %%%
        } elsif ($error eq 'bad_recaptcha_response') {
            print <<"            %%%";
            The RECAPTCHA response you typed was incorrect.   Please back
            up and try again.
            %%%
        } elsif ($error eq 'unknown_recaptcha_error') {
            print <<"            %%%";
            An unknown error occurred when checking the RECAPTCHA.  Please
            back up and try again.
            %%%
        } elsif ($error eq 'crypt_error') {
            print <<"            %%%";
            An unknown error occurred trying to encrypt the form.  Please
            check your configuration and try again.
            %%%
        } elsif ($error eq 'invalid_headers') {
            print <<"            %%%";
            One or more of the header fields, <tt>recipient</tt>, <tt>email</tt>, 
            <tt>realname</tt> or <tt>subject</tt>, were filled in with invalid 
            values. You may not include any newline characters in these parameters.
            %%%
        }
        print "</td></tr></table></center></body></html>";
    } 
    exit;
}

sub body_attributes {

   my $body;

   # Check for Background Color
   $body .= qq/ bgcolor="$CONFIG{'bgcolor'}"/
       if $CONFIG{'bgcolor'};

   # Check for Background Image
   $body .= qq/ background="$CONFIG{'background'}"/
       if $CONFIG{'background'} =~ /http\:\/\/.*\..*/;

   # Check for Link Color
   $body .= qq/ link="$CONFIG{'link_color'}"/
       if $CONFIG{'link_color'};

   # Check for Visited Link Color
   $body .= qq/ vlink="$CONFIG{'vlink_color'}"/
       if $CONFIG{'vlink_color'};

   # Check for Active Link Color
   $body .= qq/ alink="$CONFIG{'alink_color'}"/
       if $CONFIG{'alink_color'};

   # Check for Body Text Color
   $body .= qq/ text="$CONFIG{'text_color'}"/
       if $CONFIG{'text_color'};

   return $body;
}
