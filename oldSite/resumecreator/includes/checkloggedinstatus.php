<?php
  /**
   * Date: February 15, 2005
   * Author: Sean P. Jensen
   * Copyright: Copyright 2005, Association for Computing Machinery, Oregon State University
   *
   */
?>
<?php
  /*
   * This page is responsible for:
   *   * Checking to see if the user is logged in
   *     - If not redirecting them to the user login page
   *
   */
  session_start();
  require_once dirname(__FILE__)."/database.php";

  /*
   * The first step in seeing if the user is logged in is to see if
   *    the username session variable is set.
   */
  if(isset($_SESSION['username']) == true) {
	$username = mysql_escape_string($_SESSION['username']);
	$sql = "SELECT * FROM `userAccounts` WHERE (`username`='$username')";
	$result = db_get($sql);

	/*
	 * If we don't get a result then we didn't find them in the database,
	 *    which means that they've not created a user account, which then
	 *    means that they have not logged in.
	 */
	if($result) {
		$userAccount = mysql_fetch_assoc($result);
		
		/*
		 * We now check to see if the password that we md5 encrypted into a
		 *    session variable is identical to the one we pulled out from the
		 *    database and then md5 encrypted
		 */
		if(strcmp(md5($userAccount['password']), $_SESSION['password']) != 0) {
			gotoLoginPage();
		}
	}
	else {
		gotoLoginPage();
	}
  }
  else {
	gotoLoginPage();
  }

  /*
   * User is not logged in, redirect them to the user login page.
   */
  function gotoLoginPage() {
	header('Location: http://groups.engr.oregonstate.edu/acm/resumecreator/login.php');
	die();
  }
?>
