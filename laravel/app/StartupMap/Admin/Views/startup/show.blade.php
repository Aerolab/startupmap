@extends('admin::layout', [ 'pageTitle' => $startup->name ])

@section('content')
<div id="map-canvas" style="height:350px;margin: 0 0 20px;"></div>
<div class="container">

	<div class="row-fluid">
		<div class="span1">
			<img src="{{ asset('uploads/thumb_' . $startup->logo) }}" />
		</div>
		<div class="span7">
			<h1 style="margin:0 0 4px;padding:0;line-height:1;display:block;">{{ $startup->name }}</h1>
			@if($startup->slogan != '')
			<em class="muted">{{ $startup->slogan }}</em>
			@endif
		</div>
		<div class="span4 text-right">
			{{ HTML::decode(link_to_route('startup.admin', '<i class="fa fa-arrow-left"></i> Back', [], [ 'class' => 'btn' ])) }}
			{{ HTML::decode(link_to_route('startup.admin.edit', '<i class="fa fa-pencil"></i> Edit', [ 'id' => $startup->id, 'name' => $startup->slug() ], [ 'class' => 'btn btn-info'])) }}
			{{ HTML::decode(link_to('#deleteModal', '<i class="fa fa-times"></i> Delete', array( 'data-toggle' => 'modal', 'class' => 'btn btn-danger' ))) }}
		</div>
	</div>

	<hr/>

	<div class="row-fluid">
		<div class="span2">
			<ul class="unstyled">
			<?php
				$socialFieldList = array(
					'website'		=>	array( 'Website', 'fa-globe' ),
					'facebook'		=>	array( 'Facebook', 'fa-facebook' ),
					'twitter'		=>	array( 'Twitter', 'fa-twitter' ),
					'linkedin'		=>	array( 'LinkedIn', 'fa-linkedin' ),
					'crunchbase'	=>	array( 'Crunchbase', 'fa-list' ),
					'angelist'		=>	array( 'Angel List', 'fa-list' ),
					'dribbble'		=>	array( 'Dribbble', 'fa-dribbble' ),
					'google_plus'	=>	array( 'Google+', 'fa-google-plus' ),
					'foursquare'	=>	array( 'Foursquare', 'fa-foursquare' ),
					'youtube'		=>	array( 'Youtube', 'fa-youtube' ),
					);
			?>

			@foreach($socialFieldList as $key => $social)
				@if($startup->$key != '')
				<li>{{ HTML::decode(link_to($startup->$key, '<i class="fa ' . $social[1] . '"></i> ' . $social[0])) }}</li>
				@endif
			@endforeach
			</ul>
		</div>
		<div class="span8">
			@if($startup->child_of != 0)
			<div class="alert alert-info">
				This startups is part of <b>{{ link_to_route('startup.admin.show', $startup->parent->name, $startup->parent->routeParams()) }}</li></b>
			</div>
			@endif

			<div class="row-fluid">
				<div class="span5">
					<img src="{{ asset('uploads/' . $startup->banner) }}" />
				</div>
				<div class="span7">
					<p>{{ $startup->description }}</p>
				</div>
			</div>
		</div>
		<div class="span2">
			<h3 style="padding:0;margin:0 0 15px;line-height:1;">Tags</h3>
			<ul class="unstyled">
			@foreach($startup->tagList as $startup_tag)
				@if($startup_tag->tag)
					<li>{{ link_to_route('tag.admin.show', $startup_tag->tag->tag, $startup_tag->tag->routeParams()) }}</li>
				@endif
			@endforeach
			</ul>
		</div>
	</div>

</div>


<script type="text/javascript">
function initialize() {
	var myLatlng = new google.maps.LatLng({{ $startup->lat }}, {{ $startup->lon }});

	var mapOptions = {
		zoom: 16,
		center: myLatlng,
		scrollwheel: false,
		navigationControl: false,
		mapTypeControl: false,
		scaleControl: false,
		draggable: false
	}

	var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

	var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
	});

	var contentString = [
		'<div class="mapMarker">',
			'<p class="text-center">{{ $startup->address }}, {{ $startup->city }}, {{ $startup->country->name }}</p>',
		'</div>'
	].join('');

	var infowindow = new google.maps.InfoWindow({
		content: contentString
	});

      infowindow.open(map,marker);
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div id="deleteModal" class="modal hide fade">
	<div class="modal-body">
		<p>
			<b>Are you sure you want to delete {{ $startup->name }}? This will also remove all content related to it, such as job postings or team members.</b>
		</p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		{{ link_to_route('startup.admin.destroy', 'Delete this startup', $startup->routeParams(), [ 'class' => 'btn btn-danger']) }}
	</div>
</div>
@endsection