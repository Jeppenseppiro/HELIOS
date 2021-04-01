<?php 
  require 'db_connect.php';
  session_start();
  ob_start();

  $session_username = $_SESSION["username"];

  require 'check_ban.php';
  require 'check_loggedin.php';

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
?>
<DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>LEYECO V HELIOS</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <link rel="stylesheet" href="css/bootnavbar.css">
  <script src="js/bootnavbar.js" ></script>


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

<body id="page-top">

  <?php 
    require 'header.php';

    
    $status_convert = "SELECT * from tbl_account INNER JOIN tbl_status ON tbl_account.status_id = tbl_status.status_id WHERE username = '$session_username'";
    $status_query = $conn->query($status_convert);

    while ($status_row = $status_query->fetch_assoc()){
      $status_final = $status_row["status"]; 
    }

    $updatePrivilege = "SELECT * from tbl_account WHERE BINARY username = BINARY '$session_username'";
    $updatePrivilege_Query = $conn->query($updatePrivilege);
  ?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            Database
          </li>
          <li class="breadcrumb-item active">Primary Distribution Line Data</li>
        </ol>

        <!-- DataTables Example -->

        <form method='POST' enctype='multipart/form-data'>

        <div class="card mb-3">
          <div class="card-body">           

                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">                    
                    <input type="file" name="importPrimary_FileAppend" style="float: left;"/> 
                    <input type="submit" name="importPrimaryAppend" value="CSV Import" class="btn btn-info" >
                    <input type="submit" name="exportPrimary" value="CSV Export" class="btn btn-info" style="float: right;"><br><br>
                    <?php 
                      if(isset($_POST["importPrimaryAppend"])){
                        if($_FILES['importPrimary_FileAppend']['name']){
                          $filename = explode(".", $_FILES['importPrimary_FileAppend']['name']);
                          if($filename[1] == 'csv'){
                            $handle = fopen($_FILES['importPrimary_FileAppend']['tmp_name'], "r");
                            while($data = fgetcsv($handle)){
                              $primary_id = mysqli_escape_string($conn, $data[0]);
                              $account_id = mysqli_escape_string($conn, $data[1]);
                              $layer_id = mysqli_escape_string($conn, $data[2]);
                              $segment_id = mysqli_escape_string($conn, $data[3]);
                              $from_busid = mysqli_escape_string($conn, $data[4]);
                              $to_busid = mysqli_escape_string($conn, $data[5]);
                              $phasing = mysqli_escape_string($conn, $data[6]);
                              $configuration = mysqli_escape_string($conn, $data[7]);
                              $grounding_type = mysqli_escape_string($conn, $data[8]);
                              $length = mysqli_escape_string($conn, $data[9]);
                              $conductor_type = mysqli_escape_string($conn, $data[10]);
                              $conductor_size = mysqli_escape_string($conn, $data[11]);
                              $unit = mysqli_escape_string($conn, $data[12]);
                              $strands = mysqli_escape_string($conn, $data[13]);
                              $neutral_wiretype = mysqli_escape_string($conn, $data[14]);
                              $neutral_wiresize = mysqli_escape_string($conn, $data[15]);
                              $unit_nw = mysqli_escape_string($conn, $data[16]);
                              $strands_nw = mysqli_escape_string($conn, $data[17]);
                              $spacing_d12 = mysqli_escape_string($conn, $data[18]);
                              $spacing_d23 = mysqli_escape_string($conn, $data[19]);
                              $spacing_d13 = mysqli_escape_string($conn, $data[20]);
                              $spacing_d1n = mysqli_escape_string($conn, $data[21]);
                              $spacing_d2n = mysqli_escape_string($conn, $data[22]);
                              $spacing_d3n = mysqli_escape_string($conn, $data[23]);
                              $spacing_dc1c2 = mysqli_escape_string($conn, $data[24]);
                              $height_h1 = mysqli_escape_string($conn, $data[25]);
                              $height_h2 = mysqli_escape_string($conn, $data[26]);
                              $height_h3 = mysqli_escape_string($conn, $data[27]);
                              $height_hn = mysqli_escape_string($conn, $data[28]);
                              $earth_relativity = mysqli_escape_string($conn, $data[29]);
                              $primary_latitude = mysqli_escape_string($conn, $data[30]);
                              $primary_longitude = mysqli_escape_string($conn, $data[31]);
                              $date_created = mysqli_escape_string($conn, $data[32]);
                              $date_update = mysqli_escape_string($conn, $data[33]);
                              $image = mysqli_escape_string($conn, $data[34]);

                              //$check_primaryRows = "SELECT * from tbl_primary";
                              //$check_primaryRowsQuery = $conn->query($check_primaryRows);

                              /*$query = "INSERT INTO tbl_primary (`account_id`, `layer_id`, `segment_id`, `from_busid`, `to_busid`, `phasing`, `configuration`, `grounding_type`, `length`, `conductor_type`, `conductor_size`, `unit`, `strands`, `neutral_wiretype`, `neutral_wiresize`, `unit_nw`, `strands_nw`, `spacing_d12`, `spacing_d23`, `spacing_d13`, `spacing_d1n`, `spacing_d2n`, `spacing_d3n`, `spacing_dc1c2`, `height_h1`, `height_h2`, `height_h3`, `height_hn`, `earth_resistivity`, `primary_latitude`, `primary_longitude`, `date_created`, `date_updated`, `image`)
                                        SELECT * FROM (SELECT '$account_id', '$layer_id', '$segment_id', '$from_busid', '$to_busid', '$phasing', '$configuration', '$grounding_type', '$length', '$conductor_type', '$conductor_size', '$unit', '$strands', '$neutral_wiretype', '$neutral_wiresize', '$unit_nw', '$strands_nw', '$spacing_d12', '$spacing_d23', '$spacing_d13', '$spacing_d1n', '$spacing_d2n', '$spacing_d3n', '$spacing_dc1c2', '$height_h1', '$height_h2', '$height_h3', '$height_hn', '$earth_relativity', '$primary_latitude ', '$primary_longitude', '$date_created', '$date_update', '$image') AS tmp
                                        WHERE NOT EXISTS (
                                            SELECT segment_id FROM tbl_primary WHERE segment_id = '$segment_id'
                                        )";

                              $query = "INSERT INTO members (`account_id`, `layer_id`, `segment_id`, `from_busid`, `to_busid`, `phasing`, `configuration`, `grounding_type`, `length`, `conductor_type`, `conductor_size`, `unit`, `strands`, `neutral_wiretype`, `neutral_wiresize`, `unit_nw`, `strands_nw`, `spacing_d12`, `spacing_d23`, `spacing_d13`, `spacing_d1n`, `spacing_d2n`, `spacing_d3n`, `spacing_dc1c2`, `height_h1`, `height_h2`, `height_h3`, `height_hn`, `earth_resistivity`, `primary_latitude`, `primary_longitude`, `date_created`, `date_updated`, `image`)
                                        SELECT segment_id
                                        FROM tbl_primary
                                        WHERE tbl_primary.segment_id NOT IN (
                                          SELECT segment_id FROM members WHERE segment_id IS NOT NULL
                                        )";*/

                              $query = "INSERT INTO `tbl_primary` (`account_id`, `layer_id`, `segment_id`, `from_busid`, `to_busid`, `phasing`, `configuration`, `grounding_type`, `length`, `conductor_type`, `conductor_size`, `unit`, `strands`, `neutral_wiretype`, `neutral_wiresize`, `unit_nw`, `strands_nw`, `spacing_d12`, `spacing_d23`, `spacing_d13`, `spacing_d1n`, `spacing_d2n`, `spacing_d3n`, `spacing_dc1c2`, `height_h1`, `height_h2`, `height_h3`, `height_hn`, `earth_resistivity`, `primary_latitude`, `primary_longitude`, `date_created`, `date_updated`, `image`) VALUES ('$account_id', '$layer_id', '$segment_id', '$from_busid', '$to_busid', '$phasing', '$configuration', '$grounding_type', '$length', '$conductor_type', '$conductor_size', '$unit', '$strands', '$neutral_wiretype', '$neutral_wiresize', '$unit_nw', '$strands_nw', '$spacing_d12', '$spacing_d23', '$spacing_d13', '$spacing_d1n', '$spacing_d2n', '$spacing_d3n', '$spacing_dc1c2', '$height_h1', '$height_h2', '$height_h3', '$height_hn', '$earth_relativity', '$primary_latitude ', '$primary_longitude', '$date_created', '$date_update', '$image') ";

                              $conn->query($query);
                            }

                            fclose($handle);
                            print "Import done";
                          }
                        }
                      } 

                      else if (isset($_POST["exportPrimary"])){
                        header("location: exportPrimary.php");
                      }
                    ?>
                    <thead>
                      <tr>
                        <th>Count</th>
                        <th>Primary Distribution Segment ID</th>
                        <th>From Bus ID</th>
                        <th>To Bus ID</th>
                        <th>Inserted By</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Count</th>
                        <th>Primary Distribution Segment ID</th>
                        <th>From Bus ID</th>
                        <th>To Bus ID</th>
                        <th>Inserted By</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                    <tbody> 
                      <?php
                        $admin_database = "SELECT * from tbl_account INNER JOIN tbl_primary ON tbl_account.account_id = tbl_primary.account_id"; 
                        $admin_databaseResult = $conn->query($admin_database);   

                        $account_database = "SELECT * from tbl_account INNER JOIN tbl_primary ON tbl_account.account_id = tbl_primary.account_id WHERE BINARY username = BINARY '$session_username'";
                        $account_databaseResult = $conn->query($account_database);
                        
                          if ($status_final == 'Administrator' || $admin_permission_key == $account_permission_key){
                              while ($row = $admin_databaseResult->fetch_assoc()){
                                                               
                              echo "  <td>".$row["primary_id"]."</td>
                                      <td>".$row["segment_id"]."</td>
                                      <td>".$row["from_busid"]."</td>
                                      <td>".$row["to_busid"]."</td>
                                      <td><a href='profile.php?username=".$row["username"]."'>".$row["username"]." (".$row["fname"]." ".$row["mname"]." ".$row["lname"].")</a></td>
                                      <td>".$row["date_created"]."</td>
                                      <td>".$row["date_updated"]."</td>
                                      <td>
                                      <div class='dropdown'>
                                        <button class='btn btn-success dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                          <i class='fas fa-list'></i>
                                        </button>
                                        <div class='dropdown-menu'>";
                                          
                                          echo "  <a href='primary.php?object=".$row["segment_id"]."' class='btn btn-info btn-xs remove'><i class='fas fa-edit'></i></a>";
                                          echo "  <a href='deletePrimary.php?object=".$row["segment_id"]."' class='btn btn-danger btn-xs remove delete_data'><i class='fas fa-trash'></i></a>";
                                           
                                echo    "</div>
                                      </div>
                                      ";  
                              echo " </td></tr></form>";
                              } 
                          } 

                          else { 
                              while ($row = $account_databaseResult->fetch_assoc()){                               
                              echo "  <td>".$row["primary_id"]."</td>
                                      <td>".$row["segment_id"]."</td>
                                      <td>".$row["from_busid"]."</td>
                                      <td>".$row["to_busid"]."</td>
                                      <td><a href='profile.php?username=".$row["username"]."'>".$row["username"]." (".$row["fname"]." ".$row["mname"]." ".$row["lname"].")</a></td>
                                      <td>".$row["date_created"]."</td>
                                      <td>".$row["date_updated"]."</td>
                                      <td>
                                      <div class='dropdown'>
                                        <button class='btn btn-success dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                          <i class='fas fa-list'></i>
                                        </button>
                                        <div class='dropdown-menu'>";
                                          if ($row["update_privilege"] == 1){
                                            echo "  <a href='primary.php?object=".$row["segment_id"]."' class='btn btn-info btn-xs remove'><i class='fas fa-edit'></i></a>";
                                          }

                                          if ($row["delete_privilege"] == 1){
                                            echo "  <a href='deletePrimary.php?object=".$row["segment_id"]."' class='btn btn-danger btn-xs remove'><i class='fas fa-trash'></i></a>";
                                          } 
                                echo    "</div>
                                      </div>
                                      ";  
                              echo " </td></tr></form>";

                              } 
                          }                    
                                               
                      ?>
                      </form> 
                    </tbody>
                  </table>
                </div>
              

               
              <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
            </div>
            
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

        <p class="small text-center text-muted my-5">
          <em>More table examples coming soon...</em>
        </p>


      <!-- /.container-fluid -->

      <!-- Sticky Footer 
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>-->

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Pure Javascript -->
  <script type="text/javascript">
    $(function() {
      $('#sidebarToggle').click();
    });
  </script>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>


</body>

</html>
