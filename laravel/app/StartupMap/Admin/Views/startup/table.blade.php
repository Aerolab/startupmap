@if($startups->count() != 0)
<table class="table table-hover sortable">
	<thead>
		<th data-sort="int">#</th>
		<th data-sort="string">Name</th>
		<th data-sort="string">Country</th>
		<th data-sort="string">Category</th>
		<th data-sort="string">Approved</th>
		<th data-sort="int">Created</th>
		<th width="6%">&nbsp;</th>
	</thead>
	<tbody>
		@foreach($startups as $startup)
		@if($startup->approved != 'n')
		<tr>
		@else
		<tr class="warning">
		@endif
			<td>{{ $startup->id }}</td>
			<td>
				<b>{{ link_to_route('startup.admin.show', $startup->name, $startup->routeParams()) }}</b>
				@if($startup->child_of != 0 && isset($startup->parent))
				<br/>This is part of {{ $startup->parent->name }}
				@endif
			</td>
			<td>
				{{ link_to_route('startup.admin', $startup->country->name, array( 'country' => $startup->country->iso ))}}
			</td>
			@if($startup->category_id != 0)
			<td>{{ link_to_route('category.admin.show', $startup->category->name, $startup->category->routeParams()) }}</td>
			@else
			<td>Sin categoria</td>
			@endif
			<td>{{ $startup->approved }}</td>
			<td data-sort-value="{{ $startup->created_at->timestamp }}">{{ $startup->created_at->diffForHumans() }}</td>
			<td>
				<div class="btn-group">
					<a href="#" class="btn btn-small dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-cog"></i>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>{{ HTML::decode(link_to_route('startup.admin.show', '<i class="fa fa-eye"></i> View', $startup->routeParams())) }}</li>
						<li>{{ HTML::decode(link_to_route('startup.admin.edit', '<i class="fa fa-edit"></i> Edit', $startup->routeParams())) }}</li>
						<li>{{ HTML::decode(link_to_route('startup.admin.destroy', '<i class="fa fa-times"></i> Delete', $startup->routeParams(), array( 'class' => 'confirmed-link' ))) }}</li>
					</ul>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@else
<div class="well text-center alert-info">
	<h1><i class="fa fa-frown-o"></i></h1>
	<p>There's no startups to be shown.</p>
</div>
@endif