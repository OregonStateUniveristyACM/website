<?php
	include "../../../functions.php";
	$conn = getmysqlDBConn();

	mysql_select_db('acm', $conn);
	
	if( isset($_POST["AddNewTime"]) )
	{
		$Length = $_POST["Length"];
		$TutorID = $_GET["TutorID"];
		$StartingTime = $_POST["StartingTime"];
		$Day = $_POST["Day"];
		
		if( is_numeric($Length) && is_numeric($TutorID) && is_numeric($StartingTime) && is_numeric($Day) )
		{
			$sql = "INSERT INTO Times (TutorID, Day, StartingTime, Length) VALUES( $TutorID, $Day, $StartingTime, $Length )";
			mysql_query($sql, $conn);		
			main();
		}
		else
			main("<font size='+2' color='red'><'center'>One or more items are not numbers</center></font>\r\n");
	}
	else
	{
		main();
	}

function main($str = "")
{
	global $conn;
	$sql = "SELECT * FROM Tutoring WHERE TutorID=".$_GET["TutorID"];
	$result = mysql_query($sql, $conn);
	$row = mysql_fetch_assoc($result);

?>	
	<html>
	 <head>
	  <title>Create new time for Tutor</title>
	 </head>
	 <body>
	  <a href="../">Admin</a> &gt;&gt; <a href="../selectTutor.php">Select Tutor</a> &gt;&gt; <a href="../modifyTutorOptions.php?TutorID=<?php echo $_GET["TutorID"]?>">Options</a> &gt;&gt; <a href="index.php?TutorID=<?php echo $_GET["TutorID"]?>">TutorTimes</a> &gt;&gt; Add New Time
	  
	  <form method="post" action="<?php echo $_SERVER["PHP_SELF"]?>">
	   <?php if(isset($str)) print $str; ?>
	   <h2><?php echo $row["Name"]?></h2>
	   <table border='1'>
	    <tr>
	     <td>Day: </td>
	     <td>
	      <select name="Day">
			<option value="0">Sunday</option>
			<option value="1">Monday</option>
			<option value="2">Tuesday</option>
			<option value="3">Wednesday</option>
			<option value="4">Thursday</option>
			<option value="5">Friday</option>
			<option value="6">Saturday</option>
	      </select>
	     </td>
	    </tr>
	    <tr><td>Starting Time: </td> <td><input type="text" name="StartingTime" size="10" /></td></tr>
	    <tr><td>Length: </td> <td><input type="text" name="Length" size="10" /></td></tr>
	   </table>
	   <br />
	   <input type="submit" value="Add" name="AddNewTime">
	  </form>
	 </body> 
	</html>
<?php 
}
?>
