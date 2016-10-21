@extends('admin::layout', [ 'pageTitle' => 'Users' ])

@section('content')
<header class="page-header">
	<div class="container">
		<div class="row-fluid">
			<div class="span8">
				<h1>Users</h1>
			</div>
			<div class="span4 text-right" style="padding-top:10px">
				{{ HTML::decode(link_to_route('user.admin.create', '<i class="fa fa-plus"></i> Create an user', [], [ 'class' => 'btn btn-success btn-large' ])) }}
			</div>
		</div>
	</div>
</header>

<div class="container">
	@include('modules.alerts')
	<div class="alert alert-warning">
		Highlighted users have not yet validated their accounts.
	</div>
	<table class="table table-hover sortable">
		<thead>
			<th data-sort="int">#</th>
			<th data-sort="string">Name</th>
			<th data-sort="string">Email</th>
			<th data-sort="int">Joined</th>
			<th width="6%">&nbsp;</th>
		</thead>
		<tbody>
			@foreach($users as $user)
				@if($user->profile)
				@if($user->validated_at == '0000-00-00 00:00:00')
				<tr class="warning">
				@else
				<tr>
				@endif
					<td>{{ $user->id }}</td>
					<td>{{ $user->profile->full_name() }}</td>
					<td>{{ $user->email }}</td>
					<td data-sort-value="{{ $user->created_at->timestamp }}">{{ $user->created_at->diffForHumans() }}</td>
					<td>
						<div class="btn-group">
							<a href="#" class="btn btn-small dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-cog"></i>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li>{{ HTML::decode(link_to_route('user.admin.edit', '<i class="fa fa-edit"></i> Edit', $user->routeParams())) }}</li>
								<li>{{ HTML::decode(link_to_route('user.admin.destroy', '<i class="fa fa-times"></i> Delete', $user->routeParams(), array( 'class' => 'confirmed-link' ))) }}</li>
							</ul>
						</div>
					</td>
				</tr>
				@endif
			@endforeach
		</tbody>
	</table>
</div>
@endsection