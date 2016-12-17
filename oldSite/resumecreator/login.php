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
  require_once dirname(__FILE__)."/includes/database.php";

  $error = false;
  $errorMessage = "";
  $username = mysql_escape_string($_POST['username']);
  $password = mysql_escape_string($_POST['password']);

  if( (isset($_POST['login']) == true) && (strcmp($_POST['login'], "Login") == 0) ) {

	$sql = "SELECT * FROM `userAccounts` WHERE (`username`='$username') AND (`password`='$password')";
	$result = db_get($sql);
	
	$badLogin = false;
	if(mysql_num_rows($result) == 1) {
		$user = mysql_fetch_assoc($result);
		if( (strcmp($user['username'], $username) == 0) && (strcmp(md5($user['password']), md5($password)) == 0) ) {
			$_SESSION['username'] = $username;
			$_SESSION['password'] = md5($password);
			$_SESSION['userID'] = $user['id'];
			header('Location: manageresumes/index.php');
			die();
		}
		else {
			$badLogin = true;
		}
	}
	else {
		$badLogin = true;
	}

	if($badLogin == true) {
		$error = true;
		$errorMessage = "<font color='red'>Incorrect username or password</font>";
	}
  }

  
?>
<html>
 <head>
  <title>Login to Resume Creator</title>
 </head>
 <body bgcolor='#777777'>
  <h2>Login</h2>
  <form action='<?php echo $_SERVER['PHPSELF']?>' method='post' name='login'>
<?php
   if($error == true)
   	echo $errorMessage;
?>
   <table>
    <tr>
     <td>Username:</td>
     <td><input type='text' name='username' value='<?php echo $username?>' /></td>
    </tr>
    <tr>
     <td>Password:</td>
     <td><input type='password' name='password' value='' /></td>
    </tr>
   </table>
   <input type='submit' name='login' value='Login' /><br /> 
  </form>
 </body>
</html>
