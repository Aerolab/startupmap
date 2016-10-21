@extends('admin::layout', [ 'pageTitle' => 'Startups' ])

@section('content')
<header class="page-header">
	<div class="container">
		<div class="row-fluid">
			<div class="span8">
				<h1>Startups</h1>
				@if(isset($country->iso))
				Currently looking at startups in <b>{{ $country->name }}</b> {{ link_to_route('startup.admin', '(List all)') }}
				@endif
			</div>
			<div class="span4 text-right" style="padding-top:10px">
				{{ HTML::decode(link_to_route('startup.admin.create', '<i class="fa fa-plus"></i> Create a startup', [], [ 'class' => 'btn btn-large btn-success' ])) }}
			</div>
		</div>
	</div>
</header>
<div class="container">
	<div class="row-fluid">
		<div class="span12">
			@include('modules.alerts')
			@include('admin::startup.table', array( 'startups' => $startups ))
		</div>
	</div>
</div>
@endsection