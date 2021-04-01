<?php
	require 'db_connect.php';
	session_start();
  	ob_start();
  	date_default_timezone_set('Asia/Manila');

  	$session_username = $_SESSION["username"];
  	$date = date(' mdY hiA');   


	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=tbl_secondary ('.$session_username.$date.').csv'); 

	$output = fopen("php://output", "w");
	fputcsv($output, array('Count', 'Secondary Distribution Line ID', 'From Bus ID', 'To Bus ID', 'Phasing', 'Installation Type', 'Length (meters)', 'Conductor Type', 'Conductor Size'));

	//$query = "SELECT `primary_id`, `segment_id`, `from_busid`, `to_busid`, `phasing`, `configuration`, `grounding_type`, `length`, `conductor_type`, `conductor_size`, `unit`, `strands`, `neutral_wiretype`, `neutral_wiresize`, `unit_nw`, `strands_nw`, `spacing_d12`, `spacing_d23`, `spacing_d13`, `spacing_d1n`, `spacing_d2n`, `spacing_d3n`, `spacing_dc1c2`, `height_h1`, `height_h2`, `height_h3`, `height_hn`, `earth_resistivity` from tbl_primary";
	$check_query = "SELECT * from tbl_secondary INNER JOIN tbl_account ON tbl_secondary.account_id = tbl_account.account_id WHERE username = '$session_username'";
	$check_result = $conn->query($check_query);


	$admin_database = "SELECT `secondary_id`, `distribution_lineid`, `from_busid`, `to_busid`, `phasing`, `installation_type`, `length`, `conductor_type`, `conductor_size` from tbl_secondary INNER JOIN tbl_account ON tbl_secondary.account_id = tbl_account.account_id"; 
    $admin_databaseResult = $conn->query($admin_database);   

    $account_database = "SELECT `secondary_id`, `distribution_lineid`, `from_busid`, `to_busid`, `phasing`, `installation_type`, `length`, `conductor_type`, `conductor_size` from tbl_secondary INNER JOIN tbl_account ON tbl_secondary.account_id = tbl_account.account_id WHERE BINARY username = BINARY '$session_username'";
    $account_databaseResult = $conn->query($account_database);

	while ($status = $check_result->fetch_assoc()){
		if ($status["status_id"] == 1){
			while ($row = $admin_databaseResult->fetch_assoc()){
				fputcsv($output, $row);
			}
		}

		else {
			while ($row = $account_databaseResult->fetch_assoc()){
				fputcsv($output, $row);
			}
		}
		
	} 
	fclose($output);


?>