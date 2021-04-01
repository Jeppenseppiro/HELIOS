<?php
	require 'db_connect.php';
	session_start();

	if(isset($_GET["object"])){
		$id = $_GET["object"];

	    $delete = "DELETE from tbl_primary WHERE segment_id = '$id'";
	    $conn->query($delete);
	    header("location: primaryDatabase.php");

	}
?>
