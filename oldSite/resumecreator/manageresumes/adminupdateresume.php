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

  $ID = -1;
  if(is_numeric($_GET['id']) == true) {
	$ID = $_GET['id'];
  }
  else {
	header_setTitle("id is not valid");
	generateHeader();
	echo "id passed by the URL is not valid<br />";
	generateFooter();
	die();
  }

  $userID = $_SESSION['userID'];

  if( (isset($_POST['cancel']) == true) && (strcmp($_POST['cancel'], "Cancel") == 0) ) {
        header('Location: ./adminlistresumes.php');
        die();
  }

  if( (isset($_POST['update_Resume']) == true) && (strcmp($_POST['update_Resume'], "Update Resume") == 0) ) {
	/*
	 * The following section removes all HTML or simular tags from the fields
	 */
	$firstName                 = ereg_replace("<[^<>]*>", "", $_POST['firstName']);
	$lastName                  = ereg_replace("<[^<>]*>", "", $_POST['lastName']);
        $perminantAddress          = ereg_replace("<[^<>]*>", "", $_POST['perminantAddress']);
	$currentAddress            = ereg_replace("<[^<>]*>", "", $_POST['currentAddress']);
        $perminantPhone            = ereg_replace("<[^<>]*>", "", $_POST['perminantPhone']);
        $currentPhone              = ereg_replace("<[^<>]*>", "", $_POST['currentPhone']);
	$email                     = ereg_replace("<[^<>]*>", "", $_POST['email']);
        $objective                 = ereg_replace("<[^<>]*>", "", $_POST['objective']);
        $schools                   = ereg_replace("<[^<>]*>", "", $_POST['schools']);
	$major                     = ereg_replace("<[^<>]*>", "", $_POST['major']);
	$expectedGraduationDate    = ereg_replace("<[^<>]*>", "", $_POST['expectedGraduationDate']);
        $awards                    = ereg_replace("<[^<>]*>", "", $_POST['awards']);
        $employment                = ereg_replace("<[^<>]*>", "", $_POST['employment']);
        $strengths                 = ereg_replace("<[^<>]*>", "", $_POST['strengths']);
	$publications              = ereg_replace("<[^<>]*>", "", $_POST['publications']);
	$volunteerActivities       = ereg_replace("<[^<>]*>", "", $_POST['volunteerActivities']);	

	$sql = "UPDATE `Resumes` 
		   SET
			`firstName`='$firstName', 
			`lastName`='$lastName',
			`perminantAddress`='$perminantAddress', 
			`currentAddress`='$currentAddress',
			`perminantPhone`='$perminantPhone',
			`currentPhone`='$currentPhone',
			`email`='$email', 
			`objective`='$objective',
			`schools`='$schools',
			`major`='$major',
			`expectedGraduationDate`='$expectedGraduationDate',
			`awards`='$awards',
			`employment`='$employment',
			`strengths`='$strengths',
			`publications`='$publications',
			`volunteerActivities`='$volunteerActivities'
		WHERE (`id`='$ID')
	";
	db_get($sql);

	header('Location: adminlistresumes.php');
	die();
  }

  $resume = "";
  $sql = "
	SELECT * FROM `Resumes` WHERE (`id`='$ID')
  ";
  $result = db_get($sql);
  if(@mysql_num_rows($result) == 1) {
	$resume = mysql_fetch_assoc($result);
  }
  else {
	header_setTitle("Resume not found");
	generateHeader();
	echo "could not find your resume, you might need to create one.<br />";
	generateFooter();
	die();
  }

  header_setTitle("Update Resume");
  generateHeader();
?>
  <form name='updateresume' action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php ehco $ID?>" method='post'>
 <center>
 <h2><font color=''>Notice:</font></h2>
  HTML tags are allowed, and will be removed when being inserted into the database.<br />
  White spaces in the text will be upheld and may be used to space items to desired locations.<br />
  <font color='orange'>*Resumes can't be over 2 pages.*</font><br />
 </center>      
 <br />
   <table width='100%'>
  <tr>
   <td nowrap='true' valign='top'><strong>Your First Name: </strong></td>
   <td nowrap='true'><input name='firstName' value='<?php echo $resume['firstName']?>' size='25' /></td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Your Last Name: </strong></td>
   <td nowrap='true'><input name='lastName' value='<?php echo $resume['lastName']?>' size='25' /></td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Current Address: </strong></td>
   <td nowrap='true' width='100%'><textarea name='currentAddress' rows='7' cols='60'><?php echo $resume['currentAddress']?></textarea></td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Alternate Address: </strong></td>
   <td nowrap='true' width='100%'><textarea name='perminantAddress' rows='7' cols='60'><?php echo $resume['perminantAddress']?></textarea></td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Current Phone: </strong></td>
   <td nowrap='true' width='100%'><input name='currentPhone' value='<?php echo $resume['currentPhone']?>' /> (541) 123-4567 (cell)</td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Alternate Phone: </strong></td>
   <td nowrap='true' width='100%'><input name='perminantPhone' value='<?php echo $resume['perminantPhone']?>' /> (503) 123-4567 (work)</td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Email: </strong></td>
   <td nowrap='true' width='100%'><input name='email' value='<?php echo $resume['email']?>' size='40' /> name@domain.com</td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Objective: </strong></td>
   <td nowrap='true' width='100%'><textarea name='objective' rows='7' cols='60'><?php echo $resume['objective']?></textarea></td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Education: </strong></td>
   <td nowrap='true' width='100%'><textarea name='schools' rows='2' cols='60'><?php echo $resume['schools']?></textarea></td>
   <td valign='top'>
    University of Washington -- 1999-2001<br />
    Oregon State University -- 2001-2005
   </td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Major: </strong></td>
   <td nowrap='true' width='100%'><input name='major' value='<?php echo $resume['major']?>' /> Computer Science</td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Expected Graduation Date: </strong></td>
   <td nowrap='true' width='100%'><input name='expectedGraduationDate' value='<?php echo $resume['expectedGraduationDate']?>' /> (2005-06-30) or (June 2005)</td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Skills: </strong></td>
   <td nowrap='true' width='100%'><textarea name='strengths' rows='7' cols='60'><?php echo $resume['strengths']?></textarea></td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Work Experience: </strong></td>
   <td nowrap='true' valign='top'><textarea name='employment' rows='17' cols='70'><?php echo $resume['employment']?></textarea></td>
   <td nowrap='true'>
2004-present &nbsp; &nbsp; &nbsp; Company 3 &nbsp; &nbsp; &nbsp; &nbsp;Portland, Oregon<br />
 &nbsp; &nbsp; &nbsp;Lead Software Developer<br />
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; * Organized Several Projects from conception to delivery<br />
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; * Develop Testing strategies for given projects<p></p>
<br />
2002-2003 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Company 2 &nbsp; &nbsp; &nbsp; &nbsp;San Francisco, California<br />
 &nbsp; &nbsp; &nbsp;Software Engineer<br />
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; * Coordinate development timeline for projects<br />
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; * Wrote Specification and Requirement documents<p></p>
<br />
2001-2002 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Company 1 &nbsp; &nbsp; &nbsp; &nbsp;Corvallis, Oregon<br />
 &nbsp; &nbsp; &nbsp;Web Developer<br />
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; * Developed web applications using the .NET Framework<br />
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; * Communicated with company clients to obtain specifications on web application
   </td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Volunteer Activities: </strong></td>
   <td nowrap='true' ><textarea name='volunteerActivities' rows='7' cols='60'><?php echo $resume['volunteerActivities']?></textarea></td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Publications: </strong></td>
   <td nowrap='true' ><textarea name='publications' rows='7' cols='60'><?php echo $resume['publications']?></textarea></td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Awards: </strong></td>
   <td nowrap='true' width='100%'><textarea name='awards' rows='7' cols='60'><?php echo $resume['awards']?></textarea></td>
  </tr>
   </table>
   <br />
   <input type='submit' name='update_Resume' value='Update Resume' /> <input type='submit' name='cancel' value='Cancel' />
  </form>
<?php
  generateFooter();
?>
