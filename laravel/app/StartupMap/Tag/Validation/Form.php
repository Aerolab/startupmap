<?php namespace StartupMap\Tag\Validation;

class Form extends \StartupMap\Validation\FormValidator {

	/**
	 * @var array
	 */
	protected $rules = array(
		'tag' => 'required'
	);

} 