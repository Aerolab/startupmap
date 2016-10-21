<?php

use App\Forms\UserForm;
use App\Forms\ResetForm;
use App\Forms\RecoverPasswordForm;

/**
 * @package StartupMap
 * @version 1.0
 */
class UserController extends Controller {
	
	protected $form;

	public function __construct(UserForm $form)
	{
		$this->form = $form;
	}

	/**
	 * @param $key string
	 * @since 0.1
	 */
	public function validate($key)
	{
		if( ! $user = User::where('key', $key)->first())
			return Redirect::route('root');

		$user->validate();

		return Redirect::route('root')
						->with('user_validated', true);
	}

	/**
	 * @since 0.1
	 */
	public function api_store()
	{
		try
		{
			$this->form->validate(Input::all());

			$user = new User([
				'email'		=>	Input::get('email'),
				'password'	=>	Input::get('password'),
				'admin'		=>	'n'
				]);

			$user->save();

			$user->profile()->save(new Profile(array(
				'name'	=>	Input::get('name'),
				'last_name'	=>	Input::get('last_name')
				)));

			Auth::loginUsingId($user->id);

			Mail::send('emails.account_validation', array('userKey' => $user->key, 'name' => $user->profile->name), function($message) use($user){
				$message->to($user->email, $user->profile->name)
						->subject('Validate your StartupMap account');
			});

			\Slack::send('*' . $user()->profile->full_name() . '* acaba de registrarse!');

			return Response::json(array(
				'status'	=>	'success',
				'user'		=>	$user->toArray()
				));
		}
		catch(App\Forms\FormValidationException $e)
		{
			return Response::json(array(
				'status'	=>	'error',
				'errors'	=>	$e->getErrors()
				));
		}
	}

}