<?php 
  session_start();
  ob_start();
  require 'modals.php';
  $session_username = $_SESSION["username"];
  $admin_permission = "SELECT * from tbl_account WHERE status_id = '1'";
  $admin_permission_query = $conn->query($admin_permission);

  $session_username = $_SESSION["username"];
  $account_permission = "SELECT * from tbl_account WHERE BINARY username = BINARY '$session_username'";
  $account_permission_query = $conn->query($account_permission);

  while ($row = $admin_permission_query->fetch_assoc()){
    $admin_permission_key = $row["permission_key"];
  }

  while ($row = $account_permission_query->fetch_assoc()){
    $account_permission_key = $row["permission_key"];
  }
?>
<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <img src="images/leyeco-v_logo.png" width="60px" height="60px">
    </button>

    <a class="navbar-brand mr-1" href="index.php" style="font-size: 24px; font-weight: bold;">H E L I O S</a>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group"><!--
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>-->
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <?php
        $check_log = "SELECT * FROM tbl_account WHERE username = '$session_username'";
        $check_logResult = $conn->query($check_log); 

        while ($row = $check_logResult->fetch_assoc()){
          if($row["status_id"] == 1 || $admin_permission_key == $account_permission_key){
            echo '<li class="nav-item dropdown no-arrow mx-1 notification_dropdown" >
                    <a class="nav-link dropdown-toggler" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                      <i class="fas fa-bell fa-fw"></i>
                      <span class="badge badge-danger notif_count" style="font-size: 10px;"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right notif_area" aria-labelledby="messagesDropdown">
                      
                    </div>
                  </li>';
          } 
        }

        
      ?>
      
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php
            
            $accounts = "SELECT * from tbl_account INNER JOIN tbl_status ON tbl_account.status_id = tbl_status.status_id WHERE username = '$session_username'";
            $accounts_query = $conn->query($accounts); 

            if(isset($_SESSION["username"])){
              while ($row = $accounts_query->fetch_assoc()){
                $status = $row["status"];
                $map_widen = $row['insert_privilege'];
                echo '<img src="data:image;base64,'.base64_encode($row['image'] ).'" style="width: 50px; height:50px;"> ';
                echo $session_username;

                $current_permission_key = $row["permission_key"];
                $username = $session_username;
              }            
            }

            else{
              echo '<i class="fas fa-user-circle fa-fw"></i>';
            }
          ?>    
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <?php 
            if($status == 'Administrator'){
              echo '<a class="dropdown-item" href="profile.php?username='.$session_username.'">Profile</a> 
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addAccount">Add Account</a> 
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Switch Account</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>';
            }

            else if(!isset($status)){
              echo '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Login</a>';
            }

            else {
              echo '<a class="dropdown-item" href="profile.php?username='.$session_username.'">Profile</a>  
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Switch Account</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>';
            }
          ?>          
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <?php 
      if(isset($_SESSION["username"])){
        echo '<ul class="sidebar navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                  </a>
                  <a class="nav-link" href="map.php">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Map</span>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-header">Login Screens:</h6>
                    <a class="dropdown-item" href="login.html">Login</a>
                    <a class="dropdown-item" href="register.html">Register</a>
                    <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">Other Pages:</h6>
                    <a class="dropdown-item" href="404.html">404 Page</a>
                    <a class="dropdown-item" href="blank.html">Blank Page</a>
                  </div>
                </li>      
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-database"></i>
                    <span>Database</span>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-header">Objects:</h6>
                    <a class="dropdown-item" href="primaryDatabase.php">Primary</a>
                    <a class="dropdown-item" href="secondaryDatabase.php">Secondary</a>
                    <a class="dropdown-item" href="transformerDatabase.php">Transformers</a>
                    <a class="dropdown-item" href="householdDatabase.php">Households</a>
                    <a class="dropdown-item" href="orderDatabase.php">Orders</a>';

                     
                      if ($status == "Administrator" || $admin_permission_key == $account_permission_key){
                        echo '<a class="dropdown-item" href="accounts.php">Accounts</a>';
                      } 
                    
        echo  '</div>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>Settings</span>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="pagesDropdown"> 
                    <h6 class="dropdown-header">Configurations:</h6>
                    <a class="dropdown-item" data-toggle="modal" data-target="#permission_keyModal" href="#">Permission Key</a> 
                  </div>
                </li>';

              if ($status == "Administrator" || $admin_permission_key == $account_permission_key){
        echo   '<li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-save"></i>
                    <span>Back-up</span>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="pagesDropdown"> 
                    <h6 class="dropdown-header">Configurations:</h6>
                    <a class="dropdown-item" data-toggle="modal" data-target="#importModal" href="#">Import</a>
                    <a class="dropdown-item" href="#">Export</a>
                  </div>
                </li>
              ';
              }
        echo '</ul>';
      }
    ?>   

	<?php 
	  $generated_password = $_POST["row_password"];

	  $permission_keyUpdate = "UPDATE tbl_account SET permission_key = '$generated_password' WHERE BINARY username = BINARY '$username'"; 

	  if(isset($_POST["change_permissionkey"])){          
	    $conn->query($permission_keyUpdate);    
	    header("refresh: 0");
	  }
	?> 

  

	<?php 
	  $layer_name = $_POST["input_LayerName"];
	  $insert_LayerName = "INSERT INTO tbl_layer (layer_name) VALUES ('$layer_name')";

	  if(isset($_POST["addLayer_btn"])){          
	    $conn->query($insert_LayerName);    
	  }
	?> 

   

    <?php                           
      ERROR_REPORTING(~E_NOTICE);           

      $usernamelogin = $_POST['username'];
      $passwordlogin = $_POST['password'];
               
      $login_check = "SELECT * FROM tbl_account WHERE BINARY username = '$usernamelogin' && BINARY password = '$passwordlogin'";
 
      $login_query = $conn->query($login_check);

      if(isset($_POST['login_btn'])){
        if($login_query->num_rows == 1){          

          $_SESSION = array();
          session_destroy();

          session_start();

          $_SESSION["username"] = $usernamelogin; 
          header("refresh: 0");

          unset($_POST['login_btn']);
        }

        else{
          header("location: registration.php");
        }     
      }
    ?>  

  <form name="permission_keyForm" method="POST">
    <div class="modal fade" id="permission_keyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Permission Key</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body"> 
            <div class="form-inline">
              <label for="usr">Current Permission Key: &nbsp;</label>
              <input class="form-control" type="text" placeholder="<?php echo $current_permission_key; ?>" readonly>
            </div><br>
            <div class="form-inline">
              <label for="usr">New Permission Key: &nbsp;</label>
              <?php 
                if ($status == "Administrator"){
                  echo '<input name="row_password" class="form-control" type="text" required="required" autocomplete=off readonly></n>';
                }

                else{
                  echo '<input name="row_password" class="form-control" type="text" required="required" autocomplete=off></n>';
                }
              ?>
              
            </div>
            <div class="form-inline"> 
              <?php 
                if ($status == "Administrator"){
                  echo '<input type="button" class="button" value="Generate" onClick="generate();" tabindex="2">';
                } 
              ?>             
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" name="change_permissionkey">Update</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form method="POST">
    
  </form> 

<script type="text/javascript">
  function randomPassword(length) {
      var chars = "ABCDEFGHIJKLMNOP1234567890";
      var pass = "";
      for (var x = 0; x < 6; x++) {
          var i = Math.floor(Math.random() * chars.length);
          pass += chars.charAt(i);
      }
      return pass;
  }

  function generate() {
      permission_keyForm.row_password.value = randomPassword(permission_keyForm.length.value);
  }

  $(document).ready(function(){
    function load_unseen_notification(view = ''){
      $.ajax({
        url: "notification.php",
        method: "POST",
        data:{view:view},
        dataType:"json",
        success:function(data){
          $('.notif_area').html(data.notification);
          if(data.unseen_notification > 0){
            $('.notif_count').html(data.unseen_notification);
          } else {
            $('.notif_count').html('0');
          }
        }
      })
    } 

    $(document).on('click', '.dropdown-toggler', function(){
      $('.notif_count').html('0');
      load_unseen_notification('yes');
    })

    setInterval(function(){
      load_unseen_notification();
    }, 1000);

  }); 
  
</script>