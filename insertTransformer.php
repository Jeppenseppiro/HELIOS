<?php
	require "db_connect.php";
	session_start();
	ob_start();
	date_default_timezone_set('Asia/Manila'); 

	$session_username = $_SESSION["username"];
	$account = "SELECT * from tbl_account WHERE BINARY username = BINARY '$session_username'";
	$account_inserter = $conn->query($account);

	while ($row = $account_inserter->fetch_assoc()){
		$account_id = $row["account_id"];
		$status_id = $row["status_id"];
	}

	$layer_id = 3;

    $date_created = date('m/d/Y h:i A');   

	if(isset($_POST["item_transformerTransformerID"])) {
	    $item_transformerTransformerID = $_POST["item_transformerTransformerID"];
        $item_transformerFromPrimaryBusID = $_POST["item_transformerFromPrimaryBusID"];
        $item_transformerToSecondaryBusID = $_POST["item_transformerToSecondaryBusID"]; 
        $item_transformerlatitude = $_POST["item_transformerlatitude"];
        $item_transformerlongitude = $_POST["item_transformerlongitude"];
		$query = '';

	 for($count = 0; $count<count($item_transformerTransformerID); $count++) {
	  	$item_transformerTransformerID_clean = mysqli_real_escape_string($conn, $item_transformerTransformerID[$count]);
		$item_transformerFromPrimaryBusID_clean = mysqli_real_escape_string($conn, $item_transformerFromPrimaryBusID[$count]);
	    $item_transformerToSecondaryBusID_clean = mysqli_real_escape_string($conn, $item_transformerToSecondaryBusID[$count]); 
	  	$item_latitude_clean = mysqli_real_escape_string($conn, $item_transformerlatitude[$count]);
	  	$item_longitude_clean = mysqli_real_escape_string($conn, $item_transformerlongitude[$count]);

	  if($item_transformerTransformerID_clean != '' && $item_latitude_clean != '' && $item_longitude_clean != '') {
	   $query .= 'INSERT INTO tbl_transformer (account_id, layer_id, distribution_transformerid, transformer_latitude, transformer_longitude, date_created) VALUES ("'.$account_id.'", "'.$layer_id.'", "'.$item_transformerTransformerID_clean.'", "'.$item_latitude_clean.'", "'.$item_longitude_clean.'", "'.$date_created.'");';
	   $log_query .= 'INSERT INTO tbl_log (account_id, status_id, notification_id, log_status, url_link, date_created) VALUES ("'.$account_id.'", "'.$status_id.'", "3", "0", "marker.php?object='.$item_transformerTransformerID_clean.'", "'.$date_created.'");';
	  }
	 }

	 if($query != '') {
	  if(mysqli_multi_query($conn, $query) && mysqli_multi_query($conn, $log_query)) {
	   echo 'Data Inserted';	   
	  } else {
	   echo 'Error';
	  }
	 } 

	 else {
	  echo 'All Fields are Required';
	 }
	}
?>