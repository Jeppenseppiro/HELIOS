<?php 
	require 'db_connect.php';

	if (isset($_GET["privilege"])){

		$url = $_GET["privilege"]; 

        $url_explode = $url;
        $url_exploded = (explode("/", $url_explode));

        $account_explode = $url_exploded[0];
        $delete_explode = $url_exploded[1]; 

			if ($delete_explode == 1){
				$Privilege_Query = "UPDATE tbl_account SET delete_privilege = '0' WHERE account_id = $account_explode";
				$conn->query($Privilege_Query);
				header("location: accounts.php");
			}

			else if ($delete_explode == 0){
				$Privilege_Query = "UPDATE tbl_account SET delete_privilege = '1' WHERE account_id = $account_explode";
				$conn->query($Privilege_Query);
				header("location: accounts.php");
			}

	}
?>