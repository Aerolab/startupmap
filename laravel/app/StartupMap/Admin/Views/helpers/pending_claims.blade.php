<table class="table table-hover sortable">
	<thead>
		<th>Name</th>
		<th>Startup</th>
		<th>Note</th>
		<th>Status</th>
		<th>Created at</th>
		<th width="15%" class="noSorting {sorter: false}">&nbsp;</th>
	</thead>
	<tbody>
		<?php
			$classes = array(
				'accepted' => 'success',
				'denied' => 'error',
				'pending' => 'info'
				);
		?>
		@foreach(Claim::where('flag', 'pending')->orderBy('created_at', 'desc')->get() as $claim)
		<tr class="{{ $classes[$claim->flag] }}">
			<td>{{ link_to_route('user.admin.edit', $claim->user->profile->full_name(), [ 'id' => $claim->user->id, 'name' => $claim->user->profile->full_name(true) ]) }}</td>
			<td>{{ link_to_route('startup.admin.show', $claim->startup->name, $claim->startup->routeParams()) }}</td>
			<td>{{ $claim->note }}</td>
			<td>{{ $claim->flag }}</td>
			<td>{{ $claim->created_at->diffForHumans() }}</td>
			<td>
				@if($claim->flag == 'pending')
				{{ link_to_route('claim.admin.accept', 'Accept', [ 'id' => $claim->id ]) }}
				{{ link_to_route('claim.admin.deny', 'Deny', [ 'id' => $claim->id ]) }}
				@else
				&nbsp;
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>