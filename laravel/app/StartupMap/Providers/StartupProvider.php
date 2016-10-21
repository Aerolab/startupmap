<?php namespace StartupMap\Providers;
 
use Illuminate\Support\ServiceProvider;
 
class StartupProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('StartupMap\Startup\StartupInterface', function(){
			return new \StartupMap\Startup\StartupRepository(array(
				'create' => $this->app->make('StartupMap\Startup\Validation\Create'),
				'update' => $this->app->make('StartupMap\Startup\Validation\Update'),
				'claim' => $this->app->make('StartupMap\Startup\Validation\Claim'),
				'add_member' => $this->app->make('StartupMap\Startup\Validation\AddMember')
				));
		});
	}

}