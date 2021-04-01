<?php 
  require 'db_connect.php';
  session_start();
  ob_start();
  date_default_timezone_set('Asia/Manila'); 

  require 'check_ban.php';
  require 'check_loggedin.php';
  require 'check_privilege.php';

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

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

  <!-- Bootstrap -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

  <title>SB Admin - Tables</title>
 

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet"> 

  <style type="text/css">

    div.show-image:hover a.update {
        display: block;
    }
    div.show-image a.update {
        position:absolute;
        display:none;
    }
    div.show-image a.update {
        top:0;
        left:0;
    } 

    div#store_image {
      border: none;
      color: white; 
      text-align: center;
      font-size: 16px;
      margin: 4px 2px;
      opacity: 1;
      transition: 0.3s;
    }

    div#store_image:hover {
      opacity: 0.6;
    }
  </style>

</head> 


<body id="page-top">
  

  <?php 
    require 'header.php';

    $distributionlineID_get = $_GET["object"];
    $session_username = $_SESSION["username"];


  ?>
  <div id="content-wrapper">
  <div class="container-fluid">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            Database
          </li>
          <li class="breadcrumb-item active">Secondary Distribution Line Data</li>
        </ol>
    <form method="POST" enctype='multipart/form-data'>
    <div class="row">
      <div class="col-md-3">

          <?php 
            $secondaryDatabase = "SELECT * from tbl_secondary INNER JOIN tbl_account ON tbl_secondary.account_id = tbl_account.account_id WHERE BINARY distribution_lineid = BINARY '$distributionlineID_get'";
            $secondaryDatabase_Query = $conn->query($secondaryDatabase);

            if(isset($distributionlineID_get)){
              while ($row = $secondaryDatabase_Query->fetch_assoc()){ 
                $modal_secondaryID = $row["secondary_id"]; 
                echo '<div class="show-image"> '; 
                  echo "<button type='button' class='btn btn-success update_misc' ".$hide_btn." style='float: right;' onclick='showMiscUpdateBTN()'><i class='fas fa-edit'></i></button>";    

                echo' <center><h3>
                      '.$row["distribution_lineid"].'
                      </h3></center>';
                echo '<div class="text-center">';

                if(empty($row['image'])){
                  echo '<img id="store_image" type="file" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar">';
                } else {
                  echo '<div id="store_image"></div>';
                }
                         
                echo' <input type="file" name="insert_image" id="insert_image" accept="image/*" style="display: none;"/> 
                      </div></hr><br>          
                              
                      <ul class="list-group">
                        <div class="card">
                            <div class="card-body">                    
                              <table width="100%">
                                <tr>
                                  <td style="padding-top: 10px; padding-bottom: 10px;"><strong>Coordinates:</strong></td>
                                  <td contenteditable="false" id="sync_acoordinates" name="coordinates" style="text-align: right;" onkeyup="populateSecondTextBox();"><a href="map.php?coordinates='.$row["secondary_latitude"].','.$row["secondary_longitude"].'">'.$row["secondary_latitude"].','.$row["secondary_longitude"].'</a></td>
                                  <input type="hidden" id="sync_bcoordinates" name="coordinates" value="'.$row["secondary_latitude"].','.$row["secondary_longitude"].'"/>
                                </tr>
                                <tr>
                                  <td style="padding-top: 10px; padding-bottom: 10px;"><strong>Inserted By:</strong></td>
                                  <td style="text-align: right;">&nbsp;<a href="profile.php?username='.$row["username"].'">'.$row['username'].' ('.$row['fname']." ".$row['lname'].')</a></td>
                                </tr> 
                                <tr>
                                  <td style="padding-top: 10px; padding-bottom: 10px;"><strong>Date Inserted:</strong></td>
                                  <td style="text-align: right;">'.$row["date_created"].'</td>
                                </tr>
                                <tr>
                                  <td style="padding-top: 10px; padding-bottom: 10px;"><strong>Date Updated:</strong></td>
                                  <td style="text-align: right;">'.$row["date_updated"].'</td>
                                </tr>
                              </table>
                            </div>
                        </div>                  
                      </ul>
                    </div> 
                    <button type="submit" class="btn btn-info" id="edit_MiscButton" name="edit_MiscButton" style="width: 100%; display: none;">Update</button>                   
                    </div>';
                    $secondary_coordinates = $_POST["coordinates"]; 
                    $secondary_coordinates = explode(",", $secondary_coordinates);

                    $explode_latitude = $secondary_coordinates[0];
                    $explode_longitude = $secondary_coordinates[1];

                    if(isset($_POST["edit_MiscButton"])){
                      $update_misc = "UPDATE tbl_secondary SET secondary_latitude='$explode_latitude', secondary_longitude='$explode_longitude' WHERE secondary_id = '".$modal_secondaryID."'";
                      //$conn->query($update_misc);

                      header("refresh: 0");
                    }
              } 
            } 
             
                  $secondaryDatabase = "SELECT * from tbl_secondary INNER JOIN tbl_account ON tbl_secondary.account_id = tbl_account.account_id WHERE BINARY distribution_lineid = BINARY '$distributionlineID_get'";
                  $secondaryDatabase_Query = $conn->query($secondaryDatabase);

                  if(isset($distributionlineID_get)){
                    while ($row = $secondaryDatabase_Query->fetch_assoc()){
                      $secondary_householdID = $row["secondary_id"];
                      echo '<div class="col-md-9">
                              <div class="tabbable" id="tabs-89172">
                                <ul class="nav nav-tabs">
                                  <li class="nav-item">
                                    <a class="nav-link active show" href="#tab1" data-toggle="tab">Secondary</a>
                                  </li>  
                                  <li class="nav-item">
                                    <a class="nav-link" href="#tab3" data-toggle="tab">Connected Households</a>
                                  </li> 
                                </ul>

                            <div class="tab-content">
                              <div class="tab-pane fade show active" id="tab1">
                                <br>
                                  <div class="row">  

                                    <div class="col-md-6">           
                                      <label for="exampleInputEmail1"> From Bus ID </label>
                                      <input type="text" class="form-control" id="from_busid" name="from_busid" value="'.$row["from_busid"].'" '.$readonly.'/>
                                    </div>

                                    <div class="col-md-6"> 
                                      <label for="exampleInputPassword1"> To Bus ID </label> 
                                      <select class="custom-select" id="to_busid" name="to_busid" '.$disabled.'>
                                        <option selected>'.$row["to_busid"].'</option>'; 
                                        $to_busIDoption = "SELECT * FROM tbl_secondary  ORDER BY from_busid ASC";
                                        $to_busIDoptionQuery = $conn->query($to_busIDoption);

                                        while ($to_busidSelect = $to_busIDoptionQuery->fetch_assoc()){
                                          echo '<option value='.$to_busidSelect["from_busid"].'>'.$to_busidSelect["from_busid"].'</option>';
                                        }
                      echo '          </select>
                                    </div>
                                  </div> 
                                   
                                  <hr>

                                  <div class="row"> 
                                    <div class="col-md-6">
                                      <label for="exampleInputEmail1"> Phasing </label>                                   
                                      <select class="custom-select" id="phasing" name="phasing" '.$disabled.'>
                                        <option selected class="bg-success">'.$row["phasing"].'</option>
                                        <option value="BN">BN</option>
                                        <option value="CN">CN</option>
                                        <option value="ABM">ABM</option>
                                        <option value="ABCN">ABCN</option>
                                        <option value="ABN">ABN</option>
                                        <option value="ACN">ACN</option>
                                        <option value="BCN">BCN</option>
                                      </select>

                                      <label for="exampleInputEmail1"> Installation Type </label> 
                                      <select class="custom-select" id="installation_type" name="installation_type" '.$disabled.'>
                                        <option selected>'.$row["installation_type"].'</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option> 
                                        <option value="4">4</option> 
                                        <option value="5">5</option> 
                                      </select>

                                    </div>
                                    <div class="col-md-6">

                                      <label for="exampleInputEmail1"> Length (meters) </label>
                                      <input type="text" class="form-control" id="length" name="length" value="'.$row["length"].'" '.$readonly.'/> 
                                      
                                      <label for="exampleInputEmail1"> Conductor Type </label>
                                      <select class="custom-select" id="conductor_type" name="conductor_type" '.$disabled.'>
                                        <option selected>'.$row["conductor_type"].'</option>
                                        <option value="ACSR">ACSR</option>  
                                      </select>                                      
                                    </div>

                                  </div>
                                  <div class="row"> 
                                    <div class="col-md-12">
                                      <label for="exampleInputEmail1"> Conductor Size </label>
                                      <select class="custom-select" id="conductor_size" name="conductor_size" '.$disabled.'>
                                        <option selected>'.$row["conductor_size"].'</option>
                                        <option value="2">2</option>
                                        <option value="1/0">1/0</option> 
                                        <option value="2/0">2/0</option> 
                                        <option value="3/0">3/0</option> 
                                        <option value="4">4/0</option> 
                                        <option value="336400">336400</option> 
                                      </select>
                                    </div>
                                  </div><br>
                                  <button type="submit" class="btn btn-info" name="edit_SecondaryButton">Update</button>
                              </div>';
                    }
                  } 

                  if(isset($distributionlineID_get)){
                    echo '
                    <div class="tab-pane fade" id="tab3">
                      <br>
                        <button type="button" name="insert_Household" '.$hide_btn.' class="btn btn-info float-right" data-toggle="modal" data-target="#add_HouseholdSecondary">+</button><br><br>
                        <div class="table-responsive">
                          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                              <tr>
                                <th>Count</th>
                                <th>Household Name</th>
                                <th>Inserted By</th>
                                <th>Date Created</th>
                                <th>Date Updated</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>Count</th>
                                <th>Household Name</th>
                                <th>Inserted By</th>
                                <th>Date Created</th>
                                <th>Date Updated</th>
                                <th>Action</th>
                              </tr>
                            </tfoot>
                            <tbody> ';                        
                    }        
                              $secondary_database = "SELECT * FROM tbl_secondary WHERE distribution_lineid = '$distributionlineID_get'";
                              $secondary_databaseResult = $conn->query($secondary_database);  

                              while ($row = $secondary_databaseResult->fetch_assoc()){
                                $secondary_id = $row["secondary_id"];
                              }

                              $household_database = "SELECT * FROM tbl_household INNER JOIN tbl_account ON tbl_household.account_id = tbl_account.account_id WHERE secondary_id = '$secondary_id'";
                              $household_databaseResult = $conn->query($household_database);                 

                              if(isset($distributionlineID_get)){
                                while ($row = $household_databaseResult->fetch_assoc()){     
                                  echo '<tr>
                                          <td>'.$row["household_id"].'</td>
                                          <td>'.$row["hh_fname"].' '.$row["hh_mname"].' '.$row["hh_lname"].'</td>
                                          <td><a href="profile.php?username='.$row["username"].'">'.$row['username'].' ('.$row['fname']." ".$row['lname'].')</a></td>
                                          <td></td>
                                          <td></td>
                                          <td>
                                            <div class="dropdown">
                                              <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-list"></i>
                                              </button>
                                              <div class="dropdown-menu">';

                                                  $modal_householdID = $row["household_id"];
                                                  echo "  <a href='#' name='edit' value='edit' id='".$modal_householdID."' class='btn btn-info edit_data' ".$hide_btn."/><i class='fas fa-edit'></i></a>";
                                          

                                             
                                                  echo "  <a href='#' id='".$row["segment_id"]."' data-id='".$row["segment_id"]."' data-toggle='modal' data-target='#deletePrimaryModal' class='btn btn-danger btn-xs remove delete_data' ".$hide_btnDelete."><i class='fas fa-trash'></i></a>";
                                            
                                      echo    '</div>
                                            </div> 
                                          </td>                                       
                                        </tr>';
                                }  
                              }  ?>                          
        

                          </tbody>
                        </table>
                      </div>

                  </div><br>
                  
                  
                            </div>
                          </div>       
                        </div>           
    

      <?php
        $session_username = $_SESSION["username"];
        $account = "SELECT * from tbl_account WHERE BINARY username = BINARY '$session_username'";
        $account_inserter = $conn->query($account);

        while ($row = $account_inserter->fetch_assoc()){
          $account_id = $row["account_id"];
          $status_id = $row["status_id"];
        }

        if(isset($_POST["edit_SecondaryButton"])){
          $date_updated = date('m/d/Y h:i A');
          $date_created = date('m/d/Y h:i A');

          $from_busid = mysqli_escape_string($conn, $_POST["from_busid"]);
          $to_busid = mysqli_escape_string($conn, $_POST["to_busid"]);
          $phasing = mysqli_escape_string($conn, $_POST["phasing"]);
          $installation_type = mysqli_escape_string($conn, $_POST["installation_type"]); 
          $length = mysqli_escape_string($conn, $_POST["length"]);
          $conductor_type = mysqli_escape_string($conn, $_POST["conductor_type"]);
          $conductor_size = mysqli_escape_string($conn, $_POST["conductor_size"]); 
          $date_update = mysqli_escape_string($conn, $date_updated);

          if($from_busid != $to_busid){
            $query = "UPDATE `tbl_secondary` SET `from_busid` = '$from_busid', `to_busid` = '$to_busid', `phasing` = '$phasing', `installation_type` = '$installation_type', `length` = '$length', `conductor_type` = '$conductor_type', `conductor_size` = '$conductor_size', `date_updated` = '$date_update' WHERE `distribution_lineid` = '$distributionlineID_get'";

            $log_query .= 'INSERT INTO tbl_log (account_id, status_id, notification_id, log_status, url_link, date_created) VALUES ("'.$account_id.'", "'.$status_id.'", "5", "0", "marker.php?object='.$distributionlineID_get.'", "'.$date_created.'");';

            $conn->query($query);  
            $conn->query($log_query); 

            header("refresh: 0");
          } else {
            header("location: index.php");
          }
          
        }
      ?>
    </form>   
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
    $(document).ready(function(){
      $(document).on('click', '.edit_data', function(){
        var household_id = $(this).attr("id");

        $.ajax({
          url:"editHousehold.php",
          method:"POST",
          data:{household_id:household_id},
          dataType:"json",
          success:function(data){
            $('#household_id').val(data.household_id);
            $('#hh_fname').val(data.hh_fname);
            $('#hh_mname').val(data.hh_mname);
            $('#hh_lname').val(data.hh_lname);

            $('#edit_Householdbtn').val("Update");
            $('#edit_Household').modal("show");
          }
        });      
      });
    }); 

    function showMiscUpdateBTN() {
      var coordinates_cell = document.getElementById("sync_acoordinates");

      if (coordinates_cell.contentEditable === "false"){
        coordinates_cell.contentEditable = "true";
        coordinates_cell.style.backgroundColor = "lightblue";
      } else {
        coordinates_cell.contentEditable = "false";
        coordinates_cell.style.backgroundColor = "transparent";
      }

      var x = document.getElementById("edit_MiscButton");

      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    }
 

    function populateSecondTextBox() {
      document.getElementById('sync_bcoordinates').value = document.getElementById('sync_acoordinates').value;
    }

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
          $secondaryImage = "SELECT * from tbl_secondary WHERE BINARY distribution_lineid = BINARY '$distributionlineID_get'";
          $secondaryImage_Query = $conn->query($secondaryImage);

          while ($row = $secondaryImage_Query->fetch_assoc()){
            $secondary_imageID = $row["secondary_id"];
          }
          echo "url:'imageSecondary.php?object=".$distributionlineID_get."',";
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
        $secondaryImage = "SELECT * from tbl_secondary WHERE BINARY distribution_lineid = BINARY '$distributionlineID_get'";
        $secondaryImage_Query = $conn->query($secondaryImage);

        while ($row = $secondaryImage_Query->fetch_assoc()){
          $secondary_imageID = $row["secondary_id"];
        }
        echo "url:'imageSecondary_fetch.php?object=".$distributionlineID_get."',";
      ?>  
      success:function(data)
      {
        $('#store_image').html(data);
      }
    })
  }

});  
</script>