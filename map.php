<?php 
  require 'db_connect.php';
  session_start();
  ob_start();

  require 'check_ban.php';
  require 'check_loggedin.php';
  require 'check_privilege.php';
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
  <script src="js/leaflet-providers.js"></script>
  <script src="js/leaflet.groupedlayercontrol.min.js"></script> 
  <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
  <script src="https://unpkg.com/esri-leaflet@2.2.3/dist/esri-leaflet.js"
    integrity="sha512-YZ6b5bXRVwipfqul5krehD9qlbJzc6KOGXYsDjU9HHXW2gK57xmWl2gU6nAegiErAqFXhygKIsWPKbjLPXVb2g=="
    crossorigin=""></script>
  
  <!-- Leaflet CSS Library -->
  <link rel="stylesheet" href="css/leaflet-mouseposition.css" />
  <link rel="stylesheet" href="css/leaflet-search.css" />
  <link rel="stylesheet" href="css/leaflet-control-boxzoom.css" />
  <link rel="stylesheet" href="css/leaflet.groupedlayercontrol.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
  <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet'/>
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
</head>



<body id="page-top" class="sidebar-toggled">


  <?php 
    require 'header.php';

    $coordinates = explode(",", $_GET["coordinates"]);
    $lat = $coordinates[0];
    $long =$coordinates[1]; 

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
            echo '<div class="main">';
          }

          else{
            echo '<div class="main" style="width: 100%;">';
          }
        ?> 

          <!--<div id="basemaps-wrapper" class="leaflet-bar">
            <select name="basemaps" id="basemaps" onChange="changeBasemap(basemaps)">
              <option value="Physical">Open Street Map</option>
              <option value="Topographic">Topographic</option>
              <option value="Streets">Streets</option>   
              <option value="DarkGray">Dark Gray</option>
              <option value="Imagery">Imagery</option>
              <option value="ImageryClarity">Imagery (Clarity)</option>          
            </select>
          </div>-->
      

          <div id="map_window" style="width: 100%; height: 45rem; border: 1px solid #AAA; z-index: 0;">          
          </div>

          </div>
     
        <!-- Icon Cards--> 
                            
            <?php
              while ($row = $insertPrivilege_Query->fetch_assoc()){
                if($row["insert_privilege"] == 1){
                  echo '<div class="right"> 
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
          <div class="modal fade bd-example-modal-sm" id="insertObject_Modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg insertModal" style="width: 100%; height: 100%; margin: 0; padding-left: 20px; padding-right: 20px; padding-top: 20px;">
              <!-- style="width: 100%; height: 100%; margin: 0; padding-left: 20px; padding-right: 20px; padding-top: 20px;" -->
              <div class="modal-content modal-sm" style="width: auto; min-width: 100%; border-radius: 0;">
                <!-- style="width: auto; min-width: 100%; border-radius: 0;" -->
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Insert Object</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                      <div role="tabpanel">
                        <ul class="nav nav-tabs">
                          <li class="nav-item active">
                            <a class="nav-link active" href="#primaryDistribution" aria-controls="primaryDistribution" role="tab" data-toggle="tab">Primary Distribution Line
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#secondaryDistribution" aria-controls="secondaryDistribution" role="tab" data-toggle="tab">Secondary Distribution Line
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#transformerDistribution" aria-controls="transformerDistribution" role="tab" data-toggle="tab">Distribution Transformer
                            </a>
                          </li>
                        </ul>

                        <div class="tab-content">
                          <div role="tabpanel" class="tab-pane fade show active" id="primaryDistribution">
                            <div class="table-responsive">
                              <table class="table table-bordered" id="insertPrimary_Table" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th>Primary Distribution Line Segment ID</th>
                                    <th>Bus ID</th>  
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Action</th>
                                  </tr>
                                </thead> 
                              </table>
                              <div align="right">
                                <button type="button" name="insertPrimary_Add" id="insertPrimary_Add" class="btn btn-success btn-xs">+</button>
                              </div>
                            </div>
                            <div class="card-footer small text-muted">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" name="insertPrimary_Save" id="insertPrimary_Save" class="btn btn-primary">Save</button>
                            </div>
                          </div>

                          <div role="tabpanel" class="tab-pane fade" id="secondaryDistribution">
                            <div class="table-responsive">
                              <table class="table table-bordered" id="insertSecondary_Table" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th>Secondary Distribution Line ID</th>
                                    <th>Bus ID</th>  
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Action</th>
                                  </tr>
                                </thead> 
                              </table>
                              <div align="right">
                                <button type="button" name="insertSecondary_Add" id="insertSecondary_Add" class="btn btn-success btn-xs">+</button>
                              </div>
                            </div>
                            <div class="card-footer small text-muted">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" name="insertSecondary_Save" id="insertSecondary_Save" class="btn btn-primary">Save</button>
                            </div>
                          </div>

                          <div role="tabpanel" class="tab-pane fade" id="transformerDistribution">
                            <div class="table-responsive">
                              <table class="table table-bordered" id="insertTransformer_Table" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th>Distribution Transformer ID</th> 
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Action</th>
                                  </tr>
                                </thead> 
                              </table>
                              <div align="right">
                                <button type="button" name="insertSecondary_Add" id="insertTransformer_Add" class="btn btn-success btn-xs">+</button>
                              </div>
                            </div>
                            <div class="card-footer small text-muted">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" name="insertTransformer_Save" id="insertTransformer_Save" class="btn btn-primary">Save</button>
                            </div>
                          </div>
                        </div>

                        </div>
                      </div>              
                    
                      
                    
                    <br>
                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                
                </div>
                <div class="modal-footer">
                  
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
    function randomNumber(len) {
        var randomNumber;
        var n = '';

        for(var count = 0; count < len; count++) {
            randomNumber = Math.floor(Math.random() * 10);
            n += randomNumber.toString();
        }
        return n;
    }

    document.getElementById("ORDER").value = randomNumber(6);

    var map = L.map('map_window').setView([
      <?php 
        if(isset($_GET["coordinates"])){
          echo $lat.','.$long;
        } else {
          echo '11.0409, 124.6035';
        } 
      ?>
    ], 17);    

    var click = L.popup();

    function onMapClick(e) {
      var coord = e.latlng;
      var lat = coord.lat;
      var lng = coord.lng;

      $('#get_latitude').val(lat);
      $('#get_longitude').val(lng); 

      $('#item_primarylatitude').val(lat);
      $('#item_primarylongitude').val(lng);

        click
            .setLatLng(e.latlng)
            .setContent(
              '<div class="dropdown"><button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-list"></i></button><div class="dropdown-menu"><a href="#" class="btn btn-success" data-toggle="modal" data-target="#placeOrder_Modal" style="color: white;"><i class="fas fa-edit"></i></a></div></div>'
              )
            .openOn(map); 
    }

    map.on('click', onMapClick); 

    <?php 
      $placeOrder_query = "SELECT * from tbl_order";
      $placeOrder_queryShow = $conn->query($placeOrder_query);

      while ($row = $placeOrder_queryShow->fetch_assoc()){
        if($row["order_status"] == 1){
          echo "var order_place".$row["order_id"]." = L.circle([".$row["order_latitude"].", ".$row["order_longitude"]."],{
                  color: 'orange', 
                  fillOpacity: 1,
                  radius: 10
                }).addTo(map);";

          echo 'order_place'.$row["order_id"].'.bindPopup("Applicant: <b>'.$row["order_fname"].' '.$row["order_mname"].' '.$row["order_lname"].'</b><br>Notes: '.$row["order_textarea"].'");';
        }
      }
    ?> 

    <?php 
      if(isset($_GET["coordinates"])){
        echo 'var coordinates = L.marker(['.$lat.', '.$long.'], {radius:30}).addTo(map);
              coordinates.bindPopup("URL Coordinates: '.$lat.', '.$long.'");
        ';
      }
    ?>
       
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);   

    L.Routing.control({ 
        position: 'bottomright',
        routeWhileDragging: true,
        geocoder: L.Control.Geocoder.nominatim()
    }).addTo(map);


  
    L.control.mousePosition({
      position: 'topright',
      separator: " | Long: ",
      prefix: "Lat: "
    }).addTo(map);

    L.Control.geocoder({
      position: 'topright'
    }).addTo(map);

    map.addControl(new L.Control.Fullscreen());

    map.isFullscreen()
    map.toggleFullscreen()

    map.on('fullscreenchange', function () {
        if (map.isFullscreen()) {
            console.log('entered fullscreen');
        } else {
            console.log('exited fullscreen');
        }
    });



    
    /*var layer = L.esri.basemapLayer('Physical').addTo(map);
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
    }*/
    

     
    //11.04367, 124.60476],[11.04552, 124.60545],[11.0463, 124.60568
    

    
      <?php 
        $polyline_primary = "SELECT * from tbl_primary";
        $polyline_primaryQuery = $conn->query($polyline_primary);

        while ($row = $polyline_primaryQuery->fetch_assoc()){
          echo "var primary_points".$row["primary_id"]." = [";
          echo '['.$row["primary_latitude"].','.$row["primary_longitude"].'],';
          $to_busID = $row["to_busid"];

          $polyline_primaryDraw = "SELECT * from tbl_primary WHERE from_busid = '$to_busID'";
          $polyline_primaryDrawQuery = $conn->query($polyline_primaryDraw);

          while ($row = $polyline_primaryDrawQuery->fetch_assoc()){
            echo '['.$row["primary_latitude"].','.$row["primary_longitude"].'],';
          }

          echo "];";
        }       
      ?>

      <?php
        $polyline_primary = "SELECT * from tbl_primary";
        $polyline_primaryQuery = $conn->query($polyline_primary);

        while ($row = $polyline_primaryQuery->fetch_assoc()){
          echo "var primary_polylines".$row["primary_id"]." = L.polyline(primary_points".$row["primary_id"].", {color: 'black'}).addTo(map);
                primary_polylines".$row["primary_id"].".bindPopup('<b>Primary (Line)</b><br>From Bus ID: ".$row["from_busid"]."<br> To Bus ID: ".$row["to_busid"]."');
                primary_polylines".$row["primary_id"].".on('mouseover', function (e) {
                  this.openPopup();
                });
          ";
        }

      ?> 

      <?php 
        $polyline_primary = "SELECT * from tbl_secondary";
        $polyline_primaryQuery = $conn->query($polyline_primary);

        while ($row = $polyline_primaryQuery->fetch_assoc()){
          echo "var secondary_points".$row["secondary_id"]." = [";
          echo '['.$row["secondary_latitude"].','.$row["secondary_longitude"].'],';
          $to_busID = $row["to_busid"];

          $polyline_primaryDraw = "SELECT * from tbl_secondary WHERE from_busid = '$to_busID'";
          $polyline_primaryDrawQuery = $conn->query($polyline_primaryDraw);

          while ($row = $polyline_primaryDrawQuery->fetch_assoc()){
            echo '['.$row["secondary_latitude"].','.$row["secondary_longitude"].'],';
          }

          echo "];";
        }       
      ?>

      <?php
        $polyline_primary = "SELECT * from tbl_secondary";
        $polyline_primaryQuery = $conn->query($polyline_primary);

        while ($row = $polyline_primaryQuery->fetch_assoc()){
          echo "var secondary_polylines".$row["secondary_id"]." = L.polyline(secondary_points".$row["secondary_id"].", {color: 'black'}).addTo(map);
                secondary_polylines".$row["secondary_id"].".bindPopup('<b>Secondary (Line)</b><br>From Bus ID: ".$row["from_busid"]."<br> To Bus ID: ".$row["to_busid"]."');
                secondary_polylines".$row["secondary_id"].".on('mouseover', function (e) {
                  this.openPopup();
                });
          ";
        }

      ?> 

      <?php
        $polyline_transformer = "SELECT * from tbl_transformer";
        $polyline_transformerQuery = $conn->query($polyline_transformer);

        while ($row = $polyline_transformerQuery->fetch_assoc()){
          $from_PrimaryBusID = $row["primary_busid"];
          $to_SecondaryBusID = $row["secondary_busid"];

          $primary_busid = "SELECT * from tbl_primary WHERE from_busid = '$from_PrimaryBusID'";
          $primary_busidQuery = $conn->query($primary_busid);

          $distribution_transformerID = "SELECT * from tbl_transformer WHERE primary_busid = '$from_PrimaryBusID' && secondary_busid = '$to_SecondaryBusID'";
          $distribution_transformerIDQuery = $conn->query($distribution_transformerID);

          $secondary_busid = "SELECT * from tbl_secondary WHERE from_busid = '$to_SecondaryBusID'";
          $secondary_busidQuery = $conn->query($secondary_busid);

          echo 'var transformer_points'.$row["transformer_id"].' = [';

          while ($row = $primary_busidQuery->fetch_assoc()){
            echo '['.$row["primary_latitude"].','.$row["primary_longitude"].'],';
          }

          while ($row = $distribution_transformerIDQuery->fetch_assoc()){
            echo '['.$row["transformer_latitude"].','.$row["transformer_longitude"].'],';
          }

          while ($row = $secondary_busidQuery->fetch_assoc()){
            echo '['.$row["secondary_latitude"].','.$row["secondary_longitude"].'],';
          }

          echo '];';
        }
      ?> 

    <?php
      $polyline_transformer = "SELECT * from tbl_transformer";
      $polyline_transformerQuery = $conn->query($polyline_transformer);

      while ($row = $polyline_transformerQuery->fetch_assoc()){
        echo "var transformer_polylines".$row["transformer_id"]." = L.polyline(transformer_points".$row["transformer_id"].", {color: 'black'}).addTo(map);
              transformer_polylines".$row["transformer_id"].".bindPopup('<b>Transformer (Line)</b> <br> Primary Bus ID: ".$row["primary_busid"]."<br> Secondary Bus ID: ".$row["secondary_busid"]."');
        ";

      }
      
    ?>

    

    var data = [
      <?php
        $search_primary = "SELECT * from tbl_primary";
        $search_primaryQuery = $conn->query($search_primary);

        $search_secondary = "SELECT * from tbl_secondary";
        $search_secondaryQuery = $conn->query($search_secondary);

        $search_transformer = "SELECT * from tbl_transformer";
        $search_transformerQuery = $conn->query($search_transformer);

        $search_order = "SELECT * from tbl_order";
        $search_orderQuery = $conn->query($search_order);

        while ($row = $search_primaryQuery->fetch_assoc()){ 
          echo '{"loc":['.$row["primary_latitude"].','.$row["primary_longitude"].'], "title":"'.$row["segment_id"].'", "id":"Bus ID: '.$row["from_busid"].'", "type":"Primary", "name":"Object", "button":""},';
        }

        while ($row = $search_secondaryQuery->fetch_assoc()){ 
          echo '{"loc":['.$row["secondary_latitude"].','.$row["secondary_longitude"].'], "title":"'.$row["distribution_lineid"].'", "id":"Bus ID: '.$row["from_busid"].'", "type":"Secondary", "name":"Object", "button":""},';
        }  

        while ($row = $search_transformerQuery->fetch_assoc()){ 
          echo '{"loc":['.$row["transformer_latitude"].','.$row["transformer_longitude"].'], "title":"'.$row["distribution_transformerid"].'", "id":"Primary Bus ID: '.$row["primary_busid"].' <br> Secondary Bus ID: '.$row["secondary_busid"].'", "type":"Transformer", "name":"Object", "button":""},';
        } 

        while ($row = $search_orderQuery->fetch_assoc()){ 
          if($row["order_status"] == 1){
            echo '{"loc":['.$row["order_latitude"].','.$row["order_longitude"].'], "title":"'.$row["order_name"].'", "id":"Desc: '.$row["order_textarea"].'", "type":"Order", "name":"Name", "button":"<br><a class=btn btn_primary href=orderStatus.php?order='.$row["order_id"]."/".$row["order_status"].'>Done</a>"},';
          }         
        } 
      ?>
    ];   

    var markersLayer = new L.LayerGroup();
    map.addLayer(markersLayer);

    var controlSearch = new L.Control.Search({
      position:'topleft',    
      layer: markersLayer,
      initial: false,  
    });

    map.addControl( controlSearch );

    for(i in data) {
      var title = data[i].title,  
        id = data[i].id,
        type = data[i].type,
        name = data[i].name,
        button = data[i].button,
        loc = data[i].loc,    
        marker = new L.Circle(new L.latLng(loc), {title: title, 
                                                  id: id, 
                                                  type: type, 
                                                  name: name, 
                 });
      marker.bindPopup("<b>"+type+"</b><br><a href='marker.php?object="+title+"'>"+name+": "+title+' <br>'+id+"</a>"+button+"");
      marker.on("mouseover", function (e) {
        this.openPopup();
      }); 
      markersLayer.addLayer(marker);
    }

    var map_icon = L.Icon.extend({
        options: { 
            iconSize:     [35, 35] 
        }
    });

    var primary_icon = new map_icon({iconUrl: 'images/icons/utility_pole.png'}),
        secondary_icon = new map_icon({iconUrl: 'images/icons/utility_pole.png'}),
        transformer_icon = new map_icon({iconUrl: 'images/icons/transformer.png'});

    L.icon = function (options) {
        return new L.Icon(options);
    };

  </script>

  <?php 
      $world = "SELECT * from tbl_world";
      $world_query = $conn->query($world);      

      $primary = "SELECT * from tbl_primary";
      $primary_query = $conn->query($primary);

      $secondary = "SELECT * from tbl_secondary";
      $secondary_query = $conn->query($secondary);

      $transformer = "SELECT * from tbl_transformer";
      $transformer_query = $conn->query($transformer);

      $household = "SELECT * from tbl_household";
      $household_query = $conn->query($household);

        while ($row = $primary_query->fetch_assoc()){
          if ($row["layer_id"] == 1){
            echo '<script>';
            echo 'var primary'.$row["primary_id"].' = L.marker(['.$row["primary_latitude"].', '.$row["primary_longitude"].'], {icon: primary_icon});
                  primary'.$row["primary_id"].'.bindPopup("'.$row["segment_id"].'");
                  primary'.$row["primary_id"].'.on("mouseover", function (e) {
                      this.openPopup();
                  });';  
            echo '</script>';
            
            $primary_array[] = "primary".$row["primary_id"];
            
          }
        }

        while ($row = $secondary_query->fetch_assoc()){
          if ($row["layer_id"] == 2){
            echo '<script>';
            echo 'var secondary'.$row["secondary_id"].' = L.marker(['.$row["secondary_latitude"].', '.$row["secondary_longitude"].'], {icon: secondary_icon});
                  secondary'.$row["secondary_id"].'.bindPopup("'.$row["distribution_lineid"].'");
                  secondary'.$row["secondary_id"].'.on("mouseover", function (e) {
                      this.openPopup();
                  });';  
            echo '</script>';
            
            $secondary_array[] = "secondary".$row["secondary_id"];
            
          }
        } 

        while ($row = $transformer_query->fetch_assoc()){
          if ($row["layer_id"] == 3){
            echo '<script>';
            echo 'var transformer'.$row["transformer_id"].' = L.marker(['.$row["transformer_latitude"].', '.$row["transformer_longitude"].'], {icon: transformer_icon});
                  transformer'.$row["transformer_id"].'.bindPopup("'.$row["distribution_transformerid"].'");
                  transformer'.$row["transformer_id"].'.on("mouseover", function (e) {
                      this.openPopup();
                  });';  
            echo '</script>';
            
            $transformer_array[] = "transformer".$row["transformer_id"];
            
          }
        }        

        $json_primary_array = json_encode($primary_array, JSON_NUMERIC_CHECK);
        $json_secondary_array = json_encode($secondary_array, JSON_NUMERIC_CHECK);
        $json_transformer_array = json_encode($transformer_array, JSON_NUMERIC_CHECK);
        $json_household_array = json_encode($household_array, JSON_NUMERIC_CHECK);
    ?>

  <script type="text/javascript">  
    var lg_primary = L.layerGroup(<?php echo str_replace('"', '', $json_primary_array); ?>);
    var lg_secondary = L.layerGroup(<?php echo str_replace('"', '', $json_secondary_array); ?>);
    var lg_transformers = L.layerGroup(<?php echo str_replace('"', '', $json_transformer_array); ?>);
    var lg_households = L.layerGroup(<?php echo str_replace('"', '', $json_household_array); ?>);

    var overlayLayers = { 
      "Primary" : lg_primary, 
      "Secondary" : lg_secondary,
      "Transformers" : lg_transformers,
      "Households" : lg_households, 
    }

    L.control.layers(null, overlayLayers).addTo(map);
  </script>

</form>
</body>
</html>
  <script>
    
  </script>

  <script>
    $(document).ready(function(){
      var count = 1;

      // Primary Distribution Table Append
      $('#insertPrimary_Add').click(function(){
        count = count + 1;
        var html_code = "<tr id='row"+count+"'>"; 
        html_code += "<td contenteditable='true' class='item_primarySegmentID'></td>";
        html_code += "<td contenteditable='true' class='item_primaryFromBusID'></td>"; 
        html_code += "<td contenteditable='true' class='item_primarylatitude' id='item_primarylatitude'></td>";
        html_code += "<td contenteditable='true' class='item_primarylongitude' id='item_primarylongitude'></td>"; 
        html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";
        html_code += "<tr>";

        $('#insertPrimary_Table').append(html_code);
      });

      // Secondary Distribution Table Append
      $('#insertSecondary_Add').click(function(){
        count = count + 1;
        var html_code = "<tr id='row"+count+"'>"; 
        html_code += "<td contenteditable='true' class='item_secondarySegmentID'></td>";
        html_code += "<td contenteditable='true' class='item_secondaryFromBusID'></td>"; 
        html_code += "<td contenteditable='true' class='item_secondarylatitude'></td>";
        html_code += "<td contenteditable='true' class='item_secondarylongitude'></td>"; 
        html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";
        html_code += "<tr>";

        $('#insertSecondary_Table').append(html_code);
      });

      // Distribution Transformer Table Append
      $('#insertTransformer_Add').click(function(){
        count = count + 1;
        var html_code = "<tr id='row"+count+"'>"; 
        html_code += "<td contenteditable='true' class='item_transformerTransformerID'></td>"; 
        html_code += "<td contenteditable='true' class='item_transformerlatitude'></td>";
        html_code += "<td contenteditable='true' class='item_transformerlongitude'></td>"; 
        html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";
        html_code += "<tr>";

        $('#insertTransformer_Table').append(html_code);
      });

      $(document).on('click', '.remove', function(){
        var delete_row = $(this).data("row");
        $('#' + delete_row).remove();
      });

      $('#insertPrimary_Save').click(function(){
        var item_primarySegmentID = [];
        var item_primaryFromBusID = [];
        var item_primaryToBusID = [];
        var item_primaryPhasing = [];
        var item_primaryConfiguration = [];
        var item_primarySystemGroundType = [];
        var item_primaryLength = [];
        var item_primaryConductorType = [];
        var item_primaryConductorSize = [];
        var item_primaryUnit = [];
        var item_primaryStrands = [];
        var item_primaryNeutralWireType = [];
        var item_primaryNeutralWireSize = [];
        var item_primaryUnitNW = [];
        var item_primaryStrandsNW = [];
        var item_primarySpacingdD12 = [];
        var item_primarySpacingdD23 = [];
        var item_primarySpacingdD13 = [];
        var item_primarySpacingdD1n = [];
        var item_primarySpacingdD2n = [];
        var item_primarySpacingdD3n = [];
        var item_primarySpacingdDc1c2 = [];
        var item_primaryHeightH1 = [];
        var item_primaryHeightH2 = [];
        var item_primaryHeightH3 = [];
        var item_primaryHeightHn = [];
        var item_primaryEarthResistivity = [];
        var item_primarylatitude = [];
        var item_primarylongitude = [];

        $('.item_primarySegmentID').each(function(){
         item_primarySegmentID.push($(this).text());
        });
        $('.item_primaryFromBusID').each(function(){
         item_primaryFromBusID.push($(this).text());
        });
        $('.item_primaryToBusID').each(function(){
         item_primaryToBusID.push($(this).text());
        });
        $('.item_primaryPhasing').each(function(){
         item_primaryPhasing.push($(this).text());
        });
        $('.item_primaryConfiguration').each(function(){
         item_primaryConfiguration.push($(this).text());
        });
        $('.item_primarySystemGroundType').each(function(){
         item_primarySystemGroundType.push($(this).text());
        });
        $('.item_primaryLength').each(function(){
         item_primaryLength.push($(this).text());
        });
        $('.item_primaryConductorType').each(function(){
         item_primaryConductorType.push($(this).text());
        });
        $('.item_primaryConductorSize').each(function(){
         item_primaryConductorSize.push($(this).text());
        });
        $('.item_primaryUnit').each(function(){
         item_primaryUnit.push($(this).text());
        });
        $('.item_primaryStrands').each(function(){
         item_primaryStrands.push($(this).text());
        });
        $('.item_primaryNeutralWireType').each(function(){
         item_primaryNeutralWireType.push($(this).text());
        });
        $('.item_primaryNeutralWireSize').each(function(){
         item_primaryNeutralWireSize.push($(this).text());
        });
        $('.item_primaryUnitNW').each(function(){
         item_primaryUnitNW.push($(this).text());
        });
        $('.item_primaryStrandsNW').each(function(){
         item_primaryStrandsNW.push($(this).text());
        });
        $('.item_primarySpacingdD12').each(function(){
         item_primarySpacingdD12.push($(this).text());
        });
        $('.item_primarySpacingdD23').each(function(){
         item_primarySpacingdD23.push($(this).text());
        });
        $('.item_primarySpacingdD13').each(function(){
         item_primarySpacingdD13.push($(this).text());
        });
        $('.item_primarySpacingdD1n').each(function(){
         item_primarySpacingdD1n.push($(this).text());
        });
        $('.item_primarySpacingdD2n').each(function(){
         item_primarySpacingdD2n.push($(this).text());
        });
        $('.item_primarySpacingdD3n').each(function(){
         item_primarySpacingdD3n.push($(this).text());
        });
        $('.item_primarySpacingdDc1c2').each(function(){
         item_primarySpacingdDc1c2.push($(this).text());
        });
        $('.item_primaryHeightH1').each(function(){
         item_primaryHeightH1.push($(this).text());
        });
        $('.item_primaryHeightH2').each(function(){
         item_primaryHeightH2.push($(this).text());
        });
        $('.item_primaryHeightH3').each(function(){
         item_primaryHeightH3.push($(this).text());
        });
        $('.item_primaryHeightHn').each(function(){
         item_primaryHeightHn.push($(this).text());
        });
        $('.item_primaryEarthResistivity').each(function(){
         item_primaryEarthResistivity.push($(this).text());
        });
        $('.item_primarylatitude').each(function(){
         item_primarylatitude.push($(this).text());
        });
        $('.item_primarylongitude').each(function(){
         item_primarylongitude.push($(this).text());
        });

        $.ajax({
         url:"insertPrimary.php",
         method:"POST",
         data:{item_primarySegmentID:item_primarySegmentID, 
               item_primaryFromBusID:item_primaryFromBusID, 
               item_primaryToBusID:item_primaryToBusID, 
               item_primaryPhasing:item_primaryPhasing, 
               item_primaryConfiguration:item_primaryConfiguration, 
               item_primarySystemGroundType:item_primarySystemGroundType, 
               item_primaryLength:item_primaryLength, 
               item_primaryConductorType:item_primaryConductorType, 
               item_primaryConductorSize:item_primaryConductorSize, 
               item_primaryUnit:item_primaryUnit, 
               item_primaryStrands:item_primaryStrands, 
               item_primaryNeutralWireType:item_primaryNeutralWireType,
               item_primaryNeutralWireSize:item_primaryNeutralWireSize,
               item_primaryUnitNW:item_primaryUnitNW,
               item_primaryStrandsNW:item_primaryStrandsNW,
               item_primarySpacingdD12:item_primarySpacingdD12, 
               item_primarySpacingdD23:item_primarySpacingdD23, 
               item_primarySpacingdD13:item_primarySpacingdD13, 
               item_primarySpacingdD1n:item_primarySpacingdD1n, 
               item_primarySpacingdD2n:item_primarySpacingdD2n, 
               item_primarySpacingdD3n:item_primarySpacingdD3n, 
               item_primarySpacingdDc1c2:item_primarySpacingdDc1c2, 
               item_primaryHeightH1:item_primaryHeightH1, 
               item_primaryHeightH2:item_primaryHeightH2, 
               item_primaryHeightH3:item_primaryHeightH3, 
               item_primaryHeightHn:item_primaryHeightHn, 
               item_primaryEarthResistivity:item_primaryEarthResistivity, 
               item_primarylatitude:item_primarylatitude, 
               item_primarylongitude:item_primarylongitude},
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

      $('#insertSecondary_Save').click(function(){ 
        var item_secondarySegmentID = [];
        var item_secondaryFromBusID = [];
        var item_secondaryToBusID = [];
        var item_secondaryPhasing = [];
        var item_secondaryInstallationType = [];
        var item_secondaryLength = [];
        var item_secondaryConductorType = [];
        var item_secondaryConductorSize = [];
        var item_secondarylatitude = [];
        var item_secondarylongitude = [];

        $('.item_secondarySegmentID').each(function(){
         item_secondarySegmentID.push($(this).text());
        });
        $('.item_secondaryFromBusID').each(function(){
         item_secondaryFromBusID.push($(this).text());
        });
        $('.item_secondaryToBusID').each(function(){
         item_secondaryToBusID.push($(this).text());
        });
        $('.item_secondaryPhasing').each(function(){
         item_secondaryPhasing.push($(this).text());
        });
        $('.item_secondaryInstallationType').each(function(){
         item_secondaryInstallationType.push($(this).text());
        });
        $('.item_secondaryLength').each(function(){
         item_secondaryLength.push($(this).text());
        });
        $('.item_secondaryConductorType').each(function(){
         item_secondaryConductorType.push($(this).text());
        });
        $('.item_secondaryConductorSize').each(function(){
         item_secondaryConductorSize.push($(this).text());
        });
        $('.item_secondarylatitude').each(function(){
         item_secondarylatitude.push($(this).text());
        });
        $('.item_secondarylongitude').each(function(){
         item_secondarylongitude.push($(this).text());
        });

        $.ajax({
         url:"insertSecondary.php",
         method:"POST",
         data:{item_secondarySegmentID:item_secondarySegmentID, 
               item_secondaryFromBusID:item_secondaryFromBusID, 
               item_secondaryToBusID:item_secondaryToBusID, 
               item_secondaryPhasing:item_secondaryPhasing, 
               item_secondaryInstallationType:item_secondaryInstallationType, 
               item_secondaryLength:item_secondaryLength, 
               item_secondaryConductorType:item_secondaryConductorType, 
               item_secondaryConductorSize:item_secondaryConductorSize, 
               item_secondarylatitude:item_secondarylatitude, 
               item_secondarylongitude:item_secondarylongitude},
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

      $('#insertTransformer_Save').click(function(){ 
        var item_transformerTransformerID = [];
        var item_transformerFromPrimaryBusID = [];
        var item_transformerToSecondaryBusID = []; 
        var item_transformerlatitude = [];
        var item_transformerlongitude = [];

        $('.item_transformerTransformerID').each(function(){
         item_transformerTransformerID.push($(this).text());
        });
        $('.item_transformerFromPrimaryBusID').each(function(){
         item_transformerFromPrimaryBusID.push($(this).text());
        });
        $('.item_transformerToSecondaryBusID').each(function(){
         item_transformerToSecondaryBusID.push($(this).text());
        }); 
        $('.item_transformerlatitude').each(function(){
         item_transformerlatitude.push($(this).text());
        });
        $('.item_transformerlongitude').each(function(){
         item_transformerlongitude.push($(this).text());
        });

        $.ajax({
         url:"insertTransformer.php",
         method:"POST",
         data:{item_transformerTransformerID:item_transformerTransformerID, 
               item_transformerFromPrimaryBusID:item_transformerFromPrimaryBusID, 
               item_transformerToSecondaryBusID:item_transformerToSecondaryBusID, 
               item_transformerlatitude:item_transformerlatitude, 
               item_transformerlongitude:item_transformerlongitude},
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

  