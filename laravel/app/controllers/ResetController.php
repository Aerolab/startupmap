<?php

use App\Forms\ResetForm;
use App\Forms\RecoverPasswordForm;

class ResetController extends Controller {

	protected $resetForm, $recoverForm;

	public function __construct(ResetForm $resetForm,
								RecoverPasswordForm $recoverForm)
	{
		$this->resetForm = $resetForm;
		$this->recoverForm = $recoverForm;
	}

	public function edit($token)
	{
		return View::make('reset.form')
					->with('token', $token);
	}

	public function update($token)
	{
		try
		{
			$this->recoverForm->run(Input::all());

			$user = User::where('remember_token', $token)->first();
			$user->password = Hash::make(Input::get('password'));
			$user->remember_token = '';
			$user->save();

			Auth::loginUsingId($user->id);

			return Redirect::route('root')
							->with('message', 'Tu contrase&ntilde;a fue actualizada correctamente.');
		}
		catch(App\Forms\FormValidationException $e)
		{
			return Redirect::back()
							->withInput()
							->withErrors($e->getErrors());
		}
	}

	public function api_reset_password()
	{
		try
		{
			$this->resetForm->run(Input::all());

			if( ! $user = User::where('email', Input::get('email'))->first())
				return Response::json(array(
					'status'	=>	'error',
					'errors'	=>	array(
						'email'	=>	'El e-mail no esta vinculado a ninguna cuenta.'
						)
					));

			$user->setRememberToken(str_random(32));
			$user->save();

			Mail::send('emails.reset_password', array('name' => $user->profile->name, 'token' => $user->getRememberToken()), function($message) use($user){
				$message->to($user->email, $user->profile->name)
						->subject('Recupera tu cuenta en StartupMap');
			});

			return Response::json(array(
				'status'	=>	'success',
				'message'	=>	'Un e-mail ha sido enviado a tu casilla. Sigue los pasos para poder recuperar tu cuenta.'
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