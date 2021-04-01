<?php
  require 'db_connect.php';
  session_start();
  ob_start();

  $primaryID = $_GET["object"];

  if(isset($_POST["image"])){ 
     $data = $_POST["image"];
     $image_array_1 = explode(";", $data);
     $image_array_2 = explode(",", $image_array_1[1]);
     $data = base64_decode($image_array_2[1]);
     $imageName = time() . '.png';

     file_put_contents($imageName, $data);

     $image_file = addslashes(file_get_contents($imageName)); 

     $query = "UPDATE tbl_primary SET image = '".$image_file."' WHERE segment_id = '$primaryID'";
     $conn->query($query); 
  }
?>