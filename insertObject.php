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
	}

    $date_created = date('m/d/Y h:i A');   

	if(isset($_POST["item_primarySegmentID"])) {
	    $item_primarySegmentID = $_POST["item_primarySegmentID"];
	    $item_primaryFromBusID = $_POST["item_primaryFromBusID"];
	    $item_primaryToBusID = $_POST["item_primaryToBusID"];
	    $item_primaryPhasing = $_POST["item_primaryPhasing"];
	    $item_primaryConfiguration = $_POST["item_primaryConfiguration"];
	    $item_primarySystemGroundType = $_POST["item_primarySystemGroundType"];
	    $item_primaryLength = $_POST["item_primaryLength"];
	    $item_primaryConductorType = $_POST["item_primaryConductorType"];
	    $item_primaryConductorSize = $_POST["item_primaryConductorSize"];
	    $item_primaryUnit = $_POST["item_primaryUnit"];
	    $item_primaryStrands = $_POST["item_primaryStrands"];
	    $item_primaryNeutralWireType = $_POST["item_primaryNeutralWireType"];
	    $item_primaryNeutralWireSize = $_POST["item_primaryNeutralWireSize"];
	    $item_primaryUnitNW = $_POST["item_primaryUnitNW"];
	    $item_primaryStrandsNW = $_POST["item_primaryStrandsNW"];
	    $item_primarySpacingdD12 = $_POST["item_primarySpacingdD12"];
	    $item_primarySpacingdD23 = $_POST["item_primarySpacingdD23"];
	    $item_primarySpacingdD13 = $_POST["item_primarySpacingdD13"];
	    $item_primarySpacingdD1n = $_POST["item_primarySpacingdD1n"];
	    $item_primarySpacingdD2n = $_POST["item_primarySpacingdD2n"];
	    $item_primarySpacingdD3n = $_POST["item_primarySpacingdD3n"];
	    $item_primarySpacingdDc1c2 = ["item_primarySpacingdDc1c2"];
	    $item_primaryHeightH1 = $_POST["item_primaryHeightH1"];
	    $item_primaryHeightH2 = $_POST["item_primaryHeightH2"];
	    $item_primaryHeightH3 = $_POST["item_primaryHeightH3"];
	    $item_primaryHeightHn = $_POST["item_primaryHeightHn"];
	    $item_primaryEarthResistivity = $_POST["item_primaryEarthResistivity"];
		$item_latitude = $_POST["item_latitude"];
		$item_longitude = $_POST["item_longitude"];
		$query = '';

	 for($count = 0; $count<count($item_primarySegmentID); $count++) {
	  	$item_primarySegmentID_clean = mysqli_real_escape_string($conn, $item_primarySegmentID[$count]);
		$item_primaryFromBusID_clean = mysqli_real_escape_string($conn, $item_primaryFromBusID[$count]);
	    $item_primaryToBusID_clean = mysqli_real_escape_string($conn, $item_primaryToBusID[$count]);
	    $item_primaryPhasing_clean = mysqli_real_escape_string($conn, $item_primaryPhasing[$count]);
	    $item_primaryConfiguration_clean = mysqli_real_escape_string($conn, $item_primaryConfiguration[$count]);
	    $item_primarySystemGroundType_clean = mysqli_real_escape_string($conn, $item_primarySystemGroundType[$count]);
	    $item_primaryLength_clean = mysqli_real_escape_string($conn, $item_primaryLength[$count]);
	    $item_primaryConductorType_clean = mysqli_real_escape_string($conn, $item_primaryConductorType[$count]);
	    $item_primaryConductorSize_clean = mysqli_real_escape_string($conn, $item_primaryConductorSize[$count]);
	    $item_primaryUnit_clean = mysqli_real_escape_string($conn, $item_primaryUnit[$count]);
	    $item_primaryStrands_clean = mysqli_real_escape_string($conn, $item_primaryStrands[$count]);
	    $item_primaryNeutralWireType_clean = mysqli_real_escape_string($conn, $item_primaryNeutralWireType[$count]);
	    $item_primaryNeutralWireSize_clean = mysqli_real_escape_string($conn, $item_primaryNeutralWireSize[$count]);
	    $item_primaryUnitNW_clean = mysqli_real_escape_string($conn, $item_primaryUnitNW[$count]);
	    $item_primaryStrandsNW_clean = mysqli_real_escape_string($conn, $item_primaryStrandsNW[$count]);
	    $item_primarySpacingdD12_clean = mysqli_real_escape_string($conn, $item_primarySpacingdD12[$count]);
	    $item_primarySpacingdD23_clean = mysqli_real_escape_string($conn, $item_primarySpacingdD23[$count]);
	    $item_primarySpacingdD13_clean = mysqli_real_escape_string($conn, $item_primarySpacingdD13[$count]);
	    $item_primarySpacingdD1n_clean = mysqli_real_escape_string($conn, $item_primarySpacingdD1n[$count]);
	    $item_primarySpacingdD2n_clean = mysqli_real_escape_string($conn, $item_primarySpacingdD2n[$count]);
	    $item_primarySpacingdD3n_clean = mysqli_real_escape_string($conn, $item_primarySpacingdD3n[$count]);
	    $item_primarySpacingdDc1c2_clean = mysqli_real_escape_string($conn, $item_primarySpacingdDc1c2[$count]);
	    $item_primaryHeightH1_clean = mysqli_real_escape_string($conn, $item_primaryHeightH1[$count]);
	    $item_primaryHeightH2_clean = mysqli_real_escape_string($conn, $item_primaryHeightH2[$count]);
	    $item_primaryHeightH3_clean = mysqli_real_escape_string($conn, $item_primaryHeightH3[$count]);
	    $item_primaryHeightHn_clean = mysqli_real_escape_string($conn, $item_primaryHeightHn[$count]);
	    $item_primaryEarthResistivity_clean = mysqli_real_escape_string($conn, $item_primaryEarthResistivity[$count]);
	  	$item_latitude_clean = mysqli_real_escape_string($conn, $item_latitude[$count]);
	  	$item_longitude_clean = mysqli_real_escape_string($conn, $item_longitude[$count]);

	  if($item_primarySegmentID_clean != '' && $item_latitude_clean != '' && $item_longitude_clean != '') {
	   $query .= 'INSERT INTO tbl_primary (account_id, segment_id, from_busid, to_busid, phasing, configuration, grounding_type, length, conductor_type, conductor_size, unit, strands, neutral_wiretype, neutral_wiresize, unit_nw, strands_nw, spacing_d12, spacing_d23, spacing_d13, spacing_d1n, spacing_d2n, spacing_d3n, spacing_dc1c2, height_h1, height_h2, height_h3, height_hn, earth_resistivity, primary_latitude, primary_longitude) VALUES ("'.$account_id.'", "'.$item_primarySegmentID_clean.'", "'.$item_primaryFromBusID_clean.'", "'.$item_primaryToBusID_clean.'", "'.$item_primaryPhasing_clean.'", "'.$item_primaryConfiguration_clean.'", "'.$item_primarySystemGroundType_clean.'", "'.$item_primaryLength_clean.'", "'.$item_primaryConductorType_clean.'", "'.$item_primaryConductorSize_clean.'", "'.$item_primaryUnit_clean.'", "'.$item_primaryStrands_clean.'", "'.$item_primaryNeutralWireType_clean.'", "'.$item_primaryNeutralWireSize_clean.'", "'.$item_primaryUnitNW_clean.'", "'.$item_primaryStrandsNW_clean.'", "'.$item_primarySpacingdD12_clean.'", "'.$item_primarySpacingdD23_clean.'", "'.$item_primarySpacingdD13_clean.'", "'.$item_primarySpacingdD1n_clean.'", "'.$item_primarySpacingdD2n_clean.'", "'.$item_primarySpacingdD3n_clean.'", "'.$item_primarySpacingdDc1c2_clean.'", "'.$item_primaryHeightH1_clean.'", "'.$item_primaryHeightH2_clean.'", "'.$item_primaryHeightH3_clean.'", "'.$item_primaryHeightHn_clean.'", "'.$item_primaryEarthResistivity_clean.'", "'.$item_latitude_clean.'", "'.$item_longitude_clean.'");';
	  }
	 }

	 if($query != '') {
	  if(mysqli_multi_query($conn, $query)) {
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