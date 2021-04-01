<?php
	require 'db_connect.php';
  	session_start();
  	ob_start();

  	$usernameID = $_GET["username"];

	$query = "SELECT * FROM tbl_account WHERE username = '$usernameID'";
	$statement = $conn->query($query);

	 while ($row = $statement->fetch_assoc()){
	 	$output .= '<img src="data:image;base64,'.base64_encode($row['image'] ).'" class="avatar img-circle img-thumbnail" alt="avatar" style="width: 100%; ">';
     }

	echo $output;

?>