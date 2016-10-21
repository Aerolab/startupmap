<?php namespace App\Forms;

class ResetForm extends FormValidator {

	/**
	 * @var array
	 */
	protected $rules = [
		'email'		=>	'required|email|exists:users,email'
	];

} 