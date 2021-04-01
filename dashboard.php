<?php 
  require 'db_connect.php';
  session_start();
  ob_start();

  require 'check_ban.php';

  $session_username = $_SESSION["username"];
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


  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head> 


<body id="page-top">

  <?php 
    require 'header.php';

    $username_get = $_GET["username"];
    $session_username = $_SESSION["username"];
    
    if($session_username != $username_get){
      $readonly = "readonly"; 
    } else {
      $readonly = ""; 
    }
  ?>

  <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Charts</li>
        </ol> 

        <div class="row">
          <div class="col-lg-9">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-bar"></i>
                News</div>
              <div class="card-body">
                lol
              </div>
              <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>

              <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-bar"></i>
                News</div>
              <div class="card-body">
                lol
              </div>
              <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-bar"></i>
                Statistics</div>
              <div class="card-body">
                <table class="table" width="100%"> 
                  <thead>
                    <tr>
                      <th scope="col">Type</th>
                      <th scope="col" style="text-align: right;">Quantity</th> 
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">Primary</th>
                      <td style="text-align: right;">1</td>
                    </tr>
                    <tr>
                      <th scope="row">Secondary</th>
                      <td style="text-align: right;">1</td>
                    </tr>
                    <tr>
                      <th scope="row">Transformers</th>
                      <td style="text-align: right;">1</td>
                    </tr>
                    <tr>
                      <th scope="row">Households</th>
                      <td style="text-align: right;">1</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>

            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-bar"></i>
                History</div>
              <div class="card-body">
                <table width="100%" >
                  <tr>
                    <td style="padding-top: 10px; padding-bottom: 10px;"><strong>Primary</strong></td>
                    <td style="text-align: right;">1</td>
                  </tr>
                  <tr>
                    <td style="padding-top: 10px; padding-bottom: 10px;"><strong>Secondary</strong></td>
                    <td style="text-align: right;">1</td>
                  </tr>
                  <tr>
                    <td style="padding-top: 10px; padding-bottom: 10px;"><strong>Transformers</strong></td>
                    <td style="text-align: right;">1</td>
                  </tr>
                  <tr>
                    <td style="padding-top: 10px; padding-bottom: 10px;"><strong>Households</strong></td>
                    <td style="text-align: right;">1</td>
                  </tr>
                </table>
              </div>
              <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
          </div>
        </div>

        <p class="small text-center text-muted my-5">
          <em>More chart examples coming soon...</em>
        </p>

      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>

    </div>


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

<script type="text/javascript">
  $(document).ready(function() {
    $("#show_newhide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_newhide_password input').attr("type") == "text"){
            $('#show_newhide_password input').attr('type', 'password');
            $('#show_newhide_password i').addClass( "fa-eye-slash" );
            $('#show_newhide_password i').removeClass( "fa-eye" );
        }else if($('#show_newhide_password input').attr("type") == "password"){
            $('#show_newhide_password input').attr('type', 'text');
            $('#show_newhide_password i').removeClass( "fa-eye-slash" );
            $('#show_newhide_password i').addClass( "fa-eye" );
        }
    });
});

  $(document).ready(function() {
    $("#show_confirmhide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_confirmhide_password input').attr("type") == "text"){
            $('#show_confirmhide_password input').attr('type', 'password');
            $('#show_confirmhide_password i').addClass( "fa-eye-slash" );
            $('#show_confirmhide_password i').removeClass( "fa-eye" );
        }else if($('#show_confirmhide_password input').attr("type") == "password"){
            $('#show_confirmhide_password input').attr('type', 'text');
            $('#show_confirmhide_password i').removeClass( "fa-eye-slash" );
            $('#show_confirmhide_password i').addClass( "fa-eye" );
        }
    });
});
</script>

</html>
