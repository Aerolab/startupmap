@extends('admin::layout', [ 'pageTitle' => $category->name ])

@section('content')
<div class="container">

	<h1>{{ $category->name }}</h1>
	{{ link_to_route('category.admin', 'Back to categories', [], [ 'class' => 'btn' ]) }}

	<hr />

	{{ link_to_route('category.admin.edit', 'Edit', [ 'id' => $category->id, 'name' => $category->slug() ], [ 'class' => 'btn btn-info' ]) }}
	{{ link_to_route('category.admin.delete', 'Delete', [ 'id' => $category->id, 'name' => $category->slug() ], [ 'class' => 'btn btn-danger' ]) }}

	<hr />

	<h3>Startups under this category</h3>

	<table class="table table-hover">
		<thead>
			<th width="2%">#</th>
			<th>Name</th>
			<th width="10%">&nbsp;</th>
		</thead>
		<tbody>
			@foreach($category->startups as $startup)
			<tr>
				<td>{{ $startup->id }}</td>
				<td>
					<b>{{ $startup->name }}</b>
					@if($startup->child_of != 0)
					<br/>This is part of {{ $startup->parent->name }}
					@endif
				</td>
				<td>
					{{ link_to_route('startup.admin.view', 'View', [ 'id' => $startup->id, 'name' => $startup->slug() ]) }}
					{{ link_to_route('startup.admin.edit', 'Edit', [ 'id' => $startup->id, 'name' => $startup->slug() ]) }}
					{{ link_to_route('startup.admin.delete', 'Delete', [ 'id' => $startup->id, 'name' => $startup->slug() ]) }}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	
</div>
@endsection