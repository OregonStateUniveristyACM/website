<?php
   // Generate a header and start a table
   function generateHeader($title) {
?>

<HTML>
<HEAD>
<TITLE><?php echo $title ?>									</TITLE>

	<LINK REL=StyleSheet HREF="func_meth/style.css" TYPE="text/css" MEDIA=screen>
</HEAD>

<BODY>

<TABLE>
<TR>
	<TD CLASS=home>
					<A HREF="index.php"><IMG BORDER=0 SRC="images/ACMLogo.gif"></A>
	</TD>

	<TD CLASS=toppanel>
					<?php echo $title?>
	</TD>

<TR>
	<TD CLASS=leftpanel ROWSPAN=3>
					<?php generateNavigationPanel()?>
	</TD>
<TR>
	<TD CLASS=content>

<?php
   } //end generateHeader($title)
?>


<?php
	function generateOSEC($title) {
?>

<Center>
<Table WIDTH="100%" BGCOLOR="#FF9900" >
	<TR>

	<TD>
	<Center>
			<img SRC="../images/OSULogo.gif" BORDER=0 height=93 width=90>	</Center>
	</TD>

    <TD>
    <Center>
			<Font Size=+3><?php echo $title?></Font>							</Center>
    </TD>

	<TD>
	<Center>
			<img SRC="../images/ACMLogo.gif" BORDER=0 height=103 width=82>	</Center>
    </TD>

</TR>
</Table>
</Center>

<?php
   } //end generateOSEC($title)
?>





<?php
   function generateHTMLTop($title) {
?>

<HTML>
<HEAD>
<TITLE>		<?php echo $title?>										</TITLE>
</HEAD>
<BODY>
<?php
   } // end generateHTMLTop($title)
?>




<?php
   function generateHTMLBottom() {
?>
</BODY>
</HTML>


<?php
   } // end generateHTMLBottom()
?>




<?php
	// End the table and generate a footer
   function generateFooter() {
      $today = date("m/d/Y, h:i A");
?>


<TR>
	<TD CLASS=footer>
			Questions? Reach the ACM staff at<A HREF="mailto:acm-staff@cs.orst.edu">
			acm-staff@cs.orst.edu</A>, copyright &copy; 2002 Oregon State University ACM, All
			Rights Reserved.</TD>
<?php
   } //end generateFooter()
?>


<?php
   // Generate the navigation panel on the left
   function generateNavigationPanel() {
?>
      <TABLE WIDTH=94>

	<TR><TD><A HREF="Join.php">Join ACM!</A>
	<TR><TD><A HREF="About.php">About ACM</A>
	<TR><TD><A HREF="Constitution.php">Constitution</A>
	<TR><TD><HR>
	<TR><TD><A HREF="Calendar.php">Calendar</A>
	<TR><TD><A HREF="Meetings.php">Meetings</A>
	<TR><TD><A HREF="Todolist.php">To Do List</A>
	<TR><TD><HR>
	<TR><TD><A HREF="Events.php">Events</A>
	<TR><TD><A HREF="Workshop_Calendar.php">Workshops</A>
	<TR><TD><A HREF="Groups.php">Groups</A>
	<TR><TD><A HREF="Members.php">Members</A>
	<TR><TD><HR>
	<TR><TD><A HREF="Contests.php">Contests</A>
	<TR><TD><A HREF="Courses.php">Courses</A>
	<TR><TD>
	<TR><TD><A HREF="Data/Eweek.php">E-Week</A>
	<TR><TD><HR>
	<TR><TD><A HREF="/acm/Officer_Data/Officersonly.php">Officers Only</A>
	<TR><TD><HR>
	<TR><TD><A HREF="Bugs.php">Bugs</A>
	<TR><TD><A HREF="Old_News.php">Old News</A>
	<TR><TD><A HREF="Useful_Info.php">Useful Info</A>
	<TR><TD><HR>
	<TR><TD><A HREF="Links.php">Links</A>

      </TABLE>
<?php
	} //end generateNavigationPanel()
?>
