<?php

use App\Forms\Login;

/** 
 * @package StartupsMap
 * @version 0.1
 */
class SessionController extends Controller 
{

	// -----------------------------------------------------------------------

	protected $loginForm;

	public function __construct(Login $loginForm)
	{
		$this->loginForm = $loginForm;
	}

	// -----------------------------------------------------------------------

	/**
	 * @since 0.1
	 */
	public function create()
	{
		try 
		{
			// Validate
			$this->loginForm->validate(Input::all());

			// Try to login
			if( ! Auth::attempt([
				'email'		=>	Input::get('email'),
				'password'	=>	Input::get('password')
				]))
				return Request::ajax() ? Response::json(array(
					'status'	=>	'error',
					'errors'	=>	array(
						'email' => array('La combinaci&oacute;n no parece ser correcta..')
						)
					)) : Redirect::route('root')
								->with('error', 'La combinaci&oacute;n no parece ser correcta..');

			// All good.
			return Request::ajax() ? Response::json(array(
				'status'	=>	'success',
				'user'		=>	Auth::user()->toArray()
				)) : Redirect::route('root');
		}
		catch(App\Forms\FormValidationException $e)
		{
			return Request::ajax() ? Response::json(array(
				'status'	=>	'error',
				'errors'	=>	$e->getErrors()
				)) : Redirect::route('root')
								->withErrors($e->getErrors());
		}
	}

	// -----------------------------------------------------------------------

	/**
	 * @since 0.1
	 */
	public function destroy()
	{
		Auth::logout();

		return Request::ajax() ? Response::json(array(
			'status'	=>	'success'
			)) : Redirect::route('root');
	}

	// -----------------------------------------------------------------------

	/**
	 * @since 	0.1
	 */
	public function oauth_linkedin()
	{
		// Try to fetch the code and open a LI service
		$code = Input::get('code');
		$linkedIn = OAuth::consumer('Linkedin');

		// If no code, redirect
		if(empty($code))
		{
			return Request::ajax() ? Response::json(array(
				'status'	=>	'redirect',
				'redirect'	=>	(string) $linkedIn->getAuthorizationUri(array( 
					'state' 		=>	str_random(25),
					'redirect_uri'	=>	route('api.login.linkedin')
					))
				)) : Redirect::to((string) $linkedIn->getAuthorizationUri(array( 
					'state' 		=>	str_random(25),
					'redirect_uri'	=>	route('api.login.linkedin')
					)));
		}

		// Fetch the token
		$token = $linkedIn->requestAccessToken($code);

		// Grab the profile & email
		$profile = json_decode($linkedIn->request('/people/~:(first-name,last-name,headline,email-address,picture-url)?format=json'), true);

		// Try to find the user
		$user = User::where('email', $profile['emailAddress'])->first();

		// If not user was found, a new one is created with its profile
		$isNewUser = false;
		if( ! $user)
		{
			$user = new User([
				'email' 			=> $profile['emailAddress'],
				'password' 			=> str_random(10),
				'ln_access_token' 	=> $token->getAccessToken(),
				'admin' 			=> 'n'
				]);

			$user->save();

			$user->profile()->save(new Profile([
				'name' 		=> $profile['firstName'],
				'last_name' => $profile['lastName'],
				'picture' 	=> $profile['pictureUrl']
				]));

			Slack::send('*' . $profile['firstName'] . ' ' . $profile['lastName'] . '* acaba de registrarse con _LinkedIn_!');

			$isNewUser = true;
		} 
		else // Else, we update the token
		{
			$user->ln_access_token = $token->getAccessToken();
			$user->profile->picture =  $profile['pictureUrl'];
			$user->profile->save();
			$user->save();
			$user->validate();
		}

		// Login the account
		Auth::loginUsingId($user->id);

		// Gtfo.
		return Redirect::route('root')
					->with('welcomeUser', true)
					->with('isNewUserLinkedin', $isNewUser);
	}

	// -----------------------------------------------------------------------


}
