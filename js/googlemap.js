function loadMap(){
	var myLatLng = {lat: 18.5204, lng: 73.8567};
    var map = new google.maps.Map(document.getElementById('map'), {
      center: myLatLng,
      zoom: 4
    });
}