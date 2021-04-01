<?php
	$ban_sessionusername = $_SESSION["username"];
	$ban_check = "SELECT * from tbl_account WHERE BINARY username = BINARY '$ban_sessionusername'";
	$ban_checkQuery = $conn->query($ban_check);

	while ($row = $ban_checkQuery->fetch_assoc()){
		if ($row["ban_privilege"] == 1){
			header("location: banned.php");
		}	
	}

?>