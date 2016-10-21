<?php namespace StartupMap\Country;

/**
 * @package StartupMap
 * @version 0.2
 * @author Mauro Casas
 */
class CountryRepository implements CountryInterface {

	protected $validators;

	public function __construct(array $validators = array()){
		$this->validators = $validators;
	}

	public function all($orderBy = 'id', $order = 'asc')
	{
		return \Country::orderBy($orderBy, $order)->get();
	}

	public function find($value, $field = 'id')
	{
		return \Country::where($field, $value)->first();
	}

	public function toggle(\Country $country)
	{		
		$country->update(array(
			'enabled'			=>	$country->enabled == 'y' ? 'n' : 'y',
			));

		return $country;
	}

}