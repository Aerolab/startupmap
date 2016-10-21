<?php

class Country extends Eloquent 
{

	protected $table = 'countries';
	protected $fillable = array( 'enabled' );
	public $timestamps = false;

	/**
	 * @since 0.1
	 */
	public function startups()
	{
		return $this->hasMany('Startup', 'country_id', 'iso');
	}

	/**
	 * @since 0.2
	 */
	public function cities()
	{
		return $this->hasMany('City', 'country_iso', 'iso');
	}

	/**
	 * @since 0.1
	 */
	public function slug()
	{
		return Str::slug($this->name);
	}

	/**
	 * @param $params array
	 * @since 0.1
	 */
	public function routeParams($params = array())
	{
		return array_merge( array( 'iso' => $this->iso, 'name' => $this->slug() ), $params );
	}

}