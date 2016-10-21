@extends('admin::layout', [ 'pageTitle' => $category->name ])

@section('content')
<div class="container">

	<h1>{{ $category->name }}</h1>
	{{ link_to_route('category.admin', 'Back to categories', [], [ 'class' => 'btn' ]) }}

	<hr />

	{{ link_to_route('category.admin.edit', 'Edit', [ 'id' => $category->id, 'name' => $category->slug() ], [ 'class' => 'btn btn-info' ]) }}
	{{ link_to_route('category.admin.de', 'Delete', [ 'id' => $category->id, 'name' => $category->slug() ], [ 'class' => 'btn btn-danger' ]) }}

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
					{{ link_to_route('startup.admin.show', 'View', [ 'id' => $startup->id, 'name' => $startup->slug() ]) }}
					{{ link_to_route('startup.admin.edit', 'Edit', [ 'id' => $startup->id, 'name' => $startup->slug() ]) }}
					{{ link_to_route('startup.admin.destroy', 'Delete', [ 'id' => $startup->id, 'name' => $startup->slug() ]) }}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	
</div>

@if($mode != 'create')
<div id="deleteModal" class="modal hide fade">
	<div class="modal-body">
		<p>
			<b>Are you sure you want to delete {{ $user->profile->full_name() }}?</b>
		</p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		{{ link_to_route('user.admin.destroy', 'Delete this user', $user->routeParams(), [ 'class' => 'btn btn-danger']) }}
	</div>
</div>
@endif
@endsection