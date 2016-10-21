<?php namespace StartupMap\Manager\Controllers;

class Startups extends \Controller 
{

	protected $startups;

	/**
	 * @since 0.2
	 */
	public function __construct(\StartupMap\Startup\StartupInterface $startups)
	{
		$this->startups = $startups;
	}

	/**
	 * @since 0.2
	 */
	public function index($id, $startup)
	{
		return \View::make('manager::startup.index')
					->with('startup', $this->startups->find($id))
					->with('user', \Auth::user())
					->with('message', \Session::get('notification'));
	}

	public function post_add_member($id, $startup)
	{
		try
		{
			$startup = $this->startups->find($id);
			$this->startups->add_member($startup, \Input::all());

			return \Redirect::route('manager.startup.index', $startup->routeParams())
							->with('notification', 'The invitation has been processed. If the person is not registered, an e-mail will be delivered shortly.');
		}
		catch(\StartupMap\Validation\FormValidationException $e)
		{
			return \Redirect::back()->withInput()->withErrors($e->getErrors());
		}
	}

}
