@extends('manager::layout', array( 'pageTitle' => 'Manager' ))

@section('outlet')
<h2>Startups you're involved in...</h2>
<table class="table">
	<tbody>
		@foreach($user->startups as $startupMember)
		<tr>
			<td>{{ link_to_route('manager.startup.index', $startupMember->startup->name, $startupMember->startup->routeParams()) }}</td>
		</tr>
		@endforeach
	</tbody>
</table>	
@stop