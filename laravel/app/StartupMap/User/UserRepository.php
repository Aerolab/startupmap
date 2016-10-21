<?php namespace StartupMap\User;

/**
 * @package StartupMap
 * @version 0.2
 * @author Mauro Casas
 */
class UserRepository implements UserInterface {

	protected $validators;

	public function __construct(array $validators = array()){
		$this->validators = $validators;
	}

	public function all($orderBy = 'id', $order = 'asc')
	{
		return \User::orderBy($orderBy, $order)->get();
	}

	public function find($value, $field = 'id')
	{
		return \User::where($field, $value)->first();
	}

	public function findBy($args = array())
	{
		$users = \User::orderBy('id', 'asc');

		foreach($args as $field => $value)
			$users->where($field, $value);

		return $users->get();
	}

	public function create($input, $generatePassword = false, $sendValidation = true, $forceLogin = false)
	{
		if($generatePassword)
			$input['password'] = str_random(6);

		$this->validators['create']->run($input);

		$user = \User::create(array(
			'email'		=>	$input['email'],
			'password'	=>	$input['password'],
			'admin'		=>	'n'
			));

		$user->profile()->save(new \Profile(array(
			'name'	=>	$input['name'],
			'last_name'	=>	$input['last_name']
			)));

		if($forceLogin)
			\Auth::loginUsingId($user->id);

		// TODO SEND PASSWORD

		if($sendValidation)
		{
			\Mail::send('emails.account_validation', array('userKey' => $user->key, 'name' => $user->profile->name), function($message) use($user){
				$message->to($user->email, $user->profile->name)
						->subject('Validate your StartupMap account');
			});
		}
		else
			$user->validate();

		\Slack::send('*' . $user()->profile->full_name() . '* acaba de registrarse!');

		return $user;
	}

	public function update(\User $user, $input)
	{
		$this->validators['update']->run($input);
		
		$user->profile->update(array(
			'name'			=>	$input['name'],
			'last_name'		=>	$input['last_name']
			));

		if($input['send_password'] == 'y')
		{
			$user->setRememberToken(str_random(32));
			$user->save();

			\Mail::send('emails.reset_password', array(
				'name' => $user->profile->name, 
				'token' => $user->getRememberToken()
				), function($message) use($user){
				$message->to($user->email, $user->profile->full_name())
						->subject('Recupera tu cuenta en StartupMap');
			});
		}

		return $user;
	}

	public function delete(\User $user)
	{
		$user->delete();

		return true;
	}

}