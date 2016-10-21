<?php

/** 
 * @package 	StartupsMap
 * @version 	0.1
 */
class Claim extends Eloquent 
{

	// -----------------------------------------------------------------------

	protected $fillable = [ 'startup_id', 'user_id', 'note' ];

	// -----------------------------------------------------------------------

	public function startup()
	{
		return $this->belongsTo('Startup');
	}

	// -----------------------------------------------------------------------

	public function user()
	{
		return $this->belongsTo('User');
	}

	// -----------------------------------------------------------------------

	public static function boot()
	{
		parent::boot();

		self::creating(function($claim){
			$claim->user_id = Auth::user()->id;
			$claim->flag = 'pending';
		});
	}

	// -----------------------------------------------------------------------

}