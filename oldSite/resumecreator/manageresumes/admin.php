<?php
  /**
   * Date: February 15, 2005
   * Author: Sean P. Jensen
   * Copyright: Copyright 2005, Association for Computing Machinery, Oregon State University
   *
   */
?>
<?php
  session_start();
  require_once dirname(__FILE__)."/../includes/database.php";
  require_once dirname(__FILE__)."/../includes/checkloggedinstatus.php";
  require_once dirname(__FILE__)."/header.php";
  require_once dirname(__FILE__)."/footer.php";

  // grab User id
  $userID = $_SESSION['userID'];

  // Check to see if the user is an Administrator
  $sql = " SELECT * FROM userAccounts WHERE (`id`='$userID')";
  $result = db_get($sql);
  $row = mysql_fetch_assoc($result);
  if(strcmp($row['username'], "admin") != 0) {
	header('Location: ./index.php');
	die();
  }

  header_setTitle("Manage EECS Resumes");
  generateHeader();
?>
  <table>
   <tr>
    <td valign='top' align='left' width='150px'>
     <a href='adminlistresumes.php'>List</a><br />
     <br />
    </td>
    <td valign='top' align='left'>
     This tool creates a table seperating the resumes onto different row, from where one can:<br />
      * view the resume as a PDF file<br />
      * edit the resume<br />
      * delete the resume all together<br />
    </td>
   </tr>
   <tr>
    <td valign='top' align='left'>
     <a href='admin_generate_PDF_of_all_resumes.php'>Generate</a><br />
     <br />
    </td>
    <td valign='top' align='left'>
     <br />
     This tool generates a single PDF file with all the resumes on a page of thier own.<br />
     This is very useful when you are wanting to print all the resumes all at once.<br />
     <font color='blue'>Notice:</font> This may take a long time, please be patient.<br />
    </td>
   </tr>
  </table>
<?php
  generateFooter();
?>
