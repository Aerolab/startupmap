<?php

/** 
 * @package 	StartupsMap
 * @version 	0.1
 */
class Startup extends Eloquent 
{
	protected $fillable = array( 'category_id',  'user_id', 'name',  'tags', 'slogan', 'logo', 'facebook', 'twitter', 'linkedin', 
				'description', 'website', 'address', 'banner', 'city', 'country_id', 'child_of', 'user_id', 'lat', 'lon', 'crunchbase',
				'dribbble', 'angelist', 'foursquare', 'youtube', 'google_plus', 'flag', 'approved' );

	/**
	 * @since 0.1
	 */
	public static function boot()
	{
		parent::boot();

		// Generate a new startup commit before saving the new data
		self::updating(function($startup){
			$current = Startup::find($startup->id);
			$historyRecord = array();

			foreach(array( 'category_id', 'name', 'slogan', 'description', 'tags', 'approved', 'child_of', 'logo', 'banner', 'website', 
				'facebook', 'twitter',  'linkedin', 'crunchbase', 'dribbble', 'angelist', 'foursquare', 'youtube', 'google_plus', 'lat', 'lon',
				'address',  'city',  'country', 'address_city', 'address_street', 'address_country', 'address_formatted', 'flag' ) as $field)
				$historyRecord[$field] = $current->$field;

			$historyRecord['user_id'] = Auth::user()->id;

			$startup->history()->save(new Startup_history($historyRecord));
		});

		// Update the tags after saving
		self::saved(function($startup){
			if(is_array($tagList = explode(',', $startup->tags)))
			{
				$startup->tagList()->delete();

				foreach($tagList as $tag)
					$startup->tagList()->save(new Startup_tag([
						'tag_id'	=>	$tag
						]));
			}
		});

		// Delete all tags when a startup is also deleted
		self::deleting(function($startup){
			$startup->tagList()->delete();
		});
	}

	/**
	 * @since 0.1
	 */
	public function category()
	{
		return $this->belongsTo('Category');
	}

	/**
	 * @since 0.1
	 */
	public function country()
	{
		return $this->belongsTo('Country', 'country_id', 'iso');
	}

	/**
	 * @since 0.1
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

	/**
	 * @since 0.1
	 */
	public function tagList()
	{
		return $this->hasMany('Startup_tag');
	}

	/**
	 * @since 0.1
	 */
	public function slug()
	{
		return Str::slug(Str::lower($this->name));
	}

	/**
	 * @since 0.1
	 */
	public function startups()
	{
		return $this->hasMany('Startup', 'child_of', 'id');
	}

	/**
	 * @since 0.1
	 */
	public function parent()
	{
		return $this->belongsTo('Startup', 'child_of', 'id');
	}

	/** 
	 * @since 0.1
	 */
	public function founders()
	{
		return $this->hasManyThrough('Founder', 'Startup_founder', 'startup_id', 'id');
	}

	/** 
	 * @since 0.1
	 */
	public function history()
	{
		return $this->hasMany('Startup_history');
	}

	/** 
	 * @since 0.1
	 */
	public function claims()
	{
		return $this->hasMany('Claim');
	}

	public function team()
	{
		return $this->hasMany('Startup_member');
	}

	/** 
	 * @since 0.1
	 */
	public function toArray()
	{
		return array(
				'id'			=>	$this->id,
				'name'			=>	$this->name,
				'slug'			=>	$this->slug(),
				'slogan'		=>	$this->slogan,
				'description'	=>	$this->description,
				'child_of'		=>	$this->parent,
				'category_id'	=>	$this->category->id,
				'category_name' => 	$this->category->name,
				'category_slug' => 	$this->category->slug(),
				'facebook'		=>	$this->facebook,
				'twitter'		=>	$this->twitter,
				'linkedin'		=>	$this->linkedin,
				'crunchbase'	=>	$this->crunchbase,
				'angelist'		=>	$this->angelist,
				'dribbble'		=>	$this->dribbble,
				'google_plus'	=>	$this->google_plus,
				'foursquare'	=>	$this->foursquare,
				'youtube'		=>	$this->youtube,
				'website'		=>	$this->website,
				'address'		=>	$this->address,
				'city'			=>	$this->city,
				'country'		=>	$this->country->name,
				'country_iso'	=>	$this->country->iso,
				'country_slug'	=>	Str::slug(strtolower($this->country->name)),
				'approved'		=>	$this->approved,
				'user_id'		=>	$this->user_id,
				'lat'			=>	$this->lat,
				'lon'			=>	$this->lon,
				'tags'			=>	$this->tags,
				'logo'			=>	$this->logo != '' ? array(
					'file'	=>	$this->logo,
					'full'	=>	asset('uploads/' . $this->logo),
					'thumb'	=>	asset('uploads/thumb_' . $this->logo)
					) : false,
				'banner'			=>	$this->banner != '' ? array(
					'file'	=>	$this->banner,
					'full'	=>	asset('uploads/' . $this->banner),
					'thumb'	=>	asset('uploads/thumb_' . $this->banner)
					) : false,
				'updated_at' => $this->updated_at,
				'permalink'		=>	route('startup.permalink', array(Str::slug(strtolower($this->country->name)), $this->category->slug(), $this->id, $this->slug()))
			);
	}

	public function permalink()
	{
		return route('startup.permalink', array(Str::slug(strtolower($this->country->name)), $this->category->slug(), $this->id, $this->slug()));
	}

	/**
	 * @param $params array
	 * @since 0.1
	 */
	public function routeParams($params = array())
	{
		return array_merge( array( 'id' => $this->id, 'name' => $this->slug() ), $params );
	}

}