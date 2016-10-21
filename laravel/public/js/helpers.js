/*



                                ./(((((((((((/*
                             /((((((((((((((((((((*
                          /((((((((((((((((((((((((((,
                        *((((((((((((((((((((((((((((((.
                      ,((((((((((((((((((((((((((((((((((
                     ,((((((((((((((((((((((((((((((((((((
                    .((((((((((((((((((((((((((((((((((((((
                    (((((((((((((((         (((((((((((((((,
                   *((((((((((((((            ((((((((((((((
                   /(((((((((((((             ((((((((((((((.
                   /(((((((((((((             ((((((((((((((.
                   ,((((((((((((((           ((((((((((((((/
                    /((((((((((((((         (((((((((((((((.
                    .((((((((((((((((((((((((((((((((((((((
                     .((((((((((((((((((((((((((((((((((((.
                      (((((((((((((((((((((((((((((((((((.
                      .((((((((((((((((((((((((((((((((((
                       .((((((((((((((((((((((((((((((((
                        .((((((((((((((((((((((((((((((
                         /((((((((((((((((((((((((((((,
                          (((((((((((((((((((((((((((.
                           (((((((((((((((((((((((((/ ,
                       /(( .(((((((((((((((((((((((. ,((.
                      ((((/  (((((((((((((((((((((/  ((((.
                    .((((((. .(((((((((((((((((((/ .(((((((
                   (((((((((. ,((((((((((((((((((  (((((((((.
                 .(((((((((((. ,(((((((((((((((/  /(((((((((((
                 .((((((((((((  .((((((((((((((  .((((((((((((
                 .((((((((((((,  .((((((((((((   /(((((((((((/
                  ((((((((((,     ,((((((((((      /(((((((((,
                  .((((((/         ,(((((((/         ,(((((((
                  .((((.            .(((((/            ,((((/
                   ((,               .(((/                /(,
                                      .(/                                      

                                  StartupMap.la
                            made with <3 by Aerolab
*/
  
function addUserImg() {
	$('.userPanel img').attr('src', window.env.user.picture);
	$('.userPanel').addClass('logged');
}

function categoriesHoverActive() {
	$("#categories").hoverIntent(function () {
		initialListLeft = 50;
		initialViewLeft = 100;
		$('#list').css('left', initialListLeft + 100);
		// $('.startupView.active').css('left',initialViewLeft);
	}, function () {
		$('#list').css('left', initialListLeft);
		// $('.startupView.active').css('left',initialViewLeft);
	});
}


var MarkerColor = [];
MarkerColor[1] = 'blue';
MarkerColor[2] = 'pink';
MarkerColor[3] = 'red';
MarkerColor[4] = 'purple';
MarkerColor[5] = 'orange';
MarkerColor[6] = 'green'

function changeMapCountry(countryCode, noFit)
{
	if (countryCode != window.env.country.iso) {
		window.env.country = window.env.countryList[countryCode];
		$selectizeCountry[0].selectize.setValue(countryCode);
		$mapCountrySelector[0].selectize.setValue(countryCode);
		getMarkers(null,null,noFit);

		//Set URL
		History.replaceState({}, 'StartupMap - Mapa de Startups Latinoamericanas', '/'+window.env.country.slug);

		//Close Sidebars
		if (!noFit) {
			rightSidebarClose();
			if (sidebarOpen) {
				//Close Sidebar if open
				$('#toggle-nav').wait(80).trigger('click');
			}
		}
	}
}


function getMarkers(requestCategories, requestText, noFit) {
	noFit = typeof noFit !== 'undefined' ? noFit : false;

	mapRequest = {
		country: window.env.country.iso
	};

	if(typeof requestText != 'undefined')
	{
		mapRequest.text = requestText;
	}

	if(typeof requestCategories != 'undefined')
	{
		mapRequest.categories = requestCategories;
	}

	// console.log(mapRequest);

	$.ajax({
		url: window.env.endpoint + 'startup/map',
		type: 'POST',
		dataType: 'json',
		data: mapRequest,
		success: function(data){
			// $('#map').gmap('set', 'bounds', null);

		    if (typeof markerCluster === "object") {
		      map.removeLayer(markerCluster);
		      markerCluster = null;
		      markers = [];
		      categories = [];
		    }


			markerCluster = new L.MarkerClusterGroup({
				showCoverageOnHover: false,
				disableClusteringAtZoom: 19,
				maxClusterRadius: 90,
				spiderfyOnMaxZoom: true,
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
			$.each(data, function (i, item) {

				// var marker = $('#map').gmap('addMarker', {
				//   'id': item.id,
				//   'title': item.title,
				//   'category': item.category,
				//   'position': new google.maps.LatLng(item.lat, item.lon)
				// });
				// var position = item.lat+','+item.lon;
				// // console.log(marker.position);
				// $('#map').gmap('addBounds', position);
				if (item.banner == '') {
					item.banner = '/generic/banner'+Math.floor((Math.random() * 4) + 1)+'.png';
				}
				if (item.facebook != "" ||
						item.twitter != "" ||
						item.linkedin != "" ||
						item.crunchbase != "" ||
						item.angelist != "" ||
						item.dribbble != "" ||
						item.google_plus != "" ||
						item.foursquare != "") {
					item.social = true;
				} else { item.social = false;}

				var marker = L.marker([item.lat, item.lon], {
					'id': item.id,
					'name': item.name,
					'slug': item.slug,
					'category_id': item.category_id,
					'category_slug': item.category_slug,
					'array_key': i,
					'data': item,
					icon: L.AwesomeMarkers.icon({
						icon: item.category_name.toLowerCase(),
						markerColor: MarkerColor[item.category_id],
						className: 'marker company-'+item.id
					})
				});

				marker.on("click", function (event) {

					startupPanel(item.id);

				});

				markers.push(marker);
				markerCluster.addLayer(marker);

				if (typeof item.category_id != 'undefined') {
					category = {  id: item.category_id,
												name: item.category_name,
												slug: item.category_slug };

					// add to main categories array
					var catExist = false;
					for (var j in categories) {
						if ((typeof categories[j].id != 'undefined')
							&& categories[j].id == item.category_id) {
							catExist = true;
						}
					}
					if (catExist == false) categories.push(category);
				}


				// marker.setOpacity(0.2);
			});
			map.addLayer(markerCluster);
			if (!noFit) {
				map.fitBounds(markerCluster);
			}
			// console.log(markerCluster);

			fillCategories();
			if (window.env.startup != '0') {
				startupPanel(window.env.startup);
				window.env.startup = '0';
			}

		}
	});
}

function fillCategories() {
	$('#categories ul').html('');
	var html = '<li class="list-all"><a href="/'+window.env.country.slug+'/all" class="openList" data-id="all"><i class="icon-all"></i>All <span>' + markers.length + '</span></a></li>';
	$(html).appendTo('#categories ul');

	for (var i in categories) {
		var icon = categories[i].name.toLowerCase();
		var amount = $.grep(markers,function (item) {
			return item.options.category_id == categories[i].id;
		}).length;
		var html = '<li class="list-' + icon + '"><a href="/' + window.env.country.slug +'/'+ categories[i].slug + '" class="openList" data-id="'+ categories[i].id +'"><i class="icon-' + icon + '"></i>' + categories[i].name + ' <span>' + amount + '</span></a></li>';
		$(html).appendTo('#categories ul');
	}


}


function loadList(categoryID) {
	//Fill Category List

	//Show only this category Markers
	showMarkers(categoryID);

	//Prepare data for display
	if (categoryID != 'all') {
		var listData = $.grep(markers, function (item) {
			return item.options.category_id == categoryID;
		});
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
	oldPanel = $('.itemsList > div').attr('data-category');
	if (oldPanel == categoryID) {
		return false;
	} else {
		$(html).appendTo('.itemsList').css('left', 400).wait(100).css('left', 0);
		$('div[data-category="' + oldPanel + '"]').wait(450).remove();
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

			if (!markerCluster.hasLayer(item)) {
				markerCluster.addLayer(item);
			}
		}
	} else {
		for (var i in markers) {
			var item = markers[i];

			if (!markerCluster.hasLayer(item)) {
				markerCluster.addLayer(item);
			}

			if (item.options.category_id != categoryID) {
				if (markerCluster.hasLayer(item)) {
					markerCluster.removeLayer(item)
					// console.log('Removed');
				}

			} else {
				setBounds.push(item._latlng);
			}

		}
	}

	//Zoom map out to fit markers
	//map.fitBounds(setBounds);
}


var startupPanelClass = ".startupView";

function startupPanel(dataID) {

	oldPanel = $('#sidebar div.startupView.active').attr('data-id');

	//Get old active Panel
	if (oldPanel == 'startup-' + dataID) {
		return false;
	} else {
		$('div[data-id="' + oldPanel + '"]').wait(450).remove();
	}


	//Search for data
	var data = $.grep(markers, function (item) {
		return item.options.id == dataID;
	})[0];


	// data.social = 

	//Prepare content
	var template = $('#startupTemplate').html();
	Mustache.parse(template);
	var html = Mustache.render(template, data);


	// Insert content and remove old panel
	$(html).appendTo('.panel')
		.wait(100)
		.queue(function () {
			$(this).addClass('active');
		});

	if (!sidebarOpen) {
		$('#toggle-nav').wait(sidebarAnimationWait).addClass("active");
		$('body').addClass('sidebar-open');
		sidebarOpen = true;
	}
	if (userSidebarOpen) {
		rightSidebarClose();
	}

	// Hack: Change the internal size of the map so the pan+zoom animation works properly.
	map._size.x = $(window).width() - 370;

	// Move Map to marker
	// Uses fitBounds() with a custom maxZoom because using panTo + setZoom leads to weird behavior
	map.fitBounds([data._latlng], {maxZoom:17});

	// Embiggen this marker
	$('#map .marker').removeClass('active');

	setTimeout(function(){
		$('#map .marker.company-'+ dataID).addClass('active');
	}, 400);

	History.replaceState({}, data.options.name+' - StartupMap', '/'+data.options.data.country_slug+'/'+data.options.category_slug+'/'+data.options.id+'/'+data.options.slug);
	ga('send', 'pageview', '/'+  data.options.category_slug +'/'+ data.options.slug );


}


function findCategoryByID(id) {
	return $.grep(categories, function (item) {
		return item.id == id;
	})[0];
};

function findMarkerByID(id) {
	return $.grep(markers, function (item) {
		return item.options.id == id;
	})[0];
};

function panToMarker(id) {
	map.panTo(markers[id]._latlng);
}


function hideMarker(id) {
	var item = markers[id];
	if (markerCluster.hasLayer(item)) {
		markerCluster.removeLayer(item)
		// console.log('Removed');
	}
}

function showMarker(id) {
	var item = markers[id];
	if (!markerCluster.hasLayer(item)) {
		markerCluster.addLayer(item)
		// console.log('Removed');
	}


}

function rightSidebarOpen() {
	$('.control').removeClass('error');
	
	if (sidebarOpen) {
		//Close Sidebar if open
		$('#toggle-nav').wait(80).trigger('click');
	}

	$('body').addClass('userSidebar-open');
	map._size.x = $(window).width() - 370;

	userSidebarOpen = true;

	//closeEditView
	closeEditView();
}

function rightSidebarClose() {

	$('body').removeClass('userSidebar-open');
	map._size.x = $(window).width();
	
    if (typeof newMarker === "object") {
        map.removeLayer(newMarker);
        newMarker = false;
    }

	userSidebarOpen = false;
}

var geoData = {},
	newMarker;
function geolocate() {
	if ($('#startupCreateStreet').val() == '' || typeof($('#startupCreateStreet').val())  === "undefined") { return false; }
	if ($('#startupCreateCity').val() == '' || typeof($('#startupCreateCity').val())  === "undefined") { return false; }
	var address_lookup = $('#startupCreateStreet').val()+' '+$('#startupCreateCity').val()+' '+$('#startupCreateCountry').val();
	// console.log(address_lookup);

		var url = "http://maps.googleapis.com/maps/api/geocode/json?address="+address_lookup+"&sensor=true&language=es&components=country:"+$('#startupCreateCountry').val(); //&components=country:AR
		$.get(url,{},function(json){
				if(json.status != 'OK'){
						// MAP.setMessage({'class': 'error','msj':settings.NoAddressFoundText});
						return false;
				}
				if(json.results.length > 1){
						geoData.results = json.results;
						showOptions();
				}else{
					$('.address_options').html("");
					var position = [json.results[0].geometry.location.lat, json.results[0].geometry.location.lng];
					geolocateSetMarker(position);
        
					// L.marker([json.results[0].geometry.location.lat, json.results[0].geometry.location.lng]).addTo(map);
					map.panTo(position);
					map.setZoom(17);
				}
				return typeof(callback) === 'function' ? callback() : this;
		},'json');
}

function geolocateSetMarker(position) {
	if (!position || position == '') {return false;}
	if (!newMarker) {
		newMarker = new L.marker(position, {
			draggable:'false',
			'icon': L.AwesomeMarkers.icon({
				markerColor: 'blue',
				icon: 'add'
			})
		});
		// newMarker.on('dragend', function(event){
		//   var marker = event.target;
		//   var drapPosition = marker.getLatLng();
		//   newMarker.setLatLng(drapPosition,{draggable:'true'}).update();
		//   $('#startupCreateLat').val(drapPosition.lat);
		//   $('#startupCreateLon').val(drapPosition.lng);
		// });
		map.addLayer(newMarker);
	} else {
		newMarker.setLatLng(position,{draggable:'true'}).update();
	}
	$('#startupCreateLat').val(position[0]);
	$('#startupCreateLon').val(position[1]);

}


var showOptions = function(){
		var i = 0;
		html = '';
		for(x in geoData.results){
				var dato = geoData.results[x];
				html += '<li><a data-geomapbox="selected-address" data-index="'+i+'" href="javascript:void(0)">'+dato.formatted_address+'</a></li>';
				i++;
		}
		$('.address_options').html(html);
}

function closeEditView() {
	//Clear form data
	$('.edit-only').hide();
	$('.add-only').show();

	$('.success').hide();

	$('#uploadBannerArea').removeAttr("style");
	$('#uploadLogoArea').removeAttr("style");
	$('#uploadBannerArea').html('<i class="fa fa-cloud-upload"></i>');
	$('#uploadLogoArea').html('<i class="fa fa-cloud-upload"></i>');

	$selectizeCat[0].selectize.clear();
	$selectizeTag[0].selectize.clear();
	$selectizeCity[0].selectize.clear();

	$("#startupCreate input").each(function(){
		$(this).val('');
	});
	$('#startupCreate textarea').val('');
	$selectizeCountry[0].selectize.setValue(window.env.country.iso); //0.2
	// $('#startupCreateCountry').val('Argentina');
}


function openEditView(id) {
	console.log("Edit "+id);
	rightSidebarOpen();
	$('#addStartup').attr('data-action', 'edit');
	$('#userSidebar .sidebarPanel').removeClass('open');
	$('#userSidebar #addStartup').addClass('open');

	$('.add-only').hide();
	$('.edit-only').show();

	var form = $('#startupCreate');
	var data = $.grep(markers, function (item) {
		return item.options.id == id;
	})[0];
	console.log(data);
	populate(form, data.options.data);
	$('#logoFilename').val(data.options.data.logo.file);
	$('#bannerFilename').val(data.options.data.banner.file);

	var countrySelectize = $selectizeCountry[0].selectize;
	countrySelectize.setValue(data.options.data.country_iso);

	var categorySelectize = $selectizeCat[0].selectize;
	categorySelectize.setValue(data.options.data.category_id);

	var tagsSelectize = $selectizeTag[0].selectize;
	tagsSelectize.setValue(data.options.data.tags.split(","));

	var citySelectize = $selectizeCity[0].selectize;
	citySelectize.addOption({city:data.options.data.city});
	citySelectize.setValue(data.options.data.city);

	// $('#startupCreateCountry').val('Argentina');
	// $selectizeCountry[0].selectize.setValue(data.options.data.country_iso);

	// $selectizeCountry[0].selectize.setValue('CL');

	if (data.options.data.logo) {
		$('#uploadLogoArea').css('background-image','url('+data.options.data.logo.thumb+')');
		$('#uploadLogoArea').css('background-size', 'cover');
		$('#uploadBannerArea').html('');
	}
	if (data.options.data.banner) {
		$('#uploadBannerArea').css('background-image','url('+data.options.data.banner.full+')');
		$('#uploadBannerArea').css('background-size', 'cover');
		$('#uploadLogoArea').html('');
	}
	editingItemView = true;
}


function populate(frm, data) {
	$.each(data, function(key, value){
		$('[name='+key+']', frm).val(value);
	});
}

function isLogged(){
	if(typeof window.env.user == 'undefined' ||
		typeof window.env.user['uid'] == 'undefined')
	{
		return false;
	}

	return true;
}

function redirect(url){
	window.location.replace(url);
}

function getURLParams()
{
    return (document.URL.substr(document.URL.indexOf('#')+1)).split('/');
}

function loadInitialPanel() {
	var currentURLHash = getURLParams();

	if(currentURLHash.length == 3)
	{
		if(typeof parseInt(currentURLHash[1]) == 'number'){
			var search = $.grep(markers, function (item) {
				return item.options.id == currentURLHash[1];
			})[0];
			if (typeof search === "object") {
				startupPanel(search.options.id);
			}
		}
	}
}

function buildCitiesDropdown(countryISO)
{
	var cities = [];

	$.each(window.env.countryList[countryISO].cities, function(cityID, cityData){
				cities.push({"city": cityData.name});
	});

	return cities;
}