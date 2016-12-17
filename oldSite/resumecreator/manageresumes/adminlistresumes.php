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

  $resumeCreated = false;
  // grab Resume id
  $userID = $_SESSION['userID'];

  // Check to see if the user is an Administrator
  $sql = " SELECT * FROM userAccounts WHERE (`id`='$userID')";
  $result = db_get($sql);
  $row = mysql_fetch_assoc($result);
  if(strcmp($row['username'], "admin") != 0) {
        header('Location: ./index.php');
        die();
  }

  if(isset($_GET['deleteresumeid']) == true) {
	if( (isset($_GET['reallydeleteresume']) == true) && (strcmp($_GET['reallydeleteresume'], "true") == 0) ) {
		$sql = "
			DELETE FROM `Resumes` WHERE (`id`='$_GET[deleteresumeid]')
		";
		db_get($sql);
		

		header('Location: '.basename(__FILE__));
		die();
		
	}
	else {
		header_setTitle("Preparing to delete a resume!!");
		generateHeader();
?>
		<h2>Preparing to delete a resume!</h2>	
		If this was an accident, don't worry the resume has not been deleted yet.<br />
		Just hit the Cancel link down below and noone will ever know you did this.<br /><br />

		To delete the resume <a href='<?php echo $_SERVER['PHPSELF']?>?deleteresumeid=<?php echo $_GET['deleteresumeid']?>&amp;reallydeleteresume=true'>click here</a><br />
		<br />
		<br />
		Otherwise <a href='<?php echo basename(__FILE__)?>'>Cancel</a>
<?php
		generateFooter();
		die();
	}
  }

  header_setTitle("Listing of Resumes");
  generateHeader();
  echo "<font size='+2'>Notice:</font><br /><font size='+1'>Please check to make sure all resumes fit onto at most two pages, by viewing it as a pdf file.</font><br /><br />";
?>
  <table border='1'>
   <tr>
    <th>User's Name</th><th>View User's Resume</th><th>Edit User's Resume</th><th>Delete Resume</th>
   <tr>
<?php
	$sql = "SELECT * FROM Resumes ORDER BY lastName ASC, firstName ASC";
        $result = db_get($sql);

	while($row = mysql_fetch_assoc($result)) {
		echo "
			<tr>
			 <td>$row[lastName], $row[firstName]</td>
			 <td><a href='adminviewresume.php?id=$row[id]'>view as PDF file</a></td>
			 <td><a href='adminupdateresume.php?id=$row[id]'>edit resume</a></td>
			 <td><a href='$_SERVER[PHPSELF]?deleteresumeid=$row[id]'>Delete Resume</a></td>
			</tr>
		";
	}
?>
  </table>
<?php
  generateFooter();
?>
