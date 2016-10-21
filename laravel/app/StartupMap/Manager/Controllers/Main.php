<?php namespace StartupMap\Manager\Controllers;

class Main extends \Controller 
{

	protected $users;

	/**
	 * @since 0.2
	 */
	public function __construct(\StartupMap\User\UserInterface $users)
	{
		$this->users = $users;
	}

	/**
	 * @since 0.2
	 */
	public function index()
	{
		return \View::make('manager::dashboard')
					->with('user', \Auth::user())
					->with('message', \Session::get('notification'));
	}

}
