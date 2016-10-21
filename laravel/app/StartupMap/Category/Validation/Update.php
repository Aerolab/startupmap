<?php namespace StartupMap\Category\Validation;

class Update extends \StartupMap\Validation\FormValidator
{
	protected $rules = array(
		'name' => 'required',
		'order'	=>	'numeric',
		'visible'	=>	'required|in:y,n'
		);	
}