<?php 
  require 'db_connect.php';
  session_start();
  ob_start();

  require 'check_ban.php';
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

    $session_username = $_SESSION["username"];
    $status_convert = "SELECT * from tbl_account INNER JOIN tbl_status ON tbl_account.status_id = tbl_status.status_id WHERE username = '$session_username'";
    $status_query = $conn->query($status_convert);

    $updatePrivilege = "SELECT * from tbl_account WHERE BINARY username = BINARY '$session_username'";
    $updatePrivilege_Query = $conn->query($updatePrivilege);
  ?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Tables</li>
        </ol>

        <!-- DataTables Example -->

        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Data Table Example</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  
                <tbody>
                  <form action="process.php" method="POST">
                  <?php 
                    $admin_database = "SELECT * from tbl_account INNER JOIN tbl_world ON tbl_account.account_id = tbl_world.account_id"; 
                    $admin_databaseResult = $conn->query($admin_database);   

                    $account_database = "SELECT * from tbl_account INNER JOIN tbl_world ON tbl_account.account_id = tbl_world.account_id WHERE BINARY username = BINARY '$session_username'";
                    $account_databaseResult = $conn->query($account_database); 

                    while ($status_row = $status_query->fetch_assoc()){
                      if ($status_row["status"] == 'Administrator'){
                        echo '<tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Inserted By</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Date Created</th>
                                <th>Date Updated</th>
                                <!--<th>Type</th>
                                <th>Layer</th>-->
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Inserted By</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Date Created</th>
                                <th>Date Updated</th>
                                <!--<th>Type</th>
                                <th>Layer</th>-->
                                <th>Action</th>
                              </tr>
                            </tfoot>';

                          while ($row = $admin_databaseResult->fetch_assoc()){
                                                           
                          echo "  <td>".$row["world_id"]."</td>
                                  <td name='name'>".$row["name"]."</td>
                                  <td name='account'>".$row["username"]."</td>
                                  <td name='latitude'>".$row["latitude"]."</td>
                                  <td name='longitude'>".$row["longitude"]."</td>
                                  <td name='date_created'>".$row["date_created"]."</td>
                                  <td name='date_updated'>".$row["date_updated"]."</td>
                                  "; 
                          echo "  <td><a href='edit.php?edit=".$row["world_id"]."' name='saveRow' class='btn btn-success btn-xs remove'>Update</a></td>
                                  </tr>
                                  </form>";
                          } 
                      }

                      else {
                        echo '<tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Date Created</th>
                                <th>Date Updated</th>
                                <!--<th>Type</th>
                                <th>Layer</th>-->
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Date Created</th>
                                <th>Date Updated</th>
                                <!--<th>Type</th>
                                <th>Layer</th>-->
                                <th>Action</th>
                              </tr>
                            </tfoot>';

                          while ($row = $account_databaseResult->fetch_assoc()){
                          $world_ID = $row["world_id"];                                
                          echo "  <td>".$world_ID."</td>
                                  <td name='name'>".$row["name"]."</td>
                                  <td name='latitude'>".$row["latitude"]."</td>
                                  <td name='longitude'>".$row["longitude"]."</td>
                                  <td name='date_created'>".$row["date_created"]."</td>
                                  <td name='date_updated'>".$row["date_updated"]."</td>
                                  <td>
                                  "; 
                            if ($row["update_privilege"] == 1){
                              echo "  <a data-toggle='modal' data-target='#update_database' href='#' name='saveRow' class='btn btn-success btn-xs remove'>Update</a>";
                            }

                            if ($row["delete_privilege"] == 1){
                              echo "  <a href='process.php?delete=".$row["world_id"]."' name='saveRow' class='btn btn-success btn-xs remove'>Delete</a>";
                            }

                            else{

                            }
                          echo " </td></tr></form>";

                          } 
                      }                       
                    }  
                  ?>
                  </form>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

        <p class="small text-center text-muted my-5">
          <em>More table examples coming soon...</em>
        </p>



  <!-- Update Modal-->
  <form method="POST">
    <div class="modal fade" id="update_database" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="usr">Name:</label>
              <?php 
                while ($account_db = $account_databaseResult->fetch_assoc()){
                  echo $account_db["account_id"];
                }

                echo "HERE!".$world_ID;
              ?>
              <input type="text" class="form-control" name="input_LayerName">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" name="addLayer_btn">Add</button>
          </div>
        </div>
      </div>
    </div>
  </form>

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
