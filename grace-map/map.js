  var geocoder;
  var map;
  var infowindow = new google.maps.InfoWindow();
  var latlng; //= new google.maps.LatLng(-34.397, 150.644);
  var marker;
  var currDorm;
  
  function dorm(name, address){
	this.name = name;
	this.address = address;
}	
  
  function dormCoords(name, lat, lng){
	this.name = name;
	this.lat = lat;
	this.lng = lng;
}
  var dorm_list = [
	new dorm("Branner", "655 Escondido Rd, Stanford, CA 94305, USA"),
	new dorm("Wilbur", "658 Escondido Rd, Stanford, CA 94305, USA"),
	new dorm("Stern", "618 Escondido Rd, Stanford, CA 94305, USA"),
	new dorm("Roble", "374 Santa Teresa St, Stanford, CA 94305, USA"), 
	new dorm("Lag", "326 Santa Teresa St, Stanford, CA 94305, USA"),
	new dorm("FloMo", "436 Mayfield Ave, Stanford, CA 94305, USA"),
	new dorm("FroSoCo", "236 Santa Teresa St, Stanford, CA 94305, USA")
	];

  var dorm_coords = [
	new dormCoords("Branner", 37.425057,-122.162746),
	new dormCoords("Wilbur", 37.42463,-122.16151),
	new dormCoords("Stern", 37.425236,-122.165179),
	new dormCoords("Roble", 37.425473,-122.17438),
	new dormCoords("Lag", 37.425504,-122.176707),
	new dormCoords("FloMo", 37.422551,-122.17115),
	new dormCoords("GovCo", 37.42619,-122.180151)
	];

	function findDistance(a, b) {
		return Math.abs((Math.pow(a.geometry.location.lat(), 2) + Math.pow(a.geometry.location.lng(), 2)) - (Math.pow(b.lat, 2) + Math.pow(b.lng, 2)));
	}

    function findMatch(addr){
	var closestIndex = 0;
	var minDistance = findDistance(addr, dorm_coords[0]);
	for(var i = 1; i < dorm_coords.length; i++){
		var distance = findDistance(addr, dorm_coords[i]);
		if (distance < minDistance) {
			minDistance = distance;
			closestIndex = i;
		}
	}
	var lat_lng = new google.maps.LatLng(dorm_coords[closestIndex].lat, dorm_coords[closestIndex].lng);
	var nearestDormMarker = new google.maps.Marker({
				position: lat_lng,
				map: map,
				title: "Nearest dorm"
	});

	var nearestDormWindow = new google.maps.InfoWindow({
		content: 'Found the dorm nearest to you!\nDecorate a room in ' + dorm_coords[closestIndex].name + "?"
	});
	nearestDormWindow.open(map, nearestDormMarker);
}
  function reverseGeocode(){
	/*var latlngstr = input.split(",", 2);
	var lat = parseFloat(latlngstr[0]);
	var lng = parseFloat(latlngstr[1]);*/
	geocoder.geocode({'latLng': latlng}, function(results, status){
	if(status == google.maps.GeocoderStatus.OK) {
		if(results[0]){
			findMatch(results[0]);
			//findMatch(results[0].formatted_address);
		}
	} else {
		alert("Geocoder failed due to: " + status);
		}
	});
}

  function initialize() {
	geocoder = new google.maps.Geocoder();
	
	if(navigator.geolocation){
		function showMap(position){
			latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			//alert(position.coords.latitude + " " + position.coords.longitude);
			var myOptions = {
				zoom: 17,
				center: latlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			marker = new google.maps.Marker({
				position: latlng,
				map: map,
				title: "You are here!"
			});

			infowindow = new google.maps.InfoWindow({
				content: 'You are here!'
			});
			infowindow.open(map, marker);

		      google.maps.event.addListener(marker, 'click', function() {
			infoWindow.setContent("You are here!");
			infoWindow.open(map, marker);
		      });


		}
		navigator.geolocation.getCurrentPosition(showMap);
		//reverseGeocode();
	}
  }
  

  
