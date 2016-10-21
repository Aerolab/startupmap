@extends('layouts.app', [ 'pageTitle' => 'Login' ])

@section('app')
{{ Form::open([ 'route' => 'login' ]) }}
	@include('modules.alerts')
	<div>
		<label for="email">E-mail</label>
		{{ Form::text('email', Input::old('email')) }}
	</div>
	<div>
		<label for="password">Password</label>
		{{ Form::password('password') }}
	</div>
	<div>
		{{ Form::submit('Continue') }}
	</div>
	{{ Form::token() }}
{{ Form::close() }}
@endsection