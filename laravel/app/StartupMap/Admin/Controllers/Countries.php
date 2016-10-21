<?php namespace StartupMap\Admin\Controllers;

class Countries extends \Controller 
{

	protected $countries;

	/**
	 * @since 0.2
	 */
	public function __construct(\StartupMap\Country\CountryInterface $countries)
	{
		$this->countries = $countries;
	}

	/**
	 * @since 0.2
	 */
	public function index($country = false)
	{
		return \View::make('admin::country.list')
					->with('countries', $this->countries->all('enabled'))
					->with('user', \Auth::user())
					->with('message', \Session::get('notification'));
	}

	/**
	 * @param 	$id 	integer
	 * @param 	$name 	string
	 * @since 	0.2
	 */
	public function show($iso, $name)
	{
		return \View::make('admin::country.show')
					->with('country', $this->countries->find($iso, 'iso'))
					->with('user', \Auth::user())
					->with('message', \Session::get('notification'));
	}

	/**
	 * @param 	$id 	integer
	 * @param 	$name 	string
	 * @since 	0.2
	 */	 
	public function update($iso, $name)
	{
		try
		{
			$country = $this->countries->toggle($this->countries->find($iso, 'iso'));

			return \Redirect::route('country.admin')
							->with('notification', '<b>' . $country->name . '</b> (' . $country->iso . ')' . ' was toggled succesfully.');
		}
		catch(\StartupMap\Validation\FormValidationException $e)
		{
			return \Redirect::back()->withInput()->withErrors($e->getErrors());
		}
	}

}
