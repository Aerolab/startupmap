<?php namespace StartupMap\User\Validation;

class Update extends \StartupMap\Validation\FormValidator
{
	protected $rules = array(
		'name'		=>	'required',
		'last_name'	=>	'required'
		);	
}