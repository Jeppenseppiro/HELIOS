<?php
	require 'db_connect.php'; 

	if(isset($_POST["primary_id"])){
		
		$misc_query = "SELECT * FROM tbl_primary WHERE primary_id = '".$_POST["primary_id"]."'";
		$misc_result = $conn->query($misc_query);
 		$rows = mysqli_fetch_array($misc_result);
		
		echo json_encode($rows);

		$output .= '
            <input type="submit" class="btn btn-success" name="edit_PrimaryMiscbtn" id="edit_PrimaryMiscbtn" value="Misc Update">';

		//$hh_fname = mysqli_real_escape_string($conn, $_POST["hh_fname"]);
		//$hh_mname = mysqli_real_escape_string($conn, $_POST["hh_mname"]);
		//$hh_lname = mysqli_real_escape_string($conn, $_POST["hh_lname"]);

		//$update_query = "UPDATE tbl_household SET hh_fname='$hh_fname', hh_mname='$hh_mname', hh_lname='$hh_lname' WHERE household_id = '".$_POST["household_id"]."'";
		//$conn->query($update_query);
	}
?>