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

	$layer_id = 2;

    $date_created = date('m/d/Y h:i A');   

	if(isset($_POST["item_secondarySegmentID"])) {
	    $item_secondarySegmentID = $_POST["item_secondarySegmentID"];
        $item_secondaryFromBusID = $_POST["item_secondaryFromBusID"];
        $item_secondaryToBusID = $_POST["item_secondaryToBusID"]; 
        $item_secondarylatitude = $_POST["item_secondarylatitude"];
        $item_secondarylongitude = $_POST["item_secondarylongitude"];
		$query = '';

	 for($count = 0; $count<count($item_secondarySegmentID); $count++) {
	  	$item_secondarySegmentID_clean = mysqli_real_escape_string($conn, $item_secondarySegmentID[$count]);
		$item_secondaryFromBusID_clean = mysqli_real_escape_string($conn, $item_secondaryFromBusID[$count]);
	    $item_secondaryToBusID_clean = mysqli_real_escape_string($conn, $item_secondaryToBusID[$count]);
	    $item_secondaryPhasing_clean = mysqli_real_escape_string($conn, $item_secondaryPhasing[$count]);
	    $item_secondaryInstallationType_clean = mysqli_real_escape_string($conn, $item_secondaryInstallationType[$count]);
	    $item_secondaryLength_clean = mysqli_real_escape_string($conn, $item_secondaryLength[$count]);
	    $item_secondaryConductorType_clean = mysqli_real_escape_string($conn, $item_secondaryConductorType[$count]);
	    $item_secondaryConductorSize_clean = mysqli_real_escape_string($conn, $item_secondaryConductorSize[$count]); 
	  	$item_latitude_clean = mysqli_real_escape_string($conn, $item_secondarylatitude[$count]);
	  	$item_longitude_clean = mysqli_real_escape_string($conn, $item_secondarylongitude[$count]);

	  if($item_secondarySegmentID_clean != '' && $item_latitude_clean != '' && $item_longitude_clean != '') {
	   $query .= 'INSERT INTO tbl_secondary (account_id, layer_id, distribution_lineid, from_busid, to_busid, secondary_latitude, secondary_longitude, date_created) VALUES ("'.$account_id.'", "'.$layer_id.'", "'.$item_secondarySegmentID_clean.'", "'.$item_secondaryFromBusID_clean.'", "'.$item_secondaryToBusID_clean.'",  "'.$item_latitude_clean.'", "'.$item_longitude_clean.'", "'.$date_created.'");';
	   $log_query .= 'INSERT INTO tbl_log (account_id, status_id, notification_id, log_status, url_link, date_created) VALUES ("'.$account_id.'", "'.$status_id.'", "2", "0", "marker.php?object='.$item_secondarySegmentID_clean.'", "'.$date_created.'");';
	  }
	 }

	$segment_query = "SELECT * from tbl_secondary WHERE distribution_lineid = '$item_secondarySegmentID_clean'";
    $segment_exist = $conn->query($segment_query);

    if($segment_exist->num_rows > 0){
    	echo "<script>alert('Record Already Exists')</script>";  
    } else {
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
    }

	 
?>