@extends('admin::layout', [ 'pageTitle' => $mode == 'create' ? 'Create an user' : 'Edit ' . $user->profile->full_name() ])

@section('content')
<header class="page-header">
	<div class="container">
		<div class="row-fluid">
			<div class="span8">
				<h1>{{ $mode == 'create' ? 'Create an user' : 'Edit ' . $user->profile->full_name() }}</h1>
			</div>
			<div class="span4 text-right" style="padding-top:10px">
				{{ HTML::decode(link_to_route('user.admin', '<i class="fa fa-arrow-left"></i> Back to users', [], [ 'class' => 'btn' ])) }}
			</div>
		</div>
	</div>
</header>
<div class="container">
	{{ Form::open([ 'route' => $mode =='create' ? 'user.admin.create' : [ 'user.admin.edit', $user->id, $user->profile->full_name(true) ], 'method' => $mode == 'create' ? 'POST' : 'PUT', 'class' => 'form-horizontal' ]) }}

		@include('modules.alerts')

		<div class="control-group">
			<label for="email" class="control-label">E-mail</label>
			<div class="controls">
				{{ Form::text('email', $mode == 'create' ? Input::old('email') : $user->email, array( $mode == 'create' ? '' : 'disabled' )) }}
				@if($mode == 'create')
				<span class="help-block">
					A password will be generated randomly and delivered to the e-mail address.
				</span>
				@endif
			</div>
		</div>

		<div class="control-group">
			<label for="name" class="control-label">Name</label>
			<div class="controls">
				{{ Form::text('name', $mode == 'create' ? Input::old('name') : $user->profile->name) }}
			</div>
		</div>

		<div class="control-group">
			<label for="last_name" class="control-label">Last name</label>
			<div class="controls">
				{{ Form::text('last_name', $mode == 'create' ? Input::old('last_name') : $user->profile->last_name) }}
			</div>
		</div>

		@if($mode != 'create')
		<div class="control-group">
			<label for="send_password" class="control-label">Send password recovery</label>
			<div class="controls">
				{{ Form::select('send_password', array(
					'y'	=>	'Yeah',
					'n'	=>	'Nope'
				), Input::old('send_password', 'n')) }}
				<span class="help-block">
					This will deliver a password recovery e-mail to <b>{{ $user->email }}</b>
				</span>
			</div>
		</div>
		@endif

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