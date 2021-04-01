<?php
	require 'db_connect.php';
  	session_start();
  	ob_start();

  	$transformerID = $_GET["object"];

	$query = "SELECT * FROM tbl_transformer WHERE distribution_transformerid = '$transformerID'";
	$statement = $conn->query($query);

	 while ($row = $statement->fetch_assoc()){
	 	$output .= '<img src="data:image;base64,'.base64_encode($row['image'] ).'" class="avatar img-circle img-thumbnail" alt="avatar" style="width: 100%;">';
     }

	echo $output;

?>