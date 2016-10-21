<?php

/** 
 * @package 	StartupsMap
 * @version 	0.1
 */
class Tag extends Eloquent 
{

	// -----------------------------------------------------------------------

	protected $fillable = [ 'tag' ];

	// -----------------------------------------------------------------------

	public function startup_tags()
	{
		return $this->hasMany('Startup_tag');
	}

	/**
	 * Returns the startups under the tag
	 * @since 0.1
	 */
	public function startups()
	{
		$startups = array();

		foreach(Startup_tag::where('tag_id', $this->id)->get() as $tag)
			$startups[] = $tag->startup_id;

		return count($startups) != 0 ? Startup::whereIn('id', $startups)->get() : array();
	}

	// -----------------------------------------------------------------------

	/**
	 * Generate a slug from the name
	 * @since 0.1
	 */
	public function slug()
	{
		return Str::slug(Str::lower($this->tag));
	}

	// -----------------------------------------------------------------------

	public function routeParams($params = array())
	{		
		return array_merge( array( 'id' => $this->id, 'name' => $this->slug() ), $params );
	}

	// -----------------------------------------------------------------------

}