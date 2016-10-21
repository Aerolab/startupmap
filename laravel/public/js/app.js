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

var sidebarOpen,
	userSidebarOpen,
	initialListLeft,
	initialViewLeft,
	apiPlaces,
	map,
	markers = [],
	categories = [],
	setGeoData,
	editingItemView,
	$selectizeCountry,
	$mapCountrySelector,
	$modalCountrySelector,
	$selectizeCity,
	countryCities;
var $varselectize = [];

var sidebarAnimationWait = 200;

$(document).ready(function(){

	window.map = L.map('map', {zoomControl: false}).setView([-34.622101, -58.377602], 13);
	L.tileLayer('http://{s}.tiles.mapbox.com/v3/aerolab.map-oin5832f/{z}/{x}/{y}.png', { //Aerolab Mapobox
	// L.tileLayer('http://{s}.tiles.mapbox.com/v3/examples.map-i86nkdio/{z}/{x}/{y}.png', { //Example Mapbox
	//L.tileLayer('http://a.tile.openstreetmap.org/{z}/{x}/{y}.png', { //OSM
		attribution: '<a href="https://www.mapbox.com/about/maps/">&copy; Mapbox &copy; OpenStreetMap</a>',
		maxZoom: 17,
		minZoom: 3
	}).addTo(map);

	map.addControl(L.control.zoom({position: 'bottomright'}));

	getMarkers();

	$('#toggle-nav').click(function (e) {
		if (sidebarOpen){
			$(this).removeClass("active");

			$('body').removeClass('sidebar-open');

			sidebarOpen = false;

			$('#sidebar .startupView').wait(450).remove();
			$('#map .marker').removeClass('active');

			// Hack: Change the internal size of the map so the pan+zoom animation works properly.
			map._size.x = $(window).width();

		} else {
			if (userSidebarOpen) {
				rightSidebarClose();
			}

			$('body').addClass('sidebar-open');

			$(this).addClass("active");

			sidebarOpen = true;

			// Hack: Change the internal size of the map so the pan+zoom animation works properly.
			map._size.x = $(window).width() - 370;
		}
		e.preventDefault();
	});

	$('a[href="#list"]').click(function (e) {
		$(this).addClass('active');
		$('a[href="#thumbs"]').removeClass('active');
		$('.styleThumb').removeClass('active');
		e.preventDefault();
	});

	$('a[href="#thumbs"]').click(function (e) {
		$(this).addClass('active');
		$('a[href="#list"]').removeClass('active');
		$('.styleThumb').addClass('active');
		e.preventDefault();
	});

	$(".aboutUs").on("click", function (e) {
		$('#about').addClass('open');
		e.preventDefault();
	});

	$('#about .close').click(function (e) {
		$('#about').removeClass('open');
		e.preventDefault();
	});

	$('.panel').on('click', '#list .itemsList li a', function (e) {

		startupPanel($(this).attr('data-id'));
		e.preventDefault();
		
	});

	$('.panel').on('click', '#categories li a', function (e) {
		e.preventDefault();

		// var categoryId = $(this).attr('href').substring(1); Old 0.1
		var categoryId = $(this).attr('data-id'); //0.2
		console.log(categoryId);

		if (categoryId != "all") {
			var category = findCategoryByID(categoryId);
		} else {
			var category = {
				slug: 'all'
			};
		}

		loadList(categoryId);
		$('#sidebar .startupView').css('left', 370).removeClass('active').wait(450).remove();

		$('#categories li').removeClass('active');
		$(this).parent().addClass('active');

		categoriesHoverActive();

		$('a[href="#thumbs"]').removeClass('active');
		$('a[href="#list"]').addClass('active');

		History.replaceState({}, 'StartupMap - Mapa de Startups Latinoamericanas', '/'+window.env.country.slug+'/'+category.slug);
		ga('send', 'pageview', '/'+  category.slug );

		
	});


	$('.panel').on('click', '.startupView .close', function (e) {
		$(this).parent().css('left', 370).removeClass('active').wait(450).remove();
		$('#map .marker').removeClass('active');
		e.preventDefault();
	});


	$("#list").hoverIntent(function () {
		initialViewLeft = 100;
	});

	$('.panel').on('click', 'a[href="#edit"]', function (e) {
		if (!isLogged()) {
			$('#login .msg').html("Identificate para editar una startup");
			$('#userControl a[href="#userPanel"]').trigger('click');
			return false;
		}

		openEditView($(this).data('id'));
		e.preventDefault();
	});

	$('#userControl a[href="#userPanel"]').click(function (e) {
		rightSidebarOpen();
		$('#userSidebar .sidebarPanel').removeClass('open');
		if( ! isLogged()){
			$('#userSidebar #login').addClass('open');
		} else {
			$('#userSidebar #profilePanel').addClass('open');
			var template = $('#profilePanelTemplate').html();
			Mustache.parse(template);
			$('#profilePanel').empty().html(Mustache.render(template, window.env.user));
		}
		e.preventDefault();
	});

	$('#userControl a[href="#addStartup"]').click(function (e) {
		if (!isLogged()) {
			$('#login .msg').html("Identificate para agregar una startup");
			$('#userControl a[href="#userPanel"]').trigger('click');
			return false;
		}
		rightSidebarOpen();
		$('#userSidebar .sidebarPanel').removeClass('open');
		$('#userSidebar #addStartup').addClass('open');
		e.preventDefault();
	});

	$('#leftClose').click(function (e) {
		$('#toggle-nav').wait(sidebarAnimationWait).removeClass("active");
		$('body').removeClass('sidebar-open');
		map._size.x = $(window).width();
		sidebarOpen = false;
		e.preventDefault();
	});

	$('#rightClose').click(function (e) {
		map._size.x = $(window).width();
		rightSidebarClose();
		e.preventDefault();
	});

	$('#registerBtn').click(function (e) {
		$('#userSidebar .sidebarPanel').removeClass('open');
		$('#userSidebar #register').addClass('open');
		e.preventDefault();
	});

	$('#recoverBtn').click(function (e) {
		$('#userSidebar .sidebarPanel').removeClass('open');
		$('#userSidebar #recover').addClass('open');
		e.preventDefault();
	});

	$('#registerBackBtn, #recoverBackBtn').click(function (e) {
		$('#userSidebar .sidebarPanel').removeClass('open');
		$('#userSidebar #login').addClass('open');
		e.preventDefault();
	});

	$("#addStartup .toggle a").on("click", function (e) {
		var social = $(this).attr('href').substring(1);
		$(this).toggleClass('active');
		$(this).parent().parent().find('.i-'+social).slideToggle();
		e.preventDefault();
	});

	//Search Address on type
	$('.location input').bind('keypress', function(e){ geolocate(); });

	//List of Geocoded Address and Fill with
	$(document).on('click','[data-geomapbox="selected-address"]', function(){
		var $this = $(this);
		setGeoData = {
			lat : geoData.results[$(this).data('index')].geometry.location.lat,
			lng : geoData.results[$(this).data('index')].geometry.location.lng
			// formatted_address : geoData.results[$this.data('index')].formatted_address
		}
		var city = geoData.results[$(this).data('index')].address_components[2].short_name;

		//Add value to city menu
		var citySelectize = $selectizeCity[0].selectize;
		citySelectize.addOption({city:city});
		citySelectize.setValue(city);

		$('.address_options').empty();

		var position = [setGeoData.lat,setGeoData.lng];
		geolocateSetMarker(position);
		map.panTo([setGeoData.lat,setGeoData.lng]);

		map.setZoom(17);
	});

	$('#uploadLogoArea').click(function(){
		$('#uploadLogo').click();
	});

	$('#uploadBannerArea').click(function(){
		$('#uploadBanner').click();
	});


	$selectizeCat = $('#startupCreateCategory').selectize();
	$selectizeTag = $('#startupCreateTags').selectize({
		maxItems: 4
	});



	$selectizeCity = $('#startupCreateCity').selectize({
		create: true,
		createOnBlur: true,
		maxItems: 1,
		valueField: 'city',
		labelField: 'city',
		searchField: ['city']
		,onChange: geolocate
	});

	//Cargar lista ciudades inicial
	var citySelectize = $selectizeCity[0].selectize;
	citySelectize.clearOptions();
	$.each( window.env.countryList[window.env.country.iso].cities, function( i, value ){
	    citySelectize.addOption({"city": value.name});
	});

	$selectizeCountry = $('#startupCreateCountry').selectize({
		onChange: function() {
			var obj = $('#startupCreateCountry');
			changeMapCountry(obj.val(),true);
			// $mapCountrySelector[0].selectize.setValue(obj.val());
			geolocate();
			var citySelectize = $selectizeCity[0].selectize;
			citySelectize.clearOptions();
			$.each( window.env.countryList[window.env.country.iso].cities, function( i, value ){
			    citySelectize.addOption({"city": value.name});
			});
			// console.log(buildCitiesDropdown(obj.val()));
		},
		onInitialize: function() {
			// console.log(window.env.country);
			// if(typeof window.env.country === 'object' && window.env.startup == '0'){
			// 	this.setValue(window.env.country.iso);
			// 	$('#startupCreateCountry').val(window.env.country.iso);
			// }
		}
	});
	$selectizeCountry[0].selectize.setValue(window.env.country.iso);

	$('.panel').on('click', '#startupClaim', function (e) {
		$('.claimForm').slideToggle();
		e.preventDefault();
	});

	
	$('.success', $('#userSidebar')).click(function(){
		rightSidebarClose();
		$(this).hide();
	});

	var inputErrorClass = 'error';
	var appClass = '.app';
	var appDataAttr = 'data-app-route';

	var appDebug = true;

	var app = {
		'request': function(route, params, verb, callback)
		{
			$('.errorList').hide();
			$('.control').removeClass('error');

			if(typeof verb == 'undefined'){
				verb = 'POST';
			}

			if(typeof params == 'undefined'){
				params = {};
			}

			$.ajax({
				url: window.env.endpoint + route, 
				dataType: 'json', 
				data: params,
				type: verb,
				async: true,
				complete: function(xhr){
					if(appDebug)
					{
						console.log(xhr.responseJSON);
					}

					if(typeof xhr.responseJSON.redirect != 'undefined'){
						redirect(xhr.responseJSON.redirect);
						return;
					}

					if(typeof callback == 'function'){
						callback(xhr, xhr.responseJSON);
					}

					return;
				}
			});
		},
		'auth': {
			'login': function()
			{
				app.request('login', { email: $('#appLoginEmail').val(), password: $('#appLoginPassword').val() }, 'POST', function(xhr, response){
					if(xhr.status == 400)
					{
						alertBuilder(response.errors, {
							email: 'login-email',
							password: 'login-password'
						});

						return false;
					} 

					window.env.user = response.user;
					addUserImg();
					$('#btnLogin').removeClass('processing');
				});

				return;
			},
			'logout': function()
			{
				app.request('logout', {}, 'GET', function(xhr, response){
					if(xhr.status == 200)
					{
						window.env.user = false;
						$('.userPanel').removeClass('logged');
						rightSidebarClose();
					}
				});

				return;
			},
			'linkedin': function()
			{
				app.request('login/linkedin', {}, 'GET', function(response){});
			}
		},
		'user': {
			'create': function()
			{
				if(isLogged())
				{
					return false;
				}

				app.request('user', $('#registerForm').jsonIt(), 'POST', function(xhr, response){
					if(xhr.status == 400)
					{
						alertBuilder(response.errors, {
							email: 'register-email',
							password: 'register-password',
							name: 'register-name',
							last_name: 'register-last_name'
						});

						return false;
					}

					$('#registerSuccess').show();
					window.env.user = response.user;

					$('#btnRegister').removeClass('processing');

					ga('send', 'event', 'Nuevo Usuario', 'E-Mail');
				});

				return;
			},
			'recover': function()
			{
				if(isLogged())
				{
					return false;
				}

				app.request('reset_password', $('#recoverForm').jsonIt(), 'POST', function(xhr, response){
					if(xhr.status == 400)
					{
						alertBuilder(response.errors, {
							email: 'recover-email'
						});
				
						$('#btnRecover').removeClass('processing');
					}

					$('#btnRecover').removeClass('processing');
					$('.success', $('#userSidebar #recover')).show();
				});

				return;
			}
		},
		'startup': {
			'claim': function()
			{
				if( ! isLogged())
				{
					alert('You have to be logged.');
					return false;
				}

				app.request('startup/' + $('#currentStartupView').val() + '/claim', {note: $('#claimNote').val() }, 'POST', function(xhr, response){
					if(xhr.status == 400)
					{
						alert(response.error);
						return false;
						$('#btnClaim').removeClass('processing');
					}

					alert(response.message);
					$('.claimForm').hide();
					$('#btnClaim').removeClass('processing');
					return;
				});
			},
			'create': function()
			{
				if( ! isLogged())
				{
					alert('You have to be logged.');
					return false;
				}

				app.request('startup', $('#startupCreate').jsonIt(), 'POST', function(xhr, response){
					console.log(response);
					if(xhr.status == 400)
					{
						alertBuilder(response, {
							name: 'startup-name',
							slogan: 'startup-slogan',
							category: 'startup-category',
							tags: 'startup-tags',
							address: 'startup-address',
							city: 'startup-city',
							country: 'startup-country',
							website: 'startup-website',
							crunchbase: 'startup-crunchbase',
							angelist: 'startup-angellist',
							facebook: 'startup-facebook',
							dribbble: 'startup-dribbble',
							twitter: 'startup-twitter',
							foursquare: 'startup-foursquare',
							google_plus: 'startup-googleplus',
							linkedin: 'startup-linkedin',
							youtube: 'startup-youtube',
							description: 'startup-description',
							logo: 'startup-logo',
							banner: 'startup-banner'
						});

						$('#btnStartupCreate').removeClass('processing');
						$('#addStartup').scrollTop(0);

						return false;
					}

					$('#btnStartupCreate').removeClass('processing');
					$('#startupCreateSuccess').show();
					$('input,select,textarea', '#startupCreate').empty();

					var category = findCategoryByID( $('#startupCreate').jsonIt().name );
					ga('send', 'event', 'Nueva Empresa', category);

					// alert('Startup publicado');
					// redirect("http://startupmap.la/map");
					if (typeof newMarker === "object") {
						map.removeLayer(newMarker);
						newMarker = false;
					}
					getMarkers();
				});

				return false;
			},
			'edit': function()
			{
				if( ! isLogged())
				{
					alert('You have to be logged.');
					return false;
				}

				app.request('startup/' + $('#startupCreateID').val(), $('#startupCreate').jsonIt(), 'PUT', function(xhr, response){
					if(xhr.status == 400)
					{
						alertBuilder(response, {
							name: 'startup-name',
							slogan: 'startup-slogan',
							category: 'startup-category',
							tags: 'startup-tags',
							address: 'startup-address',
							city: 'startup-city',
							country: 'startup-country',
							website: 'startup-website',
							crunchbase: 'startup-crunchbase',
							angelist: 'startup-angellist',
							facebook: 'startup-facebook',
							dribbble: 'startup-dribbble',
							twitter: 'startup-twitter',
							foursquare: 'startup-foursquare',
							google_plus: 'startup-googleplus',
							linkedin: 'startup-linkedin',
							youtube: 'startup-youtube',
							description: 'startup-description',
							logo: 'startup-logo',
							banner: 'startup-banner'
						});
						$('#btnStartupEdit').removeClass('processing');

						return false;
					}

					$('.success', '#addStartup').show();
					$('#btnStartupEdit').removeClass('processing');
					if (typeof newMarker === "object") {
						map.removeLayer(newMarker);
						newMarker = false;
					}
					getMarkers();
				}); 

				return false;
			}
		}
	};



	$('#appWrapper').on('click', appClass, function(e){
		var reqRoute = ($(this).attr(appDataAttr)).split('.');
		var method = app;

		$(this).addClass('processing');

		if(reqRoute.length != 0)
		{
			for(var i = 0; i <= (reqRoute.length-1); i++){
				var temp = reqRoute[i];
				if(typeof method != 'undefined')
				{
					method = method[temp];
				}
			}

			method();
		}

		e.preventDefault();
	});

	var alertBuilder = function(messageBag, fieldList){
		$.each(fieldList, function(fieldId, fieldTag){
			var errorCounter = 0;
			if(typeof messageBag[fieldId] != 'undefined'){

				$('input, textarea', '.control[data-control=' + fieldTag + ']').bind('focus', function(){
					$('.control[data-control=' + fieldTag + ']').removeClass('error');
				});

				$('.errorList', '.control[data-control=' + fieldTag + ']').empty();
				$.each(messageBag[fieldId], function(errorId, errorMsg){
					$('.errorList', '.control[data-control=' + fieldTag + ']').append('<li>' + errorMsg + '</li>');
					errorCounter++;
				});

				if(errorCounter > 0){
					$('.control[data-control=' + fieldTag + ']').addClass('error');
				}
			}
		});
	}

	$mapCountrySelector = $('#mapCountrySelector').selectize({
		render: {
			option: function(data, escape){
				return '<div class="countryItem country' + escape(data.value) + '"><i></i><span>' + escape(data.text) + '</span></div>';
			},
			item: function(data, escape){
				return '<div class="countryItem selected country' + escape(data.value) + '"><i></i><span>' + escape(data.text) + '</span></div>';
			}
		}
	});

	$mapCountrySelector.on('change', function(e){
		var obj = $('#mapCountrySelector');
		changeMapCountry(obj.val());
	})

	$('.ajaxFileUpload').each(function(){
		var uploadRoute = $(this).attr('data-upload-route');
		var uploadField = $('#' + $(this).attr('data-upload-field'));
		var uploadInput = $('#' + $(this).attr('data-upload-input'));
		var uploadDropzone = $('.dropzone', $(this));
		
		var fileUploader = $(this).fileupload({
			url: window.env.endpoint + uploadRoute, 
			fileInput: uploadInput,
			dropZone: uploadDropzone,
			dataType: 'json',
			success: function(e, data){
				if(e.status == 'error')
				{
					alert(e.error);
					return false;
				}
				uploadField.empty().val(e.file.name);
				uploadDropzone.empty().css('background-image', 'url(' + e.file.path + ')');
				uploadDropzone.css('background-size', 'cover');

				return false;
			},
			fail: function(){
				alert(e.error); 
				return false;
			}
		});

		fileUploader.bind('fileuploaddragover', function(e, data){
			uploadDropzone.addClass('drag-over');
			setTimeout(function(){
				uploadDropzone.removeClass('drag-over');
			}, 4000)
		}); 

		fileUploader.bind('fileuploadsubmit', function(e, data){
			uploadDropzone.removeClass('drag-over');
			uploadDropzone.addClass('uploading');
		});

		fileUploader.bind('fileuploaddone', function(e, data){
			uploadDropzone.removeClass('drag-over, uploading');
		});
	});

	if (isLogged()) { addUserImg(); }

	if(typeof window.env.country === 'object' && window.env.startup == '0'){
		changeMapCountry(window.env.country.iso);
	}


	//Landing Modal Country Selector
	var $modalCountrySelector = $('#modalCountrySelector').selectize({
		render: {
			option: function(data, escape){
				return '<div class="countryItem country' + escape(data.value) + '"><i></i><span>' + escape(data.text) + '</span></div>';
			},
			item: function(data, escape){
				return '<div class="countryItem selected country' + escape(data.value) + '"><i></i><span>' + escape(data.text) + '</span></div>';
			}
		}
	});

	$modalCountrySelector.on('change', function(e){
		var obj = $('#modalCountrySelector');
		changeMapCountry(obj.val());
		// $mapCountrySelector[0].selectize.setValue(obj.val());
		$modalCountrySelector[0].selectize.destroy();
		$('#modalCountrySelect').remove();
	});

	

});
//End Document Ready
