@extends('manager::layout', array( 'pageTitle' => $startup->name . ' &mdash; StartupMap Manager' ))

@section('outlet')
<h2>{{ $startup->name }}</h2>
<div class="well">
	<p>
		Invite a team member to be listed in the map as part of {{ $startup->name }}.<br/>
		<em>If the person is not registed with us, an invitation e-mail will be delivered.</em>
	</p>
	{{ Form::open(array( 'route' => array_merge( array('manager.startup.member.add'), $startup->routeParams() ) )) }}
		@include('modules.alerts')
		<div class="control-group">
			<label for="email" class="control-label">E-mail address</label>
			<div class="controls">
				{{ Form::text('email', Input::old('email'), array( 'class' => 'input-block-level' )) }}
			</div>
		</div>
		<div class="control-group">
			<label for="role" class="control-label">Role</label>
			<div class="controls">
				{{ Form::text('role', Input::old('role')) }}
			</div>
		</div>
		<div class="control-group">

			<label for="admin" class="control-label">Grant manager access?</label>
			<div class="controls">
				{{ Form::select('admin', array( 'y' => 'Yes', 'n' => 'No' ), Input::old('admin', 'n')) }}
				<span class="help-block">
					This would allow the users to post job listings and manage the team aswell.
				</span>
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				{{ Form::button('Invite', array( 'type' => 'submit', 'class' => 'btn btn-primary' )) }}
			</div>
		</div>
		{{ Form::token() }}
	{{ Form::close() }}
</div>
<hr />
<h3>Current team</h3>
@foreach($startup->team as $member)
<div class="media">
	<img src="{{ $member->user->profile->picture() }}" alt="{{ $member->user->profile->full_name() }}" class="media-object pull-left" />
	<div class="media-body">
		<h3 class="media-heading">{{ $member->user->profile->full_name() }}</h3>
		<p>{{ $member->role->name }}</p>
	</div>
</div>
@endforeach
@stop