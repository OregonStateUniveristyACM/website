<?php
  /**
   * Date: February 15, 2005
   * Author: Sean P. Jensen
   * Copyright: Copyright 2005, Association for Computing Machinery, Oregon State University
   *
   */
?>
<?php
  require_once dirname(__FILE__)."/../includes/database.php";
  require_once dirname(__FILE__)."/../includes/checkloggedinstatus.php";
  require_once dirname(__FILE__)."/header.php";
  require_once dirname(__FILE__)."/footer.php";

  // grab Resume id
  $userID = $_SESSION['userID'];

  // Check to see if the user is an Administrator
  $sql = " SELECT * FROM userAccounts WHERE (`id`='$userID')";
  $result = db_get($sql);
  $row = mysql_fetch_assoc($result);
  if(strcmp($row['username'], "admin") == 0) {
	header('Location: ./admin.php');
	die();
  }

  // Try and grab the resume the user created. If we can't locate it then we must assume they haven't created one yet.
  $sql = "SELECT Resumes.*, userAccounts.username FROM Resumes LEFT JOIN userAccounts ON Resumes.userID=userAccounts.id WHERE (`userID`='$userID')";
  $result = db_get($sql);
  if(mysql_num_rows($result) > 0) {
	$resume = mysql_fetch_assoc($result);
  }
  else {
	header_setTitle("Manage Resume");
	generateHeader();
	echo "
		<font color='red'>Error Occured</font><br />
		Unable to locate resume.
	";
	generateFooter();
	die();
  }

  
  header_setTitle("Manage Resume");
  generateHeader();
  echo "
	<font color='orange'><font size='+2'><strong>Notice:</strong></font> Please check to make sure your resume fits onto at most two pages, by viewing it as a pdf file.</font><br /><br />
	<a href='viewresume.php?id=$resume[id]'>View</a> Resume in PDF format<br />
	<a href='updateresume.php?id=$resume[id]'>Update</a> your resume<br />
  ";

  generateFooter();
?>
