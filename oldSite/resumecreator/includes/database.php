<?php
  /**
   * Date: February 15, 2005
   * Author: Sean P. Jensen
   * Copyright: Copyright 2005, Association for Computing Machinery, Oregon State University
   *
   */
?>
<?php
  $db_host = "chena.cs.orst.edu";
  $db_username = "acmuser";
  $db_password = "h0tpl8";
  $db_database = "acm";

  // database connection
  static $db_conn;

  /*
   * This function handles all database queries
   */
  function db_get($sql) {
	global $db_conn;
	global $db_host;
	global $db_username;
	global $db_password;
	global $db_database;

	//Just incase we are already connected, disconnect
	@mysql_close($db_conn);

	$db_conn = mysql_connect($db_host, $db_username, $db_password);

	mysql_select_db($db_database, $db_conn);

	return mysql_query($sql, $db_conn);
  }
?>
