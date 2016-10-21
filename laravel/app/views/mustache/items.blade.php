<script id="itemsTemplate" type="x-tmpl-mustache">
	<div data-category="[[id]]">
		<div class="results">Resultados <span>[[amount]]</span></div>
		<ul class="styleList scrollable">
		[[#items]]
			<li><a href="/[[options.data.country_slug]]/[[options.category_slug]]/[[options.id]]/[[options.slug]]" data-id="[[options.id]]">[[options.name]]</a></li>
		[[/items]]
		</ul>
		<ul class="styleThumb scrollable">
		[[#items]]
			<li><a href="/[[options.data.country_slug]]/[[options.category_slug]]/[[options.id]]/[[options.slug]]" data-id="[[options.id]]">[[#options.data.logo]]<img src="[[options.data.logo.thumb]]" height="89" width="89" alt="[[options.name]]">[[/options.data.logo]][[^options.data.logo]]<img src="{{asset('images/logo_null.png')}}" height="89" width="89" alt="[[options.name]]">[[/options.data.logo]]</a></li>
		[[/items]]
		</ul>
	</div>
</script>