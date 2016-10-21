<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es" prefix="og: http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#"> <!--<![endif]-->
	<head>
		
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />

		<!-- Title -->
		<title>{{ $pageTitle }}</title>
		<meta name="description" content="Queremos conectar al ecosistema emprendedor en Argentina y la región! Colaborá sumando tu organización o completando la información de otras.">
		<link rel="canonical" href="http://startupmap.la" />
		<meta name="robots" content="INDEX, FOLLOW" />

		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="icon" href="/favicon.ico" />

		<meta property="og:title" content="{{ $pageTitle }}" />
		<meta property="og:description" content="Queremos conectar al ecosistema emprendedor en Argentina y la región! Ayudanos a mapear el dinámico mundo startup. Colaborá sumando tu organización o completando la información de otras." />
		<meta property="og:image" content="http://startupmap.la/images/landing/profile.jpg" />
		<meta property="og:url" content="http://startupmap.la" />


		<!-- CSS -->
		@include('assets.css')

		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-50916131-1', 'startupmap.la');
			ga('require', 'displayfeatures');
			ga('send', 'pageview');

			@if( Session::has('isNewUserLinkedin') && Session::get('isNewUserLinkedin') )
			// Report new linkedin users
			ga('send', 'event', 'Nuevo Usuario', 'LinkedIn');
			@endif
		</script>

	</head>
	<body>

		<!--[if lt IE 10]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

		<div id="appWrapper">

			<header>
				<a href="#" id="toggle-nav">
					<i>
						<span class="top-left"></span>
						<span class="top-right"></span>
						<span class="middle"></span>
						<span class="bottom-left"></span>
						<span class="bottom-right"></span>
					</i>
				</a>
				
				<h1>StartupsMap</h1>

				{{ Form::select('mapCountrySelector', Country::where('enabled', 'y')->get()->lists('name', 'iso'), $country, array( 'id' => 'mapCountrySelector' )) }}
			</header>
				
			<div id="share">
				<span class="share facebook">
					<span class="fb-share-button" data-href="http://startupmap.la/" data-type="button_count"></span>
				</span>
				<span class="share twitter">
					<a href="https://twitter.com/share" class="twitter-share-button" data-text="En @startupmapla podés ver las #startups en LatAm ¿Ya agregaste la tuya? Chequealas en http://startupmap.la" data-lang="es">Tweet</a>
				</span>
			</div>

			@if($showCountryModal)
				@include('modules.country')
			@endif

			<div id="sidebar">
				<div class="searchBar">
					<input type="text" name="" placeholder="Search..." value="">
				</div>

				<div class="panel">
					<div id="categories">
						<ul></ul>
						<a href="#" class="aboutUs"><i class="fa fa-info-circle"></i>Informacion</a>
					</div>
					<div id="list">
						<div class="itemsList"></div>

						<div id="filters">
							<ul>
								<li><a href="#thumbs"><i class="fa fa-th-large"></i> Logotipos</a></li>
								<li><a href="#list" class="active"><i class="fa fa-align-left"></i> Listado</a></li>
								<!--
								<li><a href="#"><i class="fa fa-tag"></i> Etiquetas</a></li>
								<li><a href="#"><i class="fa fa-circle-o"></i> ECommerce</a></li>
								<li><a href="#"><i class="fa fa-circle-o"></i> Marketplace</a></li>
								<li><a href="#"><i class="fa fa-circle-o"></i> Mobile app</a></li>
								<li><a href="#"><i class="fa fa-circle-o"></i> Gaming</a></li>-->
							</ul>
						</div>
					</div>
				</div>
				<!-- END .panel -->

				<a href="#leftClose" id="leftClose">
					<i class="icon-add"></i>
				</a>
				
				@include('modules.about')
			</div>
			<!-- END #sidebar -->

			<div id="hugeMap">
				<footer>
					<a href="http://aerolab.com.ar" target="_blank">by Aerolab</a>
				</footer>

				<div id="map"></div>
			</div>
			<!-- END #hugeMap -->

			<div id="rightControl">
				<div id="userControl">
					<a href="#userPanel" class="userPanel">
												<img class="user" src="http://m.c.lnkd.licdn.com/mpr/mprx/0_OYjMBBX9HQkiCuJpY0SEBzXUHkimCuJppMd6BqbFcbcYgHaytZDvJN1d62_l3w4r0g0bZPM3P-b0"/>
						<i class="icon-user"></i>
					</a>
					<a href="#addStartup" class="tooltip-left" data-tooltip="Agregar un item">
						<i class="icon-add"></i>
					</a>

					<a href="#" id="userVoiceModal" class="tooltip-left" data-tooltip="Deja un comentario">
						<i class="icon-chat"></i>
					</a>
				</div>
				<a href="#rightClose" id="rightClose" class="tooltip-left" data-tooltip="Cerrar pestaña">
					<i class="icon-add"></i>
				</a>
			</div>
			<!-- END #rightControl -->

			<div id="userSidebar">
				@include('modules.startup_form')
				@include('modules.register')
				@include('modules.login')
				@include('modules.recover')
				@include('modules.userpanel')
			</div>
			<!-- END #userSidebar -->

		</div>
		<!-- END #appWrapper -->
		
		<!-- Mustache templates -->
		@include('mustache.profile')
		@include('mustache.items')
		@include('mustache.startup')
		
		<!-- Javascript -->
		@include('assets.javascript')
	</body>
</html>