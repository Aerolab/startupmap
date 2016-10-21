<?php namespace StartupMap\Admin\Controllers;

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
	public function index($country = false)
	{
		if($country = \Country::where('iso', $country)->first())
			$startups = $this->startups->findBy(array( 'country_id' => $country->iso ));
		else
			$startups = $this->startups->all(false, 'created_at', 'desc');

		return \View::make('admin::startup.list')
					->with('country', $country)
					->with('startups', $startups)
					->with('user', \Auth::user())
					->with('message', \Session::get('notification'));
	}

	/** 
	 * @since 0.2
	 */
	public function create()
	{
		return \View::make('admin::startup.form')
					->with('mode', 'create')
					->with('user', \Auth::user())
					->with('message', \Session::get('notification'));
	}

	/**
	 * @since 0.2
	 */
	public function store()
	{
		try
		{
			$startup = $this->startups->create(\Input::all());

			return \Redirect::route('startup.admin.show', $startup->routeParams())
							->with('notification', \Input::get('name') . ' has been created succesfully.');
		}
		catch(\StartupMap\Validation\FormValidationException $e)
		{
			return \Redirect::back()->withInput()->withErrors($e->getErrors());
		}
	}

	/**
	 * @param 	$id 	integer
	 * @param 	$name 	string
	 * @since 	0.2
	 */
	public function show($id, $name)
	{
		return \View::make('admin::startup.show')
					->with('startup', $this->startups->find($id))
					->with('user', \Auth::user())
					->with('message', \Session::get('notification'));
	}

	/**
	 * @param 	$id 	integer
	 * @param 	$name 	string
	 * @since 	0.2
	 */
	public function edit($id, $name)
	{
		return \View::make('admin::startup.form')
					->with('mode', 'edit')
					->with('startup', $this->startups->find($id))
					->with('user', \Auth::user())
					->with('message', \Session::get('notification'));
	}

	/**
	 * @param 	$id 	integer
	 * @param 	$name 	string
	 * @since 	0.2
	 */	 
	public function update($id, $name)
	{
		try
		{
			$startup = $this->startups->update($this->startups->find($id), \Input::all());

			return \Redirect::route('startup.admin.edit', $startup->routeParams())
							->with('notification', \Input::get('name') . ' was updated succesfully.');
		}
		catch(\StartupMap\Validation\FormValidationException $e)
		{
			return \Redirect::back()->withInput()->withErrors($e->getErrors());
		}
	}

	/**
	 * @param 	$id 	integer
	 * @param 	$name 	string
	 * @since 	0.2
	 */
	public function destroy($id, $name)
	{
		// Fetch the startup
		$startup = $this->startups->find($id);
		$startupName = $startup->name;
		$this->startups->delete($startup);

		return \Redirect::route('startup.admin')
						->with('notification', $startupName . ' was deleted succesfully.');
	}

}
