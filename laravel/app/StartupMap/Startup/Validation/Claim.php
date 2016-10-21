<?php namespace StartupMap\Startup\Validation;

class Claim extends \StartupMap\Validation\FormValidator
{
	protected $rules = array(
		'startup_id'	=>	'required|exists:startups,id',
		'note'			=>	''
		);	
}