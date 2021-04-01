<?php 
  require 'db_connect.php';
  session_start();
  ob_start();
  date_default_timezone_set('Asia/Manila'); 

  $session_username = $_SESSION["username"];

  require 'check_ban.php';
  require 'check_loggedin.php';
  require 'check_privilege.php';
  
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
          <li class="breadcrumb-item active">Primary Distribution Line Data</li>
        </ol>
    <form method="POST" enctype='multipart/form-data'>
    <div class="row">
      <div class="col-md-3">

          <?php 
            $status_account = "SELECT * FROM tbl_account INNER JOIN tbl_status ON tbl_account.status_id = tbl_status.status_id WHERE username = '$session_username'";
            $status_accountQuery = $conn->query($status_account);

            while ($row = $status_accountQuery->fetch_assoc()){
              $account_status = $row["status"];
            }

            $primaryDatabase = "SELECT * from tbl_primary INNER JOIN tbl_account ON tbl_primary.account_id = tbl_account.account_id WHERE BINARY segment_id = BINARY '$segmentID_get'";
            $primaryDatabase_Query = $conn->query($primaryDatabase);

            if(isset($segmentID_get)){
              while ($row = $primaryDatabase_Query->fetch_assoc()){ 
                $modal_primaryID = $row["primary_id"]; 
                echo '<div class="show-image"> '; 
                  echo "<button type='button' class='btn btn-success update_misc' onclick='showMiscUpdateBTN()' ".$hide_btn." style='float: right;'><i class='fas fa-edit'></i></button>";    

                echo' <center><h3>
                      '.$row["segment_id"].'
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
                                  <td contenteditable="false" id="sync_acoordinates" name="coordinates" style="text-align: right;" onkeyup="populateSecondTextBox();"><a href="map.php?coordinates='.$row["primary_latitude"].','.$row["primary_longitude"].'">'.$row["primary_latitude"].','.$row["primary_longitude"].'</a></td>
                                  <input type="hidden" id="sync_bcoordinates" name="coordinates" value="'.$row["primary_latitude"].','.$row["primary_longitude"].'"/>
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
                    $primary_coordinates = $_POST["coordinates"]; 
                    $primary_coordinates = explode(",", $primary_coordinates);

                    $explode_latitude = $primary_coordinates[0];
                    $explode_longitude = $primary_coordinates[1];

                    if(isset($_POST["edit_MiscButton"])){
                      $update_misc = "UPDATE tbl_primary SET primary_latitude='$explode_latitude', primary_longitude='$explode_longitude' WHERE primary_id = '".$modal_primaryID."'";
                      //$conn->query($update_misc);

                      header("refresh: 0");
                    }
              } 
            } 
             
                  $primaryDatabase = "SELECT * from tbl_primary INNER JOIN tbl_account ON tbl_primary.account_id = tbl_account.account_id WHERE BINARY segment_id = BINARY '$segmentID_get'";
                  $primaryDatabase_Query = $conn->query($primaryDatabase);

                  if(isset($segmentID_get)){
                    while ($row = $primaryDatabase_Query->fetch_assoc()){
                      $primary_householdID = $row["primary_id"];
                      echo '<div class="col-md-9">
                              <div class="tabbable" id="tabs-89172">
                                <ul class="nav nav-tabs">
                                  <li class="nav-item">
                                    <a class="nav-link active show" href="#tab1" data-toggle="tab">Primary (1)</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" href="#tab2" data-toggle="tab">Primary (2)</a>
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
                                        $to_busIDoption = "SELECT * FROM tbl_primary  ORDER BY from_busid ASC";
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

                                      <label for="exampleInputEmail1"> Configuration </label> 
                                      <select class="custom-select" id="configuration" name="configuration" '.$disabled.'>
                                        <option selected>'.$row["configuration"].'</option>
                                        <option value="Triangular">Triangular</option>
                                        <option value="Vertical">Vertical</option>
                                        <option value="Horizontal">Horizontal</option> 
                                      </select>

                                      <label for="exampleInputEmail1"> System Grounding Type </label>
                                      <select class="custom-select" id="grounding_type" name="grounding_type" '.$disabled.'>
                                        <option selected>'.$row["grounding_type"].'</option>
                                        <option value="Multi-Grounded">Multi-Grounded</option> 
                                      </select>

                                      <label for="exampleInputEmail1"> Length (meters) </label>
                                      <input type="text" class="form-control" id="length" name="length" value="'.$row["length"].'" '.$readonly.'/>

                                      <label for="exampleInputEmail1"> Conductor Type </label>
                                      <select class="custom-select" id="conductor_type" name="conductor_type" '.$disabled.'>
                                        <option selected>'.$row["conductor_type"].'</option>
                                        <option value="ACSR">ACSR</option> 
                                      </select>

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
                                    <div class="col-md-6">
                                      <label for="exampleInputEmail1"> Unit (C) </label>
                                      <select class="custom-select" id="unit" name="unit" '.$disabled.'>
                                        <option selected>'.$row["unit"].'</option>
                                        <option value="AWG">AWG</option>
                                        <option value="CM">CM</option>
                                      </select>

                                      <label for="exampleInputEmail1"> Strands (C) </label> 
                                      <select class="custom-select" id="strands" name="strands" '.$disabled.'>
                                        <option selected>'.$row["strands"].'</option>
                                        <option value="6/1">6/1</option> 
                                        <option value="26/7">26/7</option>
                                      </select>

                                      <label for="exampleInputEmail1"> Neutral Wire Type </label>
                                      <select class="custom-select" id="neutral_wiretype" name="neutral_wiretype" '.$disabled.'>
                                        <option selected>'.$row["neutral_wiretype"].'</option>
                                        <option value="ACSR">ACSR</option> 
                                      </select>

                                      <label for="exampleInputEmail1"> Neutral Wire Size </label> 
                                      <select class="custom-select" id="neutral_wiresize" name="neutral_wiresize" '.$disabled.'>
                                        <option selected>'.$row["neutral_wiresize"].'</option>
                                        <option value="2">2</option>
                                        <option value="1/0">1/0</option> 
                                        <option value="2/0">2/0</option> 
                                        <option value="3/0">3/0</option> 
                                        <option value="4/0">4/0</option>  
                                      </select>

                                      <label for="exampleInputEmail1"> Unit (NW) </label>
                                      <select class="custom-select" id="unit_nw" name="unit_nw" '.$disabled.'>
                                        <option selected>'.$row["unit_nw"].'</option>
                                        <option value="AWG">AWG</option>
                                      </select>

                                      <label for="exampleInputEmail1"> Strands (NW) </label>
                                      <select class="custom-select" id="strands_nw" name="strands_nw" '.$disabled.'>
                                        <option selected>'.$row["strands_nw"].'</option>
                                        <option value="6/1">6/1</option>
                                      </select>
                                    </div>
                                  </div><br>
                                  <button type="submit" class="btn btn-info" name="edit_PrimaryButton" '.$hide_btn.'>Update</button>
                              </div>

                              <div class="tab-pane fade" id="tab2">
                                <br>
                                  <div class="row"> 
                                    <div class="col-md-6">
                                      <label for="exampleInputEmail1"> Spacing D12 </label>
                                      <input type="text" class="form-control" id="spacing_d12" name="spacing_d12" value="'.$row["spacing_d12"].'" '.$disabled.'/>

                                      <label for="exampleInputEmail1"> Spacing D23 </label>
                                      <input type="text" class="form-control" id="spacing_d23" name="spacing_d23" value="'.$row["spacing_d23"].'" '.$disabled.'/>

                                      <label for="exampleInputEmail1"> Spacing D13 </label>
                                      <input type="text" class="form-control" id="spacing_d13" name="spacing_d13" value="'.$row["spacing_d13"].'" '.$disabled.'/> 
                                    </div>
                                    <div class="col-md-6">
                                      <label for="exampleInputEmail1"> Spacing D1n </label>
                                      <input type="text" class="form-control" id="spacing_d1n" name="spacing_d1n" value="'.$row["spacing_d1n"].'" '.$disabled.'/>

                                      <label for="exampleInputEmail1"> Spacing D2n </label>
                                      <input type="text" class="form-control" id="spacing_d2n" name="spacing_d2n" value="'.$row["spacing_d2n"].'" '.$disabled.'/>

                                      <label for="exampleInputEmail1"> Spacing D3n </label>
                                      <input type="text" class="form-control" id="spacing_d3n" name="spacing_d3n" value="'.$row["spacing_d3n"].'" '.$disabled.'/> 
                                    </div>
                                  </div>

                                  <div class="row"> 
                                    <div class="col-md-12">
                                      <label for="exampleInputEmail1"> Spacing Dc1-c2 </label>
                                      <input type="text" class="form-control" id="spacing_dc1c2" name="spacing_dc1c2" value="'.$row["spacing_dc1c2"].'" '.$disabled.'/> 
                                    </div>
                                  </div>

                                  <hr>

                                  <div class="row"> 
                                    <div class="col-md-6">
                                      <label for="exampleInputEmail1"> Height H1 </label>
                                      <input type="text" class="form-control" id="height_h1" name="height_h1" value="'.$row["height_h1"].'" '.$disabled.'/>

                                      <label for="exampleInputEmail1"> Height H2 </label>
                                      <input type="text" class="form-control" id="height_h2" name="height_h2" value="'.$row["height_h2"].'" '.$disabled.'/> 
                                    </div>
                                    <div class="col-md-6">
                                      <label for="exampleInputEmail1"> Height H3 </label>
                                      <input type="text" class="form-control" id="height_h3" name="height_h3" value="'.$row["height_h3"].'" '.$disabled.'/>

                                      <label for="exampleInputEmail1"> Height Hn </label>
                                      <input type="text" class="form-control" id="height_hn" name="height_hn" value="'.$row["height_hn"].'" '.$disabled.'/> 
                                    </div>
                                  </div>

                                  <div class="row"> 
                                    <div class="col-md-12">
                                      <label for="exampleInputEmail1"> Earth Resistivity (Ohm-meter) </label><form method="POST">
                                      <input type="text" class="form-control" id="earth_resistivity" name="earth_resistivity" value="'.$row["earth_resistivity"].'" '.$disabled.'/> 
                                    </div>
                                  </div><br>
                                  <button type="submit" class="btn btn-info" name="edit_PrimaryButton" '.$hide_btn.'>Update</button>
                              </div> ';
                    }
                  } 

                  if(isset($segmentID_get)){
                    echo '
                    <div class="tab-pane fade" id="tab3">
                      <br>
                        <button type="button" name="insert_Household" data-toggle="modal" data-target="#add_HouseholdPrimary" '.$hide_btn.' class="btn btn-info float-right">+</button><br><br>
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
                              $primary_database = "SELECT * FROM tbl_primary WHERE segment_id = '$segmentID_get'";
                              $primary_databaseResult = $conn->query($primary_database);  

                              while ($row = $primary_databaseResult->fetch_assoc()){
                                $primary_id = $row["primary_id"];
                              }

                              $household_database = "SELECT * FROM tbl_household INNER JOIN tbl_account ON tbl_household.account_id = tbl_account.account_id WHERE primary_id = '$primary_id'";
                              $household_databaseResult = $conn->query($household_database);                 

                              if(isset($segmentID_get)){
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

        if(isset($_POST["edit_PrimaryButton"])){
          $date_updated = date('m/d/Y h:i A');
          $date_created = date('m/d/Y h:i A');

          $segment_id = mysqli_escape_string($conn, $_POST["segment_id"]);
          $from_busid = mysqli_escape_string($conn, $_POST["from_busid"]);
          $to_busid = mysqli_escape_string($conn, $_POST["to_busid"]);
          $phasing = mysqli_escape_string($conn, $_POST["phasing"]);
          $configuration = mysqli_escape_string($conn, $_POST["configuration"]);
          $grounding_type = mysqli_escape_string($conn, $_POST["grounding_type"]);
          $length = mysqli_escape_string($conn, $_POST["length"]);
          $conductor_type = mysqli_escape_string($conn, $_POST["conductor_type"]);
          $conductor_size = mysqli_escape_string($conn, $_POST["conductor_size"]);
          $unit = mysqli_escape_string($conn, $_POST["unit"]);
          $strands = mysqli_escape_string($conn, $_POST["strands"]);
          $neutral_wiretype = mysqli_escape_string($conn, $_POST["neutral_wiretype"]);
          $neutral_wiresize = mysqli_escape_string($conn, $_POST["neutral_wiresize"]);
          $unit_nw = mysqli_escape_string($conn, $_POST["unit_nw"]);
          $strands_nw = mysqli_escape_string($conn, $_POST["strands_nw"]);
          $spacing_d12 = mysqli_escape_string($conn, $_POST["spacing_d12"]);
          $spacing_d23 = mysqli_escape_string($conn, $_POST["spacing_d23"]);
          $spacing_d13 = mysqli_escape_string($conn, $_POST["spacing_d13"]);
          $spacing_d1n = mysqli_escape_string($conn, $_POST["spacing_d1n"]);
          $spacing_d2n = mysqli_escape_string($conn, $_POST["spacing_d2n"]);
          $spacing_d3n = mysqli_escape_string($conn, $_POST["spacing_d3n"]);
          $spacing_dc1c2 = mysqli_escape_string($conn, $_POST["spacing_dc1c2"]);
          $height_h1 = mysqli_escape_string($conn, $_POST["height_h1"]);
          $height_h2 = mysqli_escape_string($conn, $_POST["height_h2"]);
          $height_h3 = mysqli_escape_string($conn, $_POST["height_h3"]);
          $height_hn = mysqli_escape_string($conn, $_POST["height_hn"]);
          $earth_resistivity = mysqli_escape_string($conn, $_POST["earth_resistivity"]);
          $primary_latitude = mysqli_escape_string($conn, $_POST["primary_latitude"]);
          $primary_longitude = mysqli_escape_string($conn, $_POST["primary_longitude"]);
          $date_update = mysqli_escape_string($conn, $date_updated);

          if($from_busid != $to_busid){
            $query = "UPDATE `tbl_primary` SET `from_busid` = '$from_busid', `to_busid` = '$to_busid', `phasing` = '$phasing', `configuration` = '$configuration', `grounding_type` = '$grounding_type', `length` = '$length', `conductor_type` = '$conductor_type', `conductor_size` = '$conductor_size', `unit` = '$unit', `strands` = '$strands', `neutral_wiretype` = '$neutral_wiretype', `neutral_wiresize` = '$neutral_wiresize', `unit_nw` = '$unit_nw', `strands_nw` = '$strands_nw', `spacing_d12` = '$spacing_d12', `spacing_d23` = '$spacing_d23', `spacing_d13` = '$spacing_d13', `spacing_d1n` = '$spacing_d1n', `spacing_d2n` = '$spacing_d2n', `spacing_d3n` = '$spacing_d3n', `spacing_dc1c2` = '$spacing_dc1c2', `height_h1` = '$height_h1', `height_h2` = '$height_h2', `height_h3` = '$height_h3', `height_hn` = '$height_hn', `earth_resistivity` = '$earth_resistivity', `date_updated` = '$date_update' WHERE `segment_id` = '$segmentID_get'";

            $log_query .= 'INSERT INTO tbl_log (account_id, status_id, notification_id, log_status, url_link, date_created) VALUES ("'.$account_id.'", "'.$status_id.'", "4", "0", "marker.php?object='.$segmentID_get.'", "'.$date_created.'");';

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
          $primaryImage = "SELECT * from tbl_primary WHERE BINARY segment_id = BINARY '$segmentID_get'";
          $primaryImage_Query = $conn->query($primaryImage);

          while ($row = $primaryImage_Query->fetch_assoc()){
            $primary_imageID = $row["primary_id"];
          }
          echo "url:'imagePrimary.php?object=".$segmentID_get."',";
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
        $primaryImage = "SELECT * from tbl_primary WHERE BINARY segment_id = BINARY '$segmentID_get'";
        $primaryImage_Query = $conn->query($primaryImage);

        while ($row = $primaryImage_Query->fetch_assoc()){
          $primary_imageID = $row["primary_id"];
        }
        echo "url:'imagePrimary_fetch.php?object=".$segmentID_get."',";
      ?>  
      success:function(data)
      {
        $('#store_image').html(data);
      }
    })
  }

});  
</script>