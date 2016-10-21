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

		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					{{ link_to_route('admin.dashboard', 'StartupMap', array(), array( 'class' => 'brand' )) }}
					<div class="nav-collapse collapse">
						<ul class="nav">
							<li>{{ link_to_route('admin.dashboard', 'Dashboard') }}</li>
							<li>{{ link_to_route('user.admin', 'Users') }}</li>
							<li>{{ link_to_route('startup.admin', 'Startups') }}</li>
							<li>{{ link_to_route('claim.admin', 'Claims (' . Claim::where('flag', 'pending')->get()->count() . ')') }}</li>
							<li>{{ link_to_route('category.admin', 'Categories') }}</li>
							<li>{{ link_to_route('tag.admin', 'Tags') }}</li>
							<li>{{ link_to_route('country.admin', 'Countries') }}</li>
						</ul>
						<ul class="nav pull-right">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->profile->full_name() }} <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li>{{ link_to_route('api.logout', 'Cerrar sesi&oacute;n') }}</li>
								</ul>
							</li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

		@yield('content')

		<footer>
			<div class="container">
				<div class="row-fluid">
					<div class="span10">
						<p><b>StartupMap</b> &mdash; Made by Aerolab</p>
					</div>
					<div class="span2 text-right">
						<a href="#" class="btn btn-small"><i class="fa fa-arrow-up"></i> Back to top</a>
					</div>
				</div>
			</div>
		</footer>
		

		<script>var env = { endpoint: "{{ url('api') }}/" };</script>

		@foreach(array(
			asset('js/vendor/jquery-1.11.0.min.js'),
			asset('bootstrap/js/bootstrap.min.js'),
			asset('js/jquery.ui.widget.js'),
			asset('js/jquery.iframe-transport.js'),
			asset('js/jquery.fileupload.js'),
			asset('js/jquery.ui.widget.js'),
			asset('js/stupidtable.min.js'),
			asset('js/admin/app.js'),
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