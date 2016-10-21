@extends('admin::layout', [ 'pageTitle' => $mode == 'create' ? 'Create a category' : 'Edit ' . $category->name ])

@section('content')
<div class="container">

	<h1>{{ $mode == 'create' ? 'Create a category' : 'Edit ' . $category->name }}</h1>
	{{ link_to_route('category.admin', 'Back to categories', [], [ 'class' => 'btn' ]) }}

	<hr />

	{{ Form::open([ 'route' => $mode =='create' ? 'category.admin.create' : [ 'category.admin.edit', $category->id, $category->slug() ], 'method' => $mode == 'create' ? 'POST' : 'PUT', 'class' => 'form-horizontal' ]) }}

		@include('modules.alerts')

		<div class="control-group">
			<label for="name" class="control-label">Name</label>
			<div class="controls">
				{{ Form::text('name', $mode == 'create' ? Input::old('name') : $category->name) }}
			</div>
		</div>

		<div class="control-group">
			<label for="order" class="control-label">Orden</label>
			<div class="controls">
				{{ Form::text('order', $mode == 'create' ? Input::old('order', 0) : $category->order) }}
			</div>
		</div>

		<div class="control-group">
			<label for="visible" class="control-label">Visible</label>
			<div class="controls">
				{{ Form::select('visible', [ 'y' => 'Yes', 'n' => 'No' ], $mode == 'create' ? Input::old('visible') : $category->visible) }}
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				{{ Form::submit($mode == 'create' ? 'Create' : 'Save', [ 'class' => 'btn btn-success' ]) }}
				@if($mode == 'edit')
				{{ link_to_route('category.admin.delete', 'Delete', [ 'id' => $category->id, 'name' => $category->slug() ], [ 'class' => 'btn btn-danger' ]) }}
				@endif
				{{ Form::token() }}
			</div>
		</div>

	{{ Form::close() }}
</div>
@endsection