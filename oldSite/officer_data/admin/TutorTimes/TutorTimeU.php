<?php
	include "../../../functions.php";
	$conn = getmysqlDBConn();

	mysql_select_db('acm', $conn);
	
	if(isset($_POST["UpdateTime"]) == true)
	{
		$Length = $_POST["Length"];
		$TutorID = $_GET["TutorID"];
		$StartingTime = $_POST["StartingTime"];
		$Day = $_POST["Day"];
		$TimesID = $_GET["EditID"];
	
		$sql = "UPDATE Times SET Day=$Day, StartingTime=$StartingTime, Length=$Length WHERE (TimesID=$TimesID)";
		mysql_query($sql, $conn);
		
		header("Location: index.php?TutorID=$_GET[TutorID]");
	}
	else
	{
		main();
	}

function main()
{
	global $conn;
	$sql = "SELECT * FROM Tutoring WHERE TutorID=".$_GET["TutorID"];
	$result = mysql_query($sql, $conn);
	$row = mysql_fetch_assoc($result);

	$sql = "SELECT * FROM Times WHERE TimesID=".$_GET["EditID"];
	$result = mysql_query($sql, $conn);
	$timeRow = mysql_fetch_assoc($result);
?>	
	<head>
	 <head>
	  <title>Modify Tutor Times</title>
	 </head>
	 <body>
	  <a href="../">Admin</a> &gt;&gt; <a href="../selectTutor.php">Select Tutor</a> &gt;&gt; <a href="../modifyTutorOptions.php?TutorID=<?php echo $_GET["TutorID"]?>">Options</a> &gt;&gt; <a href="index.php?TutorID=<?php echo $_GET["TutorID"]?>">TutorTimes</a> &gt;&gt; Edit Tutor Time
	  <form method="post" action="<?php echo $_SERVER["PHP_SELF"]?>?TutorID=<?php echo $_GET["TutorID"]?>&amp;EditID=<?php echo $_GET["EditID"]?>">
	   <h2><?php echo $row["Name"]?></h2>
	   <table border="1">
	    <tr>
	     <td>Day: </td>
	     <td>
	      <select name="Day">
	       <option value="0" <?php if($timeRow["Day"] == 0) echo "selected='selected'"; ?>>Sunday</option>
	       <option value="1" <?php if($timeRow["Day"] == 1) echo "selected='selected'"; ?>>Monday</option>
	       <option value="2" <?php if($timeRow["Day"] == 2) echo "selected='selected'"; ?>>Tuesday</option>
	       <option value="3" <?php if($timeRow["Day"] == 3) echo "selected='selected'"; ?>>Wednesday</option>
	       <option value="4" <?php if($timeRow["Day"] == 4) echo "selected='selected'"; ?>>Thursday<option>
	       <option value="5" <?php if($timeRow["Day"] == 5) echo "selected='selected'"; ?>>Friday</option>
	       <option value="6" <?php if($timeRow["Day"] == 6) echo "selected='selected'"; ?>>Saturday</option>
	      </select>
	     </td>
	    </tr>
	    <tr><td>Starting Time: </TD> <TD><INPUT TYPE="TEXT" NAME="StartingTime" SIZE="10" VALUE="<?php print $timeRow["StartingTime"]; ?>" /></TD></TR>
	    <tr><td>Length: </TD> <TD><INPUT TYPE="TEXT" NAME="Length" SIZE="10" VALUE="<?php print $timeRow["Length"]; ?>" /></TD></TR>
	   </table>
	   <br>
	   <input type="submit" value="Update" name="UpdateTime">
	  </form>
	 </body> 
	</html>
<?php
}
?>
