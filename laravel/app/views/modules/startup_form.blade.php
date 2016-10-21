

<div id="addStartup" data-action="add" class="startupView scrollable sidebarPanel">
	<div class="success" id="startupCreateSuccess">
		<div class="icon">
			<span class="fa-stack fa-lg">
			  <i class="fa fa-circle fa-stack-2x"></i>
			  <i class="fa fa-thumbs-o-up fa-stack-1x"></i>
			</span>
		</div>
		<h3>¡Enhorabuena!</h3>
		<div class="add-only">
			<p><strong>Ya agregamos tu startup a nuestro mapa</strong></p>
			<p>Gracias por tu tiempo, no te olvides de ayudarno a difundir :D</p>
		</div>
		<div class="edit-only">
			<p><strong>Gracias por ayudarnos a mejorar el mapa!</strong></p>			
			<p>Tus cambios ya se pueden ver reflejados en el mapa</p>
		</div>
		<div class="social">
			<div class="fb-like" data-href="https://www.facebook.com/startupmap.la" data-width="20" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>

			<a href="https://twitter.com/share" class="twitter-share-button" data-url="startupmap.la" data-text="En @startupmapla podés ver las #startups en Latino América ¿Ya agregaste la tuya? Chequealas en http://startupmap.la/" data-lang="es" data-related="startupmapla">Twittear</a>
		</div>
	</div>
	<h3 class="add-only">Agregar Item</h3>
	<h3 class="edit-only">Editar Item</h3>

	<form id="startupCreate" autocomplete="off">
		<input id="startupCreateID" type="hidden" name="id" />
		<input id="startupCreateAction" type="hidden" name="action" />

		<div class="info clearfix " id="startupMainData">
			
			<div class="control" data-control="startup-name">
				<input id="startupCreateName" type="text" name="name" value="" placeholder="Nombre" />
				<ul class="errorList"></ul>
			</div>

			<div class="control" data-control="startup-slogan">
				<input id="startupCreateSlogan" type="text" name="slogan" value="" placeholder="Micro descripción" />
				<ul class="errorList"></ul>
			</div>

		</div>

		<div>
			<div class="control" data-control="startup-category">
				<select id="startupCreateCategory" name="category" class="demo-default" placeholder="Seleccion Categoria">
					@foreach($categories as $category)
					<option value="{{ $category->id }}">{{ $category->name }}</option>
					@endforeach
				</select>
				<ul class="errorList"></ul>
			</div>

			<div class="control" data-control="startup-tags">
				<select id="startupCreateTags" class="demo-default" name="tags[]" multiple placeholder="Tags">
					@foreach($tags as $tag)
					<option value="{{ $tag->id }}">{{ $tag->tag }}</option>
					@endforeach
				</select>
				<ul class="errorList"></ul>
			</div>
		</div>

		<div class="location">
			<div class="control" data-control="startup-address">
				<input id="startupCreateStreet" type="text" name="address" value="" placeholder="Calle 3139" />
				<ul class="errorList"></ul>
			</div>
			<div class="control" data-control="startup-city">
				<input id="startupCreateCity" type="text" name="city" class="city" value="" placeholder="Ciudad" />
				<ul class="errorList"></ul>
			</div>
			<div class="control" data-control="startup-country">
				<!-- <input id="startupCreateCity" type="text" name="country" class="country" value="" placeholder="Pais" /> -->
				{{ Form::select('country', Country::where('enabled', 'y')->get()->lists('name', 'iso'), $country, array( 'id' => 'startupCreateCountry' )) }}
				<ul class="errorList"></ul>
				<input id="startupCreateLat" type="hidden" name="lat"/>
				<input id="startupCreateLon" type="hidden" name="lon"/>
			</div>
			<ul class="address_options">
			</ul>
		</div>

		<div class="url">

			<div class="input-prepend">
				<span class="addon"><i class="fa fa-globe"></i></span>
				<div class="control" data-control="startup-website">
					<input id="startupCreateWebsite" type="text" name="website" value="" placeholder="http://" />
					<ul class="errorList"></ul>
				</div>
			</div>

		</div>
		<div class="imageUpload ajaxFileUpload control" data-control="startup-logo" data-upload-route="upload/logo" data-upload-field="logoFilename" data-upload-input="uploadLogo" data-control="startup-logo">
			<p>Logo (90x90)</p>
			<input type="hidden" name="logo" id="logoFilename" value="" />
			<ul class="errorList inverse"></ul>
			<input type="file" style="display:none;" name="logoFile" id="uploadLogo" />
			<div id="uploadLogoArea" class="upload dropzone">
				<div class="uploading">
					<i class="fa fa-spinner fa-spin"></i>
				</div>
				<i class="fa fa-cloud-upload"></i>
			</div>

		</div>
		<div class="banner" id="bannerAjaxUpload">
			<p>Banner (370x180)</p>
			<div class="ajaxFileUpload control" data-upload-route="upload/banner" data-upload-field="bannerFilename" data-upload-input="uploadBanner" data-control="startup-banner">
				<div id="uploadBannerArea" class="upload dropzone">
					<div class="uploading">
						<i class="fa fa-spinner fa-spin"></i>
					</div>
					<i class="fa fa-cloud-upload"></i>
				</div>
				<input type="hidden" name="banner" id="bannerFilename" value="" />
				<ul class="errorList"></ul>
				<input type="file" style="display:none;" name="bannerFile" id="uploadBanner" />
			</div>
		</div>
		<div class="data-link">
			<div class="i-crunch input-prepend control" data-control="startup-crunchbase">
				<span class="addon"><i class="icon-crunch"></i></span>
				<input id="startupCreateCrunchbase" type="text" name="crunchbase" value="" placeholder="http://www.crunchbase.com/organization/usuario" />
				<ul class="errorList"></ul>
			</div>
			<div class="i-angel input-prepend control" data-control="startup-angellist">
				<span class="addon"><i class="icon-angel"></i></span>
				<input id="startupCreateAngelist" type="text" name="angelist" value="" placeholder="https://angel.co/usuario" />
				<ul class="errorList"></ul>
			</div>
		</div>
		<div class="social">
			<div class="toggle" style="display: none">
				<a href="#facebook" class="c-facebook fa-stack fa-lg">
				  <i class="fa fa-circle fa-stack-2x"></i>
				  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
				</a>
				<a href="#dribbble" class="c-dribbble fa-stack fa-lg">
				  <i class="fa fa-circle fa-stack-2x"></i>
				  <i class="fa fa-dribbble fa-stack-1x fa-inverse"></i>
				</a>
				<a href="#twitter" class="c-twitter fa-stack fa-lg">
				  <i class="fa fa-circle fa-stack-2x"></i>
				  <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
				</a>
				<a href="#foursquare" class="c-foursquare fa-stack fa-lg">
				  <i class="fa fa-circle fa-stack-2x"></i>
				  <i class="fa fa-foursquare fa-stack-1x fa-inverse"></i>
				</a>
				<a href="#google-plus" class="c-google-plus fa-stack fa-lg">
				  <i class="fa fa-circle fa-stack-2x"></i>
				  <i class="fa fa-google-plus fa-stack-1x fa-inverse"></i>
				</a>
				<a href="#linkedin" class="c-linkedin fa-stack fa-lg">
				  <i class="fa fa-circle fa-stack-2x"></i>
				  <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
				</a>
				<a href="#youtube" class="c-youtube fa-stack fa-lg">
				  <i class="fa fa-circle fa-stack-2x"></i>
				  <i class="fa fa-youtube fa-stack-1x fa-inverse"></i>
				</a>
			</div>
			<div class="input">
				<div class="i-facebook input-prepend control" data-control="startup-facebook">
					<span class="addon"><i class="fa fa-facebook"></i></span>
					<input id="startupCreateFacebook" type="text" name="facebook" value="" placeholder="https://www.facebook.com/usuario">
					<ul class="errorList"></ul>
				</div>
				<div class="i-dribbble input-prepend control" data-control="startup-dribbble">
					<span class="addon"><i class="fa fa-dribbble"></i></span>
					<input id="startupCreateDribbble" type="text" name="dribbble" value="" placeholder="https://dribbble.com/usuario">
					<ul class="errorList"></ul>
				</div>
				<div class="i-twitter input-prepend control" data-control="startup-twitter">
					<span class="addon"><i class="fa fa-twitter"></i></span>
					<input id="startupCreateTwitter" type="text" name="twitter" value="" placeholder="https://twitter.com/usuario">
					<ul class="errorList"></ul>
				</div>
				<div class="i-foursquare input-prepend control" data-control="startup-foursquare">
					<span class="addon"><i class="fa fa-foursquare"></i></span>
					<input id="startupCreateFoursquare" type="text" name="foursquare" value="" placeholder="https://foursquare.com/usuario">
					<ul class="errorList"></ul>
				</div>
				<div class="i-google-plus input-prepend control" data-control="startup-googleplus">
					<span class="addon"><i class="fa fa-google-plus"></i></span>
					<input id="startupCreateGooglePlus" type="text" name="google_plus" value="" placeholder="https://plus.google.com/1234567890">
					<ul class="errorList"></ul>
				</div>
				<div class="i-linkedin input-prepend control" data-control="startup-linkedin">
					<span class="addon"><i class="fa fa-linkedin"></i></span>
					<input id="startupCreateLinkedIn" type="text" name="linkedin" value="" placeholder="http://linkedin.com/company/1234567">
					<ul class="errorList"></ul>
				</div>
				<div class="i-youtube input-prepend control" data-control="startup-youtube">
					<span class="addon"><i class="fa fa-youtube"></i></span>
					<input id="startupCreateYoutube" type="text" name="youtube" value="" placeholder="https://www.youtube.com/user">
					<ul class="errorList"></ul>
				</div>
			</div>
		</div>
		<div class="description">
			<div class="control" data-control="startup-description">
				<textarea id="startupCreateDescription" name="description" placeholder="Contanos de tu startup" data-control="startup-description"></textarea>
				<ul class="errorList"></ul>
			</div>
		</div>

		<div class="button add-only">

			<a href="#" id="btnStartupCreate" class="button btn submit app" data-app-route="startup.create">
				<span class="normal"><i class="fa fa-plus"></i> Agregar Startup</span>
				<span class="processing"><i class="fa fa-spinner fa-spin"></i></span>
			</a>
		</div>
		<div class="button edit-only">
			<a href="#" id="btnStartupEdit" class="button btn submit app" data-app-route="startup.edit">
				<span class="normal"><i class="fa fa-edit"></i> Guardar Cambios</span>
				<span class="processing"><i class="fa fa-spinner fa-spin"></i></span>
			</a>
		</div>
	</form>
	<!-- END #startupForm -->

</div>
<!-- END #startupEditor -->