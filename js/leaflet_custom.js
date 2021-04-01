<script type="text/javascript">
	var map = L.map('map_window', {
		fullscreenControl: true
	}).setView([11.0409, 124.6035], 17);		
	
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);	
   
	L.Control.boxzoom({ 
		position:'topleft' 
	}).addTo(map);
	L.control.mousePosition({
		position: 'topright',
		separator: " | ",
		lngFirst: true,
		lngFormatter: undefined,
		latFormatter: undefined,
		prefix: "Coordinates: "
	}).addTo(map);
	/*
	 L.Routing.control({
	  waypoints: [
	    L.latLng(11.0409, 124.6035),
	    L.latLng(11.03975, 124.6038)
	  ]
	}).addTo(map);
	*/
    function onMapClick(e) {
	    alert("You clicked the map at " + e.latlng);
	}
	map.on('click', onMapClick);
</script>