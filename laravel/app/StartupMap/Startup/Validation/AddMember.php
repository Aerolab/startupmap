<?php namespace StartupMap\Startup\Validation;

class AddMember extends \StartupMap\Validation\FormValidator
{
	protected $rules = array(
		'email' => 'required|email',
		'role'	=>	'required',
		'admin' => 'required|in:y,n'
		);	
}