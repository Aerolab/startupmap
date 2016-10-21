<?php

class City extends Eloquent 
{

	protected $table = 'cities';
	protected $fillable = array( 'name' );
	public $timestamps = false;

	/**
	 * @since 0.1
	 */
	public function country()
	{
		return $this->belongsTo('Country', 'country_iso', 'iso');
	}

}