var sidebarOpen,
	userSidebarOpen,
	initialListLeft,
	initialViewLeft,
	apiPlaces,
	map,
	markers = [],
	categories = [];
$(document).ready(function(){
	
	map = L.map('map', {zoomControl: false}).setView([-34.622101,-58.377602], 13);
	L.tileLayer('http://{s}.tiles.mapbox.com/v3/sbehrends.i44k978f/{z}/{x}/{y}.png', {
	    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
	    maxZoom: 18,
	    minZoom: 3
	}).addTo(map);

	map.addControl( L.control.zoom({position: 'bottomright'}) );

	$('#toggle-nav').click(function(e) {
		if (sidebarOpen) {
			$(this).removeClass("active");
			$('header').css('left',0);
			$('#sidebar').css('left',-370);
			$('#map').css('left',0);
			sidebarOpen = false;

			$('.startupView').wait(450).remove();

		} else {
			$(this).addClass("active");
			$('header').css('left',380);
			$('#sidebar').css('left',0);
			$('#map').css('left',370);

			sidebarOpen = true;
		}
		/* left: 500px; */
		// left: 0;
		e.preventDefault();
	});

	// $('.openList').click(function() {
	// 	$('#categories li').removeClass('active');
	// 	$(this).parent().addClass('active');

	// 	categoriesHoverActive();

	// 	$('a[href="#thumbs"]').removeClass('active');
	// 	$('a[href="#list"]').addClass('active');
	// 	// $('#appWrapper').addClass('listOpen');
	// });

	$('a[href="#list"]').click(function(e) {
		$(this).addClass('active');
		$('a[href="#thumbs"]').removeClass('active');
		$('.styleThumb').removeClass('active');
		e.preventDefault();
	});

	$('a[href="#thumbs"]').click(function(e) {
		$(this).addClass('active');
		$('a[href="#list"]').removeClass('active');
		$('.styleThumb').addClass('active');
		e.preventDefault();
	});


	$("#toggle-nav").on("click", function() {
		
		return false;
	});


	$('.panel').on('click', '#list .items li a', function(e) {
		startupPanel($(this).attr('href').substring(1));
		// startupPanel();
		e.preventDefault();
	});

	/*
	Open list
	v0.1
	$('.panel').on('click', '#categories li a', function(e) {
		loadList($(this).attr('href').substring(1));
		$('.startupView').css('left',490).removeClass('active').wait(450).remove();
		// startupPanel();
		e.preventDefault();
	});*/

	
	$('.panel').on('click', '#categories li a', function(e) {
		loadList($(this).attr('href').substring(1));
		$('.startupView').css('left',370).removeClass('active').wait(450).remove();
		// startupPanel();

		$('#categories li').removeClass('active');
		$(this).parent().addClass('active');

		categoriesHoverActive();

		$('a[href="#thumbs"]').removeClass('active');
		$('a[href="#list"]').addClass('active');
		// $('#appWrapper').addClass('listOpen');

		e.preventDefault();
	});


	$('.panel').on('click', '.startupView .close', function(e) {
		$(this).parent().css('left',370).removeClass('active').wait(450).remove();
		e.preventDefault();
	});

	

	

	$("#list").hoverIntent(function() {
		initialViewLeft = 100;
		// $('.startupView.active').css('left',initialViewLeft+100);
	}, function() {
		// $('.startupView.active').css('left',initialViewLeft);
	});

	// $.getJSON( 'http://localhost:8000/api/startup/all', function(data) {
	// 	apiPlaces = data.places;
	// });
	getMarkers();



	//User Sidebar
	$('#userControl a').click(function(e) {
		if (userSidebarOpen) {
			userSidebarOpen = false;


		} else {
			if (sidebarOpen) {
				//Close Sidebar if open
				$('#toggle-nav').trigger('click');
			}
			$('#userSidebar').css('right',0);
			$('#map').css('right',370);


			userSidebarOpen = true;
		}
		e.preventDefault();
	});

});

function categoriesHoverActive() {
	$("#categories").hoverIntent(function() {
		initialListLeft = 50;
		initialViewLeft = 100;
		$('#list').css('left',initialListLeft+100);
		// $('.startupView.active').css('left',initialViewLeft);
	}, function() {
		$('#list').css('left',initialListLeft);
		// $('.startupView.active').css('left',initialViewLeft);
	});
}

// var MarkerIcon = [];
// var MarkerIconList = [1,4,2,3,5];
// MarkerIcon['Generic'] = L.AwesomeMarkers.icon({
//     markerColor: 'red',
//     extraClasses: 'generic'
//   });
// MarkerIcon[1] = L.AwesomeMarkers.icon({
//     icon: 'startups',
//     markerColor: 'purple'
//   });
// MarkerIcon[4] = L.AwesomeMarkers.icon({
//     icon: 'coworking',
//     markerColor: 'pink'
//   });
// MarkerIcon[2] = L.AwesomeMarkers.icon({
//     icon: 'investors',
//     markerColor: 'red'
//   });
// MarkerIcon[3] = L.AwesomeMarkers.icon({
//     icon: 'incubators',
//     markerColor: 'orange'
//   });
// MarkerIcon[5] = L.AwesomeMarkers.icon({
//     icon: 'accelerators',
//     markerColor: 'light-green'
//   });


var MarkerColor = [];
MarkerColor[1] = 'blue';
MarkerColor[2] = 'pink';
MarkerColor[3] = 'red';
MarkerColor[4] = 'purple';
MarkerColor[5] = 'orange';


function getMarkers() {

$.getJSON( 'js/markers.json', function(data) {
	// $('#map').gmap('set', 'bounds', null);
	markerCluster = new L.MarkerClusterGroup({
		showCoverageOnHover: false,
		disableClusteringAtZoom: 16,
		maxClusterRadius: 140,
		iconCreateFunction: function (cluster) {
			var childCount = cluster.getChildCount();

			var c = ' marker-cluster-';
			if (childCount < 4) {
				c += 'small';
			} else if (childCount < 30) {
				c += 'medium';
			} else {
				c += 'large';
			}

			return new L.DivIcon({ html: '<div><span>' + childCount + '</span></div>', className: 'marker-cluster' + c, iconSize: new L.Point(35, 35) });
		}
	});
	var i;
	$.each( data.places, function(i, item) {
		
		// var marker = $('#map').gmap('addMarker', {
		// 	'id': item.id,
		// 	'title': item.title,
		// 	'category': item.category,
		// 	'position': new google.maps.LatLng(item.lat, item.lon)
		// });
		// var position = item.lat+','+item.lon;
		// // console.log(marker.position);
		// $('#map').gmap('addBounds', position); 

		var marker = L.marker([item.lat, item.lon],{
			'id': item.id,
			'title': item.title,
			'category': item.category,
			'array_key': i,
			'data': item,
			icon: L.AwesomeMarkers.icon({
			    icon: item.category_name.toLowerCase(),
			    markerColor: MarkerColor[item.category]
			  })
		});
		marker.on("click", function() {
			startupPanel(item.id);
        });
		markers.push(marker);
		markerCluster.addLayer(marker);





		if(typeof item.category != 'undefined')
        {
            category = { id : item.category, name : item.category_name };
            
            // add to main categories array
            var catExist = false;
            for(var j in categories)
            {
                if( (typeof categories[j].id != 'undefined') 
                    && categories[j].id == item.category)
                {
                    catExist = true;
                }
            }
            if(catExist == false) categories.push(category);            
        }

		
		// marker.setOpacity(0.2);
	});
	map.addLayer(markerCluster);
	// console.log(markerCluster);

	fillCategories();


});

}

function fillCategories() {
	var html = '<li class="list-all"><a href="#all" class="openList"><i class="icon-all"></i>All <span>'+markers.length+'</span></a></li>';
	$(html).appendTo('#categories ul');

	for (var i in categories) {
		var icon = categories[i].name.toLowerCase();
		var amount = $.grep(markers, function(item){ return item.options.category == categories[i].id; }).length;
		var html = '<li class="list-'+icon+'"><a href="#'+categories[i].id+'" class="openList"><i class="icon-'+icon+'"></i>'+categories[i].name+' <span>'+amount+'</span></a></li>';
		$(html).appendTo('#categories ul');
	}



}


function loadList(categoryID) {
	//Fill Category List

	//Show only this category Markers
	showMarkers(categoryID);

	//Prepare data for display
	if (categoryID != 'all') {
		var listData = $.grep(markers, function(item){ return item.options.category == categoryID; });
	} else {
		var listData = markers;
	}
	var data = {};
	data.amount = listData.length;
	data.id = categoryID;
	data.items = listData;


	//Prepare content
	var template = $('#itemsTemplate').html();
	Mustache.parse(template);
	var html = Mustache.render(template, data);

	//Override older Panel
	oldPanel = $('.items > div').attr('data-category');
	if (oldPanel == categoryID) {
		return false;
	} else {
		$(html).appendTo('.items').css('left',400).wait(100).css('left',0);
		$('div[data-category="'+oldPanel+'"]').wait(450).remove();
	}

	//Set as Active
	$('#list').addClass('openList');

	//Show only this markers on Map

}


function showMarkers(categoryID) {
	var setBounds = [];
	if (categoryID == "all") {
		for (var i in markers) {
			var item = markers[i];

			if(!markerCluster.hasLayer(item))
	            markerCluster.addLayer(item);
	    }
	} else {
		for (var i in markers) {
			var item = markers[i];

			if(!markerCluster.hasLayer(item))
	            markerCluster.addLayer(item);

			if (item.options.category != categoryID) {
				if(markerCluster.hasLayer(item)) {
	                markerCluster.removeLayer(item)
	            	console.log('Removed');
	            }

				
			} else {
				setBounds.push(item._latlng);
			}

		}
	}
	//Zoom map out to fit markers
	// map.fitBounds(setBounds);

}



var startupPanelClass = ".startupView";

function startupPanel(dataID) {

	oldPanel = $('div.startupView.active').attr('data-id');

	//Get old active Panel
	if (oldPanel == 'startup-'+dataID) {
		return false;
	} else {
		$('div[data-id="'+oldPanel+'"]').wait(450).remove();
	}

	//Search for data
	var data = $.grep(markers, function(item){
      return item.options.id == dataID;
    })[0];

    //Prepare content
	var template = $('#startupTemplate').html();
	Mustache.parse(template);
	var html = Mustache.render(template, data);


	//Inster content and remove old panel
	$(html).appendTo('.panel')
		.wait(100)
		.queue(function() {
			$(this).addClass('active');
		});

	if (!sidebarOpen) {
		$('#toggle-nav').wait(200).addClass("active");
		$('header').wait(200).css('left',380);
		$('#sidebar').wait(200).css('left',0);
		$('#map').wait(200).css('left',370);

		sidebarOpen = true;
	}

	//Move Map to marker
	map.panTo(data._latlng);
	data.bindPopup("Popup!").openPopup();
	map.setZoom(16);

}

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