@extends('admin::layout', [ 'pageTitle' => $mode == 'create' ? 'Create a startup' : 'Edit ' . $startup->name ])

@section('content')
<header class="page-header">
	<div class="container">
		<div class="row-fluid">
			<div class="span8">
				<h1>{{ $mode == 'create' ? 'Create a startup' : 'Edit ' . link_to_route('startup.admin.show', $startup->name, $startup->routeParams()) }}</h1>
			</div>
			<div class="span4 text-right" style="padding-top:10px">
				{{ HTML::decode(link_to_route('startup.admin', '<i class="fa fa-arrow-left"></i> Back to startups', [], [ 'class' => 'btn' ])) }}
			</div>
		</div>
	</div>
</header>
<div class="container">
	{{ Form::open(array( 'route' => $mode =='create' ? 'startup.admin.create' : array_merge(array('startup.admin.edit'), $startup->routeParams()), 'method' => $mode == 'create' ? 'POST' : 'PUT', 'class' => 'form-horizontal' )) }}

		@include('modules.alerts')

		<div class="control-group">
			<label for="name" class="control-label">Name</label>
			<div class="controls">
				{{ Form::text('name', $mode == 'create' ? Input::old('name') : $startup->name) }}
			</div>
		</div>

		<div class="control-group">
			<label for="slogan" class="control-label">Slogan</label>
			<div class="controls">
				{{ Form::text('slogan', $mode == 'create' ? Input::old('slogan') : $startup->slogan) }}
			</div>
		</div>

		<div class="control-group">
			<label for="description" class="control-label">Description</label>
			<div class="controls">
				{{ Form::textarea('description', $mode == 'create' ? Input::old('description') : $startup->description, [ 'class' => 'input-block-level' ]) }}
			</div>
		</div>

		<hr />

		<hgroup>
			<h3>Location</h3>
		</hgroup>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="address" class="control-label">Address</label>
					<div class="controls">
						{{ Form::text('address', $mode == 'create' ? Input::old('address') : $startup->address, [ 'class' => 'input-block-level updateGeolocation', 'id' => 'geoLocationAddress' ]) }}
					</div>
				</div>

				<div class="control-group">
					<label for="city" class="control-label">City</label>
					<div class="controls">
						{{ Form::text('city', $mode == 'create' ? Input::old('city') : $startup->city, [ 'class' => 'input-block-level updateGeolocation', 'id' => 'geoLocationCity' ]) }}
					</div>
				</div>

				<div class="control-group">
					<label for="country" class="control-label">Country</label>
					<div class="controls">
						{{ Form::countries([
							'name'	=>	'country',
							'value'	=>	$mode == 'create' ? Input::old('country', 'AR') : $startup->country->iso,
							'attributes' => array(
								'class'	=>	'updateGeolocation',
								'id'	=>	'geoLocationCountry'
								)
							]) }}
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label for="lat" class="control-label">Latitude</label>
					<div class="controls">
						{{ Form::text('lat', $mode == 'create' ? Input::old('lat') : $startup->lat, [ 'class' => 'input-block-level', 'id' => 'geoLocationLat' ]) }}
					</div>
				</div>

				<div class="control-group">
					<label for="lon" class="control-label">Longitude</label>
					<div class="controls">
						{{ Form::text('lon', $mode == 'create' ? Input::old('lon') : $startup->lon, [ 'class' => 'input-block-level', 'id' => 'geoLocationLon' ]) }}
					</div>
				</div>
			</div>
		</div>

		<hr />

		<hgroup>
			<h3>Social &amp; web</h3>
		</hgroup>

		<?php
			$socialFieldList = array(
				'website'		=>	'Website',
				'facebook'		=>	'Facebook',
				'twitter'		=>	'Twitter',
				'linkedin'		=>	'LinkedIn',
				'crunchbase'	=>	'Crunchbase',
				'angelist'		=>	'Angelist',
				'dribbble'		=>	'Dribbble',
				'google_plus'	=>	'Google+',
				'foursquare'	=>	'Foursquare',
				'youtube'		=>	'Youtube'
				);
		?>

		<div class="row-fluid">
			<div class="span6">
		@foreach($socialFieldList as $key => $field)
			<div class="control-group">
				<label for="{{ $key }}" class="control-label">{{ $field }}</label>
				<div class="controls">
					{{ Form::text($key, $mode == 'create' ? Input::old($key) : $startup->$key, array( 'class' => 'input-block-level' )) }}
				</div>
			</div>
			@if($key == 'crunchbase')
			</div>
			<div class="span6">
			@endif
		@endforeach
			</div>
		</div>

		<hr />

		<hgroup>
			<h3>Branding</h3>
			<p class="alert alert-info">Only jpeg gif and png files are accepted</p>
		</hgroup>

		<div class="clearfix">

			<div class="ajaxFileUpload" data-upload-route="upload/logo" data-upload-field="logoFilename" data-upload-input="uploadLogo">
				<p>Logo (90x90)</p>
				<div id="uploadLogoArea" class="upload dropzone">
					<div class="uploading">
						<i class="fa fa-spinner fa-spin"></i>
					</div>
					<i class="fa fa-cloud-upload"></i>
				</div>
				<input type="file" name="logoFile" id="uploadLogo" />
				{{ Form::hidden('logo', $mode == 'create' ? Input::old('logo', '') : 'thumb_' . $startup->logo, array( 'id' => 'logoFilename' )) }}
			</div>

			<div class="ajaxFileUpload" data-upload-route="upload/banner" data-upload-field="bannerFilename" data-upload-input="uploadBanner">
				<p>Banner (370x180)</p>
				<div id="uploadBannerArea" class="upload dropzone">
					<div class="uploading">
						<i class="fa fa-spinner fa-spin"></i>
					</div>
					<i class="fa fa-cloud-upload"></i>
				</div>
				<input type="file" name="bannerFile" id="uploadBanner" />
				{{ Form::hidden('banner', $mode == 'create' ? Input::old('banner', '') : $startup->banner, array( 'id' => 'bannerFilename' )) }}
			</div>

		</div>

		<hr />

		<hgroup>
			<h3>Advanced</h3>
		</hgroup>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="category" class="control-label">Category</label>
					<div class="controls">
						{{ Form::select('category', Category::all()->lists('name', 'id'), $mode == 'create' ? Input::old('category') : $startup->category_id) }}
					</div>
				</div>

				<div class="control-group">
					<label for="tags" class="control-label">Tags</label>
					<div class="controls">
						{{ Form::select('tags[]', Tag::all()->lists('tag', 'id'), $mode == 'create' ? Input::old('tags') : explode(',', $startup->tags), [ 'multiple', 'style' => 'height: 300px' ]) }}
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label for="parent" class="control-label">Parent</label>
					<div class="controls">
						{{ Form::select('parent', array_replace([ 0 => 'None' ], Startup::where('id', '!=', $mode == 'create' ? 0 : $startup->id)->get()->lists('name', 'id')), $mode == 'create' ? Input::old('parent') : $startup->child_of) }}
					</div>
				</div>

				<div class="control-group">
					<label for="approved" class="control-label">Approved</label>
					<div class="controls">
						{{ Form::select('approved', [ 'y' => 'Yes', 'n' => 'No' ], $mode == 'create' ? Input::old('approved') : $startup->approved) }}
					</div>
				</div>

				<div class="control-group">
					<label for="user_id" class="control-label">Owner</label>
					<div class="controls">
						{{ Form::users_dropdown('user_id', $mode == 'create' ? Input::old('user_id') : $startup->user_id) }}
					</div>
				</div>
			</div>
		</div>

		<hr />

		{{ HTML::decode(Form::button($mode == 'create' ? '<i class="fa fa-arrow-right"></i> Continue' : '<i class="fa fa-save"></i> Update', [ 'class' => 'btn btn-large btn-primary', 'type' => 'submit' ])) }}
		@if($mode == 'edit')
		{{ HTML::decode(link_to('#deleteModal', '<i class="fa fa-times"></i> Delete', array( 'data-toggle' => 'modal', 'class' => 'pull-right btn btn-large btn-danger' ))) }}
		@endif

		{{ Form::token() }}
	{{ Form::close() }}
</div>

@if($mode != 'create')
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
@endif
@endsection