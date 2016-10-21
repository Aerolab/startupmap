<script id="startupTemplate" type="x-tmpl-mustache">
	<div class="startupView scrollable" data-id="startup-[[options.id]]">

		<a href="#closeStartup" class="close"><i class="fa fa-times"></i></a>

		<div class="photoSlider">
			[[#options.data.banner]]<img src="[[options.data.banner.full]]" height="180" width="370">[[/options.data.banner]]
			[[^options.data.banner]]<img src="http://placehold.it/370x180">[[/options.data.banner]]
		</div>
		<div class="info clearfix">
			[[#options.data.logo]]<img src="[[options.data.logo.thumb]]" height="92" width="92" alt="[[options.name]]">[[/options.data.logo]]
			[[^options.data.logo]]<img src="{{asset('images/logo_null.png')}}" alt="[[options.name]]">[[/options.data.logo]]
			<h2>[[options.data.name]]</h2>
			[[#options.data.slogan]]<h3>[[options.data.slogan]]</h3>[[/options.data.slogan]]
		</div> 
		<div class="location">
			<p><i class="fa fa-location-arrow"></i> [[options.data.address]]</p>
		</div>
		[[#options.data.social]]
		<div class="social">
		
			[[#options.data.website]]
			<a href="[[options.data.website]]"  target="_blank" class="fa-stack fa-lg">
			  <i class="fa fa-circle fa-stack-2x"></i>
			  <i class="fa fa-globe fa-stack-1x fa-inverse"></i>
			</a>
			[[/options.data.website]]
		
			[[#options.data.facebook]]
			<a href="[[options.data.facebook]]"  target="_blank" class="fa-stack fa-lg c-facebook">
			  <i class="fa fa-circle fa-stack-2x"></i>
			  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
			</a>
			[[/options.data.facebook]]

			[[#options.data.twitter]]
			<a href="[[options.data.twitter]]"  target="_blank" class="fa-stack fa-lg c-twitter">
			  <i class="fa fa-circle fa-stack-2x"></i>
			  <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
			</a>
			[[/options.data.twitter]]

			[[#options.data.linkedin]]
			<a href="[[options.data.linkedin]]"  target="_blank" class="fa-stack fa-lg c-linkedin">
			  <i class="fa fa-circle fa-stack-2x"></i>
			  <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
			</a>
			[[/options.data.linkedin]]

			[[#options.data.crunchbase]]
			<a href="[[options.data.crunchbase]]"  target="_blank" class="fa-stack fa-lg">
			  <i class="fa fa-circle fa-stack-2x"></i>
			  <i class="icon-crunch fa-stack-1x fa-inverse"></i>
			</a>
			[[/options.data.crunchbase]]

			[[#options.data.angelist]]
			<a href="[[options.data.angelist]]"  target="_blank" class="fa-stack fa-lg">
			  <i class="fa fa-circle fa-stack-2x"></i>
			  <i class="icon-angel fa-stack-1x fa-inverse"></i>
			</a>
			[[/options.data.angelist]]

			[[#options.data.dribbble]]
			<a href="[[options.data.dribbble]]"  target="_blank" class="fa-stack fa-lg c-dribbble">
			  <i class="fa fa-circle fa-stack-2x"></i>
			  <i class="fa fa-dribbble fa-stack-1x fa-inverse"></i>
			</a>
			[[/options.data.dribbble]]

			[[#options.data.google_plus]]
			<a href="[[options.data.google_plus]]"  target="_blank" class="fa-stack fa-lg c-google-plus">
			  <i class="fa fa-circle fa-stack-2x"></i>
			  <i class="fa fa-google-plus fa-stack-1x fa-inverse"></i>
			</a>
			[[/options.data.google_plus]]

			[[#options.data.foursquare]]
			<a href="[[options.data.foursquare]]"  target="_blank" class="fa-stack fa-lg c-foursquare">
			  <i class="fa fa-circle fa-stack-2x"></i>
			  <i class="fa fa-foursquare fa-stack-1x fa-inverse"></i>
			</a>
			[[/options.data.foursquare]]

			[[#options.data.youtube]]
			<a href="[[options.data.youtube]]"  target="_blank" class="fa-stack fa-lg c-youtube">
			  <i class="fa fa-circle fa-stack-2x"></i>
			  <i class="fa fa-youtube fa-stack-1x fa-inverse"></i>
			</a>
			[[/options.data.youtube]]

		</div>
		[[/options.data.social]]
		<div class="description">
			<p>[[options.data.description]]</p>
			
		</div>
		<input type="hidden" id="currentStartupView" value="[[options.id]]" />

		<div class="footer">
			<a href="#" id="startupClaim"><i class="fa fa-flag"></i> Soy founder</a>
			<div class="claimForm">
				<input type="text" name="note" id="claimNote" placeholder="Motivo" value="">
				<a href="#" class="btn app" data-app-route="startup.claim" id="btnClaim">
					<span class="processing"><i class="fa fa-spinner fa-spin"></i></span>				
					<span class="normal">Enviar pedido</span>
				</a>
			</div>
		</div>
		<div class="footer">
			<a href="#edit" data-id="[[options.id]]"><i class="fa fa-pencil"></i> Editar Item</a>
		</div>
	</div>
</script>