<?php
  require 'db_connect.php';
  session_start();
?>

<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>LEYECO V HELIOS</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

  <!-- Bootstrap -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <title>SB Admin - Tables</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body>
  <?php  

                      if(isset($_GET["edit"])){
                        $id = $_GET["edit"];
                        date_default_timezone_set('Asia/Manila'); 

                        $edit = "SELECT * from tbl_primary WHERE world_id=$id";
                        $edit_query = $conn->query($edit);

                        while ($row = $edit_query->fetch_assoc()){
                          $name = $row["name"];
                          $latitude = $row["latitude"];
                          $longitude = $row["longitude"];
                          $date_updated = date('m/d/Y h:i A');
                        }
                      } 

                      if(isset($_POST["update"])){
                        $id = $_GET["edit"];
                        $name = $_POST["name"];
                        $latitude = $_POST["latitude"];
                        $longitude = $_POST["longitude"];

                        $update = "UPDATE tbl_world SET name='$name', latitude='$latitude', longitude='$longitude', date_updated='$date_updated' WHERE world_id=$id";
                        $update_query = $conn->query($update);

                        echo "<script> alert('Update success')</script>";

                        header("location:database.php");
                      }

                      else if(isset($_POST["close"])){
                        header("location:database.php");
                      }


   ?>
            <center>
            <form form="edit.php" method="POST">
            <div class="card-body">
                          <input type="text" name="name" value="<?php echo $name; ?>">
                          </div>

                          <div class="card-body">
                          <input type="text" name="latitude" value="<?php echo $latitude; ?>">
                          </div>

                         <div class="card-body">
                          <input type="text" name="longitude" value="<?php echo $longitude; ?>">
                         </div>

                        
                         <div>
                          <button type="submit" name="close" class="btn btn-danger btn-xs remove">Close</button>
                          <button type="submit" name="update" class="btn btn-success btn-xs remove">Save Changes</button>
                        </div> 
                    </center>
            </form>
</body>
</html>