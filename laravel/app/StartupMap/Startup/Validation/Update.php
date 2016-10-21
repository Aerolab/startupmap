<?php namespace StartupMap\Startup\Validation;

class Update extends \StartupMap\Validation\FormValidator
{
	protected $rules = array(
		'name'			=>	'required',
		'slogan' 		=>	'',
		'description' 	=>	'required',
		'logo' 			=>	'required',
		'banner' 		=>	'required',
		'address' 		=>	'required',
		'city' 			=>	'required',
		'country' 		=>	'required',
		'facebook' 		=>	'url',
		'twitter' 		=>	'url',
		'linkedin' 		=>	'url',
		'website' 		=>	'url',
		'crunchbase' 	=> 	'url',
		'angelist' 		=> 	'url',
		'dribbble' 		=> 	'url',
		'foursquare' 	=> 	'url',
		'google_plus' 	=> 	'url',
		'youtube' 		=> 	'url',
		'category' 		=> 	'required|exists:categories,id',
		'tags' 			=> 	'',
		'parent'		=>	'',
		'user_id'		=>	'',
		'approved'		=>	'required|in:y,n',
		'lat'			=>	'required',
		'lon'			=>	'required'
		);	
}