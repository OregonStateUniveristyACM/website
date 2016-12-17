<?php
  /**
   * Date: February 15, 2005
   * Author: Sean P. Jensen
   * Copyright: Copyright 2005, Association for Computing Machinery, Oregon State University
   *
   * Modified: Christopher A. Haller 
   * Date Modified: 2 October 2005
   */
?>
<?php
  /* 
   * This allows us to stop people from creating resumes
   *  -- You can just comment out the following lines the next time
   *     this application is needed.
   */

?>
<!-- To Disable resume creator, enable the text below that is commented out and re-enable the die(); command to
stop the page from total construction.-->


<!--
<html>
 <head>
  <title>Resume Creator</title>
 </head>
 <body bgcolor='#777777'>
  <table width='100%'>
   <tr>
    <td align='center' valign='top' width='100%'>
     <br />
     <font size='+4'>Welcome to Resume Creator</font><br />
     The purpose of this form is to create a standard resume that the EECS department can use when building resume books.<br />
     <br />
     <br />
     Currently the Resume Books have been printed so we can no longer accept anymore resumes, but you are more than welcome to access a resume that you have already created.
     <br />
     <br />
     Already created a resume? <br />
     You can <a href='login.php'>login</a> and view it.<br />
    </td>
   </tr>
  </table>
  <br />
  <br />
 </body>
</html>
-->


<?php

 /*
 *
 *  die();
 *
 */

?>


<?php  
  session_start();
  require_once dirname(__FILE__)."/includes/database.php";
  include_once dirname(__FILE__)."/includes/common.php";

  $userID = -1;

  if( (isset($_POST['create_Resume']) == true) && (strcmp($_POST['create_Resume'], "Create Resume") == 0) ) {
	$accountCreated = false;
	$notCreatingAccount = false;
	$errorMessage = "";
	
	if( (isset($_POST['createAccount']) == true) && (strcmp($_POST['createAccount'], "true") == 0) ) {
		$username = $_POST['username'];
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		$accountCreated = createUserAccount($username, $password1, $password2, &$errorMessage, &$userID);
	}
	else {
		$notCreatingAccount = true;
	}

	if( ($accountCreated == true) || ($notCreatingAccount == true) ) {
		/*
		 * This section of code removes all HTML or simular tags from the variables
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

		$sql = "INSERT INTO Resumes (
					`id`,
					`userID`,
					`firstName`, 
					`lastName`,
					`perminantAddress`, 
					`currentAddress`,
					`perminantPhone`,
					`currentPhone`,
					`email`, 
					`objective`,
					`schools`,
					`major`,
					`expectedGraduationDate`,
					`awards`,
					`employment`,
					`strengths`,
					`publications`,
					`volunteerActivities`) 
				VALUES (
					'',
					'$userID',
					'$firstName', 
					'$lastName',
					'$perminantAddress', 
					'$currentAddress',
					'$perminantPhone',
					'$currentPhone',
					'$email', 
					'$objective',
					'$schools',
					'$major',
					'$expectedGraduationDate',
					'$awards',
					'$employment',
					'$strengths',
					'$publications',
					'$volunteerActivities')
		";

		db_get($sql);
		if($notCreatingAccount == true) {
			echo "Resume created.<br />";
			die();
		}
		else if( ($notCreatingAccount == false) && ($accountCreated == true) ) {
			$_SESSION['userID'] = $userID;
			$_SESSION['username'] = $username;
			$_SESSION['password'] = md5($password1);

			header('Location: manageresumes/index.php');
			die();
		}
	}
  }

?>
<html>
 <head>
  <title>Resume Creator</title>
 </head>
 <body bgcolor='#777777'>
<table width='100%'>
 <tr>
  <td align='center' valign='top' width='100%'>
   <br />
   <font size='+4'>Welcome to Resume Creator</font><br />
   The purpose of this form is to create a standard resume that the EECS department can use when building resume books.<br />
   <br />
   <br />

 Already created a resume? <br />
      You now can <a href='login.php'>login</a> and update it.<br />

  </td>
  </td>
 </tr>
</table>
<br />
<br />
<form name='createresume' action="<?php echo $_SERVER['PHP_SELF']?>" method='post'>
 <center>
 <font size='+3' color=''>Notice:</font><br />
  HTML tags are not allowed, and will be removed when being inserted into the database.<br />
  White spaces in the text will be upheld and may be used to space items to desired locations.<br />
  <font color='orange'>*Resumes can't be over 2 pages.*</font><br />
 </center>
<p> </p>
<?php
  if( (isset($accountCreated) == true) && ($accountCreated == false) ) {
	echo "<font size='+2' color='red'>Error occured please review your information for warnings.</font><br />";
  }
?>
 <table  border='0'>
  <tr>
   <td nowrap='true' valign='top'><strong>Your First Name: </strong></td>
   <td nowrap='true'><input name='firstName' value='<?php echo $_POST['firstName']?>' size='25' /></td>
  </tr>
  <tr>                  
   <td nowrap='true' valign='top'><strong>Your Last Name: </strong></td>
   <td nowrap='true'><input name='lastName' value='<?php echo $_POST['lastName']?>' size='25' /></td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Current Address: </strong></td>
   <td nowrap='true' ><textarea name='currentAddress' rows='4' cols='60'><?php echo $_POST['currentAddress']?></textarea></td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Alternate Address: </strong></td>
   <td nowrap='true' ><textarea name='perminantAddress' rows='4' cols='60'><?php echo $_POST['perminantAddress']?></textarea></td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Current Phone: </strong></td>
   <td nowrap='true' ><input name='currentPhone' value='<?php echo $_POST['currentPhone']?>' /> (541) 123-4567(cell)</td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Alternate Phone: </strong></td>
   <td nowrap='true' ><input name='perminantPhone' value='<?php echo $_POST['perminantPhone']?>' /> (503) 123-4567(work)</td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Email: </strong></td>
   <td nowrap='true' ><input name='email' value='<?php echo $_POST['email']?>' size='40' /> name@domain.com</td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Objective: </strong></td>
   <td nowrap='true' ><textarea name='objective' rows='2' cols='60'><?php echo $_POST['objective']?></textarea></td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Education: </strong></td>
   <td nowrap='true' ><textarea name='schools' rows='2' cols='60'><?php echo $_POST['schools']?></textarea></td>
   <td valign='top' nowrap='true'>
    University of Washington -- 1999-2001<br />
    Oregon State University -- 2001-2005
   </td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Major: </strong></td>
   <td nowrap='true' ><input name='major' value='<?php echo $_POST['major']?>' /> Computer Science</td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Expected Graduation Date: </strong></td>
   <td nowrap='true' ><input name='expectedGraduationDate' value='<?php echo $_POST['expectedGraduationDate']?>' /> (2005-06-30) or (June 2005)</td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Technical Skills: </strong></td>
   <td nowrap='true' ><textarea name='strengths' rows='7' cols='60'><?php echo $_POST['strengths']?></textarea></td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Work Experience: </strong></td>
   <td nowrap='true' valign='top'><textarea name='employment' rows='18' cols='60'><?php echo $_POST['employment']?></textarea></td>
   <td nowrap='true' valign='top'>
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
   <td nowrap='true' ><textarea name='volunteerActivities' rows='7' cols='60'><?php echo $_POST['volunteerActivities']?></textarea></td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Publications: </strong></td>
   <td nowrap='true' ><textarea name='publications' rows='7' cols='60'><?php echo $_POST['publications']?></textarea></td>
  </tr>
  <tr>
   <td nowrap='true' valign='top'><strong>Awards: </strong></td>
   <td nowrap='true' ><textarea name='awards' rows='7' cols='60'><?php echo $_POST['awards']?></textarea></td>
  </tr>
 </table>
  <h2>To be able to go back and update your resume you must create an account</h2>
  <input type='radio' name='createAccount' value='true' checked='true' /> Create account<br />
  <input type='radio' name='createAccount' value='false' /> Don't create an account<br />
  <br />
<?php
   echo $errorMessage;
?>
   <table>
    <tr>
     <td>Username:</td>
     <td><input type='text' name='username' value='<?php echo $username?>' /></td>
    </tr>
    <tr>
     <td>Password:</td>
     <td><input type='password' name='password1' value='<?php echo $password1?>' /></td>
    </tr>
    <tr>
     <td>Re-type Password:</td>
     <td><input type='password' name='password2' value='<?php echo $password2?>' /></td>
    </tr>
   </table>
   <br />
   <input type='submit' name='create_Resume' value='Create Resume' /> 
</form>
</body>
</html>
<?php
//  generateFooter();
?>
