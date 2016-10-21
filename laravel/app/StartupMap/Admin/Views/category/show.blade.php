@extends('admin::layout', [ 'pageTitle' => $category->name ])

@section('content')
<header class="page-header">
	<div class="container">
		<div class="row-fluid">
			<div class="span8">
				<h1 style="margin:0 0 4px;padding:0;line-height:1;display:block;">{{ $category->name }}</h1>
			</div>
			<div class="span4 text-right">
				{{ HTML::decode(link_to_route('category.admin', '<i class="fa fa-arrow-left"></i> Back', [], [ 'class' => 'btn' ])) }}
				{{ HTML::decode(link_to_route('category.admin.edit', '<i class="fa fa-edit"></i> Edit', $category->routeParams(), [ 'class' => 'btn btn-info'])) }}
			</div>
		</div>
	</div>
</header>

<div class="container">
	<div class="row-fluid">
		<div class="span12">
			@include('admin::helpers.startups_by_country', array( 'startups' => $category->startups, 'category' => $category ))
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			@include('admin::startup.table', array( 'startups' => $category->startups ))
		</div>
	</div>
</div>
@endsection