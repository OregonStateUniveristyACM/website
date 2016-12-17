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

  $resumeCreated = false;
  // grab Resume id
  $userID = $_SESSION['userID'];

  // Check to see if the user is an Administrator
  $sql = " SELECT * FROM userAccounts WHERE (`id`='$userID')";
  $result = db_get($sql);
  $row = mysql_fetch_assoc($result);
  if(strcmp($row['username'], "admin") != 0) {
        header('Location: ./index.php');
	die();
  }

  $directory = dirname(__FILE__)."/created_files";

  $tmp_HTML =  tempnam($directory, 'HTML-');
  @unlink($tmp_HTML);
  $tmp_HTML .= ".html";
  $handle = fopen($tmp_HTML, "w+");
  fclose($handle);
  $tmp_PDF = tempnam($directory, 'PDF-');
  @unlink($tmp_PDF);
  $tmp_PDF .= ".pdf";
  $handle = fopen($tmp_PDF, "w+");
  fclose($handle);

  $handle = fopen($tmp_HTML, "w+");
  fwrite($handle, "<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n");
  fwrite($handle, "
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
  ");

  $sql = "SELECT * FROM Resumes ORDER BY lastName ASC, firstName ASC";
  $result = db_get($sql);
  while($row = mysql_fetch_assoc($result)) {
	$filename = "resumeTemplate.html";
	$resumeTemplate_handle = fopen($filename, "r");
  	$contents = fread($resumeTemplate_handle, filesize($filename));
  	fclose($resumeTemplate_handle);
	


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

	
	$contents .= "<!--NewPage-->\n";
  	fwrite($handle, $contents);
  }

  fwrite($handle, "\n</body>\n</html>");
  fclose($handle);

  // Require the class
  require_once dirname(__FILE__) . '/HTML_ToPDF.php';

  // The default domain for images that use a relative path
  // (you'll need to change the paths in the test.html page 
  // to an image on your server)
  $defaultDomain = '24.21.145.43';

  // Full path to the PDF we are creating
  $pdfFile = $tmp_PDF;

  // Remove old one, just to make sure we are making it afresh
  @unlink($pdfFile);

  // Instnatiate the class with our variables
  $pdf =& new HTML_ToPDF($tmp_HTML, $defaultDomain, $pdfFile);
  //$pdf->setDebug(true);
  $result = $pdf->convert();

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

	unlink($tmp_HTML);
	unlink($result);

        header('Content-Transfer-Encoding: none');
        header("Content-Type: application/pdf; name='".basename($result)."'");
        header("Content-length: $content_len");

        echo $content_file;
        die();

//    echo "PDF file created successfully: $result";
    echo "Click <a href='./created_files/" . basename($result) . "'>here</a> to view the PDF.<br />";
//    echo "Click <a href='./created_files/" . basename($tmp_HTML) . "'>here</a> to view the HTML file.";
  }
?>
