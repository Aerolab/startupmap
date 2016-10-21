@extends('admin::layout', [ 'pageTitle' => 'Countries' ])

@section('content')
<header class="page-header">
	<div class="container">
		<div class="row-fluid">
			<div class="span8">
				<h1>Countries</h1>
			</div>
		</div>
	</div>
</header>
<div class="container">
	<div class="row-fluid">
		<div class="span12">
			@include('modules.alerts')
			<div class="alert alert-info">
				Countries highlighted in blue are enabled for users.
			</div>
			<table class="table table-hover sortable">
				<thead>
					<th data-sort="string">ISO</th>
					<th data-sort="string">Name</th>
					<th data-sort="string">Startups</th>
					<th data-sort="string">Enabled</th>
					<th width="6%">&nbsp;</th>
				</thead>
				<tbody>
					@foreach($countries as $country)
					@if($country->enabled == 'n')
					<tr>
					@else
					<tr class="info">
					@endif
						<td>{{ $country->iso }}</td>
						<td>{{ link_to_route('country.admin.show', $country->name, $country->routeParams()) }}</td>
						<td>{{ link_to_route('country.admin.show', $country->startups()->count(), $country->routeParams()) }}</td>
						<td>{{ $country->enabled }}</td>
						<td>
							<div class="btn-group">
								<a href="#" class="btn btn-small dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-cog"></i>
									<span class="caret"></span>
								</a>
								<ul class="dropdown-menu">
									<li>{{ HTML::decode(link_to_route('country.admin.show', '<i class="fa fa-eye"></i> View', $country->routeParams())) }}</li>
									<li>{{ HTML::decode(link_to_route('country.admin.update', '<i class="fa fa-flag"></i> Toggle visibility', $country->routeParams())) }}</li>
								</ul>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection