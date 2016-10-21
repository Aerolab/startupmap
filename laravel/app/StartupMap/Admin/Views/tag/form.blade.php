@extends('admin::layout', [ 'pageTitle' => $mode == 'create' ? 'Create a tag' : 'Edit ' . $tag->tag ])

@section('content')
<div class="container">

	<h1>{{ $mode == 'create' ? 'Create a tag' : 'Edit ' . $tag->tag }}</h1>
	{{ link_to_route('tag.admin', 'Back to tags', [], [ 'class' => 'btn' ]) }}

	<hr />

	{{ Form::open([ 'route' => $mode =='create' ? 'tag.admin.create' : array_merge( array('tag.admin.edit'), $tag->routeParams()), 'method' => $mode == 'create' ? 'POST' : 'PUT', 'class' => 'form-horizontal' ]) }}

		@include('modules.alerts')

		<div class="control-group">
			<label for="tag" class="control-label">Tag</label>
			<div class="controls">
				{{ Form::text('tag', $mode == 'create' ? Input::old('tag') : $tag->tag) }}
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				{{ Form::submit($mode == 'create' ? 'Create' : 'Save', [ 'class' => 'btn btn-success' ]) }}
				@if($mode == 'edit')
				{{ link_to_route('tag.admin.destroy', 'Delete', $tag->routeParams(), [ 'class' => 'btn btn-danger' ]) }}
				@endif
				{{ Form::token() }}
			</div>
		</div>

	{{ Form::close() }}
</div>
@endsection