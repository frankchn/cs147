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

  var dorm_list = [
	new dorm("Branner", "655 Escondido Rd, Stanford, CA 94305, USA"),
	new dorm("Wilbur", "658 Escondido Rd, Stanford, CA 94305, USA"),
	new dorm("Stern,", "618 Escondido Rd, Stanford, CA 94305, USA"),
	new dorm("Roble,", "374 Santa Teresa St, Stanford, CA 94305, USA"), 
	new dorm("Lag", "326 Santa Teresa St, Stanford, CA 94305, USA"),
	new dorm("FloMo", "436 Mayfield Ave, Stanford, CA 94305, USA"),
	new dorm("FroSoCo", "236 Santa Teresa St, Stanford, CA 94305, USA")
	];
  
    function findMatch(addr){
	for(var i = 0; i < dorm_list.length; i++){
		if(dorm_list[i].address == addr){
			var infowindow = new google.maps.InfoWindow({
				content: 'Found dorm!\nDecorate a room in ' + dorm_list[i].name + "?"
			});
			infowindow.open(map, marker);
			break;
		}
	}
}
  function reverseGeocode(){
	/*var latlngstr = input.split(",", 2);
	var lat = parseFloat(latlngstr[0]);
	var lng = parseFloat(latlngstr[1]);*/
	geocoder.geocode({'latLng': latlng}, function(results, status){
	if(status == google.maps.GeocoderStatus.OK) {
		if(results[0]){
			findMatch(results[0].formatted_address);
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
		//	alert(position.coords.latitude + " " + position.coords.longitude);
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
		}
		navigator.geolocation.getCurrentPosition(showMap);
		//reverseGeocode();
	}
  }
  

  