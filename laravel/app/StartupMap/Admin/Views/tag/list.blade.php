@extends('admin::layout', [ 'pageTitle' => 'Tags' ])

@section('content')
<header class="page-header">
	<div class="container">
		<div class="row-fluid">
			<div class="span8">
				<h1>Tags</h1>
			</div>
			<div class="span4 text-right" style="padding-top:10px">
				{{ HTML::decode(link_to_route('tag.admin.create', '<i class="fa fa-plus"></i> Create a tag', [], [ 'class' => 'btn btn-large btn-success' ])) }}
			</div>
		</div>
	</div>
</header>
<div class="container">
	@include('modules.alerts')
	<table class="table table-hover sortable">
		<thead>
			<th>#</th>
			<th data-sort="string">Name</th>
			<th data-sort="int">Startups</th>
			<th width="6%">&nbsp;</th>
		</thead>
		<tbody>
			@foreach($tags as $tag)
			<tr>
				<td>{{ $tag->id }}</td>
				<td>{{ link_to_route('tag.admin.show', $tag->tag, $tag->routeParams()) }}</td>
				<td>{{ link_to_route('tag.admin.show', count($tag->startups()), $tag->routeParams()) }}</td>
				<td>
					<div class="btn-group">
						<a href="#" class="btn btn-small dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li>{{ HTML::decode(link_to_route('tag.admin.show', '<i class="fa fa-eye"></i> View', $tag->routeParams())) }}</li>
							<li>{{ HTML::decode(link_to_route('tag.admin.edit', '<i class="fa fa-edit"></i> Edit', $tag->routeParams())) }}</li>
							<li>{{ HTML::decode(link_to_route('tag.admin.destroy', '<i class="fa fa-times"></i> Delete', $tag->routeParams(), array( 'class' => 'confirmed-link' ))) }}</li>
						</ul>
					</div>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@include('admin::helpers.startups_by_tag', array('tags' => $tags))
</div>
@endsection