<?php
	ERROR_REPORTING(~E_NOTICE);

	$dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $db = "dbgis";

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    //mysql_connect("localhost","root"," ");
    //mysql_select_db("dblibrary");
?>