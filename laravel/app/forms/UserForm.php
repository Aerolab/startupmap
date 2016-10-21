<?php namespace App\Forms;

class UserForm extends FormValidator {

	/**
	 * @var array
	 */
	protected $rules = [
		'email'		=>	'required|email|unique:users,email',
		'password'	=>	'required|min:6',
		'name'		=>	'required',
		'last_name'	=>	'required'
	];

} 