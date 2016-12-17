<?php
  include_once "../../functions.php";

  if(isset($_POST["submitted"]) == true) {
	$sql = "INSERT INTO `Tutoring` (`Name`, `Email`, `Courses`) VALUES ( '".$_POST["TutorName"]."', '".$_POST["EmailAddress"]."', '".$_POST["Courses"]."')"; 

	$conn = getmysqlDBConn();
	mysql_select_db('acm', $conn); 

	$result = mysql_query($sql, $conn);
	header("Location: ./");
  }
	
?>
<html>
 <head>
  <title>Create new Tutor</title>
 </head>
 <body>	
  <a href="./">Admin</a> &gt;&gt; Create New Tutor
   <form method="post" action="<?php echo $_SERVER["PHP_SELF"]?>">
    <table>
     <tr><td><b>Tutors Name:</b></td>   <td><input type='text' name="TutorName" size="30"></td></tr>
     <tr><td><b>Email Address:</b></td> <td><input type='text' name="EmailAddress" size="30"></td></tr>
     <tr><td><b>Courses:</b></td>       <td><input type='text' name="Courses" size="30"></td></tr>
    </table>
   <input type="submit" value="Add Tutor" name="submitted">
  </form>
 </body>
</html>
