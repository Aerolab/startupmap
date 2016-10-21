@extends('admin::layout', array( 'pageTitle' => 'Admin dashboard' ))

@section('content')
<header class="page-header">
	<div class="container">
		<div class="row-fluid">
			<div class="span12">
				<h1>Hello {{ Auth::user()->profile->name }}!</h1>				
			</div>
		</div>
	</div>
</header>

<div class="container">
	<?php $pendingClaims = Claim::where('flag', 'pending')->get()->count(); ?>


	@include('admin::helpers.startups_piechart')
	
	<hr/>

	<div class="row-fluid">
		<div class="span4">
			<h3>Recent startups</h3>
			<ul class="unstyled">
			@foreach(Startup::orderBy('created_at', 'desc')->take(10)->get() as $startup)
				<li>{{ link_to_route('startup.admin.show', $startup->name, $startup->routeParams()) }} <em class="muted">Created {{ $startup->created_at->diffForHumans() }}</em></li>
			@endforeach
			</ul>
		</div>
		<div class="span4">
			<h3>Recent users</h3>
			<ul class="unstyled">
			@foreach(User::orderBy('created_at', 'desc')->take(10)->get() as $user)
				@if($user->profile)
				<li>{{ link_to_route('user.admin.edit', $user->profile->full_name(), $user->routeParams()) }} <em class="muted">Created {{ $user->created_at->diffForHumans() }}</em></li>
				@endif
			@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection