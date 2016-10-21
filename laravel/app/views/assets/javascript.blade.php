<script>var env = { countryList: {{ json_encode($countryList) }}, country: {{ json_encode($country) }}, startup: {{ $startupID }}, startupData: {{ json_encode($startupData) }}, user: {{ Auth::check() ? json_encode(Auth::user()->toArray()) : '{}' }}, endpoint: "{{ url('api') }}/" };</script>

<!-- @foreach(array(
	asset('js/vendor/modernizr-2.6.2.min.js'), '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js',
	'http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places',
	'http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.js',
	asset('js/leaflet.markercluster.js'),
	asset('js/leaflet.awesome-markers.js'),
	asset('js/plugins.js'),
	asset('js/jquery.ui.widget.js'),
	asset('js/jquery.iframe-transport.js'),
	asset('js/jquery.fileupload.js'),
	asset('js/jquery.ui.widget.js'),
	asset('js/helpers.js?002'),
	asset('js/app.js?002'),
	asset('js/uservoice.js'),
) as $javascript)
<script src="{{ $javascript }}"></script>
@endforeach -->
@foreach(array(
	asset('js/vendor/modernizr-2.6.2.min.js'), '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js',
	'http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places',
	'http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.js',
	asset('js/leaflet.markercluster.js'),
	asset('js/leaflet.awesome-markers.js'),
	asset('js/min/plugins-ck.js'),
	asset('js/min/helpers-ck.js?004'),
	asset('js/min/app-ck.js?004'),
	asset('js/uservoice.js'),
) as $javascript)
<script src="{{ $javascript }}"></script>
@endforeach

<div id="fb-root"></div>


<script>
	// Load FB and Twitter after everything else
	
	$(window).load(function(){
		// FB
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&appId=180726452116317&version=v2.0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

		// Twitter
		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
	});
</script>
