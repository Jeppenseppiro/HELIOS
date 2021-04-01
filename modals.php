<?php 
  session_start();
  ob_start();

  date_default_timezone_set('Asia/Manila'); 
  $date_created = date('m/d/Y h:i A');

?>
  <!-- Add Account Modal-->
  <form method="POST">
          <div class="modal fade" id="addAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Account</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-6">
                      <label>Username:</label>
                      <input type="text" class="form-control" name="add_Username" placeholder="Username" required>
                    </div>
                    <div class="col-sm-6">
                      <label>Password:</label>
                      <input type="password" class="form-control" name="add_Password" placeholder="Password" required>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-sm-12">
                      <label>Status:</label>
                      <select class="custom-select" id="status_member" name="status_member" required> 
                        <?php 
                          $status_fetch = "SELECT * FROM tbl_status WHERE status != 'Administrator'";
                          $status_query = $conn->query($status_fetch);

                          while ($row = $status_query->fetch_assoc()){
                            echo '<option value="'.$row["status_id"].'">'.$row["status"].'</option>';
                          }
                        ?> 
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <br>  
                      <label>Privileges: </label><br>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="privilege_insert" id="inlineRadio1" value="1" >
                        <label class="form-check-label">Insert</label>
                      </div><br>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="privilege_edit" id="inlineRadio2" value="1">
                        <label class="form-check-label">Update</label>
                      </div><br>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="privilege_delete" id="inlineRadio2" value="1">
                        <label class="form-check-label">Delete</label>
                      </div><br>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" name="addAccount_btn">Add</button>
                  <?php 
                    if(isset($_POST["addAccount_btn"])){
                      $username = $_POST["add_Username"];
                      $password = $_POST["add_Password"];
                      $status = $_POST["status_member"];
                      $insert_privilege = $_POST["privilege_insert"];
                      $update_privilege = $_POST["privilege_edit"];
                      $delete_privilege = $_POST["privilege_delete"];

                      $username_query = "SELECT * from tbl_account WHERE username = '$username'";
                      $username_exist = $conn->query($username_query);

                      if($username_exist->num_rows > 0){
                        echo "<script>alert('Username Already Exists')</script>";  
                      } else {
                        $add_account = "INSERT INTO tbl_account (username, password, status_id, insert_privilege, update_privilege, delete_privilege) VALUES ('$username', '$password', '$status', '$insert_privilege', '$update_privilege', '$delete_privilege')";
                        $conn->query($add_account); 
                      }
                      
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
  </form>
  

  <!-- Login Modal-->
  <form method="POST">
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Account Login</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="inputEmail" class="form-control" placeholder="Email address" required="required" name="username" autocomplete=off autofocus="autofocus">
              <label for="inputEmail">Username</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="required" name="password">
              <label for="inputPassword">Password</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" type="submit" name="login_btn">Login</button>
        </div>
      </div>
    </div>
  </div>
  </form>

  <!-- Import Modal-->
  <form method="POST" enctype='multipart/form-data'>
  <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Import Database Table</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="file-upload-wrapper">
              <select class="custom-select mr-sm-2" id="inlineFormCustomSelect"> 
                <option value="tbl_primary">tbl_primary</option>
                <option value="tbl_secondary">tbl_secondary</option>
                <option value="tbl_transformer">tbl_transformer</option>
              </select><br><br>
              <input type="file" name="importPrimary_File" id="input-file-now" class="file-upload" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <input type="submit" name="importPrimary" value="CSV Import" class="btn btn-info" >

          <?php 
                      if(isset($_POST["importPrimary"])){
                        if($_FILES['importPrimary_File']['name']){
                          $filename = explode(".", $_FILES['importPrimary_File']['name']);
                          if (end($filename) == "csv"){
                            $handle = fopen($_FILES['importPrimary_File']['tmp_name'], "r");

                            while ($data = fgetcsv($handle)){
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

                              $query = "UPDATE `tbl_primary` SET `primary_id` = '$primary_id', `account_id` = '$account_id', `layer_id` = '$layer_id', `segment_id` = '$segment_id', `from_busid` = '$from_busid', `to_busid` = '$to_busid', `phasing` = '$phasing', `configuration` = '$configuration', `grounding_type` = '$grounding_type', `length` = '$length', `conductor_type` = '$conductor_type', `conductor_size` = '$conductor_size', `unit` = '$unit', `strands` = '$strands', `neutral_wiretype` = '$neutral_wiretype', `neutral_wiresize` = '$neutral_wiresize', `unit_nw` = '$unit_nw', `strands_nw` = '$strands_nw', `spacing_d12` = '$spacing_d12', `spacing_d23` = '$spacing_d23', `spacing_d13` = '$spacing_d13', `spacing_d1n` = '$spacing_d1n', `spacing_d2n` = '$spacing_d2n', `spacing_d3n` = '$spacing_d3n', `spacing_dc1c2` = '$spacing_dc1c2', `height_h1` = '$height_h1', `height_h2` = '$height_h2', `height_h3` = '$height_h3', `height_hn` = '$height_hn', `earth_resistivity` = '$earth_relativity', `primary_latitude` = '$primary_latitude', `primary_longitude` = '$primary_longitude', `date_created` = '$date_created', `date_updated` = '$date_update', `image` = '$image' WHERE `primary_id` = '$primary_id'";

                              $conn->query($query);                              
                              
                            }
                            fclose($handle);

                          } else {
                            echo "CSV file only";
                          }

                        } else {
                          echo "Select File";
                        }
                      }
          ?>
        </div>
      </div>
    </div>
  </div>
  </form>

  <!-- Place Order Modal-->
  <form method="POST">
    <div class="modal fade" id="placeOrder_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Place Order:</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <INPUT TYPE="hidden" NAME="order_name" ID="ORDER" VALUE="" MAXLENGTH=16 SIZE=16>
              <label for="usr" style="display: none;">Coordinates:</label>
              <div class="row" style="display: none;">
                <div class="col-md-6">
                  <input type="text" class="form-control" name="get_latitude" id="get_latitude" value="" readonly="true">
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="get_longitude" id="get_longitude" value="" readonly="true">
                </div>
              </div>

              <br>

              <label>Fullname:</label>
              <div class="form-row">
                <div class="col">
                  <input type="text" class="form-control" name="order_firstname" id="order_firstname" placeholder="First name">
                </div>
                <div class="col">
                  <input type="text" class="form-control" name="order_middlename" id="order_middlename" placeholder="Middle Initial">
                </div>
                <div class="col">
                  <input type="text" class="form-control" name="order_lastname" id="order_lastname" placeholder="Last name">
                </div>
              </div>

              <br>

              <label>Description:</label>
              <div class="form-row">
                <div class="col">
                  <textarea name="order_textarea" class="form-control" aria-label="With textarea"></textarea>
                </div> 
              </div>

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" name="placeOrder_btn">Order</button>
            <?php 
              if(isset($_POST["placeOrder_btn"])){
                 

                $session_username = $_SESSION["username"];

                $account = "SELECT * from tbl_account WHERE BINARY username = BINARY '$session_username'";
                $account_inserter = $conn->query($account);

                while ($row = $account_inserter->fetch_assoc()){
                  $account_id = $row["account_id"];
                  $status_id = $row["status_id"];
                }                

                $order_name = "ORDER".$_POST["order_name"]; 
                $order_firstname = $_POST["order_firstname"];
                $order_middlename = $_POST["order_middlename"];
                $order_lastname = $_POST["order_lastname"];
                $order_textarea = $_POST["order_textarea"];
                $order_latitude = $_POST["get_latitude"];
                $order_longitude = $_POST["get_longitude"];
                $order_status = 1;

                $place_Order = "INSERT into tbl_order (account_id, order_name, order_fname, order_mname, order_lname, order_textarea, order_latitude, order_longitude, order_status, date_created) VALUES ('$account_id', '$order_name', '$order_firstname', '$order_middlename', '$order_lastname', '$order_textarea', '$order_latitude', '$order_longitude', '$order_status', '$date_created')";
                $conn->query($place_Order);

                unset($_POST["placeOrder_btn"]);
              }             
            ?>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Edit Primary Miscellaneous-->
  <form method="POST">
    <div class="modal fade" id="edit_PrimaryMisc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Primary Miscellaneous</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="edit_HouseholdPrimaryDetails">
            <div class="col-md-12">
               
            </div>
            <div class="row">
              <div class="col-md-4">
                 
              </div> 
            </div>
            <input type="hidden" name="primary_id" id="primary_id">
            <input type="submit" class="btn btn-success" name="edit_PrimaryMiscbtn" id="edit_PrimaryMiscbtn" value="se">

            
          </div>
          <div class="modal-footer" id="edit_HouseholdPrimaryLink">
                      
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Add Household Primary -->
  <form method="POST">
    <div class="modal fade" id="add_HouseholdPrimary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Household</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                <label for="usr">Firstname:</label>
                <input type="text" class="form-control" name="hh_fname">
              </div>
              <div class="col-md-4">
                <label for="usr">Middlename:</label>
                <input type="text" class="form-control" name="hh_mname">
              </div>
              <div class="col-md-4">
                <label for="usr">Lastname:</label>
                <input type="text" class="form-control" name="hh_lname">
              </div>
            </div> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" name="add_HouseholdPrimary">Add</button>
            <?php
              $segmentID_get = $_GET["object"];
              $primary_query = "SELECT * from tbl_primary INNER JOIN tbl_account ON tbl_primary.account_id = tbl_account.account_id WHERE BINARY segment_id = BINARY '$segmentID_get'";
              $primary_queryResult = $conn->query($primary_query);

              while ($row = $primary_queryResult->fetch_assoc()){
                $primary_idInsert = $row["primary_id"];
                $account_idInsert = $row["account_id"];
                $segment_idURL = $row["segment_id"];
              } 

              if(isset($_POST["add_HouseholdPrimary"])){             
                $hh_fname = $_POST["hh_fname"];
                $hh_mname = $_POST["hh_mname"];
                $hh_lname = $_POST["hh_lname"];

                $insert_HouseholdPrimary = "INSERT into tbl_household (account_id, primary_id, hh_fname, hh_mname, hh_lname) VALUES ('$account_idInsert', '$primary_idInsert', '$hh_fname', '$hh_mname', '$hh_lname')";
                $conn->query($insert_HouseholdPrimary);

                header("location: primary.php?object=".$segment_idURL);

                unset($_POST["add_HouseholdPrimary"]);
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </form>

  <?php 
    $query = "SELECT * FROM tbl_household WHERE household_id = '".$_POST["household_id"]."'";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()){
      $refer = $row["household_id"];
    }
  ?>

  <!-- Add Household Secondary -->
  <form method="POST">
    <div class="modal fade" id="add_HouseholdSecondary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Household</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                <label for="usr">Firstname:</label>
                <input type="text" class="form-control" name="hh_fname">
              </div>
              <div class="col-md-4">
                <label for="usr">Middlename:</label>
                <input type="text" class="form-control" name="hh_mname">
              </div>
              <div class="col-md-4">
                <label for="usr">Lastname:</label>
                <input type="text" class="form-control" name="hh_lname">
              </div>
            </div> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" name="add_HouseholdSecondary">Add</button>
            <?php
              $segmentID_get = $_GET["object"];
              $secondary_query = "SELECT * from tbl_secondary INNER JOIN tbl_account ON tbl_secondary.account_id = tbl_account.account_id WHERE BINARY distribution_lineid = BINARY '$segmentID_get'";
              $secondary_queryResult = $conn->query($secondary_query);

              while ($row = $secondary_queryResult->fetch_assoc()){
                $secondary_idInsert = $row["secondary_id"];
                $account_idInsert = $row["account_id"];
                $segment_idURL = $row["distribution_lineid"];
              } 

              if(isset($_POST["add_HouseholdSecondary"])){             
                $hh_fname = $_POST["hh_fname"];
                $hh_mname = $_POST["hh_mname"];
                $hh_lname = $_POST["hh_lname"];

                $insert_HouseholdPrimary = "INSERT into tbl_household (account_id, secondary_id, hh_fname, hh_mname, hh_lname) VALUES ('$account_idInsert', '$secondary_idInsert', '$hh_fname', '$hh_mname', '$hh_lname')";
                $conn->query($insert_HouseholdPrimary);

                header("location: secondary.php?object=".$segment_idURL);

                unset($_POST["add_HouseholdSecondary"]);
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Add Household Transformer -->
  <form method="POST">
    <div class="modal fade" id="add_HouseholdTransformer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Household</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                <label for="usr">Firstname:</label>
                <input type="text" class="form-control" name="hh_fname">
              </div>
              <div class="col-md-4">
                <label for="usr">Middlename:</label>
                <input type="text" class="form-control" name="hh_mname">
              </div>
              <div class="col-md-4">
                <label for="usr">Lastname:</label>
                <input type="text" class="form-control" name="hh_lname">
              </div>
            </div> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" name="add_HouseholdTransformer">Add</button>
            <?php 
              $segmentID_get = $_GET["object"];
              $transformer_query = "SELECT * from tbl_transformer INNER JOIN tbl_account ON tbl_transformer.account_id = tbl_account.account_id WHERE BINARY distribution_transformerid = BINARY '$segmentID_get'";
              $transformer_queryResult = $conn->query($transformer_query);

              while ($row = $transformer_queryResult->fetch_assoc()){
                $transformer_idInsert = $row["transformer_id"];
                $account_idInsert = $row["account_id"];
                $segment_idURL = $row["distribution_transformerid"];
              } 

              if(isset($_POST["add_HouseholdTransformer"])){             
                $hh_fname = $_POST["hh_fname"];
                $hh_mname = $_POST["hh_mname"];
                $hh_lname = $_POST["hh_lname"];

                $insert_HouseholdPrimary = "INSERT into tbl_household (account_id, transformer_id, hh_fname, hh_mname, hh_lname, date_created) VALUES ('$account_idInsert', '$transformer_idInsert', '$hh_fname', '$hh_mname', '$hh_lname', '$date_created')";
                $conn->query($insert_HouseholdPrimary);

                header("location: transformer.php?object=".$segment_idURL);

                unset($_POST["add_HouseholdTransformer"]);
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Edit Household Primary -->
  <form method="POST">
    <div class="modal fade" id="edit_Household" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Connected Household</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="edit_HouseholdPrimaryDetails">
            <div class="col-md-12">
              <label for="usr">Fullname:</label>
            </div>
            <div class="row">
              <div class="col-md-4"> 
                <input type="text" class="form-control" id="hh_fname" name="hh_fname" placeholder="Firstname">
              </div>
              <div class="col-md-4"> 
                <input type="text" class="form-control" id="hh_mname" name="hh_mname" placeholder="Middlename">
              </div>
              <div class="col-md-4">
                <input type="text" class="form-control" id="hh_lname" name="hh_lname" placeholder="Lastname">
              </div>
            </div><br>
            <input type="hidden" name="household_id" id="household_id">
            <input type="submit" class="btn btn-success" name="edit_Householdbtn" id="edit_Householdbtn" value="Update">

            <?php 
              if(isset($_POST["edit_Householdbtn"])){ 

                $hh_fname = mysqli_real_escape_string($conn, $_POST["hh_fname"]);
                $hh_mname = mysqli_real_escape_string($conn, $_POST["hh_mname"]);
                $hh_lname = mysqli_real_escape_string($conn, $_POST["hh_lname"]);

                $update_query = "UPDATE tbl_household SET hh_fname='$hh_fname', hh_mname='$hh_mname', hh_lname='$hh_lname', date_updated='$date_created' WHERE household_id = '".$_POST["household_id"]."'";
                $conn->query($update_query);

                unset($_POST["edit_Householdbtn"]);
              }
            ?>
          </div>
          <div class="modal-footer" id="edit_HouseholdPrimaryLink">
                      
          </div>
        </div>
      </div>
    </div>
  </form> 

  <!-- Delete Primary Modal-->
  <form method="POST">
  <div class="modal fade" id="deletePrimaryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Primary Object</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
           asdasd
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" type="submit" name="login_btn">Login</button>
        </div>
      </div>
    </div>
  </div>
  </form>