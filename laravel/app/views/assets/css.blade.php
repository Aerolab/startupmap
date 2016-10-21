@foreach(array(
	asset('css/style.css'),
	'//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css',
	'http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.css',
	'http://fonts.googleapis.com/css?family=Montserrat'
	) as $css)
<link rel="stylesheet" href="{{ $css }}" />
@endforeach