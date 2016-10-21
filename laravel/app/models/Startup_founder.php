<?php

/** 
 * @package 	StartupsMap
 * @version 	0.1
 */
class Startup_founder extends Eloquent 
{

	// -----------------------------------------------------------------------

	protected $fillable = [ 'founder_id', 'startup_id' ];

	// -----------------------------------------------------------------------

	/**
	 * @since 0.1
	 */
	public function startup()
	{
		return $this->belongsTo('Startup');
	}

	// -----------------------------------------------------------------------

	public function profile()
	{
		return $this->belongsTo('Founder');
	}

	// -----------------------------------------------------------------------

}