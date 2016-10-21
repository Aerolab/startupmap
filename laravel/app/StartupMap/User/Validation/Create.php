<?php namespace StartupMap\User\Validation;

class Create extends \StartupMap\Validation\FormValidator
{
	protected $rules = array(
		'email'		=>	'required|email|unique:users,email',
		'password'	=>	'required|min:6',
		'name'		=>	'required',
		'last_name'	=>	'required'
		);	
}