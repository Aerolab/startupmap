<?php namespace StartupMap\Country\Validation;

class Update extends \StartupMap\Validation\FormValidator
{
	protected $rules = array(
		'enabled'		=>	'required|in:y,n',
		);	
}