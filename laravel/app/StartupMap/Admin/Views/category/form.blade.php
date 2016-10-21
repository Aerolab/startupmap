@extends('admin::layout', [ 'pageTitle' => $mode == 'create' ? 'Create a category' : 'Edit ' . $category->name ])

@section('content')
<header class="page-header">
	<div class="container">
		<div class="row-fluid">
			<div class="span8">
				<h1>{{ $mode == 'create' ? 'Create a category' : 'Edit ' . link_to_route('category.admin.show', $category->name, $category->routeParams()) }}</h1>
			</div>
			<div class="span4 text-right" style="padding-top:10px">
				{{ HTML::decode(link_to_route('category.admin', '<i class="fa fa-arrow-left"></i> Back to categories', [], [ 'class' => 'btn' ])) }}
			</div>
		</div>
	</div>
</header>
<div class="container">
	{{ Form::open([ 'route' => $mode =='create' ? 'category.admin.create' : array_merge( array('category.admin.edit'), $category->routeParams() ), 'method' => $mode == 'create' ? 'POST' : 'PUT', 'class' => 'form-horizontal' ]) }}

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
				{{ HTML::decode(Form::button($mode == 'create' ? '<i class="fa fa-save"></i> Create' : '<i class="fa fa-save"></i> Save', [ 'class' => 'btn btn-primary btn-large', 'type' => 'submit' ])) }}
				@if($mode == 'edit')
				{{ HTML::decode(link_to('#deleteModal', '<i class="fa fa-times"></i> Delete', array( 'data-toggle' => 'modal', 'class' => 'btn btn-danger btn-large' ))) }}
				@endif
				{{ Form::token() }}
			</div>
		</div>

	{{ Form::close() }}
</div>

@if($mode != 'create')
<div id="deleteModal" class="modal hide fade">
	<div class="modal-body">
		<p>
			<b>Are you sure you want to delete {{ $category->name }}?</b>
		</p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		{{ link_to_route('category.admin.destroy', 'Delete this category', $category->routeParams(), [ 'class' => 'btn btn-danger']) }}
	</div>
</div>
@endif
@endsection