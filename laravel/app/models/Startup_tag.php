<?php

/** 
 * @package 	StartupsMap
 * @version 	0.1
 */
class Startup_tag extends Eloquent 
{

	// -----------------------------------------------------------------------

	protected $fillable = [ 'tag_id', 'startup_id' ];

	// -----------------------------------------------------------------------

	/**
	 * Returns the startup related to the tag
	 * @since 0.1
	 */
	public function startup()
	{
		return $this->belongsTo('Startup');
	}

	// -----------------------------------------------------------------------

	public function tag()
	{
		return $this->belongsTo('Tag');
	}

	// -----------------------------------------------------------------------

}