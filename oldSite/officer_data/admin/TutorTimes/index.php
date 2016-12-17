<?php
	include "../../../functions.php";
	$conn = getmysqlDBConn();

	mysql_select_db('acm', $conn);
	
	if(isset($_GET["EditID"]) == true)
	{
		header("Location: TutorTimeU.php?TutorID=$_GET[TutorID]&amp;EditID=$_GET[EditID]");
	}
	else if(isset($_GET["DeleteID"]) == true)
	{
		$sql = "SELECT * FROM Times WHERE (TimesID='$_GET[DeleteID]')";
		$result = mysql_query($sql, $conn);
		$row = mysql_fetch_assoc($result);

		if(!isset($row["Day"]) )
			$Day = "Unknown Day";
		else if($row["Day"] == 0)
			$Day = "Sunday";
		else if($row["Day"] == 1)
			$Day = "Monday";
		else if($row["Day"] == 2)
			$Day = "Tuesday";
		else if($row["Day"] == 3)
			$Day = "Wednesday";
		else if($row["Day"] == 4)
			$Day = "Thursday";
		else if($row["Day"] == 5)
			$Day = "Friday";
		else if($row["Day"] == 6)
			$Day = "Satday";
			
		print "Deleted tutoring time on $Day at $row[StartingTime]<br /><br />";
		
		$sql = "DELETE FROM Times WHERE (TimesID='$_GET[DeleteID]')";
		mysql_query($sql, $conn);
		
		main();
	}
	else
	{
		main();
	}
function main()
{
	global $conn;

?>
	<html>
	 <head>
	  <title>Tutor Times</title>
	 </head>
	 <body>
 	  <a href="../">Admin</a> &gt;&gt; <a href="../selectTutor.php">Select Tutor</a> &gt;&gt; <a href="../modifyTutorOptions.php?TutorID=<?php echo $_GET["TutorID"]?>">Options</a> &gt;&gt; TutorTimes 
	  <form method="post" action="<?php echo $_SERVER["PHP_SELF"]?>">
	<?php
		$sql = "SELECT * FROM Tutoring WHERE (TutorID='$_GET[TutorID]')";
		$result = mysql_query($sql, $conn);
		$row = mysql_fetch_assoc($result);
		print "<b>$row[Name]</b><br /><br />";

		$sql = "SELECT * FROM Times WHERE (TutorID='$_GET[TutorID]') ORDER BY Day"; 
		$result = mysql_query($sql, $conn);
?>
		<a href="TutorTimeC.php?TutorID=<?php echo $_GET["TutorID"]?>">Add New Time</a><br />
		<br />
<?php
		if( mysql_num_rows($result) > 0) {
?>
		<table border="1">
		  <tr><th>&nbsp;</th><th>Day</th><th>Time</th><th>Length</th></tr>

<?php
			while($row = mysql_fetch_assoc($result)) {
				echo "\t\t<tr>";
				echo "<td><a href='$_SERVER[PHP_SELF]?TutorID=$row[TutorID]&EditID=$row[TimesID]'>Edit</a> <a href='$_SERVER[PHP_SELF]?TutorID=$row[TutorID]&DeleteID=$row[TimesID]'>Delete</a></td>";
				if( $row["Day"] == 0)
					echo "<td>Sunday</td>";
				if( $row["Day"] == 1)
					echo "<td>Monday</td>";
				if( $row["Day"] == 2)
					echo "<td>Tuesday</td>";
				if( $row["Day"] == 3)
					echo "<td>Wednesday</td>";
				if( $row["Day"] == 4)
					echo "<td>Thursday</td>";
				if( $row["Day"] == 5)
					echo "<td>Friday</td>";
				if( $row["Day"] == 6)
					echo "<td>Saturday</td>";

				echo "<td>$row[StartingTime]</td>";
				echo "<td>$row[Length]</td>";
				echo "</tr>\r\n";
			}
			echo "</table>\r\n";
		}
		else
		{
			echo "<b><ul>There are no times found for this Tutor.</ul></b>";
		}
?>
	  </form>
	 </body> 
	</html>
<?php
 }
?>
