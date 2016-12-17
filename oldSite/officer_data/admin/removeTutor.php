<?php
        include "../../functions.php";
?>
<A HREF="./">Admin</A> &gt;&gt; Remove Tutor<BR><BR>
<?php
	$conn = getmysqlDBConn(); 

	mysql_select_db('acm', $conn);
	
	if( isset($_POST["TutorID"]) )
	{
		$sql = "SELECT * FROM `Tutoring` WHERE (TutorID='".$_POST["TutorID"]."')";
		$result = mysql_query($sql, $conn);
		$row = mysql_fetch_assoc($result);
		
		$removeTutorTimes_sql = "DELETE FROM `Times` WHERE (TutorID='".$_POST["TutorID"]."')";
		mysql_query( $removeTutorTimes_sql, $conn);

		$removeTutor_sql = "DELETE FROM `Tutoring` WHERE (TutorID='".$_POST["TutorID"]."')";
       		mysql_query( $removeTutor_sql, $conn );

		echo "<FONT SIZE=\"+3\"><B>DELETED THE RECORD OF:</B></FONT> <FONT SIZE=\"+2\" COLOR=\"RED\">". $row["Name"]."</FONT><BR><HR>";
	}
	$sql = "SELECT * FROM `Tutoring` WHERE 1";
	
	$result = mysql_query( $sql, $conn );

	if( $row = @mysql_fetch_assoc($result) )
	{
		do {	
			echo "<B>Name:</B>    " . $row["Name"] . "<BR>\n";
			if( $row["Email"] != null )
				echo "<B>Email:</B> <A HREF=\"mailto:" . $row["Email"] . "\">" . $row["Email"] . "</A><BR>\n"; 
			else 
				echo "<B>Email:</B> This person wishes not to publish their email address<BR>";
			echo "<B>Courses:</B> " . $row["Courses"] . "<BR>\n"; 
			
			echo "<BR>\n";
?>
			<FORM METHOD="post" ACTION="<?php echo $_SERVER["PHP_SELF"]?>">
			<INPUT TYPE="hidden" VALUE="<?php echo $row["TutorID"]?>" NAME="TutorID">
			<INPUT TYPE="submit" VALUE="Remove" NAME="RemoveNow">
			</FORM>
<?php
			echo "<HR>";
		} while( $row = @mysql_fetch_assoc($result) );
	}
	else
		echo "<UL>\r\n<H2>There are no Tutors in the Database</H2>\r\n</UL>\r\n";
?>
