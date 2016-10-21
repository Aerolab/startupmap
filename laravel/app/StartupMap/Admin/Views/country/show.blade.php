@extends('admin::layout', [ 'pageTitle' => $country->name ])

@section('content')
<header class="page-header">
	<div class="container">
		<div class="row-fluid">
			<div class="span8">
				<h1 style="margin:0 0 4px;padding:0;line-height:1;display:block;">{{ $country->name }}</h1>
			</div>
			<div class="span4 text-right">
				{{ HTML::decode(link_to_route('country.admin', '<i class="fa fa-arrow-left"></i> Back', [], [ 'class' => 'btn' ])) }}
				{{ HTML::decode(link_to_route('country.admin.update', '<i class="fa fa-pencil"></i> Toggle visibility', $country->routeParams(), [ 'class' => 'btn btn-info'])) }}
			</div>
		</div>
	</div>
</header>

<div class="container">
	<div class="row-fluid">
		<div class="span12">			
			@include('admin::helpers.startups_by_category', array( 'startups' => $country->startups, 'country' => $country ))
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			@include('admin::startup.table', array( 'startups' => $country->startups ))
		</div>
	</div>
</div>
@endsection