<?php namespace StartupMap\Providers;
 
use Illuminate\Support\ServiceProvider;
 
class UserProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('StartupMap\User\UserInterface', function(){
			return new \StartupMap\User\UserRepository(array(
				'create' => $this->app->make('StartupMap\User\Validation\Create'),
				'update' => $this->app->make('StartupMap\User\Validation\Update')
				));
		});
	}

}