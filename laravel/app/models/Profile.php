<?php

/** 
 * @package StartupsMap
 * @version 0.1
 */
class Profile extends Eloquent
{
	protected $fillable = [ 'user_id', 'name', 'last_name', 'picture' ];
	
	/**
	 * @since 	0.1
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

	/** 
	 * @since 	0.1
	 */
	public function picture()
	{
		return $this->picture == '' ? 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($this->user->email))) : $this->picture;
	}

	public function full_name($slug = false)
	{
		$fullName = $this->name . ' ' . $this->last_name;

		return $slug ? Str::slug($fullName) : $fullName;
	}

}