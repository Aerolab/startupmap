<?php namespace StartupMap\Admin\Controllers;

class Users extends \Controller 
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
		return \View::make('admin::user.list')
					->with('users', $this->users->all())
					->with('user', \Auth::user())
					->with('message', \Session::get('notification'));
	}

	/**
	 * @param 	$id 	integer
	 * @param 	$name 	string
	 * @since 	0.2
	 */
	public function show($id, $name)
	{
		return \View::make('admin::category.show')
					->with('category', $this->categories->find($id))
					->with('user', \Auth::user())
					->with('message', \Session::get('notification'));
	}

	/**
	 * @since 0.2
	 */
	public function create()
	{
		return \View::make('admin::user.form')
					->with('mode', 'create')
					->with('user', \Auth::user())
					->with('message', \Session::get('notification'));
	}

	/**
	 * @since 0.1
	 */
	public function store()
	{
		try
		{
			$user = $this->users->create(\Input::all(), true, false, false);

			return \Redirect::route('user.admin')
							->with('notification', $user->profile->name . ' ' . $user->profile->last_name . ' was succesfully created.');
		}
		catch(\StartupMap\Validation\FormValidationException $e)
		{
			return \Redirect::back()->withInput()->withErrors($e->getErrors());
		}
	}

	/**
	 * @param 	$id 	integer
	 * @param 	$name 	string
	 * @since 	0.1
	 */
	public function edit($id, $name)
	{
		return \View::make('admin::user.form')
					->with('mode', 'edit')
					->with('user', $this->users->find($id))
					->with('message', \Session::get('notification'));
	}

	/**
	 * @param 	$id 	integer
	 * @param 	$name 	string
	 * @since 	0.1
	 */
	public function update($id, $name)
	{
		try
		{
			$user = $this->users->update($this->users->find($id), \Input::all());

			return \Redirect::route('user.admin.edit', $user->routeParams())
							->with('notification', $user->profile->name . ' ' . $user->profile->last_name . ' was succesfully updated.');
		}
		catch(\StartupMap\Validation\FormValidationException $e)
		{
			return \Redirect::back()->withInput()->withErrors($e->getErrors());
		}
	}

	/**
	 * @param 	$id 	integer
	 * @param 	$name 	string
	 * @since 	0.1
	 */
	public function destroy($id, $name)
	{
		$user = $this->users->find($id);
		$fullName = $user->profile->full_name();
		$this->users->delete($user);

		return \Redirect::route('user.admin')
						->with('notification',  '<b>' . $fullName . '</b> was deleted succesfully.');
	}

}
