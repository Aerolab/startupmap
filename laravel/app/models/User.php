<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

/** 
 * @package 	StartupsMap
 * @version 	0.1
 */
class User extends Eloquent implements UserInterface, RemindableInterface 
{

	protected $hidden = array('password');
	protected $fillable = array( 'email', 'password', 'admin', 'ln_access_token', 'remember_token' );
	protected $dates = array('created_at', 'updated_at');

	public static function boot()
	{
		parent::boot();

		self::creating(function($user){
			$user->key = strtolower(str_random(32));
			$user->password = Hash::make($user->password);
			$user->validated_at = '0000-00-00 00:00:00.000000';
		});

		self::deleting(function($user){
			$user->profile()->delete();
		});
	}

	/**
	 * Returns the use profile
	 * @since 0.1
	 */
	public function profile()
	{
		return $this->hasOne('Profile');
	}

	/**
	 * Returns the user founder profile
	 * @since 0.1
	 */
	public function founder()
	{
		return $this->hasOne('Founder');
	}
	
	/**
	 * Generates an array with basic user profile
	 * @since 	0.1
	 */
	public function toArray()
	{
		return array(
			'uid'		=>	$this->key,
			'email'		=>	$this->email,
			'name'		=>	$this->profile->name,
			'last_name'	=>	$this->profile->last_name,
			'full_name'	=>	$this->profile->name . ' ' . $this->profile->last_name,
			'picture'	=>	$this->profile->picture()
			);
	}
	
	public function validate()
	{
		$date = new DateTime;
		$this->validated_at = $date->format('y-m-d H:i:s');
		$this->save();
	}

	public function claims()
	{
		return $this->hasMany('Claim');
	}

	public function startups()
	{
		return $this->hasMany('Startup_member');
	}

	/**
	 * @param $params array
	 * @since 0.1
	 */
	public function routeParams($params = array())
	{
		return array_merge( array( 'id' => $this->id, 'name' => $this->profile->full_name(true) ), $params );
	}
	
	public function getAuthIdentifier(){	return $this->getKey();	}

	public function getAuthPassword(){	return $this->password;	}

	public function getRememberToken(){	return $this->remember_token;	}

	public function setRememberToken($value){	$this->remember_token = $value;	}

	public function getRememberTokenName(){	return 'remember_token';	}

	public function getReminderEmail(){	return $this->email;	}

}
