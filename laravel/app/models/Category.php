<?php

/**
 * @package StartupMap
 * @version 1.0
 */
class Category extends Eloquent 
{

	protected $fillable = array( 'name', 'order', 'visible' );

	/** 
	 * @since 0.1
	 */
	public function startups()
	{
		return $this->hasMany('Startup');
	}

	/**
	 * @since 0.1
	 */
	public function slug()
	{
		return Str::slug(Str::lower($this->name));
	}

	/**
	 * @param $params array
	 * @since 0.1
	 */
	public function routeParams($params = array())
	{
		return array_merge( array( 'id' => $this->id, 'name' => $this->slug() ), $params );
	}

}