<?php

/** 
 * @package 	StartupsMap
 * @version 	0.3
 */
class Startup_member extends Eloquent 
{

	protected $table = 'startup_team';
	protected $fillable = array( 'user_id', 'is_admin', 'role_id' );

	/**
	 * @since 0.3
	 */
	public function startup()
	{
		return $this->belongsTo('Startup');
	}

	/**
	 * @since 0.3
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

	public function role()
	{
		return $this->hasOne('Startup_role', 'id', 'role_id');
	}

}