var layers = {},
	// markers = [],
	categories = [],
	hideTags = [],
	hideCategories = [],
	map,
	markerCluster;

$(document).ready(function(){

//Trying LeafletJS
// map = L.map('map', {zoomControl: false}).setView([-34.622101,-58.377602], 13);
// L.tileLayer('http://{s}.tiles.mapbox.com/v3/sbehrends.i44k978f/{z}/{x}/{y}.png', {
//     attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
//     maxZoom: 18,
//     minZoom: 3
// }).addTo(map);

// map.addControl( L.control.zoom({position: 'bottomright'}) );

$(window).on("resize", function() {
	// map.invalidateSize();
}).trigger("resize");

$('#map').resize(function(){
    var elem = $(this);
    
    // Update the info div width and height - replace this with your own code
    // to do something useful!
    elem.closest('.container').find('.info')
      .text( this.tagName + ' width: ' + elem.width() + ', height: ' + elem.height() );
  });
  
  // Update all info divs immediately.
  $('#map').resize();
// getMarkers();


});


// function getJSON() {
// 	$.getJSON( 'js/markers.json', function(data) {
// 		var places = data.places;
// 		var points = [];

// 		for (var i in places) {
// 			//Go thought each item in JSON

// 			var place = places[i];

// 			//Skip if no point defined
// 			if (place.lat == '' || place.lon == '') continue;

// 			//Fallback if empty Category
// 			var category = {id: 0, name: '0'};

// 			//Look for Category
// 			if(typeof place.category != 'undefined') {
// 				category = {id: place.category, name: place.category_name};

// 				//Add Category to main list
// 				var categoryExist = false;
// 				for (var j in categories) {
// 					if( (typeof categories[j].id != 'undefined')
// 						&& categories[j].id == place.category) {
// 						categoryExist = true;
// 					}
// 				}
// 				if (categoryExist == false) {
// 					categories.push(category);
// 				}

// 			}
// 			//End Look Category

// 			var tag = {};



// 		}

// 	});

// }






function findMarkerByID(id){
    var test =  $.grep(markers, function(item){
      return item.options.id == id;
    });
    console.log(test);
};

function panToMarker(id) {
	map.panTo(markers[id]._latlng);
	// map.setZoom(18);
}




function hideMarker(id) {
	var item = markers[id];
	if(markerCluster.hasLayer(item)) {
        markerCluster.removeLayer(item)
    	console.log('Removed');
    }
}

function showMarker(id) {
	var item = markers[id];
	if(!markerCluster.hasLayer(item)) {
        markerCluster.addLayer(item)
    	console.log('Removed');
    }
}


//When Marker clicked open info

// $marker.click(function() {
// 	// $('#map').gmap('openInfoWindow', {'content': 'Hello World!'}, this);
// 	console.log("Im a marker :)");
// });