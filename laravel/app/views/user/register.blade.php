@extends('layouts.app', [ 'pageTitle' => 'Create a profile' ])

@section('app')
{{ Form::open([ 'route' => 'register' ]) }}
	@include('modules.alerts')
	<div>
		<label for="name">Name</label>
		{{ Form::text('name', Input::old('name')) }}
	</div>
	<div>
		<label for="last_name">Last name</label>
		{{ Form::text('last_name', Input::old('last_name')) }}
	</div>
	<div>
		<label for="email">E-mail</label>
		{{ Form::text('email', Input::old('email')) }}
	</div>
	<div>
		<label for="password">Password</label>
		{{ Form::password('password') }}
	</div>
	<div>
		<label for="password_confirmation">Confirm password</label>
		{{ Form::password('password_confirmation') }}
	</div>
	<div>
		{{ Form::submit('Continue') }}
	</div>
	{{ Form::token() }}
{{ Form::close() }}
@endsection