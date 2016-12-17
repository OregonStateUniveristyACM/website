<?php
  /**
   * Date: February 15, 2005
   * Author: Sean P. Jensen
   * Copyright: Copyright 2005, Association for Computing Machinery, Oregon State University
   *
   */
?>
<?php
  $pageTitle = "Resume Creator";


  function generateHeader() {
	global $pageTitle;
?>
<html>
 <head>
  <title><?php echo $pageTitle?></title>
 </head>
 <body bgcolor='#777777'>
  <table>
   <tr>
    <td valign='top' align='left' nowrap='true' width='75px'>
     <br />
     <hr />
     <a href='index.php'>Home</a><br />
     <hr />
     <a href='logout.php'>Logout</a><br />
     <hr />
    </td>
    <td valign='top' align='left' nowrap='true'>
<?php
  }

  function header_setTitle($str) {
	global $pageTitle;
	$pageTitle = $str;
  }
