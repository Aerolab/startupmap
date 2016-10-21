<?php

class Founder extends Eloquent
{
	// -----------------------------------------------------------------------

	protected $fillable = [ 'user_id', 'name', 'last_name', 'picture', 'linkedin', 'angellist', 'crunchbase' ];
	
	// -----------------------------------------------------------------------

	public function user()
	{
		return $this->belongsTo('User');
	}

	// -----------------------------------------------------------------------

}