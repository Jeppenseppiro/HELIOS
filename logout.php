<?php
	session_start();

	$_SESSION = array();
	session_destroy();
	
	header("refresh:0 url=login.php");
?>