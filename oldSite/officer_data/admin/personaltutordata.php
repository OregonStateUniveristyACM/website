<?php
	include "../../functions.php";
	$conn = getmysqlDBConn();

	mysql_select_db('acm', $conn);
	
	if(isset($_POST["UpdateData"]) == true)
	{
		$TutorID = $_GET["TutorID"];
		$Name = $_POST["Name"];
		$Email = $_POST["Email"];
		$Courses = $_POST["Courses"];
		
		$sql = "UPDATE `Tutoring` SET Name='$Name', Email='$Email', Courses='$Courses' WHERE (TutorID='$TutorID')";
		mysql_query($sql, $conn);
		header("Location: modifyTutorOptions.php?TutorID=" . $TutorID);
	}

?>
<html>
 <head>
  <title>Modify Tutor's Personal Data</title>
 </head>
 <body>
  <a href="../">Admin</a> &gt;&gt; <a href="selectTutor.php">Select Tutor</a> &gt;&gt; <a href="modifyTutorOptions.php?TutorID=<?php echo $_GET["TutorID"]?>">Options</a> &gt;&gt; Personal Data
  <form method="post" action="<?php echo $_SERVER["PHP_SELF"]?>?TutorID=<?php echo $_GET["TutorID"]?>">
   <table border='1'>
<?php
	$sql = "SELECT * FROM Tutoring WHERE TutorID=" . $_GET["TutorID"]; 

	$result = mysql_query($sql, $conn);

	$row = mysql_fetch_assoc($result);
	echo "<tr><td><b>Name:</b></td> <td><input type='text' name='Name' value='$row[Name]' size='30'></td></tr>\r\n";
	echo "<tr><td><b>Email:</b></td> <td><input type='text' name='Email' value='$row[Email]' size='30'></td></tr>\r\n";
	echo "<tr><td><b>Courses:</b></td> <td><input type='text' name='Courses' value='$row[Courses]' size='30'></td></tr>\r\n";
?>
   </table>
   <br>
   <br>
   <input type="submit" value="Update" name="UpdateData">
  </form>
 </body> 
</html>
