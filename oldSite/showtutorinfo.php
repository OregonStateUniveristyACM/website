<HTML>
 <HEAD>
  <TITLE>Detailed Tutor Times</TITLE>
 </HEAD>
 <BODY>
  <?php
	include "functions.php";
	$conn = getmysqlDBConn();

	mysql_select_db('acm', $conn); 
	
	$sql = "SELECT * FROM `Tutoring` WHERE TutorID='".$_GET["tutorid"]."'";
	$result = mysql_query( $sql, $conn );


	if($result)
	{
		$row = mysql_fetch_assoc($result);
		if($row)
		{
			print "<B>Name:</B>    " . $row["Name"] . "<BR>\n";
			if( $row["Email"] != null )
				print "<B>Email:</B> <A HREF=\"mailto:" . $row["Email"] . "\">" . $row["Email"] . "</A><BR>\n"; 
			else
				print "<B>Email:</B> This person wishes not to publish their email address<BR>";
			print "<B>Courses:</B> " . $row["Courses"] . "<BR>\n"; 
			
			$DayArr = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday');

			print "<BR>Hours this ACM Tutor has set a side for tutoring<BR><BR>";
			for($cnt=0; $cnt<7; $cnt++)
			{
				$sqlTimes = "SELECT * FROM Times WHERE TutorID='".$_GET["tutorid"]."' AND Day='$cnt' ORDER BY Day";
				//print "sqlTimes: $sqlTimes<BR>";
	                        $resultTimes = mysql_query($sqlTimes, $conn);
				
				$dayHasBeenShow = false;	
				$hoursShown = false;
				while( $rowTimes = mysql_fetch_assoc($resultTimes) )
				{
					if(!$dayHasBeenShow)
					{
						$dayHasBeenShow = true;
                                               	print "<B>" . $DayArr[$cnt] . ":</B>";
					}
					$cur_time = $rowTimes["StartingTime"];
                                       	$start_time = date("ga", strtotime(substr($cur_time, 0, strlen($cur_time) - 2).":".substr($cur_time, -2, 2)));
					
					$tmpTime = $rowTimes["Length"];
					while( ($tmpTime > 0) && (($tmpTime % 60) == 0) )
					{
						$cur_time += 100;
						$tmpTime -= 60;
					}
					$end_time = date("ga", strtotime(substr($cur_time, 0, strlen($cur_time) - 2).":".substr($cur_time, -2, 2)));
					if($hoursShown)
						print " && ";
					print " $start_time-$end_time ";
					$hoursShown = true;
				}
				if($dayHasBeenShow)
					print "<BR>";
			}
		}
		print "<BR><BR>\n";
	}
	else
	{
		print "unable to get good result<BR>";
	}

  ?> 
 </BODY>
</HTML>
