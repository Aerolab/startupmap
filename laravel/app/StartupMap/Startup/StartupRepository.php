<?php namespace StartupMap\Startup;

/**
 * @package StartupMap
 * @version 0.2
 * @author Mauro Casas
 */
class StartupRepository implements StartupInterface {

	protected $validators;

	public function __construct(array $validators = array()){
		$this->validators = $validators;
	}

	public function all($array = false, $orderBy = 'id', $order = 'asc')
	{
		if( ! $array)
			return \Startup::orderBy($orderBy, $order)->get();
		else
		{
			$startups = [];

			foreach(\Startup::get() as $startup)
				$startups[] = $startup->toArray();

			return $startups;
		}
	}

	public function find($value, $field = 'id')
	{
		return \Startup::where($field, $value)->first();
	}

	public function findBy($args = array())
	{
		$startups = \Startup::orderBy('id', 'asc');

		foreach($args as $field => $value)
			$startups->where($field, $value);

		return $startups->get();
	}

	public function create($input)
	{
		$this->validators['create']->run($input);

		$startup = \Startup::create(array(
			'name'			=>	$input['name'],
			'slogan'		=>	$input['slogan'],
			'description'	=>	$input['description'],
			'logo'			=>	$input['logo'],
			'banner'		=>	$input['banner'],
			'address'		=>	$input['address'],
			'city'			=>	$input['city'],
			'country_id'	=>	$input['country'],
			'website'		=>	$input['website'],
			'facebook'		=>	$input['facebook'],
			'twitter'		=>	$input['twitter'],
			'linkedin'		=>	$input['linkedin'],
			'crunchbase'	=>	$input['crunchbase'],
			'angelist'		=>	$input['angelist'],
			'dribbble'		=>	$input['dribbble'],
			'foursquare'	=>	$input['foursquare'],
			'google_plus'	=>	$input['google_plus'],
			'youtube'		=>	$input['youtube'],
			'category_id'	=>	$input['category'],
			'tags'			=>	isset($input['tags']) && is_array($input['tags']) ? implode(',', $input['tags']) : '',
			'lat'			=>	$input['lat'],
			'lon'			=>	$input['lon'],
			'child_of'		=>	$input['parent'],
			'user_id'		=>	$input['user_id'],
			'approved'		=>	$input['approved']
			));

		$twitterURL = '';

		if($input['twitter'] != '')
			$twitterURL = '@' . str_replace(array('https://twitter.com/', 'http://twitter.com'), '', $input['twitter']);

		\Slack::send('*<' . $startup->permalink() . '|' . $startup->name . '>* se sumo al mapa desde _' . $startup->country->name . '_ (' . $startup->permalink() . ')');
		\Twitter::postTweet(array('status' => $startup->name . ($twitterURL != '' ? ' @' . $twitterURL : '') . ' se sumo al mapa desde ' . $startup->country->name . ' ' . $startup->permalink() . ' #StartupMap', 'format' => 'json'));

		return $startup;
	}

	public function update(\Startup $startup, $input)
	{
		$this->validators['update']->run($input);
		
		$startup->update(array(
			'name'			=>	$input['name'],
			'slogan'		=>	$input['slogan'],
			'description'	=>	$input['description'],
			'logo'			=>	$input['logo'],
			'banner'		=>	$input['banner'],
			'address'		=>	$input['address'],
			'city'			=>	$input['city'],
			'country_id'	=>	$input['country'],
			'website'		=>	$input['website'],
			'facebook'		=>	$input['facebook'],
			'twitter'		=>	$input['twitter'],
			'linkedin'		=>	$input['linkedin'],
			'crunchbase'	=>	$input['crunchbase'],
			'angelist'		=>	$input['angelist'],
			'dribbble'		=>	$input['dribbble'],
			'foursquare'	=>	$input['foursquare'],
			'google_plus'	=>	$input['google_plus'],
			'youtube'		=>	$input['youtube'],
			'category_id'	=>	$input['category'],
			'tags'			=>	isset($input['tags']) && is_array($input['tags']) ? implode(',', $input['tags']) : '',
			'lat'			=>	$input['lat'],
			'lon'			=>	$input['lon'],
			'child_of'		=>	$input['parent'],
			'user_id'		=>	$input['user_id'],
			'approved'		=>	$input['approved']
			));

		return $startup;
	}

	public function delete(\Startup $startup)
	{
		$startup->delete();

		return true;
	}

	public function claim($startupID, $input)
	{
		if( ! $startup = $this->find($startupID))
			return false;

		$input['startup_id'] = $startupID;

		$this->validators['claim']->run($input);

		$claim = $startup->claims()->save(new \Claim(array(
			'note'	=>	! isset($input['note']) ? '' : $input['note']
			)));

		$acceptLink = '<' . route('claim.slack.accept', array( 'claim' => $claim->id)) . '|Aceptar>';
		$denyLink = '<' . route('claim.slack.deny', array( 'claim' => $claim->id)) . '|Denegar>';

		\Slack::send('*' . \Auth::user()->profile->full_name() . '* ' . (( ! isset($input['note']) || $input['note'] == '') ? '' : '(' . $input['note'] . ')' ) . ' quiere ser listado como founder de *<' . $startup->permalink() . '|' . $startup->name . '>* => ' . $acceptLink . ' / ' . $denyLink);

		return true;
	}

	public function map($input = array())
	{
		$startups = \Startup::where('country_id', $input['country']);

		$bannedCats = array();

		foreach(\Category::where('visible', 'n')->get() as $category)
			$bannedCats[] = $category->id;

		if(array_key_exists('categories', $input) && count($input['categories']) != 0)
			$startups->whereIn('category_id', $input['categories']);

		if(array_key_exists('text', $input))
			$startups->where(function($query) use($input){
				$query->where('name', 'like', '%' . $input['text'] . '%')
						->orWhere('slogan', 'like', '%' . $input['text'] . '%')
						->orWhere('description', 'like', '%' . $input['text'] . '%');
			});

		if(count($bannedCats) != 0)
			$startups->whereNotIn('category_id', $bannedCats);

		$startups->where('approved', 'y'); //Only approved startups

		$startupsArray = array();

		$startups->orderBy('name', 'asc');

		foreach($startups->get() as $startup)
			$startupsArray[] = $startup->toArray();

		return $startupsArray;
	}

	public function add_member(\Startup $startup, $input)
	{
		$this->validators['add_member']->run($input);

		// try to find the user, otherwise send invite.
		// This should also have a table where an event
		// is triggered after registration and user is
		// automatically added to the startup team.
		if( ! $user = \User::where('email', $input['email'])->first())
			dd('User not found. Send inv. email');

		// Look up the user in the team
		if($startup->team()->where('user_id', $user->id)->first())
			dd('User is already a team member');

		// Try to find the role, otherwise create it
		if( ! $role = \Startup_role::where('name', $input['role'])->first())
			$role = \Startup_role::create(array(
				'name' => $input['role']
				));

		// Create the new member
		$startup->team()->save(new \Startup_member(array(
			'user_id' => $user->id,
			'role_id' => $role->id,
			'is_admin' => $input['admin']
			)));

		// Notify the user he's been added to the team.

		return true;
	}

	public function remove_member(\Startup $startup)
	{

	}

}