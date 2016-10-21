<!doctype html>
<html lang="en">
	<head>

		<!-- Meta -->
		<meta charset="UTF-8">

		<!-- Title -->
		<title>{{ $pageTitle }}</title>

		<!-- CSS -->
		<link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
		<link href="{{ asset('css/admin/style.css') }}" rel="stylesheet" />
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css" />

    	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

		<style type="text/css">
			body {
				margin-top: 40px;
			}

			th.header {
				cursor: pointer;
			}
			#startupPieChart {
				width: 100%;
				height: 450px;
			}
		</style>

	</head>

	<body>

		<div class="container">
			<div class="row-fluid">
				<div class="span12">
				</div>
			</div>
			<div class="row-fluid">
				<div class="span4">
					<h1>{{ Auth::user()->profile->full_name() }}</h1>
					{{ link_to_route('root', 'Go back to the map', array(), array( 'class' => 'btn btn-info' )) }}
				</div>
				<div class="span8">
					@yield('outlet')
				</div>
			</div>
			<hr />
			<div class="row-fluid">
				<div class="span12">
					<p>
						StartupMap. Made by <b>Aerolab</b>
					</p>
				</div>
			</div>
		</div>
		

		<script>var env = { endpoint: "{{ url('api') }}/" };</script>

		@foreach(array(
			asset('js/vendor/jquery-1.11.0.min.js'),
			asset('bootstrap/js/bootstrap.min.js'),
			asset('js/jquery.ui.widget.js'),
			asset('js/jquery.iframe-transport.js'),
			asset('js/jquery.fileupload.js'),
			asset('js/jquery.ui.widget.js'),
			asset('js/stupidtable.min.js'),
		) as $javascript)
		<script src="{{ $javascript }}"></script>
		@endforeach

		<script>
		$(document).ready(function(){
			$('table.sortable').stupidtable();
		})
		</script>
	</body>
</html>
<!-- Gorlomi. -->