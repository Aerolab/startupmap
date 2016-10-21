@extends('admin::layout', [ 'pageTitle' => $tag->tag ])

@section('content')
<header class="page-header">
	<div class="container">
		<div class="row-fluid">
			<div class="span8">
				<h1>{{ link_to_route('tag.admin.show', $tag->tag, $tag->routeParams()) }}</h1>
			</div>
			<div class="span4 text-right" style="padding-top:10px">
				{{ HTML::decode(link_to_route('tag.admin', '<i class="fa fa-arrow-left"></i> Back', [], [ 'class' => 'btn' ])) }}
				{{ HTML::decode(link_to_route('tag.admin.edit', '<i class="fa fa-edit"></i> Edit', $tag->routeParams(), [ 'class' => 'btn btn-info'])) }}
				{{ HTML::decode(link_to_route('tag.admin.destroy', '<i class="fa fa-times"></i> Delete', $tag->routeParams(), [ 'class' => 'btn btn-danger'])) }}
			</div>
		</div>
	</div>
</header>
<div class="container">	
	@include('admin::helpers.startups_by_tag_and_country', array('startups' => $tag->startups()))
	@include('admin::helpers.startups_by_category', array('startups' => $tag->startups()))
	@include('admin::startup.table', array('startups' => $tag->startups()))
</div>
@endsection