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

  <link rel="stylesheet" href="css/croppie.css" />
  <script src="js/croppie.js"></script>

</head> 


<body id="page-top">

  <?php 
    require 'header.php';

    $object_get = $_GET["object"];
    $session_username = $_SESSION["username"];
  ?>


  

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

<div id="insertimageModal" class="modal" role="dialog">
   <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Crop & Insert Image</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8 text-center">
              <div id="image_demo" style="width:350px; margin-top:30px"></div>
            </div>
            <div class="col-md-4" style="padding-top:30px;">
          <br />
          <br />
          <br/>
              <button class="btn btn-success crop_image">Crop & Insert Image</button>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<script>
  $(document).ready(function(){

    $image_crop = $('#image_demo').croppie({
      enableExif: true,
      viewport: {
        width:200,
        height:200,
        type:'square' //circle
      },
      boundary:{
        width:300,
        height:300
      }    
    });

    $('#insert_image').on('change', function(){
      var reader = new FileReader();
      reader.onload = function (event) {
        $image_crop.croppie('bind', {
          url: event.target.result
        }).then(function(){
          console.log('jQuery bind complete');
        });
      }
      reader.readAsDataURL(this.files[0]);
      $('#insertimageModal').modal('show');
    });
  });

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