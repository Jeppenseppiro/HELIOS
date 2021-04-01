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

  <div class="container-fluid" style="padding: 50px;"> 
    <div class="row">
      <div class="col-sm-3"><!--left col-->
              
        <?php 
          $accounts = "SELECT * from tbl_account INNER JOIN tbl_status ON tbl_account.status_id = tbl_status.status_id WHERE BINARY username = BINARY '$username_get'";
          $accounts_result = $conn->query($accounts);

          while ($row =  $accounts_result->fetch_assoc()){
            $account_id = $row["account_id"]; 

                echo' <center><h3>
                      '.$row["username"].'
                      </h3></center>';
                echo '<div class="text-center">';

                if(empty($row['image'])){
                  echo '<img id="store_image" type="file" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar">';
                } else {
                  echo '<div id="store_image"></div>';
                }

                echo' <input type="file" name="insert_image" id="insert_image" accept="image/*" style="display: none;"/>';

                echo '</div>';
          } 
        ?>        

      

      <?php
        $account = "SELECT * from tbl_account INNER JOIN tbl_status ON tbl_account.status_id = tbl_status.status_id WHERE BINARY username = BINARY '$username_get'";
        $account_result = $conn->query($account);

        $post_quantity = "SELECT * FROM tbl_post WHERE account_id = '$account_id'";
        $post_quantityQuery = $conn->query($post_quantity);

        $comment_quantity = "SELECT * FROM tbl_comment WHERE account_id = '$account_id'";
        $comment_quantityQuery = $conn->query($comment_quantity);

        $primary = "SELECT * from tbl_primary WHERE account_id = '$account_id'";
        $primaryQuery = $conn->query($primary);

        $secondary = "SELECT * from tbl_secondary WHERE account_id = '$account_id'";
        $secondaryQuery = $conn->query($secondary);

        $transformer = "SELECT * from tbl_transformer WHERE account_id = '$account_id'";
        $transformerQuery = $conn->query($transformer);

        $household = "SELECT * from tbl_household WHERE account_id = '$account_id'";
        $householdQuery = $conn->query($household);

        while ($row = $account_result->fetch_assoc()) {
          echo ' <ul class="list-group">
                  <div id="accordion">
                    <div class="card">
                      <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      <div class="card-header" id="headingOne">
                        <h5 class="mb-0">                   
                          Objects                 
                        </h5>
                      </div>
                      </button>

                      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">                    
                          <table class="table" width="100%">
                            <tr>
                              <td style="padding-top: 10px; padding-bottom: 10px;"><strong>Primary</strong></td>
                              <td style="text-align: right;">'.$primaryQuery->num_rows.'</td>
                            </tr>
                            <tr>
                              <td style="padding-top: 10px; padding-bottom: 10px;"><strong>Secondary</strong></td>
                              <td style="text-align: right;">'.$secondaryQuery->num_rows.'</td>
                            </tr>
                            <tr>
                              <td style="padding-top: 10px; padding-bottom: 10px;"><strong>Transformers</strong></td>
                              <td style="text-align: right;">'.$transformerQuery->num_rows.'</td>
                            </tr>
                            <tr>
                              <td style="padding-top: 10px; padding-bottom: 10px;"><strong>Households</strong></td>
                              <td style="text-align: right;">'.$householdQuery->num_rows.'</td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">                  
                          Activity                   
                        </h5>
                      </div>
                      </button>
                      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                          <table class="table" width="100%">
                            <tr>
                              <td style="padding-top: 10px; padding-bottom: 10px;"><strong>Posts</strong></td>
                              <td style="text-align: right;">'.$post_quantityQuery->num_rows.'</td>
                            </tr>
                            <tr>
                              <td style="padding-top: 10px; padding-bottom: 10px;"><strong>Comments</strong></td>
                              <td style="text-align: right;">'.$comment_quantityQuery->num_rows.'</td>
                            </tr> 
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--<li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
                  <li class="list-group-item"><span class="pull-left"><strong>Primary</strong></span> 125</li>
                  <li class="list-group-item"><span class="pull-left"><strong>Secondary</strong></span> 13</li>
                  <li class="list-group-item"><span class="pull-left"><strong>Transformers</strong></span> 37</li>
                  <li class="list-group-item"><span class="pull-left"><strong>Households</strong></span> 37</li>-->
                </ul> 
              </div>

            <div class="col-md-9">
            <form method="POST" enctype="multipart/form-data">
              <div class="tabbable" id="tabs-890130">
                <ul class="nav nav-tabs">

                  <li class="nav-item">
                    <a class="nav-link active show" href="#tab1" data-toggle="tab">Profile</a>
                  </li>';

                  if($session_username == $username_get){
                    echo '<li class="nav-item">
                            <a class="nav-link" href="#tab2" data-toggle="tab">Settings</a>
                          </li>';
                  } 

          echo '</ul>

                <div class="tab-content">
                  <div class="tab-pane fade show active" id="tab1">
                      <div class="row">
                        <div class="col">
                          <h6>Firstname</h6>
                          <input type="text" class="form-control" name="firstname" placeholder="Firstname" value="'.$row["fname"].'" '.$readonly.' required>
                        </div>
                        <div class="col">
                          <h6>Middlename</h6>
                          <input type="text" class="form-control" name="middlename" placeholder="Middlename" value="'.$row["mname"].'" '.$readonly.' required>
                        </div>
                        <div class="col">
                          <h6>Lastname</h6>
                          <input type="text" class="form-control" name="lastname" placeholder="Lastname" value="'.$row["lname"].'" '.$readonly.' required>
                        </div>
                      </div>
                      <br>

                      <div class="row">
                        <div class="col">
                          <h6>Status</h6>
                          <input type="text" class="form-control" name="status" placeholder="Status" value="'.$row["status"].'" readonly>
                        </div> 
                      </div> 
                      <br>

                      <div class="row">
                        <div class="col">
                          <h6>Phone Number</h6>
                          <input type="text" class="form-control" name="phone_number" placeholder="Phone number" value="'.$row["phone_number"].'" '.$readonly.'>
                        </div>
                        <div class="col">
                          <h6>Email Address</h6>
                          <input type="email" class="form-control" name="email_address" placeholder="Email address" value="'.$row["email_address"].'" '.$readonly.'>
                        </div> 
                      </div><br>';
                      if($session_username == $username_get){
                        echo '<button type="submit" class="btn btn-info" name="profile_update" style="width: 100%; height: 100px;">Update</button>';
                      }

                      if(isset($_POST["profile_update"])){
                        $firstname = $_POST["firstname"];
                        $middlename = $_POST["middlename"];
                        $lastname = $_POST["lastname"];
                        $phone_number = $_POST["phone_number"];
                        $email_address = $_POST["email_address"];

                        $update_profile = "UPDATE tbl_account SET fname = '$firstname', mname = '$middlename', lname = '$lastname', phone_number = '$phone_number', email_address = '$email_address' WHERE username = '$session_username'";
                        $conn->query($update_profile);

                        unset($_POST["profile_update"]);

                        header("refresh: 0");
                      }
                      
            echo '</form>
                  <form method="POST">
                  </div>

                  <div class="tab-pane fade" id="tab2">
                    <p>
                      <h5>Password</h5>
                      <hr>
                        <div class="row"> 
                          <div class="col">
                            <h6>New Password</h6>
                            <div class="form-group"> 
                              <div class="input-group" id="show_newhide_password">
                                <input class="form-control" type="password" name="new_password" required>
                                <div class="input-group-append">
                                  <span class="input-group-text"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col">
                            <h6>Confirm Password</h6>
                            <div class="form-group"> 
                              <div class="input-group" id="show_confirmhide_password">
                                <input class="form-control" type="password" name="confirm_password" required>
                                <div class="input-group-append">
                                  <span class="input-group-text"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div><br>';

                        if($session_username == $username_get){
                          echo '<button type="submit" class="btn btn-info" name="setting_update" style="width: 100%; height: 100px;">Update</button>';
                        }

                        if(isset($_POST["setting_update"])){
                          $new_password = $_POST["new_password"];
                          $confirm_password = $_POST["confirm_password"]; 

                          if($new_password == $confirm_password){
                            $update_setting = "UPDATE tbl_account SET password = '$new_password' WHERE username = '$session_username'";
                            $conn->query($update_setting);

                            unset($_POST["setting_update"]);

                            header("refresh: 0");
                          } else {
                            echo '<script>alert("New password and confirm password are NOT the same")</script>';
                          }

                          
                        }

            echo   '</p>
                  </div>
                </div>
              </div>
            </div> 
            <hr> 
          </div>
          </form> ';
        }

        
      ?>
      

    </div>
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

  <?php require 'modals.php'; ?>

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

  <link rel="stylesheet" href="css/croppie.css" />
  <script src="js/croppie.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  </form>

  </body>

</html> 

<div class="modal" id="insertimageModal" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Crop Image</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
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
            <button class="btn btn-success crop_image">Save Image</button>
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
    $('#store_image').click(function(){ $('#insert_image').trigger('click'); });

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

    $('.crop_image').click(function(event){
      $image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
      }).then(function(response){
        $.ajax({
          <?php 
            $accountImage = "SELECT * from tbl_account WHERE BINARY username = BINARY '$username_get'";
            $accountImage_Query = $conn->query($accountImage);

            while ($row = $accountImage_Query->fetch_assoc()){
              $account_imageID = $row["account_id"];
            }
            echo "url:'imageProfile.php?username=".$username_get."',";
          ?>        
          type:'POST',
          data:{"image":response},
          success:function(data){
            $('#insertimageModal').modal('hide');
            load_images();
          }
        })
      });
    });

    load_images();

    function load_images()
    {
      $.ajax({
        <?php 
          $accountImage = "SELECT * from tbl_account WHERE BINARY username = BINARY '$username_get'";
          $accountImage_Query = $conn->query($accountImage);

          while ($row = $accountImage_Query->fetch_assoc()){
            $account_imageID = $row["account_id"];
          }
          echo "url:'imageProfile_fetch.php?username=".$username_get."',";
        ?>  
        success:function(data)
        {
          $('#store_image').html(data);
        }
      })
    }

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