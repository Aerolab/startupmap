<?php namespace App\Forms;

use Illuminate\Support\MessageBag;

class FormValidationException extends \Exception {

	/**
	 * @var MessageBag
	 */
	protected $_errors;

	/**
	 * @param string     $message
	 * @param MessageBag $errors
	 */
	function __construct($message, MessageBag $errors)
	{
		$this->_errors = $errors->toArray();

		parent::__construct($message);
	}

	/**
	 * Get form validation errors
	 *
	 * @return MessageBag
	 */
	public function getErrors()
	{
		return $this->_errors;
	}

}