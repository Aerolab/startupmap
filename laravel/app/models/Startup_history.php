<?php

/** 
 * @package 	StartupsMap
 * @version 	0.1
 */
class Startup_history extends Eloquent 
{

	// -----------------------------------------------------------------------

	protected $table = 'startup_history';

	// -----------------------------------------------------------------------

	protected $fillable = array( 'category_id', 'user_id', 'name', 'slogan', 'description', 'type', 'tags', 'approved', 'child_of', 'logo', 'banner', 'website', 'facebook', 'twitter', 'linkedin', 'lat', 'lon', 'address', 'city', 'country' );

	// -----------------------------------------------------------------------

	/**
	 * @since 0.1
	 */
	public static function boot()
	{
		parent::boot();

		self::creating(function($startup){
			$startup->commit = strtolower(str_random(32));
		});
	}

	// -----------------------------------------------------------------------

	/**
	 * @since 0.1
	 */
	public function startup()
	{
		return $this->belongsTo('Startup');
	}

	// -----------------------------------------------------------------------

}