<?php
    require 'db_connect.php';

    $admin_permission = "SELECT * from tbl_account INNER JOIN tbl_status ON tbl_account.status_id = tbl_status.status_id WHERE status = 'Administrator'";
    $admin_permission_query = $conn->query($admin_permission);

    $session_username = $_SESSION["username"];
    $account_permission = "SELECT * from tbl_account INNER JOIN tbl_status ON tbl_account.status_id = tbl_status.status_id WHERE BINARY username = BINARY '$session_username'";
    $account_permission_query = $conn->query($account_permission);

    while ($row = $admin_permission_query->fetch_assoc()){
      $admin_permission_key = $row["permission_key"];      
    }

    while ($row = $account_permission_query->fetch_assoc()){
      $account_permission_key = $row["permission_key"];
      $account_privileges = $row["status"]; 
      $current_status = $row["status"];
    }

	$account_database = "SELECT * from tbl_account WHERE BINARY username = BINARY '$session_username'";
    $account_databaseResult = $conn->query($account_database);

    while ($row = $account_databaseResult->fetch_assoc()){
    	$insert_privilege = $row["insert_privilege"];
    	$update_privilege = $row["update_privilege"];
    	$delete_privilege = $row["delete_privilege"];
    }

    if ($update_privilege == '0' && $admin_permission_key != $account_permission_key){
        $readonly = "readonly"; 
        $disabled = "disabled";
        $hide_btn = "style='display: none;'";
    }

    if ($insert_privilege == '0' && $admin_permission_key != $account_permission_key){
        $readonlyInsert = "readonly"; 
        $disabledInsert = "disabled";
        $hide_btnInsert = "style='display: none;'";
    }

    if ($delete_privilege == '0'){
        $readonlyDelete = "readonly"; 
        $disabledDelete = "disabled";
        $hide_btnDelete = "style='display: none;'";
    }

  
?>