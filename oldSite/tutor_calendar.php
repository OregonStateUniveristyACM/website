<?php
include "functions.php";
include "schedule.inc.php";	

/*
	This is the schedule classes array. See schedule.inc.php
	for more details.
*/
	
	$conn = getmysqlDBConn();

	mysql_select_db('acm', $conn); 
	
	$classes_arr = array( );
	$classes_arr_tmp = array( );
	for($cnt=0; $cnt<7; $cnt++)
	{
		// Day
		$day = array();
		$cnt3=0;
		// Time
		for($time=0; $time<2400; $time+=100)
		{
			$sql = "SELECT * FROM Tutoring INNER JOIN Times ON Times.TutorID = Tutoring.TutorID WHERE (Day = $cnt) AND (StartingTime = $time)";
			$result = mysql_query( $sql, $conn );
			$row = @mysql_fetch_assoc($result);
	
			if($row)
			{
				$TutorTime = array(
					"name"   => $row["Name"],
					"email"  => $row["Email"],
					"ID"     => $row["TutorID"],
					"style"  => "background-color: #66CCCC",
					"length" => $row["Length"]
				);
				$day[$time] = $TutorTime;
//				print "Time: [$cnt2] <PRE>";
//				print_r($TutorTime);
//				print "</PRE><BR>";
			}
		}
//		print count($day)."--Day: [$cnt] ";
//		print "<PRE>";
//		print_r($day);
//		print "</PRE>";
//		print "<BR>";
		if(0 != count($day) )
		{
			array_push($classes_arr, $day);
		}
		else
			array_push($classes_arr, array());
	}
//	print "classes_arr:<PRE>";
//	print_r($classes_arr);
//	print "</PRE><BR>";
	/*	
	// Classes for monday (day 1)
	"1" => array(
			// Adds a class at 12pm (1200 hours)
			1200 => array(
				"name" => "Sean P. Jensen", // Display 'Phsychology: Room 404'
				"email" => "jensense@engr.orst.edu",
				"ID" => "1",
				"style" => "background-color: #66CCCC", // use style property to change the background color
				"length" => 60 // set the interval for 2hrs
			)
	),
	
	// Classes for wednesday (day 3)
	"3" => array(
			// Adds a class at 11am (1100 hours)
			1100 => array(
				"name" => "Daniel Smith", // Display 'English 101: Room 235'
				"email" => "smithda@engr.orst.edu",
				"ID" => "3",
				"style" => "background-color: #66CCCC", // use style property to change the background color	
				"length" => 120 // set the interval for 2hrs
			)
	)
);
*/

/*
	This is the schedule options array. See schedule.inc.php
	for more details.
*/
$options = array( 
			"row_interval" => 30, // set the schedule to display a row for every 30min
			"start_time" => 800, // schedule start time  (8am)
			"end_time" => 2200,   // schedule end time (8pm)
//			"title" => "ACM Tutors",
//			"title_style" => "font-family: verdana; font-size: 14pt;", // css style for schedule title
			"time_style" => "font-family: verdana; font-size: 8pt;",  // css style for the time cells
			"dayheader_style" => "font-family: verdana; font-size: 10pt;", // css style for the day header cells
			
			// default css style for the class cells. Eachs tyle can be overridden using the "style" property of each class
			// see schedule.inc.php for details.
			"class_globalstyle" => "background-color: #c0c0c0; font-family: verdana; font-size: 8pt; text-align: center;", 
);
//print_r($classes_arr);
	
	print "<h2><font color='blue'></font></h3>";
	echo schedule_generate($classes_arr, $options, $conn);
//	print "<HR>\r\n<CENTER>Algorithm for creating timetable was done by: <A HREF=\"http://www.Planet-Source-Code.com/vb/scripts/ShowCode.asp?txtCodeId=1082&lngWId=8
\"> Joe Huntley</A></CENTER>";
?>
