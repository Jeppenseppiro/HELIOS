<?php 
	require 'db_connect.php';

	if (isset($_GET["privilege"])){

		$url = $_GET["privilege"]; 

        $url_explode = $url;
        $url_exploded = (explode("/", $url_explode));

        $account_explode = $url_exploded[0];
        $ban_explode = $url_exploded[1]; 

			if ($ban_explode == 1){
				$Privilege_Query = "UPDATE tbl_account SET ban_privilege = '0' WHERE account_id = $account_explode";
				$conn->query($Privilege_Query);
				header("location: accounts.php");
			}

			else if ($ban_explode == 0){
				$Privilege_Query = "UPDATE tbl_account SET ban_privilege = '1' WHERE account_id = $account_explode";
				$conn->query($Privilege_Query);
				header("location: accounts.php");
			}

	}
?>