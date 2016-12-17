<?php if (!defined('PmWiki')) exit();
##  This is a sample config.php file.  To use this file, copy it to 
##  local/config.php, then edit it for whatever customizations you want.
##  Also, be sure to take a look at http://www.pmichaud.com/wiki/Cookbook
##  for more details on the types of customizations that can be added
##  to PmWiki.

##  $WikiTitle is the name that appears in the browser's title bar
$WikiTitle = 'Oregon State University Association for Computing Machinery
(ACM)';

##  $ScriptUrl is your preferred URL for accessing wiki pages
##  $PubDirUrl is the URL for the pub directory.
# $ScriptUrl = 'http://www.mydomain.com/path/to/pmwiki.php';
# $PubDirUrl = 'http://www.mydomain.com/path/to/pub';

 # Specifies the name of the template file to be used to generate pages. 
 $PageTemplateFmt = 'pub/skins/beeblebrox-gila/gila.tmpl';
 
 # The HTML code to be generated for the page logo.
 $PageLogoFmt = "<a href='$ScriptUrl'>OSU<span>ACM</span></a><br />
  <span id='tag'>Oregon State University Association for Computing Machinery</span>";

##  If your system is able to display the home page but gives
##  "404 Not Found" errors for all others, try setting the following:
# $EnablePathInfo = 0;

##  $PageLogoUrlFmt is the URL for a logo image--you can change this to
##  your own logo if you wish.
$PageLogoUrl = '$PubDirUrl/acm_logo94.gif';

##  Set $SpaceWikiWords if you want WikiWords to automatically have
##  spaces before each sequence of capital letters
# $SpaceWikiWords = 1;			   # turns on WikiWord spacing

##  If you want uploads enabled on your system, set $EnableUpload=1.
##  You'll also need to set a default upload password, or else set
##  passwords on individual groups and pages.  For more information see
##  PmWiki.UploadsAdmin and PmWiki.PasswordsAdmin.
$EnableUpload = 1;
$DefaultPasswords['edit']   = crypt('acm');
$DefaultPasswords['upload'] = crypt('acm-upload');
$UploadMaxSize = 1000000;


##  If you seem to be having trouble getting passwords to work, try
##  the following:
# include_once('scripts/sessionauth.php');

##  By default, PmWiki doesn't allow browsers to cache pages.  Setting
##  $EnableIMSCaching=1; will re-enable browser caches in a smart manner.
##  However, you may want to have caching disabled while adjusting
##  configuration files or layout templates.
# $EnableIMSCaching = 1;

##  By default PmWiki is configured such that only the first occurrence
##  of 'PmWiki' in a page is treated as a WikiWord.  If you want to 
##  restore 'PmWiki' to be treated like other WikiWords, uncomment the 
##  line below.
# unset($WikiWordCount['PmWiki']);

##  If you want to disable all WikiWords (leaving only {{free links}} and
##  [[WikiWord text]] markup), set $WikiWordCountMax=0.  If you want
##  only the first occurrence of each WikiWord to be treated as a link,
##  set $WikiWordCountMax=1.
# $WikiWordCountMax=0;                     # disables all WikiWords
# $WikiWordCountMax=1;                     # converts only first WikiWord

##  Many other features of PmWiki can be enabled (1) or disabled (0)
##  by setting variables below.  These are defined in and controlled by
##  the scripts/stdconfig.php script.
# $EnableQATags=1;                         # Q: and A: Markup (default on)
# $EnableWikiTrails=1;			   # WikiTrails (default on)
# $EnableStdWikiStyles=1;		   # standard WikiStyles (default on)
##  or, to turn off all of the optional features, use
# $EnableStdConfig=0;			   # 0 disables all optional features

## $DiffKeepDays specifies the minimum number of days to keep a page's
## revision history.  The default is 3650 (approx 10 years).
# $DiffKeepDays=30;                        # keep page history at least 30 days
?>
