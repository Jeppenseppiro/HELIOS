<?php 
	require 'db_connect.php';

	if (isset($_GET["order"])){

		$url = $_GET["order"]; 

        $url_explode = $url;
        $url_exploded = (explode("/", $url_explode));

        $order_explode = $url_exploded[0];
        $status_explode = $url_exploded[1];  

			if ($status_explode == 1){
				$OrderStatus_Query = "UPDATE tbl_order SET order_status = '0' WHERE order_id = $order_explode";
				$conn->query($OrderStatus_Query);
				header("location: orderDatabase.php");
			}

			else if ($status_explode == 0){
				$OrderStatus_Query = "UPDATE tbl_order SET order_status = '1' WHERE order_id = $order_explode";
				$conn->query($OrderStatus_Query);
				header("location: orderDatabase.php");
			}

	}
?>