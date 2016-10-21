var api = 'http://localhost/startupsmap/laravel/public/api/';
var startupMap = new Maplace({
		map_div: '#map',
		generate_controls: false,
		map_options: {
			set_center: [-34.6158526,-58.4332985],
			zoom: 13,
			styles: [{"featureType":"poi","stylers":[{"visibility":"off"}]},{"stylers":[{"saturation":-70},{"lightness":37},{"gamma":1.15}]},{"elementType":"labels","stylers":[{"gamma":0.26},{"visibility":"off"}]},{"featureType":"road","stylers":[{"lightness":0},{"saturation":0},{"hue":"#ffffff"},{"gamma":0}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"lightness":50},{"saturation":0},{"hue":"#ffffff"}]},{"featureType":"administrative.province","stylers":[{"visibility":"on"},{"lightness":-50}]},{"featureType":"administrative.province","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"administrative.province","elementType":"labels.text","stylers":[{"lightness":20}]}],
			streetViewControl: false,
			mapTypeControl: false,
			panControl: true,
			panControlOptions: {
		        position: google.maps.ControlPosition.RIGHT_TOP
		    },
		    zoomControl: true,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.LARGE,
				position: google.maps.ControlPosition.RIGHT_TOP
			}
		}
	});

$(document).ready(function(){

	// Load the map markers
	fetchLocations('startup/map');

});

function fetchLocations(command){
	$.getJSON(api + command, {}, function(data){
		var locations = [];

		$.each(data, function(index, locationData){
			locations.push(locationData);
		});

		window.startupMap.Load({
			locations: locations
		});
	});
}