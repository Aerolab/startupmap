<?php namespace App\Forms;

class RecoverPasswordForm extends FormValidator {

	/**
	 * @var array
	 */
	protected $rules = [
		'password'		=>	'required|min:6|confirmed',
		'password_confirmation' => 'required'
	];

} 