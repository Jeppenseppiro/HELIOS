<?php 
  require 'db_connect.php';
  session_start();
  ob_start();

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

  if ($admin_permission_key != $account_permission_key){
   header("location: index.php");
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

        <form method='POST'>

        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Data Table Example</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <?php 
                      if ($account_privileges == "Administrator"){
                        echo '<th>Password</th>';
                      }
                    ?>                    
                    <th>Firstname</th>
                    <th>Middlename</th>
                    <th>Lastname</th>
                    <?php 
                      if ($account_privileges == "Administrator"){
                        echo '<th>Permission Keys</th>';
                      }
                    ?> 
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <?php 
                      if ($account_privileges == "Administrator"){
                        echo '<th>Password</th>';
                      }
                    ?> 
                    <th>Firstname</th>
                    <th>Middlename</th>
                    <th>Lastname</th>
                    <?php 
                      if ($account_privileges == "Administrator"){
                        echo '<th>Permission Keys</th>';
                      }
                    ?> 
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody> 
                  <?php 

                    $accounts = "SELECT * from tbl_account INNER JOIN tbl_status ON tbl_account.status_id = tbl_status.status_id WHERE status != 'Administrator'";
                    $accounts_query = $conn->query($accounts);

                    $layers_show = "SELECT * from tbl_layer";
                    $layers_show_result = $conn->query($layers_show);

                    while ($row = $accounts_query->fetch_assoc()){
                      $account_idStatus = $row["account_id"];
                      $btn_gray = "btn btn-dark btn-xs remove";
                      $btn_green = "btn btn-success btn-xs remove";

                      echo "  
                            <td>".$row["account_id"]."</td>
                            <td><a href='profile.php?username=".$row["username"]."'>".$row["username"]."</a></td>";

                            if ($account_privileges == "Administrator"){
                              echo "<td>".$row["password"]."</td>";
                            }
                            
                      echo "<td>".$row["fname"]."</td>
                            <td>".$row["mname"]."</td>
                            <td>".$row["lname"]."</td>";

                            if ($account_privileges == "Administrator"){
                              echo "<td>".$row["permission_key"]."</td>";
                            }
                            

                      if ($row["status"] == "Administrator"){
                        echo "<td> 
                              </td>
                              </tr>";
                      }

                      else{
                        if ($row["insert_privilege"] == 0){
                          $btn_insertPrivilege = $btn_gray;
                        }

                        if ($row["insert_privilege"] == 1){
                          $btn_insertPrivilege = $btn_green;
                        }

                        if ($row["update_privilege"] == 0){
                          $btn_updatePrivilege = $btn_gray;
                        }

                        if ($row["update_privilege"] == 1){
                          $btn_updatePrivilege = $btn_green;
                        }

                        if ($row["delete_privilege"] == 0){
                          $btn_deletePrivilege = $btn_gray;
                        }

                        if ($row["delete_privilege"] == 1){
                          $btn_deletePrivilege = $btn_green;
                        }

                        if ($row["ban_privilege"] == 0){
                          $btn_banPrivilege = $btn_gray;
                        }

                        if ($row["ban_privilege"] == 1){
                          $btn_banPrivilege = $btn_green;
                        }

                        if ($row["status_id"] < 1){
                          $btn_adminStatus = $btn_green;
                        } 

                        if ($account_privileges == "Administrator" || $row["username"] == $session_username){
                        echo "<td> 
                              <div class='dropdown'>
                                <button class='btn btn-success dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                  Privilege
                                </button>
                              <div class='dropdown-menu'>";
                        echo "<a href='insertPrivilege.php?privilege=".$row["account_id"]."/".$row["insert_privilege"]."' class='".$btn_insertPrivilege."'>Insert</a>
                              <a href='updatePrivilege.php?privilege=".$row["account_id"]."/".$row["update_privilege"]."' class='".$btn_updatePrivilege."'>Update</a>
                              <a href='deletePrivilege.php?privilege=".$row["account_id"]."/".$row["delete_privilege"]."' class='".$btn_deletePrivilege."'>Delete</a>";

                              if ($account_privileges == "Administrator"){
                                echo " <a href='banPrivilege.php?privilege=".$row["account_id"]."/".$row["ban_privilege"]."' class='".$btn_banPrivilege."'>Ban</a>";

                                echo  "</div>  
                                       <div class='dropdown'>
                                        <button class='btn btn-success dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"
                                          .$row["status"].
                                        "</button>
                                      <div class='dropdown-menu'>";
                                        $populate_status = "SELECT * from tbl_status WHERE status != 'Administrator'";
                                        $populate_statusQuery = $conn->query($populate_status);

                                        while ($row = $populate_statusQuery->fetch_assoc()){
                                          echo "<a href='changeStatus.php?status=".$account_idStatus."/".$row["status_id"]."' class='".$btn_adminStatus."'> ".$row["status"]."</a>";
                                        } 
                                echo "</div>";
                              }
                              
                                               
                        echo "</td>
                              </tr>";
                        }

                        else {
                          echo "<td></td></tr>";
                        }
                      }                   

                    
                    }

                      /*if ($update_explode == 1){
                        $inverseUpdate = 0;
                        $UpdatePrivilege_Update = "UPDATE tbl_account SET update_privilege = $inverseUpdate WHERE account_id = $account_explode";
                        $UpdatePrivilege_Change = $conn->query($UpdatePrivilege_Update);
                        header("location: accounts.php");
                      }

                      if ($update_explode == 0){
                        $inverseUpdate = 1;
                        $UpdatePrivilege_Update = "UPDATE tbl_account SET update_privilege = $inverseUpdate WHERE account_id = $account_explode";
                        $UpdatePrivilege_Change = $conn->query($UpdatePrivilege_Update);
                        header("location: accounts.php");
                      }*/

                 
                    
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
