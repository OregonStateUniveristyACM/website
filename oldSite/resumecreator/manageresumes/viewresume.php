<?php
  /**
   * Date: February 15, 2005
   * Author: Sean P. Jensen
   * Copyright: Copyright 2005, Association for Computing Machinery, Oregon State University
   *
   */
?>
<?php
  require_once dirname(__FILE__)."/../includes/database.php";
  require_once dirname(__FILE__)."/../includes/checkloggedinstatus.php";

  // grab Resume id
  $userID = $_SESSION['userID'];

  if(strcmp($_GET['id'], "") == 0) {
        echo "no id given...<br />";
        echo "id is required before web page can work<br />";
        die();
  }

  // Check to see if the user is an Administrator
  $sql = " SELECT * FROM userAccounts WHERE (`id`='$userID')";
  $result = db_get($sql);
  $row = mysql_fetch_assoc($result);
  if(strcmp($row['username'], "admin") == 0) {
        header('Location: ./admin.php');
        die();
  }

  // Try and grab the resume the user created. If we can't locate it then we must assume they haven't created one yet.
  $sql = "
        SELECT Resumes.*, userAccounts.username FROM Resumes LEFT JOIN userAccounts ON Resumes.userID=userAccounts.id WHERE (`userID`='$userID')
  ";
  $result = db_get($sql);
  if(mysql_num_rows($result) > 0) {
        $resume = mysql_fetch_assoc($result);
        $resumeCreated = true;
  }
  else {
	// Can't locate a resume go back
	header('Location: index.php');
	die();
  }

  $filename = "resumeTemplate.html";

  $handle = fopen($filename, "r");
  $contents = "
        <html>
         <head>
          <title><title>
           <style type='text/css'>
            div.noprint {
              display: none;
            }
            h6 {
              left: 50px;
            }
            @page:right {
              margin-right: 1.0cm;
              margin-left: 1.0cm;
              margin-top: 1.0cm;
              margin-bottom: 1.0cm;
            }
            @page:left {
              margin-right: 1.0cm;
              margin-left: 1.0cm;
              margin-top: 1.0cm;
              margin-bottom: 1.0cm;
            }
            </style>
          </head>
          <body>
  ";
  $contents .= fread($handle, filesize($filename));
  $contents .= "</body></html>";
  fclose($handle);

  $sql = "SELECT Resumes.*, userAccounts.username FROM Resumes LEFT JOIN userAccounts ON Resumes.userID=userAccounts.id WHERE (Resumes.id='$_GET[id]') AND (Resumes.userID='$userID')";

  $result = db_get($sql);
  $row = mysql_fetch_assoc($result);
  
  $contents = preg_replace("/FIRSTNAME/",  preg_replace("/\n/","<br />\n", $row['firstName']), $contents);
  $contents = preg_replace("/LASTNAME/",  preg_replace("/\n/","<br />\n", $row['lastName']), $contents);
  $contents = preg_replace("/PERMINANTADDRESS/", preg_replace("/\n/","<br />\n", $row['perminantAddress']), $contents);
  $contents = preg_replace("/CURRENTADDRESS/", preg_replace("/\n/","<br />\n", $row['currentAddress']), $contents);
  $contents = preg_replace("/PERMINANTPHONE/", preg_replace("/\n/","<br />\n", $row['perminantPhone']), $contents);
  $contents = preg_replace("/CURRENTPHONE/", preg_replace("/\n/","<br />\n", $row['currentPhone']), $contents);
  $contents = preg_replace("/EMAIL/", preg_replace("/\n/","<br />\n", $row['email']), $contents);
  $contents = preg_replace("/OBJECTIVE/", preg_replace("/\n/","<br />\n", preg_replace("/\r\n\r\n/","<p></p>\n", preg_replace("/  / ", " &nbsp;", $row['objective']))), $contents);
  $contents = preg_replace("/SCHOOLS/", preg_replace("/\n/","<br />\n", preg_replace("/\r\n\r\n/","<p></p>\n", preg_replace("/  / ", " &nbsp;", $row['schools']))), $contents);

  $contents = preg_replace("/MAJOR/", preg_replace("/\n/","<br />\n", $row['major']), $contents);
  $contents = preg_replace("/EXPECTEDGRADUATIONDATE/", preg_replace("/\n/","<br />\n", $row['expectedGraduationDate']), $contents);
  $contents = preg_replace("/AWARDS/", preg_replace("/\n/","<br />\n", preg_replace("/\r\n\r\n/","<p></p>\n", preg_replace("/  / ", " &nbsp;", $row['awards']))), $contents);
  $contents = preg_replace("/EMPLOYMENT/", preg_replace("/\n/","<br />\n", preg_replace("/\r\n\r\n/","<p></p>\n", preg_replace("/  / ", " &nbsp;", $row['employment']))), $contents);
  $contents = preg_replace("/STRENGTHS/", preg_replace("/\n/","<br />\n", preg_replace("/\r\n\r\n/","<p></p>\n", preg_replace("/  / ", " &nbsp;", $row['strengths']))), $contents);
  $contents = preg_replace("/VOLUNTEERACTIVITIES/", preg_replace("/\n/","<br />\n", preg_replace("/\r\n\r\n/","<p></p>\n", preg_replace("/  / ", " &nbsp;", $row['volunteerActivities']))), $contents);
$contents = preg_replace("/PUBLICATIONS/", preg_replace("/\n/","<br />\n", preg_replace("/\r\n\r\n/","<p></p>\n", preg_replace("/  / ", " &nbsp;", $row['publications']))), $contents);

  $directory = dirname(__FILE__)."/created_files/";

  $resume_HTML =  $directory.$row['username']."-HTML";
  @unlink($resume_HTML);
  $resume_HTML .= ".html";
  $handle = fopen($resume_HTML, "w+");
  fclose($handle);
  $resume_PDF = $directory.$row['username']."-PDF";
  @unlink($resume_PDF);
  $resume_PDF .= ".pdf";
  $handle = fopen($resume_PDF, "w+");
  fclose($handle);

  $handle = fopen($resume_HTML, "w+");
  fwrite($handle, $contents);
  fclose($handle);

  // Require the class
  require_once dirname(__FILE__) . '/HTML_ToPDF.php';

  // The default domain for images that use a relative path
  // (you'll need to change the paths in the test.html page 
  // to an image on your server)
  $defaultDomain = 'http://groups.engr.oregonstate.edu/acm/resume/manageresumes/';

  // Full path to the PDF we are creating
  $pdfFile = $resume_PDF;

  // Remove old one, just to make sure we are making it afresh
  @unlink($pdfFile);

  // Instnatiate the class with our variables
  $pdf =& new HTML_ToPDF($resume_HTML, $defaultDomain, $pdfFile);
  //$pdf->setDebug(true);
  $result = $pdf->convert();

  //Remove Temp Files
  @unlink($resume_HTML);

  // Check if the result was an error
  if (PEAR::isError($result)) {
    die($result->getMessage());
  }
  else {
	// pump out file
	if(!($f = @fopen("./created_files/" . basename($result), 'rb'))) {
		echo "Attachment not found\n";
	        die;
	}

	$content_len = (int)filesize("./created_files/" . basename($result));
	$content_file = fread($f, $content_len);
	fclose($f);
	
	header('Content-Transfer-Encoding: none');
	header("Content-Type: application/pdf; name='".basename($result)."'");
	header("Content-length: $content_len");

	echo $content_file;
	@unlink($resume_PDF);
	die();
  }
?>
