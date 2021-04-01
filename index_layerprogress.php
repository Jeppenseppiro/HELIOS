<?php 
  require 'db_connect.php';
  session_start();
  ob_start();
?>
<!DOCTYPE html>
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

  <!-- Leaflet JS Library --> 
  <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
  <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
  <script src="js/leaflet-control-boxzoom.js"></script>  
  <script src="js/leaflet-mouseposition.js"></script>  
  <script src="js/leaflet-search.js"></script>  
  <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
  <script src="https://unpkg.com/esri-leaflet@2.2.3/dist/esri-leaflet.js"
    integrity="sha512-YZ6b5bXRVwipfqul5krehD9qlbJzc6KOGXYsDjU9HHXW2gK57xmWl2gU6nAegiErAqFXhygKIsWPKbjLPXVb2g=="
    crossorigin=""></script>
  
  <!-- Leaflet CSS Library -->
  <link rel="stylesheet" href="css/leaflet-mouseposition.css" />
  <link rel="stylesheet" href="css/leaflet-search.css" />
  <link rel="stylesheet" href="css/leaflet-control-boxzoom.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
  <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet'/>
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
</head>



<body id="page-top" class="sidebar-toggled">


  <?php 
    require 'header.php';

    $insertPrivilege = "SELECT * from tbl_account WHERE BINARY username = BINARY '$session_username'";
    $insertPrivilege_Query = $conn->query($insertPrivilege);
  ?>
  
    <div id="content-wrapper">
      <form method="POST">

      <div class="container-fluid">
      <div style="overflow:auto">

        <!-- Breadcrumbs
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>-->
        <?php 
          if(!empty($status) && $map_widen == 1){
            echo '<div class="main" style="width: 85%;">';
          }

          else{
            echo '<div class="main" style="width: 100%;">';
          }
        ?> 
          <div id="basemaps-wrapper" class="leaflet-bar">
            <select name="basemaps" id="basemaps" onChange="changeBasemap(basemaps)">
              <option value="Physical">Open Street Map</option>
              <option value="Topographic">Topographic</option>
              <option value="Streets">Streets</option>   
              <option value="DarkGray">Dark Gray</option>
              <option value="Imagery">Imagery</option>
              <option value="ImageryClarity">Imagery (Clarity)</option>          
            </select>
          </div>
          <div id="map_window" style="width: 100%; height: 50rem; border: 1px solid #AAA; z-index: 0;">          
          </div>

          </div>
     
        <!-- Icon Cards--> 
                            
            <?php
              while ($row = $insertPrivilege_Query->fetch_assoc()){
                if($row["insert_privilege"] == 1){
                  echo '<div class="right" style="width: 15%;">
                        <div class="row">
                          <div class="col-xl-12 col-sm-6 mb-3">
                            <div class="card text-white bg-primary o-hidden h-100">
                              <a class="text-white clearfix small z-1" data-toggle="modal" data-target="#insertObject_Modal" href="#" accesskey="h">
                              <div class="card-body">             
                                <div class="card-body-icon">
                                  <i class="fas fa-plus"></i>
                                </div>               
                                <div class="mr-5">Insert Object</div>
                              </div>
                              </a>
                              <a class="card-footer text-white clearfix small z-1" data-toggle="modal" data-target="#insertObject_ViewDetails" href="#" >
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                  <i class="fas fa-angle-right"></i>
                                </span>
                              </a>
                            </div>
                          </div>

                          <div class="col-xl-12 col-sm-6 mb-3">
                            <div class="card text-white bg-warning o-hidden h-100">
                              <div class="card-body">
                                <div class="card-body-icon">
                                  <i class="fas fa-wrench"></i>
                                </div>
                                <div class="mr-5">Use Tool</div>
                              </div>
                              <a class="card-footer text-white clearfix small z-1" href="#">
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                  <i class="fas fa-angle-right"></i>
                                </span>
                              </a>
                            </div>
                          </div>
                          <div class="col-xl-12 col-sm-6 mb-3">
                            <div class="card text-white bg-success o-hidden h-100">
                              <div class="card-body">
                                <div class="card-body-icon">
                                  <i class="fas fa-fw fa-shopping-cart"></i>
                                </div>
                                <div class="mr-5">123 New Orders!</div>
                              </div>
                              <a class="card-footer text-white clearfix small z-1" href="#">
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                  <i class="fas fa-angle-right"></i>
                                </span>
                              </a>
                            </div>
                          </div>
                          <div class="col-xl-12 col-sm-6 mb-3">
                            <div class="card text-white bg-danger o-hidden h-100">
                              <div class="card-body">
                                <div class="card-body-icon">
                                  <i class="fas fa-fw fa-life-ring"></i>
                                </div>
                                <div class="mr-5">13 New Tickets!</div>
                              </div>
                              <a class="card-footer text-white clearfix small z-1" href="#">
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                  <i class="fas fa-angle-right"></i>
                                </span>
                              </a>
                            </div>
                          </div>
                        </div>
                        </div>';
                }

                else{
                  echo '<div class="right" style="width: 0%;"></div>';
                }
              }
              
            ?>   
            
            
          </div>

          <!-- Icon Cards Modal -->
          <div class="modal fade bd-example-modal-lg" id="insertObject_Modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content modal-lg">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Insert Object</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                                    
                    
                      <div class="table-responsive">
                        <table class="table table-bordered" id="insertObject_Table" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th width="20%">Name</th>
                              <th width="20%">Latitude</th>
                              <th width="30%">Longitude</th>
                              <th width="20%">Layer</th>
                              <th width="10%">Action</th>
                            </tr>
                          </thead>
                          <!--<tbody>     
                            <tr>
                              <td>
                                <?php 

                                ?>
                              </td>
                              <td>                                                         
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>        
                          </tbody>-->
                        </table>
                        <div align="right">
                          <button type="button" name="insertObject_Add" id="insertObject_Add" class="btn btn-success btn-xs">+</button>
                        </div>
                      </div>
                    
                    <br>
                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" name="insertObject_Save" id="insertObject_Save" class="btn btn-primary">Save</button>
                </div>
              </div>
              </div>
            </div>
          </div>

          <!-- Icon Cards View Details Modal -->
          <div class="modal fade" id="insertObject_ViewDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">View Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  ...
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>
        

        <!-- Add Layer Modal -->
        <form method="POST"> 
        </div>    

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
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>

  <!-- Pure Javascript -->
  <script type="text/javascript">
    $(function() {
      $('#sidebarToggle').click();
    });
  </script>
  

  <!-- Leaflet Scripts -->
  <script type="text/javascript">
    var map = L.map('map_window', {
      fullscreenControl: true
    }).setView([11.0409, 124.6035], 17);    
    
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);  

    var searchLayer = L.layerGroup().addTo(map);
    map.addControl( new L.Control.Search({layer: searchLayer}) );

    L.control.mousePosition({
      position: 'topright',
      separator: " | ",
      prefix: "Coordinates: "
    }).addTo(map);

    map.isFullscreen()
    map.toggleFullscreen()

    map.on('fullscreenchange', function () {
        if (map.isFullscreen()) {
            console.log('entered fullscreen');
        } else {
            console.log('exited fullscreen');
        }
    });

    var layer = L.esri.basemapLayer('Physical').addTo(map);
    var layerLabels;

    function setBasemap(basemap) {
      if (layer) {
        map.removeLayer(layer);
      }

      layer = L.esri.basemapLayer(basemap);

      map.addLayer(layer);

      if (layerLabels) {
        map.removeLayer(layerLabels);
      }

      if (basemap === 'ShadedRelief'
       || basemap === 'Oceans'
       || basemap === 'Gray'
       || basemap === 'DarkGray'
       || basemap === 'Terrain'
     ) {
        layerLabels = L.esri.basemapLayer(basemap + 'Labels');
        map.addLayer(layerLabels);
      } else if (basemap.includes('Imagery')) {
        layerLabels = L.esri.basemapLayer('ImageryLabels');
        map.addLayer(layerLabels);
      }
    }

    function changeBasemap(basemaps){
      var basemap = basemaps.value;
      setBasemap(basemap);
    }

    /*
     L.Routing.control({
      waypoints: [
        L.latLng(11.0409, 124.6035),
        L.latLng(11.03975, 124.6038)
      ]
    }).addTo(map);

    */

  </script>

  <?php 
    $world_show = "SELECT * FROM tbl_world";
    $world_show_result = $conn->query($world_show);

    $layer_filter = "SELECT * FROM tbl_layer";
    $layer_filter_result = $conn->query($layer_filter);

    while ($row = $world_show_result->fetch_assoc()){
      echo '<script>
              var marker = L.circle(['.$row["latitude"].', '.$row["longitude"].'], 6).addTo(map);
              marker.bindPopup("'.$row["name"].'");
              marker.on("mouseover", function (e) {
                  this.openPopup();
              });
            </script>';
    }   

    
  ?>

</form>
</body>
</html>
  <script>
    
  </script>

  <script>
    $(document).ready(function(){
      var count = 1;
      $('#insertObject_Add').click(function(){
        count = count + 1;
        var html_code = "<tr id='row"+count+"'>"; 

        var layer_dropdown = "<?php 
                            $layers = 'SELECT * from tbl_layer';
                            $layers_query = $conn->query($layers);

                            while ($row = $layers_query->fetch_assoc()){
                              echo '<option class=item_layer value='.$row['layer_id'].'>'.$row['layer_name'].'</option>';
                            }
                           ?>";

        html_code += "<td contenteditable='true' class='item_name'></td>";
        html_code += "<td contenteditable='true' class='item_latitude'></td>";
        html_code += "<td contenteditable='true' class='item_longitude'></td>"; 
        html_code += "<td contenteditable='true'><select>"+layer_dropdown+"</select></td>"; 
        html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";
        html_code += "<tr>";

        $('#insertObject_Table').append(html_code);
      });

      $(document).on('click', '.remove', function(){
        var delete_row = $(this).data("row");
        $('#' + delete_row).remove();
      });

      $('#insertObject_Save').click(function(){
        var item_name = [];
        var item_latitude = [];
        var item_longitude = [];
        var item_layer = [];

        $('.item_name').each(function(){
         item_name.push($(this).text());
        });
        $('.item_latitude').each(function(){
         item_latitude.push($(this).text());
        });
        $('.item_longitude').each(function(){
         item_longitude.push($(this).text());
        });
        $('.item_layer').each(function(){
         item_layer.push($(this).text());
        });
        $.ajax({
         url:"insertObject.php",
         method:"POST",
         data:{item_name:item_name, item_latitude:item_latitude, item_longitude:item_longitude, item_layer:item_layer},
         success:function(data){
          alert(data);
          $("td[contentEditable='true']").text("");
          for(var i=2; i<= count; i++)
          {
           $('tr#'+i+'').remove();
          }
          fetch_item_data();
         }
        });
      });

    });
  </script>