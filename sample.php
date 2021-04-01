<!DOCTYPE html>
<html>
<head>
	<title></title>

	<script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
</head>
<body>

	<div id="map_window" style="width: 100%; height: 250px;"></div>

	<script type="text/javascript">
	    var map = L.map('map_window').setView([11.0409, 124.6035], 17); 

	    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
	        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
	    }).addTo(map);  
	</script>

</body>
</html>