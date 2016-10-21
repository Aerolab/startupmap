<?php namespace StartupMap\Country;

/**
 * @package StartupMap
 * @version 0.2
 * @author Mauro Casas
 */
interface CountryInterface {
	public function all($orderBy = 'id', $order = 'asc');
	public function find($value, $field = 'id');
	public function toggle(\Country $country);
}