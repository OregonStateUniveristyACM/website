<?php
  /**
   * Date: February 15, 2005
   * Author: Sean P. Jensen
   * Copyright: Copyright 2005, Association for Computing Machinery, Oregon State University
   *
   */
?>
<?php
  require_once dirname(__FILE__)."/database.php";

  /*
   * Creates a user account and checks to see if there are any problems as well
   *  Variables:
   *    username:     The desired username the user wishes to have
   *    password1:    The password the user has chosen
   *    password2:    The password which was retyped by the user
   *    errorMessage: Any errors that occur are sent here
   *    userID:       The unique ID the user now has
   */
  function createUserAccount($username, $password1, $password2, $errorMessage, $userID) {
	  $error = false;
	  $username = mysql_escape_string($username);
	  $password1 = mysql_escape_string($password1);
	  $password2 = mysql_escape_string($password2);

  	if(strcmp($password1, $password2) != 0) {
		$errorMessage = "<font color='red'>Passwords do not match</font>";
		return false;
	}
	if(strlen($username) < 5) {
		$error = true;
		$errorMessage = "<font color='red'>Username is shorter than or equal to 5 characters</font>";
		return false;
	}
	else if( (strlen($password1) < 5) || (strlen($password2) < 5) ) {
		$error = true;
                $errorMessage = "<font color='red'>Password is shorter than or equal to 5 characters</font>";
		return false;
        }

	$sql = "SELECT * FROM `userAccounts` WHERE (`username`='$username')";
	$result = db_get($sql);
	if(mysql_num_rows($result) > 0) {
		$error = true;
		$errorMessage = "<font color='red'>Username is already in use, please choose something else.</font>";
		return false;
	}

	$sql = "
		INSERT INTO `userAccounts` (`id`, `username`, `password`) VALUES ('', '$username', '$password1')
	";

	db_get($sql);
	$id = mysql_insert_id();
	if($id > 0) {
		$errorMessage = "";
		$userID = $id;
		
		return true;
	}
	else {
		$errorMessage = "Some kind of error occured and was unable to insert the user into the database<br />";
		return false;
	}
  }
?>
