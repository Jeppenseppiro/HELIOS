<?php
	require 'db_connect.php';
  	session_start();
  	ob_start();

  	$primaryID = $_GET["object"];

	$query = "SELECT * FROM tbl_primary WHERE segment_id = '$primaryID'";
	$statement = $conn->query($query);

	 while ($row = $statement->fetch_assoc()){
	 	$output .= '<img src="data:image;base64,'.base64_encode($row['image'] ).'" class="avatar img-circle img-thumbnail" alt="avatar" style="width: 100%;">';
     }

	echo $output;

?>