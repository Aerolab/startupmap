@extends('admin::layout', [ 'pageTitle' => 'Categories' ])

@section('content')
<header class="page-header">
	<div class="container">
		<div class="row-fluid">
			<div class="span8">
				<h1>Categories</h1>
			</div>
			<div class="span4 text-right" style="padding-top:10px">
				{{ HTML::decode(link_to_route('category.admin.create', '<i class="fa fa-plus"></i> Create a category', [], [ 'class' => 'btn btn-large btn-success' ])) }}
			</div>
		</div>
	</div>
</header>
<div class="container">
	@include('modules.alerts')
	<table class="table table-hover sortable">
		<thead>
			<th width="5%" data-sort="int">#</th>
			<th data-sort="string">Name</th>
			<th data-sort="int">Startups</th>
			<th width="6%">&nbsp;</th>
		</thead>
		<tbody>
			@foreach($categories as $category)
			<tr>
				<td>{{ $category->id }}</td>
				<td>
					{{ link_to_route('category.admin.show', $category->name, $category->routeParams()) }}
					@if($category->visible == 'n')
					<em>(Hidden)</em>
					@endif
				</td>
				<td>{{ link_to_route('category.admin.show', $category->startups()->count(), $category->routeParams()) }}</td>
				<td>
					<div class="btn-group">
						<a href="#" class="btn btn-small dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li>{{ HTML::decode(link_to_route('category.admin.show', '<i class="fa fa-eye"></i> View', $category->routeParams())) }}</li>
							<li>{{ HTML::decode(link_to_route('category.admin.edit', '<i class="fa fa-edit"></i> Edit', $category->routeParams())) }}</li>
							<li>{{ HTML::decode(link_to_route('category.admin.destroy', '<i class="fa fa-times"></i> Delete', $category->routeParams(), array( 'class' => 'confirmed-link' ))) }}</li>
						</ul>
					</div>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection