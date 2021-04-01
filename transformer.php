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

    $segmentID_get = $_GET["object"];
    $session_username = $_SESSION["username"];


  ?>
  <div id="content-wrapper">
  <div class="container-fluid">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            Database
          </li>
          <li class="breadcrumb-item active">Transformer Distribution Line Data</li>
        </ol>
    <form method="POST" enctype='multipart/form-data'>
    <div class="row">
      <div class="col-md-3">

          <?php 
            $transformerDatabase = "SELECT * from tbl_transformer INNER JOIN tbl_account ON tbl_transformer.account_id = tbl_account.account_id WHERE BINARY distribution_transformerid = BINARY '$segmentID_get'";
            $transformerDatabase_Query = $conn->query($transformerDatabase);

            if(isset($segmentID_get)){
              while ($row = $transformerDatabase_Query->fetch_assoc()){ 
                $modal_transformerID = $row["transformer_id"]; 
                echo '<div class="show-image"> '; 
                  echo "<button type='button' class='btn btn-success update_misc' ".$hide_btn." style='float: right;' onclick='showMiscUpdateBTN()'><i class='fas fa-edit'></i></button>";    

                echo' <center><h3>
                      '.$row["distribution_transformerid"].'
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
                                  <td contenteditable="false" id="sync_acoordinates" name="coordinates" style="text-align: right;" onkeyup="populateSecondTextBox();">'.$row["transformer_latitude"].','.$row["transformer_longitude"].'</td>
                                  <input type="hidden" id="sync_bcoordinates" name="coordinates" value="'.$row["transformer_latitude"].','.$row["transformer_longitude"].'"/>
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
                    $transformer_coordinates = $_POST["coordinates"]; 
                    $transformer_coordinates = explode(",", $transformer_coordinates);

                    $explode_latitude = $transformer_coordinates[0];
                    $explode_longitude = $transformer_coordinates[1];

                    if(isset($_POST["edit_MiscButton"])){
                      $update_misc = "UPDATE tbl_transformer SET transformer_latitude='$explode_latitude', transformer_longitude='$explode_longitude' WHERE transformer_id = '".$modal_transformerID."'";
                      //$conn->query($update_misc);

                      header("refresh: 0");
                    }
              } 
            } 
             
                  $transformerDatabase = "SELECT * from tbl_transformer INNER JOIN tbl_account ON tbl_transformer.account_id = tbl_account.account_id WHERE BINARY distribution_transformerid = BINARY '$segmentID_get'";
                  $transformerDatabase_Query = $conn->query($transformerDatabase);

                  if(isset($segmentID_get)){
                    while ($row = $transformerDatabase_Query->fetch_assoc()){
                      $transformer_householdID = $row["transformer_id"];
                      echo '<div class="col-md-9">
                              <div class="tabbable" id="tabs-89172">
                                <ul class="nav nav-tabs">
                                  <li class="nav-item">
                                    <a class="nav-link active show" href="#tab1" data-toggle="tab">Information</a>
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
                                      <label for="exampleInputEmail1"> From Primary Bus ID </label> 
                                      <select class="custom-select" id="primary_busid" name="primary_busid" '.$disabled.'>
                                        <option selected>'.$row["primary_busid"].'</option>';
                                        $primary_busIDtbl = "SELECT * FROM tbl_primary ORDER BY from_busid ASC";
                                        $primary_busIDtblQuery = $conn->query($primary_busIDtbl);

                                        while ($primary_tblBUS = $primary_busIDtblQuery->fetch_assoc()){
                                          echo '<option value='.$primary_tblBUS["from_busid"].'>'.$primary_tblBUS["from_busid"].'</option>';
                                        }
                      echo '          </select>
                                    </div>

                                    <div class="col-md-6"> 
                                      <label for="exampleInputPassword1"> To Secondary Bus ID </label> 
                                      <select class="custom-select" id="secondary_busid" name="secondary_busid" '.$disabled.'>
                                        <option selected>'.$row["secondary_busid"].'</option>'; 
                                        $secondary_busIDtbl = "SELECT * FROM tbl_secondary ORDER BY from_busid ASC";
                                        $secondary_busIDtblQuery = $conn->query($secondary_busIDtbl);

                                        while ($secondary_tblBUS = $secondary_busIDtblQuery->fetch_assoc()){
                                          echo '<option value='.$secondary_tblBUS["from_busid"].'>'.$secondary_tblBUS["from_busid"].'</option>';
                                        }
                      echo '          </select>
                                    </div>
                                  </div> 
                                   
                                  <hr>

                                  <div class="row"> 
                                    <div class="col-md-6">
                                      <label for="exampleInputEmail1"> Primary Phasing </label>                                   
                                      <select class="custom-select" id="primary_phasing" name="primary_phasing" '.$disabled.'>
                                        <option selected class="bg-success">'.$row["primary_phasing"].'</option>
                                        <option value="BN">BN</option>
                                        <option value="CN">CN</option>
                                        <option value="ABM">ABM</option>
                                        <option value="ABCN">ABCN</option>
                                        <option value="ABN">ABN</option>
                                        <option value="ACN">ACN</option>
                                        <option value="BCN">BCN</option>
                                      </select>

                                      <label for="exampleInputEmail1"> Secondary Phasing </label>                                   
                                      <select class="custom-select" id="secondary_phasing" name="secondary_phasing" '.$disabled.'>
                                        <option selected class="bg-success">'.$row["secondary_phasing"].'</option>
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
                                        <option selected class="bg-success">'.$row["installation_type"].'</option>
                                        <option value="Pole-Mounted">Pole-Mounted</option>
                                        <option value="Pad-Mounted">Pad-Mounted</option> 
                                      </select>

                                    </div>
                                    <div class="col-md-6">

                                      <label for="exampleInputEmail1"> No. DTs in Bank </label>
                                      <select class="custom-select" id="dts_bank" name="dts_bank" '.$disabled.'>
                                        <option selected class="bg-success">'.$row["dts_bank"].'</option>
                                        <option value="1">1</option>
                                        <option value="4">4</option> 
                                      </select>

                                      <label for="exampleInputEmail1"> Connection </label> 
                                      <select class="custom-select" id="connection" name="connection" '.$disabled.'>
                                        <option selected class="bg-success">'.$row["connection"].'</option>
                                        <option value="1">1</option>
                                        <option value="10">10</option>
                                      </select>

                                      <label for="exampleInputEmail1"> KVA Rating </label>
                                      <select class="custom-select" id="kva_rating" name="kva_rating" '.$disabled.'>
                                        <option selected>'.$row["kva_rating"].'</option>
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="25">25</option>
                                        <option value="37.5">37.5</option>
                                        <option value="50">50</option>
                                        <option value="75">75</option> 
                                      </select>
                                    </div>
                                  </div>

                                  <hr>

                                  <div class="row"> 
                                    <div class="col-md-6">
                                      <label for="exampleInputEmail1"> Primary Voltage Rating (kV) </label>
                                      <input type="text" class="form-control" id="primary_voltagerating" name="primary_voltagerating" value="'.$row["primary_voltagerating"].'" '.$readonly.'/>

                                      <label for="exampleInputEmail1"> Secondary Voltage Rating (kV) </label>
                                      <input type="text" class="form-control" id="secondary_voltagerating" name="secondary_voltagerating" value="'.$row["secondary_voltagerating"].'" '.$readonly.'/>

                                      <label for="exampleInputEmail1"> Primary Tap Voltage (kV) </label>
                                      <input type="text" class="form-control" id="primary_tapvoltage" name="primary_tapvoltage" value="'.$row["primary_tapvoltage"].'" '.$readonly.'/> 

                                      <label for="exampleInputEmail1"> Secondary Tap Voltage (kV) </label>
                                      <input type="text" class="form-control" id="secondary_tapvoltage" name="secondary_tapvoltage" value="'.$row["secondary_tapvoltage"].'" '.$readonly.'/> 
                                    </div>

                                    <div class="col-md-6">
                                      <label for="exampleInputEmail1"> %Z </label>
                                      <input type="text" class="form-control" id="percent_z" name="percent_z" value="'.$row["percent_z"].'" '.$readonly.'/>

                                      <label for="exampleInputEmail1"> X/R Ratio </label>
                                      <input type="text" class="form-control" id="xr_ratio" name="xr_ratio" value="'.$row["xr_ratio"].'" '.$readonly.'/>

                                      <label for="exampleInputEmail1"> No-Load Loss (kW) </label>
                                      <input type="text" class="form-control" id="noload_loss" name="noload_loss" value="'.$row["noload_loss"].'" '.$readonly.'/>

                                      <label for="exampleInputEmail1"> Exciting Current (%) (kW) </label>
                                      <input type="text" class="form-control" id="exciting_current" name="exciting_current" value="'.$row["exciting_current"].'" '.$readonly.'/> 
                                    </div>
                                  </div> 
                                  <br>
                                  <button type="submit" class="btn btn-info" name="edit_TransformerButton">Update</button>
                              </div> ';
                    }
                  } 

                  if(isset($segmentID_get)){
                    echo '
                    <div class="tab-pane fade" id="tab3">
                      <br>
                        <button type="button" name="insert_Household" '.$hide_btn.' class="btn btn-info float-right" data-toggle="modal" data-target="#add_HouseholdTransformer">+</button><br><br>
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
                              $transformer_database = "SELECT * FROM tbl_transformer WHERE distribution_transformerid = '$segmentID_get'";
                              $transformer_databaseResult = $conn->query($transformer_database);  

                              while ($row = $transformer_databaseResult->fetch_assoc()){
                                $transformer_id = $row["transformer_id"];
                              }

                              $household_database = "SELECT * FROM tbl_household INNER JOIN tbl_account ON tbl_household.account_id = tbl_account.account_id WHERE transformer_id = '$transformer_id'";
                              $household_databaseResult = $conn->query($household_database);                 

                              if(isset($segmentID_get)){
                                while ($row = $household_databaseResult->fetch_assoc()){     
                                  echo '<tr>
                                          <td>'.$row["household_id"].'</td>
                                          <td>'.$row["hh_fname"].' '.$row["hh_mname"].' '.$row["hh_lname"].'</td>
                                          <td><a href="profile.php?username='.$row["username"].'">'.$row['username'].' ('.$row['fname']." ".$row['lname'].')</a></td>
                                          <td>'.$row["date_created"].'</td>
                                          <td>'.$row["date_updated"].'</td>
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

        if(isset($_POST["edit_TransformerButton"])){
          $date_updated = date('m/d/Y h:i A');
          $date_created = date('m/d/Y h:i A');

          $primary_busid = mysqli_escape_string($conn, $_POST["primary_busid"]);
          $secondary_busid = mysqli_escape_string($conn, $_POST["secondary_busid"]);
          $primary_phasing = mysqli_escape_string($conn, $_POST["primary_phasing"]);
          $secondary_phasing = mysqli_escape_string($conn, $_POST["secondary_phasing"]);
          $installation_type = mysqli_escape_string($conn, $_POST["installation_type"]);
          $dts_bank = mysqli_escape_string($conn, $_POST["dts_bank"]);
          $connection = mysqli_escape_string($conn, $_POST["connection"]);
          $kva_rating = mysqli_escape_string($conn, $_POST["kva_rating"]);
          $primary_voltagerating = mysqli_escape_string($conn, $_POST["primary_voltagerating"]);
          $secondary_voltagerating = mysqli_escape_string($conn, $_POST["secondary_voltagerating"]);
          $primary_tapvoltage = mysqli_escape_string($conn, $_POST["primary_tapvoltage"]);
          $secondary_tapvoltage = mysqli_escape_string($conn, $_POST["secondary_tapvoltage"]);
          $percent_z = mysqli_escape_string($conn, $_POST["percent_z"]);
          $xr_ratio = mysqli_escape_string($conn, $_POST["xr_ratio"]);
          $noload_loss = mysqli_escape_string($conn, $_POST["noload_loss"]);
          $exciting_current = mysqli_escape_string($conn, $_POST["exciting_current"]); 
          $date_update = mysqli_escape_string($conn, $date_updated);

          
            $query = "UPDATE `tbl_transformer` SET `primary_busid` = '$primary_busid', `secondary_busid` = '$secondary_busid', `primary_phasing` = '$primary_phasing', `secondary_phasing` = '$secondary_phasing', `installation_type` = '$installation_type', `dts_bank` = '$dts_bank', `connection` = '$connection', `kva_rating` = '$kva_rating', `primary_voltagerating` = '$primary_voltagerating', `secondary_voltagerating` = '$secondary_voltagerating', `primary_tapvoltage` = '$primary_tapvoltage', `secondary_tapvoltage` = '$secondary_tapvoltage', `percent_z` = '$percent_z', `xr_ratio` = '$xr_ratio', `noload_loss` = '$noload_loss', `exciting_current` = '$exciting_current', `date_updated` = '$date_update' WHERE `distribution_transformerid` = '$segmentID_get'";

            $log_query .= 'INSERT INTO tbl_log (account_id, status_id, notification_id, log_status, url_link, date_created) VALUES ("'.$account_id.'", "'.$status_id.'", "6", "0", "marker.php?object='.$segmentID_get.'", "'.$date_created.'");';

            $conn->query($query);  
            $conn->query($log_query); 

            header("refresh: 0");         
          
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
          $transformerImage = "SELECT * from tbl_transformer WHERE BINARY distribution_transformerid = BINARY '$segmentID_get'";
          $transformerImage_Query = $conn->query($transformerImage);

          while ($row = $transformerImage_Query->fetch_assoc()){
            $transformer_imageID = $row["transformer_id"];
          }
          echo "url:'imageTransformer.php?object=".$segmentID_get."',";
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
        $transformerImage = "SELECT * from tbl_transformer WHERE BINARY distribution_transformerid = BINARY '$segmentID_get'";
        $transformerImage_Query = $conn->query($transformerImage);

        while ($row = $transformerImage_Query->fetch_assoc()){
          $transformer_imageID = $row["transformer_id"];
        }
        echo "url:'imageTransformer_fetch.php?object=".$segmentID_get."',";
      ?>  
      success:function(data)
      {
        $('#store_image').html(data);
      }
    })
  }

});  
</script>