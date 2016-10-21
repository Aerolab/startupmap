<?php namespace StartupMap\Admin\Controllers;

class Categories extends \Controller 
{

	protected $categories;

	/**
	 * @since 0.2
	 */
	public function __construct(\StartupMap\Category\CategoryInterface $categories)
	{
		$this->categories = $categories;
	}

	/**
	 * @since 0.2
	 */
	public function index()
	{
		return \View::make('admin::category.list')
					->with('categories', $this->categories->all())
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
		return \View::make('admin::category.form')
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
			$category = $this->categories->create(\Input::all());

			return \Redirect::route('category.admin')
							->with('notification', 'The category <b>' . $category->name . '</b> was created succesfully.');
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
		return \View::make('admin::category.form')
					->with('mode', 'edit')
					->with('category', $this->categories->find($id))
					->with('user', \Auth::user())
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
			$category = $this->categories->update($this->categories->find($id), \Input::all());

			return \Redirect::route('category.admin.edit', $category->routeParams())
							->with('notification', '<b>' . $category->name . '</b> has been updated succesfully.');
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
		$category = $this->categories->find($id);
		$this->categories->delete($category);

		return \Redirect::route('category.admin')
						->with('notification',  '<b>' . $category->name . '</b> was deleted succesfully.');
	}

}
