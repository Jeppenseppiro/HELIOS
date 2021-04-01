<?php 
  require 'db_connect.php';
  session_start();
  ob_start();

  require 'check_ban.php';
  require 'check_loggedin.php';

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

  <style type="text/css">
    .main {
      float:left;
      width:100%;
      padding:15px;     
     
    }

    .right {
      float:left;
      width:0%;
      padding:15px;    
    }

    @media only screen and (max-width:1208px) {
      .menu, .main, .right {
        width:100%;
        margin-left: 0px;
        margin-right: 0px;
      }     
    }
  </style>

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
          <li class="breadcrumb-item active">Discussions</li>
        </ol> 

        <div>
          <a class="btn" data-toggle="collapse" href="#collapseExample" style="display: none;">
            <i class="fas fa-bars"></i> Statistics
          </a>

          <a class="btn" data-toggle="modal" data-target="#postModal" style="color: black;">
            <i class="fas fa-bars"></i> Make a Post
          </a>          

          <form method="POST">
          <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Make a Post</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon3">Subject:</span>
                    </div>
                    <input type="text" name="post_subject" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                  </div>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Post:</span>
                    </div>
                    <textarea name="post_content" class="form-control" aria-label="With textarea"></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="post_button">Post</button>
                </div>
              </div>
            </div>
          </div>

          
          </form>

          <?php
            date_default_timezone_set('Asia/Manila'); 
            
            $account = "SELECT * from tbl_account WHERE BINARY username = BINARY '$session_username'";
            $account_inserter = $conn->query($account);

            while ($row = $account_inserter->fetch_assoc()){
              $account_id = $row["account_id"];
            }

            $post_subject = $_POST["post_subject"];
            $post_content = $_POST["post_content"];
            $post_date = date('m/d/Y h:i A');  

            if(isset($_POST["post_button"])){
              $insert_post = "INSERT INTO tbl_post (post_subject, post_content, post_date, account_id) VALUES ('$post_subject', '$post_content', '$post_date', '$account_id')";
              $conn->query($insert_post);
            }
          ?>
        </div>
        
        <br>

        <div class="collapse" id="collapseExample">
          <div class="row" style="padding-left: 15px; padding-right: 15px;">
            <div class="card-group" style="width: 100%;">
              <div class="card mb-3 bg-primary" >
                <div id="website_post" class="panel panel-default"> 
                   <div class="panel-body" style="text-align: right; font-size: 50px; font-weight: bold; padding-right: 10px; color: white;">90</div>
                </div>
                <div class="card-footer" style="font-size: 15px; font-weight: bold; color: white;">Primary</div>
              </div>
              <div class="card mb-3 bg-primary" >
                <div id="website_post" class="panel panel-default"> 
                   <div class="panel-body" style="text-align: right; font-size: 50px; font-weight: bold; padding-right: 10px; color: white;">90</div>
                </div>
                <div class="card-footer" style="font-size: 15px; font-weight: bold; color: white;">Secondary</div>
              </div>
              <div class="card mb-3 bg-primary" >
                <div id="website_post" class="panel panel-default"> 
                   <div class="panel-body" style="text-align: right; font-size: 50px; font-weight: bold; padding-right: 10px; color: white;">90</div>
                </div>
                <div class="card-footer" style="font-size: 15px; font-weight: bold; color: white;">Transformers</div>
              </div>
              <div class="card mb-3 bg-primary" >
                <div id="website_post" class="panel panel-default"> 
                   <div class="panel-body" style="text-align: right; font-size: 50px; font-weight: bold; padding-right: 10px; color: white;">90</div>
                </div>
                <div class="card-footer" style="font-size: 15px; font-weight: bold; color: white;">Households</div>
              </div>
            </div>
          </div>       
        </div>
          
          <div class="main">

        <?php 
          $post = "SELECT * FROM tbl_post INNER JOIN tbl_account ON tbl_post.account_id = tbl_account.account_id ORDER BY post_id DESC";
          $post_query = $conn->query($post);
        

          while ($row = $post_query->fetch_assoc()){
            $post_id = $row["post_id"];

            $comment_quantity = "SELECT * FROM tbl_comment WHERE post_id = '$post_id'";
            $comment_quantityQuery = $conn->query($comment_quantity);

            echo '<div class="card mb-3">
                    <div id="website_post" class="panel panel-default" style="height:auto; padding: 10px;">
                      <div class="panel-heading" style="z-index: 90; vertical-align: baseline;">
                        <table class="tg">
                          <tr>
                            <th style="vertical-align:bottom;" rowspan="2"><img src="data:image;base64,'.base64_encode($row['image'] ).'" style="width: 50px; height:50px;"></th>
                            <th class="tg-s268">&nbsp;<a href="profile.php?username='.$row["username"].'">'.$row['username'].' ('.$row['fname']." ".$row['lname'].')</a> <small style="text-align: right; float: right;"></th>
                          </tr>
                          <tr>
                            <td class="tg-s268">&nbsp;'.$row['post_date'].'</td>
                          </tr>
                        </table>                         
                      </div>
                       <div class="panel-body">
                        <div><h2>'.$row['post_subject'].'</h2></div>
                        <div><p style="color: black;">'.$row['post_content'].'</p></div>
                       </div>
                    </div>
                    <div class="card-footer small text-muted">Comments ('.$comment_quantityQuery->num_rows.')</div>
                  </div>';
          }
        ?>
          
            
          </div> 



      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->

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


</html>
