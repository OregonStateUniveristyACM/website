<?php
	include "../../functions.php";
	$conn = getmysqlDBConn();

	mysql_select_db('acm', $conn);
?>
<html>
 <head>
  <title>Select a Tutor</title>
 </head>
 <body>
  <a href="./">Admin</a> &gt;&gt; Select Tutor
  <form method='post' action="modifyTutorOptions.php">
<?php
	$sql = "SELECT * FROM Tutoring ORDER BY `Name`";
	$result = mysql_query($sql, $conn);
	
	if(mysql_num_rows($result) > 0) {
		echo "<select name='TutorID'>\r\n";
		while($row = mysql_fetch_assoc($result)) {
			echo "<option value='$row[TutorID]'>$row[Name]</option>\r\n";
		}
		echo "</select>\r\n";
		echo "<br>\r\n";
		echo "<br>\r\n";
		echo "<input type='submit' value='Select' name='submitted'>\r\n";
	}
	else
		echo "<ul>\r\n<h2>There are no Tutors in the Database</h2>\r\n</ul>\r\n";
?>
  </form>
 </body>
</html>
