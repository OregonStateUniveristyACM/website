<?php
  include_once "../../functions.php";

	if( isset($_POST["TutorID"]) )
		$ID = $_POST["TutorID"];
	else 
		$ID = $_GET["TutorID"];

?>
<html>
 <head>
  <title>
 </head>
 <body>
  <a href='../'>Admin</a> &gt;&gt; <a href='selectTutor.php'>Select Tutor</a> &gt;&gt; Options
   <ul>
    <table>
    <tr><th> Tool Name</th> <th> Tool Description</th></tr>
    <tr><td><a href="personaltutordata.php?TutorID=<?php print $ID; ?>">Modify Personal Data</a></td><td>Description 1</td></tr>
    <tr><td><a href="TutorTimes/?TutorID=<?php print $ID; ?>">Modify Times</a></td><td>Description2</td></tr>
   </table>
  </ul>
 </body>
</html>
