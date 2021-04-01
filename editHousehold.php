<?php
	require 'db_connect.php'; 

	if(isset($_POST["household_id"])){
		
		$query = "SELECT * FROM tbl_household WHERE household_id = '".$_POST["household_id"]."'";
		$result = $conn->query($query);
 		$row = mysqli_fetch_array($result);
		
		echo json_encode($row);

		$output .= '
            <input type="submit" class="btn btn-success" name="edit_Householdbtn" id="edit_Householdbtn" value="Update">';

		//$hh_fname = mysqli_real_escape_string($conn, $_POST["hh_fname"]);
		//$hh_mname = mysqli_real_escape_string($conn, $_POST["hh_mname"]);
		//$hh_lname = mysqli_real_escape_string($conn, $_POST["hh_lname"]);

		//$update_query = "UPDATE tbl_household SET hh_fname='$hh_fname', hh_mname='$hh_mname', hh_lname='$hh_lname' WHERE household_id = '".$_POST["household_id"]."'";
		//$conn->query($update_query);
	}
?>