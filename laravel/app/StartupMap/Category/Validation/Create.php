<?php namespace StartupMap\Category\Validation;

class Create extends \StartupMap\Validation\FormValidator
{
	protected $rules = array(
		'name' => 'required',
		'order'	=>	'numeric',
		'visible'	=>	'required|in:y,n'
		);	
}