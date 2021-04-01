<?php 
	require 'db_connect.php';

	if (isset($_GET["status"])){

		$url = $_GET["status"]; 

        $url_explode = $url;
        $url_exploded = (explode("/", $url_explode));

        $account_explode = $url_exploded[0];
        $status_explode = $url_exploded[1];  


		$changeStatus_Query = "UPDATE tbl_account SET status_id = $status_explode WHERE account_id = $account_explode";
		$conn->query($changeStatus_Query);
		header("location: accounts.php");

	}
?>