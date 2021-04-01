<?php
	require 'db_connect.php';
	session_start();

	if(isset($_GET["delete"])){
		$id = $_GET["delete"];

	    $delete = "DELETE from tbl_primary WHERE world_id=$id";
	    $conn->query($delete);
	    header("location:database.php");

	}
?>
